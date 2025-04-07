<!-- Modal -->
<style>
  label {
    font-weight: bold;
  }
</style>
<!-- Hiển thị danh sách xe -->
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center my-3">
    <!-- Search bar -->
    <input type="text" id="searchInput" class="form-control w-25" placeholder="Search by car name...">

    <!-- Button trigger modal -->
    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-light">
      <i class="bi bi-plus-circle"></i> Insert data
    </button>
  </div>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th class="py-3">ID</th>
        <th class="py-3">Name</th>
        <th class="py-3">Location</th>
        <th class="py-3">Fuel Type</th>
        <th class="py-3">Price</th>
        <th class="text-center py-3">Action</th>
      </tr>
    </thead>
    <tbody id="carTableBody">
      <?php foreach ($list_cars as $car) : ?>
        <tr class="car-row">
          <td><?= htmlspecialchars($car['id']) ?></td>
          <td class="car-name"><?= htmlspecialchars($car['name']) ?></td>
          <td><?= htmlspecialchars($car['location']) ?></td>
          <td><?= htmlspecialchars($car['fuel_type']) ?></td>
          <td>$<?= number_format($car['price'], 2) ?></td>
          <td class="text-center">
            <button type="button" class="btn btn-info details-btn" data-id="<?= htmlspecialchars($car['id']) ?>" data-bs-toggle="modal" data-bs-target="#carDetailModal">Details</button>
            <button type="button" class="btn btn-primary edit-btn" data-id="<?= htmlspecialchars($car['id']) ?>" data-bs-toggle="modal" data-bs-target="#updateCarModal">Edit</button>
            <button type="button" class="btn btn-danger delete-btn" data-id="<?= htmlspecialchars($car['id']) ?>" data-bs-toggle="modal" data-bs-target="#deleteCarModal">Delete</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <p id="noResultsMessage" class="text-center text-danger d-none">No matching records found.</p>

  <!-- Pagination -->
  <nav>
    <ul class="pagination justify-content-center" id="pagination">
      <!-- JS sẽ thêm số trang vào đây -->
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

          <div class="mb-3">
            <label for="fuel_type" class="form-label">Fuel Type</label>
            <select class="form-control" id="fuel_type" name="fuel_type" default="Petrol">
              <option value="Petrol">Petrol</option>
              <option value="Diesel">Diesel</option>
              <option value="Electric">Electric</option>
              <option value="Hybrid">Hybrid</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="mileage" class="form-label">Mileage</label>
            <input type="text" class="form-control" id="mileage" name="mileage" placeholder="Enter mileage (e.g., 15 km/l)">
          </div>

          <div class="mb-3">
            <label for="drive_type" class="form-label">Drive Type</label>
            <select class="form-control" id="drive_type" name="drive_type" default="Manual">
              <option value="Self">Self</option>
              <option value="Automatic">Automatic</option>
              <option value="Manual">Manual</option>
            </select>
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
        url: "/admin/dashboard/addCar", // Action của form
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
  document.getElementById("searchInput").addEventListener("keyup", function() {
    var filter = this.value.toLowerCase();
    var rows = document.querySelectorAll("#carTableBody tr");
    var found = false;

    rows.forEach(function(row) {
      var name = row.querySelector(".car-name").textContent.toLowerCase();
      if (name.includes(filter)) {
        row.style.display = "";
        found = true;
      } else {
        row.style.display = "none";
      }
    });

    document.getElementById("noResultsMessage").classList.toggle("d-none", found);
  });
  document.addEventListener("DOMContentLoaded", function() {
    var rowsPerPage = 5; // Số xe mỗi trang
    var rows = document.querySelectorAll(".car-row");
    var searchInput = document.getElementById("searchInput");
    var pagination = document.getElementById("pagination");
    var noResultsMessage = document.getElementById("noResultsMessage");
    var currentPage = 1;

    function updateTable() {
      var filter = searchInput.value.toLowerCase();
      var filteredRows = Array.from(rows).filter(row => row.querySelector(".car-name").textContent.toLowerCase().includes(filter));

      // Hiển thị thông báo nếu không tìm thấy xe
      noResultsMessage.classList.toggle("d-none", filteredRows.length > 0);

      // Tính toán số trang
      var totalPages = Math.ceil(filteredRows.length / rowsPerPage);
      if (currentPage > totalPages) currentPage = totalPages || 1;

      // Cập nhật hiển thị
      filteredRows.forEach((row, index) => {
        row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
      });

      updatePagination(totalPages);
    }

    function updatePagination(totalPages) {
      pagination.innerHTML = "";

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
    }

    searchInput.addEventListener("keyup", updateTable);
    updateTable();
  });
</script>