<div class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-header">
        <i class="fas fa-store-alt"></i>
        <h3>XY_SHOP Admin</h3>
    </div>
    <div class="admin-sidebar-menu">
        <a href="/xy_shop_admin/index.php" class="admin-menu-item <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        
        <div class="admin-menu-item <?php echo strpos($current_page, 'products/') !== false ? 'active' : ''; ?>">
            <i class="fas fa-box-open"></i>
            <span>Products</span>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div class="admin-submenu <?php echo strpos($current_page, 'products/') !== false ? 'show' : ''; ?>">
            <a href="/xy_shop_admin/products/" class="admin-submenu-item <?php echo $current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], 'products') !== false ? 'active' : ''; ?>">All Products</a>
            <a href="/xy_shop_admin/products/add.php" class="admin-submenu-item <?php echo $current_page == 'add.php' ? 'active' : ''; ?>">Add New</a>
            <a href="/xy_shop_admin/products/inventory_in.php" class="admin-submenu-item <?php echo $current_page == 'inventory_in.php' ? 'active' : ''; ?>">Inventory In</a>
            <a href="/xy_shop_admin/products/inventory_out.php" class="admin-submenu-item <?php echo $current_page == 'inventory_out.php' ? 'active' : ''; ?>">Inventory Out</a>
            <a href="/xy_shop_admin/products/categories.php" class="admin-submenu-item <?php echo $current_page == 'categories.php' ? 'active' : ''; ?>">Categories</a>
        </div>
        
        <a href="/xy_shop_admin/orders/" class="admin-menu-item <?php echo strpos($current_page, 'orders/') !== false ? 'active' : ''; ?>">
            <i class="fas fa-shopping-cart"></i>
            <span>Orders</span>
        </a>
        
        <a href="/xy_shop_admin/customers/" class="admin-menu-item <?php echo strpos($current_page, 'customers/') !== false ? 'active' : ''; ?>">
            <i class="fas fa-users"></i>
            <span>Customers</span>
        </a>
        
        <a href="/xy_shop_admin/reports/" class="admin-menu-item <?php echo strpos($current_page, 'reports/') !== false ? 'active' : ''; ?>">
            <i class="fas fa-chart-line"></i>
            <span>Reports</span>
        </a>
        
        <a href="/xy_shop_admin/settings/" class="admin-menu-item <?php echo strpos($current_page, 'settings/') !== false ? 'active' : ''; ?>">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
    </div>
</div>