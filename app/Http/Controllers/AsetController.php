<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    // 1. Tampilkan Daftar Aset (Index)
    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        $status = $request->get('status');

        $asets = Aset::when($kategori, function ($query) use ($kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                return $query->where('status_aktif', $status);
            })
            ->orderBy('id_aset', 'desc')
            ->get();

        return view('admin.aset.index', compact('asets'));
    }

    // 2. Form Tambah Aset Baru
    public function create()
    {
        return view('admin.aset.create');
    }

    // 3. Simpan Aset Baru (Store)
    public function store(Request $request)
    {
        $request->validate([
            'kode_aset' => 'required|string|unique:aset,kode_aset|max:50',
            'nama_aset' => 'required|string|max:100',
            'kategori' => 'required|in:Fasilitas,Barang',
            'kondisi_saat_ini' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        Aset::create([
            'kode_aset' => $request->kode_aset,
            'nama_aset' => $request->nama_aset,
            'kategori' => $request->kategori,
            'kondisi_saat_ini' => $request->kondisi_saat_ini,
            'status_aktif' => 1,
        ]);

        return redirect()->route('admin.aset.index')->with('success', 'Aset baru berhasil ditambahkan.');
    }

    // 4. Form Edit Aset
    public function edit($id)
    {
        $aset = Aset::findOrFail($id);
        return view('admin.aset.edit', compact('aset'));
    }

    // 5. Update Data Aset
    public function update(Request $request, $id)
    {
        $aset = Aset::findOrFail($id);

        $request->validate([
            'kode_aset' => 'required|string|max:50|unique:aset,kode_aset,' . $aset->id_aset . ',id_aset',
            'nama_aset' => 'required|string|max:100',
            'kategori' => 'required|in:Fasilitas,Barang',
            'kondisi_saat_ini' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status_aktif' => 'required|in:0,1',
        ]);

        $aset->update([
            'kode_aset' => $request->kode_aset,
            'nama_aset' => $request->nama_aset,
            'kategori' => $request->kategori,
            'kondisi_saat_ini' => $request->kondisi_saat_ini,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()->route('admin.aset.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    // 6. Nonaktifkan / Soft Delete Aset (KF-01-03)
    public function toggleStatus($id)
    {
        $aset = Aset::findOrFail($id);
        
        // Cek apakah aset pernah digunakan pada transaksi peminjaman
        $adaTransaksi = Peminjaman::where('id_aset', $aset->id_aset)->exists();

        // Jika pernah dipakai transaksi, paksa ubah status_aktif menjadi 0 (Soft Delete/Disable)
        if ($adaTransaksi) {
            $statusBaru = $aset->status_aktif == 1 ? 0 : 1;
            $aset->update(['status_aktif' => $statusBaru]);

            $pesan = $statusBaru == 0 ? 'Aset dinonaktifkan (tidak dihapus permanen karena memiliki riwayat transaksi).' : 'Aset berhasil diaktifkan kembali.';
            return back()->with('success', $pesan);
        }

        // Jika belum pernah digunakan, boleh di-hard delete
        $aset->delete();
        return back()->with('success', 'Aset berhasil dihapus secara permanen.');
    }
}