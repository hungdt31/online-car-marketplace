<style>
    <?php
    RenderSystem::renderOne('assets', 'static/css/posts/commentManager.css');
    ?>
</style>

<div class="container-fluid px-4 py-5">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h4 class="mb-3 mt-3">Blog Comments Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/blogs-management">Blogs</a></li>
            </ol>
        </nav>
    </div>

    <!-- Control Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Search Bar -->
        <div class="search-wrapper m-0">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="Search comments...">
        </div>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="py-3 sortable" data-sort="id">
                        ID
                        <i class="fas fa-sort ms-1"></i>
                    </th>
                    <th class="py-3 sortable" data-sort="blog">
                        Blog Post
                        <i class="fas fa-sort ms-1"></i>
                    </th>
                    <th class="py-3 sortable" data-sort="comment">
                        Comment
                        <i class="fas fa-sort ms-1"></i>
                    </th>
                    <th class="py-3 sortable text-center" data-sort="author">
                        Author
                        <i class="fas fa-sort ms-1"></i>
                    </th>
                    <th class="py-3 sortable text-center" data-sort="created_at">
                        Date
                        <i class="fas fa-sort ms-1"></i>
                    </th>
                    <th class="text-center py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="commentsTableBody">
                <?php if (!empty($comments)) : ?>
                    <?php foreach ($comments as $comment) : ?>
                        <tr class="comment-row">
                            <td class="align-middle"><?= htmlspecialchars($comment['comment_id']) ?></td>
                            <td class="align-middle">
                                <a href="<?= _WEB_ROOT . '/blog/detail/' . htmlspecialchars($comment['blog_id']) ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($comment['blog_title']) ?>
                                </a>
                            </td>
                            <td class="comment-content align-middle">
                                <div class="comment-text text-truncate" style="max-width: 300px;">
                                    <?= htmlspecialchars($comment['comment_content']) ?>
                                </div>
                                <?php if (!empty($comment['file_url'])) : ?>
                                    <div class="comment-attachment">
                                        <i class="fas fa-paperclip me-1"></i>
                                        <a href="<?= htmlspecialchars($comment['file_url']) ?>" target="_blank" class="attachment-link">
                                            <?= htmlspecialchars($comment['file_name']) ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <?php if (!empty($comment['avatar_url'])) : ?>
                                        <img src="<?= htmlspecialchars($comment['avatar_url']) ?>" alt="<?= htmlspecialchars($comment['username']) ?>" class="user-avatar me-2">
                                    <?php else : ?>
                                        <div class="default-avatar me-2"><i class="fas fa-user"></i></div>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($comment['username']) ?></span>
                                </div>
                            </td>
                            <td class="align-middle text-center"><?= date('M d, Y', strtotime($comment['comment_created_at'])) ?></td>
                            <td class="text-center align-middle">
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-info view-btn" data-id="<?= htmlspecialchars($comment['comment_id']) ?>" data-bs-toggle="modal" data-bs-target="#viewCommentModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger delete-btn" data-id="<?= htmlspecialchars($comment['comment_id']) ?>" data-bs-toggle="modal" data-bs-target="#deleteCommentModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-comments fa-3x mb-3"></i>
                                <h5>No Comments Yet</h5>
                                <p class="text-muted">There are no comments on any blog posts yet.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <p id="noResultsMessage" class="text-center text-muted py-5 d-none">
            <i class="fas fa-search me-2"></i>No matching comments found
        </p>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center mt-4" id="pagination">
            <!-- JS will populate this -->
        </ul>
    </nav>
</div>

<!-- View Comment Modal -->
<div class="modal fade" id="viewCommentModal" tabindex="-1" aria-labelledby="viewCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCommentModalLabel">Comment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Blog Post:</label>
                    <p id="commentBlogTitle"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Author:</label>
                    <p id="commentAuthor"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Date:</label>
                    <p id="commentDate"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Comment:</label>
                    <div id="commentContent" class="p-3 bg-light rounded"></div>
                </div>
                <div id="commentAttachment" class="mb-3 d-none">
                    <label class="form-label fw-bold">Attachment:</label>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-paperclip me-2"></i>
                        <a href="#" id="attachmentLink" target="_blank"></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Comment Modal -->
<div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteCommentForm" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCommentModalLabel">Delete Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span>This action cannot be undone. Are you sure you want to delete this comment?</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    <?php
    RenderSystem::renderOne('assets', 'static/js/pages/posts/commentManager.js');
    ?>
</script> 