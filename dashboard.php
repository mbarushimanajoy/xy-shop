<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY_SHOP - Professional Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #004b63;
            --secondary-color: #ffcc00;
            --accent-color: darkcyan;
            --light-bg: #f9f9f9;
            --dark-text: #333;
            --light-text: #fff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        /* Base Styles */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navigation Bar */
        .navbar {
            height: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--primary-color);
            color: var(--light-text);
            padding: 0 5%;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar.scrolled {
            height: 70px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: var(--transition);
        }

        .logo {
            height: 50px;
            margin-right: 10px;
            transition: var(--transition);
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: var(--light-text);
            transition: var(--transition);
        }

        .navbar.scrolled .logo {
            height: 40px;
        }

        .navbar.scrolled .logo-text {
            font-size: 20px;
        }

        .navbar nav ul {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 25px;
            margin: 0;
            padding: 0;
        }

        .navbar nav ul li {
            position: relative;
        }

        .navbar nav ul li a {
            color: var(--light-text);
            font-size: 16px;
            font-weight: 600;
            transition: var(--transition);
            padding: 8px 12px;
            border-radius: 5px;
            position: relative;
        }

        .navbar nav ul li a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            bottom: 0;
            left: 0;
            transition: var(--transition);
        }

        .navbar nav ul li a:hover:after {
            width: 100%;
        }

        .navbar nav ul li a:hover {
            color: var(--secondary-color);
        }

        .cta-button {
            background-color: var(--accent-color);
            color: var(--light-text);
            font-size: 16px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 5px;
            transition: var(--transition);
            border: 2px solid var(--accent-color);
        }

        .cta-button:hover {
            background-color: transparent;
            color: var(--light-text);
            transform: translateY(-2px);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-text);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: var(--transition);
        }

        .user-avatar:hover {
            transform: scale(1.1);
        }

        /* Hero Section */
        .hero-section {
            background-image: linear-gradient(rgba(0, 75, 99, 0.8), rgba(0, 75, 99, 0.8)), url('https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--light-text);
            text-align: center;
            padding: 0 20px;
            position: relative;
            overflow: hidden;
        }

        .hero-section:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(transparent, var(--light-bg));
            z-index: 1;
        }

        .hero-content {
            max-width: 900px;
            z-index: 2;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
            animation: fadeIn 1s ease;
            font-weight: 800;
        }

        .hero-section p {
            font-size: 1.5rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1.5s ease;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            animation: fadeIn 2s ease;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero-btn {
            background-color: var(--secondary-color);
            color: var(--dark-text);
            font-size: 18px;
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            min-width: 180px;
        }

        .hero-btn:hover {
            background-color: #ffaa00;
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .secondary-btn {
            background-color: transparent;
            color: var(--light-text);
            border: 2px solid var(--light-text);
        }

        .secondary-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--light-text);
        }

        /* Features Section */
        .features {
            padding: 100px 5%;
            background-color: var(--light-text);
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
            color: var(--primary-color);
            font-size: 2.5rem;
            font-weight: 700;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--accent-color);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background-color: var(--light-bg);
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: rgba(0, 139, 139, 0.2);
        }

        .feature-icon {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            transition: var(--transition);
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            color: var(--accent-color);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .feature-card p {
            color: #666;
            font-size: 1.05rem;
        }

        /* Products Preview */
        .products-preview {
            padding: 100px 5%;
            background-color: var(--light-bg);
            position: relative;
        }

        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto 50px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .products-search {
            position: relative;
            width: 300px;
        }

        .products-search input {
            width: 100%;
            padding: 12px 20px;
            border-radius: 50px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: var(--transition);
            padding-left: 45px;
        }

        .products-search input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 75, 99, 0.1);
        }

        .products-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-card {
            background-color: var(--light-text);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            position: relative;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--secondary-color);
            color: var(--dark-text);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            z-index: 1;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 250px;
            background-size: cover;
            background-position: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-overlay {
            position: absolute;
            bottom: -100%;
            left: 0;
            width: 100%;
            background: rgba(0, 75, 99, 0.9);
            color: var(--light-text);
            padding: 20px;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .product-card:hover .product-overlay {
            bottom: 0;
        }

        .overlay-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--light-text);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .overlay-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-5px);
        }

        .product-info {
            padding: 20px;
            position: relative;
        }

        .product-info h3 {
            margin: 0 0 10px;
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 600;
        }

        .product-category {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 10px;
            display: block;
        }

        .product-price {
            font-weight: bold;
            color: var(--accent-color);
            font-size: 1.3rem;
            margin: 10px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 1rem;
        }

        .product-rating {
            color: var(--secondary-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .rating-count {
            color: #777;
            font-size: 0.9rem;
        }

        .add-to-cart {
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .add-to-cart:hover {
            background-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .view-more {
            text-align: center;
            margin-top: 50px;
        }

        .view-more-btn {
            background-color: var(--primary-color);
            color: var(--light-text);
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .view-more-btn:hover {
            background-color: var(--accent-color);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Testimonials */
        .testimonials {
            padding: 100px 5%;
            background-color: var(--light-text);
            position: relative;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .testimonial-card {
            background-color: var(--light-bg);
            border-radius: 15px;
            padding: 40px 30px;
            position: relative;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .testimonial-quote {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 3rem;
            color: rgba(0, 75, 99, 0.1);
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 30px;
            color: #555;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: var(--light-text);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .author-info h4 {
            margin: 0;
            color: var(--primary-color);
            font-weight: 600;
        }

        .author-info p {
            margin: 5px 0 0;
            color: #777;
            font-size: 0.9rem;
        }

        /* Newsletter */
        .newsletter {
            padding: 100px 5%;
            background-color: var(--primary-color);
            color: var(--light-text);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .newsletter:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80') center/cover;
            opacity: 0.1;
            z-index: 0;
        }

        .newsletter-container {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .newsletter h2 {
            margin-bottom: 20px;
            font-size: 2.2rem;
        }

        .newsletter p {
            margin-bottom: 40px;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .newsletter-form {
            display: flex;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .newsletter-form input {
            flex: 1;
            padding: 18px 25px;
            border: none;
            font-size: 1rem;
        }

        .newsletter-form input:focus {
            outline: none;
        }

        .newsletter-form button {
            background-color: var(--secondary-color);
            color: var(--dark-text);
            border: none;
            padding: 0 35px;
            cursor: pointer;
            font-size: 1rem;
            transition: var(--transition);
            font-weight: 600;
            white-space: nowrap;
        }

        .newsletter-form button:hover {
            background-color: #ffaa00;
        }

        /* Footer */
        .footer {
            background-color: #002f3f;
            color: var(--light-text);
            padding: 80px 5% 30px;
            position: relative;
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
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
            font-weight: 600;
        }

        .footer h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
        }

        .footer p {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 12px;
        }

        .footer ul li a {
            color: #49d6f3;
            transition: var(--transition);
            display: inline-block;
        }

        .footer ul li a:hover {
            color: var(--secondary-color);
            transform: translateX(5px);
        }

        .contact-info {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }

        .contact-icon {
            color: var(--accent-color);
            font-size: 1.1rem;
            margin-top: 3px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: var(--light-text);
            transition: var(--transition);
            font-size: 1.1rem;
        }

        .social-links a:hover {
            background-color: var(--accent-color);
            transform: translateY(-5px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 50px;
            margin-top: 50px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-heart {
            color: #ff6b6b;
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            color: var(--light-text);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            opacity: 0;
            visibility: hidden;
            z-index: 999;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background-color: var(--accent-color);
            transform: translateY(-5px);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-section h1 {
                font-size: 2.8rem;
            }
            
            .hero-section p {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                height: auto;
                padding: 15px 5%;
                flex-direction: column;
                gap: 15px;
            }
            
            .navbar nav ul {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }
            
            .navbar nav ul li {
                width: 100%;
                text-align: center;
            }
            
            .navbar nav ul li a {
                display: block;
                padding: 10px;
            }
            
            .hero-section {
                height: auto;
                padding: 100px 20px;
            }
            
            .hero-section h1 {
                font-size: 2.2rem;
            }
            
            .hero-section p {
                font-size: 1.1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                gap: 15px;
            }
            
            .hero-btn {
                width: 100%;
            }
            
            .newsletter-form {
                flex-direction: column;
                border-radius: 5px;
            }
            
            .newsletter-form input,
            .newsletter-form button {
                border-radius: 5px;
                width: 100%;
            }
            
            .newsletter-form button {
                padding: 15px;
                margin-top: 10px;
            }
            
            .products-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .products-search {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .section-title {
                font-size: 2rem;
            }
            
            .feature-card {
                padding: 30px 20px;
            }
            
            .testimonial-card {
                padding: 30px 20px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        /* Admin Dashboard Styles */
        .admin-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f7fa;
        }

        .admin-sidebar {
            width: 280px;
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            transition: all 0.3s;
            position: fixed;
            height: 100%;
            z-index: 1000;
        }

        .admin-sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-sidebar-header h3 {
            margin: 0;
            font-weight: 600;
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
            transition: all 0.3s;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .admin-menu-item:hover, .admin-menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent-color);
        }

        .admin-menu-item i {
            width: 24px;
            text-align: center;
        }

        .admin-submenu {
            padding-left: 20px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s;
        }

        .admin-submenu.show {
            max-height: 500px;
        }

        .admin-submenu-item {
            padding: 10px 20px 10px 40px;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s;
            display: block;
        }

        .admin-submenu-item:hover, .admin-submenu-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .admin-main {
            flex: 1;
            margin-left: 280px;
            padding: 20px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .admin-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .admin-content {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .admin-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .admin-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .admin-card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .admin-card-actions {
            display: flex;
            gap: 10px;
        }

        .admin-btn {
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .admin-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .admin-btn-primary:hover {
            background-color: #003b50;
        }

        .admin-btn-secondary {
            background-color: #f0f0f0;
            color: #333;
        }

        .admin-btn-secondary:hover {
            background-color: #e0e0e0;
        }

        .admin-btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .admin-btn-danger:hover {
            background-color: #c0392b;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th, .admin-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .admin-table th {
            background-color: #f9f9f9;
            color: #555;
            font-weight: 600;
        }

        .admin-table tr:hover {
            background-color: #f5f5f5;
        }

        .admin-table-actions {
            display: flex;
            gap: 5px;
        }

        .admin-form-group {
            margin-bottom: 20px;
        }

        .admin-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .admin-form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .admin-form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 75, 99, 0.1);
        }

        .admin-alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .admin-alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .admin-alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .admin-stat-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
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

        .admin-stat-icon {
            font-size: 2rem;
            color: var(--accent-color);
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
                width: 280px;
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

        /* Modal */
        .admin-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1100;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .admin-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .admin-modal-content {
            background-color: white;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(-20px);
            transition: all 0.3s;
        }

        .admin-modal.show .admin-modal-content {
            transform: translateY(0);
        }

        .admin-modal-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-modal-title {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .admin-modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #777;
        }

        .admin-modal-body {
            padding: 20px;
        }

        .admin-modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
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
                <li><a href="productdetail.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li class="user-profile">
                    <div class="user-avatar">SK</div>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Premium Fashion for Everyone</h1>
            <p>Discover our exclusive collection of high-quality clothing and accessories at unbeatable prices. Experience the perfect blend of style and comfort.</p>
            <div class="hero-buttons">
                <button class="hero-btn" onclick="location.href='products.php';">Shop Now</button>
                <button class="hero-btn secondary-btn" onclick="location.href='about.php';">Learn More</button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2 class="section-title">Why Choose XY_SHOP</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Fast Delivery</h3>
                <p>Get your orders delivered to your doorstep within 24 hours in Kigali and 3-5 days nationwide with our premium shipping partners.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Quality Guarantee</h3>
                <p>All our products undergo strict quality checks to ensure you get only the best. 100% satisfaction guaranteed or your money back.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <h3>Easy Returns</h3>
                <p>Not satisfied? Return within 14 days for a full refund or exchange. Our hassle-free return policy puts you first.</p>
            </div>
        </div>
    </section>

    <!-- Products Preview -->
    <section class="products-preview">
        <div class="products-header">
            <h2 class="section-title">Featured Products</h2>
            <div class="products-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search products...">
            </div>
        </div>
        <div class="products-grid">
            <div class="product-card">
                <div class="product-badge">New</div>
                <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');">
                    <div class="product-overlay">
                        <button class="overlay-btn" title="Quick View"><i class="fas fa-eye"></i></button>
                        <button class="overlay-btn" title="Add to Wishlist"><i class="fas fa-heart"></i></button>
                        <button class="overlay-btn" title="Compare"><i class="fas fa-exchange-alt"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <span class="product-category">Men's Clothing</span>
                    <h3>Men's Casual Shirt</h3>
                    <div class="product-price">
                        RWF 25,000
                        <span class="old-price">RWF 30,000</span>
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="rating-count">(42)</span>
                    </div>
                    <button class="add-to-cart">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            </div>
            <div class="product-card">
                <div class="product-badge">-15%</div>
                <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');">
                    <div class="product-overlay">
                        <button class="overlay-btn" title="Quick View"><i class="fas fa-eye"></i></button>
                        <button class="overlay-btn" title="Add to Wishlist"><i class="fas fa-heart"></i></button>
                        <button class="overlay-btn" title="Compare"><i class="fas fa-exchange-alt"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <span class="product-category">Women's Clothing</span>
                    <h3>Women's Summer Dress</h3>
                    <div class="product-price">
                        RWF 35,000
                        <span class="old-price">RWF 41,000</span>
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <span class="rating-count">(28)</span>
                    </div>
                    <button class="add-to-cart">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1523170335258-f5ed11844a49?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');">
                    <div class="product-overlay">
                        <button class="overlay-btn" title="Quick View"><i class="fas fa-eye"></i></button>
                        <button class="overlay-btn" title="Add to Wishlist"><i class="fas fa-heart"></i></button>
                        <button class="overlay-btn" title="Compare"><i class="fas fa-exchange-alt"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <span class="product-category">Footwear</span>
                    <h3>Unisex Sneakers</h3>
                    <div class="product-price">RWF 45,000</div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span class="rating-count">(56)</span>
                    </div>
                    <button class="add-to-cart">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            </div>
            <div class="product-card">
                <div class="product-badge">Bestseller</div>
                <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');">
                    <div class="product-overlay">
                        <button class="overlay-btn" title="Quick View"><i class="fas fa-eye"></i></button>
                        <button class="overlay-btn" title="Add to Wishlist"><i class="fas fa-heart"></i></button>
                        <button class="overlay-btn" title="Compare"><i class="fas fa-exchange-alt"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <span class="product-category">Accessories</span>
                    <h3>Leather Handbag</h3>
                    <div class="product-price">RWF 55,000</div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="rating-count">(37)</span>
                    </div>
                    <button class="add-to-cart">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
        <div class="view-more">
            <button class="view-more-btn" onclick="location.href='products.php';">View All Products</button>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <h2 class="section-title">What Our Customers Say</h2>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-quote">
                    <i class="fas fa-quote-right"></i>
                </div>
                <div class="testimonial-text">
                    "I've been shopping at XY_SHOP for over a year now and I'm always impressed with their quality and customer service. The delivery is always on time and the products exceed my expectations. Highly recommended!"
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">JD</div>
                    <div class="author-info">
                        <h4>Jean D'amour</h4>
                        <p>Kigali, Rwanda</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-quote">
                    <i class="fas fa-quote-right"></i>
                </div>
                <div class="testimonial-text">
                    "The delivery was super fast and the dress I ordered fits perfectly. The quality is amazing for the price. I'll definitely be shopping here again and telling my friends about XY_SHOP!"
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">AM</div>
                    <div class="author-info">
                        <h4>Alice Mukamana</h4>
                        <p>Musanze, Rwanda</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-quote">
                    <i class="fas fa-quote-right"></i>
                </div>
                <div class="testimonial-text">
                    "Great prices for such high-quality products. The return process was also very easy when I needed to exchange a size. Customer support was helpful and responsive throughout the process."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">PK</div>
                    <div class="author-info">
                        <h4>Paul Kagabo</h4>
                        <p>Huye, Rwanda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="newsletter-container">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Get the latest updates on new products, special offers, and fashion tips straight to your inbox. Join our community of 10,000+ subscribers today!</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe <i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About XY_SHOP</h4>
                <p>Located in Kigali City, Kicukiro District, XY_SHOP specializes in quality clothing and accessories with a focus on customer satisfaction and affordable fashion.</p>
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
                    <li><a href="faq.html">FAQ</a></li>
                    <li><a href="shipping.html">Shipping Policy</a></li>
                    <li><a href="returns.html">Return Policy</a></li>
                    <li><a href="privacy.html">Privacy Policy</a></li>
                    <li><a href="terms.html">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact Us</h4>
                <div class="contact-info">
                    <i class="fas fa-map-marker-alt contact-icon"></i>
                    <p>KN 123 St, Kicukiro, Kigali, Rwanda</p>
                </div>
                <div class="contact-info">
                    <i class="fas fa-phone contact-icon"></i>
                    <p>+250 123 456 789</p>
                </div>
                <div class="contact-info">
                    <i class="fas fa-envelope contact-icon"></i>
                    <p>info@xyshop.com</p>
                </div>
                <div class="contact-info">
                    <i class="fas fa-clock contact-icon"></i>
                    <p>Mon-Sat: 8:00 AM - 7:00 PM</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 XY_SHOP. All Rights Reserved. Designed with <i class="fas fa-heart footer-heart"></i> in Rwanda</p>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Admin Dashboard (Hidden by default, shown when logged in as admin) -->
    <div class="admin-container" id="adminDashboard" style="display: none;">
        <!-- Sidebar -->
        <div class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-header">
                <i class="fas fa-store-alt"></i>
                <h3>XY_SHOP Admin</h3>
            </div>
            <div class="admin-sidebar-menu">
                <div class="admin-menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </div>
                <div class="admin-menu-item">
                    <i class="fas fa-box-open"></i>
                    <span>Products</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="admin-submenu">
                    <a href="#" class="admin-submenu-item">All Products</a>
                    <a href="#" class="admin-submenu-item">Add New</a>
                    <a href="#" class="admin-submenu-item">Categories</a>
                    <a href="#" class="admin-submenu-item">Inventory</a>
                </div>
                <div class="admin-menu-item">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="admin-submenu">
                    <a href="#" class="admin-submenu-item">All Orders</a>
                    <a href="#" class="admin-submenu-item">Processing</a>
                    <a href="#" class="admin-submenu-item">Completed</a>
                    <a href="#" class="admin-submenu-item">Cancelled</a>
                </div>
                <div class="admin-menu-item">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </div>
                <div class="admin-menu-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </div>
                <div class="admin-menu-item">
                    <i class="fas fa-tags"></i>
                    <span>Discounts</span>
                </div>
                <div class="admin-menu-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            <div class="admin-header">
                <button class="admin-toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="admin-title">Dashboard</h1>
                <div class="admin-user">
                    <div class="admin-user-avatar">SK</div>
                    <span>Shop Keeper</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

            <!-- Content -->
            <div class="admin-content">
                <!-- Stats Cards -->
                <div class="admin-stats-grid">
                    <div class="admin-stat-card">
                        <div class="admin-stat-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="admin-stat-value">1,248</div>
                        <div class="admin-stat-label">Total Products</div>
                    </div>
                    <div class="admin-stat-card">
                        <div class="admin-stat-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="admin-stat-value">356</div>
                        <div class="admin-stat-label">Today's Orders</div>
                    </div>
                    <div class="admin-stat-card">
                        <div class="admin-stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="admin-stat-value">5,421</div>
                        <div class="admin-stat-label">Total Customers</div>
                    </div>
                    <div class="admin-stat-card">
                        <div class="admin-stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="admin-stat-value">RWF 12.8M</div>
                        <div class="admin-stat-label">Monthly Revenue</div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title">Recent Orders</h3>
                        <div class="admin-card-actions">
                            <button class="admin-btn admin-btn-secondary">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#XY-1001</td>
                                    <td>Jean D'amour</td>
                                    <td>Dec 2, 2024</td>
                                    <td>RWF 75,000</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#XY-1002</td>
                                    <td>Alice Mukamana</td>
                                    <td>Dec 2, 2024</td>
                                    <td>RWF 35,000</td>
                                    <td><span class="badge bg-warning text-dark">Processing</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#XY-1003</td>
                                    <td>Paul Kagabo</td>
                                    <td>Dec 1, 2024</td>
                                    <td>RWF 120,000</td>
                                    <td><span class="badge bg-primary">Shipped</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#XY-1004</td>
                                    <td>Marie Uwase</td>
                                    <td>Dec 1, 2024</td>
                                    <td>RWF 45,000</td>
                                    <td><span class="badge bg-danger">Cancelled</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#XY-1005</td>
                                    <td>Peter Niyonsaba</td>
                                    <td>Nov 30, 2024</td>
                                    <td>RWF 85,000</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Product Management -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title">Product Management</h3>
                        <div class="admin-card-actions">
                            <button class="admin-btn admin-btn-primary" id="addProductBtn">
                                <i class="fas fa-plus"></i> Add Product
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" width="40" height="40" style="object-fit: cover; border-radius: 4px;">
                                            Men's Casual Shirt
                                        </div>
                                    </td>
                                    <td>Men's Clothing</td>
                                    <td>RWF 25,000</td>
                                    <td>42</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="admin-btn admin-btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" width="40" height="40" style="object-fit: cover; border-radius: 4px;">
                                            Women's Summer Dress
                                        </div>
                                    </td>
                                    <td>Women's Clothing</td>
                                    <td>RWF 35,000</td>
                                    <td>28</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="admin-btn admin-btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://images.unsplash.com/photo-1523170335258-f5ed11844a49?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" width="40" height="40" style="object-fit: cover; border-radius: 4px;">
                                            Unisex Sneakers
                                        </div>
                                    </td>
                                    <td>Footwear</td>
                                    <td>RWF 45,000</td>
                                    <td>56</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="admin-btn admin-btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" width="40" height="40" style="object-fit: cover; border-radius: 4px;">
                                            Leather Handbag
                                        </div>
                                    </td>
                                    <td>Accessories</td>
                                    <td>RWF 55,000</td>
                                    <td>37</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="admin-btn admin-btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://images.unsplash.com/photo-1551232864-3f0890e580d9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" width="40" height="40" style="object-fit: cover; border-radius: 4px;">
                                            Denim Jacket
                                        </div>
                                    </td>
                                    <td>Men's Clothing</td>
                                    <td>RWF 40,000</td>
                                    <td>0</td>
                                    <td><span class="badge bg-danger">Out of Stock</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-btn admin-btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="admin-btn admin-btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="admin-modal" id="addProductModal">
        <div class="admin-modal-content">
            <div class="admin-modal-header">
                <h3 class="admin-modal-title">Add New Product</h3>
                <button class="admin-modal-close" id="closeModal">&times;</button>
            </div>
            <div class="admin-modal-body">
                <form id="productForm">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Product Name</label>
                        <input type="text" class="admin-form-control" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Description</label>
                        <textarea class="admin-form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Price</label>
                                <input type="number" class="admin-form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Stock Quantity</label>
                                <input type="number" class="admin-form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Category</label>
                        <select class="admin-form-control" required>
                            <option value="">Select Category</option>
                            <option value="men">Men's Clothing</option>
                            <option value="women">Women's Clothing</option>
                            <option value="footwear">Footwear</option>
                            <option value="accessories">Accessories</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Product Images</label>
                        <input type="file" class="admin-form-control" multiple>
                    </div>
                </form>
            </div>
            <div class="admin-modal-footer">
                <button class="admin-btn admin-btn-secondary" id="cancelModal">Cancel</button>
                <button class="admin-btn admin-btn-primary">Save Product</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Main Website Scripts
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Back to top button
            const backToTop = document.querySelector('.back-to-top');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTop.classList.add('active');
                } else {
                    backToTop.classList.remove('active');
                }
            });

            backToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Newsletter form
            document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const email = this.querySelector('input').value;
                alert(`Thank you for subscribing with ${email}! You'll hear from us soon.`);
                this.querySelector('input').value = '';
            });

            // Product search functionality
            const searchInput = document.querySelector('.products-search input');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const productCards = document.querySelectorAll('.product-card');
                
                productCards.forEach(card => {
                    const productName = card.querySelector('h3').textContent.toLowerCase();
                    if (productName.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Add to cart buttons
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productName = this.closest('.product-info').querySelector('h3').textContent;
                    alert(`${productName} has been added to your cart!`);
                });
            });

            // Admin Dashboard Toggle (for demo purposes)
            const adminPanelBtn = document.querySelector('.cta-button');
            const adminDashboard = document.getElementById('adminDashboard');
            
            adminPanelBtn.addEventListener('click', function(e) {
                e.preventDefault();
                adminDashboard.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        // Admin Dashboard Scripts
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar on mobile
            const toggleSidebar = document.getElementById('toggleSidebar');
            const adminSidebar = document.getElementById('adminSidebar');
            
            toggleSidebar.addEventListener('click', function() {
                adminSidebar.classList.toggle('show');
            });

            // Submenu toggle
            const menuItems = document.querySelectorAll('.admin-menu-item');
            menuItems.forEach(item => {
                if (item.querySelector('.fa-chevron-down')) {
                    item.addEventListener('click', function() {
                        const submenu = this.nextElementSibling;
                        submenu.classList.toggle('show');
                        const icon = this.querySelector('.fa-chevron-down');
                        icon.classList.toggle('fa-rotate-180');
                    });
                }
            });

            // Product modal
            const addProductBtn = document.getElementById('addProductBtn');
            const addProductModal = document.getElementById('addProductModal');
            const closeModal = document.getElementById('closeModal');
            const cancelModal = document.getElementById('cancelModal');
            
            addProductBtn.addEventListener('click', function() {
                addProductModal.classList.add('show');
            });
            
            closeModal.addEventListener('click', function() {
                addProductModal.classList.remove('show');
            });
            
            cancelModal.addEventListener('click', function() {
                addProductModal.classList.remove('show');
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === addProductModal) {
                    addProductModal.classList.remove('show');
                }
            });

            // Demo functionality for admin panel
            const adminPanelBtn = document.querySelector('.cta-button');
            const adminDashboard = document.getElementById('adminDashboard');
            
            adminPanelBtn.addEventListener('click', function(e) {
                e.preventDefault();
                adminDashboard.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            // Close admin panel (demo)
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && adminDashboard.style.display === 'flex') {
                    adminDashboard.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
</body>
</html>