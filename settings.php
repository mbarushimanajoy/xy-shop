<?php
// settings.php - Professional Admin Settings Page

// ========================
// SESSION & AUTHENTICATION
// ========================
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

// =================
// DATABASE CONFIG
// =================
define('DB_HOST', 'localhost');
define('DB_NAME', 'xy_shop');
define('DB_USER', 'root');
define('DB_PASS', '');

// ===================
// DATABASE FUNCTIONS
// ===================
class SettingsManager {
    private $pdo;
    
    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME, 
                DB_USER, 
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
            
            $this->initializeDatabase();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            die("System maintenance in progress. Please try again later.");
        }
    }
    
    private function initializeDatabase() {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS settings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                setting_key VARCHAR(100) NOT NULL UNIQUE,
                setting_value TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_setting_key (setting_key)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
    }
    
    public function getSetting($key, $default = '') {
        $stmt = $this->pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        return $stmt->fetchColumn() ?: $default;
    }
    
    public function saveSetting($key, $value) {
        $stmt = $this->pdo->prepare("
            INSERT INTO settings (setting_key, setting_value) 
            VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE setting_value = ?
        ");
        return $stmt->execute([$key, $value, $value]);
    }
    
    public function saveSettingsBatch(array $settings) {
        $this->pdo->beginTransaction();
        try {
            foreach ($settings as $key => $value) {
                $this->saveSetting($key, $value);
            }
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Batch save failed: " . $e->getMessage());
            return false;
        }
    }
}

// ====================
// INITIALIZE SETTINGS
// ====================
$settingsManager = new SettingsManager();

// ===================
// FORM PROCESSING
// ===================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tab = $_POST['tab'] ?? 'general';
    $success = false;
    
    try {
        switch($tab) {
            case 'general':
                $settingsManager->saveSettingsBatch([
                    'store_name' => $_POST['store_name'],
                    'store_email' => $_POST['store_email'],
                    'store_phone' => $_POST['store_phone'],
                    'store_address' => $_POST['store_address'],
                    'currency' => $_POST['currency'],
                    'currency_position' => $_POST['currency_position'],
                    'thousand_separator' => $_POST['thousand_separator'],
                    'decimal_separator' => $_POST['decimal_separator'],
                    'number_of_decimals' => $_POST['number_of_decimals']
                ]);
                $success = true;
                break;
                
            case 'payment':
                $settingsManager->saveSettingsBatch([
                    'stripe_enabled' => isset($_POST['stripe_enabled']) ? 1 : 0,
                    'paypal_enabled' => isset($_POST['paypal_enabled']) ? 1 : 0,
                    'stripe_publishable_key' => $_POST['stripe_publishable_key'],
                    'stripe_secret_key' => $_POST['stripe_secret_key']
                ]);
                $success = true;
                break;
                
            case 'shipping':
                $settingsManager->saveSettingsBatch([
                    'free_shipping_enabled' => isset($_POST['free_shipping_enabled']) ? 1 : 0,
                    'flat_rate_enabled' => isset($_POST['flat_rate_enabled']) ? 1 : 0,
                    'flat_rate_price' => $_POST['flat_rate_price'],
                    'free_shipping_min' => $_POST['free_shipping_min']
                ]);
                $success = true;
                break;
                
            case 'security':
                $settingsManager->saveSettingsBatch([
                    'force_https' => isset($_POST['force_https']) ? 1 : 0,
                    'two_factor_auth' => isset($_POST['two_factor_auth']) ? 1 : 0,
                    'allowed_ips' => $_POST['allowed_ips']
                ]);
                $success = true;
                break;
        }
        
        if ($success) {
            $_SESSION['success_message'] = ucfirst($tab) . " settings updated successfully!";
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error saving settings: " . $e->getMessage();
    }
    
    header("Location: settings.php?tab=" . $tab);
    exit;
}

// ==============
// UI VARIABLES
// ==============
$current_tab = $_GET['tab'] ?? 'general';
$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

