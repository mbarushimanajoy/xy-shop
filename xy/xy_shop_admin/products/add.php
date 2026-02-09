<?php
require_once __DIR__ . '/../../includes/header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $name = sanitizeInput($_POST['name']);
    $code = sanitizeInput($_POST['code']) ?: generateProductCode($name);
    $barcode = sanitizeInput($_POST['barcode']);
    $category_id = intval($_POST['category_id']);
    $description = sanitizeInput($_POST['description']);
    $stock = intval($_POST['stock']);
    $min_stock = !empty($_POST['min_stock']) ? intval($_POST['min_stock']) : null;
    $max_stock = !empty($_POST['max_stock']) ? intval($_POST['max_stock']) : null;
    $purchase_price = !empty($_POST['purchase_price']) ? floatval($_POST['purchase_price']) : null;
    $selling_price = floatval($_POST['selling_price']);
    $status = sanitizeInput($_POST['status']);
    
    // Handle image upload
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../../uploads/products/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $file_ext;
        $destination = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $image_path = '/xy_shop_admin/uploads/products/' . $filename;
        }
    }
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO products (code, barcode, name, description, category_id, stock, min_stock, 
                           max_stock, purchase_price, selling_price, status, image) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiiiiddss", $code, $barcode, $name, $description, $category_id, $stock, $min_stock, 
                     $max_stock, $purchase_price, $selling_price, $status, $image_path);
    
    if ($stmt->execute()) {
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Product added successfully'];
        redirect('/xy_shop_admin/products/');
    } else {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'Failed to add product'];
    }
}

// Get categories for dropdown
$categories = $conn->query("SELECT * FROM categories ORDER BY name");
?>

<div class="admin-content">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Add New Product</h3>
        </div>
        <div class="admin-card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Product Code <span class="text-muted">(Auto-generated if empty)</span></label>
                            <input type="text" class="admin-form-control" name="code" id="productCode">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Barcode</label>
                            <input type="text" class="admin-form-control" name="barcode" id="productBarcode">
                            <div class="barcode-preview" id="barcodePreview"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Product Name *</label>
                            <input type="text" class="admin-form-control" name="name" id="productName" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Category *</label>
                            <select class="admin-form-control" name="category_id" id="productCategory" required>
                                <option value="">Select Category</option>
                                <?php while($category = $categories->fetch_assoc()): ?>
                                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Description</label>
                    <textarea class="admin-form-control" rows="3" name="description" id="productDescription"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Current Stock *</label>
                            <input type="number" class="admin-form-control" name="stock" id="productStock" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Purchase Price (RWF)</label>
                            <input type="number" step="0.01" class="admin-form-control" name="purchase_price" id="productPurchasePrice">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Selling Price (RWF) *</label>
                            <input type="number" step="0.01" class="admin-form-control" name="selling_price" id="productSellingPrice" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Minimum Stock Level</label>
                            <input type="number" class="admin-form-control" name="min_stock" id="productMinStock">
                            <small class="text-muted">System will alert when stock reaches this level</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Maximum Stock Level</label>
                            <input type="number" class="admin-form-control" name="max_stock" id="productMaxStock">
                            <small class="text-muted">Recommended maximum quantity to keep in stock</small>
                        </div>
                    </div>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Product Image</label>
                    <input type="file" class="admin-form-control" name="image" id="productImage" accept="image/*">
                    <div class="image-preview-container" id="imagePreviewContainer"></div>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Status *</label>
                    <select class="admin-form-control" name="status" id="productStatus" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <button type="submit" class="admin-btn admin-btn-primary">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                    <a href="/xy_shop_admin/products/" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/xy_shop_admin/assets/js/script.js"></script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>