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
('Budi Santoso', 'Dinas Pendidikan Kota', 'Kunjungan dan koordinasi program belajar', '2024-06-01', '09:00:00'),
('Siti Rahayu', 'Universitas Negeri', 'Observasi metode pembelajaran', '2024-06-02', '10:30:00'),
('Ahmad Fauzi', 'Komite Sekolah', 'Rapat koordinasi tahunan', '2024-06-03', '13:00:00');
