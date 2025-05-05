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
                    <button id="saveBtn" class="btn btn-success btn-sm px-3 ms-2" style="display:none;">
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

                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control" id="title" value="<?= htmlspecialchars($post['title']) ?>" disabled>
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
                    <label class="form-label fw-bold">Cover Image Preview</label>
                    <div class="image-preview-container">
                        <img id="imagePreview" src="<?= htmlspecialchars($post['cover_image_url']) ?>" class="img-thumbnail" style="max-height: 300px;">
                    </div>
                </div>

                <!-- Display categories -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Categories</label>
                    <div id="categoriesContainer" class="d-flex flex-wrap gap-1">
                        <?php if (!empty($post['categories'])): ?>
                            <?php foreach ($post['categories'] as $category): ?>
                                <span class="badge bg-primary"><?= htmlspecialchars($category['name']) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="badge bg-secondary">Uncategorized</span>
                        <?php endif; ?>
                    </div>
                </div>

            </form>

        </div> <!-- card-body -->
    </div> <!-- card -->
</div> <!-- container -->

<style>
    /* Enhanced styling for post detail page */
    .content-view {
        min-height: 200px;
        max-height: 500px;
        overflow-y: auto;
    }

    .content-view img {
        max-width: 100%;
        height: auto;
    }

    .image-preview-container {
        display: flex;
        justify-content: center;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 10px;
        border-radius: 4px;
    }

    .image-preview-container img {
        object-fit: contain;
        max-width: 100%;
    }

    .post-metadata {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
    }

    .editor-container .tiptap {
        min-height: 300px;
        max-height: 500px;
        overflow-y: auto;
        padding: 1rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .editor-menubar {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        padding: 8px;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-bottom: none;
        border-radius: 0.25rem 0.25rem 0 0;
    }

    .editor-menubar button {
        padding: 4px 8px;
        background: #fff;
        border: 1px solid #ced4da;
        border-radius: 3px;
        cursor: pointer;
    }

    .editor-menubar button.is-active {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }
</style>

<script type="module">
    <?php
    // Include the necessary JavaScript libraries for the editor
    RenderSystem::renderOne("assets", "static/js/helper/editor.js");
    ?>
    document.addEventListener("DOMContentLoaded", function() {
        const editBtn = document.getElementById("editBtn");
        const cancelBtn = document.getElementById("cancelBtn");
        const saveBtn = document.getElementById("saveBtn");
        const form = document.getElementById("postForm");
        const inputs = form.querySelectorAll("input:not([type=hidden]):not([type=file])");
        const coverImageInput = document.getElementById("coverImage");
        const imagePreview = document.getElementById("imagePreview");
        const uploadBtn = document.getElementById("uploadBtn");
        const imageUpload = document.getElementById("imageUpload");
        const contentView = document.getElementById("contentView");
        const editorContainer = document.querySelector(".editor-container");

        // Store original values
        const originalValues = {};
        inputs.forEach(input => {
            originalValues[input.id] = input.value;
        });

        // Original image source
        const originalImageSrc = imagePreview.src;
        let originalContent = contentView.innerHTML;
        let editor = null;

        // Handle file upload button
        uploadBtn.addEventListener("click", function() {
            imageUpload.click();
        });

        // Handle file selection
        imageUpload.addEventListener("change", function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Preview the image
                    imagePreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });

        // Update image preview when cover image URL changes
        coverImageInput.addEventListener("input", function() {
            if (this.value.trim() !== "") {
                imagePreview.src = this.value;
            }
        });

        // Edit button functionality
        editBtn.addEventListener("click", async function() {
            // Show spinner while loading editor
            editBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
            editBtn.disabled = true;

            // Enable form inputs
            inputs.forEach(input => {
                input.disabled = false;
            });

            uploadBtn.disabled = false;

            // Show editor, hide content view
            contentView.style.display = "none";
            editorContainer.style.display = "block";

            // Update button states
            editBtn.style.display = "none";
            cancelBtn.style.display = "inline-block";
            saveBtn.style.display = "inline-block";

            // Reset edit button state (in case user cancels and tries again)
            editBtn.innerHTML = '<i class="fas fa-edit me-2"></i>Edit';
            editBtn.disabled = false;
        });

        // Cancel button functionality
        cancelBtn.addEventListener("click", function() {
            const editorContent = document.querySelector(".editor-container .tiptap");
            // Reset to original values
            inputs.forEach(input => {
                input.value = originalValues[input.id];
                input.disabled = true;
            });

            // Reset image
            imagePreview.src = originalImageSrc;
            uploadBtn.disabled = true;
            imageUpload.value = "";

            // Hide editor, restore content view
            editorContainer.style.display = "none";
            contentView.style.display = "block";
            contentView.innerHTML = originalContent;

            if (editorContent) {
                editorContent.innerHTML = originalContent;
            }

            // Cleanup editor if it exists
            if (editor && typeof editor.destroy === 'function') {
                editor.destroy();
                editor = null;
            }

            // Update button states
            editBtn.style.display = "inline-block";
            cancelBtn.style.display = "none";
            saveBtn.style.display = "none";

            // Show toast notification
            showToast('Changes discarded', 'info');
        });

        // Save button functionality
        saveBtn.addEventListener("click", function() {
            // Collect form data
            const postId = document.getElementById("postId").value;
            const title = document.getElementById("title").value;

            // Get content from editor or fallback
            let content;
            if (document.getElementById("editorContent")) {
                content = document.getElementById("editorContent").value;
            } else if (document.getElementById("fallbackEditor")) {
                content = document.getElementById("fallbackEditor").value;
            } else {
                content = contentView.innerHTML;
            }

            // Create form data object for file upload
            const formData = new FormData();
            formData.append("id", postId);
            formData.append("title", title);
            formData.append("content", content);

            // If a file was selected, add it to the form data
            if (imageUpload.files && imageUpload.files[0]) {
                formData.append("cover_image", imageUpload.files[0]);
            } else {
                // Otherwise use the URL
                formData.append("cover_image_url", coverImageInput.value);
            }

            // Show loading state
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';
            saveBtn.disabled = true;

            // Send AJAX request
            fetch("/api/posts/" + postId, {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then(data => {
                    // Show success toast
                    showToast('Post updated successfully!', 'success');

                    // Update original content
                    originalContent = content;
                    contentView.innerHTML = content;

                    // Update original image source
                    originalImageSrc = imagePreview.src;

                    // If there was a new URL set in the response, update the input
                    if (data.cover_image_url) {
                        coverImageInput.value = data.cover_image_url;
                        originalValues[coverImageInput.id] = data.cover_image_url;
                    }

                    // Disable form inputs
                    inputs.forEach(input => {
                        input.disabled = true;
                        originalValues[input.id] = input.value; // Update original values
                    });

                    // Hide editor, show content view
                    editorContainer.style.display = "none";
                    contentView.style.display = "block";

                    // Cleanup editor if it exists
                    if (editor && typeof editor.destroy === 'function') {
                        editor.destroy();
                        editor = null;
                    }

                    uploadBtn.disabled = true;
                    imageUpload.value = "";

                    // Update button states
                    editBtn.style.display = "inline-block";
                    cancelBtn.style.display = "none";
                    saveBtn.style.display = "none";
                    saveBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save';
                    saveBtn.disabled = false;
                })
                .catch(error => {
                    console.error("Error updating post:", error);

                    // Show error toast
                    showToast('Failed to update post. Please try again.', 'error');

                    // Reset button state
                    saveBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save';
                    saveBtn.disabled = false;
                });
        });

        // Helper function to show toast messages
        function showToast(message, type = 'success') {
            // Create toast container if it doesn't exist
            let toastContainer = document.querySelector(".toast-container");
            if (!toastContainer) {
                toastContainer = document.createElement("div");
                toastContainer.className = "toast-container position-fixed bottom-0 end-0 p-3";
                toastContainer.style.zIndex = "5";
                document.body.appendChild(toastContainer);
            }

            // Set toast color based on type
            let bgClass = 'bg-success';
            let icon = 'fa-check-circle';

            if (type === 'error') {
                bgClass = 'bg-danger';
                icon = 'fa-exclamation-circle';
            } else if (type === 'info') {
                bgClass = 'bg-info';
                icon = 'fa-info-circle';
            }

            // Create toast HTML
            const toastHtml = `
            <div class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${icon} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

            // Add toast to container
            toastContainer.insertAdjacentHTML("beforeend", toastHtml);

            // Initialize and show the toast
            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 3000
            });
            toast.show();

            // Remove toast after it's hidden
            toastElement.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        }
    });
</script>