<?php

$page_title = "Beranda";
include '../includes/header.php';

// Koneksi Database
require_once '../api/config/database.php';
$database = new Database();
$db = $database->getConnection();

// Ambil data companies
$query = "SELECT * FROM companies ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="fade-in-up">
            <h1><i class="bi bi-building"></i> Selamat Datang di TechVenture</h1>
            <p class="lead">Platform Informasi Perusahaan Teknologi Terkemuka di Dunia</p>
            <div class="mt-4">
                <a href="register.php" class="btn btn-light btn-lg me-2">
                    <i class="bi bi-person-plus"></i> Daftar Sekarang
                </a>
                <a href="#companies" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-arrow-down"></i> Jelajahi
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Companies Section -->
<section id="companies" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Perusahaan Teknologi Terkemuka</h2>
            <p class="text-muted">Temukan informasi lengkap tentang perusahaan teknologi inovatif</p>
        </div>

        <div class="row g-4">
            <?php foreach($companies as $company): ?>
            <div class="col-md-4">
                <div class="card company-card">
                    <img src="<?php echo htmlspecialchars($company['image_url']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($company['name']); ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0"><?php echo htmlspecialchars($company['name']); ?></h5>
                            <span class="badge bg-primary"><?php echo htmlspecialchars($company['category']); ?></span>
                        </div>
                        <p class="card-text text-muted">
                            <?php echo substr(htmlspecialchars($company['description']), 0, 100) . '...'; ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> Didirikan: <?php echo $company['founded_year']; ?>
                            </small>
                            <a href="detail.php?id=<?php echo $company['id']; ?>" class="btn btn-outline-primary btn-sm">
                                Lihat Detail <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" style="background-color: #fff;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-shield-check" style="font-size: 3rem; color: var(--primary-color);"></i>
                </div>
                <h4>Terpercaya</h4>
                <p class="text-muted">Informasi akurat dan terverifikasi dari sumber terpercaya</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-lightning-charge" style="font-size: 3rem; color: var(--secondary-color);"></i>
                </div>
                <h4>Cepat & Mudah</h4>
                <p class="text-muted">Akses informasi dengan cepat dan antarmuka yang user-friendly</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-graph-up-arrow" style="font-size: 3rem; color: var(--accent-color);"></i>
                </div>
                <h4>Terupdate</h4>
                <p class="text-muted">Data selalu diperbarui dengan informasi terkini</p>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>