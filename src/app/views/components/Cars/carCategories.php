<?php
// filepath: d:\WORKSPACE\WORKSPACE PHP\docker-php-sample\src\app\views\pages\protected\cars\carCategories.php

/**
 * Car Categories Selection Component
 * 
 * @param array $car_id - The ID of the current car
 * @param array $car_categories - Array of categories already assigned to the car
 */

// Ensure required variables are available
if (!isset($car_id) || !isset($car_categories)) {
    echo '<div class="alert alert-danger">Error: Missing required parameters for category component</div>';
    return;
}
echo '<pre>';
print_r($car_categories);
echo '</pre>';
?>

<!-- Categories Section -->
<div class="card mb-4 category-card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-tags me-1"></i>
            Categories
        </div>
        <div class="badge bg-light text-dark category-counter">
            <span id="selectedCategoriesCount">0</span> selected
        </div>
    </div>
    <div class="card-body">
        <form id="carCategoriesForm">
            <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">

            <!-- Search box for categories -->
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control" id="categorySearch"
                        placeholder="Search categories...">
                </div>
            </div>

            <!-- Horizontal Flex Tabs for category types -->
            <div class="category-tabs-container mb-4">
                <div class="category-tabs" id="categoryTabs">
                    <?php
                    $types = ['All', 'Color', 'Style', 'Feature', 'Performance', 'Safety', 'Comfort', 'Technology', 'Material', 'Size', 'Fuel'];
                    foreach ($types as $index => $type):
                    ?>
                        <div class="category-tab-item <?php echo $index === 0 ? 'active' : ''; ?>"
                            data-tab="<?php echo strtolower($type); ?>">
                            <?php echo $type; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tab content -->
            <div class="tab-content pb-3" id="categoryTabsContent">
                <!-- All categories tab -->
                <div class="tab-pane active" id="all-content">
                    <div class="row g-3">
                        <?php
                        $allCategoriesCount = 0;
                        foreach ($types as $index => $type):
                            if ($type === 'All') continue;
                            $categories = $car_model->getCategoriesByType($type);
                            if (!empty($categories)):
                                $allCategoriesCount += count($categories);
                        ?>
                                <div class="col-md-4 category-group" data-type="<?php echo strtolower($type); ?>">
                                    <div class="card h-100">
                                        <div class="card-header category-type-header">
                                            <span class="badge category-badge <?php echo strtolower($type); ?>"><?php echo $type; ?></span>
                                        </div>
                                        <div class="card-body category-list-container">
                                            <div class="category-list">
                                                <?php foreach ($categories as $category): ?>
                                                    <div class="form-check category-item" data-name="<?php echo htmlspecialchars(strtolower($category['name'])); ?>">
                                                        <input class="form-check-input category-checkbox" type="checkbox"
                                                            name="categories[]"
                                                            value="<?php echo $category['id']; ?>"
                                                            id="category-all-<?php echo $category['id']; ?>"
                                                            data-type="<?php echo strtolower($type); ?>"
                                                            <?php echo in_array($category['id'], array_column($car_categories, 'id')) ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="category-all-<?php echo $category['id']; ?>">
                                                            <?php echo htmlspecialchars($category['name']); ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endif;
                        endforeach;
                        ?>

                        <?php if ($allCategoriesCount === 0): ?>
                            <div class="col-12 text-center py-4 text-muted">
                                <i class="fas fa-tag fa-3x mb-3"></i>
                                <p>No categories available</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Individual type tabs -->
                <?php foreach ($types as $index => $type):
                    if ($type === 'All') continue;
                    $categories = $car_model->getCategoriesByType($type);
                ?>
                    <div class="tab-pane" id="<?php echo strtolower($type); ?>-content">
                        <div class="row">
                            <?php if (!empty($categories)): ?>
                                <div class="col-md-12">
                                    <div class="category-list-scrollable">
                                        <?php foreach ($categories as $category): ?>
                                            <div class="form-check category-item" data-name="<?php echo htmlspecialchars(strtolower($category['name'])); ?>">
                                                <input class="form-check-input category-checkbox" type="checkbox"
                                                    name="categories[]"
                                                    value="<?php echo $category['id']; ?>"
                                                    id="category-<?php echo strtolower($type); ?>-<?php echo $category['id']; ?>"
                                                    data-type="<?php echo strtolower($type); ?>"
                                                    <?php echo in_array($category['id'], array_column($car_categories, 'id')) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="category-<?php echo strtolower($type); ?>-<?php echo $category['id']; ?>">
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-12 text-center py-4 text-muted">
                                    <i class="fas fa-tag fa-3x mb-3"></i>
                                    <p>No <?php echo $type; ?> categories available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="selected-categories-preview mb-3">
                <label class="form-label fw-bold">Selected Categories</label>
                <div id="selectedCategoriesBadges" class="d-flex flex-wrap gap-2">
                    <!-- Selected categories will be displayed here -->
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="saveCategoriesBtn">
                <i class="fas fa-save me-1"></i>Save Categories
                <span class="spinner-border spinner-border-sm ms-1 d-none" id="saveCategoriesSpinner"></span>
            </button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Tab navigation
        $('.category-tab-item').on('click', function() {
            const targetTab = $(this).data('tab');

            // Update active tab
            $('.category-tab-item').removeClass('active');
            $(this).addClass('active');

            // Show corresponding tab content
            $('.tab-pane').removeClass('active');
            $(`#${targetTab}-content`).addClass('active');

            // Smooth scroll the tab into view if needed
            const tabsContainer = document.querySelector('.category-tabs');
            const activeTab = this;

            if (activeTab.offsetLeft < tabsContainer.scrollLeft ||
                activeTab.offsetLeft + activeTab.offsetWidth > tabsContainer.scrollLeft + tabsContainer.offsetWidth) {
                $(tabsContainer).animate({
                    scrollLeft: activeTab.offsetLeft - 20
                }, 300);
            }
        });

        // Update selected categories count and badges
        function updateSelectedCategories() {
            const selectedCheckboxes = $('.category-checkbox:checked');
            const count = selectedCheckboxes.length;

            // Update counter
            $('#selectedCategoriesCount').text(count);

            // Update badges
            const badgesContainer = $('#selectedCategoriesBadges');
            badgesContainer.empty();

            if (count === 0) {
                badgesContainer.append('<span class="text-muted">No categories selected</span>');
            } else {
                selectedCheckboxes.each(function() {
                    const id = $(this).val();
                    const type = $(this).data('type');
                    const name = $(this).next('label').text().trim();

                    badgesContainer.append(
                        `<span class="selected-badge ${type}" data-id="${id}">
                        ${name}
                        <i class="fas fa-times remove-badge" data-id="${id}"></i>
                     </span>`
                    );
                });
            }
        }

        // Initialize selected categories
        updateSelectedCategories();

        // Handle category checkbox change
        $(document).on('change', '.category-checkbox', function() {
            const id = $(this).val();

            // Sync same category checkboxes across tabs
            $(`.category-checkbox[value="${id}"]`).prop('checked', $(this).prop('checked'));

            // Update badges and counter
            updateSelectedCategories();
        });

        // Handle badge removal
        $(document).on('click', '.remove-badge', function() {
            const id = $(this).data('id');
            $(`.category-checkbox[value="${id}"]`).prop('checked', false);
            updateSelectedCategories();
        });

        // Handle search functionality
        $('#categorySearch').on('input', function() {
            const searchText = $(this).val().toLowerCase();

            if (searchText === '') {
                // Show all categories
                $('.category-item').show();
                $('.category-group').show();
            } else {
                // Filter categories by name
                $('.category-item').each(function() {
                    const name = $(this).data('name');
                    if (name.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // Hide empty category groups in the All tab
                $('.category-group').each(function() {
                    const visibleItems = $(this).find('.category-item:visible').length;
                    $(this).toggle(visibleItems > 0);
                });
            }
        });

        // Handle form submission
        $('#carCategoriesForm').on('submit', function(e) {
            e.preventDefault();

            const submitBtn = $('#saveCategoriesBtn');
            const spinner = $('#saveCategoriesSpinner');

            // Show loading state
            submitBtn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Get form data
            const formData = $(this).serialize();

            // Submit via AJAX
            $.ajax({
                url: '/cars/update-categories',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showToast('Success', 'Categories saved successfully', 'success');
                    } else {
                        // Show error
                        showToast('Error', response.message || 'Failed to save categories', 'error');
                    }
                },
                error: function() {
                    // Show error message
                    showToast('Error', 'An error occurred while saving categories', 'error');
                },
                complete: function() {
                    // Reset button state
                    submitBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                }
            });
        });
    });

    // Toast notification function (make it global so it can be used by other components)
    function showCategoryToast(title, message, type) {
        const toastContainer = $('.toast-container');
        if (!toastContainer.length) {
            $('body').append('<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>');
        }

        const toastId = 'toast-' + Date.now();
        const toastHTML = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-${type === 'error' ? 'danger' : 'success'} text-white">
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} me-2"></i>
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;

        $('.toast-container').append(toastHTML);
        const toast = new bootstrap.Toast(document.getElementById(toastId));
        toast.show();

        // Remove toast from DOM after it's hidden
        $(`#${toastId}`).on('hidden.bs.toast', function() {
            $(this).remove();
        });
    }
</script>