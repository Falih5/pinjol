<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PimpinanController extends Controller
{
    // Dashboard & Laporan Executive Pimpinan
    public function index(Request $request)
    {
        // Query Dasar Aset & Transaksi
        $kategori = $request->get('kategori');
        $unit = $request->get('unit');

        // 1. Matriks Agregat Utama
        $totalPeminjaman = Peminjaman::where('status_pengajuan', 'Selesai')->count();
        $totalPelanggaran = Pelanggaran::count();
        $totalAsetAktif = Aset::where('status_aktif', 1)->count();
        
        // Persentase Utilisasi (Aset yang pernah dipinjam minimal 1 kali)
        $asetPernahDipinjam = Peminjaman::distinct('id_aset')->count('id_aset');
        $persentaseUtilisasi = $totalAsetAktif > 0 ? round(($asetPernahDipinjam / $totalAsetAktif) * 100, 1) : 0;

        // 2. Laporan Utilisasi Per Aset
        $utilisasiAset = Aset::withCount(['peminjaman' => function ($query) {
                $query->where('status_pengajuan', 'Selesai');
            }])
            ->when($kategori, function ($q) use ($kategori) {
                return $q->where('kategori', $kategori);
            })
            ->get();

        // 3. Laporan Riwayat Pelanggaran
        $daftarPelanggaran = Pelanggaran::with(['peminjaman.aset', 'user'])
            ->when($unit, function ($q) use ($unit) {
                return $q->whereHas('user', function ($userQuery) use ($unit) {
                    $userQuery->where('unit_organisasi', $unit);
                });
            })
            ->orderBy('id_pelanggaran', 'desc')
            ->get();

        return view('pimpinan.dashboard', compact(
            'totalPeminjaman',
            'totalPelanggaran',
            'totalAsetAktif',
            'persentaseUtilisasi',
            'utilisasiAset',
            'daftarPelanggaran'
        ));
    }
}