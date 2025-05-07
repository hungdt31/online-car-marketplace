<?php
// filepath: d:\WORKSPACE\WORKSPACE PHP\docker-php-sample\src\app\views\pages\protected\userManager.php
?>

<style>
  <?php
  RenderSystem::renderOne('assets', 'static/css/users/userManager.css')
  ?>
</style>

<div class="container-fluid px-4 py-4">
  <div class="user-manager-container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-1">User Management</h4>
        <p class="text-muted mb-0">Manage system users and their information</p>
      </div>
      <button type="button" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-primary">
        <i class="fas fa-user-plus me-2"></i>Add New User
      </button>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar d-flex flex-wrap gap-3 align-items-center">
      <!-- Search -->
      <div class="search-wrapper flex-grow-1">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
      </div>

      <!-- Status Filter -->
      <div class="d-flex align-items-center">
        <label class="me-2">Status:</label>
        <select id="statusFilter" class="form-select">
          <option value="all">All</option>
          <option value="active">Active</option>
          <option value="suspended">Suspended</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>

      <!-- Sort -->
      <div class="d-flex align-items-center">
        <label class="me-2">Sort by:</label>
        <select id="sortSelect" class="form-select">
          <option value="newest">Newest</option>
          <option value="oldest">Oldest</option>
          <option value="name_asc">Name (A-Z)</option>
          <option value="name_desc">Name (Z-A)</option>
        </select>
      </div>
    </div>

    <!-- Users Table -->
    <div class="users-table">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th class="sortable" data-sort="username">
              Username <i class="fas fa-sort ms-1"></i>
            </th>
            <th>Email</th>
            <th class="sortable" data-sort="created_at">
              Created <i class="fas fa-sort ms-1"></i>
            </th>
            <th>Status</th>
            <th>Role</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody id="userTableBody">
          <?php foreach ($users as $user): ?>
            <tr class="user-row">
              <td><?php echo $user['id']; ?></td>
              <td>
                <div class="d-flex align-items-center">
                  <?php if ($user['avatar_url']): ?>
                    <img src="<?php echo $user['avatar_url']; ?>" class="user-avatar me-2" alt="<?php echo $user['username']; ?>">
                  <?php else: ?>
                    <div class="avatar-placeholder me-2">
                      <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                    </div>
                  <?php endif; ?>
                  <span class="fw-semibold"><?php echo $user['username']; ?></span>
                </div>
              </td>
              <td><?php echo $user['email']; ?></td>
              <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
              <td>
                <span class="user-badge status-<?php echo strtolower($user['status']); ?>">
                  <?php echo ucfirst($user['status']); ?>
                </span>
              </td>
              <td>
                <span class="badge role-<?php echo strtolower($user['role']); ?>">
                  <?php echo ucfirst($user['role']); ?>
                </span>
              </td>
              <td>
                <div class="action-buttons">
                  <button type="button" class="btn-action btn-view view-details"
                    data-id="<?php echo $user['id']; ?>"
                    data-bs-toggle="modal"
                    data-bs-target="#userDetailModal"
                    title="View Details">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button type="button" class="btn-action btn-edit edit-user"
                    data-id="<?php echo $user['id']; ?>"
                    data-bs-toggle="modal"
                    data-bs-target="#updateUserModal"
                    title="Edit User">
                    <i class="fas fa-edit"></i>
                  </button>
                  <?php if ($user['status'] === 'active'): ?>
                    <button type="button" class="btn-action btn-suspend suspend-user-btn"
                      data-id="<?php echo $user['id']; ?>"
                      data-username="<?php echo $user['username']; ?>"
                      data-bs-toggle="modal"
                      data-bs-target="#suspendUserModal"
                      title="Suspend User">
                      <i class="fas fa-ban"></i>
                    </button>
                  <?php else: ?>
                    <button type="button" class="btn-action btn-reactivate reactivate-user"
                      data-id="<?php echo $user['id']; ?>"
                      title="Reactivate User">
                      <i class="fas fa-check-circle"></i>
                    </button>
                  <?php endif; ?>
                  <button type="button" class="btn-action btn-delete delete-user-btn"
                    data-id="<?php echo $user['id']; ?>"
                    data-username="<?php echo $user['username']; ?>"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteUserModal"
                    title="Delete User">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- No Results Message -->
    <div id="noResultsMessage" class="text-center py-5 d-none">
      <i class="fas fa-search fa-3x text-muted mb-3"></i>
      <h5>No Users Found</h5>
      <p class="text-muted">Try adjusting your search or filter criteria</p>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
      <div class="text-muted">
        Showing <span id="showing-results">1-10</span> of <span id="total-results">0</span> users
      </div>
      <nav>
        <ul id="pagination" class="pagination mb-0"></ul>
      </nav>
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addUserForm">
        <div class="modal-header">
          <h5 class="modal-title">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" placeholder="nguyenvana" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="nguyenvana@gmail.com" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" name="password" required>
              <button type="button" class="btn btn-outline-secondary toggle-password">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="fname" placeholder="Nguyen Van" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lname" placeholder="Anh" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
              <label class="form-label">Role</label>
              <select class="form-select" name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label">Phone</label>
              <input type="text" class="form-control" name="phone">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea class="form-control" name="bio" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Update User Modal -->
<div class="modal fade" id="updateUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="updateUserContent">
        <!-- Content will be loaded dynamically -->
      </div>
    </div>
  </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="userDetailContent">
          <!-- Content will be loaded dynamically -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editUserFromDetails">Edit User</button>
      </div>
    </div>
  </div>
</div>

<!-- Suspend User Modal -->
<div class="modal fade confirmation-modal" id="suspendUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-icon warning">
          <i class="fas fa-ban"></i>
        </div>
        <h5 class="modal-title">Suspend User</h5>
        <p>Are you sure you want to suspend <strong id="suspendUserName"></strong>?</p>
        <p class="text-muted">This will prevent the user from accessing their account.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-warning btn-confirm-suspend" id="confirmSuspendUser">Suspend User</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade confirmation-modal" id="deleteUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-icon danger">
          <i class="fas fa-trash-alt"></i>
        </div>
        <h5 class="modal-title">Delete User</h5>
        <p>Are you sure you want to delete <strong id="deleteUserName"></strong>?</p>
        <p class="text-muted">This action cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger btn-confirm-delete" id="confirmDeleteUser">Delete User</button>
      </div>
    </div>
  </div>
</div>

<script>
  <?php
  RenderSystem::renderOne('assets', 'static/js/pages/userManager.js')
  ?>
</script>