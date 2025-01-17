<?php
// Determine the content view based on the current page and action
$currentPage = basename(dirname($_SERVER['PHP_SELF']));
$action = basename($_SERVER['PHP_SELF'], '.php');

$contentView = match("$currentPage/$action") {
    'products/create' => __DIR__ . '/products/create.php',
    'products/edit' => __DIR__ . '/products/edit.php',
    'products/index' => __DIR__ . '/products/index.php',
    'orders/index' => __DIR__ . '/orders/index.php',
    'dashboard/index' => __DIR__ . '/dashboard/index.php',
    default => __DIR__ . '/dashboard/index.php',
};

require_once __DIR__ . '/templates/layout.php'; 