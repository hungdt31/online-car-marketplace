<div class="container-fluid px-4 py-4">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col">
            <div class="card bg-primary text-white shadow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold">Welcome, <?= htmlspecialchars($payload['name'] ?? 'Admin') ?>!</h2>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-envelope me-2"></i><?= htmlspecialchars($payload['email'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <a href="/branches" class="btn btn-light btn-sm mt-2">
                                Go to Branches
                            </a>
                            <button type="button" class="btn btn-danger btn-sm mt-2" id="logout-btn">
                                <i class="bi bi-box-arrow-right"></i> Log out
                            </button>
                        </div>
                        <div class="text-end">
                            <p class="mb-0"><?= date('l, F j, Y') ?></p>
                            <p class="mb-0 small">Last login: <?= $lastLogin ?? date('Y-m-d H:i:s') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="row mb-4">
        <!-- Blog Stats -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="text-xs fw-bold text-primary text-uppercase">
                            Blog Posts
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-newspaper text-white"></i>
                        </div>
                    </div>
                    <div class="h3 mb-0 fw-bold"><?= number_format($blogCount['total_blogs']) ?></div>
                    <div class="row mt-3 small">
                        <div class="col">
                            <span class="text-success">
                                <i class="fas fa-check-circle me-1"></i><?= number_format($blogCount['published_blogs']) ?>
                            </span>
                            <span class="d-block text-muted">Published</span>
                        </div>
                        <div class="col">
                            <span class="text-warning">
                                <i class="fas fa-edit me-1"></i><?= number_format($blogCount['draft_blogs']) ?>
                            </span>
                            <span class="d-block text-muted">Drafts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Stats -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="text-xs fw-bold text-success text-uppercase">
                            Users
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                    <div class="h3 mb-0 fw-bold"><?= number_format($userCount['total_users']) ?></div>
                    <div class="row mt-3 small">
                        <div class="col">
                            <span class="text-success">
                                <i class="fas fa-user-check me-1"></i><?= number_format($userCount['active_users']) ?>
                            </span>
                            <span class="d-block text-muted">Active</span>
                        </div>
                        <div class="col">
                            <span class="text-info">
                                <i class="fas fa-user-plus me-1"></i><?= number_format($userCount['new_users']) ?>
                            </span>
                            <span class="d-block text-muted">New this month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Views -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="text-xs fw-bold text-info text-uppercase">
                            Blog Views
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-eye text-white"></i>
                        </div>
                    </div>
                    <div class="h3 mb-0 fw-bold"><?= number_format($blogStatsView['total_views_this_month']) ?></div>
                    <div class="mt-3 small">
                        <span class="<?= ($blogStatsView['percentage_difference'] ?? 0) >= 0 ? 'text-success' : 'text-danger' ?>">
                            <i class="fas <?= ($blogStatsView['percentage_difference'] ?? 0) >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' ?> me-1"></i>
                            <?= abs($blogStatsView['percentage_difference'] ?? 5) ?>%
                        </span>
                        <span class="text-muted">from last month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="text-xs fw-bold text-warning text-uppercase">
                            System Status
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-server text-white"></i>
                        </div>
                    </div>
                    <div class="h3 mb-0 fw-bold">Healthy</div>
                    <div class="mt-3 small">
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $serverLoad ?? 25 ?>%"></div>
                        </div>
                        <div class="mt-1 d-flex justify-content-between">
                            <span class="text-muted">Server Load</span>
                            <span><?= $serverLoad ?? 25 ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Blogs -->
        <div class="col-lg-6 mb-4 equal-height-cards">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">Recent Blog Posts</h6>
                    <a href="/blogs-management" class="btn btn-sm">
                        <i class="fas fa-newspaper me-1"></i>View All
                    </a>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentBlogs)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50%">Blog Post</th>
                                        <th>Author & Date</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentBlogs as $blog): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($blog['cover_image_url'])): ?>
                                                        <div class="blog-thumbnail-container me-2">
                                                            <img
                                                                src="<?= htmlspecialchars($blog['cover_image_url']) ?>"
                                                                alt="<?= htmlspecialchars($blog['title']) ?>"
                                                                class="blog-thumbnail"
                                                                onerror="this.src='/assets/img/default-blog-cover.jpg'; this.onerror='';">
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="blog-thumbnail-placeholder me-2 d-flex align-items-center justify-content-center bg-light text-muted">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="fw-medium text-truncate" style="max-width: 250px;" title="<?= htmlspecialchars($blog['title']) ?>">
                                                            <?= htmlspecialchars($blog['title']) ?>
                                                        </div>
                                                        <div class="badge text-white small <?php
                                                                                            switch ($blog['status']) {
                                                                                                case 'published':
                                                                                                    echo 'bg-success';
                                                                                                    break;
                                                                                                case 'draft':
                                                                                                    echo 'bg-secondary';
                                                                                                    break;
                                                                                                case 'pending':
                                                                                                    echo 'bg-info';
                                                                                                    break;
                                                                                                case 'scheduled':
                                                                                                    echo 'bg-primary';
                                                                                                    break;
                                                                                                case 'archived':
                                                                                                    echo 'bg-dark';
                                                                                                    break;
                                                                                                case 'deleted':
                                                                                                    echo 'bg-danger';
                                                                                                    break;
                                                                                                default:
                                                                                                    echo 'bg-warning';
                                                                                            }
                                                                                            ?>">
                                                            <?= ucfirst(htmlspecialchars($blog['status'])) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-medium">
                                                    <i class="fas fa-user-edit me-1 text-muted small"></i>
                                                    <?= htmlspecialchars($blog['author']) ?>
                                                </div>
                                                <div class="text-muted small">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    <?= date('M j, Y', strtotime($blog['date'])) ?>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <a href="/blogs-management/details/<?= $blog['id'] ?? '' ?>" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3 text-muted">
                                <i class="fas fa-newspaper fa-3x"></i>
                            </div>
                            <p>No blog posts found</p>
                            <a href="/blog-management/create">
                                <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus me-1"></i>Create Blog Post
                                </button>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-6 mb-4 equal-height-cards">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">Recent Users</h6>
                    <a href="/users-management" class="btn btn-sm">
                        <i class="fas fa-users me-1"></i>View All
                    </a>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentUsers)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 45%">User</th>
                                        <th>Joined</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentUsers as $user): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($user['avatar_url'])): ?>
                                                        <img
                                                            src="<?= htmlspecialchars($user['avatar_url']) ?>"
                                                            alt="<?= htmlspecialchars($user['username']) ?>"
                                                            class="rounded-circle me-2"
                                                            width="40"
                                                            height="40"
                                                            onerror="this.src='/assets/img/default-avatar.png'; this.onerror='';">
                                                    <?php else: ?>
                                                        <div class="avatar-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; background-color: #6c757d;">
                                                            <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="fw-medium"><?= htmlspecialchars($user['username']) ?></div>
                                                        <div class="text-muted small text-truncate" style="max-width: 200px;"><?= htmlspecialchars($user['email']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><?= date('M j, Y', strtotime($user['created_at'])) ?></div>
                                                <div class="text-muted small"><?= date('g:i A', strtotime($user['created_at'])) ?></div>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="/users-management/details/<?= $user['id'] ?? '' ?>" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="/users-management/edit/<?= $user['id'] ?? '' ?>" class="btn btn-outline-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3 text-muted">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                            <p>No users found</p>
                            <a href="/users-management">
                                <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-plus me-1"></i>Add User
                                </button>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Activities -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row row-cols-2 g-3">
                        <div class="col">
                            <a href="/blogs-management" class="btn btn-light border w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-plus-circle fa-2x text-primary mb-2"></i>
                                <span>New Post</span>
                            </a>
                        </div>
                        <div class="col">
                            <a href="/users-management" class="btn btn-light border w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-user-plus fa-2x text-success mb-2"></i>
                                <span>New User</span>
                            </a>
                        </div>
                        <div class="col">
                            <a href="/categories-management" class="btn btn-light border w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-tags fa-2x text-warning mb-2"></i>
                                <span>Categories</span>
                            </a>
                        </div>
                        <div class="col">
                            <a href="/settings" class="btn btn-light border w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-cog fa-2x text-info mb-2"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Recent Activities</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <li class="list-group-item d-flex align-items-center px-4 py-3">
                                <?php
                                // Sample activity data - replace with actual data
                                $activities = [
                                    ['icon' => 'fa-edit text-primary', 'text' => 'Post "Getting Started with PHP" was updated'],
                                    ['icon' => 'fa-user-plus text-success', 'text' => 'New user John Doe registered'],
                                    ['icon' => 'fa-comment text-info', 'text' => 'New comment received on "Docker for Beginners"'],
                                    ['icon' => 'fa-trash text-danger', 'text' => 'Post "Outdated Tutorial" was deleted'],
                                    ['icon' => 'fa-tag text-warning', 'text' => 'New category "DevOps" was created']
                                ];
                                $activity = $activities[$i] ?? $activities[0];
                                ?>
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="fas <?= $activity['icon'] ?>"></i>
                                </div>
                                <div>
                                    <p class="mb-1"><?= $activity['text'] ?></p>
                                    <small class="text-muted"><?= date('M j, g:i a', strtotime('-' . rand(1, 24) . ' hours')) ?></small>
                                </div>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <div class="card-footer bg-white">
                    <a href="/activities" class="btn btn-sm btn-link text-decoration-none">View all activities</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Select "Logout" below if you are ready to end your current session.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="logout-btn">Logout</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Logout button functionality
        $('#logout-btn').click(function() {
            $.ajax({
                type: 'POST',
                url: '/auth/logout',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = '/auth';
                        }, 2000);
                    }
                }
            });
        });

        // Initialize tooltips if needed
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Optional: Add simple animation to stats cards
        $('.card').each(function(i) {
            setTimeout(function() {
                $('.card').eq(i).addClass('animate__animated animate__fadeIn');
            }, 100 * i);
        });
    });
</script>

<style>
    /* Styles for blog thumbnails */
    .blog-thumbnail-container {
        width: 60px;
        height: 45px;
        overflow: hidden;
        border-radius: 4px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        flex-shrink: 0;
    }

    .blog-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .blog-thumbnail-placeholder {
        width: 60px;
        height: 45px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        flex-shrink: 0;
    }

    /* Đảm bảo cả hai card có chiều cao bằng nhau */
    .equal-height-cards {
        display: flex;
        flex-direction: column;
    }

    .equal-height-cards .card {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .equal-height-cards .card-body {
        flex: 1;
        overflow: auto;
    }

    .equal-height-cards .table-responsive {
        max-height: 380px;
        overflow-y: auto;
    }

    /* Đảm bảo header và footer cố định khi scroll */
    .equal-height-cards .table thead {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1;
    }

    /* Style cho trạng thái status */
    .badge-archived {
        background-color: #6c757d;
    }

    .badge-published {
        background-color: #198754;
    }

    .badge-draft {
        background-color: #6c757d;
    }
</style>