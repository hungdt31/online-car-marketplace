<section class="rental-cars">
    <div class="container">
        <!-- Header Section -->
        <div class="section-header">
            <div class="title-wrapper">
                <p class="subtitle">Effortless Buying Solutions</p>
                <h2>Browse Our Perfect Cars</h2>
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
            <!-- Car Card 2 -->
            <!-- .......... -->
        </div>
    </div>
</section>
<?php
// Load CSS
echo '<style>';
RenderSystem::renderOne('assets', 'static/css/home/rentalCars.css', []);
echo '</style>';

// Load JS
echo '<script>';
RenderSystem::renderOne('assets', 'static/js/components/home/rentalCars.js', []);
echo '</script>';
?>