<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-calendar2-check me-2"></i>Appointment Management</h2>
        <a href="<?= _WEB_ROOT ?>/admin/appointments/add" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Appointment
        </a>
    </div>

    <!-- Search and Filter Card -->
    <!-- <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Search & Filter</h5>
        </div>
        <div class="card-body">
            <form id="searchFilterForm" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="searchKeyword" class="form-label text-muted small">Search by Customer or Car</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="searchKeyword" 
                               placeholder="Enter customer name or car model" 
                               name="keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="statusFilter" class="form-label text-muted small">Status</label>
                    <select class="form-select" name="status" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="pending" <?= isset($_GET['status']) && $_GET['status'] === 'pending' ? 'selected' : '' ?>>
                            <i class="bi bi-hourglass"></i> Pending
                        </option>
                        <option value="confirmed" <?= isset($_GET['status']) && $_GET['status'] === 'confirmed' ? 'selected' : '' ?>>
                            <i class="bi bi-check-circle"></i> Confirmed
                        </option>
                        <option value="cancelled" <?= isset($_GET['status']) && $_GET['status'] === 'cancelled' ? 'selected' : '' ?>>
                            <i class="bi bi-x-circle"></i> Cancelled
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-1"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div> -->

    <!-- Appointments Table Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <!-- <i class="bi bi-table me-2"></i> -->
            Appointments List</h5>
            <?php if (isset($total_appointments)): ?>
            <span class="badge bg-primary rounded-pill"><?= $total_appointments ?> appointments</span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" width="5%">ID</th>
                            <th scope="col" width="15%">Customer</th>
                            <th scope="col" width="15%">Car</th>
                            <th scope="col" width="12%">Date</th>
                            <th scope="col" width="10%">Status</th>
                            <th scope="col" width="12%">Purpose</th>
                            <th scope="col" width="15%">Notes</th>
                            <th scope="col" width="8%">Created</th>
                            <th scope="col" width="8%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointments)) : ?>
                        <?php foreach ($appointments as $appointment) : ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= $appointment['id'] ?></span></td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($appointment['user_name']) ?></div>
                            </td>
                            <td><?= htmlspecialchars($appointment['car_name']) ?></td>
                            <td>
                                <i class="bi bi-calendar3 me-1 text-muted"></i>
                                <?= date('Y-m-d', strtotime($appointment['appointment_date'])) ?>
                                <div class="small text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    <?= date('H:i', strtotime($appointment['appointment_date'])) ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge 
                                    <?php
                                        if ($appointment['status'] === 'pending') echo 'bg-warning text-dark';
                                        elseif ($appointment['status'] === 'confirmed') echo 'bg-success';
                                        elseif ($appointment['status'] === 'cancelled') echo 'bg-danger';
                                    ?>">
                                    <?php if ($appointment['status'] === 'pending'): ?>
                                        <i class="bi bi-hourglass me-1"></i>
                                    <?php elseif ($appointment['status'] === 'confirmed'): ?>
                                        <i class="bi bi-check-circle me-1"></i>
                                    <?php elseif ($appointment['status'] === 'cancelled'): ?>
                                        <i class="bi bi-x-circle me-1"></i>
                                    <?php endif; ?>
                                    <?= ucfirst($appointment['status']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($appointment['purpose']) ?></td>
                            <td>
                                <div class="text-truncate" style="max-width: 150px;" title="<?= htmlspecialchars($appointment['notes']) ?>">
                                    <?= htmlspecialchars($appointment['notes']) ?>
                                </div>
                            </td>
                            <td>
                                <div class="small text-muted">
                                    <?= date('Y-m-d', strtotime($appointment['created_at'])) ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <?php if ($appointment['status'] === 'pending') : ?>
                                    <button class="btn btn-sm btn-success confirm-btn" data-id="<?= $appointment['id'] ?>" 
                                            data-bs-toggle="tooltip" title="Confirm Appointment">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger cancel-btn" data-id="<?= $appointment['id'] ?>"
                                            data-bs-toggle="tooltip" title="Cancel Appointment">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                    <?php elseif ($appointment['status'] === 'confirmed') : ?>
                                    <button class="btn btn-sm btn-outline-danger cancel-btn" data-id="<?= $appointment['id'] ?>"
                                            data-bs-toggle="tooltip" title="Cancel Appointment">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                                    No appointments found
                                </div>
                                <p class="small text-muted mt-2">Try adjusting your search filters or add a new appointment</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if (isset($pagination) && $pagination['total_pages'] > 1) : ?>
            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
                <div class="small text-muted">
                    Showing <?= $pagination['from'] ?> - <?= $pagination['to'] ?> of <?= $pagination['total'] ?> entries
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <?php if ($pagination['current_page'] > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= _WEB_ROOT ?>/appointments-management?page=1<?= isset($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : '' ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>" aria-label="First">
                                <i class="bi bi-chevron-double-left"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?= _WEB_ROOT ?>/appointments-management?page=<?= $pagination['current_page'] - 1 ?><?= isset($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : '' ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>" aria-label="Previous">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++) : ?>
                        <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                            <a class="page-link" href="<?= _WEB_ROOT ?>/appointments-management?page=<?= $i ?><?= isset($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : '' ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                        
                        <?php if ($pagination['current_page'] < $pagination['total_pages']) : ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= _WEB_ROOT ?>/appointments-management?page=<?= $pagination['current_page'] + 1 ?><?= isset($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : '' ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>" aria-label="Next">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?= _WEB_ROOT ?>/appointments-management?page=<?= $pagination['total_pages'] ?><?= isset($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : '' ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>" aria-label="Last">
                                <i class="bi bi-chevron-double-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Auto-submit filter when status changes
    $('#statusFilter').change(function() {
        if (this.value) {
            $('#searchFilterForm').submit();
        }
    });

    // Confirm appointment
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

    // Cancel appointment
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
});
</script>