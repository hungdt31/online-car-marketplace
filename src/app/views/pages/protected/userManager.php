<?php
// filepath: d:\WORKSPACE\WORKSPACE PHP\docker-php-sample\src\app\views\pages\protected\userManager.php
?>

<style>
  <?php
  RenderSystem::renderOne('assets', 'static/css/cars/carManager.css');
  ?>
  /* Additional user-specific styles */
  .user-role {
    font-size: 0.8rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
  }
  .role-admin {
    background-color: #ffeceb;
    color: #dc3545;
  }
  .role-user {
    background-color: #e8f4ff;
    color: #0d6efd;
  }
  .status-active {
    background-color: #e6fff2;
    color: #198754;
  }
  .status-inactive {
    background-color: #f8f9fa;
    color: #6c757d;
  }
  .user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
  }
</style>

<div class="container-fluid px-4 py-5">
  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <h4 class="mb-0">User Management Dashboard</h4>
    <p class="text-white-50 mt-2 mb-2">Manage system users and permissions</p>
  </div>

  <!-- Control Bar -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <!-- Search Bar -->
    <div class="search-wrapper">
      <i class="fas fa-search search-icon"></i>
      <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
    </div>

    <!-- Add New User Button -->
    <button type="button" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-add">
      <i class="fas fa-user-plus me-2"></i>Add New User
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
          <th class="py-3 sortable" data-sort="email">
            Email
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="role">
            Role
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="status">
            Status
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="created_at">
            Created
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="text-center py-3">Actions</th>
        </tr>
      </thead>
      <tbody id="userTableBody">
        <?php foreach ($users as $user) : ?>
          <tr class="user-row">
            <td class="align-middle"><?= htmlspecialchars($user['id']) ?></td>
            <td class="user-name align-middle">
              <?php if (!empty($user['avatar'])) : ?>
                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="user-avatar">
              <?php else : ?>
                <i class="fas fa-user-circle me-2 text-secondary" style="font-size: 1.5rem;"></i>
              <?php endif; ?>
              <?= htmlspecialchars($user['name']) ?>
            </td>
            <td class="align-middle">
              <i class="fas fa-envelope text-muted me-2"></i>
              <?= htmlspecialchars($user['email']) ?>
            </td>
            <td class="align-middle">
              <span class="user-role <?= $user['role'] === 'admin' ? 'role-admin' : 'role-user' ?>">
                <?= ucfirst(htmlspecialchars($user['role'])) ?>
              </span>
            </td>
            <td class="align-middle">
              <span class="status-badge <?= $user['status'] === 'active' ? 'status-active' : 'status-inactive' ?>">
                <?= ucfirst(htmlspecialchars($user['status'])) ?>
              </span>
            </td>
            <td class="align-middle">
              <i class="fas fa-calendar text-muted me-1"></i>
              <?= date('M d, Y', strtotime($user['created_at'])) ?>
            </td>
            <td class="text-center align-middle">
              <div class="action-buttons">
                <button type="button" class="btn btn-info details-btn" data-id="<?= htmlspecialchars($user['id']) ?>" data-bs-toggle="modal" data-bs-target="#userDetailModal">
                  <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-primary edit-btn" data-id="<?= htmlspecialchars($user['id']) ?>" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                  <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger delete-btn" data-id="<?= htmlspecialchars($user['id']) ?>" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p id="noResultsMessage" class="text-center text-muted py-5 d-none">
      <i class="fas fa-search me-2"></i>No matching users found
    </p>
  </div>

  <!-- Pagination -->
  <nav>
    <ul class="pagination justify-content-center" id="pagination">
      <!-- JS will populate this -->
    </ul>
  </nav>
</div>

<!-- Modal Add New User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addUserForm" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addUserModalLabel">Add New User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
              <button class="btn btn-outline-secondary toggle-password" type="button">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" default="user">
              <option value="user">User</option>
              <option value="admin">Admin</option>
              <option value="editor">Editor</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" default="active">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="pending">Pending</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Enter short bio (optional)"></textarea>
          </div>

          <div class="mb-3">
            <label for="avatar" class="form-label">Avatar (optional)</label>
            <input type="file" class="form-control" id="avatar" name="avatar">
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

<!-- Modal User Details -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" id="userDetail">
      <!-- AJAX will populate this -->
    </div>
  </div>
</div>

<!-- Modal Update User -->
<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="updateUserForm" method="post">
      <div class="modal-content" id="updateUser">
        <!-- AJAX will populate this -->
      </div>
    </form>
  </div>
</div>

