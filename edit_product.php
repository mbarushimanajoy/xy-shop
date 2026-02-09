<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "xy_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product data
$product = null;
if($product_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $sku = $_POST['sku'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    
    // Handle image upload
    $image = $product['image']; // Keep existing image by default
    
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/products/";
        if(!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid('product_', true) . '.' . $file_ext;
        $target_file = $target_dir . $new_filename;
        
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Delete old image if it exists
            if(!empty($product['image']) && file_exists($product['image'])) {
                unlink($product['image']);
            }
            $image = $target_file;
        }
    }
    
    // Update product in database
    $stmt = $conn->prepare("UPDATE products SET name=?, sku=?, category=?, price=?, quantity=?, description=?, status=?, image=? WHERE id=?");
    $stmt->bind_param("sssdissi", $name, $sku, $category, $price, $quantity, $description, $status, $image, $product_id);
    
    if($stmt->execute()) {
        $success_message = "Product updated successfully!";
        // Refresh product data
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    } else {
        $error_message = "Error updating product: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();

// Redirect if product not found
if(!$product && $product_id > 0) {
    header("Location: products.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - XY_SHOP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #004b63;
            --secondary-color: darkcyan;
            --accent-color: #ff6b6b;
            --light-bg: #f8f9fa;
            --dark-bg: #002f3f;
            --text-light: #ffffff;
            --text-dark: #333333;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }
        
        .navbar {
            height: 70px;
            background-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .logo {
            height: 40px;
            margin-right: 10px;
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-light);
        }
        
        .main-container {
            padding: 2rem;
            margin-top: 20px;
        }
        
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .page-title {
            font-size: 1.8rem;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px 8px 0 0 !important;
            padding: 1.2rem;
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary-custom:hover {
            background-color: #003b50;
            border-color: #003b50;
        }
        
        .btn-outline-secondary {
            border-color: #dee2e6;
        }
        
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            display: block;
            margin-top: 10px;
            border-radius: 4px;
        }
        
        .form-label {
            font-weight: 500;
        }
        
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a href="dashboard.php" class="logo-link">
                <img src="xy/logo.png" alt="XY_SHOP Logo" class="logo">
                <span class="logo-text">XY_SHOP</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="categories.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reports.php">Reports</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-container">
        <div class="page-header">
            <h1 class="page-title">Edit Product</h1>
        </div>
        
        <!-- Alert Messages -->
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if($product): ?>
        <!-- Product Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="edit_product.php?id=<?php echo $product_id; ?>" enctype="multipart/form-data">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label required-field">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required 
                                       value="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="sku" class="form-label required-field">SKU</label>
                                <input type="text" class="form-control" id="sku" name="sku" required
                                       value="<?php echo htmlspecialchars($product['sku']); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label required-field">Category</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Men's Clothing" <?php echo ($product['category'] == "Men's Clothing") ? 'selected' : ''; ?>>Men's Clothing</option>
                                    <option value="Women's Clothing" <?php echo ($product['category'] == "Women's Clothing") ? 'selected' : ''; ?>>Women's Clothing</option>
                                    <option value="Accessories" <?php echo ($product['category'] == "Accessories") ? 'selected' : ''; ?>>Accessories</option>
                                    <option value="Footwear" <?php echo ($product['category'] == "Footwear") ? 'selected' : ''; ?>>Footwear</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label required-field">Price (RWF)</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" required
                                       value="<?php echo htmlspecialchars($product['price']); ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity" class="form-label required-field">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required
                                       value="<?php echo htmlspecialchars($product['quantity']); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label required-field">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" <?php echo ($product['status'] == "active") ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($product['status'] == "inactive") ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Product Image</label>
                                <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image</small>
                                <?php if(!empty($product['image'])): ?>
                                    <div class="mt-2">
                                        <img src="<?php echo $product['image']; ?>" class="preview-image" id="currentImage">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="removeImage" name="remove_image">
                                            <label class="form-check-label" for="removeImage">
                                                Remove current image
                                            </label>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div id="imagePreview"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <a href="products.php" class="btn btn-outline-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            Product not found.
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if(this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-image';
                    preview.appendChild(img);
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Handle remove image checkbox
        document.getElementById('removeImage')?.addEventListener('change', function() {
            const currentImage = document.getElementById('currentImage');
            if(this.checked) {
                currentImage.style.opacity = '0.5';
                currentImage.style.border = '2px solid red';
            } else {
                currentImage.style.opacity = '1';
                currentImage.style.border = 'none';
            }
        });
    </script>
</body>
</html>