<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail - XY_SHOP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
     
        
        .product-detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }
        
        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }
        
        .product-gallery {
            display: grid;
            grid-template-columns: 100px 1fr;
            gap: 20px;
        }
        
        .thumbnail-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .thumbnail {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .thumbnail:hover, .thumbnail.active {
            border-color: #004b63;
        }
        
        .main-image {
            width: 100%;
            height: 500px;
            object-fit: contain;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        
        .product-info {
            padding: 20px;
        }
        
        .product-title {
            font-size: 2.2rem;
            color: #004b63;
            margin-bottom: 10px;
        }
        
        .product-brand {
            color: #666;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        
        .product-rating {
            color: #ffcc00;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        
        .review-count {
            color: #666;
            font-size: 0.9rem;
            margin-left: 10px;
        }
        
        .product-price {
            font-size: 2rem;
            color: darkcyan;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 1.5rem;
            margin-left: 15px;
        }
        
        .product-badge {
            background-color: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .product-description {
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .product-options {
            margin-bottom: 30px;
        }
        
        .option-group {
            margin-bottom: 20px;
        }
        
        .option-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #004b63;
        }
        
        .size-options, .color-options {
            display: flex;
            gap: 10px;
        }
        
        .size-option {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .size-option:hover, .size-option.selected {
            background-color: #004b63;
            color: white;
            border-color: #004b63;
        }
        
        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .color-option:hover, .color-option.selected {
            border-color: #004b63;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .quantity-btn {
            width: 40px;
            height: 40px;
            background-color: #f5f5f5;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 5px;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .add-to-cart, .buy-now {
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .add-to-cart {
            background-color: #004b63;
            color: white;
        }
        
        .add-to-cart:hover {
            background-color: #003b50;
        }
        
        .buy-now {
            background-color: darkcyan;
            color: white;
        }
        
        .buy-now:hover {
            background-color: #008b8b;
        }
        
        .wishlist-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .wishlist-btn:hover {
            color: #ff6b6b;
        }
        
        .product-meta {
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 30px;
        }
        
        .meta-item {
            margin-bottom: 10px;
        }
        
        .meta-label {
            font-weight: bold;
            color: #004b63;
            margin-right: 10px;
        }
        
        .product-tabs {
            margin-top: 60px;
        }
        
        .tab-header {
            display: flex;
            border-bottom: 1px solid #ddd;
        }
        
        .tab-btn {
            padding: 15px 25px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            font-size: 1rem;
            font-weight: bold;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .tab-btn.active {
            color: #004b63;
            border-bottom-color: #004b63;
        }
        
        .tab-content {
            padding: 30px 0;
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .specifications-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .specifications-table tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        
        .specifications-table td {
            padding: 15px;
            border: 1px solid #ddd;
        }
        
        .spec-label {
            font-weight: bold;
            color: #004b63;
            width: 30%;
        }
        
        .review-item {
            border-bottom: 1px solid #ddd;
            padding: 20px 0;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .review-author {
            font-weight: bold;
        }
        
        .review-date {
            color: #666;
            font-size: 0.9rem;
        }
        
        .review-rating {
            color: #ffcc00;
            margin-bottom: 10px;
        }
        
        .related-products {
            margin-top: 80px;
        }
        
        .related-title {
            font-size: 1.8rem;
            color: #004b63;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        @media (max-width: 768px) {
            .product-detail {
                grid-template-columns: 1fr;
            }
            
            .product-gallery {
                grid-template-columns: 1fr;
            }
            
            .thumbnail-list {
                flex-direction: row;
                order: 2;
            }
            
            .main-image {
                height: 300px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
        .footer {
            background-color: #002f3f;
            color: white;
            padding: 60px 20px 20px;
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
        }
        
        .footer h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: darkcyan;
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
            transition: color 0.3s ease;
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
            background-color: #004b63;
            border-radius: 50%;
            color: white;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: darkcyan;
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
        }

    </style>
</head>
<body>
    <!-- Navigation Bar (Same as index.html) -->
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
                <li><a href="productdetail.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li class="user-profile">
                    <div class="user-avatar"></div>
                </li>
                <li><a href="login.php" class="cta-button">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Product Detail Hero Section -->
    <section class="hero-section product-detail-hero">
        <h1>Product Details</h1>
    </section>

    <!-- Product Detail Content -->
    <div class="product-detail-container">
        <div class="product-detail">
            <div class="product-gallery">
                <div class="thumbnail-list">
                    <img src="https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Thumbnail 1" class="thumbnail active">
                    <img src="https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Thumbnail 2" class="thumbnail">
                    <img src="https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Thumbnail 3" class="thumbnail">
                    <img src="https://images.unsplash.com/photo-1527719327859-c6ce80353573?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Thumbnail 4" class="thumbnail">
                </div>
                <img src="https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Men's Casual Shirt" class="main-image">
            </div>
            
            <div class="product-info">
                <h1 class="product-title">Men's Casual Shirt</h1>
                <p class="product-brand">Brand: XY_Fashion</p>
                <div class="product-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span class="review-count">(24 reviews)</span>
                </div>
                
                <div class="product-price">
                    RWF 25,000 <span class="old-price">RWF 30,000</span>
                </div>
                
                <span class="product-badge">Sale - 17% OFF</span>
                
                <p class="product-description">
                    This stylish men's casual shirt is perfect for any occasion. Made from premium cotton fabric, it offers exceptional comfort and breathability. The slim fit design provides a modern look, while the classic button-down collar adds a touch of sophistication. Available in various colors to match your personal style.
                </p>
                
                <div class="product-options">
                    <div class="option-group">
                        <label>Size</label>
                        <div class="size-options">
                            <div class="size-option">S</div>
                            <div class="size-option selected">M</div>
                            <div class="size-option">L</div>
                            <div class="size-option">XL</div>
                            <div class="size-option">XXL</div>
                        </div>
                    </div>
                    
                    <div class="option-group">
                        <label>Color</label>
                        <div class="color-options">
                            <div class="color-option selected" style="background-color: #3498db;"></div>
                            <div class="color-option" style="background-color: #2c3e50;"></div>
                            <div class="color-option" style="background-color: #e74c3c;"></div>
                            <div class="color-option" style="background-color: #f1c40f;"></div>
                        </div>
                    </div>
                </div>
                
                <div class="quantity-selector">
                    <button class="quantity-btn">-</button>
                    <input type="number" value="1" min="1" class="quantity-input">
                    <button class="quantity-btn">+</button>
                </div>
                
                <div class="action-buttons">
                    <button class="add-to-cart">Add to Cart</button>
                    <button class="buy-now">Buy Now</button>
                </div>
                
                <button class="wishlist-btn">
                    <i class="far fa-heart"></i> Add to Wishlist
                </button>
                
                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">SKU:</span> XY-MS-001
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Category:</span> <a href="#">Men's Clothing</a>, <a href="#">Shirts</a>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tags:</span> <a href="#">Casual</a>, <a href="#">Cotton</a>, <a href="#">Summer</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="product-tabs">
            <div class="tab-header">
                <button class="tab-btn active" data-tab="description">Description</button>
                <button class="tab-btn" data-tab="specifications">Specifications</button>
                <button class="tab-btn" data-tab="reviews">Reviews (24)</button>
            </div>
            
            <div class="tab-content active" id="description">
                <h3>Product Description</h3>
                <p>This men's casual shirt is designed for comfort and style. The premium cotton fabric ensures breathability and softness against your skin, making it perfect for all-day wear. The shirt features a classic button-down collar, a button-up front, and a curved hem that stays tucked in or looks great untucked.</p>
                <p>The slim fit design provides a modern silhouette that flatters your shape without being too tight. The shirt is versatile enough to dress up with chinos for a business casual look or dress down with jeans for a relaxed weekend outfit.</p>
                <p><strong>Key Features:</strong></p>
                <ul>
                    <li>100% premium cotton fabric</li>
                    <li>Slim fit design</li>
                    <li>Button-down collar</li>
                    <li>Single chest pocket</li>
                    <li>Machine washable</li>
                    <li>Available in multiple colors</li>
                </ul>
            </div>
            
            <div class="tab-content" id="specifications">
                <h3>Product Specifications</h3>
                <table class="specifications-table">
                    <tr>
                        <td class="spec-label">Material</td>
                        <td>100% Cotton</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Fit</td>
                        <td>Slim Fit</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Collar</td>
                        <td>Button-Down Collar</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Sleeve Length</td>
                        <td>Long Sleeve</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Pattern</td>
                        <td>Solid</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Care Instructions</td>
                        <td>Machine Wash, Tumble Dry</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Origin</td>
                        <td>Made in Rwanda</td>
                    </tr>
                </table>
            </div>
            
            <div class="tab-content" id="reviews">
                <h3>Customer Reviews</h3>
                
                <div class="review-item">
                    <div class="review-header">
                        <span class="review-author">Jean Claude</span>
                        <span class="review-date">March 15, 2024</span>
                    </div>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>This shirt is incredibly comfortable and fits perfectly. The quality is excellent for the price. I've already ordered another one in a different color!</p>
                </div>
                
                <div class="review-item">
                    <div class="review-header">
                        <span class="review-author">Marie Aimee</span>
                        <span class="review-date">February 28, 2024</span>
                    </div>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <p>Great shirt overall. The fabric is soft and breathable. The only reason I'm giving 4 stars instead of 5 is that the sleeves were slightly longer than I expected.</p>
                </div>
                
                <div class="review-item">
                    <div class="review-header">
                        <span class="review-author">Paul Kagabo</span>
                        <span class="review-date">February 10, 2024</span>
                    </div>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p>Very satisfied with this purchase. The shirt looks exactly like in the pictures and arrived faster than expected. Will definitely buy from XY_SHOP again.</p>
                </div>
                
                <button class="view-more-btn">View All Reviews</button>
                <button class="view-more-btn" style="margin-left: 15px;">Write a Review</button>
            </div>
        </div>
        
        <div class="related-products">
            <h3 class="related-title">You May Also Like</h3>
            <div class="related-grid">
                <!-- Related Product 1 -->
                <div class="product-card">
                    <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                    <div class="product-info">
                        <h3>Men's Checkered Shirt</h3>
                        <div class="product-price">RWF 28,000</div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span>(15)</span>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">Add to Cart</button>
                            <button class="view-details">Details</button>
                        </div>
                    </div>
                </div>
                
                <!-- Related Product 2 -->
                <div class="product-card">
                    <span class="product-badge">New</span>
                    <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                    <div class="product-info">
                        <h3>Men's Denim Shirt</h3>
                        <div class="product-price">RWF 32,000</div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(32)</span>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">Add to Cart</button>
                            <button class="view-details">Details</button>
                        </div>
                    </div>
                </div>
                
                <!-- Related Product 3 -->
                <div class="product-card">
                    <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1527719327859-c6ce80353573?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                    <div class="product-info">
                        <h3>Men's Linen Shirt</h3>
                        <div class="product-price">RWF 27,500</div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span>(8)</span>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">Add to Cart</button>
                            <button class="view-details">Details</button>
                        </div>
                    </div>
                </div>
                
                <!-- Related Product 4 -->
                <div class="product-card">
                    <span class="product-badge">-15%</span>
                    <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                    <div class="product-info">
                        <h3>Men's Casual Shirt (Blue)</h3>
                        <div class="product-price">
                            RWF 25,000 <span class="old-price">RWF 30,000</span>
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span>(24)</span>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">Add to Cart</button>
                            <button class="view-details">Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer (Same as index.html) -->
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
                    <li><a href="faq.html">FAQ</a></li>
                    <li><a href="shipping.html">Shipping Policy</a></li>
                    <li><a href="returns.html">Return Policy</a></li>
                    <li><a href="privacy.html">Privacy Policy</a></li>
                    <li><a href="terms.html">Terms & Conditions</a></li>
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
            <p>&copy; 2024 XY_SHOP. All Rights Reserved. Designed with <i class="fas fa-heart" style="color: #ff6b6b;"></i> in Rwanda</p>
        </div>
    </footer>

    <script>
        // Thumbnail gallery functionality
        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.querySelector('.main-image');
        
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                // Remove active class from all thumbnails
                thumbnails.forEach(t => t.classList.remove('active'));
                // Add active class to clicked thumbnail
                this.classList.add('active');
                // Change main image source
                mainImage.src = this.src;
            });
        });
        
        // Quantity selector functionality
        const minusBtn = document.querySelector('.quantity-btn:first-child');
        const plusBtn = document.querySelector('.quantity-btn:last-child');
        const quantityInput = document.querySelector('.quantity-input');
        
        minusBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            quantityInput.value = value + 1;
        });
        
        // Size selection functionality
        const sizeOptions = document.querySelectorAll('.size-option');
        sizeOptions.forEach(option => {
            option.addEventListener('click', function() {
                sizeOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
        
        // Color selection functionality
        const colorOptions = document.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', function() {
                colorOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
        
        // Tab functionality
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Remove active class from all buttons and contents
                tabBtns.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                // Add active class to clicked button and corresponding content
                this.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });
        
        // Add to cart functionality
        document.querySelector('.add-to-cart').addEventListener('click', function() {
            const productName = document.querySelector('.product-title').textContent;
            const quantity = document.querySelector('.quantity-input').value;
            alert(`${quantity} ${productName}(s) added to your cart!`);
        });
        
        // Buy now functionality
        document.querySelector('.buy-now').addEventListener('click', function() {
            window.location.href = 'checkout.html';
        });
    </script>
</body>
</html>