<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page_title = 'Help Center';
?>

<!-- <div class="help-center-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold text-white mb-3">How Can We Help You?</h1>
                <div class="search-box">
                    <form action="/help/search" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg" placeholder="Search for answers..." name="query">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="container py-5">
    <!-- Help Categories -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">Popular Topics</h2>
            <p class="text-muted">Find quick answers to your most common questions</p>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <a href="#booking" class="help-category-card">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="category-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h5 class="mt-3">Booking</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <a href="#payment" class="help-category-card">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="category-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h5 class="mt-3">Payment</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <a href="#vehicles" class="help-category-card">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="category-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h5 class="mt-3">Vehicles</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <a href="#support" class="help-category-card">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="category-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5 class="mt-3">Support</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- FAQ Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title fw-bold mb-4" id="faq">Frequently Asked Questions</h2>
                    <div class="accordion" id="faqAccordion">
                        <?php if (!empty($faqs)) : ?>
                            <?php foreach ($faqs as $index => $faq) : ?>
                                <?php if ($faq['status'] == 'active') : ?>
                                    <div class="accordion-item mb-3 border rounded">
                                        <h3 class="accordion-header" id="heading<?= $index ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse<?= $index ?>" aria-expanded="false"
                                                aria-controls="collapse<?= $index ?>">
                                                <?= htmlspecialchars($faq['question']) ?>
                                            </button>
                                        </h3>
                                        <div id="collapse<?= $index ?>" class="accordion-collapse collapse"
                                            aria-labelledby="heading<?= $index ?>" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <?= htmlspecialchars($faq['answer']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="alert alert-info">
                                No FAQs available at the moment. Please check back later.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title fw-bold mb-3">Still Need Help?</h3>
                    <p class="mb-4">Can't find what you're looking for? Send us your question and we'll get back to you.</p>
                    
                    <form action="/help/send-question" method="POST" id="helpForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="question" class="form-label">Your Question</label>
                            <textarea class="form-control" name="question" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Question</button>
                    </form>
                </div>
            </div>
            
            <!-- Quick Contact Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">Quick Contact</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i> +84 123 456 789</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> support@carvan.com</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> 123 Nguyen Hue, Ho Chi Minh City</li>
                    </ul>
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Hours -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4 text-center">Our Service Hours</h3>
                    <div class="row text-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="service-time-card">
                                <i class="fas fa-headset text-primary mb-3 service-icon"></i>
                                <h5>Customer Support</h5>
                                <p>Monday - Friday: 8AM - 8PM<br>Saturday: 9AM - 5PM</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="service-time-card">
                                <i class="fas fa-car text-primary mb-3 service-icon"></i>
                                <h5>Car Pickup/Return</h5>
                                <p>Monday - Sunday: 6AM - 10PM</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-time-card">
                                <i class="fas fa-tools text-primary mb-3 service-icon"></i>
                                <h5>Technical Support</h5>
                                <p>24/7 Emergency Service</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<?php if (isset($success_message)): ?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?= htmlspecialchars($success_message) ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?= htmlspecialchars($error_message) ?>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
/* Hero Section */
.help-center-hero {
    background: linear-gradient(rgba(13, 110, 253, 0.8), rgba(13, 110, 253, 0.9)), url("<?= _WEB_ROOT ?>/assets/static/images/help/help-hero.jpg");
    background-size: cover;
    background-position: center;
    padding: 80px 0;
    margin-bottom: 30px;
}

.search-box {
    max-width: 600px;
    margin: 0 auto;
}

.search-box .form-control {
    border-radius: 30px 0 0 30px;
    height: 54px;
}

.search-box .btn {
    border-radius: 0 30px 30px 0;
}

/* Category Cards */
.help-category-card {
    display: block;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
}

.help-category-card:hover {
    transform: translateY(-10px);
}

.category-icon {
    font-size: 2.5rem;
    color: #0d6efd;
}

/* Section Title */
.section-title {
    position: relative;
    padding-bottom: 10px;
    margin-bottom: 20px;
    font-weight: 700;
}

.section-title:after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: 0;
    width: 50px;
    height: 3px;
    background: #0d6efd;
    transform: translateX(-50%);
}

/* Accordion Styling */
.accordion-button:not(.collapsed) {
    color: #0d6efd;
    background-color: #e7f1ff;
    font-weight: 600;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0, 0, 0, .125);
}

.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230d6efd'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.accordion-item {
    background-color: #fff;
    transition: all 0.3s ease;
    margin-bottom: 10px;
    border-radius: 10px;
    overflow: hidden;
}

.accordion-item:hover {
    transform: translateY(-2px);
}

/* Service Hours */
.service-time-card {
    padding: 20px;
    transition: all 0.3s ease;
}

.service-time-card:hover {
    background-color: #f8f9fa;
    border-radius: 10px;
}

.service-icon {
    font-size: 2rem;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .help-center-hero {
        padding: 50px 0;
    }
    
    .search-box .form-control,
    .search-box .btn {
        height: 46px;
    }
}
</style>

<script>
// Form Submission with AJAX
document.getElementById('helpForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;

    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Sending...';

    fetch('/help/send-question', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Create custom toast
            showToast('Success', data.message, 'success');
            // Reset form
            this.reset();
        } else {
            // Show error message
            showToast('Error', data.message || 'Failed to send question. Please try again.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error', 'An error occurred. Please try again.', 'danger');
    })
    .finally(() => {
        // Re-enable submit button and restore original text
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
    });
});

// Function to show toast
function showToast(title, message, type) {
    const toastContainer = document.createElement('div');
    toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
    toastContainer.style.zIndex = '9999';
    
    const toastHTML = `
        <div class="toast show bg-${type} text-white" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-${type} text-white">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.innerHTML = toastHTML;
    document.body.appendChild(toastContainer);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toastContainer.remove();
    }, 5000);
}

// Smooth scroll for category links
document.querySelectorAll('.help-category-card').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 100,
                behavior: 'smooth'
            });
        }
    });
});
</script>