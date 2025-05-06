<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<section class="testimonials">
    <div class="container">
        <div class="section-header-text-center">
            <h4>Your Satisfaction, Our Success</h4>
            <h2>What Our Customers Are Saying</h2>
        </div>

        <div class="customer-avatars">
            <div class="avatar">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/home/avt.jpg" alt="Lan Huong">
                <div class="info">
                    <p class="name">Lan Huong</p>
                    <p class="designation">Regular User</p>
                </div>
            </div>
            <div class="avatar">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/home/avt.jpg" alt="Lan Huong">
                <div class="info">
                    <p class="name">Lan Huong</p>
                    <p class="designation">Regular User</p>
                </div>
            </div>
            <div class="avatar">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/home/avt.jpg" alt="Lan Huong">
                <div class="info">
                    <p class="name">Lan Huong</p>
                    <p class="designation">Regular User</p>
                </div>
            </div>
            <div class="avatar">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/home/avt.jpg" alt="Lan Huong">
                <div class="info">
                    <p class="name">Lan Huong</p>
                    <p class="designation">Regular User</p>
                </div>
            </div>

        </div>

        <div class="testimonial-container">
            <div class="testimonial-left">
                <i class="bi bi-chat-left-quote speech-icon"></i>
                <div class="review-content">
                    <div class="review-header">
                        <h3>Highly Recommend!</h3>
                        <div class="stars">★★★★★</div>
                    </div>
                    <p>Morbi finibus habitant posuere ornare nostra ultricies sodales. Et potenti urna ultrices sagittis
                        metus eleifend rutrum...</p>
                    <button class="read-more">Watch story</button>
                </div>
            </div>
            <div class="testimonial-images">
                <img src="image1.jpg" alt="Review image 1">
                <img src="image2.jpg" alt="Review image 2">
                <img src="image3.jpg" alt="Review image 3">
                <img src="image4.jpg" alt="Review image 4">
                <img src="image5.jpg" alt="Review image 5">
                <img src="image6.jpg" alt="Review image 6">
            </div>
        </div>
    </div>
</section>
<?php
// Load CSS
echo '<style>';
RenderSystem::renderOne('assets', 'static/css/home/testimonials.css', []);
echo '</style>';

// Load JS
echo '<script>';
RenderSystem::renderOne('assets', 'static/js/components/home/testimonials.js', []);
echo '</script>';
?>