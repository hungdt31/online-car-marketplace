<style>
  <?php
  RenderSystem::renderOne('assets', 'static/css/cars/carManager.css');
  ?>
</style>

<div class="container-fluid px-4 py-5">
  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <h4 class="mb-0">Car Management Dashboard</h4>
    <p class="text-white-50 mt-2 mb-2">Manage your vehicle inventory</p>
  </div>

  <!-- Control Bar -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <!-- Search Bar -->
    <div class="search-wrapper">
      <i class="fas fa-search search-icon"></i>
      <input type="text" id="searchInput" class="form-control" placeholder="Search cars...">
    </div>

    <!-- Add New Car Button -->
    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-add">
      <i class="fas fa-plus-circle me-2"></i>Add New Car
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
          <th class="py-3 sortable" data-sort="location">
            Location
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="fuel_type">
            Fuel Type
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="py-3 sortable" data-sort="price">
            Price
            <i class="fas fa-sort ms-1"></i>
          </th>
          <th class="text-center py-3">Actions</th>
        </tr>
      </thead>
      <tbody id="carTableBody">
        <?php foreach ($list_cars as $car) : ?>
          <tr class="car-row">
            <td class="align-middle"><?= htmlspecialchars($car['id']) ?></td>
            <td class="car-name align-middle"><?= htmlspecialchars($car['name']) ?></td>
            <td class="align-middle">
              <i class="fas fa-map-marker-alt text-muted me-2"></i>
              <?= htmlspecialchars($car['location']) ?>
            </td>
            <td class="align-middle">
              <span class="status-badge bg-light">
                <?= htmlspecialchars($car['fuel_type']) ?>
              </span>
            </td>
            <td class="price-column align-middle">$<?= number_format($car['price']) ?></td>
            <td class="text-center align-middle">
              <div class="action-buttons">
                <button type="button" class="btn btn-info details-btn" data-id="<?= htmlspecialchars($car['id']) ?>" data-bs-toggle="modal" data-bs-target="#carDetailModal">
                  <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-primary edit-btn" data-id="<?= htmlspecialchars($car['id']) ?>" data-bs-toggle="modal" data-bs-target="#updateCarModal">
                  <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger delete-btn" data-id="<?= htmlspecialchars($car['id']) ?>" data-bs-toggle="modal" data-bs-target="#deleteCarModal">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p id="noResultsMessage" class="text-center text-muted py-5 d-none">
      <i class="fas fa-search me-2"></i>No matching cars found
    </p>
  </div>

  <!-- Pagination -->
  <nav>
    <ul class="pagination justify-content-center" id="pagination">
      <!-- JS will populate this -->
    </ul>
  </nav>
</div>

<!-- Modal thêm xe mới -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addCarForm" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Register a New Car</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter car name" required>
          </div>

          <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter location">
          </div>

          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="fuel_type" class="form-label">Fuel Type</label>
              <select class="form-control" id="fuel_type" name="fuel_type" default="Petrol">
                <option value="Petrol">Petrol</option>
                <option value="Diesel">Diesel</option>
                <option value="Electric">Electric</option>
                <option value="Hybrid">Hybrid</option>
              </select>
            </div>

            <div class="mb-3 col-md-6">
              <label for="drive_type" class="form-label">Drive Type</label>
              <select class="form-control" id="drive_type" name="drive_type" default="Manual">
                <option value="Self">Self</option>
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label for="mileage" class="form-label">Mileage</label>
            <input type="text" class="form-control" id="mileage" name="mileage" placeholder="Enter mileage (e.g., 15 km/l)">
          </div>



          <div class="mb-3">
            <label for="service_duration" class="form-label">Service Duration</label>
            <input type="text" class="form-control" id="service_duration" name="service_duration" placeholder="Enter service duration (e.g., 6 months)">
          </div>

          <div class="mb-3">
            <label for="body_weight" class="form-label">Body Weight</label>
            <input type="text" class="form-control" id="body_weight" name="body_weight" placeholder="Enter body weight (e.g., 1200 kg)">
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Enter price (e.g., 15000.00)" required step="0.01">
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

<!-- Modal xem chi tiết xe -->
<div class="modal fade" id="carDetailModal" tabindex="-1" aria-labelledby="carDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" id="carDetail">
    </div>
  </div>
</div>

<!-- Modal chỉnh sửa thông tin xe -->
<div class="modal fade" id="updateCarModal" tabindex="-1" aria-labelledby="updateCarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="updateCarForm" method="post">
      <div class="modal-content" id="updateCar">
      </div>
    </form>
  </div>
