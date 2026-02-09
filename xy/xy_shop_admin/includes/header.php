<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('/xy_shop_admin/login.php');
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY_SHOP Admin - <?php echo ucfirst(str_replace('.php', '', $current_page)); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/xy_shop_admin/assets/css/style.css">
</head>
<body>
    <div class="admin-container">
        <?php include __DIR__ . '/sidebar.php'; ?>
        <div class="admin-main">
            <div class="admin-header">
                <button class="admin-toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="admin-title"><?php echo ucfirst(str_replace('.php', '', $current_page)); ?></h1>
                <div class="admin-user" id="userDropdown">
                    <div class="admin-user-avatar"><?php echo substr($_SESSION['username'], 0, 2); ?></div>
                    <span><?php echo $_SESSION['username']; ?></span>
                    <i class="fas fa-chevron-down"></i>
                    <div class="admin-user-dropdown">
                        <a href="/xy_shop_admin/profile.php" class="admin-user-dropdown-item"><i class="fas fa-user"></i> Profile</a>
                        <a href="/xy_shop_admin/settings/" class="admin-user-dropdown-item"><i class="fas fa-cog"></i> Settings</a>
                        <a href="/xy_shop_admin/logout.php" class="admin-user-dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>