-- 1. Master Data: USERS
CREATE TABLE users (
    id_user BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    identitas VARCHAR(20) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'Peminjam' NOT NULL,
    unit_organisasi VARCHAR(50),
    is_banned TINYINT(1) DEFAULT 0 NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 2. Master Data: ASET
CREATE TABLE aset (
    id_aset BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_aset VARCHAR(50) UNIQUE NOT NULL,
    nama_aset VARCHAR(100) NOT NULL,
    kategori VARCHAR(20) NOT NULL,
    kondisi_saat_ini VARCHAR(20) NOT NULL,
    status_aktif TINYINT(1) DEFAULT 1 NOT NULL
);

-- 3. Transaksional Utama: PEMINJAMAN
CREATE TABLE peminjaman (
    id_peminjaman BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user BIGINT UNSIGNED NOT NULL,
    id_aset BIGINT UNSIGNED NOT NULL,
    waktu_pengajuan TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    waktu_mulai DATETIME NOT NULL,
    waktu_selesai DATETIME NOT NULL,
    tujuan_penggunaan VARCHAR(255),
    status_pengajuan VARCHAR(20) DEFAULT 'Menunggu' NOT NULL,
    batas_sla_admin DATETIME,
    id_admin_approval BIGINT UNSIGNED,
    CONSTRAINT fk_peminjaman_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    CONSTRAINT fk_peminjaman_aset FOREIGN KEY (id_aset) REFERENCES aset(id_aset) ON DELETE CASCADE,
    CONSTRAINT fk_peminjaman_admin FOREIGN KEY (id_admin_approval) REFERENCES users(id_user) ON DELETE SET NULL
);

-- 4. Log Operasional: INSPEKSI_ASET
CREATE TABLE inspeksi_aset (
    id_inspeksi BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_peminjaman BIGINT UNSIGNED UNIQUE NOT NULL,
    waktu_serah DATETIME,
    id_petugas_serah BIGINT UNSIGNED,
    kondisi_baseline VARCHAR(20),
    foto_baseline_url VARCHAR(255),
    waktu_kembali DATETIME,
    id_petugas_kembali BIGINT UNSIGNED,
    kondisi_akhir VARCHAR(20),
    foto_akhir_url VARCHAR(255),
    CONSTRAINT fk_inspeksi_peminjaman FOREIGN KEY (id_peminjaman) REFERENCES peminjaman(id_peminjaman) ON DELETE CASCADE,
    CONSTRAINT fk_inspeksi_petugas_s FOREIGN KEY (id_petugas_serah) REFERENCES users(id_user) ON DELETE SET NULL,
    CONSTRAINT fk_inspeksi_petugas_k FOREIGN KEY (id_petugas_kembali) REFERENCES users(id_user) ON DELETE SET NULL
);

-- 5. Tindak Lanjut: PELANGGARAN
CREATE TABLE pelanggaran (
    id_pelanggaran BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_peminjaman BIGINT UNSIGNED NOT NULL,
    id_user BIGINT UNSIGNED NOT NULL,
    jenis_pelanggaran VARCHAR(20) NOT NULL,
    keterangan VARCHAR(255),
    status_keuangan VARCHAR(20) DEFAULT 'Belum Dikirim' NOT NULL,
    CONSTRAINT fk_pelanggaran_peminjaman FOREIGN KEY (id_peminjaman) REFERENCES peminjaman(id_peminjaman) ON DELETE CASCADE,
    CONSTRAINT fk_pelanggaran_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);









-- 1. SEED DATA USERS
INSERT INTO users (identitas, nama_lengkap, password, role, unit_organisasi, is_banned, created_at, updated_at) VALUES
('19850101201001', 'Budi Santoso (Admin Sarpras)', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Bagian Sarana & Prasarana', 0, NOW(), NOW()),
('19900202201502', 'Siti Rahma (Petugas Gudang)', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Petugas', 'Unit Logistik & Inventaris', 0, NOW(), NOW()),
('22410100002', 'Fredriex Pramana Putra', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Peminjam', 'S1 Sistem Informasi', 0, NOW(), NOW()),
('0712038501', 'Dr. Endra (Dosen)', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Peminjam', 'S1 Sistem Informasi', 0, NOW(), NOW()),
('19750303200003', 'Prof. Handoko (Pimpinan)', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pimpinan', 'Rektorat', 0, NOW(), NOW());

-- 2. SEED DATA ASET
INSERT INTO aset (kode_aset, nama_aset, kategori, kondisi_saat_ini, status_aktif) VALUES
('AST-FAS-001', 'Ruang Kelas 401 (Lantai 4)', 'Fasilitas', 'Baik', 1),
('AST-FAS-002', 'GOR Utama Universitas Dinamika', 'Fasilitas', 'Baik', 1),
('AST-INV-001', 'Proyektor Epson EB-X400', 'Barang', 'Baik', 1),
('AST-INV-002', 'Kamera Sony Alpha A7 III', 'Barang', 'Baik', 1),
('AST-INV-003', 'Sound System Portable Wireless', 'Barang', 'Rusak Ringan', 1);

-- 3. SEED DATA PEMINJAMAN
-- Transaksi 1: Status Dipinjam (Kamera Sony A7 III oleh Fredriex)
INSERT INTO peminjaman (id_user, id_aset, waktu_pengajuan, waktu_mulai, waktu_selesai, tujuan_penggunaan, status_pengajuan, batas_sla_admin, id_admin_approval) VALUES
(3, 4, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 1 DAY, NOW() + INTERVAL 1 DAY, 'Dokumentasi Kegiatan Himpunan Mahasiswa', 'Dipinjam', NOW() - INTERVAL 1 DAY, 1);

-- Transaksi 2: Status Menunggu Persetujuan (GOR Utama oleh Dr. Endra)
INSERT INTO peminjaman (id_user, id_aset, waktu_pengajuan, waktu_mulai, waktu_selesai, tujuan_penggunaan, status_pengajuan, batas_sla_admin, id_admin_approval) VALUES
(4, 2, NOW(), NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 'Kuliah Tamu & Seminar Teknologi', 'Menunggu', NOW() + INTERVAL 1 DAY, NULL);

-- Transaksi 3: Status Selesai dengan Catatan Pelanggaran (Proyektor Epson)
INSERT INTO peminjaman (id_user, id_aset, waktu_pengajuan, waktu_mulai, waktu_selesai, tujuan_penggunaan, status_pengajuan, batas_sla_admin, id_admin_approval) VALUES
(3, 3, NOW() - INTERVAL 10 DAY, NOW() - INTERVAL 9 DAY, NOW() - INTERVAL 8 DAY, 'Presentasi Proyek Sistem Informasi', 'Selesai', NOW() - INTERVAL 9 DAY, 1);

-- 4. SEED DATA INSPEKSI ASET
-- Log Inspeksi untuk Transaksi 1 (Baru Serah Terima)
INSERT INTO inspeksi_aset (id_peminjaman, waktu_serah, id_petugas_serah, kondisi_baseline, foto_baseline_url, waktu_kembali, id_petugas_kembali, kondisi_akhir, foto_akhir_url) VALUES
(1, NOW() - INTERVAL 1 DAY, 2, 'Baik', 'uploads/inspeksi/baseline_a7iii_01.jpg', NULL, NULL, NULL, NULL);

-- Log Inspeksi untuk Transaksi 3 (Sudah Dikembalikan tapi Keterlambatan/Kerusakan)
INSERT INTO inspeksi_aset (id_peminjaman, waktu_serah, id_petugas_serah, kondisi_baseline, foto_baseline_url, waktu_kembali, id_petugas_kembali, kondisi_akhir, foto_akhir_url) VALUES
(3, NOW() - INTERVAL 9 DAY, 2, 'Baik', 'uploads/inspeksi/baseline_epson_03.jpg', NOW() - INTERVAL 7 DAY, 2, 'Rusak Ringan', 'uploads/inspeksi/akhir_epson_03.jpg');

-- 5. SEED DATA PELANGGARAN
-- Pelanggaran dari Transaksi 3 (Terlambat 1 hari & kabel VGA retak)
INSERT INTO pelanggaran (id_peminjaman, id_user, jenis_pelanggaran, keterangan, status_keuangan) VALUES
(3, 3, 'Kombinasi', 'Pengembalian terlambat 1 hari dan port HDMI fisik kendur.', 'Terkirim (API)');











