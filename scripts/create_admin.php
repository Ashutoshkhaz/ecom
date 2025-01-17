<?php
require_once '../config.php';

// Admin details
$admin_email = 'admin@example.com';
$admin_password = 'admin123';
$admin_name = 'admin';

try {
    // First, check if role column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($stmt->rowCount() === 0) {
        // Add role column if it doesn't exist
        $pdo->exec("ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'user' AFTER password");
        echo "Added role column to users table\n";
    }

    // Check if admin already exists (modified query to work with or without role column)
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
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