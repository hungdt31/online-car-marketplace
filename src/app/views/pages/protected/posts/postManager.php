<style>
    <?php
    RenderSystem::renderOne('assets', 'static/css/postManager.css');
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
                                    <button type="button" class="btn btn-info details-btn" data-id="<?= htmlspecialchars($post['id']) ?>" data-bs-toggle="modal" data-bs-target="#postDetailModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select a category</option>
                                <?php if (!empty($categories)) : ?>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Cover Image</label>
                        <input type="file" class="form-control" id="cover_image" name="cover_image">
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label">Summary</label>
                        <textarea class="form-control" id="summary" name="summary" rows="2" placeholder="Enter post summary"></textarea>
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

<!-- Modal Post Details -->
<div class="modal fade" id="postDetailModal" tabindex="-1" aria-labelledby="postDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="postDetail">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

<!-- Modal Update Post -->
<div class="modal fade" id="updatePostModal" tabindex="-1" aria-labelledby="updatePostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="updatePostForm" method="post">
            <div class="modal-content" id="updatePost">
                <!-- Content will be loaded dynamically -->
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
    $(document).ready(function() {
        // Add post functionality
        $("#addPostForm").submit(function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: "/admin/posts/add",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message || "Failed to create post");
                    }
                },
                error: function() {
                    toastr.error("Failed to add post. Please try again.");
                },
            });
        });

        // View post details
        $(".details-btn").click(function() {
            const postId = $(this).data("id");
            $.ajax({
                url: "/admin/posts/getPost/" + postId,
                type: "GET",
                dataType: "html",
                success: function(response) {
                    $('#postDetail').html(response);
                },
                error: function() {
                    toastr.error("Failed to get post details.");
                }
            });
        });

        // Edit post
        // $(".edit-btn").click(function() {
        //     const postId = $(this).data("id");
        //     $.ajax({
        //         url: "/admin/posts/getPost/" + postId,
        //         type: "GET",
        //         data: {
        //             'getToUpdate': true
        //         },
        //         dataType: "html",
        //         success: function(response) {
        //             $('#updatePost').html(response);
        //             // Initialize rich text editor if needed
        //             if (typeof initEditor === 'function') {
        //                 initEditor('#updatePostForm #content');
        //             }
        //         },
        //         error: function() {
        //             toastr.error("Failed to get post details.");
        //         }
        //     });
        // });

        // Set post ID for deletion
        $(".delete-btn").click(function() {
            const postId = $(this).data("id");
            const deleteButton = document.getElementById("deletePostForm").querySelector("button[type='submit']");
            deleteButton.setAttribute("data-id", postId);
        });
    });

    // Handle update post form submission
    document.getElementById("updatePostForm").addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector("button[type='submit']");
        const postId = submitButton.getAttribute("data-id");

        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...';

        $.ajax({
            url: `/admin/posts/edit/${postId}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message || "Failed to update post");
                }
            },
            error: function() {
                toastr.error("Failed to update post. Please try again.");
            },
            complete: function() {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = 'Save Changes';
            }
        });
    });

    // Handle delete post form submission
    document.getElementById("deletePostForm").addEventListener("submit", function(event) {
        event.preventDefault();

        const submitButton = this.querySelector("button[type='submit']");
        const postId = submitButton.getAttribute("data-id");

        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Deleting...';

        $.ajax({
            url: `/admin/posts/delete/${postId}`,
            type: "POST",
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message || "Failed to delete post");
                }
            },
            error: function() {
                toastr.error("Failed to delete post. Please try again.");
            },
            complete: function() {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = 'Delete';
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Variables for pagination and sorting
        const rowsPerPage = 5; // Number of items per page
        const rows = document.querySelectorAll(".post-row");
        const searchInput = document.getElementById("searchInput");
        const pagination = document.getElementById("pagination");
        const noResultsMessage = document.getElementById("noResultsMessage");
        let currentPage = 1;
        let sortState = {
            column: null,
            direction: 'asc'
        };

        // Declare all functions first
        function updatePagination(totalPages) {
            pagination.innerHTML = "";

            // Add Previous button
            if (totalPages > 1) {
                let prevLi = document.createElement("li");
                prevLi.classList.add("page-item");
                if (currentPage === 1) prevLi.classList.add("disabled");
                prevLi.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
                prevLi.addEventListener("click", function(e) {
                    e.preventDefault();
                    if (currentPage > 1) {
                        currentPage--;
                        updateTable();
                    }
                });
                pagination.appendChild(prevLi);
            }

            // Add page numbers
            for (let i = 1; i <= totalPages; i++) {
                let li = document.createElement("li");
                li.classList.add("page-item");
                if (i === currentPage) li.classList.add("active");
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener("click", function(e) {
                    e.preventDefault();
                    currentPage = i;
                    updateTable();
                });
                pagination.appendChild(li);
            }

            // Add Next button
            if (totalPages > 1) {
                let nextLi = document.createElement("li");
                nextLi.classList.add("page-item");
                if (currentPage === totalPages) nextLi.classList.add("disabled");
                nextLi.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
                nextLi.addEventListener("click", function(e) {
                    e.preventDefault();
                    if (currentPage < totalPages) {
                        currentPage++;
                        updateTable();
                    }
                });
                pagination.appendChild(nextLi);
            }
        }

        function getCellValue(row, column) {
            const mapping = {
                'id': 0,
                'title': 1,
                'author': 2,
                'views': 3,
                'created_at': 4
            };

            const cell = row.cells[mapping[column]];
            return cell ? cell.textContent.trim() : '';
        }

        function sortTable(column) {
            const table = document.getElementById('blogTableBody');
            if (!table) return;

            const rows = Array.from(table.getElementsByTagName('tr'));
            const headers = document.querySelectorAll('th.sortable');

            // Reset all headers
            headers.forEach(header => {
                header.classList.remove('asc', 'desc');
                header.querySelector('i').className = 'fas fa-sort ms-1';
            });

            // Update sort state
            if (sortState.column === column) {
                sortState.direction = sortState.direction === 'asc' ? 'desc' : 'asc';
            } else {
                sortState.column = column;
                sortState.direction = 'asc';
            }

            // Update header appearance
            const currentHeader = document.querySelector(`th[data-sort="${column}"]`);
            if (currentHeader) {
                currentHeader.classList.add(sortState.direction);
                currentHeader.querySelector('i').className = `fas fa-sort-${sortState.direction === 'asc' ? 'up' : 'down'} ms-1`;
            }

            // Sort the rows
            rows.sort((a, b) => {
                let aValue = getCellValue(a, column);
                let bValue = getCellValue(b, column);

                // Handle numeric sorting
                if (column === 'id' || column === 'views') {
                    return sortState.direction === 'asc' ?
                        parseInt(aValue) - parseInt(bValue) :
                        parseInt(bValue) - parseInt(aValue);
                }

                // Handle date sorting
                if (column === 'created_at') {
                    const dateA = new Date(aValue);
                    const dateB = new Date(bValue);
                    return sortState.direction === 'asc' ? 
                        dateA - dateB : 
                        dateB - dateA;
                }

                // String comparison for other columns
                return sortState.direction === 'asc' ?
                    aValue.localeCompare(bValue) :
                    bValue.localeCompare(aValue);
            });

            // Reorder the table
            rows.forEach(row => table.appendChild(row));
        }

        // Define updateTable function
        function updateTable() {
            const filter = searchInput.value.toLowerCase();
            const filteredRows = Array.from(rows).filter(row =>
                row.querySelector(".post-title").textContent.toLowerCase().includes(filter)
            );

            // Show no results message if needed
            noResultsMessage.classList.toggle("d-none", filteredRows.length > 0);

            // Calculate pagination
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            if (currentPage > totalPages) {
                currentPage = totalPages || 1;
            }

            // Update display
            filteredRows.forEach((row, index) => {
                row.style.display = (index >= (currentPage - 1) * rowsPerPage &&
                    index < currentPage * rowsPerPage) ? "" : "none";
            });

            // Update pagination controls
            updatePagination(totalPages);

            // Apply sorting if a column is selected
            if (sortState.column) {
                sortTable(sortState.column);
            }
        }

        // Add click event listeners to sortable headers
        document.querySelectorAll('th.sortable').forEach(header => {
            header.addEventListener('click', () => {
                const column = header.getAttribute('data-sort');
                if (column) {
                    sortTable(column);
                    // Re-apply pagination after sorting
                    updateTable();
                }
            });

            // Add hover effect for sort indicators
            header.addEventListener('mouseover', () => {
                if (!header.classList.contains('asc') && !header.classList.contains('desc')) {
                    const icon = header.querySelector('i');
                    if (icon) icon.style.opacity = '0.5';
                }
            });

            header.addEventListener('mouseout', () => {
                if (!header.classList.contains('asc') && !header.classList.contains('desc')) {
                    const icon = header.querySelector('i');
                    if (icon) icon.style.opacity = '0.2';
                }
            });
        });

        // Search functionality
        searchInput.addEventListener("keyup", function() {
            currentPage = 1; // Reset to first page on search
            updateTable();
        });

        // Initialize rich text editors if needed
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#content',
                height: 300,
                plugins: 'link image code table lists',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code'
            });
        }

        // Initial table setup
        updateTable();
    });
</script>