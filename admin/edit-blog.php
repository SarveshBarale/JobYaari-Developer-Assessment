<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/auth_check.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) redirect(SITE_URL . '/admin/dashboard.php');

// Fetch existing blog
$stmt = $conn->prepare('SELECT * FROM blogs WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();
if (!$blog) redirect(SITE_URL . '/admin/dashboard.php');

$pageTitle = 'Edit Blog';
$adminPage = 'dashboard';
$errors    = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title'             => trim($_POST['title']             ?? ''),
        'short_description' => trim($_POST['short_description'] ?? ''),
        'content'           => trim($_POST['content']           ?? ''),
        'category'          => trim($_POST['category']          ?? ''),
    ];

    if ($data['title']             === '') $errors[] = 'Title is required.';
    if ($data['short_description'] === '') $errors[] = 'Short description is required.';
    if ($data['content']           === '') $errors[] = 'Content is required.';
    if (!in_array($data['category'], $categories))  $errors[] = 'Please select a valid category.';

    // Handle image
    $imageName = $blog['image']; // keep existing by default
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $errors[] = 'Invalid image format.';
        } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Image size must be under 2MB.';
        } else {
            $newName = uniqid('blog_') . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR . $newName)) {
                // Delete old image
                if ($blog['image'] && file_exists(UPLOAD_DIR . $blog['image'])) {
                    unlink(UPLOAD_DIR . $blog['image']);
                }
                $imageName = $newName;
            } else {
                $errors[] = 'Failed to upload image.';
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare(
            'UPDATE blogs SET title=?, short_description=?, content=?, category=?, image=? WHERE id=?'
        );
        $stmt->bind_param('sssssi', $data['title'], $data['short_description'], $data['content'], $data['category'], $imageName, $id);
        $stmt->execute();

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Blog updated successfully!'];
        redirect(SITE_URL . '/admin/dashboard.php');
    }

    // Merge for re-display
    $blog = array_merge($blog, $data);
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-pencil me-2"></i>Edit Blog</h6>
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
                    <input type="text" name="title" class="form-control" value="<?= e($blog['title']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat) ?>" <?= ($blog['category'] === $cat) ? 'selected' : '' ?>>
                            <?= e($cat) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Image <small class="text-muted">(Leave blank to keep current)</small></label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    <img id="image-preview" src="<?= e(blogImage($blog['image'])) ?>" alt="Current Image"
                         class="mt-2 rounded" style="max-height:120px;">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Short Description <span class="text-danger">*</span></label>
                    <textarea name="short_description" class="form-control" rows="3" required><?= e($blog['short_description']) ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Full Content <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="10" required><?= htmlspecialchars($blog['content'], ENT_QUOTES, 'UTF-8') ?></textarea>
                    <div class="form-text">HTML tags are supported.</div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Update Blog
                    </button>
                    <a href="<?= SITE_URL ?>/admin/dashboard.php" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
