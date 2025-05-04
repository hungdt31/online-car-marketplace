<div class="container-fluid px-4 py-5">
  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <h4 class="mb-0">Category Management Dashboard</h4>
    <p class="text-white-50 mt-2 mb-2">Manage your category system</p>
  </div>

  <!-- Control Bar - Modified to include type filter -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">
      <!-- Search Bar -->
      <div class="search-wrapper mb-0">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" class="form-control" placeholder="Search categories...">
      </div>

      <!-- Type Filter Dropdown -->
      <div class="filter-wrapper ">
        <select id="typeFilter" class="form-select">
          <option value="">All Types</option>
          <?php
          $types = ['Color', 'Style', 'Feature', 'Performance', 'Safety', 'Comfort', 'Technology', 'Material', 'Size', 'Fuel'];
          foreach ($types as $type) {
            echo "<option value=\"$type\">$type</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <!-- Add New Category Button -->
    <button type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal" class="btn btn-add">
      <i class="fas fa-plus-circle me-2"></i>Add New Category
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
          <th class="py-3 sortable" data-sort="name">
            Name
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="description">
            Description
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="type">
            Type
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="created_at">
            Created At
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="text-center py-3">Actions</th>
        </tr>
      </thead>
      <tbody id="categoryTableBody">
        <?php foreach ($categories as $category): ?>
          <tr class="category-row">
            <td class="align-middle"><?= $category['id'] ?></td>
            <td class="category-name align-middle"><?= htmlspecialchars($category['name']) ?></td>
            <td class="align-middle description-cell"><?= htmlspecialchars($category['description']) ?></td>
            <td class="align-middle">
              <span class="status-badge <?= getTypeBadgeClass($category['type']) ?>">
                <?= htmlspecialchars($category['type']) ?>
              </span>
            </td>
            <td class="align-middle"><?= date('Y-m-d H:i', strtotime($category['created_at'])) ?></td>
            <td class="text-center align-middle">
              <div class="action-buttons">
                <button class="btn btn-info edit-category" data-id="<?= $category['id'] ?>">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-danger delete-category" data-id="<?= $category['id'] ?>">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p id="noResultsMessage" class="text-center text-muted py-5 d-none">
      <i class="fas fa-search me-2"></i>No matching categories found
    </p>
  </div>

  <!-- Pagination -->
  <nav>
    <ul class="pagination justify-content-center" id="pagination">
      <!-- JS will populate this -->
    </ul>
  </nav>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryModalLabel">
          <i class="fas fa-tag me-2"></i>Add New Category
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addCategoryForm">
        <div class="modal-body">
          <input type="hidden" name="csrf_token" value="<?= $content['csrf_token'] ?>">

          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required maxlength="100" placeholder="Enter category name">
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" maxlength="255" placeholder="Enter category description"></textarea>
          </div>

          <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-control" id="type" name="type" required>
              <?php
              $types = ['Color', 'Style', 'Feature', 'Performance', 'Safety', 'Comfort', 'Technology', 'Material', 'Size', 'Fuel'];
              foreach ($types as $type) {
                echo "<option value=\"$type\">$type</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Save Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCategoryModalLabel">
          <i class="fas fa-edit me-2"></i>Edit Category
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editCategoryForm">
        <div class="modal-body">
          <input type="hidden" name="csrf_token" value="<?= $content['csrf_token'] ?>">
          <input type="hidden" id="edit_id" name="id">

          <div class="mb-3">
            <label for="edit_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="edit_name" name="name" required maxlength="100">
          </div>

          <div class="mb-3">
            <label for="edit_description" class="form-label">Description</label>
            <textarea class="form-control" id="edit_description" name="description" rows="3" maxlength="255"></textarea>
          </div>

          <div class="mb-3">
            <label for="edit_type" class="form-label">Type</label>
            <select class="form-control" id="edit_type" name="type" required>
              <?php
              foreach ($types as $type) {
                echo "<option value=\"$type\">$type</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Update Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteCategoryModalLabel">
          <!-- <i class="fas fa-exclamation-triangle me-2"></i> -->
          Confirm Deletion
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="delete-confirmation-content">
          <div class="warning-icon mb-3 text-center">
            <i class="fas fa-exclamation-circle fa-4x text-danger"></i>
          </div>
          
          <h5 class="confirmation-heading mb-3">Are you sure you want to delete this category?</h5>
          
          <div class="alert alert-warning py-2 mb-3">
            <i class="fas fa-info-circle me-2"></i>
            This action cannot be undone. All associated data will be permanently removed.
          </div>
          
          <div class="category-details p-3 mb-2 border rounded bg-light">
            <div class="row">
              <div class="col-4 text-muted">Name:</div>
              <div class="col-8 fw-bold" id="delete-category-name"></div>
            </div>
            <div class="row mt-2">
              <div class="col-4 text-muted">Type:</div>
              <div class="col-8"><span id="delete-category-type" class="status-badge"></span></div>
            </div>
          </div>
          
          <p class="text-center text-danger mb-0 mt-3">
            <small><i class="fas fa-lock me-1"></i> Once deleted, you cannot recover this information</small>
          </p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-danger">
          <i class="fas fa-trash me-2"></i>Delete Category
        </button>
      </div>
    </div>
  </div>
</div>

<style>
  <?php
  RenderSystem::renderOne('assets', 'static/css/categories/cateManager.css', []);
  ?>
</style>

<script>
  function getTypeBadgeClass(type) {
    const typeClasses = {
      'Color': 'bg-color',
      'Style': 'bg-style',
      'Feature': 'bg-feature',
      'Performance': 'bg-performance',
      'Safety': 'bg-safety',
      'Comfort': 'bg-comfort',
      'Technology': 'bg-technology',
      'Material': 'bg-material',
      'Size': 'bg-size',
      'Fuel': 'bg-fuel'
    };

    return typeClasses[type] || 'bg-light';
  }

  $(document).ready(function() {
    // Pagination variables
    let rowsPerPage = 10;
    let currentPage = 1;
    let filteredRows = [];

    function updateTable() {
      const searchText = $('#searchInput').val().toLowerCase();
      const typeFilter = $('#typeFilter').val().toLowerCase();
      const rows = $('.category-row');
      console.log(typeFilter);

      // Filter rows based on search text and type filter
      filteredRows = [];

      rows.each(function() {
        const name = $(this).find('.category-name').text().toLowerCase();
        const description = $(this).find('.description-cell').text().toLowerCase();
        const type = $(this).find('.status-badge').text().trim().toLowerCase();

        if ((name.includes(searchText) || description.includes(searchText) || type.includes(searchText)) &&
          (typeFilter === '' || type === typeFilter)) {
          filteredRows.push($(this));
        }
      });
      console.log(filteredRows);

      // Hide all rows
      rows.hide();

      // Show no results message if needed
      if (filteredRows.length === 0) {
        $('#noResultsMessage').removeClass('d-none');
      } else {
        $('#noResultsMessage').addClass('d-none');

        // Calculate pagination
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (currentPage > totalPages) {
          currentPage = totalPages || 1;
        }

        // Show current page rows
        const startIdx = (currentPage - 1) * rowsPerPage;
        const endIdx = Math.min(startIdx + rowsPerPage, filteredRows.length);

        for (let i = startIdx; i < endIdx; i++) {
          filteredRows[i].show();
        }

        // Update pagination controls
        updatePagination(totalPages);
      }
    }

    function updatePagination(totalPages) {
      const pagination = $('#pagination');
      pagination.empty();

      if (totalPages <= 1) return;

      // Previous button
      const prevLi = $('<li>').addClass('page-item' + (currentPage === 1 ? ' disabled' : ''));
      const prevLink = $('<a>').addClass('page-link').attr('href', '#').html('&laquo;');
      prevLi.append(prevLink);
      pagination.append(prevLi);

      // Page numbers
      for (let i = 1; i <= totalPages; i++) {
        const li = $('<li>').addClass('page-item' + (i === currentPage ? ' active' : ''));
        const link = $('<a>').addClass('page-link').attr('href', '#').text(i);
        li.append(link);
        pagination.append(li);
      }

      // Next button
      const nextLi = $('<li>').addClass('page-item' + (currentPage === totalPages ? ' disabled' : ''));
      const nextLink = $('<a>').addClass('page-link').attr('href', '#').html('&raquo;');
      nextLi.append(nextLink);
      pagination.append(nextLi);

      // Add click handlers
      pagination.find('.page-link').on('click', function(e) {
        e.preventDefault();

        const text = $(this).text();
        if (text === '«') {
          currentPage--;
        } else if (text === '»') {
          currentPage++;
        } else {
          currentPage = parseInt(text);
        }

        updateTable();
      });
    }

    // Initialize table
    updateTable();

    // Search functionality
    $('#searchInput').on('keyup', function() {
      currentPage = 1;
      updateTable();
    });

    // Type filter functionality
    $('#typeFilter').on('change', function() {
      currentPage = 1;
      updateTable();
    });

    // Add Category Form Submission
    $('#addCategoryForm').on('submit', function(e) {
      e.preventDefault();
      const submitBtn = $(this).find('button[type="submit"]');
      const originalText = submitBtn.html();

      submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...').attr('disabled', true);

      $.ajax({
        url: '/admin/categories/add',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            toastr.success(response.message || 'Category added successfully');
            setTimeout(function() {
              location.reload();
            }, 1500); // Reload after 1.5 seconds
          } else {
            toastr.error(response.message || 'Error adding category');
          }
        },
        error: function(xhr) {
          toastr.error('An error occurred: ' + xhr.statusText);
        },
        complete: function() {
          submitBtn.html(originalText).attr('disabled', false);
        }
      });
    });

    // Edit Category Button Click
    $(document).on('click', '.edit-category', function() {
      const id = $(this).data('id');
      const submitBtn = $('#editCategoryForm button[type="submit"]');

      submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Loading...').attr('disabled', true);

      $.ajax({
        url: '/admin/categories/get/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#edit_id').val(response.data.id);
            $('#edit_name').val(response.data.name);
            $('#edit_description').val(response.data.description);
            $('#edit_type').val(response.data.type);
            $('#editCategoryModal').modal('show');

            submitBtn.html('<i class="fas fa-save me-2"></i>Update Category').attr('disabled', false);
          } else {
            toastr.error(response.message || 'Failed to load category data');
          }
        },
        error: function(xhr) {
          toastr.error('An error occurred: ' + xhr.statusText);
        }
      });
    });

    // Update Category Form Submission
    $('#editCategoryForm').on('submit', function(e) {
      e.preventDefault();
      const submitBtn = $(this).find('button[type="submit"]');
      const originalText = submitBtn.html();

      submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...').attr('disabled', true);

      $.ajax({
        url: '/admin/categories/update',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            toastr.success(response.message || 'Category updated successfully');
            setTimeout(function() {
              location.reload();
            }, 1500); // Reload after 1.5 seconds
          } else {
            toastr.error(response.message || 'Error updating category');
          }
        },
        error: function(xhr) {
          toastr.error('An error occurred: ' + xhr.statusText);
        },
        complete: function() {
          submitBtn.html(originalText).attr('disabled', false);
        }
      });
    });

    // Delete Category Button Click
    $(document).on('click', '.delete-category', function() {
      const id = $(this).data('id');
      const categoryName = $(this).closest('tr').find('.category-name').text();
      const categoryType = $(this).closest('tr').find('.status-badge').text().trim();

      $('#delete-category-name').text(categoryName);
      $('#delete-category-type').text(categoryType).attr('class', 'status-badge ' + getTypeBadgeClass(categoryType));
      $('#confirmDeleteBtn').data('id', id);
      $('#deleteCategoryModal').modal('show');
    });

    // Confirm Delete Button Click
    $('#confirmDeleteBtn').on('click', function() {
      const id = $(this).data('id');
      const btn = $(this);
      const originalText = btn.html();

      btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Deleting...').attr('disabled', true);

      $.ajax({
        url: '/admin/categories/delete/' + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            toastr.success(response.message || 'Category deleted successfully');
            $('#deleteCategoryModal').modal('hide');
            setTimeout(function() {
              location.reload();
            }, 1500); // Reload after 1.5 seconds
          } else {
            toastr.error(response.message || 'Error deleting category');
          }
        },
        error: function(xhr) {
          toastr.error('An error occurred: ' + xhr.statusText);
        },
        complete: function() {
          btn.html(originalText).attr('disabled', false);
        }
      });
    });

    // Sorting functionality
    let sortState = {
      column: null,
      direction: 'asc'
    };

    $(document).on('click', '.sortable', function() {
      const column = $(this).data('sort');

      // Reset all headers
      $('.sortable').removeClass('asc desc').find('i').attr('class', 'fas fa-sort ms-1');

      // Update sort state
      if (sortState.column === column) {
        sortState.direction = sortState.direction === 'asc' ? 'desc' : 'asc';
      } else {
        sortState.column = column;
        sortState.direction = 'asc';
      }

      // Update header appearance
      $(this).addClass(sortState.direction);
      $(this).find('i').attr('class', 'fas fa-sort-' + (sortState.direction === 'asc' ? 'up' : 'down') + ' ms-1');

      // Perform sort
      sortTableRows();

      // Update display
      updateTable();
    });

    function sortTableRows() {
      const column = sortState.column;
      const direction = sortState.direction;

      const rows = Array.from($('#categoryTableBody tr'));

      rows.sort(function(a, b) {
        let valueA, valueB;

        if (column === 'id') {
          valueA = parseInt($(a).find('td:eq(0)').text());
          valueB = parseInt($(b).find('td:eq(0)').text());
        } else if (column === 'name') {
          valueA = $(a).find('td:eq(1)').text().toLowerCase();
          valueB = $(b).find('td:eq(1)').text().toLowerCase();
        } else if (column === 'description') {
          valueA = $(a).find('td:eq(2)').text().toLowerCase();
          valueB = $(b).find('td:eq(2)').text().toLowerCase();
        } else if (column === 'type') {
          valueA = $(a).find('td:eq(3)').text().toLowerCase();
          valueB = $(b).find('td:eq(3)').text().toLowerCase();
        } else if (column === 'created_at') {
          valueA = new Date($(a).find('td:eq(4)').text()).getTime();
          valueB = new Date($(b).find('td:eq(4)').text()).getTime();
        }

        if (direction === 'asc') {
          return valueA > valueB ? 1 : -1;
        } else {
          return valueA < valueB ? 1 : -1;
        }
      });

      $('#categoryTableBody').append(rows);
    }
  });
</script>

<?php
// Helper function to get badge class based on category type
function getTypeBadgeClass($type)
{
  $typeClasses = [
    'Color' => 'bg-color',
    'Style' => 'bg-style',
    'Feature' => 'bg-feature',
    'Performance' => 'bg-performance',
    'Safety' => 'bg-safety',
    'Comfort' => 'bg-comfort',
    'Technology' => 'bg-technology',
    'Material' => 'bg-material',
    'Size' => 'bg-size',
    'Fuel' => 'bg-fuel'
  ];

  return isset($typeClasses[$type]) ? $typeClasses[$type] : 'bg-light';
}
?>