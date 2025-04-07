<?php
RenderSystem::render('components',[
    [
        'name' => 'Home/rentalCars',
        'data' => [
            'top_category' => $top_category,
        ]
    ],
    [
        'name' => 'Home/testimonials',
        'data' => [
        ]
    ],
    [
        'name' => 'Home/booking',
        'data' => [
        ]
    ]
])
?>

<style>
    /* Reset và General Styles */
    <?php
        RenderSystem::renderOne('assets', 'static/css/home/index.css', []);
    ?>
</style>