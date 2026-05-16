<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/auth_check.php';

$pageTitle = 'Add Blog';
$adminPage = 'add';
$errors    = [];
$old       = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = [
        'title'             => trim($_POST['title']             ?? ''),
        'short_description' => trim($_POST['short_description'] ?? ''),
        'content'           => trim($_POST['content']           ?? ''),
        'category'          => trim($_POST['category']          ?? ''),
    ];

    // Validation
    if ($old['title']             === '') $errors[] = 'Title is required.';
    if ($old['short_description'] === '') $errors[] = 'Short description is required.';
    if ($old['content']           === '') $errors[] = 'Content is required.';
    if (!in_array($old['category'], $categories))  $errors[] = 'Please select a valid category.';

    // Image upload
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $errors[] = 'Invalid image format. Allowed: JPG, PNG, GIF, WEBP.';
        } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Image size must be under 2MB.';
        } else {
            $imageName = uniqid('blog_') . '.' . $ext;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR . $imageName)) {
                $errors[] = 'Failed to upload image.';
                $imageName = null;
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare(
            'INSERT INTO blogs (title, short_description, content, category, image) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('sssss', $old['title'], $old['short_description'], $old['content'], $old['category'], $imageName);
        $stmt->execute();

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Blog added successfully!'];
        redirect(SITE_URL . '/admin/dashboard.php');
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-plus-circle me-2"></i>Add New Blog</h6>
    </div>
    <div class="card-body p-4">

        <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                <?php foreach ($errors as $err): ?>
                <li><?= e($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" novalidate>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?= e($old['title'] ?? '') ?>" placeholder="Enter blog title" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat) ?>" <?= (($old['category'] ?? '') === $cat) ? 'selected' : '' ?>>
                            <?= e($cat) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Image <small class="text-muted">(Max 2MB, JPG/PNG/GIF/WEBP)</small></label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    <img id="image-preview" src="" alt="Preview" class="mt-2 rounded" style="max-height:120px; display:none;">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Short Description <span class="text-danger">*</span></label>
                    <textarea name="short_description" class="form-control" rows="3" placeholder="Brief summary shown on blog cards..." required><?= e($old['short_description'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Full Content <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="10" placeholder="Full blog content (HTML supported)..." required><?= e($old['content'] ?? '') ?></textarea>
                    <div class="form-text">You can use basic HTML tags like &lt;p&gt;, &lt;h5&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;strong&gt;, etc.</div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Publish Blog
                    </button>
                    <a href="<?= SITE_URL ?>/admin/dashboard.php" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
