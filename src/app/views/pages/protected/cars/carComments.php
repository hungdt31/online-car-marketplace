<div class="container-fluid py-4">
    <?php
    if (isset($_GET['id'])) {
        echo ' 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/cars-management">Cars</a></li>
                <li class="breadcrumb-item"><a href="/car-assets/' . $_GET['id'] . '">Car Assets</a></li>
                <li class="breadcrumb-item active" aria-current="page">' . $car['name'] . '</li>
            </ol>
        </nav>';
    } else {
        echo ' 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/cars-management">Cars</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Reviews</li>
            </ol>
        </nav>';
    }
    ?>
    <div class="row mb-4">
        <!-- Thống kê -->
        <div class="col-sm-4 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <h4 class="text-sm mb-2 text-uppercase font-weight-bold text-primary">Total Evaluate</h4>
                                <h5 class="font-weight-bolder" id="totalReviewsCount"><?= count($data['comments']) ?></h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-success text-sm font-weight-bolder"><i class="fa fa-arrow-up"></i> 3%</span>
                                    <span class="text-muted">compared to last month</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape btn btn-outline-primary shadow text-center rounded-circle">
                                <i class="fas fa-comments text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <h4 class="text-sm mb-2 text-uppercase font-weight-bold text-warning">Pending</h4>
                                <h5 class="font-weight-bolder" id="pendingReviewsCount">7</h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-danger text-sm font-weight-bolder"><i class="fa fa-arrow-up"></i> 2</span>
                                    <span class="text-muted">new comments</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape btn btn-outline-warning shadow text-center rounded-circle">
                                <i class="fas fa-hourglass-half text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <h4 class="text-sm mb-2 text-uppercase font-weight-bold text-success">Average Ratings</h4>
                                <h5 class="font-weight-bolder d-flex align-items-center">
                                    4.3
                                    <span class="ms-2 fs-6 text-muted">/ 5</span>
                                </h5>
                                <div class="d-flex">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <i class="fas fa-star-half-alt text-warning me-1"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape btn btn-outline-success shadow text-center rounded-circle">
                                <i class="fas fa-star text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bộ lọc -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-uppercase">Smart Filter</h4>
                </div>
                <div class="card-body pt-2 pb-5">
                    <form id="filterForm" class="row g-3">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-5 col-sm-6">
                                <label class="form-label">Rating</label>
                                <select class="form-select" name="rating">
                                    <option value="">All</option>
                                    <option value="5">5 STARS</option>
                                    <option value="4">4 STARS</option>
                                    <option value="3">3 STARS</option>
                                    <option value="2">2 STARS</option>
                                    <option value="1">1 STAR</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-5 col-sm-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <!-- <div class="col-lg-2 col-md-4 col-sm-6">
                                <label class="form-label">Sort By</label>
                                <select class="form-select" name="sort_by">
                                    <option value="date_desc">Newest</option>
                                    <option value="date_asc">Oldest</option>
                                    <option value="rating_desc">Max ratings</option>
                                    <option value="rating_asc">Min ratings</option>
                                </select>
                            </div> -->
                            <div class="col-lg-6 col-md-10 col-sm-12">
                                <label class="form-label">Range Time</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="start_date" placeholder="Từ">
                                    <span class="input-group-text">to</span>
                                    <input type="date" class="form-control" name="end_date" placeholder="Đến">
                                </div>
                            </div>
                        </div>

                        <div class="d-sm-flex gap-3 justify-content-between align-items-center">
                            <div class="input-group mt-3">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="searchReviews" placeholder="Search by username, email, content...">
                                <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-end mt-3">
                                <button type="submit" class="btn btn-primary w-100" style="min-width: 200px;">
                                    <i class="fas fa-filter me-2"></i> Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng đánh giá -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <?php if (!empty($data['comments'])): ?>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable p-3" data-sort="user">
                                            User <i class="fas fa-sort ms-1" style="opacity: 0.2;"></i>
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 sortable p-3" data-sort="car">
                                            Model <i class="fas fa-sort ms-1" style="opacity: 0.2;"></i>
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 sortable p-3" data-sort="rating">
                                            Rating <i class="fas fa-sort ms-1" style="opacity: 0.2;"></i>
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 sortable p-3" data-sort="content">
                                            Content <i class="fas fa-sort ms-1" style="opacity: 0.2;"></i>
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable p-3" data-sort="date">
                                            Created At <i class="fas fa-sort ms-1" style="opacity: 0.2;"></i>
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable p-3" data-sort="status">
                                            Status <i class="fas fa-sort ms-1" style="opacity: 0.2;"></i>
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['comments'] as $comment): ?>
                                        <tr class="review-row" data-id="<?= $comment['comment_id'] ?>" data-status=<?= $comment['comment_status'] ?> data-rating="<?= $comment['rating'] ?>" data-date="<?= $comment['comment_created_at'] ?>">
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <?php if ($comment['avatar_url']): ?>
                                                            <img src="<?= htmlspecialchars($comment['avatar_url']); ?>" class="avatar avatar-sm me-3" alt="Avatar">
                                                        <?php else: ?>
                                                            <div class="avatar avatar-sm bg-gradient-secondary me-3">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm car-name"><?= htmlspecialchars($comment['fname'] . ' ' . $comment['lname']); ?></h6>
                                                        <p class="text-xs text-secondary mb-0"><?= htmlspecialchars($comment['email']); ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="car-model-badge bg-light rounded-pill px-2 py-1 me-2">
                                                        <i class="fas fa-car text-primary me-1"></i> <?= htmlspecialchars($comment['car_name']); ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <?php if ($i <= $comment['rating']): ?>
                                                            <i class="fas fa-star text-warning"></i>
                                                        <?php else: ?>
                                                            <i class="far fa-star text-secondary"></i>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                    <span class="ms-2 badge bg-gradient-info"><?= $comment['rating'] ?>.0</span>
                                                </div>
                                            </td>
                                            <td style="max-width: 250px;">
                                                <div>
                                                    <p class="text-xs font-weight-bold mb-1"><?= htmlspecialchars($comment['comment_title']); ?></p>
                                                    <p class="text-xs text-secondary mb-0 text-wrap comment-ellipsis">
                                                        <?= substr($comment['comment_content'], 0, 100); ?>
                                                        <?= (strlen($comment['comment_content']) > 100) ? '...' : ''; ?>
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"><?= date('d/m/Y', strtotime($comment['comment_created_at'])); ?></span>
                                                <p class="text-xs text-muted mb-0"><?= date('H:i', strtotime($comment['comment_created_at'])); ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm <?php
                                                                            if ($comment['comment_status'] == 'pending') {
                                                                                echo 'bg-warning';
                                                                            } elseif ($comment['comment_status'] == 'approved') {
                                                                                echo 'bg-success';
                                                                            } else {
                                                                                echo 'bg-danger';
                                                                            }
                                                                            ?>"><?= htmlspecialchars($comment['comment_status']) ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="dropdown text-center">
                                                    <a href="#" class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v text-lg"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewCommentModal<?= $comment['comment_id']; ?>">
                                                                <i class="fas fa-eye text-info me-2"></i> See details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item approve-comment" href="#" data-id="<?= $comment['comment_id']; ?>">
                                                                <i class="fas fa-check text-success me-2"></i> Approve
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#replyModal" data-id="<?= $comment['comment_id']; ?>">
                                                                <i class="fas fa-reply text-primary me-2"></i> Reply
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item delete-comment" href="#" data-id="<?= $comment['comment_id']; ?>">
                                                                <i class="fas fa-trash text-danger me-2"></i> Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <div class="d-flex justify-content-center mt-4">
                            <ul class="pagination"></ul>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5" id="emptyTableMessage">
                            <div class="mb-4">
                                <i class="fas fa-comments fa-4x text-secondary opacity-50"></i>
                            </div>
                            <h5 class="text-muted">Không có đánh giá nào</h5>
                            <p class="text-muted">Chưa có đánh giá nào được tạo cho xe này.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal trả lời đánh giá -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="replyForm">
                        <input type="hidden" id="commentId" name="comment_id">
                        <div class="mb-3">
                            <label class="form-label">Response</label>
                            <textarea class="form-control" rows="5" name="reply_content" placeholder="Enter your feedback..." required></textarea>
                            <small class="form-text text-muted">This feedback will be displayed publicly under customer reviews.</small>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="notifyUser" name="notify_user" checked>
                            <label class="form-check-label" for="notifyUser">
                                Notify customers via email
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="submitReply">
                        <i class="fas fa-paper-plane me-1"></i> Gửi phản hồi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Các modal chi tiết comments -->
