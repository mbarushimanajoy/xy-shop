<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - XY_SHOP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        
        /* Logo Styling */
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

        .navbar {
            height: 12vh;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #004b63;
            color: white;
            padding: 15px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar nav ul li a {
            color: white;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s ease;
            padding: 8px 12px;
            border-radius: 5px;
        }
        
        .navbar nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .cta-button {
            background-color: #004b63;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #003d4f;
            color: white;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: #004b63;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Hero Section */
        .hero-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 2rem;
        }

        .about-hero {
            background-image: linear-gradient(rgba(0, 75, 99, 0.8), rgba(0, 75, 99, 0.8)),
            url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');
            height: 50vh;
            background-size: cover;
            background-position: center;
        }

        .about-hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .about-hero p {
            font-size: 1.2rem;
            max-width: 800px;
        }

        /* About Content */
        .about-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .about-section {
            margin-bottom: 60px;
        }

        .about-section h2 {
            color: #004b63;
            font-size: 2rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .about-section h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 80px;
            height: 3px;
            background-color: darkcyan;
        }

        /* Mission & Vision */
        .mission-vision {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 40px;
        }

        .mission-card, .vision-card {
            background-color: #f5f5f5;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .mission-card h3, .vision-card h3 {
            color: #004b63;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .mission-card h3 i, .vision-card h3 i {
            margin-right: 10px;
        }

        /* Team Section */
        .team {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .team-member {
            text-align: center;
        }

        .team-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid #004b63;
        }

        /* Values Section */
        .values-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .value-item {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .value-item:hover {
            transform: translateY(-5px);
        }

        .value-icon {
            font-size: 2rem;
            color: #004b63;
            margin-bottom: 15px;
        }

        /* Footer Styles */
        .footer {
            background-color: #004b63;
            color: white;
            padding: 3rem 5%;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section h4 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-section h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: darkcyan;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: white;
        }

        .footer-section p {
            margin-bottom: 10px;
            color: #ddd;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            color: white;
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        .social-links a:hover {
            color: darkcyan;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
            }
            
            .navbar nav ul {
                margin-top: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .navbar nav ul li {
                margin: 0.5rem;
            }
            
            .about-hero h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <a href="dashboard.php" class="logo-link">
                <img src="xy/logo.png" alt="XY_SHOP Logo" class="logo">
                <span class="logo-text">XY_SHOP</span>
            </a>
        </div>
        <nav>
            <ul>
            <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="productdetail.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li class="user-profile">
                    <div class="user-avatar">JS</div>
                </li>
                <li><a href="login.php" class="cta-button">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero-section about-hero">
        <h1>Our Story</h1>
        <p>Discover the passion behind XY_SHOP and our commitment to quality fashion</p>
    </section>

    <div class="about-content">
        <section class="about-section">
            <h2>Who We Are</h2>
            <p>Founded in 2024 in Kigali, Rwanda, XY_SHOP began as a small boutique with a big dream: to bring high-quality, affordable fashion to everyone in Rwanda. What started as a single store in Kicukiro District has grown into one of Rwanda's most trusted online fashion destinations.</p>
            <p>Our team of fashion enthusiasts carefully curates each collection to ensure we offer the latest trends without compromising on quality or comfort. We believe that everyone deserves to look and feel their best, regardless of budget.</p>
        </section>

        <section class="about-section">
            <h2>Our Mission & Vision</h2>
            <div class="mission-vision">
                <div class="mission-card">
                    <h3><i class="fas fa-bullseye"></i> Our Mission</h3>
                    <p>To empower individuals through fashion by providing high-quality, affordable clothing that boosts confidence and expresses personal style, while maintaining ethical business practices and excellent customer service.</p>
                </div>
                <div class="vision-card">
                    <h3><i class="fas fa-eye"></i> Our Vision</h3>
                    <p>To become Rwanda's leading fashion retailer, recognized for our commitment to quality, customer satisfaction, and innovative shopping experiences both online and in-store.</p>
                </div>
            </div>
        </section>

        <section class="about-section">
            <h2>Our Team</h2>
            <p>Behind XY_SHOP is a dedicated team of fashion experts, customer service professionals, and logistics specialists who work tirelessly to ensure your shopping experience is exceptional.</p>
            <div class="team">
                <div class="team-member">
                    <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Marie Claire" class="team-photo">
                    <h3>Marie Claire</h3>
                    <p>Founder & CEO</p>
                </div>
                <div class="team-member">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Jean Paul" class="team-photo">
                    <h3>Jean Paul</h3>
                    <p>Head of Operations</p>
                </div>
                <div class="team-member">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Amina" class="team-photo">
                    <h3>Amina</h3>
                    <p>Fashion Director</p>
                </div>
                <div class="team-member">
                    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Eric" class="team-photo">
                    <h3>Eric</h3>
                    <p>Customer Service Manager</p>
                </div>
            </div>
        </section>

        <section class="about-section">
            <h2>Our Values</h2>
            <p>These core values guide everything we do at XY_SHOP:</p>
            <div class="values-list">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h3>Quality First</h3>
                    <p>We never compromise on the quality of our products, ensuring durability and comfort in every piece.</p>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3>Customer Focus</h3>
                    <p>Your satisfaction is our priority. We listen, adapt, and go the extra mile for every customer.</p>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Sustainability</h3>
                    <p>We're committed to eco-friendly practices and ethical sourcing throughout our supply chain.</p>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3>Innovation</h3>
                    <p>We continuously improve our products and services to stay ahead in the fashion industry.</p>
                </div>
            </div>
        </section>
    </div>

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
                <li><a href="productdetail.php">Categories</a></li>
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
            <p>&copy; <?php echo date("Y"); ?> XY_SHOP. All Rights Reserved. Designed with <i class="fas fa-heart" style="color: #ff6b6b;"></i> in Rwanda</p>
        </div>
    </footer>
</body>
</html>