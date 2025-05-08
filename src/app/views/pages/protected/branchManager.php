<div class="container-fluid px-4 py-5">
  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <h4 class="mb-0">Branch Management Dashboard</h4>
    <p class="text-white-50 mt-2 mb-2">Manage your branch locations</p>
  </div>

  <!-- Control Bar -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <!-- Search Bar -->
    <div class="search-wrapper m-0">
      <i class="fas fa-search search-icon"></i>
      <input type="text" id="searchInput" class="form-control" placeholder="Search branches...">
    </div>

    <div class="d-flex align-items-center gap-3 flex-wrap">
      <!-- Add New Branch Button -->
      <button type="button" data-bs-toggle="modal" data-bs-target="#addBranchModal" class="btn btn-add">
        <i class="fas fa-plus-circle me-2"></i>Add New Branch
      </button>
    </div>
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
          <th class="py-3 sortable" data-sort="address">
            Address
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="phone">
            Phone
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="email">
            Email
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="text-center py-3">Actions</th>
        </tr>
      </thead>
      <tbody id="branchTableBody">
        <?php foreach ($branches as $branch) : ?>
          <tr class="branch-row">
            <td class="align-middle"><?= htmlspecialchars($branch['id']) ?></td>
            <td class="branch-name align-middle font-weight-bold"><?= htmlspecialchars($branch['name']) ?></td>
            <td class="align-middle">
              <i class="fas fa-map-marker-alt text-muted me-2"></i>
              <?= htmlspecialchars($branch['address']) ?>
            </td>
            <td class="align-middle">
              <i class="fas fa-phone text-muted me-2"></i>
              <?= htmlspecialchars($branch['phone']) ?>
            </td>
            <td class="align-middle">
              <i class="fas fa-envelope text-muted me-2"></i>
              <?= htmlspecialchars($branch['email']) ?>
            </td>
            <td class="text-center align-middle">
              <div class="action-buttons">
                <button type="button" class="btn btn-info details-btn" data-id="<?= htmlspecialchars($branch['id']) ?>" data-bs-toggle="modal" data-bs-target="#branchDetailModal">
                  <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-primary edit-btn" data-id="<?= htmlspecialchars($branch['id']) ?>" data-bs-toggle="modal" data-bs-target="#updateBranchModal">
                  <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger delete-btn" data-id="<?= htmlspecialchars($branch['id']) ?>" data-bs-toggle="modal" data-bs-target="#deleteBranchModal">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p id="noResultsMessage" class="text-center text-muted py-5 d-none">
      <i class="fas fa-search me-2"></i>No matching branches found
    </p>
  </div>

  <!-- Pagination -->
  <nav>
    <ul class="pagination justify-content-center" id="pagination">
      <!-- JS will populate this -->
    </ul>
  </nav>
</div>

<!-- Modal Add New Branch -->
<div class="modal fade" id="addBranchModal" tabindex="-1" aria-labelledby="addBranchModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addBranchForm" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addBranchModalLabel">Add New Branch</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Branch Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter branch name" required>
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter branch address" required>
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal View Branch Details -->
<div class="modal fade" id="branchDetailModal" tabindex="-1" aria-labelledby="branchDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" id="branchDetail">
      <!-- Content will be loaded dynamically -->
    </div>
  </div>
</div>

<!-- Modal Edit Branch -->
<div class="modal fade" id="updateBranchModal" tabindex="-1" aria-labelledby="updateBranchModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="updateBranchForm" method="post">
      <div class="modal-content" id="updateBranch">
        <!-- Content will be loaded dynamically -->
      </div>
    </form>
  </div>
</div>

