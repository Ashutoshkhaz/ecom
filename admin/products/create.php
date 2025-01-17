<?php
require_once '../../config.php';
require_once '../auth_check.php';

// Fetch categories for dropdown
$stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // Insert product
        $stmt = $pdo->prepare("
            INSERT INTO products (name, description, price, stock_quantity, category_id, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['price'],
            $_POST['stock_quantity'],
            $_POST['category_id']
        ]);
        
        $productId = $pdo->lastInsertId();

        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = __DIR__ . '/../../uploads/products/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $fileName = uniqid() . '_' . $_FILES['images']['name'][$key];
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($tmp_name, $uploadFile)) {
                    $stmt = $pdo->prepare("
                        INSERT INTO product_images (product_id, image_path, is_primary) 
                        VALUES (?, ?, ?)
                    ");
                    $stmt->execute([$productId, 'uploads/products/' . $fileName, $key === 0]);
                }
            }
        }

        $pdo->commit();
        header('Location: /admin/products');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Error creating product: " . $e->getMessage();
    }
}

$pageTitle = "Create Product";
?>

<div class="admin-form">
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>">
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" id="stock_quantity" name="stock_quantity" required>
            </div>

            <div class="form-group full-width">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group full-width">
                <label for="images">Product Images</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*" onchange="previewImages(this)">
                <div id="imagePreview" class="image-preview"></div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Product</button>
            <a href="/admin/products" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `<img src="${e.target.result}">`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}
</script> 