</div>

<!-- Modal xóa xe -->
<div class="modal fade" id="deleteCarModal" tabindex="-1" aria-labelledby="deleteCarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteCarForm" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteCarModalLabel">Delete Car</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this car?</p>
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
    // thêm xe mới
    $("#addCarForm").submit(function(event) {
      event.preventDefault(); // Ngăn chặn form gửi theo cách thông thường

      $.ajax({
        url: "/admin/cars/addCar", // Action của form
        type: "POST",
        data: $(this).serialize(), // Lấy dữ liệu từ form
        dataType: "json",
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            setTimeout(function() {
              location.reload(); // Load lại trang sau khi hiển thị thông báo
            }, 1000); // Chờ 1 giây để người dùng thấy thông báo
          } else {
            toastr.error(response.message);
          }
        },
        error: function() {
          alert("Failed to add car. Please try again.");
        },
      });
    });
    // xem chi tiết xe
    $(".details-btn").click(function() {
      var carId = $(this).data("id"); // Lấy ID của xe
      $.ajax({
        url: "/admin/cars/getCar/" + carId, // Gọi API lấy thông tin xe
        type: "GET",
        dataType: "html",
        success: function(response) {
          $('#carDetail').html(response);
        },
        error: function() {
          toastr.error("Failed to get car details.");
        }
      });
    });
    // chỉnh sửa thông tin xe
    $(".edit-btn").click(function() {
      var carId = $(this).data("id"); // Lấy ID của xe
      $.ajax({
        url: "/admin/cars/getCar/" + carId, // Gọi API lấy thông tin xe
        type: "GET",
        data: {
          'getToUpdate': true
        },
        dataType: "html",
        success: function(response) {
          $('#updateCar').html(response);
        },
        error: function() {
          toastr.error("Failed to get car details.");
        }
      });
    });
    // xóa xe
    $(".delete-btn").click(function() {
      var carId = $(this).data("id"); // Lấy ID của xe
      var deleteButton = document.getElementById("deleteCarForm").querySelector("button[type='submit']");
      deleteButton.setAttribute("data-id", carId); // Gán ID vào nút xác nhận xóa
    });
  });
  document.getElementById("updateCarForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Ngăn trang load lại

    let formData = new FormData(this);
    let xhr = new XMLHttpRequest();

    let submitButton = this.querySelector("button[type='submit']");
    let id = submitButton.getAttribute("data-id");

    xhr.open("POST", `/admin/cars/editCar/${id}`, true);

    // Khi request hoàn thành
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

    // Xử lý lỗi mạng
    xhr.onerror = function() {
      toastr.error("Error! " + xhr.statusText);
    };

    xhr.send(formData);
  });
  document.getElementById("deleteCarForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Ngăn trang load lại

    let formData = new FormData(this);
    let xhr = new XMLHttpRequest();

    let submitButton = this.querySelector("button[type='submit']");
    let id = submitButton.getAttribute("data-id");

    xhr.open("POST", `/admin/cars/deleteCar/${id}`, true);

    // Khi request hoàn thành
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

    // Xử lý lỗi mạng
    xhr.onerror = function() {
      toastr.error("Error! " + xhr.statusText);
    };

    xhr.send(formData);
  });
  document.addEventListener("DOMContentLoaded", function() {
    // Variables for pagination and sorting
    const rowsPerPage = 10; // Number of items per page
    const rows = document.querySelectorAll(".car-row");
    const searchInput = document.getElementById("searchInput");
    const pagination = document.getElementById("pagination");
    const noResultsMessage = document.getElementById("noResultsMessage");
    const tableBody = document.getElementById("carTableBody");
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
      'location': {
        index: 2,
        type: 'string'
      },
      'fuel_type': {
        index: 3,
        type: 'string'
      },
      'price': {
        index: 4,
        type: 'currency'
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
        case 'currency':
          return parseFloat(rawValue.replace(/[$,]/g, '')) || 0;
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
      const rowsArray = Array.from(tableBody.querySelectorAll('tr.car-row'));
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
        // Search through name, location, and fuel type
        const name = row.querySelector(".car-name").textContent.toLowerCase();
        const location = row.cells[2].textContent.toLowerCase();
        const fuelType = row.cells[3].textContent.toLowerCase();

        return name.includes(searchTerm) ||
          location.includes(searchTerm) ||
          fuelType.includes(searchTerm);
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
      const maxVisiblePages = 5; // Maximum number of page buttons to show
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
</script>