<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Add New Appointment</h2>
        <a href="<?= _WEB_ROOT ?>/admin/appointments" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="appointmentForm">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Customer</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="">Select Customer</option>
                        <?php foreach ($users as $user) : ?>
                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="car_id" class="form-label">Car</label>
                    <select class="form-select" id="car_id" name="car_id" required>
                        <option value="">Select Car</option>
                        <?php foreach ($cars as $car) : ?>
                        <option value="<?= $car['id'] ?>"><?= htmlspecialchars($car['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="appointment_date" class="form-label">Appointment Date</label>
                    <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date"
                        required>
                </div>

                <div class="mb-3">
                    <label for="purpose" class="form-label">Purpose</label>
                    <textarea class="form-control" id="purpose" name="purpose" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Appointment</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#appointmentForm').submit(function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: '<?= _WEB_ROOT ?>/admin/appointments/add',
            type: 'POST',
            data: formData,
            success: function(response) {
                try {
                    response = JSON.parse(response);
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            window.location.href =
                                '<?= _WEB_ROOT ?>/admin/appointments';
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                } catch (e) {
                    toastr.error('Invalid server response');
                }
            },
            error: function() {
                toastr.error('Failed to add appointment');
            }
        });
    });
});
</script>