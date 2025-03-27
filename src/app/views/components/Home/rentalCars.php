<section class="rental-cars">
    <div class="container">
        <!-- Header Section -->
        <div class="section-header">
            <div class="title-wrapper">
                <p class="subtitle">Effortless Renting Solutions</p>
                <h2>Browse Our Rental Cars</h2>
            </div>
            <div class="category-filters">
                <div class="category-item active">All</div>
                <?php foreach ($top_category as $category) : ?>
                    <div class="category-item" data-category="<?= $category['category_id']; ?>">
                        <?= $category['category_name']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <p></p>
        <!-- Cars Grid -->
        <div class="cars-grid">
            <!-- Car Card 1 -->
            <!-- <div class="car-card">
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
            </div> -->
            <!-- Repeat car-card structure for other cars -->
        </div>
    </div>
</section>
<?php
// Load CSS
echo '<style>';
RenderSystem::renderOne('assets', 'css/home/rentalCars.css', []);
echo '</style>';

// Load JS
echo '<script>';
RenderSystem::renderOne('assets', 'js/home/rentalCars.js', []);
echo '</script>';
?>