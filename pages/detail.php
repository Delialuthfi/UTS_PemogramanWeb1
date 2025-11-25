<?php

$page_title = "Detail Perusahaan";
include '../includes/header.php';

// Koneksi Database
require_once '../api/config/database.php';
$database = new Database();
$db = $database->getConnection();

// Ambil ID dari URL
$company_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Company ID tidak ditemukan.');

// Query data company berdasarkan ID
$query = "SELECT * FROM companies WHERE id = ? LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $company_id);
$stmt->execute();
$company = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$company) {
    die('ERROR: Company tidak ditemukan.');
}
?>

<!-- Detail Header -->
<div class="detail-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" class="text-white">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Detail Perusahaan</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold"><?php echo htmlspecialchars($company['name']); ?></h1>
        <p class="lead">
            <span class="badge bg-light text-dark fs-6">
                <i class="bi bi-tag"></i> <?php echo htmlspecialchars($company['category']); ?>
            </span>
        </p>
    </div>
</div>

<!-- Detail Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Company Image -->
            <div class="col-lg-5 mb-4">
                <img src="<?php echo htmlspecialchars($company['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($company['name']); ?>"
                     class="detail-image">
            </div>

            <!-- Company Information -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="mb-4"><i class="bi bi-info-circle"></i> Informasi Perusahaan</h3>
                        
                        <div class="mb-4">
                            <h5 class="text-primary"><i class="bi bi-card-text"></i> Deskripsi</h5>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($company['description'])); ?></p>
                        </div>

                        <hr>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-event text-primary fs-4 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Tahun Didirikan</small>
                                        <strong><?php echo htmlspecialchars($company['founded_year']); ?></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-people text-success fs-4 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Jumlah Karyawan</small>
                                        <strong><?php echo number_format($company['employees']); ?></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-tag text-warning fs-4 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Kategori</small>
                                        <strong><?php echo htmlspecialchars($company['category']); ?></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-globe text-info fs-4 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Website</small>
                                        <a href="<?php echo htmlspecialchars($company['website']); ?>" 
                                           target="_blank" 
                                           class="text-decoration-none">
                                            Kunjungi Website <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <a href="index.php" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <button class="btn btn-success">
                                    <i class="bi bi-bookmark"></i> Simpan
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>