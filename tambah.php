<?php
session_start();
// Jika belum login, paksa kembali ke halaman login
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php'; 
// ... (lanjutkan dengan kode logikamu yang lain di bawahnya) 

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $stok_awal = $_POST['stok_awal'];
    $stok_sekarang = $_POST['stok_sekarang'];

    $query = mysqli_query($conn, "INSERT INTO barang (kode_barang, nama_barang, kategori, stok_awal, stok_sekarang) VALUES ('$kode', '$nama', '$kategori', '$stok_awal', '$stok_sekarang')");

    if ($query) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Data - Gudang Komputer Mantap Jaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%); min-height: 100vh; padding-top: 3rem; font-family: 'Segoe UI', sans-serif;}
        .card { border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none; }
        .card-header { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border-radius: 15px 15px 0 0 !important; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Tambah Barang Baru</h5></div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Barang</label>
                            <input type="text" name="kode_barang" class="form-control" placeholder="Contoh: BRG004" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: RAM 8GB DDR4" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Contoh: Komponen" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Stok Awal</label>
                                <input type="number" name="stok_awal" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Stok Sekarang</label>
                                <input type="number" name="stok_sekarang" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" name="simpan" class="btn btn-primary w-100 mb-2">Simpan Data</button>
                        <a href="index.php" class="btn btn-light border w-100">Batal Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>