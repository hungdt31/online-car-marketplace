<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article>
                <!-- Featured Image -->
                <div class="mb-4 position-relative">
                    <img src="<?php echo !empty($blog['cover_image_url']) ? htmlspecialchars($blog['cover_image_url']) : 'https://via.placeholder.com/800x400?text=No+Image'; ?>"
                        class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($blog['title']); ?>"
                        style="width: 100%; height: 400px; object-fit: cover;">

                    <?php if (!empty($blog['categories'])): ?>
                        <div class="position-absolute top-0 start-0 m-3">
                            <?php foreach ($blog['categories'] as $category): ?>
                                <a href="<?php echo _WEB_ROOT; ?>/blog/category/<?php echo $category['id']; ?>"
                                    class="badge bg-primary text-decoration-none me-1">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Title and Meta -->
                <h1 class="mb-3"><?php echo htmlspecialchars($blog['title']); ?></h1>
                <div class="d-flex flex-wrap mb-4 text-muted">
                    <div class="me-4">
                        <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($blog['author_name']); ?>
                    </div>
                    <div class="me-4">
                        <i class="fas fa-calendar-alt me-1"></i> <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                    </div>
                    <div>
                        <i class="fas fa-eye me-1"></i> <?php echo $blog['views']; ?> views
                    </div>
                </div>

                <!-- Content -->
                <div class="blog-content mb-5">
                    <?php echo $blog['content']; ?>
                </div>

                <!-- Share -->
                <div class="d-flex align-items-center mb-5">
                    <span class="me-3 fw-bold">Share:</span>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-info"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-danger"><i class="fab fa-pinterest"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-success"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Author Box -->
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="https://ui.shadcn.com/avatars/01.png" alt="Author" class="rounded-circle me-4" width="80" height="80">
                            <div>
                                <h5 class="mb-1"><?php echo htmlspecialchars($blog['author_name']); ?></h5>
                                <p class="text-muted mb-3">Author</p>
                                <p class="mb-0"><?php echo $blog['author_bio'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Search -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Search</h5>
                        <?php if (isset($hasRecentKeywords) && $hasRecentKeywords): ?>
                            <a href="<?php echo _WEB_ROOT; ?>/blog/clearSearchHistory" class="btn btn-sm btn-outline-secondary" id="clearSearchHistoryBtn">
                                <i class="fas fa-history"></i> Clear History
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <form action="<?php echo _WEB_ROOT; ?>/blog/search" method="GET" class="position-relative">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" id="searchKeyword" placeholder="Enter keyword">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        
                        <?php if (isset($hasRecentKeywords) && $hasRecentKeywords): ?>
                            <div class="recent-keywords mt-2">
                                <small class="text-muted d-block mb-1">Recent searches:</small>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php foreach ($recentKeywords as $recentKeyword): ?>
                                        <a href="<?php echo _WEB_ROOT; ?>/blog/search?keyword=<?php echo urlencode($recentKeyword); ?>" 
                                           class="badge bg-light text-dark search-keyword-badge">
                                            <?php echo htmlspecialchars($recentKeyword); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Categories -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Categories</h5>
                        <?php if (!empty($selectedCategories)): ?>
                            <a href="<?php echo _WEB_ROOT; ?>/blog/clearCategories" id="clearCategoriesBtn">
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-times-circle"></i> Clear Filters
                                </button>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (!empty($selectedCategories)): ?>
                        <div class="mb-3">
                            <small class="text-muted mb-3">Showing posts with ALL of these categories:</small>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                <?php foreach ($categories as $category): ?>
                                    <?php if (in_array($category['id'], $selectedCategories)): ?>
                                        <a href="<?php echo _WEB_ROOT; ?>/blog/toggleCategory/<?php echo $category['id']; ?>" 
                                           class="badge bg-primary text-white category-filter-badge"
                                           data-category-id="<?php echo $category['id']; ?>">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                            <i class="fas fa-times ms-1"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="list-group list-group-flush">
                        <?php foreach ($categories as $category): ?>
                            <a href="<?php echo _WEB_ROOT; ?>/blog/toggleCategory/<?php echo $category['id']; ?>"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-item <?php echo in_array($category['id'], $selectedCategories ?? []) ? 'text-white bg-primary' : ''; ?>"
                                data-category-id="<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                                <span class="badge <?php echo in_array($category['id'], $selectedCategories ?? []) ? 'bg-white text-primary' : 'bg-primary'; ?> rounded-pill">
                                    <?php echo $category['post_count']; ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <?php if (isset($hasRecentlyViewed) && $hasRecentlyViewed): ?>
                            Recently Viewed Posts
                        <?php else: ?>
                            Recent Posts
                        <?php endif; ?>
                    </h5>
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="d-flex mb-3 mt-3">
                            <img src="<?php echo !empty($post['cover_image_url']) ? htmlspecialchars($post['cover_image_url']) : 'https://via.placeholder.com/100?text=No+Image'; ?>"
                                class="flex-shrink-0 me-3" alt="<?php echo htmlspecialchars($post['title']); ?>"
                                style="width: 70px; height: 70px; object-fit: cover;">
                            <div>
                                <h6 class="mb-1">
                                    <a href="<?php echo _WEB_ROOT; ?>/blog/detail/<?php echo $post['id']; ?>" class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .blog-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .blog-content p {
        margin-bottom: 1.5rem;
    }

    .blog-content img {
        max-width: 100%;
        height: auto;
        margin: 2rem 0;
    }

    .blog-content h2,
    .blog-content h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .blog-content ul,
    .blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }

    .blog-content blockquote {
        border-left: 4px solid #0d6efd;
        padding-left: 1rem;
        font-style: italic;
        margin: 1.5rem 0;
    }

    /* Category Filters Styling */
    .category-item {
        transition: all 0.2s ease-in-out;
        border-radius: 6px;
        margin-bottom: 5px;
    }

    .category-item:hover {
        background-color: #f8f9fa;
        transform: translateX(3px);
    }

    .category-item.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
        font-weight: 500;
    }

    .category-filter-badge {
        padding: 6px 10px;
        font-weight: normal;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .category-filter-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 5px rgba(0,0,0,0.1);
    }

    .category-filter-badge .fas {
        opacity: 0.7;
    }

    #clearCategoriesBtn {
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    #clearCategoriesBtn:hover {
        background-color: #dc3545;
        color: white;
    }

    /* Search Keyword Styling */
    .search-keyword-badge {
        padding: 5px 10px;
        font-weight: normal;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid #e5e5e5;
    }

    .search-keyword-badge:hover {
        background-color: #f1f1f1;
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .recent-keywords {
        max-width: 100%;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    #clearSearchHistoryBtn {
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    #clearSearchHistoryBtn:hover {
        background-color: #e9ecef;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category filter handling
    function initCategoryFilters() {
        // Add click handlers for category filters using AJAX
        const categoryItems = document.querySelectorAll('.category-item, .category-filter-badge');
        const clearCategoriesBtn = document.getElementById('clearCategoriesBtn');
        
        console.log('Initializing category filters on detail page');
        console.log('Found ' + categoryItems.length + ' category items');
        
        // Log the web root for debugging
        console.log('Web root: ' + '<?php echo _WEB_ROOT; ?>');
        
        // Function to reload the page content after filter change
        function reloadPage() {
            window.location.href = "<?php echo _WEB_ROOT; ?>/blog";
        }
        
        // Add click handler for category items
        categoryItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const categoryId = this.getAttribute('data-category-id');
                console.log('Category clicked: ' + categoryId);
                
                // Toggle active state visually
                this.classList.toggle('active');
                
                // Use regular navigation instead of AJAX
                window.location.href = '<?php echo _WEB_ROOT; ?>/blog/toggleCategory/' + categoryId;
            });
        });
        
        // Add click handler for clear categories button
        if (clearCategoriesBtn) {
            clearCategoriesBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Clear categories clicked');
                
                // Use regular navigation instead of AJAX
                window.location.href = '<?php echo _WEB_ROOT; ?>/blog/clearCategories';
            });
        }
    }
    
    // Initialize category filters
    initCategoryFilters();
    
    // Search history handling
    function initSearchHistory() {
        const clearSearchHistoryBtn = document.getElementById('clearSearchHistoryBtn');
        
        if (clearSearchHistoryBtn) {
            clearSearchHistoryBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Clear search history clicked');
                
                // Use regular navigation
                window.location.href = '<?php echo _WEB_ROOT; ?>/blog/clearSearchHistory';
            });
        }
        
        // Make search keywords clickable
        const searchKeywords = document.querySelectorAll('.search-keyword-badge');
        searchKeywords.forEach(keyword => {
            keyword.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                window.location.href = url;
            });
        });
    }
    
    // Initialize search history
    initSearchHistory();
});
</script>