<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) session_start();

$categories = ['Admit Card', 'Result', 'Latest Jobs', 'Answer Key'];

// Sanitize output
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Format date
function formatDate($date) {
    return date('d M Y', strtotime($date));
}

// Category badge color map
function categoryBadge($cat) {
    $map = [
        'Admit Card'  => 'primary',
        'Result'      => 'success',
        'Latest Jobs' => 'warning text-dark',
        'Answer Key'  => 'danger',
    ];
    $color = $map[$cat] ?? 'secondary';
    return '<span class="badge bg-' . $color . '">' . e($cat) . '</span>';
}

// Get blog image src
function blogImage($image) {
    if ($image && file_exists(UPLOAD_DIR . $image)) {
        return UPLOAD_URL . $image;
    }
    return DEFAULT_IMAGE;
}

// Redirect helper
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

// CSRF token helpers
function csrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfVerify() {
    $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Invalid CSRF token.');
    }
}
