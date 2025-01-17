<?php
require_once '../../config.php';
require_once '../auth_check.php';

// Fetch orders with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("
    SELECT o.*, 
           u.email as customer_email,
           COUNT(oi.id) as item_count,
           SUM(oi.quantity * oi.price) as total_amount
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    LEFT JOIN order_items oi ON o.id = oi.order_id
    GROUP BY o.id
    ORDER BY o.created_at DESC
    LIMIT ? OFFSET ?
");
$stmt->execute([$limit, $offset]);
$orders = $stmt->fetchAll();

$stmt = $pdo->query("SELECT COUNT(*) FROM orders");
$totalOrders = $stmt->fetchColumn();
$totalPages = ceil($totalOrders / $limit);

$pageTitle = "Manage Orders";
require_once '../layout.php';
?>

<div class="admin-orders">
    <div class="page-header">
        <h2>Orders</h2>
        <div class="order-filters">
            <select id="status-filter" onchange="filterOrders()">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></td>
                        <td><?= htmlspecialchars($order['customer_email']) ?></td>
                        <td><?= $order['item_count'] ?> items</td>
                        <td>$<?= number_format($order['total_amount'], 2) ?></td>
                        <td>
                            <select onchange="updateOrderStatus(<?= $order['id'] ?>, this.value)"
                                    class="status-select status-<?= $order['status'] ?>">
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>
                                    Pending
                                </option>
                                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>
                                    Processing
                                </option>
                                <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>
                                    Shipped
                                </option>
                                <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>
                                    Delivered
                                </option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>
                                    Cancelled
                                </option>
                            </select>
                        </td>
                        <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                        <td>
                            <a href="/admin/orders/view.php?id=<?= $order['id'] ?>" class="btn-view">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

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
function updateOrderStatus(orderId, status) {
    fetch('/admin/orders/update-status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ orderId, status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update status class
            const select = document.querySelector(`select[onchange*="${orderId}"]`);
            select.className = `status-select status-${status}`;
        } else {
            alert('Error updating order status');
        }
    });
}

function filterOrders() {
    const status = document.getElementById('status-filter').value;
    window.location.href = `/admin/orders?status=${status}`;
}
</script> 