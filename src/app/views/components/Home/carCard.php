<!-- (
            [id] => 1
            [name] => Toyota Corolla
            [location] => HCM City
            [overview] => Toyota Corolla is a compact sedan ideal for city driving with great fuel efficiency.
            [fuel_type] => Petrol
            [mileage] => 15 km/l
            [drive_type] => Automatic
            [service_duration] => 2 years
            [body_weight] => 1200 kg
            [price] => 25000.00
            [avg_rating] => 5.00
            [capabilities] => {"engine": "1.8L 4-cylinder", "seats": 5, "features": ["Bluetooth", "Cruise Control", "Backup Camera"]}
            [created_at] => 2025-03-27 03:04:24
            [updated_at] => 2025-03-27 03:04:24
        ) -->
<div class="vehicle-card">
    <div class="vehicle-image">
        <img
            src="<?= isset($image) ? $image : 'https://images.unsplash.com/photo-1704340142770-b52988e5b6eb?q=80&w=2000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' ?>"
            alt="<?= htmlspecialchars($name) ?>">
        <div class="action">
            <a href="<?= htmlspecialchars($link) ?>">View Detail <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                </svg>
            </a>
        </div>
    </div>
    <div class="vehicle-details">
        <p class="vehicle-name"><?= htmlspecialchars($name) ?></p>
        <div class="vehicle-spec">
            <img src="<?= _WEB_ROOT. '/assets/static/images/home/fuel-type.svg' ?>" alt="Fuel Type Icon" width="24" height="24">
            <span class="spec-label">Fuel type:</span>
            <span class="spec-value"><?= htmlspecialchars($fuel_type) ?></span>
        </div>
        <div class="vehicle-spec">
            <img src="<?=  _WEB_ROOT. '/assets/static/images/home/mileage.svg' ?>" alt="Mileage Icon" width="24" height="24">
            <span class="spec-label">Mileage:</span>
            <span class="spec-value"><?= htmlspecialchars($mileage) ?></span>
        </div>
        <div class="vehicle-spec">
            <img src="<?=  _WEB_ROOT. '/assets/static/images/home/drive-type.svg' ?>" alt="Drive Type Icon" width="24" height="24">
            <span class="spec-label">Drive type:</span>
            <span class="spec-value"><?= htmlspecialchars($drive_type) ?></span>
        </div>
        <div class="price-section">
            <span class="price">$<?= htmlspecialchars($price) ?></span>
            <div class="reviews">
                <span>Reviews:</span>
                <div class="star-rating">
                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                    <span><?= htmlspecialchars($avg_rating) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    <?php
    // Load CSS
    RenderSystem::renderOne('assets', 'static/css/home/carCard.css', []);
    ?>
</style>