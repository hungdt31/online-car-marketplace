<?php
if (empty($user)) {
    // Tạo dữ liệu giả nếu mảng $user rỗng
    $user = [
        [
            "fname" => "Nguyễn",
            "lname" => "A",
            "email" => "nguyena@example.com",
            "reg_date" => "2023-01-01"
        ],
        [
            "fname" => "Trần",
            "lname" => "B",
            "email" => "tranb@example.com",
            "reg_date" => "2023-02-01"
        ]
    ];
}
?>

<section class="rental-cars">
    <div class="container">
        <!-- Header Section -->
        <div class="section-header">
            <div class="title-wrapper">
                <p class="subtitle">Effortless Renting Solutions</p>
                <h2>Browse Our Rental Cars</h2>
            </div>
            <div class="category-filters">
                <a href="#" class="active">All</a>
                <a href="#">Economy</a>
                <a href="#">Electric</a>
                <a href="#">Luxury</a>
            </div>
        </div>

        <!-- Cars Grid -->
        <div class="cars-grid">
            <!-- Car Card 1 -->
            <div class="car-card">
                <div class="car-image">
                    <img src="path-to-car1.jpg" alt="Rapid Falcon GTR">
                    <span class="car-type">Sport Car / Yellow</span>
                </div>
                <div class="car-details">
                    <h3>Rapid Falcon GTR Max</h3>
                    <div class="car-specs">
                        <div class="spec">
                            <i class="icon-fuel"></i>
                            <span>Fuel type: Diesel</span>
                        </div>
                        <div class="spec">
                            <i class="icon-storage"></i>
                            <span>Storage: 450cc + Extra</span>
                        </div>
                    </div>
                    <div class="car-price">
                        <span class="price">$599.00</span>
                        <button class="reserve-btn">Reserve</button>
                    </div>
                </div>
            </div>
            <!-- Repeat car-card structure for other cars -->
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="container">
        <div class="section-header text-center">
            <h4>Your Satisfaction, Our Success</h4>
            <h2>What Our Customers Are Saying</h2>
        </div>

        <div class="customer-avatars">
            <div class="avatar">
                <img src="avatar1.jpg" alt="Lan Huong">
                <span>Lan Huong</span>
                <span class="designation">Regular User</span>
            </div>
            <!-- Repeat for other avatars -->
        </div>

        <div class="testimonial-content">
            <div class="review-text">
                <div class="review-header">
                    <span>Highly Recommend!</span>
                    <div class="stars">★★★★★</div>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                <button class="read-more">Read full story</button>
            </div>
            <div class="review-images">
                <img src="review1.jpg" alt="Review image">
                <!-- Repeat for other review images -->
            </div>
        </div>
    </div>
</section>

<section class="booking-section">
    <div class="container">
        <div class="booking-wrapper">
            <div class="booking-image">
                <img src="car-booking.jpg" alt="Book your vehicle">
                <div class="promo-card">
                    <h3>Limited Offers of Upto 30% For Booking Over 3 Days</h3>
                    <div class="promo-features">
                        <span><i class="icon-check"></i> Standard Car Delivery</span>
                        <span><i class="icon-check"></i> Unlimited Kilometers</span>
                    </div>
                </div>
            </div>

            <div class="booking-form">
                <h2>Book Your Vehicle Now</h2>
                <form>
                    <div class="form-grid">
                        <input type="text" placeholder="Pick-up Location">
                        <input type="text" placeholder="Drop-off Location">
                        <input type="text" placeholder="Pick-up Date">
                        <input type="text" placeholder="Drop-off Date">
                        <input type="text" placeholder="Pick-up Time">
                        <input type="text" placeholder="Drop-off Time">
                    </div>
                    <button type="submit" class="submit-btn">Submit now</button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    /* Reset và General Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Rental Cars Section */
    .rental-cars {
        padding: 60px 0;
        background-color: #fff;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }

    .title-wrapper .subtitle {
        color: #666;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .title-wrapper h2 {
        font-size: 32px;
        font-weight: bold;
    }

    .category-filters {
        display: flex;
        gap: 16px;
    }

    .category-filters a {
        text-decoration: none;
        color: #333;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .category-filters a.active {
        background: #4169E1;
        color: white;
    }

    /* Cars Grid */
    .cars-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    .car-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .car-image {
        position: relative;
        height: 200px;
    }

    .car-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .car-type {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
    }

    .car-details {
        padding: 16px;
    }

    .car-details h3 {
        font-size: 18px;
        margin-bottom: 12px;
    }

    .car-specs {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 16px;
    }

    .spec {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
        font-size: 14px;
    }

    .car-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid #eee;
    }

    .price {
        font-weight: bold;
        font-size: 20px;
    }

    .reserve-btn {
        background: #4169E1;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
    }

    /* Testimonials Section */
    .testimonials {
        background: #f8f8f8;
        padding: 60px 0;
    }

    .text-center {
        text-align: center;
    }

    .testimonials h4 {
        color: #666;
        margin-bottom: 8px;
    }

    .testimonials h2 {
        font-size: 32px;
        margin-bottom: 40px;
    }

    .customer-avatars {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 40px;
    }

    .avatar {
        background: #000;
        color: white;
        padding: 8px 20px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .testimonial-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .stars {
        color: #FFD700;
    }

    .review-text p {
        color: #666;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .read-more {
        background: #4169E1;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 20px;
        cursor: pointer;
    }

    .review-images {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .review-images img {
        width: 100%;
        border-radius: 8px;
    }

    /* Booking Section */
    .booking-section {
        background: #4169E1;
        padding: 60px 0;
    }

    .booking-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
    }

    .booking-image {
        position: relative;
    }

    .booking-image img {
        width: 100%;
        border-radius: 12px;
    }

    .promo-card {
        position: absolute;
        bottom: -20px;
        left: 20px;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        width: calc(100% - 40px);
    }

    .promo-card h3 {
        font-size: 18px;
        margin-bottom: 12px;
    }

    .promo-features {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .booking-form {
        background: white;
        padding: 30px;
        border-radius: 12px;
    }

    .booking-form h2 {
        margin-bottom: 24px;
        color: #333;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }

    .form-grid input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .submit-btn {
        width: 100%;
        background: #4169E1;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .cars-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .cars-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .booking-wrapper,
        .testimonial-content {
            grid-template-columns: 1fr;
        }

        .customer-avatars {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 480px) {
        .cars-grid {
            grid-template-columns: 1fr;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .review-images {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>