<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung arahkan ke index
if (isset($_SESSION['status_login'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {
    // Menangkap inputan dan membersihkannya dari karakter berbahaya
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    // Password di-enkripsi md5 agar cocok dengan yang di database
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['status_login'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Data Warehouse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-login {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
        }
        .card-header-gradient {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 2rem 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-6 col-lg-4">
                <div class="card card-login">
                    <div class="card-header-gradient">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Sistem Login</h4>
                        <p class="mb-0 mt-1 text-light" style="font-size: 0.85rem; opacity: 0.9;">Data Warehouse Monitoring</p>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger py-2 fs-6 text-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-semibold" style="font-size: 0.9rem;">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-secondary"></i></span>
                                    <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Masukkan username" required autofocus>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-secondary fw-semibold" style="font-size: 0.9rem;">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-secondary"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Masukkan password" required>
                                </div>
                            </div>
                            <button type="submit" name="login" class="btn w-100 text-white fw-bold py-2 shadow-sm" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none;">
                                MASUK <i class="bi bi-box-arrow-in-right ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3 text-muted" style="font-size: 0.8rem;">
                    &copy; <?= date('Y'); ?> - Sistem Inventory
                </div>
            </div>
        </div>
    </div>

</body>
</html>