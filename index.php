<?php
session_start();
// Jika belum login, paksa kembali ke halaman login
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php'; 
// ... (lanjutkan dengan kode logikamu yang lain di bawahnya) 

// 1. Logika Fitur Pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// 2. Logika Mengambil Data Statistik untuk Ringkasan Widget
$q_stats = mysqli_query($conn, "SELECT COUNT(*) as total_jenis, SUM(stok_sekarang) as total_stok FROM barang");
$r_stats = mysqli_fetch_assoc($q_stats);
$total_jenis = $r_stats['total_jenis'] ?? 0;
$total_stok = $r_stats['total_stok'] ?? 0;

$q_menipis = mysqli_query($conn, "SELECT COUNT(*) as total_menipis FROM barang WHERE stok_sekarang < 10");
$r_menipis = mysqli_fetch_assoc($q_menipis);
$total_menipis = $r_menipis['total_menipis'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warehouse - Professional Monitoring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 2rem;
            padding-bottom: 3rem;
        }
        
        /* Widget & Info Cards */
        .card-stat {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            background: white;
        }
        .card-stat:hover {
            transform: translateY(-3px);
        }
        .icon-shape {
            width: 48px;
            height: 48px;
            background: #e0eafc;
            color: #1e3c72;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Main Card */
        .card-main {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: white;
        }
        .card-header-gradient {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 1.2rem 1.5rem;
            border-bottom: none;
        }
        
        .btn-tambah {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-tambah:hover {
            background-color: white;
            color: #1e3c72;
        }

        /* Table Styling */
        .table th {
            color: #1e3c72;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }
        .table td {
            vertical-align: middle;
            color: #4a5568;
        }
        .badge-status {
            padding: 0.5em 0.8em;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            
            <div class="mb-4 text-center">
                <h3 class="fw-bold" style="color: #1e3c72;">
                    <i class="bi bi-speedometer2 me-2"></i>Data Warehouse Monitoring System
                </h3>
                <p class="text-muted">Manajemen logistik dan pengawasan ketersediaan barang real-time</p>
            </div>

            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card card-stat p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Total Jenis Barang</h6>
                                <h3 class="fw-bold mb-0 text-dark"><?= $total_jenis; ?> <span class="fs-6 text-muted font-normal">Item</span></h3>
                            </div>
                            <div class="icon-shape"><i class="bi bi-box-seam"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card card-stat p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Stok Keseluruhan</h6>
                                <h3 class="fw-bold mb-0 text-dark"><?= number_format($total_stok); ?> <span class="fs-6 text-muted font-normal">Pcs</span></h3>
                            </div>
                            <div class="icon-shape" style="background: #e8f5e9; color: #2e7d32;"><i class="bi bi-boxes"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stat p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Stok Menipis (&lt; 10)</h6>
                                <h3 class="fw-bold mb-0 text-danger"><?= $total_menipis; ?> <span class="fs-6 text-muted font-normal">Item</span></h3>
                            </div>
                            <div class="icon-shape" style="background: #ffebee; color: #c62828;"><i class="bi bi-exclamation-octagon"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-main">
                <div class="card-header-gradient d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h5 class="mb-0 fw-semibold"><i class="bi bi-hdd-rack me-2"></i>Inventory Control Panel</h5>
                    
                    <div class="d-flex gap-2">
                        <form method="GET" action="" class="input-group input-group-sm" style="max-width: 250px;">
                            <input type="text" name="search" class="form-control" placeholder="Cari kode / nama..." value="<?= htmlspecialchars($search); ?>">
                            <button class="btn btn-light text-primary" type="submit"><i class="bi bi-search"></i></button>
                            <?php if($search != ''): ?>
                                <a href="index.php" class="btn btn-secondary btn-sm" title="Reset Pencarian"><i class="bi bi-x-circle"></i></a>
                            <?php endif; ?>
                        </form>
                        <a href="tambah.php" class="btn btn-tambah btn-sm px-3">
                            <i class="bi bi-plus-circle me-1"></i> Tambah
                        </a>
                        <a href="logout.php" class="btn btn-danger btn-sm px-3 shadow-sm border-0" onclick="return confirm('Yakin ingin keluar?');">
    <i class="bi bi-box-arrow-right me-1"></i> Keluar
</a>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center px-4 py-3">No</th>
                                    <th class="py-3">Kode</th>
                                    <th class="py-3">Nama Barang</th>
                                    <th class="py-3">Kategori</th>
                                    <th class="text-center py-3">Stok Awal</th>
                                    <th class="text-center py-3">Stok Terkini</th>
                                    <th class="text-center py-3">Status</th>
                                    <th class="text-center py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                
                                // Query SQL disesuaikan jika user melakukan pencarian
                                if ($search != '') {
                                    $query = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang LIKE '%$search%' OR nama_barang LIKE '%$search%' OR kategori LIKE '%$search%' ORDER BY id DESC");
                                } else {
                                    $query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
                                }
                                
                                if (mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        if ($row['stok_sekarang'] < 10) {
                                            $status = '<span class="badge-status bg-danger-subtle text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Menipis</span>';
                                        } else {
                                            $status = '<span class="badge-status bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Aman</span>';
                                        }
                                ?>
                                <tr>
                                    <td class="text-center px-4 py-3 fw-bold text-muted"><?= $no++; ?></td>
                                    <td class="py-3"><span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1" style="font-size: 0.85rem;"><?= htmlspecialchars($row['kode_barang']); ?></span></td>
                                    <td class="py-3 fw-medium"><?= htmlspecialchars($row['nama_barang']); ?></td>
                                    <td class="py-3 text-secondary"><?= htmlspecialchars($row['kategori']); ?></td>
                                    <td class="text-center py-3 text-muted"><?= htmlspecialchars($row['stok_awal']); ?></td>
                                    <td class="text-center py-3">
                                        <span class="fs-6 fw-bold <?= $row['stok_sekarang'] < 10 ? 'text-danger' : 'text-dark'; ?>">
                                            <?= htmlspecialchars($row['stok_sekarang']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center py-3"><?= $status; ?></td>
                                    <td class="text-center py-3">
                                        <div class="btn-group btn-group-sm">
                                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-outline-warning border-0" title="Edit">
                                                <i class="bi bi-pencil-square fs-6"></i>
                                            </a>
                                            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-outline-danger border-0" onclick="return confirm('Yakin ingin menghapus barang ini?');" title="Hapus">
                                                <i class="bi bi-trash fs-6"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                    } 
                                } else {
                                    echo '<tr><td colspan="8" class="text-center text-muted py-5"><i class="bi bi-search fs-2 d-block mb-2 text-secondary"></i>Barang tidak ditemukan atau data kosong.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>