<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - XY_SHOP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <style>
        :root {
            --primary-color: #004b63;
            --primary-light: #006b8f;
            --secondary-color: darkcyan;
            --secondary-light: #00b3b3;
            --accent-color: #009688; /* Changed from red to teal */
            --accent-light: #00bcd4;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #495057;
            --darker-gray: #343a40;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --error-color: #dc3545;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --box-shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
            --border-radius: 8px;
            --nav-height: 80px;
            --nav-height-scrolled: 70px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            color: var(--darker-gray);
            line-height: 1.6;
            overflow-x: hidden;
            padding-top: var(--nav-height);
        }
        
        /* Navigation Bar */
        .navbar {
            height: var(--nav-height);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--primary-color);
            color: white;
            padding: 0 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar.scrolled {
            height: var(--nav-height-scrolled);
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
            color: white;
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
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .navbar nav ul li {
            position: relative;
        }

        .navbar nav ul li a {
            color: white;
            font-size: 16px;
            font-weight: 600;
            transition: var(--transition);
            padding: 8px 12px;
            border-radius: var(--border-radius);
            position: relative;
            text-decoration: none;
        }

        .navbar nav ul li a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: white;
            bottom: 0;
            left: 0;
            transition: var(--transition);
        }

        .navbar nav ul li a:hover:after {
            width: 100%;
        }

        .navbar nav ul li a:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .cta-button {
            background-color: var(--secondary-color);
            color: white;
            font-size: 16px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            border: 2px solid var(--secondary-color);
            text-decoration: none;
            display: inline-block;
        }

        .cta-button:hover {
            background-color: var(--secondary-light);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--box-shadow-hover);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            position: relative;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: var(--transition);
        }

        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 200px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 100;
        }

        .user-profile:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(10px);
        }

        .dropdown-menu a {
            display: block;
            padding: 10px 20px;
            color: var(--darker-gray);
            text-decoration: none;
            transition: var(--transition);
        }

        .dropdown-menu a:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
            padding-left: 25px;
        }

        .dropdown-menu a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Hero Section */
        .checkout-hero {
            background-image: linear-gradient(rgba(0, 75, 99, 0.8), rgba(0, 75, 99, 0.8)), url('https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');
            height: 40vh;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 0 20px;
        }
        
        .checkout-hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.8s ease;
        }
        
        .checkout-hero p {
            font-size: 1.2rem;
            max-width: 700px;
            animation: fadeInUp 0.8s ease 0.2s both;
        }
        
        /* Main Checkout Container */
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }
        
        .checkout-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .checkout-title {
            font-size: 2rem;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 10px;
        }
        
        .checkout-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--secondary-color);
        }
        
        .continue-shopping {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: var(--transition);
            padding: 8px 15px;
            border-radius: var(--border-radius);
        }
        
        .continue-shopping:hover {
            background-color: rgba(0, 75, 99, 0.1);
            transform: translateX(-5px);
        }
        
        .continue-shopping i {
            margin-right: 8px;
            transition: var(--transition);
        }
        
        .continue-shopping:hover i {
            transform: translateX(-3px);
        }
        
        /* Checkout Steps */
        .checkout-steps {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
            position: relative;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            padding: 0 30px;
            flex: 1;
            max-width: 250px;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--medium-gray);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 10px;
            z-index: 1;
            transition: var(--transition);
        }
        
        .step.active .step-number {
            background-color: var(--primary-color);
            box-shadow: 0 0 0 5px rgba(0, 75, 99, 0.2);
        }
        
        .step.completed .step-number {
            background-color: var(--secondary-color);
        }
        
        .step.completed .step-number::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }
        
        .step-title {
            color: var(--dark-gray);
            font-size: 0.9rem;
            text-align: center;
            transition: var(--transition);
            font-weight: 500;
        }
        
        .step.active .step-title {
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .step.completed .step-title {
            color: var(--secondary-color);
        }
        
        .step::before, .step::after {
            content: '';
            position: absolute;
            top: 20px;
            width: 50%;
            height: 2px;
            background-color: var(--medium-gray);
            transition: var(--transition);
        }
        
        .step::before {
            left: 0;
        }
        
        .step::after {
            right: 0;
        }
        
        .step:first-child::before, .step:last-child::after {
            display: none;
        }
        
        .step.completed::before, .step.completed::after {
            background-color: var(--secondary-color);
        }
        
        /* Checkout Layout */
        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }
        
        /* Checkout Form */
        .checkout-form {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .checkout-form:hover {
            box-shadow: var(--box-shadow-hover);
        }
        
        .form-section {
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .section-title {
            font-size: 1.3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .form-group input, 
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .form-group input:focus, 
        .form-group select:focus, 
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 75, 99, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        /* Saved Addresses */
        .saved-addresses {
            margin-bottom: 20px;
        }
        
        .saved-addresses h4 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }

        .saved-addresses h4 i {
            margin-right: 10px;
        }
        
        .address-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .address-option {
            display: flex;
            align-items: flex-start;
            padding: 15px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .address-option:hover {
            border-color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .address-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(0, 75, 99, 0.05);
            box-shadow: 0 0 0 1px var(--primary-color);
        }
        
        .address-option input {
            margin-right: 10px;
            margin-top: 3px;
        }
        
        .address-details h4 {
            margin-bottom: 5px;
            color: var(--primary-color);
            font-size: 1rem;
        }
        
        .address-details p {
            color: var(--dark-gray);
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .add-new-address {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            font-weight: 600;
            margin-top: 15px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            background-color: rgba(0, 75, 99, 0.1);
        }
        
        .add-new-address:hover {
            background-color: rgba(0, 75, 99, 0.2);
            transform: translateX(5px);
        }
        
        .add-new-address i {
            margin-right: 8px;
        }
        
        /* Checkout Summary */
        .checkout-summary {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            height: fit-content;
            position: sticky;
            top: calc(var(--nav-height) + 20px);
            transition: var(--transition);
        }

        .checkout-summary:hover {
            box-shadow: var(--box-shadow-hover);
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--medium-gray);
            transition: var(--transition);
        }

        .summary-item:hover {
            transform: translateX(3px);
        }
        
        .item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .item-image:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .item-info {
            flex: 1;
            padding: 0 15px;
        }
        
        .item-info h4 {
            margin: 0 0 5px;
            font-size: 0.9rem;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .item-info h4:hover {
            color: var(--primary-light);
        }
        
        .item-info p {
            margin: 0;
            color: var(--dark-gray);
            font-size: 0.8rem;
        }
        
        .item-price {
            font-weight: bold;
            color: var(--primary-color);
            min-width: 80px;
            text-align: right;
        }
        
        .item-quantity {
            display: inline-block;
            background-color: var(--medium-gray);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            margin-top: 5px;
            color: var(--darker-gray);
        }
        
        .summary-total {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid var(--primary-color);
        }
        
        .summary-total .item-price {
            font-size: 1.2rem;
            color: var(--primary-color);
        }
        
        .coupon-form {
            display: flex;
            margin-top: 20px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .coupon-input {
            flex: 1;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-right: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .coupon-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        
        .coupon-button {
            padding: 0 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
        }
        
        .coupon-button:hover {
            background-color: var(--primary-light);
        }
        
        .coupon-success {
            color: var(--success-color);
            font-size: 0.9rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }
        
        .coupon-success i {
            margin-right: 5px;
        }
        
        /* Payment Methods */
        .payment-methods {
            margin-top: 30px;
        }
        
        .payment-method {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .payment-method:hover {
            border-color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .payment-method.selected {
            border-color: var(--primary-color);
            background-color: rgba(0, 75, 99, 0.05);
            box-shadow: 0 0 0 1px var(--primary-color);
        }
        
        .payment-icon {
            font-size: 1.5rem;
            margin-right: 15px;
            color: var(--primary-color);
            width: 30px;
            text-align: center;
        }
        
        .payment-info h4 {
            margin: 0 0 5px;
            color: var(--primary-color);
        }
        
        .payment-info p {
            margin: 0;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        /* Card Payment Form */
        .card-form {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            background-color: var(--light-gray);
            display: none;
            animation: fadeIn 0.5s ease;
        }
        
        .card-form.active {
            display: block;
        }
        
        .card-element {
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            background-color: white;
            margin-bottom: 15px;
        }
        
        /* Mobile Money Form */
        .mobile-money-form {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            background-color: var(--light-gray);
            display: none;
            animation: fadeIn 0.5s ease;
        }
        
        .mobile-money-form.active {
            display: block;
        }
        
        /* Place Order Button */
        .place-order-btn {
            width: 100%;
            padding: 15px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .place-order-btn:hover {
            background-color: var(--secondary-light);
            transform: translateY(-2px);
            box-shadow: 0 7px 15px rgba(0, 139, 139, 0.3);
        }
        
        .place-order-btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .place-order-btn i {
            margin-right: 10px;
        }
        
        /* Secure Checkout */
        .secure-checkout {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            color: var(--dark-gray);
            font-size: 0.9rem;
            padding: 10px;
            background-color: rgba(0, 75, 99, 0.05);
            border-radius: var(--border-radius);
        }
        
        .secure-checkout i {
            color: var(--success-color);
            margin-right: 8px;
            font-size: 1.2rem;
        }
        
        .payment-icons {
            margin-top: 20px;
            text-align: center;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .payment-icons img {
            height: 25px;
            filter: grayscale(30%);
            transition: var(--transition);
        }

        .payment-icons img:hover {
            filter: grayscale(0%);
            transform: translateY(-2px);
        }
        
        /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 60px 0 20px;
            position: relative;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }
        
        .footer-section {
            margin-bottom: 30px;
        }
        
        .footer-section h4 {
            font-size: 1.2rem;
            margin-bottom: 20px;
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
            background-color: var(--accent-color);
        }
        
        .footer-section p {
            margin-bottom: 15px;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            color: white;
            font-size: 1.2rem;
            transition: var(--transition);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .social-links a:hover {
            color: var(--accent-color);
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li {
            margin-bottom: 10px;
        }
        
        .footer-section ul li a {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
            display: inline-block;
        }
        
        .footer-section ul li a:hover {
            color: var(--accent-color);
            padding-left: 5px;
        }
        
        .footer-section i {
            margin-right: 10px;
            color: var(--accent-color);
            width: 20px;
            text-align: center;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
        }

        .footer-bottom p {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background-color: var(--accent-light);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }
            
            .checkout-summary {
                position: static;
                margin-top: 40px;
            }

            .navbar nav ul {
                gap: 15px;
            }

            .cta-button {
                padding: 8px 15px;
                font-size: 14px;
            }
        }
        
        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
            }
            
            .checkout-hero h1 {
                font-size: 2rem;
            }
            
            .checkout-hero p {
                font-size: 1rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .checkout-steps {
                flex-wrap: wrap;
            }
            
            .step {
                padding: 10px;
                margin-bottom: 20px;
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .step::before, .step::after {
                display: none;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                height: 70px;
            }

            .logo-text {
                font-size: 20px;
            }

            .logo {
                height: 40px;
            }

            .navbar nav ul {
                gap: 10px;
            }

            .checkout-hero h1 {
                font-size: 1.8rem;
            }

            .checkout-title {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.1rem;
            }
        }
        
        /* Form Validation Styles */
        .form-group.error input,
        .form-group.error select,
        .form-group.error textarea {
            border-color: var(--error-color);
            background-color: rgba(220, 53, 69, 0.05);
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }
        
        .form-group.error .error-message {
            display: block;
        }
        
        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Order Summary Toggle */
        .summary-toggle {
            display: none;
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            border-radius: var(--border-radius);
            margin-bottom: 15px;
            cursor: pointer;
            text-align: center;
            justify-content: center;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            transition: var(--transition);
        }

        .summary-toggle:hover {
            background-color: var(--primary-light);
        }
        
        .summary-toggle i {
            transition: var(--transition);
        }
        
        .summary-toggle.active i {
            transform: rotate(180deg);
        }

        .summary-content {
            transition: var(--transition);
            overflow: hidden;
        }
        
        @media (max-width: 992px) {
            .summary-toggle {
                display: flex;
            }

            .summary-content {
                max-height: 0;
                opacity: 0;
                visibility: hidden;
            }

            .summary-content.active {
                max-height: 2000px;
                opacity: 1;
                visibility: visible;
            }
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--primary-color);
            color: white;
            padding: 15px 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .toast.visible {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-10px);
        }

        .toast i {
            font-size: 1.2rem;
        }

        /* Tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: var(--darker-gray);
            color: white;
            text-align: center;
            border-radius: var(--border-radius);
            padding: 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: var(--transition);
            font-size: 0.8rem;
            font-weight: normal;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: var(--darker-gray) transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <a href="index.html" class="logo-link">
                <img src="xy/logo.png" alt="XY_SHOP Logo" class="logo">
                <span class="logo-text">XY_SHOP</span>
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li class="user-profile">
                    <div class="user-avatar">JS</div>
                    <div class="dropdown-menu">
                        <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                        <a href="orders.php"><i class="fas fa-shopping-bag"></i> My Orders</a>
                        <a href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a>
                        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </li>
                <li><a href="login.php" class="cta-button">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero-section checkout-hero">
        <h1>Secure Checkout</h1>
        <p>Complete your purchase with confidence - your information is always protected</p>
    </section>

    <div class="checkout-container">
        <div class="checkout-header">
            <h2 class="checkout-title">Complete Your Purchase</h2>
            <a href="cart.html" class="continue-shopping">
                <i class="fas fa-arrow-left"></i> Back to Cart
            </a>
        </div>
        
        <div class="checkout-steps">
            <div class="step completed">
                <div class="step-number">1</div>
                <div class="step-title">Shopping Cart</div>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-title">Checkout Details</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-title">Order Confirmation</div>
            </div>
        </div>
        
        <div class="checkout-layout">
            <div class="checkout-form">
                <form id="checkoutForm">
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-user"></i> Customer Information</h3>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required placeholder="your@email.com">
                            <div class="error-message">Please enter a valid email address</div>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" id="createAccount" name="createAccount">
                                <label for="createAccount">Create an account for faster checkout next time</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-truck"></i> Delivery Information</h3>
                        
                        <div class="saved-addresses">
                            <h4><i class="fas fa-map-marker-alt"></i> Saved Addresses</h4>
                            <div class="address-options">
                                <label class="address-option selected">
                                    <input type="radio" name="address" checked>
                                    <div class="address-details">
                                        <h4>Home Address</h4>
                                        <p>betty, KN 123 St, Kicukiro, Kigali, Rwanda</p>
                                        <p>+250 788 123 456</p>
                                    </div>
                                </label>
                                <label class="address-option">
                                    <input type="radio" name="address">
                                    <div class="address-details">
                                        <h4>Work Address</h4>
                                        <p>sonia, KG 456 Ave, Nyarugenge, Kigali, Rwanda</p>
                                        <p>+250 788 789 012</p>
                                    </div>
                                </label>
                            </div>
                            <div class="add-new-address">
                                <i class="fas fa-plus"></i> Add New Address
                            </div>
                        </div>
                        
                        <div class="new-address-form" style="display: none;">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" id="firstName" name="firstName" required placeholder="John">
                                    <div class="error-message">Please enter your first name</div>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" id="lastName" name="lastName" required placeholder="Doe">
                                    <div class="error-message">Please enter your last name</div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" required placeholder="+250 788 123 456">
                                <div class="error-message">Please enter a valid phone number</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="address">Street Address</label>
                                <input type="text" id="address" name="address" required placeholder="KN 123 St">
                                <div class="error-message">Please enter your street address</div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" required placeholder="Kigali">
                                    <div class="error-message">Please enter your city</div>
                                </div>
                                <div class="form-group">
                                    <label for="district">District</label>
                                    <select id="district" name="district" required>
                                        <option value="">Select District</option>
                                        <option value="kigali">Kigali</option>
                                        <option value="northern">Northern Province</option>
                                        <option value="southern">Southern Province</option>
                                        <option value="eastern">Eastern Province</option>
                                        <option value="western">Western Province</option>
                                    </select>
                                    <div class="error-message">Please select your district</div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="notes">Delivery Instructions (Optional)</label>
                                <textarea id="notes" name="notes" rows="3" placeholder="e.g. Gate code, building description, etc."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" id="saveAddress" name="saveAddress" checked>
                                    <label for="saveAddress">Save this address to my account</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-shipping-fast"></i> Shipping Method</h3>
                        
                        <div class="form-group">
                            <label class="payment-method selected">
                                <input type="radio" name="shippingMethod" value="standard" checked>
                                <div class="payment-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>Standard Shipping</h4>
                                    <p>Delivery in 3-5 business days - RWF 2,500</p>
                                </div>
                            </label>
                            
                            <label class="payment-method">
                                <input type="radio" name="shippingMethod" value="express">
                                <div class="payment-icon">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>Express Shipping</h4>
                                    <p>Delivery in 1-2 business days - RWF 5,000</p>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-credit-card"></i> Payment Method</h3>
                        
                        <div class="form-group">
                            <label class="payment-method selected" data-payment="mobile">
                                <input type="radio" name="paymentMethod" value="mobile" checked>
                                <div class="payment-icon">
                                    <i class="fab fa-cc-m-pesa"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>Mobile Money (M-Pesa, Airtel Money)</h4>
                                    <p>Pay securely with your mobile money account</p>
                                </div>
                            </label>
                            
                            <label class="payment-method" data-payment="card">
                                <input type="radio" name="paymentMethod" value="card">
                                <div class="payment-icon">
                                    <i class="far fa-credit-card"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>Credit/Debit Card</h4>
                                    <p>Pay with Visa, Mastercard, or other cards</p>
                                </div>
                            </label>
                            
                            <label class="payment-method" data-payment="cod">
                                <input type="radio" name="paymentMethod" value="cod">
                                <div class="payment-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>Cash on Delivery</h4>
                                    <p>Pay when you receive your order</p>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Mobile Money Payment Form -->
                        <div class="mobile-money-form active">
                            <div class="form-group">
                                <label for="mobileProvider">Mobile Provider</label>
                                <select id="mobileProvider" name="mobileProvider" required>
                                    <option value="">Select Provider</option>
                                    <option value="mtn">MTN Mobile Money</option>
                                    <option value="airtel">Airtel Money</option>
                                    <option value="tigo">Tigo Cash</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobileNumber">Mobile Number</label>
                                <input type="tel" id="mobileNumber" name="mobileNumber" placeholder="07XX XXX XXX" required>
                            </div>
                            
                            <div class="form-group">
                                <p>You will receive a payment request on your mobile phone to complete the transaction.</p>
                            </div>
                        </div>
                        
                        <!-- Card Payment Form -->
                        <div class="card-form">
                            <div class="form-group">
                                <label for="cardNumber">Card Number</label>
                                <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="cardExpiry">Expiry Date</label>
                                    <input type="text" id="cardExpiry" name="cardExpiry" placeholder="MM/YY">
                                </div>
                                <div class="form-group">
                                    <label for="cardCvc">CVC</label>
                                    <input type="text" id="cardCvc" name="cardCvc" placeholder="123">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="cardName">Name on Card</label>
                                <input type="text" id="cardName" name="cardName" placeholder="John Doe">
                            </div>
                            
                            <div class="form-group">
                                <p>Your payment will be processed securely. We do not store your card details.</p>
                            </div>
                        </div>
                        
                        <!-- Cash on Delivery Notice -->
                        <div class="cod-notice" style="display: none;">
                            <div class="form-group">
                                <p>Please have the exact amount ready when your delivery arrives. Our delivery agent will not carry change.</p>
                                <p>A 2% service charge will be added for cash on delivery orders.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-sticky-note"></i> Additional Information</h3>
                        
                        <div class="form-group">
                            <label for="orderNotes">Order Notes (Optional)</label>
                            <textarea id="orderNotes" name="orderNotes" rows="4" placeholder="Special instructions, gift message, etc."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="checkout-summary">
                <div class="summary-toggle">
                    <span>Order Summary</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                
                <div class="summary-content">
                    <h3 class="section-title">Your Order</h3>
                    
                    <div class="summary-item">
                        <img src="https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Men's Casual Shirt" class="item-image">
                        <div class="item-info">
                            <h4>Men's Casual Shirt</h4>
                            <p>Blue, Size M</p>
                            <span class="item-quantity">Qty: 1</span>
                        </div>
                        <div class="item-price">RWF 25,000</div>
                    </div>
                    
                    <div class="summary-item">
                        <img src="https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Women's Summer Dress" class="item-image">
                        <div class="item-info">
                            <h4>Women's Summer Dress</h4>
                            <p>Red, Size S</p>
                            <span class="item-quantity">Qty: 1</span>
                        </div>
                        <div class="item-price">RWF 35,000</div>
                    </div>
                    
                    <div class="summary-item">
                        <img src="https://images.unsplash.com/photo-1523170335258-f5ed11844a49?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Unisex Sneakers" class="item-image">
                        <div class="item-info">
                            <h4>Unisex Sneakers</h4>
                            <p>White, Size 42</p>
                            <span class="item-quantity">Qty: 1</span>
                        </div>
                        <div class="item-price">RWF 45,000</div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="item-info">
                            <h4>Subtotal</h4>
                        </div>
                        <div class="item-price">RWF 105,000</div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="item-info">
                            <h4>Shipping</h4>
                        </div>
                        <div class="item-price">RWF 2,500</div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="item-info">
                            <h4>Tax (10%)</h4>
                        </div>
                        <div class="item-price">RWF 10,500</div>
                    </div>
                    
                    <div class="coupon-form">
                        <input type="text" class="coupon-input" placeholder="Coupon Code">
                        <button type="button" class="coupon-button">Apply</button>
                    </div>
                    <div class="coupon-success" style="display: none;">
                        <i class="fas fa-check-circle"></i>
                        <span>Coupon applied successfully!</span>
                    </div>
                    
                    <div class="summary-item summary-total">
                        <div class="item-info">
                            <h4>Total</h4>
                        </div>
                        <div class="item-price">RWF 118,000</div>
                    </div>
                    
                    <button class="place-order-btn" id="placeOrderBtn">
                        <i class="fas fa-lock"></i> Place Order Securely
                    </button>
                    
                    <div class="secure-checkout">
                        <i class="fas fa-lock"></i>
                        <span>256-bit SSL Secure Checkout</span>
                    </div>
                    
                    <div class="payment-icons">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/visa/visa-original.svg" alt="Visa">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mastercard/mastercard-original.svg" alt="Mastercard">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/paypal/paypal-original.svg" alt="PayPal">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/M-PESA_LOGO-01.svg/1200px-M-PESA_LOGO-01.svg.png" alt="M-Pesa">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Airtel_Money_Logo.svg/1200px-Airtel_Money_Logo.svg.png" alt="Airtel Money">
                    </div>
                </div>
            </div>
        </div>
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
                    <li><a href="dashboard.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="products.php"><i class="fas fa-chevron-right"></i> Products</a></li>
                    <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="contact.php"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                    <li><a href="blog.html"><i class="fas fa-chevron-right"></i> Blog</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Customer Service</h4>
                <ul>
                    <li><a href="faq.html"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                    <li><a href="shipping.html"><i class="fas fa-chevron-right"></i> Shipping Policy</a></li>
                    <li><a href="returns.html"><i class="fas fa-chevron-right"></i> Return Policy</a></li>
                    <li><a href="privacy.html"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                    <li><a href="terms.html"><i class="fas fa-chevron-right"></i> Terms & Conditions</a></li>
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
            <p><i class="far fa-copyright"></i> 2024 XY_SHOP. All Rights Reserved. Designed with <i class="fas fa-heart" style="color: var(--accent-color);"></i> in Rwanda</p>
        </div>
    </footer>

    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toast-message">Order placed successfully!</span>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Scroll event for navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Back to top button
            const backToTop = document.querySelector('.back-to-top');
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        // Back to top functionality
        document.querySelector('.back-to-top').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Initialize phone number input
        const phoneInput = document.querySelector("#phone");
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "rw",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Mobile number input for mobile money
        const mobileInput = document.querySelector("#mobileNumber");
        const mobileIti = window.intlTelInput(mobileInput, {
            initialCountry: "rw",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Payment method toggle
        document.querySelectorAll('[name="paymentMethod"]').forEach(method => {
            method.addEventListener('change', function() {
                // Hide all payment forms
                document.querySelectorAll('.mobile-money-form, .card-form, .cod-notice').forEach(form => {
                    form.style.display = 'none';
                });
                
                // Show selected payment form
                const paymentType = this.closest('.payment-method').dataset.payment;
                if (paymentType === 'mobile') {
                    document.querySelector('.mobile-money-form').style.display = 'block';
                } else if (paymentType === 'card') {
                    document.querySelector('.card-form').style.display = 'block';
                } else if (paymentType === 'cod') {
                    document.querySelector('.cod-notice').style.display = 'block';
                }
            });
        });

        // Shipping method toggle
        document.querySelectorAll('[name="shippingMethod"]').forEach(method => {
            method.addEventListener('change', function() {
                document.querySelectorAll('.payment-method').forEach(el => {
                    el.classList.remove('selected');
                });
                this.closest('.payment-method').classList.add('selected');
                
                // Update shipping cost in summary (would be dynamic in real app)
                const shippingCost = this.value === 'express' ? 5000 : 2500;
                document.querySelector('.summary-item:nth-last-child(3) .item-price').textContent = `RWF ${shippingCost.toLocaleString()}`;
                
                // Recalculate total (would be dynamic in real app)
                const subtotal = 105000;
                const tax = subtotal * 0.1;
                const total = subtotal + shippingCost + tax;
                document.querySelector('.summary-total .item-price').textContent = `RWF ${total.toLocaleString()}`;
            });
        });

        // Address toggle
        document.querySelector('.add-new-address').addEventListener('click', function() {
            const newAddressForm = document.querySelector('.new-address-form');
            const addressOptions = document.querySelector('.saved-addresses .address-options');
            
            if (newAddressForm.style.display === 'none') {
                newAddressForm.style.display = 'block';
                addressOptions.style.display = 'none';
                this.innerHTML = '<i class="fas fa-times"></i> Cancel';
            } else {
                newAddressForm.style.display = 'none';
                addressOptions.style.display = 'flex';
                this.innerHTML = '<i class="fas fa-plus"></i> Add New Address';
            }
        });

        // Coupon code application
        document.querySelector('.coupon-button').addEventListener('click', function() {
            const couponInput = document.querySelector('.coupon-input');
            if (couponInput.value.trim() !== '') {
                const couponSuccess = document.querySelector('.coupon-success');
                couponSuccess.style.display = 'flex';
                couponInput.value = '';
                
                // Apply discount (would be dynamic in real app)
                setTimeout(() => {
                    const discount = 10000;
                    const subtotal = 105000;
                    const shipping = 2500;
                    const tax = subtotal * 0.1;
                    const total = subtotal + shipping + tax - discount;
                    
                    // Check if discount is already applied
                    if (!document.querySelector('.discount-item')) {
                        // Add discount line
                        const discountItem = document.createElement('div');
                        discountItem.className = 'summary-item discount-item';
                        discountItem.innerHTML = `
                            <div class="item-info">
                                <h4 style="color: var(--success-color);">Discount</h4>
                            </div>
                            <div class="item-price" style="color: var(--success-color);">-RWF ${discount.toLocaleString()}</div>
                        `;
                        
                        const summaryItems = document.querySelector('.summary-content');
                        const totalItem = document.querySelector('.summary-total');
                        summaryItems.insertBefore(discountItem, totalItem);
                        
                        // Update total
                        document.querySelector('.summary-total .item-price').textContent = `RWF ${total.toLocaleString()}`;
                    }

                    // Show toast notification
                    showToast('Coupon applied successfully! You saved RWF 10,000');
                }, 500);
            }
        });

        // Order summary toggle for mobile
        document.querySelector('.summary-toggle').addEventListener('click', function() {
            this.classList.toggle('active');
            document.querySelector('.summary-content').classList.toggle('active');
        });

        // Show toast notification
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            toastMessage.textContent = message;
            toast.classList.add('visible');
            
            setTimeout(() => {
                toast.classList.remove('visible');
            }, 3000);
        }

        // Form validation
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            
            // Validate required fields
            document.querySelectorAll('[required]').forEach(field => {
                const formGroup = field.closest('.form-group');
                if (!field.value.trim()) {
                    formGroup.classList.add('error');
                    isValid = false;
                } else {
                    formGroup.classList.remove('error');
                }
            });
            
            // Validate email format
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                email.closest('.form-group').classList.add('error');
                isValid = false;
            }
            
            // If form is valid, proceed with payment
            if (isValid) {
                const placeOrderBtn = document.getElementById('placeOrderBtn');
                placeOrderBtn.innerHTML = '<span class="spinner"></span> Processing Order...';
                placeOrderBtn.disabled = true;
                
                // Simulate payment processing
                setTimeout(() => {
                    // Show success toast
                    showToast('Order placed successfully! Redirecting...');
                    
                    // Redirect to confirmation page
                    setTimeout(() => {
                        window.location.href = 'order-confirmation.html';
                    }, 2000);
                }, 2000);
            } else {
                // Scroll to first error
                const firstError = document.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });

        // Initialize Stripe (would be properly configured in a real app)
        const stripe = Stripe('pk_test_your_stripe_key_here');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#cardElement');

        // Tooltip for payment methods
        document.querySelectorAll('.payment-method').forEach(method => {
            const type = method.dataset.payment;
            let tooltipText = '';
            
            if (type === 'mobile') {
                tooltipText = 'Instant payment via mobile money. You will receive a payment request.';
            } else if (type === 'card') {
                tooltipText = 'Secure card payment processed via Stripe. We do not store your card details.';
            } else if (type === 'cod') {
                tooltipText = 'Pay when you receive your order. A 2% service charge applies.';
            }
            
            const tooltip = document.createElement('span');
            tooltip.className = 'tooltiptext';
            tooltip.textContent = tooltipText;
            
            const icon = document.createElement('i');
            icon.className = 'fas fa-info-circle';
            icon.style.marginLeft = '5px';
            icon.style.color = 'var(--primary-color)';
            icon.style.fontSize = '0.8rem';
            
            const tooltipContainer = document.createElement('span');
            tooltipContainer.className = 'tooltip';
            tooltipContainer.appendChild(icon);
            tooltipContainer.appendChild(tooltip);
            
            method.querySelector('.payment-info h4').appendChild(tooltipContainer);
        });
    </script>
</body>
</html>