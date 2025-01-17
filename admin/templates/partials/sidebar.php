<aside class="admin-sidebar">
    <div class="admin-logo">
        <i class="fas fa-store"></i> Store Admin
    </div>
    
    <nav class="admin-nav">
        <ul>
            <li><a href="/admin/dashboard" class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a></li>
            <li><a href="/admin/products" class="<?= $currentPage === 'products' ? 'active' : '' ?>">
                <i class="fas fa-box"></i> Products
            </a></li>
            <li><a href="/admin/orders" class="<?= $currentPage === 'orders' ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart"></i> Orders
            </a></li>
        </ul>
    </nav>
</aside> 