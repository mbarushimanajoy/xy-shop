<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products - XY_SHOP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reuse all the styles from index.html */
        /* Add specific styles for products page */
        .products-hero {
            background-image: linear-gradient(rgba(0, 75, 99, 0.8), rgba(0, 75, 99, 0.8)), url('https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');
            height: 50vh;
        }
        
        .products-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }
        
        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .products-header h2 {
            color: #004b63;
            font-size: 2rem;
            margin: 0;
        }
        
        .sort-filter {
            display: flex;
            gap: 15px;
        }
        
        .sort-filter select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: white;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .product-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .product-image {
            height: 250px;
            background-size: cover;
            background-position: center;
        }
        
        .product-info {
            padding: 20px;
        }
        
        .product-info h3 {
            margin-top: 0;
            color: #004b63;
            font-size: 1.2rem;
        }
        
        .product-price {
            font-weight: bold;
            color: darkcyan;
            font-size: 1.2rem;
            margin: 10px 0;
        }
        
        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 1rem;
            margin-left: 10px;
        }
        
        .product-rating {
            color: #ffcc00;
            margin-bottom: 15px;
        }
        
        .product-actions {
            display: flex;
            gap: 10px;
        }
        
        .add-to-cart, .view-details {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
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
        
        .view-details {
            background-color: white;
            color: #004b63;
            border: 1px solid #004b63;
        }
        
        .view-details:hover {
            background-color: #f0f0f0;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 50px;
            gap: 10px;
        }
        
        .page-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .page-btn:hover, .page-btn.active {
            background-color: #004b63;
            color: white;
            border-color: #004b63;
        }
        
        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .category-sidebar {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .category-sidebar h3 {
            color: #004b63;
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 2px solid darkcyan;
        }
        
        .category-list {
            list-style: none;
            padding: 0;
        }
        
        .category-list li {
            margin-bottom: 10px;
        }
        
        .category-list a {
            color: #333;
            transition: all 0.3s ease;
            display: block;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        
        .category-list a:hover {
            color: darkcyan;
            padding-left: 10px;
        }
        
        .products-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
        }
        
        @media (max-width: 768px) {
            .products-layout {
                grid-template-columns: 1fr;
            }
            
            .products-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
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
                <li><a href="index.html">Home</a></li>
                <li><a href="products.html">Products</a></li>
                <li><a href="categories.html">Categories</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li class="user-profile">
                    <div class="user-avatar">JS</div>
                </li>
                <li><a href="login.html" class="cta-button">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Products Hero Section -->
    <section class="hero-section products-hero">
        <h1>Our Products</h1>
        <p>Discover our wide range of high-quality fashion items</p>
    </section>

    <!-- Products Content -->
    <div class="products-container">
        <div class="products-layout">
            <div class="category-sidebar">
                <h3>Categories</h3>
                <ul class="category-list">
                    <li><a href="#">Men's Clothing</a></li>
                    <li><a href="#">Women's Clothing</a></li>
                    <li><a href="#">Kids & Babies</a></li>
                    <li><a href="#">Shoes & Footwear</a></li>
                    <li><a href="#">Accessories</a></li>
                    <li><a href="#">Bags & Luggage</a></li>
                    <li><a href="#">Jewelry</a></li>
                    <li><a href="#">Watches</a></li>
                    <li><a href="#">Sports & Outdoor</a></li>
                </ul>
                
                <h3 style="margin-top: 30px;">Filter By</h3>
                <div class="filter-group">
                    <h4>Price Range</h4>
                    <input type="range" min="0" max="100000" value="50000" class="slider" id="priceRange">
                    <p>Max: RWF <span id="priceValue">50,000</span></p>
                </div>
                
                <div class="filter-group">
                    <h4>Size</h4>
                    <div class="size-options">
                        <label><input type="checkbox" name="size" value="S"> S</label>
                        <label><input type="checkbox" name="size" value="M"> M</label>
                        <label><input type="checkbox" name="size" value="L"> L</label>
                        <label><input type="checkbox" name="size" value="XL"> XL</label>
                    </div>
                </div>
                
                <div class="filter-group">
                    <h4>Color</h4>
                    <div class="color-options">
                        <span class="color-dot" style="background-color: #000;"></span>
                        <span class="color-dot" style="background-color: #fff; border: 1px solid #ddd;"></span>
                        <span class="color-dot" style="background-color: #f00;"></span>

<span class="color-dot" style="background-color: #0f0;"></span>
                        <span class="color-dot" style="background-color: #00f;"></span>
                        <span class="color-dot" style="background-color: #ff0;"></span>
                    </div>
                </div>
                
                <button class="apply-filters">Apply Filters</button>
            </div>
            
            <div class="products-main">
                <div class="products-header">
                    <h2>All Products</h2>
                    <div class="sort-filter">
                        <select id="sortBy">
                            <option value="popular">Sort by: Popularity</option>
                            <option value="newest">Sort by: Newest</option>
                            <option value="price-low">Sort by: Price Low to High</option>
                            <option value="price-high">Sort by: Price High to Low</option>
                            <option value="rating">Sort by: Customer Rating</option>
                        </select>
                        <select id="showCount">
                            <option value="12">Show: 12</option>
                            <option value="24">Show: 24</option>
                            <option value="36">Show: 36</option>
                            <option value="all">Show: All</option>
                        </select>
                    </div>
                </div>
                
                <div class="products-grid">
                    <!-- Product 1 -->
                    <div class="product-card">
                        <div class="product-badge">Sale</div>
                        <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                        <div class="product-info">
                            <h3>Men's Casual Shirt</h3>
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
                    
                    <!-- Product 2 -->
                    <div class="product-card">
                        <div class="product-badge">New</div>
                        <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                        <div class="product-info">
                            <h3>Women's Summer Dress</h3>
                            <div class="product-price">RWF 35,000</div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(18)</span>
                            </div>
                            <div class="product-actions">
                                <button class="add-to-cart">Add to Cart</button>
                                <button class="view-details">Details</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 3 -->
                    <div class="product-card">
                        <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1523170335258-f5ed11844a49?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                        <div class="product-info">
                            <h3>Unisex Sneakers</h3>
                            <div class="product-price">RWF 45,000</div>
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
                    
                    <!-- Product 4 -->
                    <div class="product-card">
                        <div class="product-badge">-20%</div>
                        <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                        <div class="product-info">
                            <h3>Leather Handbag</h3>
                            <div class="product-price">
                                RWF 55,000 <span class="old-price">RWF 68,000</span>
                            </div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(15)</span>
                            </div>
                            <div class="product-actions">
                                <button class="add-to-cart">Add to Cart</button>
                                <button class="view-details">Details</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 5 -->
                    <div class="product-card">
                        <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                        <div class="product-info">
                            <h3>Men's Formal Suit</h3>
                            <div class="product-price">RWF 85,000</div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(12)</span>
                            </div>
                            <div class="product-actions">
                                <button class="add-to-cart">Add to Cart</button>
                                <button class="view-details">Details</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 6 -->
                    <div class="product-card">
                        <div class="product-badge">Hot</div>
                        <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1539533018447-63fcce2678e4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                        <div class="product-info">
                            <h3>Women's Winter Coat</h3>
                            <div class="product-price">RWF 65,000</div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(28)</span>
                            </div>
                            <div class="product-actions">
                                <button class="add-to-cart">Add to Cart</button>
                                <button class="view-details">Details</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 7 -->
                    <div class="product-card">
                        <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                        <div class="product-info">
                            <h3>Kids T-Shirt Set</h3>
                            <div class="product-price">RWF 15,000</div>
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
                    
                    <!-- Product 8 -->
                    <div class="product-card">
                        <div class="product-badge">Limited</div>
                        <div class="product-image" style="background-image: url('https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');"></div>
                        <div class="product-info">
                            <h3>Sports Running Shoes</h3>
                            <div class="product-price">RWF 50,000</div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(21)</span>
                            </div>
                            <div class="product-actions">
                                <button class="add-to-cart">Add to Cart</button>
                                <button class="view-details">Details</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="pagination">
                    <button class="page-btn disabled"><i class="fas fa-chevron-left"></i></button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">4</button>
                    <button class="page-btn">5</button>
                    <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
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
                    <li><a href="index.html">Home</a></li>
                    <li><a href="products.html">Products</a></li>
                    <li><a href="categories.html">Categories</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="blog.html">Blog</a></li>
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
        // Price range slider
        const priceSlider = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        
        priceSlider.addEventListener('input', function() {
            priceValue.textContent = new Intl.NumberFormat().format(this.value);
        });
        
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productName = this.closest('.product-card').querySelector('h3').textContent;
                alert(`${productName} has been added to your cart!`);
            });
        });
        
        // View details functionality
        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                const productName = this.closest('.product-card').querySelector('h3').textContent;
                window.location.href = 'product-detail.html?product=' + encodeURIComponent(productName);
            });
        });
    </script>
</body>
</html>