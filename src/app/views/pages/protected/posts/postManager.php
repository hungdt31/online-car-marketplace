<style>
    <?php
    RenderSystem::renderOne('assets', 'static/css/posts/postManager.css');
    ?>
</style>

<div class="container-fluid px-4 py-5">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h4 class="mb-0">Blog Management Dashboard</h4>
        <p class="text-white-50 mb-2 mt-2">Manage your blog posts and content</p>
    </div>

    <!-- Control Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Search Bar -->
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="Search posts...">
        </div>

        <!-- Add New Post Button -->
        <button type="button" data-bs-toggle="modal" data-bs-target="#addPostModal" class="btn btn-add">
            <i class="fas fa-plus-circle me-2"></i>Add New Post
        </button>
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
                    <th class="py-3 sortable" data-sort="title">
                        Title
                        <i class="fas fa-sort ms-1"></i>
                    </th>
                    <th class="py-3 sortable text-center" data-sort="author">
                        Author
                        <i class="fas fa-sort ms-1"></i>
                    </th>
                    <th class="py-3 sortable text-center" data-sort="views">
                        Views
                        <i class="fas fa-sort ms-1"></i>
                    </th>
                    <th class="py-3 sortable text-center" data-sort="created_at">
                        Published Date
                        <i class="fas fa-sort ms-1"></i>
                    </th>
                    <th class="text-center py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="blogTableBody">
                <?php if (!empty($list_posts)) : ?>
                    <?php foreach ($list_posts as $post) : ?>
                        <tr class="post-row">
                            <td class="align-middle"><?= htmlspecialchars($post['id']) ?></td>
                            <td class="post-title align-middle">
                                <div class="d-flex align-items-center">
                                    <?php if (!empty($post['cover_image_url'])) : ?>
                                        <div class="post-thumbnail me-2">
                                            <img src="<?= htmlspecialchars($post['cover_image_url']) ?>"
                                                alt="<?= htmlspecialchars($post['title']) ?>"
                                                class="img-thumbnail post-cover-image">
                                        </div>
                                    <?php else : ?>
                                        <div class="post-thumbnail me-2">
                                            <div class="no-image"><i class="fas fa-image"></i></div>
                                        </div>
                                    <?php endif; ?>
                                    <span class="text-truncate"><?= htmlspecialchars($post['title']) ?></span>
                                </div>
                            </td>
                            <td class="align-middle text-center"><?= htmlspecialchars($post['author_name'] ?? 'Unknown') ?></td>
                            <td class="align-middle text-center"><?= htmlspecialchars($post['views']) ?></td>
                            <td class="align-middle text-center"><?= date('M d, Y', strtotime($post['created_at'])) ?></td>
                            <td class="text-center align-middle">
                                <div class="action-buttons">
                                    <!-- <button type="button" class="btn btn-info details-btn" data-id="<?= htmlspecialchars($post['id']) ?>" data-bs-toggle="modal" data-bs-target="#postDetailModal">
                                        <i class="fas fa-eye"></i>
                                    </button> -->
                                    <!-- data-id="<?= htmlspecialchars($post['id']) ?>" data-bs-toggle="modal" data-bs-target="#updatePostModal" -->
                                    <a href="<?= _WEB_ROOT . '/blogs-management/details/' . htmlspecialchars($post['id']) ?>">
                                        <button type="button" class="btn btn-primary edit-btn">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-danger delete-btn" data-id="<?= htmlspecialchars($post['id']) ?>" data-bs-toggle="modal" data-bs-target="#deletePostModal">
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
                                <i class="fas fa-newspaper fa-3x mb-3"></i>
                                <h5>No Blog Posts Yet</h5>
                                <p class="text-muted">Start creating your blog content by adding a new post.</p>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addPostModal" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Add First Post
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <p id="noResultsMessage" class="text-center text-muted py-5 d-none">
            <i class="fas fa-search me-2"></i>No matching posts found
        </p>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center mt-4" id="pagination">
            <!-- JS will populate this -->
        </ul>
    </nav>
</div>

<!-- Modal Add New Post -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="addPostForm" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPostModalLabel">Create New Blog Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter post title" required>
                    </div>

                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Cover Image</label>
                        <input type="file" class="form-control" id="cover_image" name="cover_image">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="8" placeholder="Write your post content here"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Post Modal -->
<div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deletePostForm" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePostModalLabel">Delete Blog Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span>This action cannot be undone. Are you sure you want to delete this blog post?</span>
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
    RenderSystem::renderOne('assets', 'static/js/pages/posts/postManager.js');
    ?>
</script>