<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(SITE_URL . '/admin/dashboard.php');
}

csrfVerify();

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) redirect(SITE_URL . '/admin/dashboard.php');

$stmt = $conn->prepare('SELECT image FROM blogs WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();

if ($blog) {
    if ($blog['image'] && file_exists(UPLOAD_DIR . $blog['image'])) {
        unlink(UPLOAD_DIR . $blog['image']);
    }
    $del = $conn->prepare('DELETE FROM blogs WHERE id = ?');
    $del->bind_param('i', $id);
    $del->execute();
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Blog deleted successfully.'];
} else {
    $_SESSION['flash'] = ['type' => 'warning', 'msg' => 'Blog not found.'];
}

redirect(SITE_URL . '/admin/dashboard.php');
