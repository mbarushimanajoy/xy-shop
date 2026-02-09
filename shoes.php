<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Black Shoes Collection</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            color: white;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Navigation Bar */
        .navbar nav ul {
    list-style: none; /* Remove bullet points */
    display: flex; /* Align items in a row */
    align-items: center; /* Vertically align items */
    gap: 20px; /* Space between items */
    margin: 0;
    padding: 0;
}

.navbar nav ul li {
    position: relative; /* Position for dropdown menu */
}

.navbar nav ul li select {
    background-color: #004b63;
    color: white;
    border: none;
    font-size: 16px;
    font-weight: bold;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}

.navbar nav ul li select:hover {
    background-color: #003b50;
}

.navbar nav ul li select option {
    background-color: #004b63;
    color: white;
}

/* Optional: Ensure dropdown options display horizontally if required */
.navbar nav ul li select optgroup {
    display: inline-block;
    white-space: nowrap;
}

        .navbar {
            height: 12vh;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #004b63;
            color: white;
            padding: 15px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar nav ul {
            list-style: none;
            display: flex;
            gap: 30px;
        }
        .navbar nav ul li {
            position: relative;
        }
        .navbar nav ul li a {
            color: white;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .navbar nav ul li a:hover {
            color: #004b63;
        }
        .cta-button {
            background-color: darkcyan;
            color: #333;
            font-size: 18px;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .cta-button:hover {
            background-color: #004b63;
        }

        /* Dropdown Styling */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #004b63;
            color: white;
            border: none;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .dropdown select:hover {
            background-color: #003b50;
        }

        select option {
            color: white;
        }
        .header {
            background-color: #004b63;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .header h1{
            color: white;
        }
        main {
            padding: 20px;
        }
        .hero {
            background-image: url('xy/pa.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .hero h2 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }

        .hero .btn {
            background-color: #007BFF;
            color: white;
            padding: 12px 30px;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .hero .btn:hover {
            background-color: #0056b3;
        }

        /* Page Content Styling */
        .product-page {
            max-width: 1200px;
            margin: 120px auto 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
            color: #333;
        }

        /* Product Grid Styling */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* Default: 5 cards per row */
            gap: 20px; /* Space between cards */
        }

        .product-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .product-card img {
            width: 100%;
            max-width: 150px;
            margin: 0 auto 15px;
            border-radius: 10px;
        }

        .product-card h3 {
            font-size: 1.1rem;
            margin: 10px 0;
        }

        .product-card p {
            color: #d9534f;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .product-card .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .product-card .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Styling */
        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr); /* 4 cards per row */
            }
        }

        @media (max-width: 992px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr); /* 3 cards per row */
            }
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 cards per row */
            }
        }

        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr; /* 1 card per row */
            }
        }

        /* Footer Styling */
        .footer {
            background-color: #004b63;
            color: white;
            text-align: center;
            padding: 20px 10px;
            margin-top: auto;
        }

        .footer .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .footer .footer-section {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .footer h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .footer p, .footer ul {
            font-size: 14px;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 5px;
        }

        .footer ul li a {
            color: #49d6f3;
            transition: color 0.3s ease;
        }

        .footer ul li a:hover {
            color: #4eedb5;
        }

        .footer-bottom {
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<header class="navbar">
        <div class="logo">
            <a href="dashboard.php" class="logo-link">
                <img src="xy/logo.png" alt="dashboard.php" class="logo">
                <span class="logo-text">XY_SHOP</span>
            </a>
        </div>
        <nav>
            <ul>
            <li><a href="dashboard.php">Home</a></li>
                <li ><a href="index.php">View Products</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="login.php" class="cta-button">Login</a></li>
            </ul>
        </nav>
    </header>
    <div class="header">
        <h1>Shoes</h1>
        <a href="index.php" style="color: white; text-decoration: none;">Back to View Products</a>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h2>Discover Your Perfect Pair of  Shoes</h2>
            <p>Stylish, Comfortable, and Perfect for Every Occasion</p>
            <a href="shoes.php" class="btn">Shop Now</a>
        </div>
    </section>

    <!-- Product Page -->
    <div class="product-page">
        <h1>Our Shoes</h1>
        
        <div class="product-grid">
            <!-- Repeat Product Cards -->
            <div class="product-card">
                <img src="xy/shoes/p.jpg" alt="Casual Black Shoes">
                <h3>Casual Black Shoes</h3>
                <p>$29.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p2.jpg" alt="Formal Black Shoes">
                <h3>Formal Black Shoes</h3>
                <p>$49.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p3.jpg" alt="Sports Black Shoes">
                <h3>Sports Black Shoes</h3>
                <p>$39.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p4.jpg" alt="Designer Black Shoes">
                <h3>Designer Black Shoes</h3>
                <p>$89.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p5.jpg" alt="Outdoor Black Shoes">
                <h3>Outdoor Black Shoes</h3>
                <p>$59.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>
            <div class="product-card">
                <img src="xy/shoes/p6.jpg" alt="Casual Black Shoes">
                <h3>Casual Black Shoes</h3>
                <p>$29.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p7.jpg" alt="Formal Black Shoes">
                <h3>Formal Black Shoes</h3>
                <p>$49.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p40.jpg" alt="Sports Black Shoes">
                <h3>Sports Black Shoes</h3>
                <p>$39.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p9.jpg" alt="Designer Black Shoes">
                <h3>Designer Black Shoes</h3>
                <p>$89.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p10.jpg" alt="Outdoor Black Shoes">
                <h3>Outdoor Black Shoes</h3>
                <p>$59.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>
            <div class="product-card">
                <img src="xy/shoes/p11.jpg" alt="Casual Black Shoes">
                <h3>Casual Black Shoes</h3>
                <p>$29.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p1.jpg" alt="Formal Black Shoes">
                <h3>Formal Black Shoes</h3>
                <p>$49.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p13.jpg" alt="Sports Black Shoes">
                <h3>Sports Black Shoes</h3>
                <p>$39.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p14.jpg" alt="Designer Black Shoes">
                <h3>Designer Black Shoes</h3>
                <p>$89.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p15.jpg" alt="Outdoor Black Shoes">
                <h3>Outdoor Black Shoes</h3>
                <p>$59.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>
            <div class="product-card">
                <img src="xy/shoes/p16.jpg" alt="Casual Black Shoes">
                <h3>Casual Black Shoes</h3>
                <p>$29.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p17.jpg" alt="Formal Black Shoes">
                <h3>Formal Black Shoes</h3>
                <p>$49.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p18.jpg" alt="Sports Black Shoes">
                <h3>Sports Black Shoes</h3>
                <p>$39.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p19.jpg" alt="Designer Black Shoes">
                <h3>Designer Black Shoes</h3>
                <p>$89.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p20.jpg" alt="Outdoor Black Shoes">
                <h3>Outdoor Black Shoes</h3>
                <p>$59.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>
            <div class="product-card">
                <img src="xy/shoes/p21.jpg" alt="Casual Black Shoes">
                <h3>Casual Black Shoes</h3>
                <p>$29.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p52.jpg" alt="Formal Black Shoes">
                <h3>Formal Black Shoes</h3>
                <p>$49.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p53.jpg" alt="Sports Black Shoes">
                <h3>Sports Black Shoes</h3>
                <p>$39.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p24.jpg" alt="Designer Black Shoes">
                <h3>Designer Black Shoes</h3>
                <p>$89.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/p25.jpg" alt="Outdoor Black Shoes">
                <h3>Outdoor Black Shoes</h3>
                <p>$59.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>
        </div>
    </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About XY Shop</h4>
                <p>Located in Kigali City, Kicukiro District, XY Shop specializes in quality clothing and reliable inventory management solutions.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="index.php">Products</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact Us</h4>
                <p>Email: info@xyshop.com</p>
                <p>Phone: +250 123 456 789</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 XY Shop. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
