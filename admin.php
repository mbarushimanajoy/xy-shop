<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY_SHOP - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #17a2b8;
            --light-bg: #f9f9f9;
            --dark-text: #2c3e50;
            --light-text: #ecf0f1;
            --border-color: #e0e0e0;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --sidebar-width: 280px;
            --header-height: 70px;
            --card-radius: 10px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark-text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Admin Container */
        .admin-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(to bottom, #2c3e50, #1a2530);
            color: var(--light-text);
            padding: 20px 0;
            transition: var(--transition);
            position: fixed;
            height: 100%;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .admin-sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            position: sticky;
            top: 0;
            background-color: var(--primary-color);
            z-index: 1;
        }

        .admin-sidebar-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--light-text);
        }

        .admin-sidebar-header i {
            font-size: 1.5rem;
            color: var(--secondary-color);
        }

        .admin-sidebar-menu {
            padding: 20px 0;
        }

        .admin-menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.8);
            transition: var(--transition);
            cursor: pointer;
            border-left: 3px solid transparent;
            font-size: 0.95rem;
            position: relative;
        }

        .admin-menu-item:hover, 
        .admin-menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--secondary-color);
        }

        .admin-menu-item i {
            width: 24px;
            text-align: center;
            font-size: 1rem;
        }

        .admin-menu-item .badge {
            position: absolute;
            right: 20px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 0.7rem;
        }

        .admin-submenu {
            padding-left: 20px;
            max-height: 0;
            overflow: hidden;
            transition: var(--transition);
            background-color: rgba(0, 0, 0, 0.1);
        }

        .admin-submenu.show {
            max-height: 500px;
        }

        .admin-submenu-item {
            padding: 10px 20px 10px 40px;
            color: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
            display: block;
            text-decoration: none;
            font-size: 0.9rem;
            position: relative;
        }

        .admin-submenu-item:hover, 
        .admin-submenu-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .admin-submenu-item.active::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--secondary-color);
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: var(--transition);
            min-height: 100vh;
        }

        /* Header */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background-color: white;
            box-shadow: var(--shadow);
            border-radius: var(--card-radius);
            margin-bottom: 20px;
            height: var(--header-height);
        }

        .admin-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-title i {
            color: var(--secondary-color);
        }

        .admin-header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-search-box {
            position: relative;
            width: 250px;
        }

        .admin-search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--border-color);
            border-radius: 30px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .admin-search-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .admin-search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .admin-notification {
            position: relative;
            cursor: pointer;
        }

        .admin-notification i {
            font-size: 1.2rem;
            color: var(--dark-text);
        }

        .admin-notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            position: relative;
        }

        .admin-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: var(--transition);
            background-size: cover;
            background-position: center;
        }

        .admin-user:hover .admin-user-avatar {
            transform: scale(1.05);
        }

        .admin-user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
            padding: 10px 0;
            min-width: 200px;
            z-index: 100;
            display: none;
        }

        .admin-user-dropdown.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        .admin-user-dropdown-item {
            padding: 10px 20px;
            color: var(--dark-text);
            transition: var(--transition);
            display: block;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .admin-user-dropdown-item:hover {
            background-color: #f5f5f5;
            color: var(--secondary-color);
        }

        .admin-user-dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }

        /* Content */
        .admin-content {
            background-color: white;
            border-radius: var(--card-radius);
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }

        /* Cards */
        .admin-card {
            background-color: white;
            border-radius: var(--card-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .admin-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .admin-card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-card-title i {
            color: var(--secondary-color);
        }

        .admin-card-actions {
            display: flex;
            gap: 10px;
        }

        /* Buttons */
        .admin-btn {
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }

        .admin-btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
        }

        .admin-btn-primary {
            background-color: var(--secondary-color);
            color: white;
        }

        .admin-btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(41, 128, 185, 0.2);
        }

        .admin-btn-secondary {
            background-color: #ecf0f1;
            color: var(--dark-text);
        }

        .admin-btn-secondary:hover {
            background-color: #bdc3c7;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(189, 195, 199, 0.2);
        }

        .admin-btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .admin-btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(231, 76, 60, 0.2);
        }

        .admin-btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .admin-btn-success:hover {
            background-color: #219653;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(39, 174, 96, 0.2);
        }

        .admin-btn-warning {
            background-color: var(--warning-color);
            color: white;
        }

        .admin-btn-warning:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(243, 156, 18, 0.2);
        }

        .admin-btn-info {
            background-color: var(--info-color);
            color: white;
        }

        .admin-btn-info:hover {
            background-color: #138496;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(23, 162, 184, 0.2);
        }

        .admin-btn-outline {
            background-color: transparent;
            border: 1px solid var(--secondary-color);
            color: var(--secondary-color);
        }

        .admin-btn-outline:hover {
            background-color: var(--secondary-color);
            color: white;
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
            background-color: #f9f9f9;
            color: #555;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
        }

        .admin-table tr:hover {
            background-color: #f5f5f5;
        }

        .admin-table-actions {
            display: flex;
            gap: 5px;
        }

        /* Stats Cards */
        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .admin-stat-card {
            background-color: white;
            border-radius: var(--card-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            text-align: center;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .admin-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .admin-stat-icon {
            font-size: 2rem;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .admin-stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 10px 0;
        }

        .admin-stat-label {
            color: #777;
            font-size: 0.9rem;
        }

        .admin-stat-change {
            font-size: 0.8rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .admin-stat-change.positive {
            color: var(--success-color);
        }

        .admin-stat-change.negative {
            color: var(--danger-color);
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .bg-primary {
            background-color: #cce5ff;
            color: #004085;
        }

        .bg-secondary {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .bg-success {
            background-color: #d4edda;
            color: #155724;
        }

        .bg-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .bg-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .bg-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .bg-dark {
            background-color: #d6d8d9;
            color: #1b1e21;
        }

        /* Responsive Admin */
        @media (max-width: 992px) {
            .admin-sidebar {
                width: 250px;
            }
            .admin-main {
                margin-left: 250px;
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            }
            .admin-toggle-sidebar {
                display: block !important;
            }
        }

        .admin-toggle-sidebar {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
        }

        /* Form Elements */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .form-col {
            padding: 0 10px;
            flex: 1;
            min-width: 250px;
        }

        /* Chart Container */
        .chart-container {
            height: 300px;
            position: relative;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: var(--border-color);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            border: 2px solid white;
        }

        .timeline-date {
            font-size: 0.8rem;
            color: #777;
        }

        .timeline-content {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-top: 5px;
        }

        /* Toast Notification */
        .admin-toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--success-color);
            color: white;
            padding: 15px 25px;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
            z-index: 1100;
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .admin-toast.show {
            opacity: 1;
            visibility: visible;
        }

        .admin-toast i {
            font-size: 1.2rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
                <a href="dashboard.php" class="admin-menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="admin-menu-item">
                    <i class="fas fa-box-open"></i>
                    <span>Products</span>
                    <i class="fas fa-chevron-down"></i>
                    <span class="badge">15</span>
                </div>
                <div class="admin-submenu">
                    <a href="products.php" class="admin-submenu-item active">All Products</a>
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
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </h1>
                <div class="admin-header-actions">
                    <div class="admin-search-box">
                        <i class="fas fa-search admin-search-icon"></i>
                        <input type="text" class="admin-search-input" placeholder="Search...">
                    </div>
                    <div class="admin-notification">
                        <i class="fas fa-bell"></i>
                        <span class="admin-notification-badge">3</span>
                    </div>
                    <div class="admin-user" id="userDropdown">
                        <div class="admin-user-avatar" style="background-image: url('https://randomuser.me/api/portraits/men/32.jpg')">SK</div>
                        <span>Shop Keeper</span>
                        <i class="fas fa-chevron-down"></i>
                        <div class="admin-user-dropdown">
                            <a href="#" class="admin-user-dropdown-item"><i class="fas fa-user"></i> Profile</a>
                            <a href="settings.php" class="admin-user-dropdown-item"><i class="fas fa-cog"></i> Settings</a>
                            <a href="logout.php" class="admin-user-dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="admin-content">
                <!-- Stats Cards -->
                <div class="admin-stats-grid">
                    <div class="admin-stat-card">
                        <i class="fas fa-boxes admin-stat-icon"></i>
                        <div class="admin-stat-value">1,248</div>
                        <div class="admin-stat-label">Total Products</div>
                        <div class="admin-stat-change positive">
                            <i class="fas fa-arrow-up"></i> 12% from last month
                        </div>
                    </div>
                    <div class="admin-stat-card">
                        <i class="fas fa-shopping-cart admin-stat-icon"></i>
                        <div class="admin-stat-value">356</div>
                        <div class="admin-stat-label">Today's Orders</div>
                        <div class="admin-stat-change positive">
                            <i class="fas fa-arrow-up"></i> 8% from yesterday
                        </div>
                    </div>
                    <div class="admin-stat-card">
                        <i class="fas fa-dollar-sign admin-stat-icon"></i>
                        <div class="admin-stat-value">RWF 2,450,000</div>
                        <div class="admin-stat-label">Today's Revenue</div>
                        <div class="admin-stat-change negative">
                            <i class="fas fa-arrow-down"></i> 3% from yesterday
                        </div>
                    </div>
                    <div class="admin-stat-card">
                        <i class="fas fa-users admin-stat-icon"></i>
                        <div class="admin-stat-value">1,024</div>
                        <div class="admin-stat-label">New Customers</div>
                        <div class="admin-stat-change positive">
                            <i class="fas fa-arrow-up"></i> 15% from last month
                        </div>
                    </div>
                </div>

                <!-- Recent Orders & Top Products -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h3 class="admin-card-title">
                                    <i class="fas fa-shopping-cart"></i> Recent Orders
                                </h3>
                                <div class="admin-card-actions">
                                    <button class="admin-btn admin-btn-secondary admin-btn-sm">
                                        View All
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#ORD-2023-001</td>
                                            <td>John Doe</td>
                                            <td>RWF 125,000</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td>Today, 10:30 AM</td>
                                        </tr>
                                        <tr>
                                            <td>#ORD-2023-002</td>
                                            <td>Jane Smith</td>
                                            <td>RWF 85,500</td>
                                            <td><span class="badge bg-warning">Processing</span></td>
                                            <td>Today, 09:15 AM</td>
                                        </tr>
                                        <tr>
                                            <td>#ORD-2023-003</td>
                                            <td>Robert Johnson</td>
                                            <td>RWF 210,000</td>
                                            <td><span class="badge bg-danger">Cancelled</span></td>
                                            <td>Yesterday, 04:45 PM</td>
                                        </tr>
                                        <tr>
                                            <td>#ORD-2023-004</td>
                                            <td>Sarah Williams</td>
                                            <td>RWF 64,000</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td>Yesterday, 02:30 PM</td>
                                        </tr>
                                        <tr>
                                            <td>#ORD-2023-005</td>
                                            <td>Michael Brown</td>
                                            <td>RWF 32,500</td>
                                            <td><span class="badge bg-info">Shipped</span></td>
                                            <td>Yesterday, 11:20 AM</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h3 class="admin-card-title">
                                    <i class="fas fa-star"></i> Top Selling Products
                                </h3>
                                <div class="admin-card-actions">
                                    <button class="admin-btn admin-btn-secondary admin-btn-sm">
                                        View All
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Sold</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Smartphone X Pro</td>
                                            <td>Electronics</td>
                                            <td>RWF 550,000</td>
                                            <td>48</td>
                                            <td>RWF 26,400,000</td>
                                        </tr>
                                        <tr>
                                            <td>Wireless Headphones</td>
                                            <td>Electronics</td>
                                            <td>RWF 120,000</td>
                                            <td>36</td>
                                            <td>RWF 4,320,000</td>
                                        </tr>
                                        <tr>
                                            <td>Men's T-Shirt</td>
                                            <td>Clothing</td>
                                            <td>RWF 25,000</td>
                                            <td>28</td>
                                            <td>RWF 700,000</td>
                                        </tr>
                                        <tr>
                                            <td>Rice 5kg Bag</td>
                                            <td>Groceries</td>
                                            <td>RWF 15,000</td>
                                            <td>25</td>
                                            <td>RWF 375,000</td>
                                        </tr>
                                        <tr>
                                            <td>Office Chair</td>
                                            <td>Furniture</td>
                                            <td>RWF 180,000</td>
                                            <td>12</td>
                                            <td>RWF 2,160,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Chart & Activity Timeline -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h3 class="admin-card-title">
                                    <i class="fas fa-chart-line"></i> Sales Overview
                                </h3>
                                <div class="admin-card-actions">
                                    <select class="admin-form-control" id="salesPeriod">
                                        <option>Last 7 Days</option>
                                        <option>Last 30 Days</option>
                                        <option selected>Last 90 Days</option>
                                        <option>This Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <div class="chart-container">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h3 class="admin-card-title">
                                    <i class="fas fa-list-alt"></i> Recent Activity
                                </h3>
                                <div class="admin-card-actions">
                                    <button class="admin-btn admin-btn-secondary admin-btn-sm">
                                        View All
                                    </button>
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-date">Today, 11:45 AM</div>
                                        <div class="timeline-content">
                                            New order #ORD-2023-006 received from David Miller
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-date">Today, 10:30 AM</div>
                                        <div class="timeline-content">
                                            Product "Wireless Earbuds" stock updated (Qty: 25)
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-date">Today, 09:15 AM</div>
                                        <div class="timeline-content">
                                            New customer registered: Sarah Johnson
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-date">Yesterday, 05:20 PM</div>
                                        <div class="timeline-content">
                                            Order #ORD-2023-005 shipped to Michael Brown
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-date">Yesterday, 03:45 PM</div>
                                        <div class="timeline-content">
                                            New category "Home Appliances" added
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="admin-toast" id="toastNotification">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">System updated successfully</span>
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

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.admin-user-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            });

            // Submenu toggle
            document.querySelectorAll('.admin-menu-item').forEach(item => {
                if (item.querySelector('.fa-chevron-down')) {
                    item.addEventListener('click', function(e) {
                        if (e.target.tagName !== 'A') {
                            const submenu = this.nextElementSibling;
                            submenu.classList.toggle('show');
                            const icon = this.querySelector('.fa-chevron-down');
                            icon.classList.toggle('fa-rotate-180');
                        }
                    });
                }
            });

            // Simulate toast notification
            setTimeout(() => {
                const toast = document.getElementById('toastNotification');
                toast.classList.add('show');
                
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }, 1500);

            // Sales Chart
            const salesChart = document.getElementById('salesChart').getContext('2d');
            const chart = new Chart(salesChart, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue (RWF)',
                        data: [1500000, 1800000, 2100000, 2400000, 2200000, 2500000, 2800000, 3000000, 2900000, 3200000, 3500000, 3800000],
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderColor: '#3498db',
                        borderWidth: 3,
                        pointBackgroundColor: '#3498db',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'RWF ' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Simulate backend data update
            document.getElementById('salesPeriod').addEventListener('change', function() {
                const toast = document.getElementById('toastNotification');
                toast.querySelector('#toastMessage').textContent = 'Sales data updated for ' + this.value;
                toast.classList.add('show');
                
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            });
        });

        // Backend simulation - Data processing functions
        function processOrder(orderData) {
            // Simulated backend order processing
            console.log("Processing order:", orderData);
            return { status: "success", orderId: "#ORD-" + Math.floor(Math.random() * 1000000) };
        }

        function updateInventory(productId, quantity) {
            // Simulated inventory update
            console.log(`Updating inventory for product ${productId} by ${quantity} units`);
            return { status: "success", newStock: Math.floor(Math.random() * 100) };
        }

        function getSalesReport(period) {
            // Simulated sales report generation
            console.log(`Generating sales report for ${period}`);
            return { revenue: Math.floor(Math.random() * 10000000), orders: Math.floor(Math.random() * 1000) };
        }

        // Example usage
        const newOrder = {
            customer: "Alice Johnson",
            items: [
                { id: "P123", name: "Smart Watch", price: 120000, quantity: 1 },
                { id: "P456", name: "Wireless Earbuds", price: 85000, quantity: 2 }
            ],
            total: 290000
        };

        const orderResult = processOrder(newOrder);
        console.log("Order processed:", orderResult);

        const inventoryResult = updateInventory("P123", -1);
        console.log("Inventory updated:", inventoryResult);

        const reportResult = getSalesReport("Last 30 Days");
        console.log("Sales report:", reportResult);
    </script>
</body>
</html>