<?php foreach ($data['comments'] as $comment): ?>
    <!-- Modal xem chi tiết bình luận -->
    <div class="modal fade" id="viewCommentModal<?= $comment['comment_id']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comment Details #<?= $comment['comment_id']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h5>User Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <?php if ($comment['avatar_url']): ?>
                                            <img src="<?= htmlspecialchars($comment['avatar_url']); ?>" class="avatar avatar-lg rounded-circle me-3" alt="Avatar">
                                        <?php else: ?>
                                            <div class="avatar avatar-lg bg-gradient-secondary me-3">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <h6 class="mb-0"><?= htmlspecialchars($comment['fname'] . ' ' . $comment['lname']); ?></h6>
                                            <p class="text-sm text-secondary mb-0">@<?= htmlspecialchars($comment['username']); ?></p>
                                        </div>
                                    </div>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($comment['email']); ?></p>
                                    <?php if ($comment['phone']): ?>
                                        <p><strong>Telephone:</strong> <?= htmlspecialchars($comment['phone']); ?></p>
                                    <?php endif; ?>
                                    <?php if ($comment['address']): ?>
                                        <p><strong>Address:</strong> <?= htmlspecialchars($comment['address']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h5>Evaluation Information</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Model:</strong> <?= htmlspecialchars($comment['car_name']); ?></p>
                                    <p><strong>Ratings:</strong>
                                        <span class="ms-2">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $comment['rating']): ?>
                                                    <i class="fas fa-star text-warning"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star text-secondary"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            (<?= $comment['rating'] ?>.0)
                                        </span>
                                    </p>
                                    <p><strong>Evaluated Date:</strong> <?= date('d/m/Y H:i', strtotime($comment['comment_created_at'])); ?></p>
                                    <p><strong>Status:</strong> <span class="badge badge-sm 
                                        <?php
                                        if ($comment['comment_status'] == 'pending') {
                                            echo 'bg-warning';
                                        } elseif ($comment['comment_status'] == 'approved') {
                                            echo 'bg-success';
                                        } else {
                                            echo 'bg-danger';
                                        }
                                        ?>
                                    "><?= htmlspecialchars($comment['comment_status']) ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header pb-0">
                            <h5>Evaluation Content</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3"><?= htmlspecialchars($comment['comment_title']); ?></h5>
                            <div class="bg-light p-3 rounded">
                                <p><?= $comment['comment_content']; ?></p>
                            </div>

                            <?php if (isset($comment['file_url']) && $comment['file_url']): ?>
                                <div class="mt-3">
                                    <h6>Tệp đính kèm:</h6>
                                    <a href="<?= htmlspecialchars($comment['file_url']); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="fas fa-file-download me-1"></i>
                                        <?= htmlspecialchars($comment['file_name'] ?: 'Tải tệp đính kèm'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header pb-0">
                            <h5>Reply Content</h5>
                        </div>
                        <div class="card-body">
                            <?php if (isset($comment['comment_reply'])): ?>
                                <div class="mt-2">
                                    <h6>Created at: <?= date('d/m/Y H:i', strtotime($comment['comment_reply_created_at'])); ?></h6>
                                    <p><?= $comment['comment_reply'] ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger delete-comment" data-id="<?= $comment['comment_id']; ?>" data-bs-dismiss="modal">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                    <button type="button" class="btn btn-warning reject-comment" data-id="<?= $comment['comment_id']; ?>">
                        <i class="fas fa-ban me-1"></i> Reject
                    </button>
                    <button type="button" class="btn btn-success approve-comment" data-id="<?= $comment['comment_id']; ?>">
                        <i class="fas fa-check me-1"></i> Approve
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal" data-id="<?= $comment['comment_id']; ?>" data-bs-dismiss="modal">
                        <i class="fas fa-reply me-1"></i> Reply
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<style>
    <?php
    RenderSystem::renderOne('assets', 'static/css/cars/carComments.css');
    ?>
</style>

<script>
    <?php
    RenderSystem::renderOne('assets', 'static/js/pages/carComments.js');
    ?>
</script>