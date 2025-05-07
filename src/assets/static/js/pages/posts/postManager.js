$(document).ready(function () {
  // Khai báo biến toàn cục cho việc sắp xếp
  let sortState = {
    column: null,
    direction: "asc"
  };
  
  // Khởi tạo rows là tất cả các dòng trong bảng
  const rows = $(".post-row").get();
  const rowsPerPage = 10; // Số mục trên mỗi trang
  let currentPage = 1;

  // ==== Xử lý sắp xếp bảng ====
  $("th.sortable").click(function() {
    const column = $(this).data("sort");
    handleSort(column);
  });
  
  function handleSort(column) {
    // Reset tất cả các header
    $("th.sortable").removeClass("asc desc");
    $("th.sortable i").attr("class", "fas fa-sort ms-1").css("opacity", "0.2");

    // Cập nhật trạng thái sắp xếp
    if (sortState.column === column) {
      sortState.direction = sortState.direction === "asc" ? "desc" : "asc";
    } else {
      sortState.column = column;
      sortState.direction = "asc";
    }

    // Cập nhật giao diện của header đang được sắp xếp
    const currentHeader = $(`th[data-sort="${column}"]`);
    currentHeader.addClass(sortState.direction);
    currentHeader.find("i").attr("class", 
      `fas fa-sort-${sortState.direction === "asc" ? "up" : "down"} ms-1`
    ).css("opacity", "1");

    // Tiến hành sắp xếp dữ liệu
    sortTable();
    
    // Cập nhật hiển thị của bảng sau khi sắp xếp
    updateTable();
  }

  function sortTable() {
    const column = sortState.column;
    const direction = sortState.direction;
    
    if (!column) return;

    // Định nghĩa mapping từ tên cột sang số thứ tự cột
    const columnMap = {
      "id": 0,
      "title": 1,
      "author": 2,
      "views": 3,
      "created_at": 4
    };
    
    const columnIndex = columnMap[column];
    
    // Sắp xếp mảng rows
    rows.sort(function(a, b) {
      let aValue = getCellValue(a, columnIndex);
      let bValue = getCellValue(b, columnIndex);
      
      // Xử lý các kiểu dữ liệu khác nhau
      switch(column) {
        case "id":
        case "views":
          // Sắp xếp số
          aValue = parseInt(aValue, 10) || 0;
          bValue = parseInt(bValue, 10) || 0;
          return direction === "asc" ? aValue - bValue : bValue - aValue;
          
        case "created_at":
          // Sắp xếp ngày tháng
          aValue = new Date(aValue).getTime() || 0;
          bValue = new Date(bValue).getTime() || 0;
          return direction === "asc" ? aValue - bValue : bValue - aValue;
          
        default:
          // Sắp xếp chuỗi
          return direction === "asc" 
            ? aValue.localeCompare(bValue)
            : bValue.localeCompare(aValue);
      }
    });
    
    // Áp dụng thứ tự mới vào DOM
    const tbody = $("#blogTableBody");
    $.each(rows, function(index, row) {
      tbody.append(row);
    });
  }
  
  function getCellValue(row, index) {
    // Trích xuất giá trị từ ô cụ thể
    let cell = $(row).find("td").eq(index);
    
    // Xử lý trường hợp đặc biệt cho title (vì có thể chứa hình ảnh)
    if (index === 1) { // Cột title
      return $(cell).find("span").text().trim();
    }
    
    return $(cell).text().trim();
  }
  
  // ==== Xử lý tìm kiếm và phân trang ====
  function updateTable() {
    // Lọc các dòng theo từ khóa tìm kiếm
    const searchTerm = $("#searchInput").val().toLowerCase();
    const filteredRows = rows.filter(function(row) {
      const title = $(row).find(".post-title span").text().toLowerCase();
      return title.includes(searchTerm);
    });
    
    // Hiển thị thông báo không có kết quả nếu cần
    if (filteredRows.length === 0) {
      $("#noResultsMessage").removeClass("d-none");
      $("#pagination").hide();
    } else {
      $("#noResultsMessage").addClass("d-none");
      $("#pagination").show();
    }
    
    // Tính toán phân trang
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    if (currentPage > totalPages) {
      currentPage = Math.max(1, totalPages);
    }
    
    // Ẩn tất cả các dòng
    $(rows).hide();
    
    // Hiển thị các dòng của trang hiện tại
    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = Math.min(startIndex + rowsPerPage, filteredRows.length);
    
    for (let i = startIndex; i < endIndex; i++) {
      $(filteredRows[i]).show();
    }
    
    // Cập nhật điều khiển phân trang
    updatePagination(totalPages);
  }
  
  function updatePagination(totalPages) {
    const pagination = $("#pagination");
    pagination.empty();
    
    if (totalPages <= 1) return;
    
    // Nút Previous
    let prevLi = $("<li>").addClass("page-item");
    if (currentPage === 1) prevLi.addClass("disabled");
    
    $("<a>")
      .addClass("page-link")
      .html("&laquo;")
      .attr("href", "#")
      .on("click", function(e) {
        e.preventDefault();
        if (currentPage > 1) {
          currentPage--;
          updateTable();
        }
      })
      .appendTo(prevLi);
    
    pagination.append(prevLi);
    
    // Số trang
    for (let i = 1; i <= totalPages; i++) {
      let li = $("<li>").addClass("page-item");
      if (i === currentPage) li.addClass("active");
      
      $("<a>")
        .addClass("page-link")
        .text(i)
        .attr("href", "#")
        .on("click", function(e) {
          e.preventDefault();
          currentPage = i;
          updateTable();
        })
        .appendTo(li);
      
      pagination.append(li);
    }
    
    // Nút Next
    let nextLi = $("<li>").addClass("page-item");
    if (currentPage === totalPages) nextLi.addClass("disabled");
    
    $("<a>")
      .addClass("page-link")
      .html("&raquo;")
      .attr("href", "#")
      .on("click", function(e) {
        e.preventDefault();
        if (currentPage < totalPages) {
          currentPage++;
          updateTable();
        }
      })
      .appendTo(nextLi);
    
    pagination.append(nextLi);
  }
  
  // Xử lý tìm kiếm
  $("#searchInput").on("keyup", function() {
    currentPage = 1; // Reset về trang đầu tiên khi tìm kiếm
    updateTable();
  });
  
  // Hiệu ứng hover cho các tiêu đề có thể sắp xếp
  $("th.sortable").hover(
    function() {
      if (!$(this).hasClass("asc") && !$(this).hasClass("desc")) {
        $(this).find("i").css("opacity", "0.5");
      }
    },
    function() {
      if (!$(this).hasClass("asc") && !$(this).hasClass("desc")) {
        $(this).find("i").css("opacity", "0.2");
      }
    }
  );
  
  // Khởi tạo bảng lần đầu
  updateTable();
  
  // =========================
  // Các phần xử lý form đã có
  // =========================
  
  // Add post functionality
  $("#addPostForm").submit(function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      url: "/admin/posts/add",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          toastr.success(response.message);
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          toastr.error(response.message || "Failed to create post");
        }
      },
      error: function () {
        toastr.error("Failed to add post. Please try again.");
      },
    });
  });

  // Set post ID for deletion
  $(".delete-btn").click(function () {
    const postId = $(this).data("id");
    const deleteButton = document
      .getElementById("deletePostForm")
      .querySelector("button[type='submit']");
    deleteButton.setAttribute("data-id", postId);
  });
});

// Handle delete post form submission
document
  .getElementById("deletePostForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const submitButton = this.querySelector("button[type='submit']");
    const postId = submitButton.getAttribute("data-id");

    // Show loading state
    submitButton.disabled = true;
    submitButton.innerHTML =
      '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Deleting...';

    console.log("Deleting post with ID:", postId);
    $.ajax({
      url: `/admin/posts/delete/${postId}`,
      type: "POST",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          toastr.success(response.message);
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          toastr.error(response.message || "Failed to delete post");
        }
      },
      error: function () {
        toastr.error("Failed to delete post. Please try again.");
      },
      complete: function () {
        // Reset button state
        submitButton.disabled = false;
        submitButton.innerHTML = "Delete";
      },
    });
  });
