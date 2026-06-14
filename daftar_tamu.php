<?php
require_once 'koneksi.php';

// Fitur Pencarian
$search = '';
$where  = '';

if (isset($_GET['cari']) && !empty(trim($_GET['cari']))) {
    $search = mysqli_real_escape_string($koneksi, trim($_GET['cari']));
    $where  = "WHERE nama LIKE '%$search%' OR instansi LIKE '%$search%'";
}

// Query Data
$sql   = "SELECT * FROM buku_tamu $where ORDER BY tanggal DESC, waktu DESC";
$result = mysqli_query($koneksi, $sql);
$total  = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tamu - Buku Tamu Digital</title>
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
        .table thead { background-color: var(--sage); color: #fff; }
        .table-hover tbody tr:hover { background-color: var(--sage-pale); }
        .no-data-icon { font-size: 4rem; color: var(--sage-light); }
        .secnav-bg { background-color: var(--sage-sec);}
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="bi bi-pencil-square me-1"></i>Form Tamu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="daftar_tamu.php"><i class="bi bi-people-fill me-1"></i>Daftar Tamu</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Hero -->
<div class="secnav-bg text-white py-4">
    <div class="container text-center">
        <h1 class="fw-bold mb-1"></i>Daftar Tamu</h1>
        <p class="mb-0 opacity-75">Rekap seluruh tamu yang telah berkunjung</p>
    </div>
</div>

<!-- Konten Utama -->
<div class="container py-4">

    <!-- Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="display-6 fw-bold text-sage"><?= $total ?></div>
                <small class="text-muted"><?= $search ? 'Hasil Pencarian' : 'Total Tamu' ?></small>
            </div>
        </div>
        <?php
            $today = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM buku_tamu WHERE tanggal = CURDATE()");
            $today_row = mysqli_fetch_assoc($today);
            $bulan = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM buku_tamu WHERE MONTH(tanggal) = MONTH(NOW()) AND YEAR(tanggal) = YEAR(NOW())");
            $bulan_row = mysqli_fetch_assoc($bulan);
        ?>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="display-6 fw-bold text-sage"><?= $today_row['jml'] ?></div>
                <small class="text-muted">Tamu Hari Ini</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="display-6 fw-bold text-sage"><?= $bulan_row['jml'] ?></div>
                <small class="text-muted">Tamu Bulan Ini</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3 h-100 d-flex justify-content-center">
                <div class="fs-5 fw-bold text-sage">
                    <?= date('d M Y') ?>
                </div>
                <small class="text-muted">Tanggal Hari Ini</small>
            </div>
        </div>
    </div>

    <!-- Card Tabel -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header card-header-custom py-3 rounded-top-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-table me-2"></i>Data Tamu</h5>
            <a href="index.php" class="btn btn-light btn-sm fw-medium">
                <i class="bi bi-plus-circle me-1"></i>Tambah Tamu
            </a>
        </div>

        <!-- Form Pencarian -->
        <div class="card-body border-bottom pb-3">
            <form method="GET" action="daftar_tamu.php" class="d-flex gap-2">
                <input type="text" name="cari" class="form-control border-sage"
                    placeholder="Cari nama atau instansi..."
                    value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-sage px-3">
                    <i class="bi bi-search"></i>
                </button>
                <?php if ($search): ?>
                    <a href="daftar_tamu.php" class="btn btn-outline-secondary px-3" title="Reset pencarian">
                        <i class="bi bi-x-lg"></i>
                    </a>
                <?php endif; ?>
            </form>
            <?php if ($search): ?>
                <div class="mt-2 small text-muted">
                    <i class="bi bi-funnel me-1"></i>Menampilkan hasil pencarian untuk: <strong>"<?= htmlspecialchars($search) ?>"</strong>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tabel -->
        <div class="card-body p-0">
            <?php if ($total > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width:50px">#</th>
                                <th><i class="bi bi-person-fill me-1"></i>Nama Lengkap</th>
                                <th><i class="bi bi-building me-1"></i>Instansi</th>
                                <th><i class="bi bi-chat-text me-1"></i>Tujuan Kedatangan</th>
                                <th><i class="bi bi-calendar3 me-1"></i>Tanggal</th>
                                <th><i class="bi bi-clock me-1"></i>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)):
                                $tanggal_fmt = date('d M Y', strtotime($row['tanggal']));
                                $waktu_fmt   = date('H:i', strtotime($row['waktu']));
                                $isToday     = ($row['tanggal'] === date('Y-m-d'));
                            ?>
                            <tr>
                                <td class="ps-3 text-muted"><?= $no++ ?></td>
                                <td class="fw-medium">
                                    <?= htmlspecialchars($row['nama']) ?>
                                    <?php if ($isToday): ?>
                                        <span class="badge badge-sage ms-1" style="background-color:#7a9e7e;font-size:0.65rem">Hari Ini</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['instansi']) ?></td>
                                <td>
                                    <span title="<?= htmlspecialchars($row['tujuan']) ?>">
                                        <?= mb_strlen($row['tujuan']) > 60
                                            ? htmlspecialchars(mb_substr($row['tujuan'], 0, 60)) . '...'
                                            : htmlspecialchars($row['tujuan']) ?>
                                    </span>
                                </td>
                                <td class="text-nowrap"><?= $tanggal_fmt ?></td>
                                <td class="text-nowrap"><?= $waktu_fmt ?> WIB</td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- Kosong / Tidak Ditemukan -->
                <div class="text-center py-5">
                    <div class="no-data-icon mb-3">
                        <i class="bi bi-<?= $search ? 'search' : 'inbox' ?>"></i>
                    </div>
                    <h6 class="text-muted fw-medium">
                        <?= $search ? 'Tidak ada tamu yang cocok dengan pencarian "' . htmlspecialchars($search) . '"' : 'Belum ada data tamu' ?>
                    </h6>
                    <p class="text-muted small">
                        <?= $search ? 'Coba kata kunci yang berbeda.' : 'Data tamu akan muncul di sini setelah formulir diisi.' ?>
                    </p>
                    <?php if ($search): ?>
                        <a href="daftar_tamu.php" class="btn btn-sage btn-sm">Tampilkan Semua Tamu</a>
                    <?php else: ?>
                        <a href="index.php" class="btn btn-sage btn-sm"><i class="bi bi-plus-circle me-1"></i>Isi Form Tamu</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($total > 0): ?>
        <div class="card-footer bg-light text-muted small rounded-bottom-3 py-2">
            <i class="bi bi-info-circle me-1"></i>
            Menampilkan <strong><?= $total ?></strong> data tamu
            <?= $search ? 'untuk pencarian "<strong>' . htmlspecialchars($search) . '</strong>"' : '' ?>.
        </div>
        <?php endif; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
