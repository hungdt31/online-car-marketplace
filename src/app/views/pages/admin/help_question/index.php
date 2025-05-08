<div class="container-fluid px-4 py-5">
    <div class="dashboard-header">
        <h4 class="mb-0">Customer Questions</h4>
        <p class="text-white-50 mb-0">Manage and reply to customer questions</p>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Question</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($questions)) : ?>
                        <?php foreach ($questions as $q) : ?>
                        <tr>
                            <td><?= htmlspecialchars($q['name']) ?></td>
                            <td><?= htmlspecialchars($q['email']) ?></td>
                            <td><?= htmlspecialchars($q['question']) ?></td>
                            <td>
                                <span class="badge bg-<?= $q['status'] === 'pending' ? 'warning' : 'success' ?>">
                                    <?= ucfirst($q['status']) ?>
                                </span>
                            </td>
                            <td><?= date('Y-m-d H:i', strtotime($q['create_at'])) ?></td>
                            <td>
                                <?php if ($q['status'] === 'pending') : ?>
                                <button class="btn btn-sm btn-primary reply-btn" data-id="<?= $q['id'] ?>"
                                    data-email="<?= htmlspecialchars($q['email']) ?>"
                                    data-name="<?= htmlspecialchars($q['name']) ?>">
                                    Reply
                                </button>
                                <?php else: ?>
                                <span class="text-muted">Replied</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">No questions found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Send Answer to Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="replyForm">
                        <input type="hidden" id="questionId" name="id">
                        <div class="mb-3">
                            <label class="form-label">To (Email)</label>
                            <input type="email" class="form-control" id="toEmail" name="toEmail" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control"
                                value="Answering for your question about our car website" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea class="form-control" id="mailContent" name="content" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var modal = new bootstrap.Modal(document.getElementById('replyModal'));
    $('.reply-btn').click(function() {
        var id = $(this).data('id');
        var email = $(this).data('email');
        $('#questionId').val(id);
        $('#toEmail').val(email);
        $('#mailContent').val('');
        modal.show();
    });
    $('#replyForm').submit(function(e) {
        e.preventDefault();
        var id = $('#questionId').val();

        $.ajax({
            url: '<?= _WEB_ROOT ?>/admin/help-question/edit/' + id,
            type: 'POST',
            success: function(response) {
                try {
                    response = JSON.parse(response);
                    if (response.success) {
                        toastr.success('Status updated successfully');
                        modal.hide();
                        location.reload(); // Reload để cập nhật trạng thái trong bảng
                    } else {
                        toastr.error(response.message || 'Failed to update status');
                    }
                } catch (e) {
                    toastr.error('Invalid response from server');
                }
            },
            error: function() {
                toastr.error('Failed to connect to server');
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

.badge.bg-warning {
    background: #ffc107;
    color: #212529;
}

.badge.bg-success {
    background: #28a745;
}
</style>