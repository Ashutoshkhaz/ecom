<aside class="admin-sidebar">
    <a href="/admin" class="admin-logo">
        <i class="fas fa-store"></i> Store Admin
    </a>
    
    <nav class="admin-nav">
        <ul>
            <li class="admin-nav-item">
                <a href="/admin/dashboard" class="admin-nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="/admin/products" class="admin-nav-link <?= $currentPage === 'products' ? 'active' : '' ?>">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="/admin/orders" class="admin-nav-link <?= $currentPage === 'orders' ? 'active' : '' ?>">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="/admin/blog" class="admin-nav-link <?= $currentPage === 'blog' ? 'active' : '' ?>">
                    <i class="fas fa-blog"></i> Blog
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="/admin/categories" class="admin-nav-link <?= $currentPage === 'categories' ? 'active' : '' ?>">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="/admin/users" class="admin-nav-link <?= $currentPage === 'users' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="/admin/settings" class="admin-nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>
        </ul>
    </nav>
</aside> 