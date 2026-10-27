<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. SEED TABLE: USERS
        DB::table('users')->insert([
            [
                'id_user' => 1,
                'identitas' => '19850101201001',
                'nama_lengkap' => 'Budi Santoso (Admin Sarpras)',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'unit_organisasi' => 'Bagian Sarana & Prasarana',
                'is_banned' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 2,
                'identitas' => '19900202201502',
                'nama_lengkap' => 'Siti Rahma (Petugas Gudang)',
                'password' => Hash::make('password'),
                'role' => 'Petugas',
                'unit_organisasi' => 'Unit Logistik & Inventaris',
                'is_banned' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 3,
                'identitas' => '22410100002',
                'nama_lengkap' => 'Fredriex Pramana Putra',
                'password' => Hash::make('password'),
                'role' => 'Peminjam',
                'unit_organisasi' => 'S1 Sistem Informasi',
                'is_banned' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 4,
                'identitas' => '0712038501',
                'nama_lengkap' => 'Dr. Endra (Dosen)',
                'password' => Hash::make('password'),
                'role' => 'Peminjam',
                'unit_organisasi' => 'S1 Sistem Informasi',
                'is_banned' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 5,
                'identitas' => '19750303200003',
                'nama_lengkap' => 'Prof. Handoko (Pimpinan)',
                'password' => Hash::make('password'),
                'role' => 'Pimpinan',
                'unit_organisasi' => 'Rektorat',
                'is_banned' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 2. SEED TABLE: ASET
        DB::table('aset')->insert([
            [
                'id_aset' => 1,
                'kode_aset' => 'AST-FAS-001',
                'nama_aset' => 'Ruang Kelas 401 (Lantai 4)',
                'kategori' => 'Fasilitas',
                'kondisi_saat_ini' => 'Baik',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_aset' => 2,
                'kode_aset' => 'AST-FAS-002',
                'nama_aset' => 'GOR Utama Universitas Dinamika',
                'kategori' => 'Fasilitas',
                'kondisi_saat_ini' => 'Baik',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_aset' => 3,
                'kode_aset' => 'AST-INV-001',
                'nama_aset' => 'Proyektor Epson EB-X400',
                'kategori' => 'Barang',
                'kondisi_saat_ini' => 'Baik',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_aset' => 4,
                'kode_aset' => 'AST-INV-002',
                'nama_aset' => 'Kamera Sony Alpha A7 III',
                'kategori' => 'Barang',
                'kondisi_saat_ini' => 'Baik',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_aset' => 5,
                'kode_aset' => 'AST-INV-003',
                'nama_aset' => 'Sound System Portable Wireless',
                'kategori' => 'Barang',
                'kondisi_saat_ini' => 'Rusak Ringan',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 3. SEED TABLE: PEMINJAMAN
        DB::table('peminjaman')->insert([
            [
                'id_peminjaman' => 1,
                'id_user' => 3,
                'id_aset' => 4,
                'waktu_pengajuan' => Carbon::now()->subDays(2),
                'waktu_mulai' => Carbon::now()->subDay(),
                'waktu_selesai' => Carbon::now()->addDay(),
                'tujuan_penggunaan' => 'Dokumentasi Kegiatan Himpunan Mahasiswa',
                'status_pengajuan' => 'Dipinjam',
                'batas_sla_admin' => Carbon::now()->subDay(),
                'id_admin_approval' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_peminjaman' => 2,
                'id_user' => 4,
                'id_aset' => 2,
                'waktu_pengajuan' => Carbon::now(),
                'waktu_mulai' => Carbon::now()->addDays(2),
                'waktu_selesai' => Carbon::now()->addDays(3),
                'tujuan_penggunaan' => 'Kuliah Tamu & Seminar Teknologi',
                'status_pengajuan' => 'Menunggu',
                'batas_sla_admin' => Carbon::now()->addHours(24),
                'id_admin_approval' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_peminjaman' => 3,
                'id_user' => 3,
                'id_aset' => 3,
                'waktu_pengajuan' => Carbon::now()->subDays(10),
                'waktu_mulai' => Carbon::now()->subDays(9),
                'waktu_selesai' => Carbon::now()->subDays(8),
                'tujuan_penggunaan' => 'Presentasi Proyek Sistem Informasi',
                'status_pengajuan' => 'Selesai',
                'batas_sla_admin' => Carbon::now()->subDays(9),
                'id_admin_approval' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 4. SEED TABLE: INSPEKSI_ASET
        DB::table('inspeksi_aset')->insert([
            [
                'id_inspeksi' => 1,
                'id_peminjaman' => 1,
                'waktu_serah' => Carbon::now()->subDay(),
                'id_petugas_serah' => 2,
                'kondisi_baseline' => 'Baik',
                'foto_baseline_url' => 'inspeksi/baseline/sample_baseline_a7iii.jpg',
                'waktu_kembali' => null,
                'id_petugas_kembali' => null,
                'kondisi_akhir' => null,
                'foto_akhir_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_inspeksi' => 2,
                'id_peminjaman' => 3,
                'waktu_serah' => Carbon::now()->subDays(9),
                'id_petugas_serah' => 2,
                'kondisi_baseline' => 'Baik',
                'foto_baseline_url' => 'inspeksi/baseline/sample_baseline_epson.jpg',
                'waktu_kembali' => Carbon::now()->subDays(7),
                'id_petugas_kembali' => 2,
                'kondisi_akhir' => 'Rusak Ringan',
                'foto_akhir_url' => 'inspeksi/akhir/sample_akhir_epson.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 5. SEED TABLE: PELANGGARAN
        DB::table('pelanggaran')->insert([
            [
                'id_pelanggaran' => 1,
                'id_peminjaman' => 3,
                'id_user' => 3,
                'jenis_pelanggaran' => 'Kombinasi',
                'keterangan' => 'Terlambat mengembalikan selama 1 hari. Kondisi fisik berubah dari Baik menjadi Rusak Ringan.',
                'status_keuangan' => 'Terkirim (API)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}