<!-- Modal Delete User -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteUserForm" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Warning: This action cannot be undone.
          </div>
          <p>Are you sure you want to delete this user? All associated data will also be deleted.</p>
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
    // Add new user
    $("#addUserForm").submit(function(event) {
      event.preventDefault();

      const formData = new FormData(this);

      $.ajax({
        url: "/admin/users/add",
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
            toastr.error(response.message);
          }
        },
        error: function() {
          toastr.error("Failed to add user. Please try again.");
        },
      });
    });

    // View user details
    $(".details-btn").click(function() {
      const userId = $(this).data("id");
      $.ajax({
        url: "/admin/users/get/" + userId,
        type: "GET",
        dataType: "html",
        success: function(response) {
          $('#userDetail').html(response);
        },
        error: function() {
          toastr.error("Failed to get user details.");
        }
      });
    });

    // Edit user
    $(".edit-btn").click(function() {
      const userId = $(this).data("id");
      $.ajax({
        url: "/admin/users/get/" + userId,
        type: "GET",
        data: {
          'getToUpdate': true
        },
        dataType: "html",
        success: function(response) {
          $('#updateUser').html(response);
          
          // Initialize password toggle
          $('.toggle-password').on('click', function() {
            const passwordField = $(this).closest('.input-group').find('input');
            const passwordFieldType = passwordField.attr('type');
            
            if (passwordFieldType === 'password') {
              passwordField.attr('type', 'text');
              $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
              passwordField.attr('type', 'password');
              $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
            }
          });
        },
        error: function() {
          toastr.error("Failed to get user details.");
        }
      });
    });

    // Delete user
    $(".delete-btn").click(function() {
      const userId = $(this).data("id");
      const deleteButton = document.getElementById("deleteUserForm").querySelector("button[type='submit']");
      deleteButton.setAttribute("data-id", userId);
    });

    // Initialize password toggle
    $('.toggle-password').on('click', function() {
      const passwordField = $(this).closest('.input-group').find('input');
      const passwordFieldType = passwordField.attr('type');
      
      if (passwordFieldType === 'password') {
        passwordField.attr('type', 'text');
        $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        passwordField.attr('type', 'password');
        $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });
  });

  // Update user form submission
  document.getElementById("updateUserForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const submitButton = this.querySelector("button[type='submit']");
    const userId = submitButton.getAttribute("data-id");

    $.ajax({
      url: "/admin/users/update/" + userId,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(response) {
        if (response.success) {
          toastr.success(response.message);
          setTimeout(() => {
            location.reload();
          }, 1000);
        } else {
          toastr.error(response.message);
        }
      },
      error: function(xhr) {
        toastr.error("Failed to update user: " + (xhr.responseJSON?.message || "Unknown error"));
      }
    });
  });

  // Delete user form submission
  document.getElementById("deleteUserForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const submitButton = this.querySelector("button[type='submit']");
    const userId = submitButton.getAttribute("data-id");

    $.ajax({
      url: "/admin/users/delete/" + userId,
      type: "POST",
      dataType: "json",
      success: function(response) {
        if (response.success) {
          toastr.success(response.message);
          setTimeout(() => {
            location.reload();
          }, 1000);
        } else {
          toastr.error(response.message);
        }
      },
      error: function() {
        toastr.error("Failed to delete user. Please try again.");
      }
    });
  });

  // Table search, pagination and sorting
  document.addEventListener("DOMContentLoaded", function() {
    // Variables for pagination and sorting
    const rowsPerPage = 5;
    const rows = document.querySelectorAll(".user-row");
    const searchInput = document.getElementById("searchInput");
    const pagination = document.getElementById("pagination");
    const noResultsMessage = document.getElementById("noResultsMessage");
    let currentPage = 1;
    let sortState = {
      column: null,
      direction: 'asc'
    };

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
        'name': 1,
        'email': 2,
        'role': 3,
        'status': 4,
        'created_at': 5
      };

      const cell = row.cells[mapping[column]];
      return cell ? cell.textContent.trim() : '';
    }

    function sortTable(column) {
      const table = document.getElementById('userTableBody');
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

        if (column === 'id') {
          return sortState.direction === 'asc' ?
            parseInt(aValue) - parseInt(bValue) :
            parseInt(bValue) - parseInt(aValue);
        }

        if (column === 'created_at') {
          aValue = new Date(aValue);
          bValue = new Date(bValue);
          return sortState.direction === 'asc' ? aValue - bValue : bValue - aValue;
        }

        // String comparison for other columns
        return sortState.direction === 'asc' ?
          aValue.localeCompare(bValue) :
          bValue.localeCompare(aValue);
      });

      // Reorder the table
      rows.forEach(row => table.appendChild(row));
    }

    function updateTable() {
      const filter = searchInput.value.toLowerCase();
      const filteredRows = Array.from(rows).filter(row => {
        const userName = row.querySelector(".user-name").textContent.toLowerCase();
        const userEmail = row.cells[2].textContent.toLowerCase();
        return userName.includes(filter) || userEmail.includes(filter);
      });

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
          updateTable();
        }
      });

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
      currentPage = 1;
      updateTable();
    });

    // Initial table setup
    updateTable();
  });
</script>