<?php
// Determine the content view based on the current page
$currentPage = basename(dirname($_SERVER['PHP_SELF']));
$contentView = match($currentPage) {
    'products' => __DIR__ . '/products/index.php',
    'orders' => __DIR__ . '/orders/index.php',
    'dashboard' => __DIR__ . '/dashboard/index.php',
    default => __DIR__ . '/dashboard/index.php',
};

require_once __DIR__ . '/templates/layout.php'; 