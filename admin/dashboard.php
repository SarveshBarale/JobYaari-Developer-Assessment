<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/auth_check.php';

$pageTitle = 'Dashboard';
$adminPage = 'dashboard';

// Stats
$totalBlogs = $conn->query('SELECT COUNT(*) FROM blogs')->fetch_row()[0];
$statsByCategory = $conn->query(
    "SELECT category, COUNT(*) as cnt FROM blogs GROUP BY category"
)->fetch_all(MYSQLI_ASSOC);

// All blogs
$blogs = $conn->query('SELECT id, title, category, image, created_at FROM blogs ORDER BY created_at DESC')->fetch_all(MYSQLI_ASSOC);

// Flash message
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

require_once __DIR__ . '/admin_header.php';
?>

<?php if ($flash): ?>
<div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
    <?= e($flash['msg']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card bg-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-2 fw-bold"><?= $totalBlogs ?></div>
                    <div class="small opacity-75">Total Blogs</div>
                </div>
                <i class="bi bi-journal-richtext"></i>
            </div>
        </div>
    </div>
    <?php
    $catColors = ['Admit Card'=>'success','Result'=>'info','Latest Jobs'=>'warning','Answer Key'=>'danger'];
    $catIcons  = ['Admit Card'=>'card-heading','Result'=>'trophy','Latest Jobs'=>'briefcase','Answer Key'=>'key'];
    foreach ($statsByCategory as $row):
        $color = $catColors[$row['category']] ?? 'secondary';
        $icon  = $catIcons[$row['category']]  ?? 'tag';
    ?>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-<?= $color ?>">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-2 fw-bold"><?= $row['cnt'] ?></div>
                    <div class="small opacity-75"><?= e($row['category']) ?></div>
                </div>
                <i class="bi bi-<?= $icon ?>"></i>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Blog Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-list-ul me-2"></i>All Blogs</h6>
        <a href="<?= SITE_URL ?>/admin/add-blog.php" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Blog
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($blogs)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No blogs found. <a href="<?= SITE_URL ?>/admin/add-blog.php">Add one now.</a></td></tr>
                <?php else: ?>
                    <?php foreach ($blogs as $i => $blog): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <img src="<?= e(blogImage($blog['image'])) ?>" alt="<?= e($blog['title']) ?>">
                        </td>
                        <td><?= e($blog['title']) ?></td>
                        <td><?= categoryBadge($blog['category']) ?></td>
                        <td><?= formatDate($blog['created_at']) ?></td>
                        <td>
                            <a href="<?= SITE_URL ?>/admin/edit-blog.php?id=<?= $blog['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="<?= SITE_URL ?>/admin/delete-blog.php" class="d-inline delete-form">
                                <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
                                <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
