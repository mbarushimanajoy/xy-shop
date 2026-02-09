<?php
require_once __DIR__ . '/../../includes/header.php';

// Get all products
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.name";
$products = $conn->query($sql);

// Get all categories for filter
$categories = $conn->query("SELECT * FROM categories ORDER BY name");
?>

<div class="admin-content">
    <!-- Stats Cards -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <i class="fas fa-boxes admin-stat-icon"></i>
            <div class="admin-stat-value">
                <?php 
                $count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc();
                echo $count['total']; 
                ?>
            </div>
            <div class="admin-stat-label">Total Products</div>
        </div>
        <div class="admin-stat-card">
            <i class="fas fa-arrow-up admin-stat-icon"></i>
            <div class="admin-stat-value">
                <?php 
                $month = date('m');
                $year = date('Y');
                $stockIn = $conn->query("SELECT SUM(quantity) as total FROM stock_in 
                                        WHERE MONTH(date_time) = $month AND YEAR(date_time) = $year")->fetch_assoc();
                echo $stockIn['total'] ?: 0; 
                ?>
            </div>
            <div class="admin-stat-label">Stock In This Month</div>
        </div>
        <div class="admin-stat-card">
            <i class="fas fa-arrow-down admin-stat-icon"></i>
            <div class="admin-stat-value">
                <?php 
                $stockOut = $conn->query("SELECT SUM(quantity) as total FROM stock_out 
                                        WHERE MONTH(date_time) = $month AND YEAR(date_time) = $year")->fetch_assoc();
                echo $stockOut['total'] ?: 0; 
                ?>
            </div>
            <div class="admin-stat-label">Stock Out This Month</div>
        </div>
        <div class="admin-stat-card">
            <i class="fas fa-exclamation-triangle admin-stat-icon"></i>
            <div class="admin-stat-value">
                <?php 
                $lowStock = $conn->query("SELECT COUNT(*) as total FROM products 
                                        WHERE min_stock > 0 AND stock <= min_stock")->fetch_assoc();
                echo $lowStock['total']; 
                ?>
            </div>
            <div class="admin-stat-label">Low Stock Items</div>
        </div>
    </div>

    <!-- Product Management Tabs -->
    <div class="admin-tabs">
        <div class="admin-tab active" data-tab="products">Products</div>
        <div class="admin-tab" data-tab="stockIn">Stock In</div>
        <div class="admin-tab" data-tab="stockOut">Stock Out</div>
        <div class="admin-tab" data-tab="categories">Categories</div>
    </div>

    <!-- Products Tab -->
    <div class="admin-tab-content active" id="productsTab">
        <div class="admin-search-filter">
            <div class="admin-search-box">
                <i class="fas fa-search admin-search-icon"></i>
                <input type="text" class="admin-search-input" id="productSearch" placeholder="Search products...">
            </div>
            <div class="admin-filter-group">
                <select class="admin-filter-select" id="productStatusFilter">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
                <select class="admin-filter-select" id="productCategoryFilter">
                    <option value="">All Categories</option>
                    <?php while($category = $categories->fetch_assoc()): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endwhile; ?>
                </select>
                <button class="admin-btn admin-btn-secondary" id="printProductsBtn">
                    <i class="fas fa-print"></i> Print
                </button>
                <button class="admin-btn admin-btn-success" id="exportProductsBtn">
                    <i class="fas fa-file-export"></i> Export
                </button>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">All Products</h3>
                <div class="admin-card-actions">
                    <a href="add.php" class="admin-btn admin-btn-primary">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                    <button class="admin-btn admin-btn-warning" id="refreshProductsBtn">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Current Stock</th>
                            <th>Price (RWF)</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        <?php if($products->num_rows > 0): ?>
                            <?php while($product = $products->fetch_assoc()): ?>
                                <?php
                                // Determine stock level indicator
                                $stockLevelClass = 'stock-high';
                                $stockLevelTooltip = 'Good stock level';
                                
                                if ($product['min_stock'] && $product['stock'] <= $product['min_stock']) {
                                    $stockLevelClass = 'stock-low';
                                    $stockLevelTooltip = 'Low stock - below minimum';
                                } elseif ($product['max_stock'] && $product['stock'] > $product['max_stock'] * 0.7) {
                                    $stockLevelClass = 'stock-medium';
                                    $stockLevelTooltip = 'Stock getting high';
                                }
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['code']) ?></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?></td>
                                    <td>
                                        <span class="stock-level <?= $stockLevelClass ?>" title="<?= $stockLevelTooltip ?>"></span>
                                        <?= $product['stock'] ?>
                                        <?php if($product['min_stock']): ?>
                                            <small class="text-muted">/ min <?= $product['min_stock'] ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= formatCurrency($product['selling_price']) ?></td>
                                    <td title="Created: <?= formatDateTime($product['created_at']) ?>">
                                        <?= formatDateTime($product['updated_at']) ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= getStatusBadge($product['status']) ?>">
                                            <?= ucfirst(str_replace('_', ' ', $product['status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <a href="edit.php?id=<?= $product['id'] ?>" class="admin-btn admin-btn-primary admin-btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="admin-btn admin-btn-danger admin-btn-sm" 
                                                    onclick="confirmAction('Are you sure you want to delete <?= htmlspecialchars($product['name']) ?>?', 
                                                    () => window.location.href='delete.php?id=<?= $product['id'] ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="admin-btn admin-btn-secondary admin-btn-sm" 
                                                    onclick="viewProductDetails(<?= $product['id'] ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <i class="fas fa-box-open"></i>
                                    <p>No products found</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination would be added here -->
        </div>
    </div>
</div>

<script src="/xy_shop_admin/assets/js/script.js"></script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>