// ============
// HTML START
// ============
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY_SHOP - Admin Settings</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Color Scheme */
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
            --border: #dee2e6;
            
            /* Spacing */
            --space-xs: 0.25rem;
            --space-sm: 0.5rem;
            --space-md: 1rem;
            --space-lg: 1.5rem;
            --space-xl: 2rem;
            
            /* Shadows */
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            
            /* Transitions */
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .admin-sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1e3c72, #2a5298);
            color: white;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            height: 100vh;
            position: fixed;
            overflow-y: auto;
        }
        
        .admin-sidebar-header {
            padding: var(--space-lg);
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .admin-sidebar-header i {
            font-size: 1.5rem;
            margin-right: var(--space-sm);
        }
        
        .admin-sidebar-header h1 {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .admin-sidebar-menu {
            padding: var(--space-md) 0;
        }
        
        .admin-sidebar-menu h3 {
            padding: var(--space-sm) var(--space-lg);
            font-size: 0.8rem;
            text-transform: uppercase;
            color: rgba(255,255,255,0.7);
            letter-spacing: 1px;
            margin-bottom: var(--space-xs);
        }
        
        .admin-sidebar-menu ul {
            list-style: none;
        }
        
        .admin-sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: var(--space-sm) var(--space-lg);
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.95rem;
            border-left: 3px solid transparent;
        }
        
        .admin-sidebar-menu li a:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .admin-sidebar-menu li a i {
            margin-right: var(--space-sm);
            width: 20px;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .admin-sidebar-menu li.active a {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid var(--secondary);
        }
        
        /* Main Content Styles */
        .admin-main {
            flex: 1;
            margin-left: 250px;
            padding: var(--space-lg);
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-lg);
            padding-bottom: var(--space-md);
            border-bottom: 1px solid var(--border);
        }
        
        .admin-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .admin-user {
            display: flex;
            align-items: center;
            background: white;
            padding: var(--space-sm) var(--space-md);
            border-radius: 30px;
            box-shadow: var(--shadow-sm);
        }
        
        .admin-user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: var(--space-sm);
            object-fit: cover;
            border: 2px solid var(--primary);
        }
        
        .admin-user-info {
            display: flex;
            flex-direction: column;
        }
        
        .admin-user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .admin-user-role {
            font-size: 0.8rem;
            color: var(--gray);
        }
        
        /* Settings Specific Styles */
        .settings-tabs {
            display: flex;
            border-bottom: 1px solid var(--border);
            margin-bottom: var(--space-lg);
            background: white;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .settings-tab {
            padding: var(--space-md) var(--space-lg);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: var(--transition);
            font-weight: 500;
            color: var(--gray);
        }
        
        .settings-tab:hover {
            color: var(--primary);
            background: rgba(52, 152, 219, 0.05);
        }
        
        .settings-tab.active {
            border-bottom-color: var(--primary-dark);
            color: var(--primary);
            font-weight: 600;
        }
        
        .settings-tab-content {
            display: none;
        }
        
        .settings-tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        .settings-card {
            background-color: white;
            border-radius: 5px;
            padding: var(--space-lg);
            margin-bottom: var(--space-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: transform 0.3s ease;
        }
        
        .settings-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        
        .settings-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-md);
            padding-bottom: var(--space-md);
            border-bottom: 1px solid var(--border);
        }
        
        .settings-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }
        
        .settings-card-title i {
            font-size: 1.1rem;
        }
        
        .settings-description {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: var(--space-lg);
            line-height: 1.7;
        }
        
        .settings-form-group {
            margin-bottom: var(--space-md);
        }
        
        .settings-form-label {
            display: block;
            margin-bottom: var(--space-xs);
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
        }
        
        .settings-form-control {
            width: 100%;
            padding: var(--space-sm) var(--space-md);
            border: 1px solid var(--border);
            border-radius: 4px;
            transition: var(--transition);
            font-size: 0.9rem;
            background: #fff;
        }
        
        .settings-form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .btn {
            padding: var(--space-sm) var(--space-lg);
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: var(--space-sm);
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: var(--shadow-sm);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .btn-secondary {
            background-color: var(--gray);
            color: white;
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .form-row {
            display: flex;
            gap: var(--space-md);
            margin-bottom: var(--space-md);
        }
        
        .form-col {
            flex: 1;
        }
        
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: var(--primary);
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        .toggle-group {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            margin-bottom: var(--space-sm);
        }
        
        .toggle-label {
            font-size: 0.95rem;
            color: var(--dark);
        }
        
        .alert {
            padding: var(--space-sm) var(--space-md);
            border-radius: 4px;
            margin-bottom: var(--space-md);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }
        
        .alert-success {
            background-color: rgba(46, 204, 113, 0.15);
            color: #27ae60;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }
        
        .alert-danger {
            background-color: rgba(231, 76, 60, 0.15);
            color: #c0392b;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .alert i {
            font-size: 1.2rem;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .admin-sidebar {
                width: 70px;
            }
            
            .admin-sidebar-header h1,
            .admin-sidebar-menu h3,
            .admin-sidebar-menu span {
                display: none;
            }
            
            .admin-sidebar-menu li a {
                justify-content: center;
                padding: var(--space-md) 0;
            }
            
            .admin-sidebar-menu li a i {
                margin-right: 0;
                font-size: 1.1rem;
            }
            
            .admin-main {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-md);
            }
            
            .admin-user {
                align-self: flex-end;
                margin-top: var(--space-md);
            }
            
            .settings-tabs {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="admin-sidebar-header">
                <i class="fas fa-store-alt"></i>
                <h1>XY_SHOP Admin</h1>
            </div>
            <div class="admin-sidebar-menu">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                    <li><a href="products.php"><i class="fas fa-box-open"></i> <span>Products</span></a></li>
                    <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> <span>Orders</span></a></li>
                    <li><a href="customers.php"><i class="fas fa-users"></i> <span>Customers</span></a></li>
                    <li class="active"><a href="settings.php"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
                </ul>
                
                <h3>System</h3>
                <ul>
                    <li><a href="staff.php"><i class="fas fa-user-shield"></i> <span>Staff</span></a></li>
                    <li><a href="backup.php"><i class="fas fa-database"></i> <span>Backup</span></a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-header">
                <h2><i class="fas fa-cog"></i> Settings</h2>
                <div class="admin-user">
                    <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Admin User">
                    <div class="admin-user-info">
                        <span class="admin-user-name"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
                        <span class="admin-user-role"><?php echo htmlspecialchars(ucfirst($_SESSION['admin_role'] ?? 'Administrator')); ?></span>
                    </div>
                </div>
            </div>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <div class="settings-tabs">
                <div class="settings-tab <?php echo $current_tab === 'general' ? 'active' : ''; ?>" data-tab="general">
                    <i class="fas fa-store"></i>
                    <span>General</span>
                </div>
                <div class="settings-tab <?php echo $current_tab === 'payment' ? 'active' : ''; ?>" data-tab="payment">
                    <i class="fas fa-credit-card"></i>
                    <span>Payment</span>
                </div>
                <div class="settings-tab <?php echo $current_tab === 'shipping' ? 'active' : ''; ?>" data-tab="shipping">
                    <i class="fas fa-truck"></i>
                    <span>Shipping</span>
                </div>
                <div class="settings-tab <?php echo $current_tab === 'security' ? 'active' : ''; ?>" data-tab="security">
                    <i class="fas fa-shield-alt"></i>
                    <span>Security</span>
                </div>
            </div>

            <!-- General Settings Tab -->
            <div class="settings-tab-content <?php echo $current_tab === 'general' ? 'active' : ''; ?>" id="general-tab">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="tab" value="general">
                    
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <h3 class="settings-card-title"><i class="fas fa-info-circle"></i> Store Information</h3>
                        </div>
                        <p class="settings-description">Update your store's basic information and contact details.</p>
                        
                        <div class="settings-form-group">
                            <label class="settings-form-label">Store Name</label>
                            <input type="text" class="settings-form-control" name="store_name" 
                                   value="<?php echo htmlspecialchars($settingsManager->getSetting('store_name', 'XY_SHOP')); ?>" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Store Email</label>
                                    <input type="email" class="settings-form-control" name="store_email" 
                                           value="<?php echo htmlspecialchars($settingsManager->getSetting('store_email', 'contact@xyshop.com')); ?>" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Store Phone</label>
                                    <input type="tel" class="settings-form-control" name="store_phone" 
                                           value="<?php echo htmlspecialchars($settingsManager->getSetting('store_phone', '+1 (555) 123-4567')); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="settings-form-group">
                            <label class="settings-form-label">Store Address</label>
                            <textarea class="settings-form-control" name="store_address" rows="3"><?php 
                                echo htmlspecialchars($settingsManager->getSetting('store_address', '123 Commerce Street, Business City, BC 12345, United States')); 
                            ?></textarea>
                        </div>
                        
                        <div class="settings-form-group">
                            <label class="settings-form-label">Store Logo</label>
                            <input type="file" class="settings-form-control" name="store_logo">
                            <small style="color: var(--gray); font-size: 0.8rem;">Recommended size: 200x50 pixels</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                    
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <h3 class="settings-card-title"><i class="fas fa-money-bill-wave"></i> Store Currency</h3>
                        </div>
                        <p class="settings-description">Set your store's default currency and formatting options.</p>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Currency</label>
                                    <select class="settings-form-control" name="currency">
                                        <option value="USD" <?php echo $settingsManager->getSetting('currency') === 'USD' ? 'selected' : ''; ?>>US Dollar (USD)</option>
                                        <option value="EUR" <?php echo $settingsManager->getSetting('currency') === 'EUR' ? 'selected' : ''; ?>>Euro (EUR)</option>
                                        <option value="GBP" <?php echo $settingsManager->getSetting('currency', 'GBP') === 'GBP' ? 'selected' : ''; ?>>British Pound (GBP)</option>
                                        <option value="JPY" <?php echo $settingsManager->getSetting('currency') === 'JPY' ? 'selected' : ''; ?>>Japanese Yen (JPY)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Currency Position</label>
                                    <select class="settings-form-control" name="currency_position">
                                        <option value="left" <?php echo $settingsManager->getSetting('currency_position', 'left') === 'left' ? 'selected' : ''; ?>>Left (£99.99)</option>
                                        <option value="right" <?php echo $settingsManager->getSetting('currency_position') === 'right' ? 'selected' : ''; ?>>Right (99.99£)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Thousand Separator</label>
                                    <input type="text" class="settings-form-control" name="thousand_separator" 
                                           value="<?php echo htmlspecialchars($settingsManager->getSetting('thousand_separator', ',')); ?>">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Decimal Separator</label>
                                    <input type="text" class="settings-form-control" name="decimal_separator" 
                                           value="<?php echo htmlspecialchars($settingsManager->getSetting('decimal_separator', '.')); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="settings-form-group">
                            <label class="settings-form-label">Number of Decimals</label>
                            <input type="number" min="0" max="4" class="settings-form-control" name="number_of_decimals" 
                                   value="<?php echo htmlspecialchars($settingsManager->getSetting('number_of_decimals', '2')); ?>">
                        </div>
                        
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Payment Settings Tab -->
            <div class="settings-tab-content <?php echo $current_tab === 'payment' ? 'active' : ''; ?>" id="payment-tab">
                <form method="post">
                    <input type="hidden" name="tab" value="payment">
                    
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <h3 class="settings-card-title"><i class="fas fa-credit-card"></i> Payment Methods</h3>
                        </div>
                        <p class="settings-description">Enable and configure payment gateways for your store.</p>
                        
                        <div class="settings-form-group">
                            <div class="toggle-group">
                                <label class="switch">
                                    <input type="checkbox" name="stripe_enabled" 
                                        <?php echo $settingsManager->getSetting('stripe_enabled', '1') === '1' ? 'checked' : ''; ?>>
                                    <span class="slider"></span>
                                </label>
                                <span class="toggle-label">Credit/Debit Cards (Stripe)</span>
                            </div>
                        </div>
                        
                        <div class="settings-form-group">
                            <div class="toggle-group">
                                <label class="switch">
                                    <input type="checkbox" name="paypal_enabled" 
                                        <?php echo $settingsManager->getSetting('paypal_enabled', '1') === '1' ? 'checked' : ''; ?>>
                                    <span class="slider"></span>
                                </label>
                                <span class="toggle-label">PayPal</span>
                            </div>
                        </div>
                        
                        <div class="settings-form-group">
                            <label class="settings-form-label">Stripe Publishable Key</label>
                            <input type="text" class="settings-form-control" name="stripe_publishable_key" 
                                   value="<?php echo htmlspecialchars($settingsManager->getSetting('stripe_publishable_key', 'pk_test_...')); ?>">
                        </div>
                        
                        <div class="settings-form-group">
                            <label class="settings-form-label">Stripe Secret Key</label>
                            <input type="password" class="settings-form-control" name="stripe_secret_key" 
                                   value="<?php echo htmlspecialchars($settingsManager->getSetting('stripe_secret_key', 'sk_test_...')); ?>">
                        </div>
                        
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Shipping Settings Tab -->
            <div class="settings-tab-content <?php echo $current_tab === 'shipping' ? 'active' : ''; ?>" id="shipping-tab">
                <form method="post">
                    <input type="hidden" name="tab" value="shipping">
                    
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <h3 class="settings-card-title"><i class="fas fa-truck"></i> Shipping Options</h3>
                        </div>
                        <p class="settings-description">Configure your shipping methods and rates.</p>
                        
                        <div class="settings-form-group">
                            <div class="toggle-group">
                                <label class="switch">
                                    <input type="checkbox" name="free_shipping_enabled" 
                                        <?php echo $settingsManager->getSetting('free_shipping_enabled', '1') === '1' ? 'checked' : ''; ?>>
                                    <span class="slider"></span>
                                </label>
                                <span class="toggle-label">Free Shipping</span>
                            </div>
                        </div>
                        
                        <div class="settings-form-group">
                            <div class="toggle-group">
                                <label class="switch">
                                    <input type="checkbox" name="flat_rate_enabled" 
                                        <?php echo $settingsManager->getSetting('flat_rate_enabled', '1') === '1' ? 'checked' : ''; ?>>
                                    <span class="slider"></span>
                                </label>
                                <span class="toggle-label">Flat Rate Shipping</span>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Flat Rate Price</label>
                                    <input type="number" min="0" step="0.01" class="settings-form-control" name="flat_rate_price" 
                                           value="<?php echo htmlspecialchars($settingsManager->getSetting('flat_rate_price', '4.99')); ?>">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Free Shipping Minimum Order</label>
                                    <input type="number" min="0" step="0.01" class="settings-form-control" name="free_shipping_min" 
                                           value="<?php echo htmlspecialchars($settingsManager->getSetting('free_shipping_min', '50.00')); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Security Settings Tab -->
            <div class="settings-tab-content <?php echo $current_tab === 'security' ? 'active' : ''; ?>" id="security-tab">
                <form method="post">
                    <input type="hidden" name="tab" value="security">
                    
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <h3 class="settings-card-title"><i class="fas fa-shield-alt"></i> Security Settings</h3>
                        </div>
                        <p class="settings-description">Configure security options for your store.</p>
                        
                        <div class="settings-form-group">
                            <div class="toggle-group">
                                <label class="switch">
                                    <input type="checkbox" name="force_https" 
                                        <?php echo $settingsManager->getSetting('force_https', '1') === '1' ? 'checked' : ''; ?>>
                                    <span class="slider"></span>
                                </label>
                                <span class="toggle-label">Force HTTPS</span>
                            </div>
                        </div>
                        
                        <div class="settings-form-group">
                            <div class="toggle-group">
                                <label class="switch">
                                    <input type="checkbox" name="two_factor_auth" 
                                        <?php echo $settingsManager->getSetting('two_factor_auth', '1') === '1' ? 'checked' : ''; ?>>
                                    <span class="slider"></span>
                                </label>
                                <span class="toggle-label">Two-Factor Authentication</span>
                            </div>
                        </div>
                        
                        <div class="settings-form-group">
                            <label class="settings-form-label">Allowed IP Addresses (Admin Access)</label>
                            <textarea class="settings-form-control" name="allowed_ips" rows="3"><?php 
                                echo htmlspecialchars($settingsManager->getSetting('allowed_ips', "192.168.1.1\n203.0.113.42")); 
                            ?></textarea>
                            <small style="color: var(--gray); font-size: 0.8rem;">Enter one IP per line. Leave empty to allow all.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tab Switching Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.settings-tab');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    
                    // Update URL without reloading
                    window.history.pushState({}, '', `settings.php?tab=${tabId}`);
                    
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Hide all tab contents
                    document.querySelectorAll('.settings-tab-content').forEach(content => {
                        content.classList.remove('active');
                    });
                    
                    // Show selected tab content
                    document.getElementById(`${tabId}-tab`).classList.add('active');
                });
            });
            
            // Initialize toggle switches
            document.querySelectorAll('.switch input').forEach(switchInput => {
                const slider = switchInput.nextElementSibling;
                slider.style.backgroundColor = switchInput.checked ? '#3498db' : '#ccc';
                
                switchInput.addEventListener('change', function() {
                    slider.style.backgroundColor = this.checked ? '#3498db' : '#ccc';
                });
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
    </script>
</body>
</html>