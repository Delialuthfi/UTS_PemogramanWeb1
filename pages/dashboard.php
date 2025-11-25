<?php

session_start();

// Cek apakah user sudah login
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$page_title = "Dashboard";
include '../includes/header.php';

// Koneksi Database
require_once '../api/config/database.php';
$database = new Database();
$db = $database->getConnection();

// Ambil statistik
$total_companies_query = "SELECT COUNT(*) as total FROM companies";
$total_stmt = $db->prepare($total_companies_query);
$total_stmt->execute();
$total_companies = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Ambil data companies
$query = "SELECT * FROM companies ORDER BY created_at DESC LIMIT 6";
$stmt = $db->prepare($query);
$stmt->execute();
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="container">
        <h1 class="mb-2">
            <i class="bi bi-speedometer2"></i> Dashboard
        </h1>
        <p class="lead mb-0">Selamat datang kembali, <strong><?php echo htmlspecialchars($_SESSION['fullname']); ?></strong>!</p>
    </div>
</div>

<!-- Statistics Section -->
<section class="py-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stats-card bg-primary text-white">
                    <i class="bi bi-building fs-1 mb-2"></i>
                    <h3><?php echo $total_companies; ?></h3>
                    <p class="mb-0">Total Perusahaan</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-success text-white">
                    <i class="bi bi-eye fs-1 mb-2"></i>
                    <h3>1,234</h3>
                    <p class="mb-0">Total Views</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-warning text-white">
                    <i class="bi bi-bookmark fs-1 mb-2"></i>
                    <h3>56</h3>
                    <p class="mb-0">Saved Items</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-info text-white">
                    <i class="bi bi-graph-up fs-1 mb-2"></i>
                    <h3>+12%</h3>
                    <p class="mb-0">Growth</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- User Profile Section -->
<section class="py-4">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="bi bi-person-circle"></i>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h4 class="mb-1"><?php echo htmlspecialchars($_SESSION['fullname']); ?></h4>
                        <p class="text-muted mb-2">
                            <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($_SESSION['email']); ?>
                        </p>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Active Member
                        </span>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="bi bi-gear"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Actions -->
<section class="py-4">
    <div class="container">
        <h3 class="mb-4"><i class="bi bi-lightning-charge"></i> Quick Actions</h3>
        <div class="row g-3">
            <div class="col-md-3">
                <a href="index.php" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-house-door text-primary fs-1 mb-2"></i>
                        <h6>Lihat Semua Perusahaan</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-bookmark text-success fs-1 mb-2"></i>
                        <h6>Saved Companies</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-clock-history text-warning fs-1 mb-2"></i>
                        <h6>History</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-gear text-info fs-1 mb-2"></i>
                        <h6>Settings</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Recent Companies -->
<section class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="bi bi-clock-history"></i> Recent Companies</h3>
            <a href="index.php" class="btn btn-outline-primary btn-sm">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="row g-4">
            <?php foreach($companies as $company): ?>
            <div class="col-md-4">
                <div class="card company-card">
                    <img src="<?php echo htmlspecialchars($company['image_url']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($company['name']); ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title mb-0"><?php echo htmlspecialchars($company['name']); ?></h6>
                            <span class="badge bg-primary"><?php echo htmlspecialchars($company['category']); ?></span>
                        </div>
                        <p class="card-text text-muted small">
                            <?php echo substr(htmlspecialchars($company['description']), 0, 80) . '...'; ?>
                        </p>
                        <a href="detail.php?id=<?php echo $company['id']; ?>" class="btn btn-outline-primary btn-sm w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>