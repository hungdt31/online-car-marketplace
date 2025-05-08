<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Schedule Purchase Appointment</h5>
    </div>
    <div class="card-body">
        <form action="/shop/schedule" method="POST" id="scheduleForm">
            <input type="hidden" name="car_id" value="<?php echo $data['car_id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">

            <div class="mb-3">
                <label for="appointmentDate" class="form-label">Select Date</label>
                <input type="date" class="form-control" id="appointmentDate" name="appointmentDate"
                    min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="mb-3">
                <label for="appointmentTime" class="form-label">Select Time</label>
                <input type="time" class="form-control" id="appointmentTime" name="appointmentTime" required>
            </div>

            <div class="mb-3">
                <label for="brand_id" class="form-label">Address</label>
                 <select class="form-select" id="branch_id" name="branch_id" required>
                    <option value="" selected disabled>Select Branch</option>
                    <?php foreach ($data['branches'] as $branch) : ?>
                        <option value="<?= $branch['id'] ?>"><?= htmlspecialchars($branch['address']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="purpose" class="form-label">Purpose</label>
                <select class="form-select" id="purpose" name="purpose" required>
                    <option value="" selected disabled>Select purpose</option>
                    <option value="test_drive">Test Drive</option>
                    <option value="inspection">Vehicle Inspection</option>
                    <option value="purchase">Purchase Discussion</option>
                    <option value="financing">Financing Options</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Additional Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"
                    placeholder="Any specific requests or questions..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Schedule Appointment</button>
        </form>
    </div>
</div>

<script>
    $('#scheduleForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Get date and time values directly from the input fields
        const date = $('#appointmentDate').val();
        const time = $('#appointmentTime').val();

        // Validate inputs
        if (!date || !time) {
            toastr.error('Please select both date and time for your appointment');
            return false;
        }

        // Create a combined date-time string in ISO format (YYYY-MM-DD HH:MM:SS)
        const combinedDateTime = `${date} ${time}:00`;

        // Create a new FormData object based on the form
        const formDataObj = new FormData(this);

        // Remove the separate date and time fields
        formDataObj.delete('appointmentDate');
        formDataObj.delete('appointmentTime');

        // Add the combined datetime
        formDataObj.append('date', combinedDateTime);

        // Convert to regular object for AJAX
        const formDataForAjax = {};
        formDataObj.forEach((value, key) => {
            formDataForAjax[key] = value;
        });

        console.log(formDataForAjax); // Debugging line

        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        // console.log(formDataForAjax); // Debugging line
        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'), // Use the form's action attribute
            data: formDataForAjax,
            success: function(response) {
                // Parse JSON response if needed
                let result = response;
                if (typeof response === 'string') {
                    try {
                        result = JSON.parse(response);
                    } catch (e) {
                        console.error('Invalid JSON response');
                    }
                }

                if (result.success) {
                    // Show success message
                    toastr.success(result.message || 'Appointment scheduled successfully!');

                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = '/account?tab=appointments'; // Redirect to appointments page
                    }, 1500);
                } else {
                    // Show error message
                    toastr.error(result.message || 'Error scheduling appointment');

                    // Reset button
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            },
            error: function(xhr, status, error) {
                // Handle error response
                toastr.error('Error scheduling appointment: ' + (xhr.responseJSON?.message || error));

                // Reset button
                submitBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
</script>