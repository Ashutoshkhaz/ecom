<?php
require_once '../config.php';
require_once 'auth_check.php';

// Redirect to dashboard
header('Location: /admin/dashboard');
exit; 