<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <?php if (isset($currentCategory)): ?>
                <h1 class="mb-4"><?php echo htmlspecialchars($currentCategory['name']); ?> Articles</h1>
            <?php elseif (isset($keyword)): ?>
                <h1 class="mb-4">Search Results: <?php echo htmlspecialchars($keyword); ?></h1>
            <?php else: ?>
                <h1 class="mb-4">Latest Articles</h1>
            <?php endif; ?>

            <?php if (empty($blogs)): ?>
                <div class="alert alert-info">
                    No articles found.
                </div>
            <?php else: ?>
                <div class="row gy-4">
                    <?php foreach ($blogs as $blog): ?>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="<?php echo !empty($blog['cover_image_url']) ? htmlspecialchars($blog['cover_image_url']) : 'https://via.placeholder.com/400x200?text=No+Image'; ?>"
                                        class="card-img-top" alt="<?php echo htmlspecialchars($blog['title']); ?>"
                                        style="height: 200px; object-fit: cover;">

                                    <?php if (isset($blog['categories']) && !empty($blog['categories'])): ?>
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <?php foreach ($blog['categories'] as $category): ?>
                                                <span class="badge bg-primary me-1"><?php echo htmlspecialchars($category['name']); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <a href="<?php echo _WEB_ROOT; ?>/blog/detail/<?php echo $blog['id']; ?>" class="text-decoration-none text-dark">
                                            <?php echo htmlspecialchars($blog['title']); ?>
                                        </a>
                                    </h5>
                                    <div class="card-text mb-3 flex-grow-1">
                                        <?php
                                        $shortContent = strip_tags($blog['content']);
                                        echo strlen($shortContent) > 100 ? substr($shortContent, 0, 100) . '...' : $shortContent;
                                        ?>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($blog['author_name']); ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i> <?php echo $blog['views']; ?> views
                                        </small>
                                        <a href="<?php echo _WEB_ROOT; ?>/blog/detail/<?php echo $blog['id']; ?>">
                                            <button class="btn btn-sm btn-outline-primary">Read More</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Pagination -->
            <div class="pagination-container mt-5" id="blogPagination">
                <nav aria-label="Blog pagination">
                    <ul class="pagination pagination-modern justify-content-center" id="paginationList">
                        <!-- Phân trang sẽ được tạo bởi JavaScript -->
                    </ul>
                </nav>

                <div class="pagination-info text-center mt-2">
                    <small class="text-muted">
                        Showing page <span id="currentPage">1</span> of <span id="totalPages">1</span>
                    </small>
                </div>
            </div>
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
                            <input type="text" class="form-control" name="keyword" id="searchKeyword" placeholder="Enter keyword"
                                value="<?php echo isset($keyword) ? htmlspecialchars($keyword) : (isset($currentKeyword) ? htmlspecialchars($currentKeyword) : ''); ?>">
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
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-times-circle"></i> Clear Filters</button>
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

            <!-- Tags -->
            <!-- <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title">Tags</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/branded" class="btn btn-sm btn-outline-secondary">Branded</a>
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/luxury" class="btn btn-sm btn-outline-secondary">Luxury</a>
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/suv" class="btn btn-sm btn-outline-secondary">SUV's</a>
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/electric" class="btn btn-sm btn-outline-secondary">Electric</a>
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/sports" class="btn btn-sm btn-outline-secondary">Sports</a>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>

