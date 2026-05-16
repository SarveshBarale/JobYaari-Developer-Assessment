<?php
/**
 * Admin sidebar + topbar partial
 * Requires $adminPage variable to be set for active link highlighting
 */
$adminPage = $adminPage ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | ' : '' ?>Admin — <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>

<!-- Mobile topbar toggle -->
<nav class="navbar navbar-dark bg-primary d-md-none px-3 py-2">
    <a class="navbar-brand fw-bold" href="<?= SITE_URL ?>/admin/dashboard.php">
        <i class="bi bi-briefcase-fill me-2"></i><?= SITE_NAME ?>
    </a>
    <button class="btn btn-outline-light btn-sm" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
</nav>

<!-- Sidebar -->
<nav class="admin-sidebar d-none d-md-flex flex-column" id="adminSidebar">
    <a href="<?= SITE_URL ?>/admin/dashboard.php" class="brand">
        <i class="bi bi-briefcase-fill me-2"></i><?= SITE_NAME ?>
    </a>
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link <?= $adminPage === 'dashboard' ? 'active' : '' ?>" href="<?= SITE_URL ?>/admin/dashboard.php">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $adminPage === 'add' ? 'active' : '' ?>" href="<?= SITE_URL ?>/admin/add-blog.php">
                <i class="bi bi-plus-circle me-2"></i>Add Blog
            </a>
        </li>
        <li class="nav-item mt-auto">
            <a class="nav-link text-danger" href="<?= SITE_URL ?>/admin/logout.php">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </a>
        </li>
    </ul>
</nav>

<!-- Main wrapper -->
<div class="admin-main">
    <!-- Topbar -->
    <div class="admin-topbar">
        <h6 class="mb-0 fw-semibold"><?= $pageTitle ?? 'Dashboard' ?></h6>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small"><i class="bi bi-person-circle me-1"></i><?= e($_SESSION['admin_username'] ?? 'Admin') ?></span>
            <a href="<?= SITE_URL ?>/admin/logout.php" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </a>
        </div>
    </div>
    <div class="admin-content">
