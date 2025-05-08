<section class="testimonials">
    <div class="container">
        <div class="section-header-text-center">
            <h4>Your Satisfaction, Our Success</h4>
            <h2>What Our Customers Are Saying</h2>
        </div>

        <div class="customer-avatars">
            <div class="avatar"
                data-comment="Xe vẫn giữ được sự linh hoạt giữa lái xe hàng ngày và hiệu suất trên đường đua, dù bản GTS hybrid nặng hơn 50kg so với trước. Giá khởi điểm từ 122.095 USD, bản GTS từ 166.895 USD, đắt nhưng xứng đáng với trải nghiệm lái đỉnh cao. Tuy nhiên, việc bỏ tùy chọn số sàn ở Carrera S và nút khởi động thay cho chìa xoay truyền thống khiến một số fan tiếc nuối. Porsche 911 2025 là minh chứng cho sự tiến hóa không ngừng của một huyền thoại"
                data-stars="★★★★★"
                data-image="https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1744099160_car_most.jpg">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/home/avt.jpg" alt="Alice">
                <div class="info">
                    <p class="name">Alice</p>
                    <p class="designation">Regular User</p>
                </div>
            </div>
            <div class="avatar" data-comment="BMW X5 2025 là lựa chọn lý tưởng cho những ai tìm kiếm sự kết hợp giữa hiệu suất, công nghệ và sự sang trọng, dù không phải là rẻ nhất trong phân khúc.

" data-stars="★★★★☆"
                data-image="https://carvannn.s3.ap-southeast-2.amazonaws.com/comments/1745233130_lai_xe_an_toan.jpg">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/home/avt.jpg" alt="Dương">
                <div class="info">
                    <p class="name">Dương</p>
                    <p class="designation">Regular User</p>
                </div>
            </div>
            <div class="avatar" data-comment="Love the tech, but charging takes time." data-stars="★★★☆☆"
                data-image="https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745288989_2024-jeep-wrangler114-649ade7362678.jpg">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/home/avt.jpg" alt="Bob">
                <div class="info">
                    <p class="name">Bob</p>
                    <p class="designation">Regular User</p>
                </div>
            </div>
            <div class="avatar"
                data-comment="The Ferrari 488 is a masterpiece of Italian engineering and design. With its 3.9-liter twin-turbocharged V8 engine, it delivers breathtaking performance while maintaining impressive efficiency at 15 km/l.
The car’s lightweight body at 1200 kg ensures sharp handling and a thrilling driving experience.
Built for those who seek both luxury and speed, the 488 offers self-drive excitement, making every journey feel like a race on the track."
                data-stars="★★★★☆"
                data-image="https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745288989_2024-jeep-wrangler114-649ade7362678.jpg">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/home/avt.jpg" alt="Charlie">
                <div class="info">
                    <p class="name">Charlie</p>
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
                        <div class="stars">★★★★★</div> <!-- Initial stars placeholder -->
                    </div>
                    <p class="testimonial-comment">Click on a customer avatar to see their feedback!</p>
                    <!-- Initial comment -->
                </div>
            </div>
            <div class="testimonial-images">
                <img src="https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1744099160_car_most.jpg"
                    alt="Review image" class="testimonial-image">
            </div>
        </div>
    </div>
</section>

<style>
<?php // Load CSS
RenderSystem::renderOne('assets', 'static/css/home/testimonials.css', []);
?>
</style>
<script>
<?php
    // Load JS
    RenderSystem::renderOne('assets', 'static/js/components/home/testimonials.js', []);
    ?>
</script>