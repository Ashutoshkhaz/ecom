<header class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title"><?= $pageTitle ?? 'Dashboard' ?></h1>
        <div class="admin-header-actions">
            <div class="admin-user-menu">
                <span class="admin-user-name"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
                <a href="/admin/logout.php" class="admin-logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </div>
</header> 