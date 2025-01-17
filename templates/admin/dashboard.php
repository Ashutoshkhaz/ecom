<div class="dashboard-grid">
    <!-- Quick Stats -->
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="stat-content">
            <h3>Total Products</h3>
            <p class="stat-number">245</p>
            <p class="stat-change positive">+12% from last month</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-content">
            <h3>Orders Today</h3>
            <p class="stat-number">18</p>
            <p class="stat-change positive">+5% from yesterday</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-content">
            <h3>Revenue Today</h3>
            <p class="stat-number">$1,284</p>
            <p class="stat-change positive">+8% from yesterday</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <h3>New Customers</h3>
            <p class="stat-number">24</p>
            <p class="stat-change positive">+15% from last week</p>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<section class="dashboard-section">
    <div class="section-header">
        <h2>Recent Orders</h2>
        <a href="/admin/orders" class="btn-view-all">View All</a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Products</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample order rows -->
            </tbody>
        </table>
    </div>
</section>

<!-- Low Stock Alert -->
<section class="dashboard-section">
    <div class="section-header">
        <h2>Low Stock Alert</h2>
        <a href="/admin/products?filter=low-stock" class="btn-view-all">View All</a>
    </div>
    <div class="alert-list">
        <!-- Low stock items -->
    </div>
</section> 