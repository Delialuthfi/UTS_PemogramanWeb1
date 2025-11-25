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

// Proses Login
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Validasi server-side
    if(empty($email) || empty($password)) {
        $error_message = 'Email dan password harus diisi!';
    } else {
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "SELECT id, fullname, email, password FROM users WHERE email = ? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifikasi password
            if(password_verify($password, $user['password'])) {
                // Login berhasil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect ke dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = 'Email atau password salah!';
            }
        } else {
            $error_message = 'Email tidak terdaftar!';
        }
    }
}

$page_title = "Login";
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
                                <p class="text-muted">Silakan login ke akun Anda</p>
                            </div>

                            <!-- Error/Success Message -->
                            <div id="error-message" class="alert d-none"></div>
                            
                            <?php if($error_message): ?>
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-triangle"></i> <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>

                            <?php if(isset($_GET['registered'])): ?>
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle"></i> Registrasi berhasil! Silakan login.
                                </div>
                            <?php endif; ?>

                            <!-- Login Form -->
                            <form id="loginForm" method="POST" action="" onsubmit="validateLogin(event)">
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
                                           placeholder="Masukkan password"
                                           required>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-3">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </button>
                            </form>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Belum punya akun? 
                                    <a href="register.php" class="text-primary text-decoration-none fw-bold">
                                        Daftar Sekarang
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