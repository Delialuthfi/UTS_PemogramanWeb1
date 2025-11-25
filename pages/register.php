<?php

session_start();

// Jika sudah login, redirect ke dashboard
if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

require_once '../api/config/database.php';

$error_message = '';
$success_message = '';

// Proses Registrasi
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validasi server-side
    if(empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = 'Semua field harus diisi!';
    } elseif($password !== $confirm_password) {
        $error_message = 'Password dan konfirmasi password tidak cocok!';
    } elseif(strlen($password) < 6) {
        $error_message = 'Password minimal 6 karakter!';
    } else {
        $database = new Database();
        $db = $database->getConnection();
        
        // Cek apakah email sudah terdaftar
        $check_query = "SELECT id FROM users WHERE email = ? LIMIT 1";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(1, $email);
        $check_stmt->execute();
        
        if($check_stmt->rowCount() > 0) {
            $error_message = 'Email sudah terdaftar!';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user baru
            $insert_query = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
            $insert_stmt = $db->prepare($insert_query);
            $insert_stmt->bindParam(1, $fullname);
            $insert_stmt->bindParam(2, $email);
            $insert_stmt->bindParam(3, $hashed_password);
            
            if($insert_stmt->execute()) {
                header("Location: login.php?registered=true");
                exit();
            } else {
                $error_message = 'Registrasi gagal. Silakan coba lagi.';
            }
        }
    }
}

$page_title = "Register";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - TechVenture</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card auth-card">
                        <div class="card-body p-5">
                            <!-- Logo & Title -->
                            <div class="text-center mb-4">
                                <h2 class="fw-bold text-primary">
                                    <i class="bi bi-rocket-takeoff"></i> TechVenture
                                </h2>
                                <p class="text-muted">Buat akun baru Anda</p>
                            </div>

                            <!-- Error Message -->
                            <div id="error-message" class="alert d-none"></div>
                            
                            <?php if($error_message): ?>
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-triangle"></i> <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Register Form -->
                            <form id="registerForm" method="POST" action="" onsubmit="validateRegister(event)">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">
                                        <i class="bi bi-person"></i> Nama Lengkap
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="fullname" 
                                           name="fullname"
                                           placeholder="Masukkan nama lengkap"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="bi bi-envelope"></i> Email
                                    </label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email"
                                           placeholder="nama@email.com"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-lock"></i> Password
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password" 
                                           name="password"
                                           placeholder="Minimal 6 karakter"
                                           required>
                                    <small class="text-muted">Password minimal 6 karakter</small>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">
                                        <i class="bi bi-lock-fill"></i> Konfirmasi Password
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="confirm_password" 
                                           name="confirm_password"
                                           placeholder="Ulangi password"
                                           required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-3">
                                    <i class="bi bi-person-plus"></i> Daftar Sekarang
                                </button>
                            </form>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Sudah punya akun? 
                                    <a href="login.php" class="text-primary text-decoration-none fw-bold">
                                        Login
                                    </a>
                                </p>
                                <a href="index.php" class="text-muted text-decoration-none d-block mt-2">
                                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>@Copyright by 23552011317_ARDELIA LUTHFIANI_TIF RP-23 CNS B</p>
        </div>
    </footer>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/validation.js"></script>
</body>
</html>