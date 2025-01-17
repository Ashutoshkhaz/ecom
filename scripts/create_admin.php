<?php
require_once '../config.php';

// Admin details
$admin_email = 'admin@example.com';
$admin_password = 'your_secure_password';
$admin_name = 'Admin User';

try {
    // Check if admin already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$admin_email]);
    
    if ($stmt->fetch()) {
        echo "Admin user already exists!\n";
        exit;
    }

    // Create admin user
    $stmt = $pdo->prepare("
        INSERT INTO users (email, password, name, role, created_at) 
        VALUES (?, ?, ?, 'admin', NOW())
    ");
    
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
    $stmt->execute([$admin_email, $hashed_password, $admin_name]);
    
    echo "Admin user created successfully!\n";
} catch (Exception $e) {
    echo "Error creating admin user: " . $e->getMessage() . "\n";
} 