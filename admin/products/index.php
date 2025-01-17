<?php
require_once '../../config.php';
require_once '../auth_check.php'; // Ensure admin is logged in

// Fetch products with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("
    SELECT p.*, pi.image_path, c.name as category_name 
    FROM products p 
    LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
    LEFT JOIN categories c ON p.category_id = c.id 
    ORDER BY p.created_at DESC 
    LIMIT ? OFFSET ?
");
$stmt->execute([$limit, $offset]);
$products = $stmt->fetchAll();

// Get total products count for pagination
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$totalProducts = $stmt->fetchColumn();
$totalPages = ceil($totalProducts / $limit);

$pageTitle = "Manage Products";
require_once '../layout.php';
?>

<div class="admin-products">
    <div class="page-actions">
        <a href="/admin/products/create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Product
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($product['image_path'] ?? '/assets/images/placeholder.png') ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>" 
                                 class="product-thumbnail">
                        </td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['category_name']) ?></td>
                        <td>$<?= number_format($product['price'], 2) ?></td>
                        <td><?= $product['stock_quantity'] ?></td>
                        <td>
                            <span class="status-badge <?= $product['stock_quantity'] > 0 ? 'in-stock' : 'out-of-stock' ?>">
                                <?= $product['stock_quantity'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                            </span>
                        </td>
                        <td class="action-buttons">
                            <a href="/admin/products/edit.php?id=<?= $product['id'] ?>" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteProduct(<?= $product['id'] ?>)" class="btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $page === $i ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        fetch(`/admin/products/delete.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting product');
            }
        });
    }
}
</script> 