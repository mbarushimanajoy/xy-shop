<?php
require_once 'config.php';
requireLogin();

// Handle stock in/out
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productCode = $_POST['product_code'];
    $quantity = $_POST['quantity'];
    $unitPrice = $_POST['unit_price'];
    $dateTime = $_POST['date_time'];
    $type = $_POST['type'];
    
    $totalPrice = $quantity * $unitPrice;
    
    try {
        if ($type == 'in') {
            $stmt = $pdo->prepare("INSERT INTO Production (ProductCode, DateTime, Quantity, UnitPrice, TotalPrice) VALUES (?, ?, ?, ?, ?)");
        } else {
            $stmt = $pdo->prepare("INSERT INTO ProductOut (ProductCode, DateTime, Quantity, UnitPrice, TotalPrice) VALUES (?, ?, ?, ?, ?)");
        }
        
        $stmt->execute([$productCode, $dateTime, $quantity, $unitPrice, $totalPrice]);
        
        $_SESSION['message'] = "Stock " . ($type == 'in' ? 'in' : 'out') . " recorded successfully";
        $_SESSION['message_type'] = "success";
        header("Location: stock.php");
        exit();
    } catch (PDOException $e) {
        $error = "Error recording stock: " . $e->getMessage();
    }
}

// Get all products for dropdown
$products = $pdo->query("SELECT * FROM Product")->fetchAll();

// Get recent stock movements
$stockIn = $pdo->query("SELECT p.*, pr.ProductName FROM Production p JOIN Product pr ON p.ProductCode = pr.ProductCode ORDER BY p.DateTime DESC LIMIT 10")->fetchAll();
$stockOut = $pdo->query("SELECT p.*, pr.ProductName FROM ProductOut p JOIN Product pr ON p.ProductCode = pr.ProductCode ORDER BY p.DateTime DESC LIMIT 10")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY Shop - Stock Management</title>
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
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="admin-alert admin-alert-<?php echo $_SESSION['message_type']; ?>">
                        <i class="fas fa-<?php echo $_SESSION['message_type'] == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
                <?php endif; ?>
                
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title">
                            <i class="fas fa-exchange-alt"></i> Stock Management
                        </h3>
                    </div>
                    
                    <div class="admin-tabs">
                        <div class="admin-tab active" data-tab="stock-in">Stock In</div>
                        <div class="admin-tab" data-tab="stock-out">Stock Out</div>
                    </div>
                    
                    <div class="admin-tab-content active" id="stock-in-tab">
                        <form method="POST" action="stock.php">
                            <input type="hidden" name="type" value="in">
                            
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label required">Product</label>
                                        <select name="product_code" class="admin-form-control admin-form-select" required>
                                            <option value="">Select Product</option>
                                            <?php foreach ($products as $product): ?>
                                                <option value="<?php echo $product['ProductCode']; ?>"><?php echo $product['ProductName']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label required">Quantity</label>
                                        <input type="number" name="quantity" class="admin-form-control" min="1" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label required">Unit Price (RWF)</label>
                                        <input type="number" name="unit_price" class="admin-form-control" step="0.01" min="0" required>
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label required">Date & Time</label>
                                        <div class="date-picker">
                                            <input type="datetime-local" name="date_time" class="admin-form-control" required>
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-group">
                                <button type="submit" class="admin-btn admin-btn-primary">
                                    <i class="fas fa-arrow-down"></i> Record Stock In
                                </button>
                            </div>
                        </form>
                        
                        <h4 style="margin: 20px 0 10px;">Recent Stock In</h4>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stockIn as $item): ?>
                                    <tr>
                                        <td><?php echo $item['ProductName']; ?></td>
                                        <td><?php echo $item['Quantity']; ?></td>
                                        <td>RWF <?php echo number_format($item['UnitPrice'], 2); ?></td>
                                        <td>RWF <?php echo number_format($item['TotalPrice'], 2); ?></td>
                                        <td><?php echo date('M d, Y h:i A', strtotime($item['DateTime'])); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="admin-tab-content" id="stock-out-tab">
                        <form method="POST" action="stock.php">
                            <input type="hidden" name="type" value="out">
                            
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label required">Product</label>
                                        <select name="product_code" class="admin-form-control admin-form-select" required>
                                            <option value="">Select Product</option>
                                            <?php foreach ($products as $product): ?>
                                                <option value="<?php echo $product['ProductCode']; ?>"><?php echo $product['ProductName']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label required">Quantity</label>
                                        <input type="number" name="quantity" class="admin-form-control" min="1" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label required">Unit Price (RWF)</label>
                                        <input type="number" name="unit_price" class="admin-form-control" step="0.01" min="0" required>
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label required">Date & Time</label>
                                        <div class="date-picker">
                                            <input type="datetime-local" name="date_time" class="admin-form-control" required>
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-group">
                                <button type="submit" class="admin-btn admin-btn-primary">
                                    <i class="fas fa-arrow-up"></i> Record Stock Out
                                </button>
                            </div>
                        </form>
                        
                        <h4 style="margin: 20px 0 10px;">Recent Stock Out</h4>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stockOut as $item): ?>
                                    <tr>
                                        <td><?php echo $item['ProductName']; ?></td>
                                        <td><?php echo $item['Quantity']; ?></td>
                                        <td>RWF <?php echo number_format($item['UnitPrice'], 2); ?></td>
                                        <td>RWF <?php echo number_format($item['TotalPrice'], 2); ?></td>
                                        <td><?php echo date('M d, Y h:i A', strtotime($item['DateTime'])); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        <?php include 'admin.js'; ?>
        
        // Tab switching functionality
        document.querySelectorAll('.admin-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.admin-tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(`${tabId}-tab`).classList.add('active');
            });
        });
    </script>
</body>
</html>