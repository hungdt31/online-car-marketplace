<div class="card">
    <h2 class="card-header d-flex justify-content-between align-items-center">
        <span>Your Appointments</span>
        <a href="/shop">
            <button class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle me-1"></i>Schedule New
            </button>
        </a>
    </h2>
    <div class="card-body">
        <?php if (empty($appointments)): ?>
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                No appointments scheduled yet.
            </div>
        <?php else: ?>
            <!-- Filter Controls -->
            <div class="row mb-3">
                <div class="col-md-8 mb-2 mb-md-0">
                    <div class="d-flex flex-wrap gap-2">
                        <select id="statusFilter" class="form-select form-select-sm" style="width: auto;">
                            <option value="all">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>

                        <select id="purposeFilter" class="form-select form-select-sm" style="width: auto;">
                            <option value="all">All Purposes</option>
                            <option value="test_drive">Test Drive</option>
                            <option value="inspection">Vehicle Inspection</option>
                            <option value="purchase">Purchase Discussion</option>
                            <option value="financing">Financing Options</option>
                        </select>

                        <select id="sortOrder" class="form-select form-select-sm" style="width: auto;">
                            <option value="latest">Latest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="upcoming">Upcoming First</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        <button class="btn btn-outline-secondary" type="button" id="searchButton">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-outline-danger" type="button" id="resetButton">
                            <i class="fas fa-times"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="appointmentsTable" class="table table-hover appointment-table">
                    <thead class="table-light">
                        <tr>
                            <th>Chosen Vehicle</th>
                            <th>Date & Time</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment):
                            // Format the date and time
                            $appointmentDateTime = new DateTime($appointment['date']);
                            $date = $appointmentDateTime->format('M j, Y');
                            $time = $appointmentDateTime->format('g:i A');
                            $isoDate = $appointmentDateTime->format('c'); // ISO format for sorting

                            // Determine status badge class
                            $statusClass = 'bg-secondary';
                            if ($appointment['status'] == 'confirmed') {
                                $statusClass = 'bg-success';
                            } elseif ($appointment['status'] == 'pending') {
                                $statusClass = 'bg-warning text-dark';
                            } elseif ($appointment['status'] == 'cancelled') {
                                $statusClass = 'bg-danger';
                            } elseif ($appointment['status'] == 'completed') {
                                $statusClass = 'bg-info';
                            }

                            // Check if appointment can be cancelled (not in past, not already cancelled or completed)
                            $canCancel = $appointmentDateTime > new DateTime() &&
                                !in_array($appointment['status'], ['cancelled', 'completed']);
                        ?>
                            <tr data-date="<?= $isoDate ?>" data-purpose="<?= htmlspecialchars($appointment['purpose'], ENT_QUOTES, 'UTF-8') ?>" data-status="<?= htmlspecialchars($appointment['status'], ENT_QUOTES, 'UTF-8') ?>">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($appointment['car_image'])): ?>
                                            <img src="<?= htmlspecialchars($appointment['car_image'], ENT_QUOTES, 'UTF-8') ?>"
                                                class="car-thumbnail me-2" alt="<?= htmlspecialchars($appointment['name'], ENT_QUOTES, 'UTF-8') ?>">
                                        <?php else: ?>
                                            <div class="car-thumbnail-placeholder me-2">
                                                <i class="fas fa-car"></i>
                                            </div>
                                        <?php endif; ?>
                                        <span><?= htmlspecialchars($appointment['name'], ENT_QUOTES, 'UTF-8') ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div><?= $date ?></div>
                                    <small class="text-muted"><?= $time ?></small>
                                </td>
                                <td>
                                    <?= ucfirst(htmlspecialchars($appointment['purpose'], ENT_QUOTES, 'UTF-8')) ?>
                                </td>
                                <td>
                                    <span class="badge <?= $statusClass ?>">
                                        <?= ucfirst(htmlspecialchars($appointment['status'], ENT_QUOTES, 'UTF-8')) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary view-details"
                                            data-id="<?= $appointment['id'] ?>"
                                            data-car="<?= htmlspecialchars($appointment['name'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-date="<?= $date ?>"
                                            data-time="<?= $time ?>"
                                            data-purpose="<?= htmlspecialchars($appointment['purpose'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-notes="<?= htmlspecialchars($appointment['notes'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-status="<?= htmlspecialchars($appointment['status'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-car-id="<?= $appointment['car_id'] ?>"
                                            data-car-image="<?= htmlspecialchars($appointment['car_image'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                            data-fuel-type="<?= htmlspecialchars($appointment['fuel_type'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                            data-drive-type="<?= htmlspecialchars($appointment['drive_type'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                            data-mileage="<?= htmlspecialchars($appointment['mileage'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                            data-price="<?= htmlspecialchars($appointment['price'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                            data-location="<?= htmlspecialchars($appointment['location'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#appointmentDetailsModal">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <?php if ($canCancel): ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger cancel-appointment"
                                                data-id="<?= $appointment['id'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#cancelAppointmentModal">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="d-flex justify-content-between align-items-center mt-3">
                <div class="pagination-info small text-muted">
                    Showing <span id="showing-start">1</span> to <span id="showing-end">10</span> of <span id="total-items"><?= count($appointments) ?></span> appointments
                </div>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled" id="prev-page">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active" data-page="1"><a class="page-link" href="#">1</a></li>
                    <li class="page-item" id="next-page">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="alert alert-info d-none mt-3" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                No appointments match your search criteria.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Appointment Details Modal -->
<div class="modal fade" id="appointmentDetailsModal" tabindex="-1" aria-labelledby="appointmentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="appointmentDetailsModalLabel">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column - Car Details -->
                    <div class="col-md-5 border-end">
                        <div id="car-image-container" class="text-center mb-3">
                            <img id="modal-car-image" class="img-fluid rounded car-detail-img"
                                src="" alt="Vehicle Image">
                        </div>
                        <h5 id="modal-car" class="text-center mb-3 fw-bold"></h5>
                        <div class="car-specs">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Fuel Type:</span>
                                <span id="modal-fuel-type" class="fw-medium"></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Drive Type:</span>
                                <span id="modal-drive-type" class="fw-medium"></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Mileage:</span>
                                <span id="modal-mileage" class="fw-medium"></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Price:</span>
                                <span id="modal-price" class="fw-bold text-primary"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Appointment Details -->
                    <div class="col-md-7">
                        <h6 class="border-bottom pb-2 mb-3">Appointment Information</h6>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="text-muted">Date:</label>
                                </div>
                                <div class="col-sm-8">
                                    <p id="modal-date" class="mb-1 fw-medium"></p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="text-muted">Time:</label>
                                </div>
                                <div class="col-sm-8">
                                    <p id="modal-time" class="mb-1 fw-medium"></p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="text-muted">Purpose:</label>
                                </div>
                                <div class="col-sm-8">
                                    <p id="modal-purpose" class="mb-1 fw-medium"></p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="text-muted">Status:</label>
                                </div>
                                <div class="col-sm-8">
                                    <span id="modal-status-badge" class="badge"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="text-muted">Location:</label>
                                </div>
                                <div class="col-sm-8">
                                    <p id="modal-location" class="mb-1 fw-medium"></p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted">Notes:</label>
                            <div class="p-2 bg-light rounded mt-1">
                                <p id="modal-notes" class="mb-0 fst-italic"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" id="modal-cancel-btn" class="btn btn-danger d-none" 
                    data-id="" data-bs-toggle="modal" data-bs-target="#cancelAppointmentModal">
                    Cancel Appointment
                </button> -->
                <a id="modal-car-link" href="#" target="_blank">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-car me-1"></i> View Car Details
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Appointment Modal -->
<div class="modal fade" id="cancelAppointmentModal" tabindex="-1" aria-labelledby="cancelAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelAppointmentModalLabel">Cancel Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this appointment? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep It</button>
                <button type="button" id="confirmCancelBtn" class="btn btn-danger" data-id="">Yes, Cancel It</button>
            </div>
        </div>
    </div>
</div>

<style>
    .car-thumbnail {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
    }

    .car-thumbnail-placeholder {
        width: 60px;
        height: 40px;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        color: #aaa;
    }

    .appointment-table td {
        vertical-align: middle;
    }

    .car-detail-img {
        max-height: 180px;
        object-fit: cover;
        width: 100%;
    }

    #modal-notes:empty:before {
        content: 'No notes provided';
        color: #999;
    }

    .modal-lg {
        max-width: 800px;
    }

    @media (max-width: 767px) {
        .col-md-5.border-end {
            border-right: none !important;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
    }

    /* Additional styles for pagination */
    #pagination .page-link {
        cursor: pointer;
    }

    #pagination .page-item.disabled .page-link {
        cursor: not-allowed;
    }

    @media (max-width: 767px) {
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination-info {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }
    }

    /* Highlight active filters */
    select.active-filter {
        border-color: #0d6efd;
    }
</style>

<script>
    $(document).ready(function() {

        // Make sure event handlers are properly attached
        function attachEventHandlers() {
            // Event handlers for filters
            $('#statusFilter, #purposeFilter').on('change', function() {
                console.log('Filter changed:', $(this).attr('id'), $(this).val());
                filterTable();
            });

            $('#sortOrder').on('change', function() {
                console.log('Sort changed:', $(this).val());
                sortTable();
                showCurrentPage();
            });

            $('#searchButton').on('click', function() {
                console.log('Search clicked', $('#searchInput').val());
                filterTable();
            });

            $('#searchInput').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    console.log('Search enter pressed', $(this).val());
                    filterTable();
                }
            });

            $('#resetButton').on('click', function() {
                // Clear search field
                $('#searchInput').val('');

                // Reset all filters to default values
                $('#statusFilter').val('all').removeClass('active-filter');
                $('#purposeFilter').val('all').removeClass('active-filter');
                $('#sortOrder').val('latest');

                console.log('Filters reset');

                // Apply filters (resets everything)
                filterTable();

                // Provide visual feedback - check if toastr exists first
                if (typeof toastr !== 'undefined') {
                    toastr.info('Filters have been reset');
                } else {
                    alert('Filters have been reset');
                }
            });
        }
        // View appointment details
        $('.view-details').on('click', function() {
            const id = $(this).data('id');
            const car = $(this).data('car');
            const date = $(this).data('date');
            const time = $(this).data('time');
            const purpose = $(this).data('purpose');
            const notes = $(this).data('notes') || '';
            const status = $(this).data('status');
            const carId = $(this).data('car-id');
            const carImage = $(this).data('car-image') || '/assets/img/car-placeholder.jpg';
            const fuelType = $(this).data('fuel-type') || 'Not specified';
            const driveType = $(this).data('drive-type') || 'Not specified';
            const mileage = $(this).data('mileage') || 'Not specified';
            const price = $(this).data('price') || '0.00';
            const location = $(this).data('location') || 'Not specified';

            // Fill modal with car details
            $('#modal-car').text(car);
            $('#modal-car-image').attr('src', carImage).attr('alt', car);
            $('#modal-fuel-type').text(fuelType);
            $('#modal-drive-type').text(driveType);
            $('#modal-mileage').text(mileage);
            $('#modal-price').text('$' + Number(price).toLocaleString());
            $('#modal-location').text(location);

            // Fill modal with appointment details
            $('#modal-date').text(date);
            $('#modal-time').text(time);
            $('#modal-purpose').text(purpose.charAt(0).toUpperCase() + purpose.slice(1));
            $('#modal-notes').text(notes);
            $('#modal-car-link').attr('href', '/shop/detail/' + carId);

            // Set status badge
            let statusClass = 'bg-secondary';
            if (status === 'confirmed') {
                statusClass = 'bg-success';
            } else if (status === 'pending') {
                statusClass = 'bg-warning text-dark';
            } else if (status === 'cancelled') {
                statusClass = 'bg-danger';
            } else if (status === 'completed') {
                statusClass = 'bg-info';
            }

            $('#modal-status-badge')
                .removeClass('bg-secondary bg-success bg-warning bg-danger bg-info text-dark')
                .addClass(statusClass)
                .text(status.charAt(0).toUpperCase() + status.slice(1));

            // Show/hide cancel button based on status
            const appointmentDate = new Date(`${date} ${time}`);
            const now = new Date();

            if (appointmentDate > now && !['cancelled', 'completed'].includes(status)) {
                $('#modal-cancel-btn').removeClass('d-none').data('id', id);
            } else {
                $('#modal-cancel-btn').addClass('d-none');
            }
        });

        // Set appointment ID for cancellation
        $('.cancel-appointment, #modal-cancel-btn').on('click', function() {
            const appointmentId = $(this).data('id');
            $('#confirmCancelBtn').data('id', appointmentId);
        });

        // Handle cancel appointment confirmation
        $('#confirmCancelBtn').on('click', function() {
            const appointmentId = $(this).data('id');

            // Disable button and show loading state
            const $btn = $(this);
            const originalText = $btn.text();
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');

            // Send AJAX request to cancel appointment
            $.ajax({
                url: '/user/appointments/cancel',
                type: 'POST',
                data: {
                    appointment_id: appointmentId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Close modal
                        $('#cancelAppointmentModal').modal('hide');

                        // Show success message
                        toastr.success(response.message || 'Appointment cancelled successfully');

                        // Reload page after short delay
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        // Show error message
                        toastr.error(response.message || 'Failed to cancel appointment');

                        // Reset button state
                        $btn.prop('disabled', false).text(originalText);
                    }
                },
                error: function() {
                    // Show error message
                    toastr.error('An error occurred. Please try again later.');

                    // Reset button state
                    $btn.prop('disabled', false).text(originalText);
                }
            });
        });

        // ===== NEW CODE FOR FILTERING, SORTING, AND PAGINATION =====

        // Variables for pagination
        let currentPage = 1;
        const rowsPerPage = 10;
        let filteredRows = [];

        // Initialize
        function initializeTable() {
            filteredRows = $('#appointmentsTable tbody tr').toArray();
            updatePagination();
            showCurrentPage();
        }

        // Filter the table based on selected filters
        function filterTable() {
            const status = $('#statusFilter').val();
            const purpose = $('#purposeFilter').val();
            const searchTerm = $('#searchInput').val().toLowerCase().trim();

            // Toggle active filter class for visual feedback
            $('#statusFilter').toggleClass('active-filter', status !== 'all');
            $('#purposeFilter').toggleClass('active-filter', purpose !== 'all');

            // Get all rows
            const allRows = $('#appointmentsTable tbody tr').toArray();

            // Filter rows based on criteria
            filteredRows = allRows.filter(function(row) {
                const $row = $(row);
                const rowStatus = $row.data('status');
                const rowPurpose = $row.data('purpose');
                const rowText = $row.text().toLowerCase();

                // Check if row matches all filters
                const statusMatch = status === 'all' || rowStatus === status;
                const purposeMatch = purpose === 'all' || rowPurpose === purpose;
                const searchMatch = !searchTerm || rowText.includes(searchTerm);

                return statusMatch && purposeMatch && searchMatch;
            });

            // Sort filtered rows
            sortTable();

            // Reset to first page and update pagination
            currentPage = 1;
            updatePagination();
            showCurrentPage();

            // Show/hide no results message
            if (filteredRows.length === 0) {
                $('#no-results').removeClass('d-none');
                $('#pagination').addClass('d-none');
            } else {
                $('#no-results').addClass('d-none');
                $('#pagination').removeClass('d-none');
            }
        }

        // Sort the filtered rows
        function sortTable() {
            const sortOption = $('#sortOrder').val();

            filteredRows.sort(function(a, b) {
                const $a = $(a);
                const $b = $(b);
                const dateA = new Date($a.data('date')); // Get ISO date from data attribute
                const dateB = new Date($b.data('date'));

                // Check if the dates are valid
                const isValidDateA = !isNaN(dateA.getTime());
                const isValidDateB = !isNaN(dateB.getTime());

                // If either date is invalid, sort alphabetically by car name as fallback
                if (!isValidDateA || !isValidDateB) {
                    const nameA = $a.find('td:first-child span').text();
                    const nameB = $b.find('td:first-child span').text();
                    return nameA.localeCompare(nameB);
                }

                const now = new Date();

                if (sortOption === 'oldest') {
                    return dateA - dateB;
                } else if (sortOption === 'upcoming') {
                    // For upcoming sort: future dates first (closest to now), then past dates
                    const diffA = dateA >= now ? dateA - now : Number.MAX_SAFE_INTEGER;
                    const diffB = dateB >= now ? dateB - now : Number.MAX_SAFE_INTEGER;

                    // If both are in the future or both are in the past, sort by closest/furthest
                    if ((dateA >= now && dateB >= now) || (dateA < now && dateB < now)) {
                        return diffA - diffB;
                    }

                    // Otherwise, future dates come before past dates
                    return dateA >= now ? -1 : 1;
                } else {
                    // Default: latest first
                    return dateB - dateA;
                }
            });

            // Debug - check if sort is working
            console.log("Sort option:", sortOption);
            console.log("First few rows after sorting:",
                filteredRows.slice(0, 3).map(row => {
                    const $row = $(row);
                    return {
                        date: $row.data('date'),
                        car: $row.find('td:first-child span').text().trim()
                    };
                })
            );
        }

        // Update pagination controls
        function updatePagination() {
            const totalRows = filteredRows.length;
            const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));

            // Update pagination info
            $('#total-items').text(totalRows);
            const start = totalRows === 0 ? 0 : ((currentPage - 1) * rowsPerPage) + 1;
            const end = Math.min(currentPage * rowsPerPage, totalRows);
            $('#showing-start').text(start);
            $('#showing-end').text(end);

            // Clear existing page links (except first, prev, next)
            $('.page-item').not('#prev-page, #next-page').remove();

            // Add page links
            const $nextPage = $('#next-page');
            const maxVisiblePages = 5;
            const startPage = Math.max(1, Math.min(currentPage - Math.floor(maxVisiblePages / 2), totalPages - maxVisiblePages + 1));
            const endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            for (let i = startPage; i <= endPage; i++) {
                const $pageItem = $('<li class="page-item" data-page="' + i + '"><a class="page-link" href="#">' + i + '</a></li>');
                if (i === currentPage) {
                    $pageItem.addClass('active');
                }
                $nextPage.before($pageItem);
            }

            // Update prev/next buttons
            $('#prev-page').toggleClass('disabled', currentPage === 1);
            $('#next-page').toggleClass('disabled', currentPage === totalPages);
        }

        // Show the current page of results
        function showCurrentPage() {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const visibleRows = filteredRows.slice(start, end);

            // Hide all rows and then show only the ones for current page
            $('#appointmentsTable tbody tr').hide();
            visibleRows.forEach(row => $(row).show());
        }

        // Event handlers for filters
        $('#statusFilter, #purposeFilter, #sortOrder').on('change', filterTable);

        $('#searchButton').on('click', filterTable);

        $('#searchInput').on('keyup', function(e) {
            if (e.key === 'Enter') {
                filterTable();
            }
        });

        // Add event handler for the reset button
        $('#resetButton').on('click', function() {
            // Clear search field
            $('#searchInput').val('');

            // Reset all filters to default values
            $('#statusFilter').val('all').removeClass('active-filter');
            $('#purposeFilter').val('all').removeClass('active-filter');
            $('#sortOrder').val('latest');

            // Apply filters (resets everything)
            filterTable();

            // Provide visual feedback
            toastr.info('Filters have been reset');
        });

        // Handle page navigation
        $(document).on('click', '.page-item:not(.disabled)', function(e) {
            e.preventDefault();

            // Handle prev/next buttons
            if ($(this).attr('id') === 'prev-page') {
                currentPage--;
            } else if ($(this).attr('id') === 'next-page') {
                currentPage++;
            } else {
                currentPage = parseInt($(this).data('page'));
            }

            updatePagination();
            showCurrentPage();
        });

        // Initialize the table
        initializeTable();

        // Attach event handlers
        attachEventHandlers();
    });
</script>