<style>
    .modal-body input,
    select {
        margin-top: 10px;
    }

    .action-btn {
        min-width: 100px;
    }
</style>
<div class="modal-header">
    <h1 class="modal-title fs-5" id="carDetailModalLabel">
        <?php if ($getToUpdate): ?>
            <div class="input-group">
                <input type="text" class="form-control p-2" name="name" value="<?= $car['name'] ?? '' ?>" aria-describedby="inputGroup-sizing-default">
            </div>
        <?php else: ?>
            <span id="carName">
                <?= htmlspecialchars($car['name'] ?? 'N/A') ?>
            </span>
            <div class="lead" style="font-size: medium; text-align: left;">
                <i class="bi bi-geo-alt-fill"></i>
                <em id="carLocation">
                    <?= htmlspecialchars($car['location'] ?? 'N/A') ?>
                </em>
            </div>
        <?php endif; ?>
    </h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<?php if ($getToUpdate): ?>
    <div class="p-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text p-3"><strong>Location</strong></div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" value="<?= $car['location'] ?? '' ?>" name="location">
        </div>
    </div>
<?php endif; ?>
<div class="modal-body">
    <div class="container">
        <div class="row mb-3">
            <div class="col-6">
                <label for="fuel_type"><strong>Fuel Type</strong></label>
                <?php if ($getToUpdate): ?>
                    <select class="form-control" id="fuel_type" name="fuel_type">
                        <option value="Petrol" <?= ($car['fuel_type'] ?? '') === 'Petrol' ? 'selected' : '' ?>>Petrol</option>
                        <option value="Diesel" <?= ($car['fuel_type'] ?? '') === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                        <option value="Electric" <?= ($car['fuel_type'] ?? '') === 'Electric' ? 'selected' : '' ?>>Electric</option>
                        <option value="Hybrid" <?= ($car['fuel_type'] ?? '') === 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                    </select>
                <?php else: ?>
                    <p><?= htmlspecialchars($car['fuel_type'] ?? 'N/A') ?></p>
                <?php endif; ?>
            </div>
            <div class="col-6">
                <label for="mileage"><strong>Mileage</strong></label>
                <?php if ($getToUpdate): ?>
                    <input type="text" class="form-control" id="mileage" name="mileage" value="<?= htmlspecialchars($car['mileage'] ?? '') ?>">
                <?php else: ?>
                    <p><?= htmlspecialchars($car['mileage'] ?? 'N/A') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label for="drive_type"><strong>Drive Type</strong></label>
                <?php if ($getToUpdate): ?>
                    <select class="form-control" id="drive_type" name="drive_type">
                        <option value="Self" <?= ($car['drive_type'] ?? '') === 'Self' ? 'selected' : '' ?>>Self</option>
                        <option value="Automatic" <?= ($car['drive_type'] ?? '') === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                        <option value="Manual" <?= ($car['drive_type'] ?? '') === 'Manual' ? 'selected' : '' ?>>Manual</option>
                    </select>
                <?php else: ?>
                    <p><?= htmlspecialchars($car['drive_type'] ?? 'N/A') ?></p>
                <?php endif; ?>
            </div>
            <div class="col-6 mb-3">
                <label for="service_duration"><strong>Service Duration</strong></label>
                <?php if ($getToUpdate): ?>
                    <input type="text" class="form-control" id="service_duration" name="service_duration" value="<?= htmlspecialchars($car['service_duration'] ?? '') ?>">
                <?php else: ?>
                    <p><?= htmlspecialchars($car['service_duration'] ?? 'N/A') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="body_weight"><strong>Body Weight</strong></label>
                <?php if ($getToUpdate): ?>
                    <input type="text" class="form-control" id="body_weight" name="body_weight" value="<?= htmlspecialchars($car['body_weight'] ?? '') ?>">
                <?php else: ?>
                    <p><?= htmlspecialchars($car['body_weight'] ?? 'N/A') ?></p>
                <?php endif; ?>
            </div>
            <div class="col-6">
                <label for="price"><strong>Price</strong></label>
                <?php if ($getToUpdate): ?>
                    <input type="number" class="form-control" id="price" name="price" value="<?= $car['price'] ?>" step="0.01">
                <?php else: ?>
                    <p>$<?= number_format($car['price'] ?? 0, 2) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($getToUpdate): ?>
            <div class="text-center mt-5">
                <button class="btn btn-outline-secondary action-btn" data-bs-dismiss="modal" aria-label="Close" type="button">Exit</button>
                <button type="submit" class="btn btn-outline-primary action-btn save-btn" data-id="<?= htmlspecialchars($car['id']) ?>">Save</button>
            </div>
        <?php else: ?>
            <div class="row mb-5">
                <div class="col-12">
                    <label for="body_weight"><strong>Pictures</strong></label>
                    <div class="row mt-2 align-items-stretch">
                        <?php
                        $type_video = ['video/mp4', 'avi', 'mov', 'wmv', 'flv'];
                        $count = 0;
                        foreach ($car['images'] as $image) {
                            if ($count >= 3) {
                                break;
                            }
                            if (!in_array($image['type'], $type_video)) {
                                $count++;
                                echo '<div class="col-12 col-lg-6 mb-3" style="object-fit: cover;">'; // full width on mobile, half on large
                                echo '<img src="' . htmlspecialchars($image['url']) . '" alt="Car Image" class="img-fluid rounded" style="width: 100%; height: 100%;">';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <a href="/car-assets/<?= htmlspecialchars($car['id']) ?>">
                        <button class="btn btn-outline-secondary mt-3">See more <i class="bi bi-arrow-right-short"></i></button>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>