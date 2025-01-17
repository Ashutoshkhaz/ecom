<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?= $pageTitle ?? 'Admin' ?></title>
    <!-- Update CSS paths to be relative to admin directory -->
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/admin/admin.css">
    <link rel="stylesheet" href="/assets/css/admin/products.css">
    <link rel="stylesheet" href="/assets/css/admin/blog.css">
    <link rel="stylesheet" href="/assets/css/admin/categories.css">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/partials/sidebar.php'; ?>
        <main class="admin-main">
            <?php include __DIR__ . '/partials/header.php'; ?>
            <div class="admin-content">
                <?php include $contentView; ?>
            </div>
        </main>
    </div>

    <button class="admin-mobile-toggle">
        <i class="fas fa-bars"></i>
    </button>

    <script src="/assets/js/admin/admin.js"></script>
</body>
</html> 