$(document).ready(function () {
  // Initialize tooltips
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Handle suspend user button
  $(document).on("click", ".suspend-user-btn", function () {
    const userId = $(this).data("id");
    const username = $(this).data("username");

    // Set data in modal
    $("#suspendUserName").text(username);
    $("#confirmSuspendUser").data("id", userId);
  });

  // Handle delete user button
  $(document).on("click", ".delete-user-btn", function () {
    const userId = $(this).data("id");
    const username = $(this).data("username");

    // Set data in modal
    $("#deleteUserName").text(username);
    $("#confirmDeleteUser").data("id", userId);
  });

  // Handle confirm suspend
  $("#confirmSuspendUser").click(function () {
    const userId = $(this).data("id");
    const button = $(this);

    // Change button to loading state
    const originalText = button.html();
    button.html('<i class="fas fa-spinner fa-spin me-1"></i> Suspending...');
    button.prop("disabled", true);

    // Send AJAX request
    $.ajax({
      url: `/admin/users/updateUserStatus/${userId}`,
      method: "POST",
      data: { status: "suspended" },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          // Close modal
          $("#suspendUserModal").modal("hide");

          // Show success message
          toastr.success("User has been suspended");

          // Update UI - replace suspend button with reactivate button
          const actionBtn = $(`.suspend-user-btn[data-id="${userId}"]`);
          const actionCell = actionBtn.closest(".action-buttons");

          // Update status badge
          const statusBadge = actionBtn.closest("tr").find(".user-badge");
          statusBadge
            .removeClass("status-active")
            .addClass("status-suspended")
            .text("Suspended");

          // Replace button
          actionBtn.replaceWith(`
              <button type="button" class="btn-action btn-reactivate reactivate-user" 
                      data-id="${userId}" 
                      data-bs-toggle="tooltip" 
                      title="Reactivate User">
                <i class="fas fa-check-circle"></i>
              </button>
            `);

          // Reinitialize tooltips
          const tooltips = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
          );
          tooltips.map(function (tooltipEl) {
            return new bootstrap.Tooltip(tooltipEl);
          });
        } else {
          toastr.error(response.message || "Failed to suspend user");
        }
      },
      error: function () {
        toastr.error("Could not connect to server");
      },
      complete: function () {
        button.html(originalText);
        button.prop("disabled", false);
      },
    });
  });

  // Handle confirm delete
  $("#confirmDeleteUser").click(function () {
    const userId = $(this).data("id");
    const button = $(this);

    // Change button to loading state
    const originalText = button.html();
    button.html('<i class="fas fa-spinner fa-spin me-1"></i> Deleting...');
    button.prop("disabled", true);

    // Send AJAX request
    $.ajax({
      url: `/admin/users/delete/${userId}`,
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          // Close modal
          $("#deleteUserModal").modal("hide");

          // Show success message
          toastr.success("User has been deleted successfully");

          // Remove row from table with animation
          $(`.delete-user-btn[data-id="${userId}"]`)
            .closest("tr")
            .fadeOut(400, function () {
              $(this).remove();
              applyFilters(); // Update pagination
            });
        } else {
          toastr.error(response.message || "Failed to delete user");
        }
      },
      error: function () {
        toastr.error("Could not connect to server");
      },
      complete: function () {
        button.html(originalText);
        button.prop("disabled", false);
      },
    });
  });

  // Handle reactivate user directly (no confirmation needed)
  $(document).on("click", ".reactivate-user", function () {
    const userId = $(this).data("id");
    const button = $(this);

    // Change button to loading state
    button.html('<i class="fas fa-spinner fa-spin"></i>');
    button.prop("disabled", true);

    // Send AJAX request
    $.ajax({
      url: `/admin/users/updateUserStatus/${userId}`,
      method: "POST",
      data: { status: "active" },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          // Show success message
          toastr.success("User has been reactivated");

          // Update UI - replace reactivate button with suspend button
          const actionCell = button.closest(".action-buttons");

          // Update status badge
          const statusBadge = button.closest("tr").find(".user-badge");
          statusBadge
            .removeClass("status-suspended")
            .addClass("status-active")
            .text("Active");

          // Replace button
          button.replaceWith(`
              <button type="button" class="btn-action btn-suspend suspend-user-btn" 
                      data-id="${userId}" 
                      data-username="${response.user?.username || ""}"
                      data-bs-toggle="tooltip" 
                      title="Suspend User">
                <i class="fas fa-ban"></i>
              </button>
            `);

          // Reinitialize tooltips
          const tooltips = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
          );
          tooltips.map(function (tooltipEl) {
            return new bootstrap.Tooltip(tooltipEl);
          });
        } else {
          toastr.error(response.message || "Failed to reactivate user");
          // Reset button state
          button.html('<i class="fas fa-check-circle"></i>');
          button.prop("disabled", false);
        }
      },
      error: function () {
        toastr.error("Could not connect to server");
        // Reset button state
        button.html('<i class="fas fa-check-circle"></i>');
        button.prop("disabled", false);
      },
    });
  });

  // Variables for pagination and filtering
  let currentPage = 1;
  const rowsPerPage = 10;
  let currentSort = "newest";
  let currentStatus = "all";
  let searchTerm = "";

  // User Row Template
  function createUserDetailContent(user) {
    return `
        <div>
          <div class="user-details-header">
            ${
              user.avatar
                ? `<img src="${user.avatar}" class="avatar-lg" alt="${user.username}">`
                : `<div class="avatar-lg avatar-placeholder mx-auto">
                 ${user.username ? user.username.charAt(0).toUpperCase() : "U"}
               </div>`
            }
            <h5 class="mb-1">${user.username}</h5>
            <div class="text-muted">${user.email}</div>
            <div class="mt-2">
              <span class="user-badge role-${user.role}">${user.role}</span>
              <span class="user-badge status-${
                user.status
              } ms-2">${user.status}</span>
            </div>
          </div>
          <div class="user-details-content">
            <!-- Personal Information -->
            <h6 class="fw-bold mb-3">Personal Information</h6>
            <div class="row">
              <div class="col-md-6">
                <div class="user-details-item">
                  <div class="user-details-label">First Name</div>
                  <div class="user-details-value">${
                    user.fname || "<em>___</em>"
                  }</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="user-details-item">
                  <div class="user-details-label">Last Name</div>
                  <div class="user-details-value">${
                    user.lname || "<em>___</em>"
                  }</div>
                </div>
              </div>
            </div>
            
            <div class="row">
                <div class="user-details-item col-md-6">
                    <div class="user-details-label">Gender</div>
                    <div class="user-details-value">${
                        user.gender || "<em>___</em>"
                    }</div>
                </div>
                
                <div class="user-details-item col-md-6">
                    <div class="user-details-label">Phone</div>
                    <div class="user-details-value">${
                        user.phone || "<em>___</em>"
                    }</div>
                </div>
            </div>
            
            <div class="user-details-item">
              <div class="user-details-label">Address</div>
              <div class="user-details-value">${
                user.address || "<em>___</em>"
              }</div>
            </div>
            
            <hr class="my-3">
            
            <!-- Account Information -->
            <h6 class="fw-bold mb-3">Account Information</h6>
            <div class="user-details-item">
              <div class="user-details-label">Registration Method</div>
              <div class="user-details-value">
                ${
                  user.provider
                    ? `<span class="provider-badge provider-${user.provider}">
                     <i class="fab fa-${user.provider}"></i> ${user.provider}
                   </span>`
                    : "Direct Registration"
                }
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="user-details-item">
                  <div class="user-details-label">Created Date</div>
                  <div class="user-details-value">${new Date(
                    user.created_at
                  ).toLocaleString()}</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="user-details-item">
                  <div class="user-details-label">Last Updated</div>
                  <div class="user-details-value">${new Date(
                    user.updated_at
                  ).toLocaleString()}</div>
                </div>
              </div>
            </div>
            
            ${
              user.bio
                ? `
              <hr class="my-3">
              <h6 class="fw-bold mb-3">Bio</h6>
              <div class="user-details-item">
                <div class="user-details-value fst-italic">${user.bio}</div>
              </div>
            `
                : ""
            }
          </div>
        </div>
      `;
  }

  // Search and filter functionality
  function applyFilters() {
    const rows = document.querySelectorAll(".user-row");
    let visibleCount = 0;
    let filteredRows = [];

    // Filter rows based on search term and status
    rows.forEach((row) => {
      const username = row
        .querySelector("td:nth-child(2)")
        .textContent.toLowerCase();
      const email = row
        .querySelector("td:nth-child(3)")
        .textContent.toLowerCase();
      const status = row.querySelector(".user-badge").textContent.toLowerCase();

      // Check if row matches search and status filters
      const matchesSearch =
        username.includes(searchTerm.toLowerCase()) ||
        email.includes(searchTerm.toLowerCase());
      const matchesStatus =
        currentStatus === "all" || status.includes(currentStatus.toLowerCase());

      if (matchesSearch && matchesStatus) {
        filteredRows.push(row);
        visibleCount++;
      }
    });

    // Apply sorting
    sortRows(filteredRows, currentSort);

    // Apply pagination
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;
    if (currentPage > totalPages) {
      currentPage = 1;
    }

    // Hide all rows first
    rows.forEach((row) => (row.style.display = "none"));

    // Show only rows for current page
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    filteredRows.slice(start, end).forEach((row) => (row.style.display = ""));

    // Update pagination
    updatePagination(totalPages);

    // Show/hide no results message
    document
      .getElementById("noResultsMessage")
      .classList.toggle("d-none", filteredRows.length > 0);
    document
      .querySelector(".users-table")
      .classList.toggle("d-none", filteredRows.length === 0);

    // Update results count
    const showing =
      filteredRows.length > 0
        ? `${start + 1}-${Math.min(end, filteredRows.length)}`
        : "0-0";
    document.getElementById("showing-results").textContent = showing;
    document.getElementById("total-results").textContent = filteredRows.length;
  }

  // Sort the rows based on selected option
  function sortRows(rows, sortBy) {
    const userRows = Array.from(rows);

    switch (sortBy) {
      case "newest":
        userRows.sort((a, b) => {
          const dateA = new Date(
            a.querySelector("td:nth-child(4)").textContent
          );
          const dateB = new Date(
            b.querySelector("td:nth-child(4)").textContent
          );
          return dateB - dateA;
        });
        break;

      case "oldest":
        userRows.sort((a, b) => {
          const dateA = new Date(
            a.querySelector("td:nth-child(4)").textContent
          );
          const dateB = new Date(
            b.querySelector("td:nth-child(4)").textContent
          );
          return dateA - dateB;
        });
        break;

      case "name_asc":
        userRows.sort((a, b) => {
          const nameA = a
            .querySelector("td:nth-child(2)")
            .textContent.toLowerCase();
          const nameB = b
            .querySelector("td:nth-child(2)")
            .textContent.toLowerCase();
          return nameA.localeCompare(nameB);
        });
        break;

      case "name_desc":
        userRows.sort((a, b) => {
          const nameA = a
            .querySelector("td:nth-child(2)")
            .textContent.toLowerCase();
          const nameB = b
            .querySelector("td:nth-child(2)")
            .textContent.toLowerCase();
          return nameB.localeCompare(nameA);
        });
        break;
    }

    // Reorder in the DOM
    const tableBody = document.getElementById("userTableBody");
    userRows.forEach((row) => tableBody.appendChild(row));

    return userRows;
  }

  // Update pagination controls
  function updatePagination(totalPages) {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    // Previous button
    const prevLi = document.createElement("li");
    prevLi.classList.add("page-item");
    if (currentPage === 1) prevLi.classList.add("disabled");
    prevLi.innerHTML = `<a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>`;
    prevLi.addEventListener("click", function (e) {
      e.preventDefault();
      if (currentPage > 1) {
        currentPage--;
        applyFilters();
      }
    });
    pagination.appendChild(prevLi);

    // Page numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

    if (endPage - startPage + 1 < maxVisiblePages) {
      startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    if (startPage > 1) {
      const firstLi = document.createElement("li");
      firstLi.classList.add("page-item");
      firstLi.innerHTML = `<a class="page-link" href="#">1</a>`;
      firstLi.addEventListener("click", function (e) {
        e.preventDefault();
        currentPage = 1;
        applyFilters();
      });
      pagination.appendChild(firstLi);

      if (startPage > 2) {
        const ellipsisLi = document.createElement("li");
        ellipsisLi.classList.add("page-item", "disabled");
        ellipsisLi.innerHTML = `<a class="page-link" href="#">...</a>`;
        pagination.appendChild(ellipsisLi);
      }
    }

    for (let i = startPage; i <= endPage; i++) {
      const li = document.createElement("li");
      li.classList.add("page-item");
      if (i === currentPage) li.classList.add("active");
      li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
      li.addEventListener("click", function (e) {
        e.preventDefault();
        currentPage = i;
        applyFilters();
      });
      pagination.appendChild(li);
    }

    if (endPage < totalPages) {
      if (endPage < totalPages - 1) {
        const ellipsisLi = document.createElement("li");
        ellipsisLi.classList.add("page-item", "disabled");
        ellipsisLi.innerHTML = `<a class="page-link" href="#">...</a>`;
        pagination.appendChild(ellipsisLi);
      }

      const lastLi = document.createElement("li");
      lastLi.classList.add("page-item");
      lastLi.innerHTML = `<a class="page-link" href="#">${totalPages}</a>`;
      lastLi.addEventListener("click", function (e) {
        e.preventDefault();
        currentPage = totalPages;
        applyFilters();
      });
      pagination.appendChild(lastLi);
    }

    // Next button
    const nextLi = document.createElement("li");
    nextLi.classList.add("page-item");
    if (currentPage === totalPages) nextLi.classList.add("disabled");
    nextLi.innerHTML = `<a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>`;
    nextLi.addEventListener("click", function (e) {
      e.preventDefault();
      if (currentPage < totalPages) {
        currentPage++;
        applyFilters();
      }
    });
    pagination.appendChild(nextLi);
  }

  // Search input event
  document.getElementById("searchInput").addEventListener("input", function () {
    searchTerm = this.value;
    currentPage = 1;
    applyFilters();
  });

  // Sort select change
  document.getElementById("sortSelect").addEventListener("change", function () {
    currentSort = this.value;
    currentPage = 1;
    applyFilters();
  });

  // Status filter change
  document
    .getElementById("statusFilter")
    .addEventListener("change", function () {
      currentStatus = this.value;
      currentPage = 1;
      applyFilters();
    });

  // Handle sortable column headers
  document.querySelectorAll("th.sortable").forEach((header) => {
    header.addEventListener("click", function () {
      const sort = this.getAttribute("data-sort");
      let sortOption;

      switch (sort) {
        case "username":
          sortOption = currentSort === "name_asc" ? "name_desc" : "name_asc";
          break;
        case "created_at":
          sortOption = currentSort === "newest" ? "oldest" : "newest";
          break;
        // Add other cases as needed
      }

      if (sortOption) {
        currentSort = sortOption;
        document.getElementById("sortSelect").value = sortOption;
        applyFilters();

        // Update header icons
        document.querySelectorAll("th.sortable i").forEach((icon) => {
          icon.className = "fas fa-sort ms-1";
        });

        const icon = this.querySelector("i");
        if (sortOption.includes("asc")) {
          icon.className = "fas fa-sort-up ms-1";
        } else {
          icon.className = "fas fa-sort-down ms-1";
        }
      }
    });
  });

  // View user details
  $(document).on("click", ".view-details", function () {
    const userId = $(this).data("id");

    // Get user details from table row for instant display
    const userRow = $(this).closest("tr");
    const username = userRow.find("td:eq(1) .fw-semibold").text().trim();

    // Show loading state
    $("#userDetailContent").html(`
        <div class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      `);

    // Fetch user details
    $.ajax({
      url: `/admin/users/info/${userId}`,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.success && response.user) {
          $("#userDetailContent").html(createUserDetailContent(response.user));

          // Store user ID for edit button
          $("#editUserFromDetails").data("id", userId);
        } else {
          $("#userDetailContent").html(`
              <div class="text-center py-5">
                <i class="fas fa-exclamation-circle text-danger fa-3x mb-3"></i>
                <h5>Error</h5>
                <p class="text-muted">Failed to load user details.</p>
              </div>
            `);
        }
      },
      error: function () {
        $("#userDetailContent").html(`
            <div class="text-center py-5">
              <i class="fas fa-exclamation-circle text-danger fa-3x mb-3"></i>
              <h5>Error</h5>
              <p class="text-muted">Could not connect to server.</p>
            </div>
          `);
      },
    });
  });

  // Edit from details view
  $("#editUserFromDetails").click(function () {
    const userId = $(this).data("id");
    $("#userDetailModal").modal("hide");

    setTimeout(() => {
      $('.edit-user[data-id="' + userId + '"]').click();
    }, 500);
  });

  // Edit user
  $(document).on("click", ".edit-user", function () {
    const userId = $(this).data("id");

    // Show loading state
    $("#updateUserContent").html(`
        <div class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      `);

    // Fetch user data for edit form
    $.ajax({
      url: `/admin/users/info/${userId}?edit=true`,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.success && response.user) {
          const user = response.user;

          $("#updateUserContent").html(`
            <form id="updateUserForm" action="POST">
              <div class="modal-header">
                <h5 class="modal-title">Edit User: ${user.username}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" value="${user.id}">
                
                <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="${
                    user.username
                }" required>
                </div>
            
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" value="${
                    user.phone || ""
                    }">
                </div>
            
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" value="${
                    user.email
                    }" required>
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role">
                                <option value="user" ${
                                user.role === "user" ? "selected" : ""
                                }>User</option>
                                <option value="admin" ${
                                user.role === "admin" ? "selected" : ""
                                }>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="active" ${
                                user.status === "active" ? "selected" : ""
                                }>Active</option>
                                <option value="suspended" ${
                                user.status === "suspended" ? "selected" : ""
                                }>Suspended</option>
                                <option value="inactive" ${
                                user.status === "inactive" ? "selected" : ""
                                }>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" data-id="${
                  user.id
                }">Update User</button>
              </div>
            </form>
            `);
        } else {
          $("#updateUserContent").html(`
              <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="alert alert-danger">Failed to load user information.</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            `);
        }
      },
      error: function () {
        $("#updateUserContent").html(`
            <div class="modal-header">
              <h5 class="modal-title">Error</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger">Could not connect to server.</div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          `);
      },
    });
  });

  // Delete user
  $(document).on("click", ".delete-user", function () {
    const userId = $(this).data("id");
    $("#confirmDeleteUser").data("id", userId);
  });

  $("#confirmDeleteUser").click(function () {
    const userId = $(this).data("id");

    // Change button state to loading
    const button = $(this);
    const originalText = button.html();
    button.html('<i class="fas fa-spinner fa-spin"></i> Deleting...');
    button.prop("disabled", true);

    $.ajax({
      url: `/admin/users/delete/${userId}`,
      method: "POST",
      success: function (response) {
        if (response.success) {
          toastr.success("User deleted successfully");
          $("#deleteUserModal").modal("hide");

          // Remove user row from table
          $(`.delete-user[data-id="${userId}"]`)
            .closest("tr")
            .fadeOut(400, function () {
              $(this).remove();
              applyFilters();
            });
        } else {
          toastr.error(response.message || "Failed to delete user");
        }
      },
      error: function () {
        toastr.error("Could not connect to server");
      },
      complete: function () {
        button.html(originalText);
        button.prop("disabled", false);
      },
    });
  });

  // Reactivate user
  $(document).on("click", ".reactivate-user", function (e) {
    e.preventDefault();
    const userId = $(this).data("id");

    $.ajax({
      url: `/admin/users/update-status/${userId}`,
      method: "POST",
      data: { status: "active" },
      success: function (response) {
        if (response.success) {
          toastr.success("User reactivated successfully");

          // Update status in table
          const row = $(`.reactivate-user[data-id="${userId}"]`).closest("tr");
          row
            .find(".user-badge")
            .removeClass("status-suspended")
            .addClass("status-active")
            .text("Active");

          // Update dropdown actions
          const dropdownMenu = row.find(".dropdown-menu");
          dropdownMenu.html(`
              <li>
                <a class="dropdown-item view-details" href="#" data-id="${userId}" data-bs-toggle="modal" data-bs-target="#userDetailModal">
                  <i class="fas fa-eye text-info"></i> View Details
                </a>
              </li>
              <li>
                <a class="dropdown-item edit-user" href="#" data-id="${userId}" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                  <i class="fas fa-edit text-primary"></i> Edit User
                </a>
              </li>
              <li>
                <a class="dropdown-item suspend-user" href="#" data-id="${userId}">
                  <i class="fas fa-ban text-warning"></i> Suspend User
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item delete-user text-danger" href="#" data-id="${userId}" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                  <i class="fas fa-trash-alt text-danger"></i> Delete User
                </a>
              </li>
            `);
        } else {
          toastr.error(response.message || "Failed to reactivate user");
        }
      },
      error: function () {
        toastr.error("Could not connect to server");
      },
    });
  });

  // Add form submission
  $("#addUserForm").submit(function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    // Change button state to loading
    const button = $(this).find('button[type="submit"]');
    const originalText = button.html();
    button.html('<i class="fas fa-spinner fa-spin me-1"></i> Creating...');
    button.prop("disabled", true);

    // console.log("Form data:", formData); // Debugging line

    $.ajax({
      url: "/admin/users/add",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          toastr.success("User added successfully");
          $("#addUserModal").modal("hide");

          // Reload page to show new user
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          toastr.warning(response.message || "Failed to add user");
        }
      },
      error: function () {
        toastr.error("Could not connect to server");
      },
      complete: function () {
        button.html(originalText);
        button.prop("disabled", false);
      },
    });
  });

  // Update user form submission
  $(document).on("submit", "#updateUserForm", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const userId = $(this).find('button[type="submit"]').data("id");

    // Change button state to loading
    const button = $(this).find('button[type="submit"]');
    const originalText = button.html();
    button.html('<i class="fas fa-spinner fa-spin me-1"></i> Updating...');
    button.prop("disabled", true);

    // console.log("Form data:", formData); // Debugging line
    $.ajax({
      url: `/admin/users/update/${userId}`,
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          toastr.success("User updated successfully");
          $("#updateUserModal").modal("hide");

        //   // Update user in table (basic info only)
        //   const row = $(`.edit-user[data-id="${userId}"]`).closest("tr");
        //   if (response.user) {
        //     const user = response.user;

        //     // Update username, status, etc. as needed
        //     row.find("td:eq(1) .fw-semibold").text(user.username);
        //     row
        //       .find(".user-badge")
        //       .removeClass()
        //       .addClass(`user-badge status-${user.status}`)
        //       .text(user.status.charAt(0).toUpperCase() + user.status.slice(1));
        //   }
          // Reload page to show updated user
          setTimeout(() => { 
            window.location.reload();
          }, 1000);
        } else {
          toastr.error(response.message || "Failed to update user");
        }
      },
      error: function () {
        toastr.error("Could not connect to server");
      },
      complete: function () {
        button.html(originalText);
        button.prop("disabled", false);
      },
    });
  });

  // Initialize toggle password visibility
  $(document).on("click", ".toggle-password", function () {
    const passwordField = $(this).closest(".input-group").find("input");
    const type =
      passwordField.attr("type") === "password" ? "text" : "password";
    passwordField.attr("type", type);
    $(this).find("i").toggleClass("fa-eye fa-eye-slash");
  });

  // Initial apply filters to setup pagination
  applyFilters();
});
