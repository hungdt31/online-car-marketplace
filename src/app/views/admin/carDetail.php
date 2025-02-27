<div class="modal-header">
    <h1 class="modal-title fs-5" id="carDetailModalLabel">
        <span id="carName" class="text-info"><?= htmlspecialchars($car['name'] ?? 'N/A') ?></span>
    </h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="container">
        <div class="row">
            <p class="col-6"><strong>Fuel Type:</strong> <?= htmlspecialchars($car['fuel_type'] ?? 'N/A') ?></p>
            <p class="col-6"><strong>Mileage:</strong> <?= htmlspecialchars($car['mileage'] ?? 'N/A') ?></p>
        </div>
        <div class="row">
            <p class="col-6"><strong>Drive Type:</strong> <?= htmlspecialchars($car['drive_type'] ?? 'N/A') ?></p>
            <p class="col-6"><strong>Service Duration:</strong> <?= htmlspecialchars($car['service_duration'] ?? 'N/A') ?></p>
        </div>
        <div class="row">
            <p class="col-6"><strong>Body Weight:</strong> <?= htmlspecialchars($car['body_weight'] ?? 'N/A') ?></p>
            <p class="col-6"><strong>Price:</strong> $<?= number_format($car['price'] ?? 0, 2) ?></p>
        </div>
    </div>
</div>