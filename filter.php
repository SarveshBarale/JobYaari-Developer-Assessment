<?php
/**
 * filter.php — AJAX endpoint for blog filtering
 * Returns HTML blog cards based on search/category/date filters
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$search   = trim($_GET['search']   ?? '');
$category = trim($_GET['category'] ?? '');
$date     = trim($_GET['date']     ?? '');

$where  = [];
$params = [];
$types  = '';

if ($search !== '') {
    $where[]  = '(title LIKE ? OR short_description LIKE ?)';
    $like     = '%' . $search . '%';
    $params[] = $like;
    $params[] = $like;
    $types   .= 'ss';
}

if ($category !== '') {
    $where[]  = 'category = ?';
    $params[] = $category;
    $types   .= 's';
}

if ($date !== '') {
    $where[]  = 'DATE(created_at) = ?';
    $params[] = $date;
    $types   .= 's';
}

$sql = 'SELECT id, title, short_description, category, image, created_at FROM blogs';
if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
$sql .= ' ORDER BY created_at DESC';

$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '';
    exit;
}

while ($blog = $result->fetch_assoc()):
    $imgSrc = blogImage($blog['image']);
?>
<div class="col-sm-6 col-lg-4 mb-4">
    <div class="card blog-card h-100">
        <img src="<?= e($imgSrc) ?>" class="card-img-top" alt="<?= e($blog['title']) ?>" loading="lazy">
        <div class="card-body">
            <div class="mb-2"><?= categoryBadge($blog['category']) ?></div>
            <h5 class="card-title"><?= e($blog['title']) ?></h5>
            <p class="card-text"><?= e($blog['short_description']) ?></p>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <span><i class="bi bi-calendar3 me-1"></i><?= formatDate($blog['created_at']) ?></span>
            <a href="<?= SITE_URL ?>/blog.php?id=<?= $blog['id'] ?>" class="btn btn-primary btn-sm">
                Read More <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
<?php endwhile; ?>