<!-- Modal Delete Branch -->
<div class="modal fade" id="deleteBranchModal" tabindex="-1" aria-labelledby="deleteBranchModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteBranchForm" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteBranchModalLabel">Delete Branch</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this branch?</p>
          <p class="text-danger"><small>This action cannot be undone if this branch has associated data.</small></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Add new branch
    $("#addBranchForm").submit(function(event) {
      event.preventDefault();

      $.ajax({
        url: "/admin/branches/addBranch",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            setTimeout(function() {
              location.reload();
            }, 1000);
          } else {
            toastr.error(response.message);
          }
        },
        error: function() {
          toastr.error("Failed to add branch. Please try again.");
        },
      });
    });

    // View branch details
    $(".details-btn").click(function() {
      var branchId = $(this).data("id");
      $.ajax({
        url: "/admin/branches/getBranch/" + branchId,
        type: "GET",
        dataType: "html",
        success: function(response) {
          $('#branchDetail').html(response);
        },
        error: function() {
          toastr.error("Failed to get branch details.");
        }
      });
    });

    // Edit branch
    $(".edit-btn").click(function() {
      var branchId = $(this).data("id");
      $.ajax({
        url: "/admin/branches/getBranch/" + branchId,
        type: "GET",
        data: {
          'getToUpdate': true
        },
        dataType: "html",
        success: function(response) {
          $('#updateBranch').html(response);
        },
        error: function() {
          toastr.error("Failed to get branch details.");
        }
      });
    });

    // Delete branch
    $(".delete-btn").click(function() {
      var branchId = $(this).data("id");
      var deleteButton = document.getElementById("deleteBranchForm").querySelector("button[type='submit']");
      deleteButton.setAttribute("data-id", branchId);
    });

    // Handle update branch form submission
    document.getElementById("updateBranchForm").addEventListener("submit", function(event) {
      event.preventDefault();

      let formData = new FormData(this);
      let xhr = new XMLHttpRequest();

      let submitButton = this.querySelector("button[type='submit']");
      let id = submitButton.getAttribute("data-id");

      xhr.open("POST", `/admin/branches/editBranch/${id}`, true);

      xhr.onload = function() {
        if (xhr.status === 200) {
          try {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
              toastr.success(response.message);
            } else {
              toastr.error(response.message);
            }
            setTimeout(() => {
              location.reload();
            }, 1000);
          } catch (e) {
            toastr.error("Error! " + e);
          }
        } else {
          toastr.error("Error! " + xhr.statusText);
        }
      };

      xhr.onerror = function() {
        toastr.error("Network Error!");
      };

      xhr.send(formData);
    });

    // Handle delete branch form submission
    document.getElementById("deleteBranchForm").addEventListener("submit", function(event) {
      event.preventDefault();

      let formData = new FormData(this);
      let xhr = new XMLHttpRequest();

      let submitButton = this.querySelector("button[type='submit']");
      let id = submitButton.getAttribute("data-id");

      xhr.open("POST", `/admin/branches/deleteBranch/${id}`, true);

      xhr.onload = function() {
        if (xhr.status === 200) {
          try {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
              toastr.success(response.message);
            } else {
              toastr.error(response.message);
            }
            setTimeout(() => {
              location.reload();
            }, 1000);
          } catch (e) {
            toastr.error("Error! " + e);
          }
        } else {
          toastr.error("Error! " + xhr.statusText);
        }
      };

      xhr.onerror = function() {
        toastr.error("Network Error!");
      };

      xhr.send(formData);
    });

    // Pagination and filtering
    document.addEventListener("DOMContentLoaded", function() {
      // Variables for pagination and sorting
      const rowsPerPage = 10;
      const rows = document.querySelectorAll(".branch-row");
      const searchInput = document.getElementById("searchInput");
      const pagination = document.getElementById("pagination");
      const noResultsMessage = document.getElementById("noResultsMessage");
      const tableBody = document.getElementById("branchTableBody");
      let currentPage = 1;
      let sortState = {
        column: null,
        direction: 'asc'
      };

      // Column mappings for sorting
      const columnMap = {
        'id': {
          index: 0,
          type: 'number'
        },
        'name': {
          index: 1,
          type: 'string'
        },
        'address': {
          index: 2,
          type: 'string'
        },
        'phone': {
          index: 3,
          type: 'string'
        },
        'email': {
          index: 4,
          type: 'string'
        }
      };

      // Get cell value based on column type and index
      function getCellValue(row, columnName) {
        if (!columnMap[columnName]) return '';

        const cell = row.cells[columnMap[columnName].index];
        if (!cell) return '';

        const rawValue = cell.textContent.trim();

        // Process value based on column type
        switch (columnMap[columnName].type) {
          case 'number':
            return parseInt(rawValue, 10) || 0;
          default:
            return rawValue;
        }
      }

      // Compare function for sorting
      function compareValues(a, b, columnName, direction) {
        const aValue = getCellValue(a, columnName);
        const bValue = getCellValue(b, columnName);

        // Compare based on column type
        if (columnMap[columnName].type === 'string') {
          return direction === 'asc' ?
            aValue.localeCompare(bValue) :
            bValue.localeCompare(aValue);
        } else {
          return direction === 'asc' ?
            aValue - bValue :
            bValue - aValue;
        }
      }

      // Sort the table by column
      function sortTable(columnName) {
        if (!columnName || !tableBody) return;

        // Reset all headers
        document.querySelectorAll('th.sortable').forEach(th => {
          th.classList.remove('asc', 'desc');
          const icon = th.querySelector('i');
          if (icon) {
            icon.className = 'fas fa-sort ms-1';
            icon.style.opacity = '0.2';
          }
        });

        // Update sort state
        if (sortState.column === columnName) {
          sortState.direction = sortState.direction === 'asc' ? 'desc' : 'asc';
        } else {
          sortState.column = columnName;
          sortState.direction = 'asc';
        }

        // Update header style
        const header = document.querySelector(`th[data-sort="${columnName}"]`);
        if (header) {
          header.classList.add(sortState.direction);
          const icon = header.querySelector('i');
          if (icon) {
            icon.className = `fas fa-sort-${sortState.direction === 'asc' ? 'up' : 'down'} ms-1`;
            icon.style.opacity = '1';
          }
        }

        // Get all rows as array and sort
        const rowsArray = Array.from(tableBody.querySelectorAll('tr.branch-row'));
        rowsArray.sort((a, b) => compareValues(a, b, columnName, sortState.direction));

        // Append rows in new order
        rowsArray.forEach(row => tableBody.appendChild(row));

        // Update pagination after sorting
        updateTable();
      }

      // Update table display based on search and pagination
      function updateTable() {
        const searchTerm = searchInput.value.toLowerCase();

        // Filter rows based on search term
        const filteredRows = Array.from(rows).filter(row => {
          // Search through name, address, phone, and email
          const name = row.querySelector(".branch-name").textContent.toLowerCase();
          const address = row.cells[2].textContent.toLowerCase();
          const phone = row.cells[3].textContent.toLowerCase();
          const email = row.cells[4].textContent.toLowerCase();

          return name.includes(searchTerm) ||
            address.includes(searchTerm) ||
            phone.includes(searchTerm) ||
            email.includes(searchTerm);
        });

        // Show/hide no results message
        noResultsMessage.classList.toggle("d-none", filteredRows.length > 0);

        // Calculate pagination
        const totalPages = Math.max(1, Math.ceil(filteredRows.length / rowsPerPage));
        if (currentPage > totalPages) {
          currentPage = totalPages;
        }

        // Calculate start and end indices
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = Math.min(startIndex + rowsPerPage, filteredRows.length);

        // Update row visibility
        rows.forEach(row => row.style.display = "none");
        filteredRows.slice(startIndex, endIndex).forEach(row => row.style.display = "");

        // Update pagination controls
        updatePagination(totalPages);
      }

      // Update pagination controls
      function updatePagination(totalPages) {
        pagination.innerHTML = "";

        if (totalPages <= 1) return;

        // Previous button
        const prevLi = document.createElement("li");
        prevLi.classList.add("page-item");
        if (currentPage === 1) prevLi.classList.add("disabled");

        const prevLink = document.createElement("a");
        prevLink.classList.add("page-link");
        prevLink.href = "#";
        prevLink.innerHTML = "&laquo;";
        prevLink.addEventListener("click", function(e) {
          e.preventDefault();
          if (currentPage > 1) {
            currentPage--;
            updateTable();
          }
        });

        prevLi.appendChild(prevLink);
        pagination.appendChild(prevLi);

        // Page numbers
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        // Adjust if we're near the end
        if (endPage - startPage + 1 < maxVisiblePages) {
          startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // First page button if not starting at 1
        if (startPage > 1) {
          const firstLi = document.createElement("li");
          firstLi.classList.add("page-item");

          const firstLink = document.createElement("a");
          firstLink.classList.add("page-link");
          firstLink.href = "#";
          firstLink.textContent = "1";
          firstLink.addEventListener("click", function(e) {
            e.preventDefault();
            currentPage = 1;
            updateTable();
          });

          firstLi.appendChild(firstLink);
          pagination.appendChild(firstLi);

          // Ellipsis if not starting at 2
          if (startPage > 2) {
            const ellipsisLi = document.createElement("li");
            ellipsisLi.classList.add("page-item", "disabled");

            const ellipsisLink = document.createElement("a");
            ellipsisLink.classList.add("page-link");
            ellipsisLink.href = "#";
            ellipsisLink.textContent = "...";

            ellipsisLi.appendChild(ellipsisLink);
            pagination.appendChild(ellipsisLi);
          }
        }

        // Page number buttons
        for (let i = startPage; i <= endPage; i++) {
          const li = document.createElement("li");
          li.classList.add("page-item");
          if (i === currentPage) li.classList.add("active");

          const link = document.createElement("a");
          link.classList.add("page-link");
          link.href = "#";
          link.textContent = i;
          link.addEventListener("click", function(e) {
            e.preventDefault();
            currentPage = i;
            updateTable();
          });

          li.appendChild(link);
          pagination.appendChild(li);
        }

        // Ellipsis and last page if not ending at totalPages
        if (endPage < totalPages) {
          // Ellipsis if not ending at totalPages-1
          if (endPage < totalPages - 1) {
            const ellipsisLi = document.createElement("li");
            ellipsisLi.classList.add("page-item", "disabled");

            const ellipsisLink = document.createElement("a");
            ellipsisLink.classList.add("page-link");
            ellipsisLink.href = "#";
            ellipsisLink.textContent = "...";

            ellipsisLi.appendChild(ellipsisLink);
            pagination.appendChild(ellipsisLi);
          }

          // Last page button
          const lastLi = document.createElement("li");
          lastLi.classList.add("page-item");

          const lastLink = document.createElement("a");
          lastLink.classList.add("page-link");
          lastLink.href = "#";
          lastLink.textContent = totalPages;
          lastLink.addEventListener("click", function(e) {
            e.preventDefault();
            currentPage = totalPages;
            updateTable();
          });

          lastLi.appendChild(lastLink);
          pagination.appendChild(lastLi);
        }

        // Next button
        const nextLi = document.createElement("li");
        nextLi.classList.add("page-item");
        if (currentPage === totalPages) nextLi.classList.add("disabled");

        const nextLink = document.createElement("a");
        nextLink.classList.add("page-link");
        nextLink.href = "#";
        nextLink.innerHTML = "&raquo;";
        nextLink.addEventListener("click", function(e) {
          e.preventDefault();
          if (currentPage < totalPages) {
            currentPage++;
            updateTable();
          }
        });

        nextLi.appendChild(nextLink);
        pagination.appendChild(nextLi);
      }

      // Add event listeners to sortable column headers
      document.querySelectorAll('th.sortable').forEach(header => {
        header.addEventListener('click', () => {
          const column = header.getAttribute('data-sort');
          if (column) {
            sortTable(column);
          }
        });

        // Add hover effects
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

      // Initial table setup
      updateTable();
    });
  });
</script>