<!-- <div class="container mt-4 bg-light p-3 rounded">
    <h5>Debug Links</h5>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Category Filter Behavior:</strong> Posts must have <em>ALL</em> selected categories to appear in the list.</p>

            <p>Test category toggle links:</p>
            <?php foreach ($categories as $category): ?>
                <a href="<?php echo _WEB_ROOT; ?>/blog/toggleCategory/<?php echo $category['id']; ?>" class="btn btn-sm <?php echo in_array($category['id'], $selectedCategories ?? []) ? 'btn-primary' : 'btn-outline-primary'; ?> me-2 mb-2">
                    Toggle: <?php echo htmlspecialchars($category['name']); ?> (ID: <?php echo $category['id']; ?>)
                </a>
            <?php endforeach; ?>

            <a href="<?php echo _WEB_ROOT; ?>/blog/clearCategories" class="btn btn-sm btn-danger me-2">Clear All Categories</a>

            <hr>

            <p>Current selected categories (requiring ALL to match):</p>
            <?php if (!empty($selectedCategories)): ?>
                <ul>
                    <?php foreach ($selectedCategories as $catId): ?>
                        <li>
                            Category ID: <?php echo $catId; ?> -
                            <?php
                            $foundCategory = null;
                            foreach ($categories as $category) {
                                if ($category['id'] == $catId) {
                                    $foundCategory = $category;
                                    break;
                                }
                            }
                            echo $foundCategory ? htmlspecialchars($foundCategory['name']) : 'Unknown Category';
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p><em>No categories selected</em></p>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <p><strong>Search Keywords:</strong> Recent searches are stored in session.</p>

            <p>Current search keyword:</p>
            <?php if (isset($keyword) && !empty($keyword)): ?>
                <p><code><?php echo htmlspecialchars($keyword); ?></code></p>
            <?php elseif (isset($currentKeyword) && !empty($currentKeyword)): ?>
                <p><code><?php echo htmlspecialchars($currentKeyword); ?></code></p>
            <?php else: ?>
                <p><em>No current keyword</em></p>
            <?php endif; ?>

            <p>Recent search keywords:</p>
            <?php if (isset($recentKeywords) && !empty($recentKeywords)): ?>
                <ul>
                    <?php foreach ($recentKeywords as $index => $recentKeyword): ?>
                        <li>
                            <?php echo $index + 1; ?>. <code><?php echo htmlspecialchars($recentKeyword); ?></code>
                            <a href="<?php echo _WEB_ROOT; ?>/blog/search?keyword=<?php echo urlencode($recentKeyword); ?>" class="btn btn-sm btn-link py-0">Use</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?php echo _WEB_ROOT; ?>/blog/clearSearchHistory" class="btn btn-sm btn-outline-danger">Clear Search History</a>
            <?php else: ?>
                <p><em>No recent keywords</em></p>
            <?php endif; ?>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <p>Session Data (for debugging):</p>
            <pre><?php print_r($_SESSION); ?></pre>
        </div>
    </div>
</div> -->

