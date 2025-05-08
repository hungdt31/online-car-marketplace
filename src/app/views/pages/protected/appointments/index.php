<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Appointment Management</h2>
        <a href="<?= _WEB_ROOT ?>/admin/appointments/add" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add New Appointment
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Car</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Purpose</th>
                            <th>Notes</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointments)) : ?>
                        <?php foreach ($appointments as $appointment) : ?>
                        <tr>
                            <td><?= $appointment['id'] ?></td>
                            <td><?= htmlspecialchars($appointment['user_name']) ?></td>
                            <td><?= htmlspecialchars($appointment['car_name']) ?></td>
                            <td><?= date('Y-m-d H:i', strtotime($appointment['appointment_date'])) ?></td>
                            <td>
                                <span class="badge 
                                    <?php
                                        if ($appointment['status'] === 'pending') echo 'bg-warning';
                                        elseif ($appointment['status'] === 'confirmed') echo 'bg-success';
                                        elseif ($appointment['status'] === 'cancelled') echo 'bg-danger';
                                    ?>">
                                    <?= ucfirst($appointment['status']) ?>
                                </span>

                            </td>
                            <td><?= htmlspecialchars($appointment['purpose']) ?></td>
                            <td><?= htmlspecialchars($appointment['notes']) ?></td>
                            <td><?= date('Y-m-d H:i', strtotime($appointment['created_at'])) ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <?php if ($appointment['status'] === 'pending') : ?>
                                    <button class="btn btn-sm btn-success confirm-btn"
                                        data-id="<?= $appointment['id'] ?>">
                                        Confirm
                                    </button>
                                    <button class="btn btn-sm btn-danger cancel-btn"
                                        data-id="<?= $appointment['id'] ?>">
                                        Cancel
                                    </button>
                                    <?php elseif ($appointment['status'] === 'confirmed') : ?>
                                    <button class="btn btn-sm btn-outline-danger cancel-btn"
                                        data-id="<?= $appointment['id'] ?>">
                                        Cancel
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>


                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center">No appointments found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.confirm-btn').click(function() {
        const id = $(this).data('id');
        if (!confirm('Are you sure you want to confirm this appointment?')) {
            return;
        }

        $.ajax({
            url: '<?= _WEB_ROOT ?>/admin/appointments/confirm/' + id,
            type: 'POST',
            success: function(response) {
                try {
                    response = JSON.parse(response);
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        toastr.error(response.message);
                    }
                } catch (e) {
                    toastr.error('Invalid server response');
                }
            },
            error: function() {
                toastr.error('Failed to confirm appointment');
            }
        });
    });
});
$('.cancel-btn').click(function() {
    const id = $(this).data('id');
    if (!confirm('Are you sure you want to cancel this appointment?')) {
        return;
    }

    $.ajax({
        url: '<?= _WEB_ROOT ?>/admin/appointments/cancel/' + id,
        type: 'POST',
        success: function(response) {
            try {
                response = JSON.parse(response);
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(response.message);
                }
            } catch (e) {
                toastr.error('Invalid server response');
            }
        },
        error: function() {
            toastr.error('Failed to cancel appointment');
        }
    });
});
</script>