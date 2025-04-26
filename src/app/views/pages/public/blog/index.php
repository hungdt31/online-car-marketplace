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
                    <h5 class="card-title">Search</h5>
                    <form action="<?php echo _WEB_ROOT; ?>/blog/search" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="Enter keyword"
                                value="<?php echo isset($keyword) ? htmlspecialchars($keyword) : ''; ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <div class="list-group list-group-flush">
                        <?php foreach ($categories as $category): ?>
                            <a href="<?php echo _WEB_ROOT; ?>/blog/category/<?php echo $category['id']; ?>"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($category['name']); ?>
                                <span class="badge bg-primary rounded-pill"><?php echo $category['post_count']; ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Recent Posts</h5>
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="d-flex mb-3">
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
            <div class="card shadow-sm mt-4">
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
            </div>
        </div>
    </div>
</div>

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
    });
</script>