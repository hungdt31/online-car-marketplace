<div class="container-fluid px-4 py-5">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h4 class="mb-0">FAQ Management</h4>
        <p class="text-white-50 mb-0">Manage your frequently asked questions</p>
    </div>

    <!-- Control Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <!-- Search Bar -->
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="Search FAQs...">
        </div>

        <!-- Add New FAQ Button -->
        <a href="<?= _WEB_ROOT ?>/admin/faq/add" class="btn btn-add">
            <i class="fas fa-plus-circle me-2"></i>Add New FAQ
        </a>
    </div>

    <!-- FAQs Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($faqs)) : ?>
                        <?php foreach ($faqs as $faq) : ?>
                        <tr>
                            <td><?= htmlspecialchars($faq['question']) ?></td>
                            <td><?= htmlspecialchars(substr($faq['answer'], 0, 100)) ?>...</td>
                            <td>
                                <span class="badge bg-<?= $faq['status'] === 'active' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($faq['status']) ?>
                                </span>
                            </td>
                            <td><?= date('M d, Y', strtotime($faq['created_at'])) ?></td>
                            <td><?= date('M d, Y', strtotime($faq['updated_at'])) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= _WEB_ROOT ?>/admin/faq/edit/<?= $faq['id'] ?>"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger delete-faq"
                                        data-id="<?= $faq['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">No FAQs found.</td>
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
    // Search functionality
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Delete FAQ
    $('.delete-faq').click(function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this FAQ?')) {
            $.ajax({
                url: '<?= _WEB_ROOT ?>/admin/faq/delete/' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred while deleting the FAQ.');
                }
            });
        }
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

.search-wrapper {
    position: relative;
    min-width: 300px;
}

.search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.search-wrapper input {
    padding-left: 35px;
}

.btn-add {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.btn-add:hover {
    background-color: var(--secondary-color);
    color: white;
}

.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

.badge {
    padding: 0.5em 0.75em;
}
</style>