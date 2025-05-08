<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3a0ca3;
        --accent-color: #f72585;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --gray-color: #6c757d;
        --border-radius: 15px;
        --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--dark-color);
        background-color: #ffffff;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 80px 0;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("<?= _WEB_ROOT ?>/assets/static/images/pattern.png");
        background-size: cover;
        opacity: 0.1;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        margin-bottom: 30px;
        opacity: 0.9;
    }

    /* Contact Box */
    .contact-quick-box {
        background: white;
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: var(--box-shadow);
        margin-top: 30px;
        transition: var(--transition);
    }

    .contact-quick-box:hover {
        transform: translateY(-10px);
    }

    .contact-quick-box h3 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 20px;
    }

    .contact-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        background: var(--light-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: var(--primary-color);
        font-size: 20px;
        transition: var(--transition);
    }

    .contact-info-item:hover .contact-icon {
        background: var(--primary-color);
        color: white;
        transform: rotateY(180deg);
    }

    .contact-text {
        flex: 1;
    }

    .contact-text h4 {
        font-size: 18px;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .contact-text p {
        color: var(--gray-color);
        margin: 0;
    }

    /* Form Section */
    .form-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    .form-container {
        background: white;
        border-radius: var(--border-radius);
        padding: 40px;
        box-shadow: var(--box-shadow);
    }

    .section-title {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }

    .section-title h2 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 15px;
        font-size: 2.5rem;
    }

    .section-title p {
        color: var(--gray-color);
        max-width: 700px;
        margin: 0 auto;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .contact-form .form-group {
        margin-bottom: 25px;
    }

    .contact-form label {
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
    }

    .contact-form .form-control {
        height: 50px;
        border-radius: 10px;
        border: 1px solid #e1e1e1;
        padding: 10px 15px;
        font-size: 16px;
        transition: var(--transition);
    }

    .contact-form .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
    }

    .contact-form textarea.form-control {
        height: 150px;
        resize: none;
    }

    .btn-submit {
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        width: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
    }

    /* Map Section */
    .map-section {
        padding: 80px 0;
    }

    .map-container {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
    }

    .map-container iframe {
        width: 100%;
        height: 400px;
        border: 0;
    }

    /* Social Media */
    .social-media {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .social-icon {
        width: 50px;
        height: 50px;
        background: var(--light-color);
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 10px;
        font-size: 20px;
        transition: var(--transition);
        text-decoration: none;
    }

    .social-icon:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-5px);
    }

    /* Response Message */
    .response-message {
        padding: 15px;
        margin-top: 20px;
        border-radius: var(--border-radius);
        text-align: center;
        font-weight: 600;
    }

    .response-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .response-error {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 3rem;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        .contact-quick-box {
            margin-bottom: 30px;
        }
        .form-container {
            padding: 30px 20px;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 2rem;
        }
        .section-title h2 {
            font-size: 2rem;
        }
        .contact-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">Contact Us</h1>
                <p class="hero-subtitle">Let us know what you're thinking, what you need, and how we can assist you.</p>
                <div class="d-flex align-items-center mt-4">
                    <div class="contact-box-badge">
                        <i class="fas fa-headset fa-2x"></i>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0 fw-bold">24/7 Support</p>
                        <p class="mb-0">Our team is always ready to help you</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-card">
                    <img src="<?= _WEB_ROOT ?>/assets/static/images/contact.avif" alt="car" width="350px" height="250px" class="rounded-pill mb-3">
                    <div class="contact-card-info">
                        <h3>Premium Car For Purchasing</h3>
                        <p>Experience quality service with our modern fleet</p>
                        <a href="#" class="btn btn-light mt-2">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wave-container">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 150">
            <path fill="#ffffff" fill-opacity="1" d="M0,96L48,90.7C96,85,192,75,288,80C384,85,480,107,576,112C672,117,768,107,864,90.7C960,75,1056,53,1152,53.3C1248,53,1344,75,1392,85.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Quick Contact Info -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-quick-box h-100">
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Address</h4>
                            <p>H6 Building, HCMUT</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Email</h4>
                            <p>carvan.contact@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-quick-box h-100">
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Phone</h4>
                            <p>012345678910</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Working Hours</h4>
                            <p>Mon - Sat: 9AM - 6PM</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="contact-quick-box h-100 d-flex flex-column justify-content-center align-items-center text-center">
                    <h3>Connect With Us</h3>
                    <p class="mb-4">Follow us on social media for the latest news and special offers</p>
                    <div class="social-media">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="form-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="section-title">
                    <h2>Send Us a Message</h2>
                    <p>Fill out the form below and we will get back to you as soon as possible</p>
                </div>
                <div class="form-container">
                    <form id="emailForm" class="contact-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">
                            <span id="submit-text">Send Message</span>
                            <span id="submit-loader" class="d-none">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Sending...
                            </span>
                        </button>
                        <div id="responseMessage" class="response-message d-none"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4946681013896!2d106.65843807469749!3d10.77228668931163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!5e0!3m2!1svi!2s!4v1708614186024!5m2!1svi!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById("emailForm").addEventListener("submit", function (event) {
        event.preventDefault();

        let formData = new FormData(this);
        let xhr = new XMLHttpRequest();
        let submitText = document.getElementById("submit-text");
        let submitLoader = document.getElementById("submit-loader");
        let submitButton = this.querySelector("button[type='submit']");
        let responseMessage = document.getElementById("responseMessage");

        // Show loading state
        submitButton.disabled = true;
        submitText.classList.add("d-none");
        submitLoader.classList.remove("d-none");
        responseMessage.className = "response-message d-none";

        xhr.open("POST", "product/sendMail", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                submitButton.disabled = false;
                submitText.classList.remove("d-none");
                submitLoader.classList.add("d-none");

                responseMessage.classList.remove("d-none");
                
                if (xhr.status === 200) {
                    responseMessage.innerHTML = "Email has been sent successfully!";
                    responseMessage.className = "response-message response-success";
                    document.getElementById("emailForm").reset();
                } else {
                    responseMessage.innerHTML = "Failed to send email. Please try again later!";
                    responseMessage.className = "response-message response-error";
                }
                
                // Automatically hide the message after 5 seconds
                setTimeout(function() {
                    responseMessage.classList.add("d-none");
                }, 5000);
            }
        };

        xhr.send(formData);
    });

    // Animation on scroll
    document.addEventListener("DOMContentLoaded", function() {
        const boxes = document.querySelectorAll('.contact-quick-box');
        
        boxes.forEach((box, index) => {
            setTimeout(() => {
                box.style.opacity = "1";
                box.style.transform = "translateY(0)";
            }, index * 200);
        });
    });
</script>

<style>
    /* Animation styles */
    .contact-quick-box {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.5s ease;
    }
    
    .map-container {
        transition: var(--transition);
    }
    
    .map-container:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    /* Hero Section styling additions */
    .wave-container {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        line-height: 0;
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-10px);
    }

    .car-image {
        width: 250px;
        height: auto;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .contact-card:hover .car-image {
        transform: scale(1.05);
    }

    .contact-card-info {
        width: 100%;
    }

    .contact-box-badge {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
</style>