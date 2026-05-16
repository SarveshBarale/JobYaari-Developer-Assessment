<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) redirect(SITE_URL . '/index.php');

$stmt = $conn->prepare('SELECT * FROM blogs WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();

if (!$blog) redirect(SITE_URL . '/index.php');

$pageTitle = $blog['title'];
require_once __DIR__ . '/includes/header.php';
$imgSrc = blogImage($blog['image']);
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/index.php">Home</a></li>
                    <li class="breadcrumb-item active"><?= e($blog['category']) ?></li>
                </ol>
            </nav>

            <!-- Blog Detail Card -->
            <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                <img src="<?= e($imgSrc) ?>" class="blog-detail-img" alt="<?= e($blog['title']) ?>">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                        <?= categoryBadge($blog['category']) ?>
                        <small class="text-muted"><i class="bi bi-calendar3 me-1"></i><?= formatDate($blog['created_at']) ?></small>
                    </div>
                    <h1 class="h3 fw-bold mb-3"><?= e($blog['title']) ?></h1>
                    <p class="text-muted border-start border-primary border-3 ps-3 mb-4">
                        <?= e($blog['short_description']) ?>
                    </p>
                    <div class="blog-content">
                        <?= $blog['content'] /* HTML content stored in DB */ ?>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="<?= SITE_URL ?>/index.php" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i>Back to All Blogs
                </a>
            </div>

        </div>
    </div>
</div>

<script>const SITE_URL = '<?= SITE_URL ?>';</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