<style>
    /* Modern Pagination Styling */
    .pagination-container {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .pagination-modern {
        --pagination-hover-bg: #f8f9fa;
        --pagination-active-bg: #0d6efd;
        --pagination-active-color: #fff;
        --pagination-border-radius: 50px;
        --pagination-size: 38px;
        --pagination-font-weight: 500;
    }

    .pagination-modern .page-item {
        margin: 0 3px;
    }

    .pagination-modern .page-link {
        width: var(--pagination-size);
        height: var(--pagination-size);
        border-radius: var(--pagination-border-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: var(--pagination-font-weight);
        color: #495057;
        border: none;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.25s ease-in-out;
    }

    .pagination-modern .page-link:hover {
        background-color: var(--pagination-hover-bg);
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        color: #0d6efd;
    }

    .pagination-modern .page-item.active .page-link {
        background-color: var(--pagination-active-bg);
        color: var(--pagination-active-color);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
        transform: translateY(-2px);
        font-weight: bold;
    }

    .pagination-modern .page-item.disabled .page-link {
        color: #adb5bd;
        background-color: #f8f9fa;
        pointer-events: none;
        box-shadow: none;
    }

    .pagination-modern .page-item.ellipsis .page-link {
        background-color: transparent;
        box-shadow: none;
    }

    .pagination-modern .page-item.ellipsis .page-link:hover {
        background-color: transparent;
        transform: none;
    }

    .pagination-info {
        color: #6c757d;
        font-size: 0.9rem;
    }

    @media (max-width: 576px) {
        .pagination-modern {
            --pagination-size: 32px;
        }

        .pagination-modern .page-item {
            margin: 0 2px;
        }
    }

    /* Thêm styles cho blog cards */
    .blog-card {
        transition: all 0.3s ease;
        display: none;
        /* Ẩn tất cả cards mặc định */
    }

    .blog-card.active {
        display: block;
        /* Chỉ hiển thị cards ở trang hiện tại */
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
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
        // Cấu hình phân trang
        const itemsPerPage = 6; // Số bài viết mỗi trang
        const blogCards = document.querySelectorAll('.col-md-6'); // Tất cả các thẻ blog
        const totalItems = blogCards.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        // Cập nhật tổng số trang vào UI
        document.getElementById('totalPages').textContent = totalPages;

        // Chức năng hiển thị các blog cards cho trang được chọn
        function showPage(page) {
            // Ẩn tất cả các cards
            blogCards.forEach(card => {
                card.classList.remove('active');
            });

            // Hiển thị cards cho trang hiện tại
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

            for (let i = startIndex; i < endIndex; i++) {
                if (blogCards[i]) {
                    blogCards[i].classList.add('active');
                }
            }

            // Cập nhật số trang hiện tại
            document.getElementById('currentPage').textContent = page;

            // Cập nhật trạng thái active cho nút phân trang
            const pageButtons = document.querySelectorAll('#paginationList .page-number');
            pageButtons.forEach(button => {
                button.parentElement.classList.remove('active');
                if (parseInt(button.getAttribute('data-page')) === page) {
                    button.parentElement.classList.add('active');
                }
            });

            // Scroll to top of blog list
            const blogContainer = document.querySelector('.col-lg-8');
            if (blogContainer) {
                window.scrollTo({
                    top: blogContainer.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        }

        // Tạo nút phân trang
        function createPagination() {
            const paginationList = document.getElementById('paginationList');
            paginationList.innerHTML = '';

            // Nút Previous
            const prevLi = document.createElement('li');
            prevLi.className = 'page-item prev-page';
            prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Previous">
                                  <i class="fas fa-chevron-left"></i>
                                </a>`;
            paginationList.appendChild(prevLi);

            // Giới hạn số trang hiển thị (để tránh quá nhiều nút)
            let startPage = 1;
            let endPage = totalPages;

            if (totalPages > 5) {
                // Hiển thị nút trang đầu tiên
                const firstLi = document.createElement('li');
                firstLi.className = 'page-item';
                firstLi.innerHTML = `<a class="page-link page-number" href="#" data-page="1">1</a>`;
                paginationList.appendChild(firstLi);

                // Thêm dấu chấm lửng nếu trang đầu tiên không phải là trang hiện tại
                if (startPage > 2) {
                    const ellipsisLi = document.createElement('li');
                    ellipsisLi.className = 'page-item ellipsis';
                    ellipsisLi.innerHTML = `<span class="page-link">...</span>`;
                    paginationList.appendChild(ellipsisLi);
                }

                // Hiển thị các trang ở giữa
                for (let i = 2; i < totalPages; i++) {
                    const pageLi = document.createElement('li');
                    pageLi.className = 'page-item';
                    pageLi.innerHTML = `<a class="page-link page-number" href="#" data-page="${i}">${i}</a>`;
                    paginationList.appendChild(pageLi);
                }

                // Thêm dấu chấm lửng nếu trang cuối cùng không phải là trang tiếp theo
                if (endPage < totalPages - 1) {
                    const ellipsisLi = document.createElement('li');
                    ellipsisLi.className = 'page-item ellipsis';
                    ellipsisLi.innerHTML = `<span class="page-link">...</span>`;
                    paginationList.appendChild(ellipsisLi);
                }

                // Hiển thị nút trang cuối cùng
                const lastLi = document.createElement('li');
                lastLi.className = 'page-item';
                lastLi.innerHTML = `<a class="page-link page-number" href="#" data-page="${totalPages}">${totalPages}</a>`;
                paginationList.appendChild(lastLi);
            } else {
                // Nếu ít trang, hiển thị tất cả
                for (let i = 1; i <= totalPages; i++) {
                    const pageLi = document.createElement('li');
                    pageLi.className = 'page-item';
                    pageLi.innerHTML = `<a class="page-link page-number" href="#" data-page="${i}">${i}</a>`;
                    paginationList.appendChild(pageLi);
                }
            }

            // Nút Next
            const nextLi = document.createElement('li');
            nextLi.className = 'page-item next-page';
            nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Next">
                                  <i class="fas fa-chevron-right"></i>
                                </a>`;
            paginationList.appendChild(nextLi);

            // Ẩn phân trang nếu chỉ có 1 trang
            if (totalPages <= 1) {
                document.getElementById('blogPagination').style.display = 'none';
            } else {
                document.getElementById('blogPagination').style.display = 'block';
            }

            // Thêm sự kiện click cho các nút phân trang
            const pageButtons = document.querySelectorAll('#paginationList .page-number');
            pageButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = parseInt(this.getAttribute('data-page'));
                    currentPage = page;
                    showPage(currentPage);
                });
            });

            // Xử lý nút Previous
            const prevButton = document.querySelector('.prev-page');
            prevButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });

            // Xử lý nút Next
            const nextButton = document.querySelector('.next-page');
            nextButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                }
            });
        }

        // Khởi tạo phân trang
        let currentPage = 1;
        createPagination();
        showPage(currentPage);

        // Cập nhật trạng thái nút Previous/Next
        function updateNavButtons() {
            const prevButton = document.querySelector('.prev-page');
            const nextButton = document.querySelector('.next-page');

            if (currentPage === 1) {
                prevButton.classList.add('disabled');
            } else {
                prevButton.classList.remove('disabled');
            }

            if (currentPage === totalPages) {
                nextButton.classList.add('disabled');
            } else {
                nextButton.classList.remove('disabled');
            }
        }

        // Cập nhật trạng thái nút ban đầu
        updateNavButtons();

        // Thêm lớp cho các thẻ blog để dễ dàng xử lý phân trang
        blogCards.forEach(card => {
            card.classList.add('blog-card');
        });

        // Category filter handling
        function initCategoryFilters() {
            // Add click handlers for category filters using AJAX
            const categoryItems = document.querySelectorAll('.category-item, .category-filter-badge');
            const clearCategoriesBtn = document.getElementById('clearCategoriesBtn');

            console.log('Initializing category filters');
            console.log('Found ' + categoryItems.length + ' category items');

            // Log the web root for debugging
            console.log('Web root: ' + '<?php echo _WEB_ROOT; ?>');

            // Function to reload the page content after filter change
            function reloadPage() {
                window.location.reload();
            }

            // Add click handler for category items
            categoryItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const categoryId = this.getAttribute('data-category-id');
                    console.log('Category clicked: ' + categoryId);

                    // Toggle active state visually
                    this.classList.toggle('active');

                    // Make AJAX request with a direct URL
                    const url = '<?php echo _WEB_ROOT; ?>/blog/toggleCategory/' + categoryId;
                    console.log('Making request to: ' + url);

                    // Use regular form submission instead of AJAX for now
                    window.location.href = url;

                    /* 
                    // Original AJAX code
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            // Reload the page to show filtered results
                            reloadPage();
                        }
                    })
                    .catch(error => {
                        console.error('Error toggling category:', error);
                    });
                    */
                });
            });

            // Add click handler for clear categories button
            if (clearCategoriesBtn) {
                clearCategoriesBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Clear categories clicked');

                    // Use regular form submission instead of AJAX for now
                    window.location.href = '<?php echo _WEB_ROOT; ?>/blog/clearCategories';

                    /*
                    // Original AJAX code
                    fetch(`<?php echo _WEB_ROOT; ?>/blog/clearCategories`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to show all results
                            reloadPage();
                        }
                    })
                    .catch(error => {
                        console.error('Error clearing categories:', error);
                    });
                    */
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