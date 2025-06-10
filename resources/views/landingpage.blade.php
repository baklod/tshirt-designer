<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FABLAB - Innovative Products & Solutions</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#home">FABLAB</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item nav-cart">
                        <a class="nav-link" href="#cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge">3</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                       
                        <h2 class="hero-subtitle">Innovation Meets Excellence</h2>
                        <p class="hero-description">
                            Discover cutting-edge products designed to transform your world. From revolutionary tech solutions to premium fabricated goods, we bring tomorrow's innovations to today's market.
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('login') }}" class="btn btn-primary-custom">
                                <i class="fas fa-shopping-bag me-2"></i>Shop Now
                            </a>
                            <button class="btn btn-outline-custom">
                                <i class="fas fa-play me-2"></i>Watch Demo
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="{{ asset('images/logo.png') }}" alt="FABLAB Logo" class="hero-logo" style="width: 400px; height: auto; animation: float 6s ease-in-out infinite;">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="scroll-indicator">
            <i class="fas fa-chevron-down fa-2x"></i>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="section-padding">
        <div class="container">
            <h2 class="section-title">Our Products</h2>
            <p class="section-subtitle">Explore our range of innovative products designed to enhance your life and work</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-microchip"></i>
                            <div class="product-badge">New</div>
                        </div>
                        <div class="product-content">
                            <div class="product-category">Electronics</div>
                            <h3 class="product-title">Smart IoT Controller</h3>
                            <p class="product-description">
                                Advanced IoT controller with Wi-Fi connectivity, real-time monitoring, and smartphone integration.
                            </p>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-text">(128 reviews)</span>
                            </div>
                            <div class="product-price">$299.99</div>
                            <button class="btn btn-add-cart">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-tools"></i>
                            <div class="product-badge">Popular</div>
                        </div>
                        <div class="product-content">
                            <div class="product-category">Tools</div>
                            <h3 class="product-title">Precision Multi-Tool Kit</h3>
                            <p class="product-description">
                                Professional-grade multi-tool kit with 24 precision instruments for electronics and mechanical work.
                            </p>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="rating-text">(89 reviews)</span>
                            </div>
                            <div class="product-price">$149.99</div>
                            <button class="btn btn-add-cart">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-cube"></i>
                            <div class="product-badge">Custom</div>
                        </div>
                        <div class="product-content">
                            <div class="product-category">3D Printing</div>
                            <h3 class="product-title">Custom 3D Print Service</h3>
                            <p class="product-description">
                                High-quality 3D printing service with multiple materials and finishing options for your projects.
                            </p>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-text">(67 reviews)</span>
                            </div>
                            <div class="product-price">From $25.00</div>
                            <button class="btn btn-add-cart">
                                <i class="fas fa-quote-left me-2"></i>Get Quote
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section section-padding">
        <div class="container">
            <h2 class="section-title">Why Choose FABLAB?</h2>
            <p class="section-subtitle">We're committed to delivering exceptional quality and innovation in every product</p>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4>Premium Quality</h4>
                        <p>Every product undergoes rigorous testing to ensure it meets our high standards for durability and performance.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h4>Innovation First</h4>
                        <p>We stay ahead of the curve, incorporating the latest technologies and design principles into our products.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>Expert Support</h4>
                        <p>Our dedicated support team is always ready to help you get the most out of your FABLAB products.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4>Fast Delivery</h4>
                        <p>Quick and reliable shipping ensures you get your products when you need them, anywhere in the world.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section section-padding">
        <div class="container">
            <div class="cta-content">
                <h2 class="section-title text-white mb-4">Ready to Experience the Future?</h2>
                <p class="lead mb-5">Join thousands of satisfied customers who trust FABLAB for their innovative product needs.</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <button class="btn btn-primary-custom btn-lg">Start Shopping</button>
                    <button class="btn btn-outline-custom btn-lg">Contact Sales</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="mb-3">FABLAB</h3>
                    <p>Innovating tomorrow's products today. Connect with us to discover how we can transform your ideas into reality.</p>
                </div>
                <div class="col-lg-6">
                    <h5 class="mb-3">Connect With Us</h5>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                    <p class="mt-3">info@fablab.com | +1 (555) 123-4567</p>
                </div>
            </div>
            <hr class="my-4">
            <p class="text-center mb-0">&copy; 2025 FABLAB. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.15)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            }
        });

        // Add scroll reveal animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.product-card, .feature-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>