<?php
RenderSystem::render('components',[
    [
        'name' => 'Home/rentalCars',
        'data' => [
            'top_category' => $top_category,
        ]
    ]
])
?>

<!-- Our Services Section -->
<section class="services-section py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">Our Premium Services</h2>
                <p class="section-subtitle">Experience excellence with our premium automotive services</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-car-alt"></i>
                    </div>
                    <h3>Premium Vehicles</h3>
                    <p>Browse our extensive collection of luxury and high-performance vehicles from top manufacturers worldwide.</p>
                    <a href="#" class="btn-service">Explore Inventory</a>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>Financing Options</h3>
                    <p>Flexible financing solutions tailored to your budget with competitive rates and convenient terms.</p>
                    <a href="#" class="btn-service">Learn More</a>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>After-Sales Support</h3>
                    <p>Comprehensive maintenance packages and extended warranty options for your peace of mind.</p>
                    <a href="#" class="btn-service">Our Services</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Customer Reviews Section -->
<section class="reviews-section py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">What Our Customers Say</h2>
                <p class="section-subtitle">Don't just take our word for it - hear from our satisfied customers</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="review-card">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">"Exceptional buying experience from start to finish. The sales team was knowledgeable, patient, and helped me find the perfect car for my needs. The financing process was seamless."</p>
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            <img src="https://ui.shadcn.com/avatars/03.png" alt="John Doe" onerror="this.src='<?= _WEB_ROOT ?>/assets/static/images/user.png'">
                        </div>
                        <div class="reviewer-details">
                            <h4>John Doe</h4>
                            <p>Luxury Car Owner</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="review-card">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">"I've purchased vehicles from many dealerships, but Carvan offers the best selection of premium cars and customer service. Their after-sales support is truly outstanding!"</p>
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            <img src="https://ui.shadcn.com/avatars/02.png" alt="Emily Johnson" onerror="this.src='<?= _WEB_ROOT ?>/assets/static/images/user.png'">
                        </div>
                        <div class="reviewer-details">
                            <h4>Emily Johnson</h4>
                            <p>Repeat Customer</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 mx-auto">
                <div class="review-card">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="review-text">"The entire purchasing process was smooth and transparent. They offered a fair trade-in value for my old car and helped me find financing that fit my budget perfectly."</p>
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            <img src="https://ui.shadcn.com/avatars/01.png" alt="Michael Smith" onerror="this.src='<?= _WEB_ROOT ?>/assets/static/images/user.png'">
                        </div>
                        <div class="reviewer-details">
                            <h4>Michael Smith</h4>
                            <p>First-time Buyer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="/shop" class="btn btn-primary btn-lg">Read More Reviews</a>
            </div>
        </div>
    </div>
</section>

<style>
    /* Reset và General Styles */
    <?php
        RenderSystem::renderOne('assets', 'static/css/home/index.css', []);
    ?>
    
    /* Services Section Styles */
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
    }
    
    .section-subtitle {
        font-size: 1.1rem;
        color: #6c757d;
        max-width: 700px;
        margin: 0 auto 20px;
    }
    
    .service-card {
        background: #fff;
        border-radius: 15px;
        padding: 35px 25px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .service-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: white;
        font-size: 30px;
    }
    
    .service-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }
    
    .service-card p {
        color: #6c757d;
        margin-bottom: 25px;
    }
    
    .btn-service {
        display: inline-block;
        padding: 10px 25px;
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
        color: white;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-service:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        color: white;
    }
    
    /* Reviews Section Styles */
    .reviews-section {
        background-color: #f8f9fa;
    }
    
    .review-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .review-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .review-rating {
        margin-bottom: 20px;
        color: #ffc107;
        font-size: 18px;
    }
    
    .review-text {
        color: #6c757d;
        font-style: italic;
        margin-bottom: 20px;
        min-height: 100px;
    }
    
    .reviewer-info {
        display: flex;
        align-items: center;
    }
    
    .reviewer-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 15px;
    }
    
    .reviewer-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .reviewer-details h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }
    
    .reviewer-details p {
        color: #6c757d;
        margin: 0;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .section-title {
            font-size: 2rem;
        }
        
        .service-card, .review-card {
            margin-bottom: 30px;
        }
        
        .review-text {
            min-height: auto;
        }
    }
</style>