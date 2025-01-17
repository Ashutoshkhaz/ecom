<?php
require_once '../../config.php';
require_once '../auth_check.php';

$productId = $_GET['id'] ?? null;
if (!$productId) {
    header('Location: /admin/products');
    exit;
}

// Fetch product details
$stmt = $pdo->prepare("
    SELECT p.*, GROUP_CONCAT(pi.image_path) as images 
    FROM products p 
    LEFT JOIN product_images pi ON p.id = pi.product_id 
    WHERE p.id = ?
    GROUP BY p.id
");
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: /admin/products');
    exit;
}

// Fetch categories
$stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // Update product
        $stmt = $pdo->prepare("
            UPDATE products 
            SET name = ?, description = ?, price = ?, 
                stock_quantity = ?, category_id = ? 
            WHERE id = ?
        ");
        $stmt->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['price'],
            $_POST['stock_quantity'],
            $_POST['category_id'],
            $productId
        ]);

        // Handle new image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = '../../uploads/products/';
            
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $fileName = uniqid() . '_' . $_FILES['images']['name'][$key];
                move_uploaded_file($tmp_name, $uploadDir . $fileName);
                
                $stmt = $pdo->prepare("
                    INSERT INTO product_images (product_id, image_path, is_primary) 
                    VALUES (?, ?, ?)
                ");
                $stmt->execute([
                    $productId,
                    '/uploads/products/' . $fileName,
                    0
                ]);
            }
        }

        $pdo->commit();
        header('Location: /admin/products');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Error updating product: " . $e->getMessage();
    }
}

$pageTitle = "Edit Product";
require_once '../layout.php';
?>

<div class="admin-form">
    <form method="POST" enctype="multipart/form-data">
        <!-- Similar form structure as create.php with pre-filled values -->
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" 
                       value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <!-- Other form fields... -->
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="/admin/products" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div> 