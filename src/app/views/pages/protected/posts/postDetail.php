<?php
// Debug info removed - for production
// Array structure for reference:
// $post contains: id, title, content, views, created_at, updated_at, author_name, author_id, author_bio, cover_image_url, categories
?>

<div class="container py-4">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-3 rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="/dashboard" class="text-decoration-none">
                    <i class="fas fa-home me-1"></i>Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="/blogs-management" class="text-decoration-none">
                    <i class="fas fa-newspaper me-1"></i>Blogs
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= strlen($post['title']) > 40 ? substr(htmlspecialchars($post['title']), 0, 40) . '...' : htmlspecialchars($post['title']) ?>
            </li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h1 class="card-title mb-0">Blog Details</h1>

                <div class="post-actions d-flex">
                    <button id="editBtn" class="btn btn-primary btn-sm px-3">
                        <i class="fas fa-edit me-2"></i>Edit
                    </button>
                    <button id="cancelBtn" class="btn btn-outline-secondary btn-sm px-3 ms-2" style="display:none;">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button id="saveBtn" class="btn btn-success btn-sm px-3 ms-2" style="display:none;" data-cover-image-id="<?= htmlspecialchars($post['cover_image_id']) ?>">
                        <i class="fas fa-save me-2"></i>Save
                    </button>
                </div>
            </div>

            <!-- Enhanced Post Information -->
            <div class="post-metadata mt-4 p-4 bg-white rounded shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>General Information</h5>
                    <span class="badge bg-light text-dark border">ID: <?= htmlspecialchars($post['id']) ?></span>
                </div>

                <hr class="my-3">

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-light p-3 me-3 text-primary">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Views</div>
                                <div class="fw-bold"><?= number_format($post['views']) ?></div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-light p-3 me-3 text-success">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Author</div>
                                <div class="fw-bold"><?= htmlspecialchars($post['author_name']) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-light p-3 me-3 text-warning">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Created</div>
                                <div class="fw-bold"><?= date('F d, Y', strtotime($post['created_at'])) ?></div>
                                <div class="text-muted small"><?= date('g:i A', strtotime($post['created_at'])) ?></div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-light p-3 me-3 text-info">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Updated</div>
                                <div class="fw-bold"><?= date('F d, Y', strtotime($post['updated_at'])) ?></div>
                                <div class="text-muted small"><?= date('g:i A', strtotime($post['updated_at'])) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form id="postForm">
                <input type="hidden" id="postId" value="<?= htmlspecialchars($post['id']) ?>">

                <div class="d-flex gap-3 align-items-center mb-4">
                    <div class="flex-grow-1">
                        <label for="title" class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control" id="title" value="<?= htmlspecialchars($post['title']) ?>" disabled>
                    </div>

                    <div>
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select" id="status" disabled>
                            <option value="draft" <?= $post['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="pending" <?= $post['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="published" <?= $post['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                            <option value="scheduled" <?= $post['status'] === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                            <option value="archived" <?= $post['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
                            <option value="deleted" <?= $post['status'] === 'deleted' ? 'selected' : '' ?>>Deleted</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="content" class="form-label fw-bold">Content</label>
                    <div class="content-container">
                        <div class="editor-container" data-default="<?= htmlspecialchars($post['content']) ?>" style="display:none;"></div>
                        <div class="content-view border rounded p-3 bg-light" id="contentView"><?= $post['content'] ?></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="coverImage" class="form-label fw-bold">Cover Image</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="coverImage" value="<?= htmlspecialchars($post['cover_image_url']) ?>" disabled>
                        <button class="btn btn-outline-secondary" type="button" id="uploadBtn" disabled><i class="fas fa-upload me-1"></i>Upload</button>
                    </div>
                    <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                </div>

                <div class="mb-4">
                    <!-- <label class="form-label fw-bold">Cover Image Preview</label> -->
                    <div class="image-preview-container">
                        <img id="imagePreview" src="<?= htmlspecialchars($post['cover_image_url']) ?>" class="img-thumbnail" style="max-height: 300px;">
                    </div>
                </div>

                <!-- Enhanced Categories Section -->
                <div class="card mb-4 mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-tags me-1"></i>
                            Categories
                        </div>
                        <div class="badge bg-light text-dark category-counter">
                            <span id="selectedCategoriesCount"><?= !empty($post['categories']) ? count($post['categories']) : '0' ?></span> selected
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <form id="carCategoriesForm">
                                <input type="hidden" name="blog_id" value="<?php echo $post['id']; ?>">
                                <!-- Search Box -->
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" id="categorySearch" placeholder="Search categories...">
                                    </div>
                                </div>

                                <!-- Type Filter -->
                                <div class="col-md-4">
                                    <select class="form-select" id="categoryTypeFilter">
                                        <option value="">All Types</option>
                                        <?php
                                        $types = ['Color', 'Style', 'Feature', 'Performance', 'Safety', 'Comfort', 'Technology', 'Material', 'Size', 'Fuel'];
                                        foreach ($types as $type):
                                        ?>
                                            <option value="<?= strtolower($type) ?>"><?= $type ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <!-- Categories List -->
                        <div class="d-flex flex-wrap gap-2 mb-3" id="categoryList">
                            <?php
                            $cate_ids = array_column($blog_categories, 'id');
                            foreach ($categories as $category) {
                                $isChecked = in_array($category['id'], $cate_ids) ? 'primary' : 'secondary';
                                echo '<button type="button" class="btn btn-outline-' . $isChecked . ' category-item" data-id="' . $category['id'] . '" data-type="' . strtolower($category['type']) . '" data-name="' . strtolower($category['name']) . '">';
                                echo htmlspecialchars($category['name']);
                                echo '<input type="checkbox" name="categories[]" value="' . $category['id'] . '" ' . ($isChecked == 'primary' ? 'checked' : '') . ' class="d-none">';
                                echo '</button>';
                            }
                            // Display all categories with appropriate selection state
                            ?>
                        </div>

                        <!-- No results message -->
                        <div id="noResults" class="text-center py-4 d-none">
                            <p class="text-muted">No categories match your search</p>
                        </div>
                    </div>
                </div>

            </form>

        </div> <!-- card-body -->
    </div> <!-- card -->
</div> <!-- container -->

<style>
    <?php
    RenderSystem::renderOne("assets", "static/css/posts/postDetail.css");
    ?>
</style>

<script type="module">
    <?php
    // Include the necessary JavaScript libraries for the editor
    RenderSystem::renderOne("assets", "static/js/helper/editor.js");
    ?>
    <?php
    RenderSystem::renderOne("assets", "static/js/pages/posts/postDetail.js");
    ?>
</script>