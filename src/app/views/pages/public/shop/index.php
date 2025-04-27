<?php
// Get session for any user-specific data
$account = SessionFactory::createSession('account');
?>

<div class="container py-5">
    <div class="row">
        <!-- Left sidebar with filters -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <!-- <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2"></i>Filters</h5>
                </div> -->
                <div class="card-body">
                    <!-- Search box -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Search</h5>
                        <form action="<?php echo _WEB_ROOT ?>/shop" method="GET" id="searchForm">
                            <div class="input-group">
                                <input type="text" class="form-control border-end-0" id="keywordInput" name="keyword" placeholder="Search..." value="<?php echo htmlspecialchars($keyword ?? ''); ?>" list="keywordHistory">
                                <datalist id="keywordHistory">
                                    <?php
                                    // Get search history from cookie
                                    $searchHistory = isset($_COOKIE['search_history']) ? json_decode($_COOKIE['search_history'], true) : [];
                                    if (is_array($searchHistory)) {
                                        foreach ($searchHistory as $historyItem) {
                                            echo '<option value="' . htmlspecialchars($historyItem) . '">';
                                        }
                                    }
                                    ?>
                                </datalist>
                                <?php if (!empty($keyword)): ?>
                                    <button type="button" class="btn btn-light border" id="clearSearchBtn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>

                            <!-- Preserve other parameters -->
                            <?php if (!empty($selectedCategories)): ?>
                                <input type="hidden" name="categories" value="<?php echo implode(',', $selectedCategories); ?>">
                            <?php endif; ?>
                            <?php if (isset($minPrice)): ?>
                                <input type="hidden" name="min_price" value="<?php echo $minPrice; ?>">
                            <?php endif; ?>
                            <?php if (isset($maxPrice)): ?>
                                <input type="hidden" name="max_price" value="<?php echo $maxPrice; ?>">
                            <?php endif; ?>
                            <?php if (isset($sort)): ?>
                                <input type="hidden" name="sort" value="<?php echo $sort; ?>">
                            <?php endif; ?>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Categories</h5>
                        <div class="categories-filter">
                            <?php if (isset($categories) && is_array($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <div class="form-check d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <div>
                                            <input class="form-check-input category-checkbox" type="checkbox"
                                                id="category-<?php echo $category['id']; ?>"
                                                data-category-id="<?php echo $category['id']; ?>"
                                                <?php echo in_array($category['id'], $selectedCategories ?? []) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="category-<?php echo $category['id']; ?>">
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </label>
                                        </div>
                                        <span class="badge bg-secondary rounded-pill"><?php echo $category['car_count']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (!empty($selectedCategories)): ?>
                                <button class="btn btn-sm btn-outline-danger mt-3 w-100 clear-categories">
                                    Clear All
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Price Range</h5>
                        <div class="price-slider-container">
                            <div class="price-range">
                                <?php
                                $minPriceValue = isset($priceRange['min']) ? $priceRange['min'] : 0;
                                $maxPriceValue = isset($priceRange['max']) ? $priceRange['max'] : 100000;
                                ?>
                                <div class="range-slider mt-4" id="price-range-slider"></div>
                                <div class="d-flex justify-content-between mt-2">
                                    <span id="min-price-display" class="badge bg-light text-dark">$<?php echo number_format($minPriceValue); ?></span>
                                    <span id="max-price-display" class="badge bg-light text-dark">$<?php echo number_format($maxPriceValue); ?></span>
                                </div>
                            </div>
                            <form id="price-filter-form" action="<?php echo _WEB_ROOT ?>/shop" method="GET" class="mt-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="min_price" id="min-price" value="<?php echo $minPrice ?? $minPriceValue; ?>" class="form-control form-control-sm" placeholder="Min">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_price" id="max-price" value="<?php echo $maxPrice ?? $maxPriceValue; ?>" class="form-control form-control-sm" placeholder="Max">
                                    </div>
                                </div>

                                <?php if (!empty($keyword)): ?>
                                    <input type="hidden" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>">
                                <?php endif; ?>
                                <?php if (!empty($selectedCategories)): ?>
                                    <input type="hidden" name="categories" value="<?php echo implode(',', $selectedCategories); ?>">
                                <?php endif; ?>
                                <button class="btn btn-primary w-100 mt-3" id="filter-button" type="submit">
                                    <i class="fas fa-filter me-1"></i>Apply Filter
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Recent Products -->
                    <?php if (!empty($recentCars) && is_array($recentCars)): ?>
                        <div class="recent-products">
                            <h5 class="border-bottom pb-2">Recently Viewed</h5>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recentCars as $car): ?>
                                    <a href="<?php echo _WEB_ROOT ?>/shop/detail/<?php echo $car['id']; ?>" class="list-group-item list-group-item-action d-flex align-items-center border-0 px-0 py-2 border-bottom">
                                        <?php if (!empty($car['cover_image_url'])): ?>
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo $car['cover_image_url']; ?>" class="rounded" style="width: 60px; height: 45px; object-fit: cover;" alt="<?php echo htmlspecialchars($car['name']); ?>">
                                            </div>
                                        <?php endif; ?>
                                        <div class="ms-3">
                                            <div class="fw-bold text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($car['name']); ?></div>
                                            <div class="text-primary">$<?php echo number_format($car['price']); ?></div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-9">
            <!-- Products count and sort -->
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center py-3">
                    <div class="mb-2 mb-md-0">
                        <?php if (isset($showing)): ?>
                            <h5 class="mb-0">Showing <span class="fw-bold text-primary"><?php echo $showing['from']; ?>-<?php echo $showing['to']; ?></span> of <span class="fw-bold"><?php echo $showing['total']; ?></span> results</h5>
                        <?php else: ?>
                            <h5 class="mb-0">All Products</h5>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-2 text-nowrap">Sort by:</span>
                        <form id="sortForm" action="<?php echo _WEB_ROOT ?>/shop" method="GET" class="mb-0">
                            <select class="form-select form-select-sm" id="sort-by" name="sort" style="min-width: 180px;" onchange="document.getElementById('sortForm').submit();">
                                <option value="latest" <?php echo (!isset($sort) || $sort === 'latest') ? 'selected' : ''; ?>>Latest</option>
                                <option value="price-asc" <?php echo (isset($sort) && $sort === 'price-asc') ? 'selected' : ''; ?>>Price: Low to High</option>
                                <option value="price-desc" <?php echo (isset($sort) && $sort === 'price-desc') ? 'selected' : ''; ?>>Price: High to Low</option>
                            </select>

                            <!-- Preserve other parameters -->
                            <?php if (!empty($keyword)): ?>
                                <input type="hidden" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>">
                            <?php endif; ?>
                            <?php if (!empty($selectedCategories)): ?>
                                <input type="hidden" name="categories" value="<?php echo implode(',', $selectedCategories); ?>">
                            <?php endif; ?>
                            <?php if (isset($minPrice)): ?>
                                <input type="hidden" name="min_price" value="<?php echo $minPrice; ?>">
                            <?php endif; ?>
                            <?php if (isset($maxPrice)): ?>
                                <input type="hidden" name="max_price" value="<?php echo $maxPrice; ?>">
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <!-- Active filters -->
                <?php if (!empty($keyword) || !empty($selectedCategories) || isset($minPrice) || isset($maxPrice)): ?>
                    <div class="card-footer bg-light py-2">
                        <div class="d-flex flex-wrap align-items-center mb-2 gap-3 mt-2">
                            <span class="me-2 fw-bold text-secondary small">Active filters:</span>

                            <?php if (!empty($keyword)): ?>
                                <span class="badge bg-primary me-2 position-relative">
                                    Keyword: <?php echo htmlspecialchars($keyword); ?>
                                    <a href="<?php echo _WEB_ROOT ?>/shop?<?php
                                                                            $params = $_GET;
                                                                            unset($params['keyword']);
                                                                            echo http_build_query($params);
                                                                            ?>" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light">
                                        <i class="fas fa-times"></i>
                                        <span class="visually-hidden">Remove keyword filter</span>
                                    </a>
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($selectedCategories) && isset($categories)): ?>
                                <?php
                                // Create a map of category IDs to names
                                $categoryMap = [];
                                foreach ($categories as $cat) {
                                    $categoryMap[$cat['id']] = $cat['name'];
                                }

                                foreach ($selectedCategories as $catId):
                                    if (isset($categoryMap[$catId])):
                                        // Create a new array without this category
                                        $remainingCategories = array_filter($selectedCategories, function ($c) use ($catId) {
                                            return $c != $catId;
                                        });
                                ?>
                                        <span class="badge bg-info text-dark me-2 position-relative">
                                            <?php echo htmlspecialchars($categoryMap[$catId]); ?>
                                            <a href="<?php echo _WEB_ROOT ?>/shop?<?php
                                                                                    $params = $_GET;
                                                                                    if (empty($remainingCategories)) {
                                                                                        unset($params['categories']);
                                                                                    } else {
                                                                                        $params['categories'] = implode(',', $remainingCategories);
                                                                                    }
                                                                                    echo http_build_query($params);
                                                                                    ?>" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light">
                                                <i class="fas fa-times"></i>
                                                <span class="visually-hidden">Remove category filter</span>
                                            </a>
                                        </span>
                                <?php
                                    endif;
                                endforeach; ?>
                            <?php endif; ?>

                            <?php if (isset($minPrice) || isset($maxPrice)): ?>
                                <span class="badge bg-success me-2 position-relative">
                                    Price:
                                    <?php if (isset($minPrice)): ?>$<?php echo number_format($minPrice); ?><?php endif; ?>
                                    <?php if (isset($minPrice) && isset($maxPrice)): ?> - <?php endif; ?>
                                    <?php if (isset($maxPrice)): ?>$<?php echo number_format($maxPrice); ?><?php endif; ?>
                                    <a href="<?php echo _WEB_ROOT ?>/shop?<?php
                                                                            $params = $_GET;
                                                                            unset($params['min_price']);
                                                                            unset($params['max_price']);
                                                                            echo http_build_query($params);
                                                                            ?>" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light">
                                        <i class="fas fa-times"></i>
                                        <span class="visually-hidden">Remove price filter</span>
                                    </a>
                                </span>
                            <?php endif; ?>

                            <a href="<?php echo _WEB_ROOT ?>/shop" class="ms-auto">
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-backspace-reverse-fill me-2"></i>Reset
                                </button>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Products grid -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
                <?php if (empty($cars)): ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center py-5">
                            <i class="fas fa-car-crash fa-4x mb-3 text-muted"></i>
                            <h4>No vehicles found</h4>
                            <p class="mb-0">Try adjusting your search or filter criteria</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($cars as $car): ?>
                        <div class="col">
                            <div class="card h-100 product-card border-0 shadow-sm rounded-3 hover-effect">
                                <div class="position-relative">
                                    <div class="card-img-container" style="height: 200px; overflow: hidden;">
                                        <?php if (!empty($car['cover_image_url'])): ?>
                                            <img src="<?php echo $car['cover_image_url']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($car['name']); ?>" style="object-fit: cover; height: 100%; width: 100%;">
                                        <?php else: ?>
                                            <div class="placeholder-image bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                                <i class="fas fa-car fa-3x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Location badge overlay -->
                                    <div class="position-absolute bottom-0 start-0 m-2">
                                        <span class="badge bg-dark bg-opacity-75">
                                            <i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars($car['location']); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="<?php echo _WEB_ROOT ?>/shop/detail/<?php echo $car['id']; ?>" class="text-decoration-none">
                                        <h5 class="card-title text-truncate"><?php echo htmlspecialchars($car['name']); ?></h5>
                                    </a>
                                    <?php if (!empty($car['overview'])): ?>
                                        <p class="card-text small text-muted mb-3 text-truncate"><?php echo htmlspecialchars($car['overview']); ?></p>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <h5 class="text-primary mb-0 fw-bold">$<?php echo number_format($car['price']); ?></h5>
                                        <a href="<?php echo _WEB_ROOT ?>/shop/detail/<?php echo $car['id']; ?>">
                                            <button class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>
                                                Details
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if (isset($pagination) && $pagination['total'] > 1): ?>
                <nav aria-label="Page navigation" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <!-- First page button -->
                        <li class="page-item <?php echo $pagination['current'] == 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo _WEB_ROOT ?>/shop?page=1<?php echo !empty($keyword) ? '&keyword=' . urlencode($keyword) : ''; ?><?php echo !empty($selectedCategories) ? '&categories=' . implode(',', $selectedCategories) : ''; ?><?php echo isset($minPrice) ? '&min_price=' . $minPrice : ''; ?><?php echo isset($maxPrice) ? '&max_price=' . $maxPrice : ''; ?><?php echo isset($sort) ? '&sort=' . $sort : ''; ?>" aria-label="First">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <!-- Previous button -->
                        <li class="page-item <?php echo $pagination['current'] == 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo _WEB_ROOT ?>/shop?page=<?php echo $pagination['current'] - 1; ?><?php echo !empty($keyword) ? '&keyword=' . urlencode($keyword) : ''; ?><?php echo !empty($selectedCategories) ? '&categories=' . implode(',', $selectedCategories) : ''; ?><?php echo isset($minPrice) ? '&min_price=' . $minPrice : ''; ?><?php echo isset($maxPrice) ? '&max_price=' . $maxPrice : ''; ?><?php echo isset($sort) ? '&sort=' . $sort : ''; ?>">
                                <span aria-hidden="true">&lsaquo;</span>
                            </a>
                        </li>

                        <?php
                        // Display limited page numbers with ellipsis
                        $startPage = max(1, $pagination['current'] - 2);
                        $endPage = min($pagination['total'], $pagination['current'] + 2);

                        // Show first page if not included in the range
                        if ($startPage > 1) {
                            echo '<li class="page-item"><a class="page-link" href="' . _WEB_ROOT . '/shop?page=1' .
                                (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '') .
                                (!empty($selectedCategories) ? '&categories=' . implode(',', $selectedCategories) : '') .
                                (isset($minPrice) ? '&min_price=' . $minPrice : '') .
                                (isset($maxPrice) ? '&max_price=' . $maxPrice : '') .
                                (isset($sort) ? '&sort=' . $sort : '') .
                                '">1</a></li>';

                            if ($startPage > 2) {
                                echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                            }
                        }

                        // Loop through the calculated range
                        for ($i = $startPage; $i <= $endPage; $i++):
                        ?>
                            <li class="page-item <?php echo $pagination['current'] == $i ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo _WEB_ROOT ?>/shop?page=<?php echo $i; ?><?php echo !empty($keyword) ? '&keyword=' . urlencode($keyword) : ''; ?><?php echo !empty($selectedCategories) ? '&categories=' . implode(',', $selectedCategories) : ''; ?><?php echo isset($minPrice) ? '&min_price=' . $minPrice : ''; ?><?php echo isset($maxPrice) ? '&max_price=' . $maxPrice : ''; ?><?php echo isset($sort) ? '&sort=' . $sort : ''; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor;

                        // Show last page if not included in the range
                        if ($endPage < $pagination['total']) {
                            if ($endPage < $pagination['total'] - 1) {
                                echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="' . _WEB_ROOT . '/shop?page=' . $pagination['total'] .
                                (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '') .
                                (!empty($selectedCategories) ? '&categories=' . implode(',', $selectedCategories) : '') .
                                (isset($minPrice) ? '&min_price=' . $minPrice : '') .
                                (isset($maxPrice) ? '&max_price=' . $maxPrice : '') .
                                (isset($sort) ? '&sort=' . $sort : '') .
                                '">' . $pagination['total'] . '</a></li>';
                        }
                        ?>

                        <!-- Next button -->
                        <li class="page-item <?php echo $pagination['current'] == $pagination['total'] ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo _WEB_ROOT ?>/shop?page=<?php echo $pagination['current'] + 1; ?><?php echo !empty($keyword) ? '&keyword=' . urlencode($keyword) : ''; ?><?php echo !empty($selectedCategories) ? '&categories=' . implode(',', $selectedCategories) : ''; ?><?php echo isset($minPrice) ? '&min_price=' . $minPrice : ''; ?><?php echo isset($maxPrice) ? '&max_price=' . $maxPrice : ''; ?><?php echo isset($sort) ? '&sort=' . $sort : ''; ?>">
                                <span aria-hidden="true">&rsaquo;</span>
                            </a>
                        </li>

                        <!-- Last page button -->
                        <li class="page-item <?php echo $pagination['current'] == $pagination['total'] ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo _WEB_ROOT ?>/shop?page=<?php echo $pagination['total']; ?><?php echo !empty($keyword) ? '&keyword=' . urlencode($keyword) : ''; ?><?php echo !empty($selectedCategories) ? '&categories=' . implode(',', $selectedCategories) : ''; ?><?php echo isset($minPrice) ? '&min_price=' . $minPrice : ''; ?><?php echo isset($maxPrice) ? '&max_price=' . $maxPrice : ''; ?><?php echo isset($sort) ? '&sort=' . $sort : ''; ?>" aria-label="Last">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .pagination .page-link {
        color: #495057;
        border-radius: 0;
        margin: 0 2px;
    }

    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .pagination .page-link:focus {
        box-shadow: none;
    }
</style>

<script>
    // Store search keyword in history
    function storeKeyword(keyword) {
        if (!keyword || keyword.trim() === '') return;

        // Get existing history
        let searchHistory = getCookie('search_history');
        searchHistory = searchHistory ? JSON.parse(searchHistory) : [];

        // Add keyword if not exists
        if (!searchHistory.includes(keyword)) {
            // Keep only last 5 searches
            if (searchHistory.length >= 5) {
                searchHistory.pop();
            }
            searchHistory.unshift(keyword);

            // Save back to cookie (7 days expiration)
            document.cookie = `search_history=${JSON.stringify(searchHistory)}; max-age=604800; path=/`;
        }
    }

    // Get cookie by name
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    // Category toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Store current keyword in history if exists
        const currentKeyword = document.getElementById('keywordInput').value;
        if (currentKeyword) {
            storeKeyword(currentKeyword);
        }

        // Clear search button
        const clearSearchBtn = document.getElementById('clearSearchBtn');
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function() {
                document.getElementById('keywordInput').value = '';
                document.getElementById('searchForm').submit();
            });
        }

        // Category checkboxes
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const categoryId = this.getAttribute('data-category-id');

                // Create form and submit
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = '<?php echo _WEB_ROOT ?>/shop';

                // Keep existing params
                const params = new URLSearchParams(window.location.search);

                // Update categories
                let categories = params.get('categories') ? params.get('categories').split(',') : [];

                if (this.checked) {
                    // Add category if not exists
                    if (!categories.includes(categoryId)) {
                        categories.push(categoryId);
                    }
                } else {
                    // Remove category
                    categories = categories.filter(id => id !== categoryId);
                }

                // Add all params to form
                for (const [key, value] of params.entries()) {
                    if (key !== 'categories') {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }
                }

                // Add categories param if not empty
                if (categories.length > 0) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'categories';
                    input.value = categories.join(',');
                    form.appendChild(input);
                }

                // Submit form
                document.body.appendChild(form);
                form.submit();
            });
        });

        // Clear categories button
        const clearCategoriesBtn = document.querySelector('.clear-categories');
        if (clearCategoriesBtn) {
            clearCategoriesBtn.addEventListener('click', function() {
                // Create form and submit without categories param
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = '<?php echo _WEB_ROOT ?>/shop';

                // Keep existing params except categories
                const params = new URLSearchParams(window.location.search);
                for (const [key, value] of params.entries()) {
                    if (key !== 'categories') {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }
                }

                // Submit form
                document.body.appendChild(form);
                form.submit();
            });
        }

        // Price range slider
        if (document.getElementById('price-range-slider')) {
            const minPrice = <?php echo $priceRange['min'] ?? 0; ?>;
            const maxPrice = <?php echo $priceRange['max'] ?? 100000; ?>;
            const currentMinPrice = <?php echo $minPrice ?? $priceRange['min'] ?? 0; ?>;
            const currentMaxPrice = <?php echo $maxPrice ?? $priceRange['max'] ?? 100000; ?>;

            // Initialize price range slider
            const slider = document.getElementById('price-range-slider');
            noUiSlider.create(slider, {
                start: [currentMinPrice, currentMaxPrice],
                connect: true,
                step: 1000,
                range: {
                    'min': minPrice,
                    'max': maxPrice
                },
                format: {
                    to: function(value) {
                        return Math.round(value);
                    },
                    from: function(value) {
                        return Number(value);
                    }
                }
            });

            // Update display values and form inputs
            const minPriceInput = document.getElementById('min-price');
            const maxPriceInput = document.getElementById('max-price');
            const minPriceDisplay = document.getElementById('min-price-display');
            const maxPriceDisplay = document.getElementById('max-price-display');

            slider.noUiSlider.on('update', function(values, handle) {
                const value = values[handle];
                if (handle === 0) {
                    minPriceInput.value = value;
                    minPriceDisplay.textContent = '$' + Number(value).toLocaleString();
                } else {
                    maxPriceInput.value = value;
                    maxPriceDisplay.textContent = '$' + Number(value).toLocaleString();
                }
            });
        }
    });
</script>