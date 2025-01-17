<?php
require_once '../config.php';

// Admin details
$admin_email = 'admin@example.com';
$admin_password = 'admin123';
$admin_name = 'admin';

try {
    // Check if admin already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$admin_email]);
    
    if ($stmt->fetch()) {
        echo "Admin user already exists!\n";
        exit;
    }

    // Create admin user (using full_name instead of name)
    $stmt = $pdo->prepare("
        INSERT INTO users (email, password, full_name, role, created_at) 
        VALUES (?, ?, ?, 'admin', NOW())
    ");
    
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
    $stmt->execute([$admin_email, $hashed_password, $admin_name]);
    
    echo "Admin user created successfully!\n";
} catch (Exception $e) {
    echo "Error creating admin user: " . $e->getMessage() . "\n";
} 