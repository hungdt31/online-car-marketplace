<?php
$page_title = 'About Us';
?>

<div class="container-fluid py-5" style="margin-top: 30px;">
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">About Us</h1>
        <p class="lead text-muted">Learn more about our company and our mission</p>
    </div>

    <!-- Section 1: Hero and Benefits -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <div class="position-relative d-inline-block w-50">
                <img src="<?= htmlspecialchars(_WEB_ROOT) ?>/assets/static/images/half_car_white.png" alt="EV Car"
                    class="img-fluid rounded shadow-sm w-100"
                    style=" border-bottom-right-radius: 30px; border-bottom-left-radius: 30px">

                <div class="position-absolute bottom-0 end-0 px-4 py-5  text-white fw-bold text-center"
                    style="background-color: #4D7CFE; border-top-left-radius: 30px; border-top-right-radius: 10px; border-bottom-left-radius: 10px; border-bottom-right-radius: 30px">
                    <div style="font-size: 1.8rem;">5K+</div>
                    <div style="font-size: 1rem;">Quality cars</div>
                </div>
            </div>

        </div>
        <div class="col-md-5 g-5">
            <h6 class="text-uppercase text-muted mb-5">Electric Cars, Amazing Offers 🚗</h6>
            <h1 class="fw-bold mb-4">Exploring The Benefits Of EVs</h1>
            <p class="text-muted mb-4">
                Discover how electric vehicles can revolutionize your driving experience with sustainable options, lower
                costs, and amazing features.
            </p>

            <div class="row row-cols-2 g-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-globe-americas fs-5 text-primary mt-1"></i>
                    <span class="text-muted">Environmentally Sustainable</span>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-receipt fs-5 text-primary mt-1"></i>
                    <span class="text-muted">Tax Incentives & Rebates</span>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-tools fs-5 text-primary mt-1"></i>
                    <span class="text-muted">Lower Maintenance Costs</span>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-clock-history fs-5 text-primary mt-1"></i>
                    <span class="text-muted">24x7 best customer support</span>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-truck fs-5 text-primary mt-1"></i>
                    <span class="text-muted">Innovative Experience</span>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-signpost fs-5 text-primary mt-1"></i>
                    <span class="text-muted">Better for Short Trips</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Section 2: Booking Steps -->
    <div class="bg-dark text-white text-center py-5 rounded mb-5">
        <h6 class="text-uppercase mb-4 text-decoration-underline">Quick, Easy, and Reliable Car Booking <i
                class="bi bi-car-front"></i>
        </h6>

        <h2 class="fw-bold mb-4">Booking Your Ride Made Simple</h2>
        <div class="row">
            <div class="col-md-4">
                <i class="bi bi-car-front fs-2"></i>
                <h5 class="mt-2">1. Select Your Car</h5>
                <p class="text-muted">Choose the best EV that suits your needs and style.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-geo-alt fs-2"></i>
                <h5 class="mt-2">2. Choose Location</h5>
                <p class="text-muted">Pick your preferred pickup and drop-off points.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-telephone	 fs-2"></i>
                <h5 class="mt-2">3. Confirm Details</h5>
                <p class="text-muted">Review and confirm your ride instantly.</p>
            </div>
        </div>
        <a href="/contact" class="btn btn-outline-light mt-4">Contact us</a>
    </div>

    <!-- Section 3: Services -->
    <div class="text-center">
        <h6 class="text-uppercase text-muted">Your Service, Our Priority </h6>
        <h2 class="fw-bold mb-5">Transforming Needs into Perfect Solutions</h2>
        <div class="row text-start">
            <?php
            $services = [
                ['icon' => 'bi-lightning', 'title' => 'Charging System Services', 'desc' => 'Optimized power delivery for your EV.'],
                ['icon' => 'bi-laptop', 'title' => 'Vehicle Software Updates', 'desc' => 'Keep your system up to date.'],
                ['icon' => 'bi-headset', 'title' => '24x7 Customer Support', 'desc' => 'Help whenever you need it.'],
                ['icon' => 'bi-battery-full', 'title' => 'Battery Health Checks', 'desc' => 'Ensure your battery stays in shape.'],
                ['icon' => 'bi-activity', 'title' => 'Advanced Diagnostics', 'desc' => 'Identify and fix issues quickly.'],
                ['icon' => 'bi-shield-check', 'title' => 'System Safety Inspections', 'desc' => 'Drive with full confidence.'],
                ['icon' => 'bi-speedometer2', 'title' => 'Pressure Monitoring', 'desc' => 'Safe tire pressure at all times.'],
                ['icon' => 'bi-plug', 'title' => 'Charging Unit Inspection', 'desc' => 'Thorough inspection of your chargers.'],
            ];
            foreach ($services as $service) {
                echo "
                <div class='col-md-3 mb-4'>
                    <div class='card h-100 text-center border-0 shadow-sm'>
                        <div class='card-body'>
                            <i class='bi {$service['icon']} fs-2 text-primary mb-3'></i>
                            <h6 class='fw-bold'>{$service['title']}</h6>
                            <p class='text-muted small'>{$service['desc']}</p>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
        </div>
    </div>
</div>