<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pelanggaran;
class PeminjamController extends Controller
{
    // Halaman Dashboard & Riwayat Pengajuan Peminjam
    public function index()
    {
        $riwayat = Peminjaman::with('aset')
            ->where('id_user', Auth::user()->id_user)
            ->orderBy('waktu_pengajuan', 'desc')
            ->get();

        return view('peminjam.dashboard', compact('riwayat'));
    }

    // Halaman Form Cek Ketersediaan & Pengajuan
    public function create(Request $request)
    {
        $asets = Aset::where('status_aktif', 1)->get();
        $hasilCek = null;

        // Jika pengguna melakukan aksi "Cek Ketersediaan"
        if ($request->has(['id_aset', 'waktu_mulai', 'waktu_selesai'])) {
            $request->validate([
                'id_aset' => 'required|exists:aset,id_aset',
                'waktu_mulai' => 'required|date|after:now',
                'waktu_selesai' => 'required|date|after:waktu_mulai',
            ]);

            // Cek irisan rentang waktu dengan transaksi lain yang aktif
            $isBentrok = Peminjaman::where('id_aset', $request->id_aset)
                ->whereIn('status_pengajuan', ['Menunggu', 'Disetujui', 'Dipinjam'])
                ->where(function ($query) use ($request) {
                    $query->where('waktu_mulai', '<', $request->waktu_selesai)
                          ->where('waktu_selesai', '>', $request->waktu_mulai);
                })
                ->exists();

            $hasilCek = [
                'tersedia' => !$isBentrok,
                'id_aset' => $request->id_aset,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
            ];
        }

        return view('peminjam.create', compact('asets', 'hasilCek'));
    }

    // Proses Simpan Form Pengajuan
    public function store(Request $request)
    {
        // Validasi status blokir peminjam
        if (Auth::user()->is_banned) {
            return back()->with('error', 'Pengajuan ditolak. Akun Anda sedang diblokir akibat riwayat pelanggaran.');
        }

        $request->validate([
            'id_aset' => 'required|exists:aset,id_aset',
            'waktu_mulai' => 'required|date|after:now',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'tujuan_penggunaan' => 'required|string|max:255',
        ]);

        // Re-check ketersediaan sebelum insert (mencegah bentrok jadwal)
        $isBentrok = Peminjaman::where('id_aset', $request->id_aset)
            ->whereIn('status_pengajuan', ['Menunggu', 'Disetujui', 'Dipinjam'])
            ->where(function ($query) use ($request) {
                $query->where('waktu_mulai', '<', $request->waktu_selesai)
                      ->where('waktu_selesai', '>', $request->waktu_mulai);
            })
            ->exists();

        if ($isBentrok) {
            return back()->with('error', 'Maaf, aset tidak tersedia pada slot waktu tersebut karena sudah terpesan.');
        }

        $waktuPengajuan = Carbon::now();
        $batasSlaAdmin = $waktuPengajuan->copy()->addHours(24);

        Peminjaman::create([
            'id_user' => Auth::user()->id_user,
            'id_aset' => $request->id_aset,
            'waktu_pengajuan' => $waktuPengajuan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'tujuan_penggunaan' => $request->tujuan_penggunaan,
            'status_pengajuan' => 'Menunggu',
            'batas_sla_admin' => $batasSlaAdmin,
        ]);

        return redirect()->route('peminjam.dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim! Menunggu verifikasi Admin Sarpras.');
    }

    // 1. Detail Tiket Peminjaman
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['aset', 'user', 'inspeksi'])
            ->where('id_user', Auth::user()->id_user)
            ->findOrFail($id);

        return view('peminjam.show', compact('peminjaman'));
    }

    // 2. Batalkan Pengajuan (Hanya untuk status 'Menunggu')
    public function cancel($id)
    {
        $peminjaman = Peminjaman::where('id_user', Auth::user()->id_user)
            ->where('status_pengajuan', 'Menunggu')
            ->findOrFail($id);

        // Hapus atau ubah status transaksi
        $peminjaman->delete();

        return redirect()->route('peminjam.dashboard')->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }

    // 3. Halaman Riwayat Pelanggaran & Status Denda Pribadi
    public function pelanggaran()
    {
        $pelanggaran = Pelanggaran::with(['peminjaman.aset'])
            ->where('id_user', Auth::user()->id_user)
            ->orderBy('id_pelanggaran', 'desc')
            ->get();

        return view('peminjam.pelanggaran', compact('pelanggaran'));
    }
}
