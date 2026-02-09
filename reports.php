<?php
// Database connection
require_once 'config.php';

// Initialize variables
$dateRange = isset($_GET['date_range']) ? $_GET['date_range'] : 'month';
$reportType = isset($_GET['report_type']) ? $_GET['report_type'] : 'sales';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

// Process date range selection
switch ($dateRange) {
    case 'today':
        $startDate = $endDate = date('Y-m-d');
        break;
    case 'yesterday':
        $startDate = $endDate = date('Y-m-d', strtotime('-1 day'));
        break;
    case 'week':
        $startDate = date('Y-m-d', strtotime('monday this week'));
        $endDate = date('Y-m-d', strtotime('sunday this week'));
        break;
    case 'quarter':
        $currentMonth = date('n');
        $currentYear = date('Y');
        if($currentMonth >= 1 && $currentMonth <= 3) {
            $startDate = $currentYear . '-01-01';
            $endDate = $currentYear . '-03-31';
        } elseif($currentMonth >= 4 && $currentMonth <= 6) {
            $startDate = $currentYear . '-04-01';
            $endDate = $currentYear . '-06-30';
        } elseif($currentMonth >= 7 && $currentMonth <= 9) {
            $startDate = $currentYear . '-07-01';
            $endDate = $currentYear . '-09-30';
        } elseif($currentMonth >= 10 && $currentMonth <= 12) {
            $startDate = $currentYear . '-10-01';
            $endDate = $currentYear . '-12-31';
        }
        break;
    case 'year':
        $startDate = date('Y-01-01');
        $endDate = date('Y-12-31');
        break;
    case 'custom':
        // Use the provided dates
        break;
    default: // month
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');
}

// Fetch report data based on type
$salesData = [];
$productsData = [];
$customersData = [];
$inventoryData = [];

