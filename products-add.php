<?php
require_once 'config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productCode = $_POST['product_code'];
    $productName = $_POST['product_name'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO Product (ProductCode, ProductName) VALUES (?, ?)");
        $stmt->execute([$productCode, $productName]);
        
        $_SESSION['message'] = "Product added successfully";
        $_SESSION['message_type'] = "success";
        header("Location: products.php");
        exit();
    } catch (PDOException $e) {
        $error = "Error adding product: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY Shop - Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        <?php include 'admin.css'; ?>
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            <?php include 'header.php'; ?>

            <!-- Content -->
            <div class="admin-content">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title">
                            <i class="fas fa-plus"></i> Add New Product
                        </h3>
                        <div class="admin-card-actions">
                            <a href="products.php" class="admin-btn admin-btn-secondary admin-btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Products
                            </a>
                        </div>
                    </div>
                    
                    <form method="POST" action="products-add.php">
                        <div class="form-row">
                            <div class="form-col">
                                <div class="admin-form-group">
                                    <label class="admin-form-label required">Product Code</label>
                                    <input type="text" name="product_code" class="admin-form-control" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="admin-form-group">
                                    <label class="admin-form-label required">Product Name</label>
                                    <input type="text" name="product_name" class="admin-form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (isset($error)): ?>
                            <div class="admin-alert admin-alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="admin-form-group">
                            <button type="submit" class="admin-btn admin-btn-primary">
                                <i class="fas fa-save"></i> Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        <?php include 'admin.js'; ?>
    </script>
</body>
</html>