<div class="container-fluid px-4 py-5">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h4 class="mb-0">Add New FAQ</h4>
        <p class="text-white-50 mb-0">Create a new frequently asked question</p>
    </div>

    <!-- Add FAQ Form -->
    <div class="card">
        <div class="card-body">
            <form id="addFaqForm">
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <input type="text" class="form-control" id="question" name="question" required>
                </div>
                <div class="mb-3">
                    <label for="answer" class="form-label">Answer</label>
                    <textarea class="form-control" id="answer" name="answer" rows="5" required></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save FAQ
                    </button>
                    <a href="<?= _WEB_ROOT ?>/faq" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#addFaqForm').on('submit', function(e) {
        e.preventDefault();

        var formData = {
            question: $('#question').val(),
            answer: $('#answer').val()
        };

        $.ajax({
            url: '<?= _WEB_ROOT ?>/admin/faq/add',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.href = '<?= _WEB_ROOT ?>/admin/faq';
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('An error occurred while saving the FAQ.');
            }
        });
    });
});
</script>

<style>
.dashboard-header {
    background-color: var(--primary-color);
    color: white;
    padding: 1.5rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
}

.form-label {
    font-weight: 500;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
}
</style>