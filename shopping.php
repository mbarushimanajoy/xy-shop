<?php
session_start();
require_once 'config.php'; // Database configuration

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (isset($_POST['product_id'], $_POST['quantity'])) {
                    $product_id = (int)$_POST['product_id'];
                    $quantity = (int)$_POST['quantity'];
                    
                    // Check if product exists in database
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->execute([$product_id]);
                    $product = $stmt->fetch();
                    
                    if ($product) {
                        // Add to cart or update quantity
                        if (isset($_SESSION['cart'][$product_id])) {
                            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                        } else {
                            $_SESSION['cart'][$product_id] = [
                                'id' => $product_id,
                                'name' => $product['name'],
                                'price' => $product['price'],
                                'image' => $product['image'],
                                'quantity' => $quantity,
                                'color' => $_POST['color'] ?? '',
                                'size' => $_POST['size'] ?? ''
                            ];
                        }
                    }
                }
                break;
                
            case 'update':
                if (isset($_POST['product_id'], $_POST['quantity'])) {
                    $product_id = (int)$_POST['product_id'];
                    $quantity = (int)$_POST['quantity'];
                    
                    if ($quantity > 0 && isset($_SESSION['cart'][$product_id])) {
                        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                    }
                }
                break;
                
            case 'remove':
                if (isset($_POST['product_id'])) {
                    $product_id = (int)$_POST['product_id'];
                    if (isset($_SESSION['cart'][$product_id])) {
                        unset($_SESSION['cart'][$product_id]);
                    }
                }
                break;
                
            case 'clear':
                $_SESSION['cart'] = [];
                break;
        }
    }
    
    // Redirect to prevent form resubmission
    header('Location: shopping.php');
    exit();
}

// Calculate cart totals
$subtotal = 0;
$shipping = 2500; // Fixed shipping cost
$tax_rate = 0.1; // 10% tax

foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$tax = $subtotal * $tax_rate;
$total = $subtotal + $shipping + $tax;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - XY_SHOP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #004b63;
            --primary-dark: #003b50;
            --secondary-color: darkcyan;
            --accent-color: #ff6b6b;
            --light-color: #f5f5f5;
            --dark-color: #333;
            --gray-color: #666;
            --border-color: #ddd;
            --white: #fff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        /* Header Styles */
        .navbar {
            height: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0 5%;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .logo {
            height: 50px;
            margin-right: 10px;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: var(--white);
        }
        
        .navbar nav ul {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 20px;
            margin: 0;
            padding: 0;
        }
        
        .navbar nav ul li {
            position: relative;
        }
        
        .navbar nav ul li a {
            color: var(--white);
            font-size: 16px;
            font-weight: 500;
            transition: var(--transition);
            padding: 8px 12px;
            border-radius: 5px;
        }
        
        .navbar nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--secondary-color);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
        }
        
        .cta-button {
            background-color: var(--secondary-color);
            padding: 8px 20px;
            border-radius: 5px;
            transition: var(--transition);
        }
        
        .cta-button:hover {
            background-color: var(--primary-dark);
        }
        
        /* Hero Section */
        .cart-hero {
            background-image: linear-gradient(rgba(0, 75, 99, 0.8), rgba(0, 75, 99, 0.8)), url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            color: var(--white);
            text-align: center;
        }
        
        .cart-hero h1 {
            font-size: 3rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        /* Main Cart Container */
        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 5%;
        }
        
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .cart-title {
            font-size: 2.2rem;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .continue-shopping {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-color);
            font-weight: 500;
            transition: var(--transition);
        }
        
        .continue-shopping:hover {
            color: var(--primary-dark);
        }
        
        .cart-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        /* Cart Items Section */
        .cart-items {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--shadow);
        }
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .cart-table th {
            text-align: left;
            padding: 15px 10px;
            border-bottom: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .cart-table td {
            padding: 20px 10px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        
        .product-cell {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .product-info h4 {
            margin: 0 0 5px;
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .product-info p {
            margin: 0;
            color: var(--gray-color);
            font-size: 0.9rem;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            background-color: var(--light-color);
            border: 1px solid var(--border-color);
            cursor: pointer;
            font-size: 14px;
            transition: var(--transition);
        }
        
        .quantity-btn:hover {
            background-color: var(--border-color);
        }
        
        .quantity-input {
            width: 50px;
            height: 30px;
            text-align: center;
            border: 1px solid var(--border-color);
            margin: 0 5px;
            font-weight: 500;
        }
        
        .remove-btn {
            background: none;
            border: none;
            color: var(--accent-color);
            cursor: pointer;
            font-size: 1.2rem;
            transition: var(--transition);
        }
        
        .remove-btn:hover {
            transform: scale(1.2);
        }
        
        /* Cart Summary Section */
        .cart-summary {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--shadow);
            height: fit-content;
            position: sticky;
            top: 100px;
        }
        
        .summary-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-top: 0;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
            font-weight: 600;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .summary-label {
            color: var(--gray-color);
        }
        
        .summary-value {
            font-weight: 500;
        }
        
        .total-row {
            border-top: 1px solid var(--border-color);
            padding-top: 15px;
            margin-top: 15px;
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .checkout-btn {
            width: 100%;
            padding: 15px;
            background-color: var(--secondary-color);
            color: var(--white);
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 20px;
        }
        
        .checkout-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .coupon-form {
            margin-top: 30px;
        }
        
        .coupon-form h4 {
            margin-bottom: 15px;
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .coupon-input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            margin-bottom: 10px;
            font-family: inherit;
        }
        
        .apply-coupon {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }
        
        .apply-coupon:hover {
            background-color: var(--primary-dark);
        }
        
        /* Cart Actions */
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .update-cart, .clear-cart {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .update-cart {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        .update-cart:hover {
            background-color: var(--primary-dark);
        }
        
        .clear-cart {
            background-color: var(--light-color);
            color: var(--gray-color);
            border: 1px solid var(--border-color);
        }
        
        .clear-cart:hover {
            background-color: var(--border-color);
        }
        
        /* Empty Cart State */
        .empty-cart {
            text-align: center;
            padding: 50px 0;
        }
        
        .empty-cart-icon {
            font-size: 5rem;
            color: var(--border-color);
            margin-bottom: 20px;
        }
        
        .empty-cart h3 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        .empty-cart p {
            color: var(--gray-color);
            margin-bottom: 30px;
        }
        
        .shop-btn {
            padding: 12px 30px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .shop-btn:hover {
            background-color: var(--primary-dark);
        }
        
        /* Footer Styles */
        .footer {
            background-color: #002f3f;
            color: var(--white);
            padding: 60px 5% 20px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer-section {
            margin-bottom: 30px;
        }
        
        .footer h4 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
            font-weight: 600;
        }
        
        .footer h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: var(--secondary-color);
        }
        
        .footer p {
            margin-bottom: 15px;
        }
        
        .footer ul {
            list-style: none;
            padding: 0;
        }
        
        .footer ul li {
            margin-bottom: 10px;
        }
        
        .footer ul li a {
            color: #49d6f3;
            transition: var(--transition);
        }
        
        .footer ul li a:hover {
            color: #4eedb5;
            padding-left: 5px;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            border-radius: 50%;
            color: var(--white);
            transition: var(--transition);
        }
        
        .social-links a:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }
            
            .cart-summary {
                position: static;
            }
        }
        
        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
                height: 70px;
            }
            
            .cart-hero h1 {
                font-size: 2.2rem;
            }
            
            .cart-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .cart-table th {
                display: none;
            }
            
            .cart-table td {
                display: block;
                padding: 15px 10px;
                position: relative;
                padding-left: 50%;
            }
            
            .cart-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                font-weight: 600;
                color: var(--primary-color);
            }
            
            .product-cell {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .quantity-selector {
                justify-content: flex-start;
            }
            
            .cart-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .update-cart, .clear-cart {
                width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .navbar nav ul {
                gap: 10px;
            }
            
            .navbar nav ul li a {
                padding: 6px 8px;
                font-size: 14px;
            }
            
            .cta-button {
                padding: 6px 12px;
            }
            
            .cart-hero {
                height: 200px;
            }
            
            .cart-hero h1 {
                font-size: 1.8rem;
            }
            
            .cart-title {
                font-size: 1.8rem;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .cart-items, .cart-summary {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1100;
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateX(150%);
            transition: transform 0.3s ease;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <header class="navbar">
        <div class="logo">
            <a href="index.php" class="logo-link">
                <img src="xy/logo.png" alt="XY_SHOP Logo" class="logo">
                <span class="logo-text">XY_SHOP</span>
            </a>
        </div>
        <nav>
            <ul>     
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li class="user-profile">
                    <div class="user-avatar"><?php echo isset($_SESSION['user']) ? substr($_SESSION['user']['name'], 0, 1) : 'G'; ?></div>
                </li>
                <li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="logout.php" class="cta-button">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="cta-button">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Cart Hero Section -->
    <section class="hero-section cart-hero">
        <h1>Your Shopping Cart</h1>
    </section>

    <!-- Cart Content -->
    <div class="cart-container">
        <div class="cart-header">
            <h2 class="cart-title">My Cart</h2>
            <a href="products.php" class="continue-shopping">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
        </div>
        
        <?php if (!empty($_SESSION['cart'])): ?>
        <div class="cart-layout">
            <div class="cart-items">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                        <tr>
                            <td data-label="Product">
                                <div class="product-cell">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="product-image">
                                    <div class="product-info">
                                        <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                        <?php if (!empty($item['color'])): ?>
                                        <p>Color: <?php echo htmlspecialchars($item['color']); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($item['size'])): ?>
                                        <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Price">RWF <?php echo number_format($item['price'], 0); ?></td>
                            <td data-label="Quantity">
                                <form method="post" class="quantity-form">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <div class="quantity-selector">
                                        <button type="button" class="quantity-btn minus-btn">-</button>
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
                                        <button type="button" class="quantity-btn plus-btn">+</button>
                                    </div>
                                </form>
                            </td>
                            <td data-label="Subtotal">RWF <?php echo number_format($item['price'] * $item['quantity'], 0); ?></td>
                            <td data-label="Remove">
                                <form method="post" class="remove-form">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="remove-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="cart-actions">
                    <form method="post">
                        <input type="hidden" name="action" value="clear">
                        <button type="submit" class="clear-cart">Clear Cart</button>
                    </form>
                    <button type="button" class="update-cart" id="update-all-btn">Update Cart</button>
                </div>
            </div>
            
            <div class="cart-summary">
                <h3 class="summary-title">Order Summary</h3>
                <div class="summary-row">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value">RWF <?php echo number_format($subtotal, 0); ?></span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Shipping</span>
                    <span class="summary-value">RWF <?php echo number_format($shipping, 0); ?></span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Tax (10%)</span>
                    <span class="summary-value">RWF <?php echo number_format($tax, 0); ?></span>
                </div>
                <div class="summary-row total-row">
                    <span class="summary-label">Total</span>
                    <span class="summary-value">RWF <?php echo number_format($total, 0); ?></span>
                </div>
                
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
                
                <div class="coupon-form">
                    <h4>Apply Coupon</h4>
                    <input type="text" placeholder="Enter coupon code" class="coupon-input" id="coupon-code">
                    <button class="apply-coupon" id="apply-coupon">Apply</button>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added any items to your cart yet</p>
            <a href="products.php" class="shop-btn">Start Shopping</a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About XY_SHOP</h4>
                <p>Located in Kigali City, Kicukiro District, XY_SHOP specializes in quality clothing and accessories with a focus on customer satisfaction.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Customer Service</h4>
                <ul>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="shipping.php">Shipping Policy</a></li>
                    <li><a href="returns.php">Return Policy</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact Us</h4>
                <p><i class="fas fa-map-marker-alt"></i> KN 123 St, Kicukiro, Kigali, Rwanda</p>
                <p><i class="fas fa-phone"></i> +250 123 456 789</p>
                <p><i class="fas fa-envelope"></i> info@xyshop.com</p>
                <p><i class="fas fa-clock"></i> Mon-Sat: 8:00 AM - 7:00 PM</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> XY_SHOP. All Rights Reserved. Designed with <i class="fas fa-heart" style="color: #ff6b6b;"></i> in Rwanda</p>
        </div>
    </footer>

    <!-- Notification Element -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notification-message">Cart updated successfully!</span>
    </div>

    <script>
        // Quantity selector functionality
        document.querySelectorAll('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                let value = parseInt(input.value);
                
                if (this.classList.contains('plus-btn')) {
                    input.value = value + 1;
                } else if (value > 1) {
                    input.value = value - 1;
                }
            });
        });
        
        // Update all quantities button
        document.getElementById('update-all-btn').addEventListener('click', function() {
            const forms = document.querySelectorAll('.quantity-form');
            forms.forEach(form => {
                fetch('shopping.php', {
                    method: 'POST',
                    body: new FormData(form)
                });
            });
            
            showNotification('Cart updated successfully!');
            setTimeout(() => {
                location.reload();
            }, 1000);
        });
        
        // Remove item functionality
        document.querySelectorAll('.remove-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    fetch('shopping.php', {
                        method: 'POST',
                        body: new FormData(form)
                    }).then(() => {
                        showNotification('Item removed from cart');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    });
                }
            });
        });
        
        // Clear cart button
        document.querySelector('.clear-cart')?.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear your entire cart?')) {
                fetch('shopping.php', {
                    method: 'POST',
                    body: new FormData(this.parentElement)
                }).then(() => {
                    showNotification('Cart cleared');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                });
            }
        });
        
        // Apply coupon button
        document.getElementById('apply-coupon')?.addEventListener('click', function() {
            const couponCode = document.getElementById('coupon-code').value;
            if (couponCode) {
                // In a real app, this would validate the coupon with the server
                fetch('apply_coupon.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ coupon: couponCode })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Coupon applied successfully!');
                        // Update the totals with the discount
                        location.reload();
                    } else {
                        showNotification(data.message || 'Invalid coupon code', 'error');
                    }
                })
                .catch(() => {
                    showNotification('Error applying coupon', 'error');
                });
            } else {
                showNotification('Please enter a coupon code', 'error');
            }
        });
        
        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            const messageElement = document.getElementById('notification-message');
            
            messageElement.textContent = message;
            notification.className = 'notification';
            notification.classList.add(type === 'error' ? 'error' : 'success');
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>