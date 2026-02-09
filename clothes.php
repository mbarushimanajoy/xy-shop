<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothes</title>
    <style>
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
        main {
            padding: 20px;
        }
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
        .footer {

margin: 0;
padding: 0;
background-color: #004b63;
color: white;
padding: 30px 20px;
text-align: center;
margin-top: 0vh;
}
.footer .footer-content {
display: flex;
flex-wrap: wrap;
justify-content: space-around;
margin-bottom: 20px;
color: white;

}
.footer .footer-section {
max-width: 300px;
margin-bottom: 20px;
text-emphasis-color: white;
color: white;

}
.footer h4 {
font-size: 18px;
margin-bottom: 10px;
color: white;

}
.footer p, .footer ul {
font-size: 14px;
color: white;

}
.footer ul {
list-style: none;
padding: 0;
color: white;

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
color: white;

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
                <li><a href="products.php">Products</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="login.php" class="cta-button">Login</a></li>
            </ul>
        </nav>
    </header>
    <div class="header">
        <h1>Clothes</h1>
        <a href="index.php" style="color: white; text-decoration: none;">Back to View Products</a>
    </div>
    <main>
    <div class="product-page">
        <center><h1>Our Clothes</h1></center>
        
        <div class="product-grid">
            <!-- Repeat Product Cards -->
            <div class="product-card">
                <img src="xy/shoes/c1.jpg" alt="Casual Black Shoes">
                <h3>Casual Black Shoes</h3>
                <p>$29.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/c2.jpg" alt="Formal Black Shoes">
                <h3>Formal Black Shoes</h3>
                <p>$49.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/c3.jpg" alt="Sports Black Shoes">
                <h3>Sports Black Shoes</h3>
                <p>$39.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/c4.jpg" alt="Designer Black Shoes">
                <h3>Designer Black Shoes</h3>
                <p>$89.99</p>
                <a href="#" class="btn">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="xy/shoes/c5.jpg" alt="Outdoor Black Shoes">
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

    </main>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About XY Shop</h4>
                <p>Located in Kigali City, Kicukiro District, XY Shop specializes in quality clothing and reliable inventory management solutions.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
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
