<?php
$pageTitle = 'Home';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Banner -->
<section class="hero-banner">
    <div class="container text-center">
        <h1><i class="bi bi-briefcase-fill me-2"></i>Welcome to <?= SITE_NAME ?></h1>
        <p class="mb-0">Your one-stop destination for Admit Cards, Results, Latest Jobs &amp; Answer Keys</p>
    </div>
</section>

<div class="container py-4">

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold mb-1"><i class="bi bi-search me-1"></i>Search</label>
                <input type="text" id="search-input" class="form-control" placeholder="Search blogs...">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold mb-1"><i class="bi bi-tag me-1"></i>Category</label>
                <select id="category-filter" class="form-select">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= e($cat) ?>" <?= (($_GET['category'] ?? '') === $cat) ? 'selected' : '' ?>>
                        <?= e($cat) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1"><i class="bi bi-calendar3 me-1"></i>Date</label>
                <input type="date" id="date-filter" class="form-control">
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Loading blogs...</p>
    </div>

    <!-- No Results -->
    <div id="no-results">
        <i class="bi bi-search text-muted"></i>
        <h5 class="text-muted">No blogs found</h5>
        <p class="text-muted">Try adjusting your search or filters.</p>
    </div>

    <!-- Blog Grid (populated via AJAX) -->
    <div class="row" id="blog-grid"></div>

</div>

<!-- Pass SITE_URL to JS -->
<script>const SITE_URL = '<?= SITE_URL ?>';</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