try {
    // Sales Report Data
    $stmt = $pdo->prepare("
        SELECT 
            DATE_FORMAT(order_date, '%Y-%m-%d') AS day,
            COUNT(*) AS order_count,
            SUM(total_amount) AS total_sales,
            AVG(total_amount) AS avg_order
        FROM orders
        WHERE order_date BETWEEN ? AND ?
        GROUP BY day
        ORDER BY day
    ");
    $stmt->execute([$startDate, $endDate]);
    $salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate totals for sales
    $totalSales = 0;
    $totalOrders = 0;
    foreach ($salesData as $sale) {
        $totalSales += $sale['total_sales'];
        $totalOrders += $sale['order_count'];
    }
    $avgOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

    // Top Products Data
    $stmt = $pdo->prepare("
        SELECT 
            p.product_id,
            p.name AS product_name,
            c.name AS category_name,
            SUM(oi.quantity) AS quantity_sold,
            SUM(oi.quantity * oi.unit_price) AS revenue,
            (SUM(oi.quantity * oi.unit_price) / (SELECT SUM(total_amount) FROM orders WHERE order_date BETWEEN ? AND ?)) * 100 AS percentage_of_total
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        JOIN categories c ON p.category_id = c.category_id
        JOIN orders o ON oi.order_id = o.order_id
        WHERE o.order_date BETWEEN ? AND ?
        GROUP BY p.product_id
        ORDER BY revenue DESC
        LIMIT 10
    ");
    $stmt->execute([$startDate, $endDate, $startDate, $endDate]);
    $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Customers Data
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(*) AS total_customers,
            SUM(CASE WHEN registration_date BETWEEN ? AND ? THEN 1 ELSE 0 END) AS new_customers,
            AVG((SELECT SUM(total_amount) FROM orders WHERE customer_id = c.customer_id AND order_date BETWEEN ? AND ?)) AS avg_spend,
            AVG((SELECT COUNT(*) FROM orders WHERE customer_id = c.customer_id AND order_date BETWEEN ? AND ?)) AS avg_orders
        FROM customers c
    ");
    $stmt->execute([$startDate, $endDate, $startDate, $endDate, $startDate, $endDate]);
    $customersData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Inventory Data
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(*) AS total_products,
            SUM(CASE WHEN stock_quantity <= min_stock_level AND stock_quantity > 0 THEN 1 ELSE 0 END) AS low_stock_items,
            SUM(CASE WHEN stock_quantity = 0 THEN 1 ELSE 0 END) AS out_of_stock,
            SUM(stock_quantity * purchase_price) AS inventory_value
        FROM products
    ");
    $stmt->execute();
    $inventoryData = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Function to format currency
function formatCurrency($amount) {
    return 'RWF ' . number_format($amount, 0, '.', ',');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY_SHOP - Reports Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
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
            --card-radius: 12px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 10px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: var(--dark-color);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Admin Container */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background-color: white;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
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
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-right: 12px;
        }

        .admin-sidebar-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            color: var(--dark-color);
        }

        .admin-sidebar-menu {
            padding: 15px 0;
        }

        .admin-menu-item {
            display: flex;
            align-items: center;
            padding: 14px 24px;
            color: var(--dark-color);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .admin-menu-item:hover {
            background-color: rgba(67, 97, 238, 0.08);
            color: var(--primary-color);
        }

        .admin-menu-item.active {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border-left: 4px solid var(--primary-color);
            font-weight: 600;
        }

        .admin-menu-item i {
            margin-right: 12px;
            width: 22px;
            text-align: center;
            font-size: 1.1rem;
        }

        .admin-menu-item span {
            flex-grow: 1;
        }

        .admin-menu-item .fa-chevron-down {
            transition: transform 0.3s ease;
            font-size: 0.9rem;
        }

        .admin-menu-item.active .fa-chevron-down {
            transform: rotate(180deg);
        }

        .admin-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            background-color: #f9f9f9;
        }

        .admin-submenu.show {
            max-height: 500px;
        }

        .admin-submenu-item {
            display: block;
            padding: 12px 24px 12px 60px;
            color: var(--gray-color);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .admin-submenu-item:hover {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }

        .badge {
            background-color: var(--danger-color);
            color: white;
            border-radius: 10px;
            padding: 3px 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Main Content */
        .admin-main {
            flex-grow: 1;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }

        /* Header */
        .admin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 30px;
            background-color: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--gray-color);
            cursor: pointer;
            display: none;
            transition: var(--transition);
        }

        .admin-toggle-sidebar:hover {
            color: var(--primary-color);
        }

        .admin-title {
            font-size: 1.6rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--dark-color);
        }

        .admin-title i {
            color: var(--primary-color);
            font-size: 1.4rem;
        }

        .admin-header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-search-box {
            position: relative;
        }

        .admin-search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
            font-size: 1rem;
        }

        .admin-search-input {
            padding: 10px 18px 10px 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 220px;
            transition: var(--transition);
            font-size: 0.95rem;
            background-color: #f8fafc;
        }

        .admin-search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            width: 260px;
            background-color: white;
        }

        .admin-notification {
            position: relative;
            cursor: pointer;
            color: var(--gray-color);
            transition: var(--transition);
            font-size: 1.2rem;
        }

        .admin-notification:hover {
            color: var(--primary-color);
        }

        .admin-notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            position: relative;
            padding: 8px 12px;
            border-radius: 8px;
            transition: var(--transition);
        }

        .admin-user:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .admin-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background-size: cover;
            background-position: center;
            font-size: 0.95rem;
        }

        .admin-user-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .admin-user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            box-shadow: var(--shadow-hover);
            border-radius: 8px;
            width: 220px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 100;
        }

        .admin-user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(8px);
        }

        .admin-user-dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px 18px;
            color: var(--dark-color);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .admin-user-dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .admin-user-dropdown-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        /* Content */
        .admin-content {
            padding: 30px;
        }

        .admin-card {
            background-color: white;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .admin-card:hover {
            box-shadow: var(--shadow-hover);
        }

        .admin-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-card-title {
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--dark-color);
        }

        .admin-card-title i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .admin-card-actions {
            display: flex;
            gap: 12px;
        }

        /* Form Elements */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .form-col {
            flex: 1;
            min-width: 220px;
        }

        .admin-form-group {
            margin-bottom: 18px;
        }

        .admin-form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .admin-form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: var(--transition);
            background-color: #f8fafc;
        }

        .admin-form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            background-color: white;
        }

        .admin-form-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 1em;
        }

        .date-picker {
            position: relative;
        }

        .date-picker i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
            pointer-events: none;
            font-size: 1rem;
        }

        /* Buttons */
        .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .admin-btn-sm {
            padding: 8px 14px;
            font-size: 0.9rem;
        }

        .admin-btn-primary {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .admin-btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .admin-btn-secondary {
            background-color: white;
            color: var(--gray-color);
            border-color: var(--border-color);
        }

        .admin-btn-secondary:hover {
            background-color: #f8f9fa;
            color: var(--dark-color);
            border-color: var(--gray-color);
        }

        .admin-btn-success {
            background-color: var(--success-color);
            color: white;
            border-color: var(--success-color);
        }

        .admin-btn-success:hover {
            background-color: #3ab7d8;
            border-color: #3ab7d8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 201, 240, 0.2);
        }

        /* Report Cards */
        .report-card {
            background-color: white;
            border-radius: var(--card-radius);
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .report-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border-color);
        }

        .report-card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .report-card-title i {
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        .report-card-body {
            min-height: 300px;
        }

        /* Charts */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Report Summary */
        .report-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            margin-top: 30px;
        }

        .report-summary-item {
            flex: 1;
            min-width: 200px;
            background-color: white;
            padding: 24px;
            border-radius: var(--card-radius);
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .report-summary-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .report-summary-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-color);
            margin: 12px 0;
            line-height: 1.2;
        }

        .report-summary-label {
            color: var(--gray-color);
            font-size: 0.95rem;
            font-weight: 600;
        }

        /* Tables */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
            border-radius: var(--card-radius);
            overflow: hidden;
        }

        .report-table th, 
        .report-table td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .report-table th {
            background-color: var(--light-color);
            color: var(--dark-color);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .report-table tr:last-child td {
            border-bottom: none;
        }

        .report-table tr:hover td {
            background-color: rgba(67, 97, 238, 0.05);
        }

        /* Progress Bars */
        .progress-container {
            width: 100%;
            height: 8px;
            background-color: var(--light-gray);
            border-radius: 4px;
            margin: 8px 0;
            display: inline-block;
            vertical-align: middle;
        }

        .progress-bar {
            height: 100%;
            border-radius: 4px;
            background-color: var(--primary-color);
            transition: width 0.6s ease;
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
            .report-summary-item {
                min-width: calc(50% - 12px);
            }
            
            .admin-content {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .report-card {
                padding: 24px 18px;
            }
            
            .report-summary-item {
                min-width: 100%;
            }
            
            .report-table th, 
            .report-table td {
                padding: 10px 12px;
            }

            .admin-header {
                flex-wrap: wrap;
                gap: 12px;
                padding: 15px;
            }

            .admin-title {
                order: 1;
                width: 100%;
                font-size: 1.4rem;
            }

            .admin-toggle-sidebar {
                order: 0;
            }

            .admin-header-actions {
                order: 2;
                margin-left: auto;
            }

            .admin-search-input {
                width: 180px;
            }

            .admin-search-input:focus {
                width: 200px;
            }
        }

        @media (max-width: 576px) {
            .report-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .admin-card-actions {
                align-self: flex-start;
            }

            .form-col {
                min-width: 100%;
            }
            
            .report-summary-value {
                font-size: 1.8rem;
            }
        }

        /* Print Styles */
        @media print {
            .admin-sidebar, .admin-header, .admin-card-actions {
                display: none !important;
            }
            
            .admin-main {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0 !important;
            }
            
            .report-card {
                box-shadow: none;
                border: 1px solid #ddd;
                page-break-inside: avoid;
                margin-bottom: 20px !important;
            }

            .report-summary-item {
                box-shadow: none;
                border: 1px solid #ddd;
                page-break-inside: avoid;
            }
            
            .report-summary {
                page-break-before: avoid;
            }
            
            @page {
                size: A4 landscape;
                margin: 1cm;
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
                
                <a href="orders.php" class="admin-menu-item">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                    <span class="badge">5</span>
                </a>
                
                <a href="customers.php" class="admin-menu-item">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
                
                <a href="reports.php" class="admin-menu-item active">
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
                    <i class="fas fa-chart-line"></i> Reports Dashboard
                </h1>
                <div class="admin-header-actions">
                    <div class="admin-search-box">
                        <i class="fas fa-search admin-search-icon"></i>
                        <input type="text" class="admin-search-input" placeholder="Search reports...">
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
                        <span class="admin-user-name">Shop Keeper</span>
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
                <!-- Report Filters -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title">
                            <i class="fas fa-filter"></i> Report Filters
                        </h3>
                    </div>
                    <form method="GET" action="reports.php" class="form-row">
                        <div class="form-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Date Range</label>
                                <select class="admin-form-control admin-form-select" name="date_range" id="reportDateRange">
                                    <option value="today" <?= $dateRange === 'today' ? 'selected' : '' ?>>Today</option>
                                    <option value="yesterday" <?= $dateRange === 'yesterday' ? 'selected' : '' ?>>Yesterday</option>
                                    <option value="week" <?= $dateRange === 'week' ? 'selected' : '' ?>>This Week</option>
                                    <option value="month" <?= $dateRange === 'month' ? 'selected' : '' ?>>This Month</option>
                                    <option value="quarter" <?= $dateRange === 'quarter' ? 'selected' : '' ?>>This Quarter</option>
                                    <option value="year" <?= $dateRange === 'year' ? 'selected' : '' ?>>This Year</option>
                                    <option value="custom" <?= $dateRange === 'custom' ? 'selected' : '' ?>>Custom Range</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-col" id="customDateFromCol" style="display: <?= $dateRange === 'custom' ? 'block' : 'none' ?>;">
                            <div class="admin-form-group">
                                <label class="admin-form-label">From</label>
                                <div class="date-picker">
                                    <input type="date" class="admin-form-control" name="start_date" id="reportDateFrom" value="<?= $startDate ?>">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-col" id="customDateToCol" style="display: <?= $dateRange === 'custom' ? 'block' : 'none' ?>;">
                            <div class="admin-form-group">
                                <label class="admin-form-label">To</label>
                                <div class="date-picker">
                                    <input type="date" class="admin-form-control" name="end_date" id="reportDateTo" value="<?= $endDate ?>">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Report Type</label>
                                <select class="admin-form-control admin-form-select" name="report_type" id="reportType">
                                    <option value="sales" <?= $reportType === 'sales' ? 'selected' : '' ?>>Sales Report</option>
                                    <option value="products" <?= $reportType === 'products' ? 'selected' : '' ?>>Products Report</option>
                                    <option value="customers" <?= $reportType === 'customers' ? 'selected' : '' ?>>Customers Report</option>
                                    <option value="inventory" <?= $reportType === 'inventory' ? 'selected' : '' ?>>Inventory Report</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <button type="submit" class="admin-btn admin-btn-primary" id="applyFilters" style="margin-top: 24px;">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Sales Report -->
                <div class="report-card" id="salesReport" style="display: <?= $reportType === 'sales' ? 'block' : 'none' ?>;">
                    <div class="report-card-header">
                        <h3 class="report-card-title">
                            <i class="fas fa-shopping-cart"></i> Sales Overview
                        </h3>
                        <div class="admin-card-actions">
                            <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <button class="admin-btn admin-btn-success admin-btn-sm" id="exportSales">
                                <i class="fas fa-file-export"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="report-card-body">
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                        <div class="report-summary">
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= formatCurrency($totalSales) ?></div>
                                <div class="report-summary-label">Total Sales</div>
                            </div>
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= $totalOrders ?></div>
                                <div class="report-summary-label">Total Orders</div>
                            </div>
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= formatCurrency($avgOrder) ?></div>
                                <div class="report-summary-label">Average Order</div>
                            </div>
                            <div class="report-summary-item">
                                <div class="report-summary-value">8%</div>
                                <div class="report-summary-label">Growth Rate</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Products Report -->
                <div class="report-card" id="productsReport" style="display: <?= $reportType === 'products' ? 'block' : 'none' ?>;">
                    <div class="report-card-header">
                        <h3 class="report-card-title">
                            <i class="fas fa-box-open"></i> Top Selling Products
                        </h3>
                        <div class="admin-card-actions">
                            <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <button class="admin-btn admin-btn-success admin-btn-sm" id="exportProducts">
                                <i class="fas fa-file-export"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="report-card-body">
                        <div class="table-responsive">
                            <table class="report-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Sold</th>
                                        <th>Revenue</th>
                                        <th>% of Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($productsData as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                                        <td><?= htmlspecialchars($product['category_name']) ?></td>
                                        <td><?= $product['quantity_sold'] ?></td>
                                        <td><?= formatCurrency($product['revenue']) ?></td>
                                        <td>
                                            <div class="progress-container">
                                                <div class="progress-bar" style="width: <?= round($product['percentage_of_total']) ?>%;"></div>
                                            </div>
                                            <?= round($product['percentage_of_total']) ?>%
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Customer Report -->
                <div class="report-card" id="customersReport" style="display: <?= $reportType === 'customers' ? 'block' : 'none' ?>;">
                    <div class="report-card-header">
                        <h3 class="report-card-title">
                            <i class="fas fa-users"></i> Customer Analytics
                        </h3>
                        <div class="admin-card-actions">
                            <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <button class="admin-btn admin-btn-success admin-btn-sm" id="exportCustomers">
                                <i class="fas fa-file-export"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="report-card-body">
                        <div class="form-row">
                            <div class="form-col">
                                <div class="chart-container">
                                    <canvas id="customersChart"></canvas>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="chart-container">
                                    <canvas id="locationsChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="report-summary">
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= $customersData['total_customers'] ?></div>
                                <div class="report-summary-label">Total Customers</div>
                            </div>
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= $customersData['new_customers'] ?></div>
                                <div class="report-summary-label">New This Month</div>
                            </div>
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= formatCurrency($customersData['avg_spend'] ?? 0) ?></div>
                                <div class="report-summary-label">Avg. Spend</div>
                            </div>
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= round($customersData['avg_orders'] ?? 0, 1) ?></div>
                                <div class="report-summary-label">Avg. Orders</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Report -->
                <div class="report-card" id="inventoryReport" style="display: <?= $reportType === 'inventory' ? 'block' : 'none' ?>;">
                    <div class="report-card-header">
                        <h3 class="report-card-title">
                            <i class="fas fa-boxes"></i> Inventory Report
                        </h3>
                        <div class="admin-card-actions">
                            <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <button class="admin-btn admin-btn-success admin-btn-sm" id="exportInventory">
                                <i class="fas fa-file-export"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="report-card-body">
                        <div class="form-row">
                            <div class="form-col">
                                <div class="chart-container">
                                    <canvas id="stockChart"></canvas>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="chart-container">
                                    <canvas id="lowStockChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="report-summary">
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= $inventoryData['total_products'] ?></div>
                                <div class="report-summary-label">Total Products</div>
                            </div>
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= $inventoryData['low_stock_items'] ?></div>
                                <div class="report-summary-label">Low Stock Items</div>
                            </div>
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= $inventoryData['out_of_stock'] ?></div>
                                <div class="report-summary-label">Out of Stock</div>
                            </div>
                            <div class="report-summary-item">
                                <div class="report-summary-value"><?= formatCurrency($inventoryData['inventory_value']) ?></div>
                                <div class="report-summary-label">Inventory Value</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        // DOM Content Loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar on mobile
            const toggleSidebar = document.getElementById('toggleSidebar');
            const adminSidebar = document.getElementById('adminSidebar');
            
            toggleSidebar.addEventListener('click', function() {
                adminSidebar.classList.toggle('show');
            });

            // Products menu toggle
            const productsMenu = document.getElementById('productsMenu');
            const productsSubmenu = document.getElementById('productsSubmenu');
            
            productsMenu.addEventListener('click', function(e) {
                e.preventDefault();
                productsSubmenu.classList.toggle('show');
                this.classList.toggle('active');
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
                document.querySelectorAll('.admin-user-dropdown, .notification-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            });

            // Show/hide custom date range fields
            const reportDateRange = document.getElementById('reportDateRange');
            const customDateFromCol = document.getElementById('customDateFromCol');
            const customDateToCol = document.getElementById('customDateToCol');
            
            reportDateRange.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDateFromCol.style.display = 'block';
                    customDateToCol.style.display = 'block';
                } else {
                    customDateFromCol.style.display = 'none';
                    customDateToCol.style.display = 'none';
                }
            });

            // Set default dates for custom range
            const today = new Date();
            const oneMonthAgo = new Date();
            oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
            
            document.getElementById('reportDateFrom').valueAsDate = oneMonthAgo;
            document.getElementById('reportDateTo').valueAsDate = today;

            // Initialize charts
            initSalesChart();
            initCustomersChart();
            initLocationsChart();
            initStockChart();
            initLowStockChart();

            // Export buttons functionality
            document.getElementById('exportSales').addEventListener('click', function() {
                exportReport('sales');
            });
            
            document.getElementById('exportProducts').addEventListener('click', function() {
                exportReport('products');
            });
            
            document.getElementById('exportCustomers').addEventListener('click', function() {
                exportReport('customers');
            });
            
            document.getElementById('exportInventory').addEventListener('click', function() {
                exportReport('inventory');
            });
        });

        // Export report function
        function exportReport(type) {
            const dateRange = document.getElementById('reportDateRange').value;
            const startDate = document.getElementById('reportDateFrom').value;
            const endDate = document.getElementById('reportDateTo').value;
            
            // In a real application, this would make an AJAX call to export the data
            alert(`Exporting ${type} report for ${dateRange} (${startDate} to ${endDate})...`);
            
            // For demo purposes, we'll simulate a download
            const link = document.createElement('a');
            link.href = `export.php?type=${type}&start_date=${startDate}&end_date=${endDate}`;
            link.click();
        }

        // Initialize Sales Chart
        function initSalesChart() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode(array_column($salesData, 'day')) ?>,
                    datasets: [{
                        label: 'Daily Sales',
                        data: <?= json_encode(array_column($salesData, 'total_sales')) ?>,
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        borderColor: 'rgba(67, 97, 238, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'rgba(67, 97, 238, 1)',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'RWF ' + context.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'RWF ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        // Initialize Customers Chart
        function initCustomersChart() {
            const ctx = document.getElementById('customersChart').getContext('2d');
            const customersChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'New Customers',
                        data: [12, 19, 15, 22, 18, 24, 20, 17, 19, 23, 21, 25],
                        backgroundColor: 'rgba(67, 97, 238, 0.7)',
                        borderColor: 'rgba(67, 97, 238, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Initialize Locations Chart
        function initLocationsChart() {
            const ctx = document.getElementById('locationsChart').getContext('2d');
            const locationsChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Kigali', 'Musanze', 'Rubavu', 'Huye', 'Nyagatare', 'Others'],
                    datasets: [{
                        data: [45, 15, 12, 10, 8, 10],
                        backgroundColor: [
                            'rgba(67, 97, 238, 0.8)',
                            'rgba(76, 201, 240, 0.8)',
                            'rgba(67, 97, 238, 0.6)',
                            'rgba(76, 201, 240, 0.6)',
                            'rgba(67, 97, 238, 0.4)',
                            'rgba(76, 201, 240, 0.4)'
                        ],
                        borderColor: [
                            'rgba(67, 97, 238, 1)',
                            'rgba(76, 201, 240, 1)',
                            'rgba(67, 97, 238, 1)',
                            'rgba(76, 201, 240, 1)',
                            'rgba(67, 97, 238, 1)',
                            'rgba(76, 201, 240, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        }

        // Initialize Stock Chart
        function initStockChart() {
            const ctx = document.getElementById('stockChart').getContext('2d');
            const stockChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Electronics', 'Clothing', 'Groceries', 'Furniture', 'Others'],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: [
                            'rgba(67, 97, 238, 0.8)',
                            'rgba(76, 201, 240, 0.8)',
                            'rgba(67, 97, 238, 0.6)',
                            'rgba(76, 201, 240, 0.6)',
                            'rgba(67, 97, 238, 0.4)'
                        ],
                        borderColor: [
                            'rgba(67, 97, 238, 1)',
                            'rgba(76, 201, 240, 1)',
                            'rgba(67, 97, 238, 1)',
                            'rgba(76, 201, 240, 1)',
                            'rgba(67, 97, 238, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        }

        // Initialize Low Stock Chart
        function initLowStockChart() {
            const ctx = document.getElementById('lowStockChart').getContext('2d');
            const lowStockChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Electronics', 'Clothing', 'Groceries', 'Furniture', 'Others'],
                    datasets: [{
                        label: 'Low Stock Items',
                        data: [5, 3, 4, 2, 1],
                        backgroundColor: 'rgba(247, 37, 133, 0.7)',
                        borderColor: 'rgba(247, 37, 133, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>