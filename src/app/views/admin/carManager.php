<!-- Modal -->
<style>
  label {
    font-weight: bold;
  }
</style>

<!-- Hiển thị danh sách xe -->
<div class="container mt-4">
  <div class="my-3">
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
    <tbody>
      <?php foreach ($list_cars as $car) : ?>
        <tr>
          <td><?= htmlspecialchars($car['id']) ?></td>
          <td><?= htmlspecialchars($car['name']) ?></td>
          <td><?= htmlspecialchars($car['location']) ?></td>
          <td><?= htmlspecialchars($car['fuel_type']) ?></td>
          <td>$<?= number_format($car['price'], 2) ?></td>
          <td class="text-center">
            <button type="button" class="btn btn-info details-btn" data-id="<?= htmlspecialchars($car['id']) ?>" data-bs-toggle="modal" data-bs-target="#carDetailModal">Details</button>
            <button type="button" class="btn btn-primary">Edit</button>
            <button type="button" class="btn btn-danger">Delete</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
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

<script>
  $(document).ready(function() {
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
    $(".details-btn").click(function() {
      var carId = $(this).data("id"); // Lấy ID của xe
      $.ajax({
        url: "/admin/dashboard/getCar/" + carId, // Gọi API lấy thông tin xe
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
  });
</script>