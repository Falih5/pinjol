<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use App\Models\InspeksiAset;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PetugasController extends Controller
{
    // Dashboard Petugas: Daftar Antrean Serah Terima & Pengembalian
    public function index()
    {
        // Antrean Barang Siap Diserahkan (Status: Disetujui)
        $siapSerah = Peminjaman::with(['user', 'aset'])
            ->where('status_pengajuan', 'Disetujui')
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        // Antrean Barang Siap Dikembalikan (Status: Dipinjam)
        $siapKembali = Peminjaman::with(['user', 'aset', 'inspeksi'])
            ->where('status_pengajuan', 'Dipinjam')
            ->orderBy('waktu_selesai', 'asc')
            ->get();

        return view('petugas.dashboard', compact('siapSerah', 'siapKembali'));
    }

    // Form Serah Terima (Baseline Condition)
    public function serahTerimaForm($id)
    {
        $peminjaman = Peminjaman::with(['user', 'aset'])->findOrFail($id);
        return view('petugas.serah_terima', compact('peminjaman'));
    }

    // Proses Simpan Serah Terima
    public function processSerahTerima(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'kondisi_baseline' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'foto_baseline' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload Foto Baseline
        $path = $request->file('foto_baseline')->store('inspeksi/baseline', 'public');

        // Simpan Data Inspeksi Initial
        InspeksiAset::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'waktu_serah' => Carbon::now(),
            'id_petugas_serah' => Auth::user()->id_user,
            'kondisi_baseline' => $request->kondisi_baseline,
            'foto_baseline_url' => $path,
        ]);

        // Update Status Peminjaman menjadi 'Dipinjam'
        $peminjaman->update(['status_pengajuan' => 'Dipinjam']);

        return redirect()->route('petugas.dashboard')->with('success', 'Proses serah terima berhasil! Status barang kini "Dipinjam".');
    }

    // Form Pengembalian (Komparasi Akhir)
    public function pengembalianForm($id)
    {
        $peminjaman = Peminjaman::with(['user', 'aset', 'inspeksi'])->findOrFail($id);
        return view('petugas.pengembalian', compact('peminjaman'));
    }

    // Proses Simpan Pengembalian & Otomatisasi Pelanggaran
    public function processPengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::with(['inspeksi', 'aset'])->findOrFail($id);
        $inspeksi = $peminjaman->inspeksi;

        $request->validate([
            'kondisi_akhir' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'foto_akhir' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $waktuSekarang = Carbon::now();
        $path = $request->file('foto_akhir')->store('inspeksi/akhir', 'public');

        // Update Log Inspeksi Akhir
        $inspeksi->update([
            'waktu_kembali' => $waktuSekarang,
            'id_petugas_kembali' => Auth::user()->id_user,
            'kondisi_akhir' => $request->kondisi_akhir,
            'foto_akhir_url' => $path,
        ]);

        // Update Kondisi Terkini pada Master Data Aset
        $peminjaman->aset->update(['kondisi_saat_ini' => $request->kondisi_akhir]);

        // Logika Deteksi Pelanggaran Otomatis (Terlambat & Kerusakan)
        $isTerlambat = $waktuSekarang->greaterThan($peminjaman->waktu_selesai);
        $isRusak = ($inspeksi->kondisi_baseline === 'Baik' && $request->kondisi_akhir !== 'Baik');

        if ($isTerlambat || $isRusak) {
            $jenis = 'Keterlambatan';
            $keteranganArr = [];

            if ($isTerlambat) {
                $selisih = $waktuSekarang->diffForHumans($peminjaman->waktu_selesai, true);
                $keteranganArr[] = "Terlambat mengembalikan selama {$selisih}.";
            }

            if ($isRusak) {
                $jenis = $isTerlambat ? 'Kombinasi' : 'Kerusakan';
                $keteranganArr[] = "Kondisi fisik berubah dari {$inspeksi->kondisi_baseline} menjadi {$request->kondisi_akhir}.";
            }

            // Insert Record Pelanggaran ke Database
            Pelanggaran::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_user' => $peminjaman->id_user,
                'jenis_pelanggaran' => $jenis,
                'keterangan' => implode(' ', $keteranganArr),
                'status_keuangan' => 'Terkirim (API)',
            ]);
        }

        // Update Status Transaksi Menjadi Selesai
        $peminjaman->update(['status_pengajuan' => 'Selesai']);

        return redirect()->route('petugas.dashboard')->with('success', 'Pengembalian barang berhasil dikonfirmasi dan diproses.');
    }
}