<?php
// Database configuration and connection
$host = 'localhost';
$dbname = 'xy_shop';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize variables
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$payment_filter = isset($_GET['payment']) ? $_GET['payment'] : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

// Build query based on filters
$query = "SELECT * FROM orders WHERE 1=1";
$params = [];

if (!empty($status_filter)) {
    $query .= " AND status = :status";
    $params[':status'] = $status_filter;
}

if (!empty($payment_filter)) {
    $query .= " AND payment_status = :payment";
    $params[':payment'] = $payment_filter;
}

if (!empty($date_from) && !empty($date_to)) {
    $query .= " AND order_date BETWEEN :date_from AND :date_to";
    $params[':date_from'] = $date_from;
    $params[':date_to'] = $date_to;
}

// Execute query
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count orders by status for sidebar badge
$status_counts = [
    'pending' => 0,
    'processing' => 0,
    'shipped' => 0,
    'delivered' => 0,
    'cancelled' => 0
];

$countStmt = $pdo->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status");
while ($row = $countStmt->fetch(PDO::FETCH_ASSOC)) {
    $status_counts[$row['status']] = $row['count'];
}

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $updateStmt = $pdo->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
    $updateStmt->execute([':status' => $new_status, ':order_id' => $order_id]);
    
    // Refresh page to show updated status
    header("Location: orders.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY_SHOP - Orders Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Base Variables */
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #f8961e;
            --info-color: #43aa8b;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --light-gray: #e9ecef;
            --border-color: #dee2e6;
            --card-radius: 10px;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark-color);
            line-height: 1.6;
        }

        /* Admin Container */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 250px;
            background-color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .admin-sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .admin-sidebar-header i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 10px;
        }

        .admin-sidebar-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }

        .admin-sidebar-menu {
            padding: 15px 0;
        }

        .admin-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }

        .admin-menu-item:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .admin-menu-item.active {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border-left: 3px solid var(--primary-color);
        }

        .admin-menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .admin-menu-item span {
            flex-grow: 1;
        }

        .admin-menu-item .fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .admin-menu-item.active .fa-chevron-down {
            transform: rotate(180deg);
        }

        .admin-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background-color: #f9f9f9;
        }

        .admin-submenu.show {
            max-height: 500px;
        }

        .admin-submenu-item {
            display: block;
            padding: 10px 20px 10px 50px;
            color: var(--gray-color);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .admin-submenu-item:hover {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }

        .badge {
            background-color: var(--danger-color);
            color: white;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Status Badges */
        .badge.bg-success {
            background-color: var(--success-color);
        }
        .badge.bg-warning {
            background-color: var(--warning-color);
        }
        .badge.bg-danger {
            background-color: var(--danger-color);
        }
        .badge.bg-info {
            background-color: var(--info-color);
        }
        .badge.bg-primary {
            background-color: var(--primary-color);
        }
        .badge.bg-secondary {
            background-color: var(--gray-color);
        }

        /* Main Content */
        .admin-main {
            flex-grow: 1;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        /* Header */
        .admin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 25px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--gray-color);
            cursor: pointer;
            display: none;
        }

        .admin-title {
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-title i {
            color: var(--primary-color);
        }

        .admin-header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-search-box {
            position: relative;
        }

        .admin-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
        }

        .admin-search-input {
            padding: 8px 15px 8px 35px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            width: 200px;
            transition: all 0.3s ease;
        }

        .admin-search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            width: 250px;
        }

        .admin-notification {
            position: relative;
            cursor: pointer;
        }

        .admin-notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            font-weight: 600;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            position: relative;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.2s ease;
        }

        .admin-user:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .admin-user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background-size: cover;
            background-position: center;
        }

        .admin-user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            box-shadow: var(--shadow-hover);
            border-radius: 5px;
            width: 200px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 100;
        }

        .admin-user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(5px);
        }

        .admin-user-dropdown-item {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .admin-user-dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .admin-user-dropdown-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Content */
        .admin-content {
            padding: 25px;
        }

        /* Cards */
        .admin-card {
            background-color: white;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
            margin-bottom: 25px;
            border: 1px solid var(--border-color);
        }

        .admin-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-card-title i {
            color: var(--primary-color);
        }

        .admin-card-actions {
            display: flex;
            gap: 10px;
        }

        .admin-card-body {
            padding: 20px;
        }

        /* Form Elements */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-col {
            flex: 1;
            min-width: 200px;
        }

        .admin-form-group {
            margin-bottom: 15px;
        }

        .admin-form-label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--dark-color);
        }

        .admin-form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .admin-form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .admin-form-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 1em;
        }

        .admin-form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .date-picker {
            position: relative;
        }

        .date-picker i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
            pointer-events: none;
        }

        /* Buttons */
        .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .admin-btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
        }

        .admin-btn-primary {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .admin-btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .admin-btn-secondary {
            background-color: white;
            color: var(--gray-color);
            border-color: var(--border-color);
        }

        .admin-btn-secondary:hover {
            background-color: #f8f9fa;
            color: var(--dark-color);
        }

        .admin-btn-success {
            background-color: var(--success-color);
            color: white;
            border-color: var(--success-color);
        }

        .admin-btn-success:hover {
            background-color: #3ab7d8;
            border-color: #3ab7d8;
        }

        .admin-btn-danger {
            background-color: var(--danger-color);
            color: white;
            border-color: var(--danger-color);
        }

        .admin-btn-danger:hover {
            background-color: #e51673;
            border-color: #e51673;
        }

        .admin-btn-warning {
            background-color: var(--warning-color);
            color: white;
            border-color: var(--warning-color);
        }

        .admin-btn-warning:hover {
            background-color: #e68a1a;
            border-color: #e68a1a;
        }

        .admin-btn-info {
            background-color: var(--info-color);
            color: white;
            border-color: var(--info-color);
        }

        .admin-btn-info:hover {
            background-color: #3c9680;
            border-color: #3c9680;
        }

        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .admin-table th, 
        .admin-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .admin-table th {
            background-color: var(--light-color);
            color: var(--dark-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .admin-table tr:hover td {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .admin-table-actions {
            display: flex;
            gap: 5px;
        }

        /* Pagination */
        .admin-pagination {
            display: flex;
            justify-content: center;
            padding: 15px;
            border-top: 1px solid var(--border-color);
        }

        .admin-pagination ul {
            display: flex;
            list-style: none;
            gap: 5px;
        }

        .admin-page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 5px;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .admin-page-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .admin-page-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .admin-page-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal */
        .admin-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .admin-modal.show {
            display: flex;
            opacity: 1;
        }

        .admin-modal-content {
            background-color: white;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-hover);
            max-height: 90vh;
            overflow-y: auto;
            width: 90%;
            max-width: 900px;
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .admin-modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 10;
        }

        .admin-modal-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .admin-modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray-color);
            transition: color 0.2s ease;
        }

        .admin-modal-close:hover {
            color: var(--danger-color);
        }

        .admin-modal-body {
            padding: 20px;
        }

        .admin-modal-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            position: sticky;
            bottom: 0;
            background-color: white;
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .admin-sidebar {
                transform: translateX(-100%);
                position: fixed;
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-toggle-sidebar {
                display: block;
            }
        }

        @media (max-width: 992px) {
            .admin-table th, 
            .admin-table td {
                padding: 8px 10px;
            }
        }

        @media (max-width: 768px) {
            .admin-header {
                flex-wrap: wrap;
                gap: 10px;
                padding: 15px;
            }

            .admin-title {
                order: 1;
                width: 100%;
            }

            .admin-toggle-sidebar {
                order: 0;
            }

            .admin-header-actions {
                order: 2;
                margin-left: auto;
            }

            .admin-search-input {
                width: 150px;
            }

            .admin-search-input:focus {
                width: 180px;
            }

            .admin-table-actions {
                flex-direction: column;
                gap: 5px;
            }
        }

        @media (max-width: 576px) {
            .form-col {
                min-width: 100%;
            }

            .admin-modal-footer {
                flex-direction: column;
            }

            .admin-modal-footer .admin-btn {
                width: 100%;
            }
        }

        /* Print Styles */
        @media print {
            .admin-sidebar, .admin-header, .admin-card-actions, .admin-modal-footer {
                display: none !important;
            }
            
            .admin-main {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0 !important;
            }
            
            .admin-card {
                box-shadow: none;
                border: 1px solid #ddd;
                page-break-inside: avoid;
            }

            .admin-table {
                width: 100%;
            }

            .admin-table th {
                background-color: #f1f1f1 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-header">
                <i class="fas fa-store-alt"></i>
                <h3>XY_SHOP Admin</h3>
            </div>
            <div class="admin-sidebar-menu">
                <a href="dashboard.php" class="admin-menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="admin-menu-item" id="productsMenu">
                    <i class="fas fa-box-open"></i>
                    <span>Products</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="admin-submenu" id="productsSubmenu">
                    <a href="products.php" class="admin-submenu-item">All Products</a>
                    <a href="products-add.php" class="admin-submenu-item">Add New</a>
                    <a href="inventory.php" class="admin-submenu-item">Inventory</a>
                    <a href="categories.php" class="admin-submenu-item">Categories</a>
                </div>
                
                <a href="orders.php" class="admin-menu-item active">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                    <span class="badge"><?php echo isset($status_counts['pending']) ? $status_counts['pending'] : 0; ?></span>
                </a>
                
                <a href="customers.php" class="admin-menu-item">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
                
                <a href="reports.php" class="admin-menu-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Reports</span>
                </a>
                
                <a href="settings.php" class="admin-menu-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            <div class="admin-header">
                <button class="admin-toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="admin-title">
                    <i class="fas fa-shopping-cart"></i> Orders Management
                </h1>
                <div class="admin-header-actions">
                    <div class="admin-search-box">
                        <i class="fas fa-search admin-search-icon"></i>
                        <input type="text" class="admin-search-input" placeholder="Search orders..." id="searchOrders">
                    </div>
                    <div class="admin-notification" id="notificationDropdown">
                        <i class="fas fa-bell"></i>
                        <span class="admin-notification-badge">3</span>
                        <div class="admin-user-dropdown notification-dropdown">
                            <a href="#" class="admin-user-dropdown-item"><i class="fas fa-shopping-cart"></i> 2 new orders</a>
                            <a href="#" class="admin-user-dropdown-item"><i class="fas fa-exclamation-circle"></i> 1 low stock item</a>
                            <a href="#" class="admin-user-dropdown-item"><i class="fas fa-user"></i> New customer registered</a>
                        </div>
                    </div>
                    <div class="admin-user" id="userDropdown">
                        <div class="admin-user-avatar" style="background-image: url('https://randomuser.me/api/portraits/men/32.jpg')">SK</div>
                        <span>Shop Keeper</span>
                        <i class="fas fa-chevron-down"></i>
                        <div class="admin-user-dropdown">
                            <a href="#" class="admin-user-dropdown-item"><i class="fas fa-user"></i> Profile</a>
                            <a href="#" class="admin-user-dropdown-item"><i class="fas fa-cog"></i> Settings</a>
                            <a href="#" class="admin-user-dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="admin-content">
                <!-- Order Filters -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title">
                            <i class="fas fa-filter"></i> Filter Orders
                        </h3>
                    </div>
                    <form method="GET" action="orders.php" class="form-row">
                        <div class="form-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Date Range</label>
                                <div class="date-picker">
                                    <input type="date" class="admin-form-control" id="orderDateFrom" name="date_from" value="<?php echo $date_from; ?>">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label">To</label>
                                <div class="date-picker">
                                    <input type="date" class="admin-form-control" id="orderDateTo" name="date_to" value="<?php echo $date_to; ?>">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Status</label>
                                <select class="admin-form-control admin-form-select" id="orderStatusFilter" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="pending" <?php echo ($status_filter == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="processing" <?php echo ($status_filter == 'processing') ? 'selected' : ''; ?>>Processing</option>
                                    <option value="shipped" <?php echo ($status_filter == 'shipped') ? 'selected' : ''; ?>>Shipped</option>
                                    <option value="delivered" <?php echo ($status_filter == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                                    <option value="cancelled" <?php echo ($status_filter == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Payment</label>
                                <select class="admin-form-control admin-form-select" id="paymentStatusFilter" name="payment">
                                    <option value="">All Payments</option>
                                    <option value="paid" <?php echo ($payment_filter == 'paid') ? 'selected' : ''; ?>>Paid</option>
                                    <option value="pending" <?php echo ($payment_filter == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="failed" <?php echo ($payment_filter == 'failed') ? 'selected' : ''; ?>>Failed</option>
                                    <option value="refunded" <?php echo ($payment_filter == 'refunded') ? 'selected' : ''; ?>>Refunded</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <button type="submit" class="admin-btn admin-btn-primary" style="margin-top: 24px;">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Orders List -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title">
                            <i class="fas fa-list"></i> Recent Orders
                        </h3>
                        <div class="admin-card-actions">
                            <button class="admin-btn admin-btn-success" id="exportOrdersBtn">
                                <i class="fas fa-file-export"></i> Export
                            </button>
                            <button class="admin-btn admin-btn-secondary" id="printOrdersBtn">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="admin-table" id="ordersTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($orders) > 0): ?>
                                    <?php foreach($orders as $order): ?>
                                        <tr>
                                            <td>#<?php echo $order['order_id']; ?></td>
                                            <td><?php echo $order['customer_name']; ?></td>
                                            <td><?php echo date('M d, Y h:i A', strtotime($order['order_date'])); ?></td>
                                            <td>RWF <?php echo number_format($order['total_amount'], 2); ?></td>
                                            <td>
                                                <?php 
                                                    $payment_badge_class = '';
                                                    switch($order['payment_status']) {
                                                        case 'paid': $payment_badge_class = 'bg-success'; break;
                                                        case 'pending': $payment_badge_class = 'bg-warning'; break;
                                                        case 'failed': $payment_badge_class = 'bg-danger'; break;
                                                        case 'refunded': $payment_badge_class = 'bg-info'; break;
                                                        default: $payment_badge_class = 'bg-secondary';
                                                    }
                                                ?>
                                                <span class="badge <?php echo $payment_badge_class; ?>"><?php echo ucfirst($order['payment_status']); ?></span>
                                            </td>
                                            <td>
                                                <?php 
                                                    $status_badge_class = '';
                                                    switch($order['status']) {
                                                        case 'pending': $status_badge_class = 'bg-warning'; break;
                                                        case 'processing': $status_badge_class = 'bg-info'; break;
                                                        case 'shipped': $status_badge_class = 'bg-primary'; break;
                                                        case 'delivered': $status_badge_class = 'bg-success'; break;
                                                        case 'cancelled': $status_badge_class = 'bg-danger'; break;
                                                        default: $status_badge_class = 'bg-secondary';
                                                    }
                                                ?>
                                                <span class="badge <?php echo $status_badge_class; ?>"><?php echo ucfirst($order['status']); ?></span>
                                            </td>
                                            <td>
                                                <div class="admin-table-actions">
                                                    <button class="admin-btn admin-btn-primary admin-btn-sm" onclick="viewOrderDetails('<?php echo $order['order_id']; ?>')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <?php if ($order['status'] == 'pending' || $order['status'] == 'processing'): ?>
                                                        <form method="POST" style="display: inline;">
                                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                            <input type="hidden" name="new_status" value="shipped">
                                                            <button type="submit" class="admin-btn admin-btn-success admin-btn-sm">
                                                                <i class="fas fa-truck"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <?php if ($order['status'] == 'shipped'): ?>
                                                        <form method="POST" style="display: inline;">
                                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                            <input type="hidden" name="new_status" value="delivered">
                                                            <button type="submit" class="admin-btn admin-btn-success admin-btn-sm">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <?php if ($order['status'] != 'cancelled' && $order['status'] != 'delivered'): ?>
                                                        <form method="POST" style="display: inline;">
                                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                            <input type="hidden" name="new_status" value="cancelled">
                                                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <?php if ($order['status'] == 'cancelled'): ?>
                                                        <form method="POST" style="display: inline;">
                                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                            <input type="hidden" name="new_status" value="pending">
                                                            <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm">
                                                                <i class="fas fa-redo"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No orders found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="admin-pagination">
                        <ul>
                            <li><a href="#" class="admin-page-link disabled"><i class="fas fa-chevron-left"></i></a></li>
                            <li><a href="#" class="admin-page-link active">1</a></li>
                            <li><a href="#" class="admin-page-link">2</a></li>
                            <li><a href="#" class="admin-page-link">3</a></li>
                            <li><a href="#" class="admin-page-link"><i class="fas fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="admin-modal" id="orderModal">
        <div class="admin-modal-content">
            <div class="admin-modal-header">
                <h3 class="admin-modal-title">Order Details - #ORD-2023-101</h3>
                <button class="admin-modal-close" id="closeOrderModal">&times;</button>
            </div>
            <div class="admin-modal-body">
                <div class="form-row">
                    <div class="form-col">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h4 class="admin-card-title">
                                    <i class="fas fa-info-circle"></i> Order Information
                                </h4>
                            </div>
                            <div class="admin-card-body">
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Order Date</label>
                                    <p>October 15, 2023 10:30 AM</p>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Customer</label>
                                    <p>John Doe (john.doe@example.com)</p>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Payment Method</label>
                                    <p>Mobile Money (MTN)</p>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Payment Status</label>
                                    <p><span class="badge bg-success">Paid</span></p>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Order Status</label>
                                    <div class="form-row" style="align-items: center;">
                                        <div class="form-col">
                                            <select class="admin-form-control admin-form-select">
                                                <option>Pending</option>
                                                <option selected>Processing</option>
                                                <option>Shipped</option>
                                                <option>Delivered</option>
                                                <option>Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="form-col">
                                            <button class="admin-btn admin-btn-primary admin-btn-sm">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h4 class="admin-card-title">
                                    <i class="fas fa-map-marker-alt"></i> Shipping Information
                                </h4>
                            </div>
                            <div class="admin-card-body">
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Shipping Address</label>
                                    <p>123 Main Street, Kigali, Rwanda</p>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Phone Number</label>
                                    <p>+250 78 123 4567</p>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Shipping Method</label>
                                    <p>Standard Delivery (3-5 business days)</p>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Tracking Number</label>
                                    <div class="form-row" style="align-items: center;">
                                        <div class="form-col">
                                            <input type="text" class="admin-form-control" placeholder="Enter tracking number">
                                        </div>
                                        <div class="form-col">
                                            <button class="admin-btn admin-btn-primary admin-btn-sm">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-col">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h4 class="admin-card-title">
                                    <i class="fas fa-shopping-cart"></i> Order Items
                                </h4>
                            </div>
                            <div class="admin-card-body">
                                <div class="table-responsive">
                                    <table class="admin-table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <img src="https://via.placeholder.com/50" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                                        <div>
                                                            <div>Smartphone X Pro</div>
                                                            <small class="text-muted">Color: Black, Storage: 128GB</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>RWF 550,000</td>
                                                <td>1</td>
                                                <td>RWF 550,000</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <img src="https://via.placeholder.com/50" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                                        <div>
                                                            <div>Wireless Headphones</div>
                                                            <small class="text-muted">Color: White</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>RWF 120,000</td>
                                                <td>1</td>
                                                <td>RWF 120,000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div style="border-top: 1px solid var(--border-color); margin-top: 20px; padding-top: 20px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                        <span>Subtotal:</span>
                                        <span>RWF 670,000</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                        <span>Shipping:</span>
                                        <span>RWF 5,000</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                        <span>Tax:</span>
                                        <span>RWF 67,000</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.1rem;">
                                        <span>Total:</span>
                                        <span>RWF 742,000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h4 class="admin-card-title">
                                    <i class="fas fa-comment-alt"></i> Customer Notes
                                </h4>
                            </div>
                            <div class="admin-card-body">
                                <div class="admin-form-group">
                                    <textarea class="admin-form-control admin-form-textarea" placeholder="No notes from customer"></textarea>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label">Private Notes</label>
                                    <textarea class="admin-form-control admin-form-textarea" placeholder="Add private notes here..."></textarea>
                                </div>
                                <button class="admin-btn admin-btn-primary">
                                    Save Notes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="admin-modal-footer">
                <button class="admin-btn admin-btn-secondary" id="cancelOrderModal">Close</button>
                <button class="admin-btn admin-btn-success">
                    <i class="fas fa-check"></i> Mark as Completed
                </button>
                <button class="admin-btn admin-btn-danger">
                    <i class="fas fa-times"></i> Cancel Order
                </button>
                <button class="admin-btn admin-btn-primary">
                    <i class="fas fa-print"></i> Print Invoice
                </button>
            </div>
        </div>
    </div>

    <script>
        // DOM Content Loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar on mobile
            const toggleSidebar = document.getElementById('toggleSidebar');
            const adminSidebar = document.getElementById('adminSidebar');
            
            toggleSidebar.addEventListener('click', function() {
                adminSidebar.classList.toggle('show');
            });

            // User dropdown
            const userDropdown = document.getElementById('userDropdown');
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdown = this.querySelector('.admin-user-dropdown');
                dropdown.classList.toggle('show');
            });

            // Notification dropdown
            const notificationDropdown = document.getElementById('notificationDropdown');
            notificationDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdown = this.querySelector('.notification-dropdown');
                dropdown.classList.toggle('show');
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.admin-user-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            });

            // Order modal functionality
            const orderModal = document.getElementById('orderModal');
            const closeOrderModal = document.getElementById('closeOrderModal');
            const cancelOrderModal = document.getElementById('cancelOrderModal');
            
            function viewOrderDetails(orderId) {
                // In a real implementation, this would fetch order data via AJAX
                // and populate the modal with the specific order details
                orderModal.classList.add('show');
                
                // Update modal title with order ID
                document.querySelector('.admin-modal-title').textContent = `Order Details - #${orderId}`;
            }
            
            closeOrderModal.addEventListener('click', function() {
                orderModal.classList.remove('show');
            });
            
            cancelOrderModal.addEventListener('click', function() {
                orderModal.classList.remove('show');
            });

            // Export orders
            document.getElementById('exportOrdersBtn').addEventListener('click', function() {
                alert('Exporting orders to CSV...');
                // In a real implementation, this would trigger a CSV export
            });

            // Print orders
            document.getElementById('printOrdersBtn').addEventListener('click', function() {
                window.print();
            });
            
            // Live search functionality
            const searchInput = document.getElementById('searchOrders');
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#ordersTable tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        });
    </script>
</body>
</html>