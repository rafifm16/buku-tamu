-- Buat Database
CREATE DATABASE IF NOT EXISTS db_bukutamu;
USE db_bukutamu;

-- Buat Tabel buku_tamu
CREATE TABLE IF NOT EXISTS buku_tamu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    instansi VARCHAR(100) NOT NULL,
    tujuan TEXT NOT NULL,
    tanggal DATE NOT NULL,
    waktu TIME NOT NULL
);

-- Contoh data dummy (opsional)
INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) VALUES
('Rafi', 'Dinas Pendidikan Kota', 'Koordinasi program beasiswa', '2026-06-13', '09:00:00'),
('Fadhil', 'SMK Negeri 1 Cimahi', 'Konsultasi kurikulum merdeka', '2026-06-13', '10:30:00'),
('Mubarok', 'Komite Sekolah', 'Rapat persiapan acara kelulusan', '2026-06-13', '13:00:00');
