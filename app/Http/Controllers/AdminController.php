<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Dashboard Admin Sarpras: Menampilkan Statistik & Antrean Approval
    public function index()
    {
        $pengajuanMasuk = Peminjaman::with(['user', 'aset'])
            ->where('status_pengajuan', 'Menunggu')
            ->orderBy('waktu_pengajuan', 'asc')
            ->get();

        $totalPengajuanMenunggu = $pengajuanMasuk->count();
        $totalAsetAktif = Aset::where('status_aktif', 1)->count();
        $totalAsetDipinjam = Peminjaman::where('status_pengajuan', 'Dipinjam')->count();

        return view('admin.dashboard', compact('pengajuanMasuk', 'totalPengajuanMenunggu', 'totalAsetAktif', 'totalAsetDipinjam'));
    }

    // Aksi Approve Pengajuan
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Safety Lock: Cek ulang bentrok dengan transaksi yang sudah terlanjur disetujui/dipinjam
        $isBentrok = Peminjaman::where('id_aset', $peminjaman->id_aset)
            ->where('id_peminjaman', '!=', $peminjaman->id_peminjaman)
            ->whereIn('status_pengajuan', ['Disetujui', 'Dipinjam'])
            ->where(function ($query) use ($peminjaman) {
                $query->where('waktu_mulai', '<', $peminjaman->waktu_selesai)
                      ->where('waktu_selesai', '>', $peminjaman->waktu_mulai);
            })
            ->exists();

        if ($isBentrok) {
            return back()->with('error', 'Gagal menyetujui! Sudah terdapat peminjaman lain yang disetujui pada slot waktu tersebut.');
        }

        $peminjaman->update([
            'status_pengajuan' => 'Disetujui',
            'id_admin_approval' => Auth::user()->id_user,
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil disetujui!');
    }

    // Aksi Reject Pengajuan
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status_pengajuan' => 'Ditolak',
            'id_admin_approval' => Auth::user()->id_user,
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil ditolak.');
    }
}
