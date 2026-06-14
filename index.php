<?php
require_once 'koneksi.php';

$pesan = '';
$tipe_pesan = '';

// Proses Submit Form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $instansi = mysqli_real_escape_string($koneksi, trim($_POST['instansi']));
    $tujuan   = mysqli_real_escape_string($koneksi, trim($_POST['tujuan']));
    $tanggal  = date('Y-m-d');
    $waktu    = date('H:i:s');

    if (!empty($nama) && !empty($instansi) && !empty($tujuan)) {
        $sql = "INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) 
                VALUES ('$nama', '$instansi', '$tujuan', '$tanggal', '$waktu')";

        if (mysqli_query($koneksi, $sql)) {
            $pesan = 'Data tamu berhasil disimpan! Selamat datang, <strong>' . htmlspecialchars($nama) . '</strong>.';
            $tipe_pesan = 'success';
        } else {
            $pesan = 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.';
            $tipe_pesan = 'danger';
        }
    } else {
        $pesan = 'Semua field wajib diisi!';
        $tipe_pesan = 'warning';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sage: #7a9e7e;
            --sage-dark: #5a7d5e;
            --sage-light: #a8c5ac;
            --sage-pale: #e8f0e9;
            --sage-sec: #7da882;
        }
        body { background-color: var(--sage-pale); }
        .navbar { background-color: var(--sage-dark) !important; }
        .navbar-brand, .nav-link { color: #fff !important; }
        .nav-link:hover, .nav-link.active { color: #d4e8d4 !important; }
        .card-header-custom { background-color: var(--sage); color: #fff; }
        .btn-sage { background-color: var(--sage); color: #fff; border: none; }
        .btn-sage:hover { background-color: var(--sage-dark); color: #fff; }
        .badge-sage { background-color: var(--sage); }
        .border-sage { border-color: var(--sage) !important; }
        .text-sage { color: var(--sage-dark); }
        .hero-bg { background-color: var(--sage-dark); }
        .secnav-bg { background-color: var(--sage-sec);}
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link active" href="index.php"><i class="bi bi-pencil-square me-1"></i>Form Tamu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="daftar_tamu.php"><i class="bi bi-people-fill me-1"></i>Daftar Tamu</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Hero -->
<div class="secnav-bg text-white py-4">
    <div class="container text-center">
        <h1 class="fw-bold mb-1"></i>Buku Tamu Digital</h1>
        <p class="mb-0 opacity-75">Selamat datang — silakan isi buku tamu digital kami</p>
    </div>
</div>

<!-- Konten Utama -->
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <!-- Alert Pesan -->
            <?php if ($pesan): ?>
                <div class="alert alert-<?= $tipe_pesan ?> alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-<?= $tipe_pesan === 'success' ? 'check-circle-fill' : ($tipe_pesan === 'danger' ? 'x-circle-fill' : 'exclamation-triangle-fill') ?> me-2"></i>
                    <?= $pesan ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Link ke Daftar Tamu -->
            <div class="card text-center p-2 mb-3">
                <a href="daftar_tamu.php" class="btn btn-sage btn-lg text-decoration-none fw-semibold">
                    </i>Lihat Daftar Tamu yang Telah Hadir
                </a>
            </div>

            <!-- Card Form -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header card-header-custom py-3 rounded-top-3">
                    <h5 class="mb-0 fw-semibold"><i class="bi bi-person-plus-fill me-2"></i>Formulir Tamu</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="index.php">

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-medium text-sage">
                                <i class="bi bi-person-fill me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control border-sage" id="nama" name="nama"
                                placeholder="Masukkan nama lengkap Anda" required
                                value="<?= isset($_POST['nama']) && $tipe_pesan !== 'success' ? htmlspecialchars($_POST['nama']) : '' ?>">
                        </div>

                        <!-- Instansi -->
                        <div class="mb-3">
                            <label for="instansi" class="form-label fw-medium text-sage">
                                <i class="bi bi-building me-1"></i>Instansi / Asal Sekolah <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control border-sage" id="instansi" name="instansi"
                                placeholder="Contoh: Dinas Pendidikan, Universitas X"
                                required
                                value="<?= isset($_POST['instansi']) && $tipe_pesan !== 'success' ? htmlspecialchars($_POST['instansi']) : '' ?>">
                        </div>

                        <!-- Tujuan Kedatangan -->
                        <div class="mb-3">
                            <label for="tujuan" class="form-label fw-medium text-sage">
                                <i class="bi bi-chat-text-fill me-1"></i>Tujuan Kedatangan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control border-sage" id="tujuan" name="tujuan"
                                rows="3" placeholder="Jelaskan tujuan kedatangan Anda..." required><?= isset($_POST['tujuan']) && $tipe_pesan !== 'success' ? htmlspecialchars($_POST['tujuan']) : '' ?></textarea>
                        </div>

                        <!-- Tanggal & Waktu (otomatis) -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-sage">
                                <i class="bi bi-clock-fill me-1"></i>Tanggal & Waktu Kedatangan
                            </label>
                            <input type="text" class="form-control bg-light" id="waktu_display"
                                readonly placeholder="Otomatis tercatat saat submit">
                            <div class="form-text"><i class="bi bi-info-circle me-1"></i>Waktu dicatat otomatis saat formulir dikirim.</div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-sage btn-lg fw-semibold py-2">
                                <i class="bi bi-send-fill me-2"></i>Kirim Data Tamu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Tampilkan waktu real-time di field display
    function updateWaktu() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
        document.getElementById('waktu_display').value = now.toLocaleDateString('id-ID', options);
    }
    updateWaktu();
    setInterval(updateWaktu, 1000);
</script>
</body>
</html>
