$(document).ready(function () {
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

document.addEventListener("DOMContentLoaded", function () {
  // Variables for pagination and sorting
  const rowsPerPage = 5; // Number of items per page
  const rows = document.querySelectorAll(".post-row");
  const searchInput = document.getElementById("searchInput");
  const pagination = document.getElementById("pagination");
  const noResultsMessage = document.getElementById("noResultsMessage");
  let currentPage = 1;
  let sortState = {
    column: null,
    direction: "asc",
  };

  // Declare all functions first
  function updatePagination(totalPages) {
    pagination.innerHTML = "";

    // Add Previous button
    if (totalPages > 1) {
      let prevLi = document.createElement("li");
      prevLi.classList.add("page-item");
      if (currentPage === 1) prevLi.classList.add("disabled");
      prevLi.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
      prevLi.addEventListener("click", function (e) {
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
      li.addEventListener("click", function (e) {
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
      nextLi.addEventListener("click", function (e) {
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
      id: 0,
      title: 1,
      author: 2,
      views: 3,
      created_at: 4,
    };

    const cell = row.cells[mapping[column]];
    return cell ? cell.textContent.trim() : "";
  }

  function sortTable(column) {
    const table = document.getElementById("blogTableBody");
    if (!table) return;

    const rows = Array.from(table.getElementsByTagName("tr"));
    const headers = document.querySelectorAll("th.sortable");

    // Reset all headers
    headers.forEach((header) => {
      header.classList.remove("asc", "desc");
      header.querySelector("i").className = "fas fa-sort ms-1";
    });

    // Update sort state
    if (sortState.column === column) {
      sortState.direction = sortState.direction === "asc" ? "desc" : "asc";
    } else {
      sortState.column = column;
      sortState.direction = "asc";
    }

    // Update header appearance
    const currentHeader = document.querySelector(`th[data-sort="${column}"]`);
    if (currentHeader) {
      currentHeader.classList.add(sortState.direction);
      currentHeader.querySelector("i").className = `fas fa-sort-${
        sortState.direction === "asc" ? "up" : "down"
      } ms-1`;
    }

    // Sort the rows
    rows.sort((a, b) => {
      let aValue = getCellValue(a, column);
      let bValue = getCellValue(b, column);

      // Handle numeric sorting
      if (column === "id" || column === "views") {
        return sortState.direction === "asc"
          ? parseInt(aValue) - parseInt(bValue)
          : parseInt(bValue) - parseInt(aValue);
      }

      // Handle date sorting
      if (column === "created_at") {
        const dateA = new Date(aValue);
        const dateB = new Date(bValue);
        return sortState.direction === "asc" ? dateA - dateB : dateB - dateA;
      }

      // String comparison for other columns
      return sortState.direction === "asc"
        ? aValue.localeCompare(bValue)
        : bValue.localeCompare(aValue);
    });

    // Reorder the table
    rows.forEach((row) => table.appendChild(row));
  }

  // Define updateTable function
  function updateTable() {
    const filter = searchInput.value.toLowerCase();
    const filteredRows = Array.from(rows).filter((row) =>
      row
        .querySelector(".post-title")
        .textContent.toLowerCase()
        .includes(filter)
    );

    // Show no results message if needed
    noResultsMessage.classList.toggle("d-none", filteredRows.length > 0);

    // Calculate pagination
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    if (currentPage > totalPages) {
      currentPage = totalPages || 1;
    }

    // Update display
    filteredRows.forEach((row, index) => {
      row.style.display =
        index >= (currentPage - 1) * rowsPerPage &&
        index < currentPage * rowsPerPage
          ? ""
          : "none";
    });

    // Update pagination controls
    updatePagination(totalPages);

    // Apply sorting if a column is selected
    if (sortState.column) {
      sortTable(sortState.column);
    }
  }

  // Add click event listeners to sortable headers
  document.querySelectorAll("th.sortable").forEach((header) => {
    header.addEventListener("click", () => {
      const column = header.getAttribute("data-sort");
      if (column) {
        sortTable(column);
        // Re-apply pagination after sorting
        updateTable();
      }
    });

    // Add hover effect for sort indicators
    header.addEventListener("mouseover", () => {
      if (
        !header.classList.contains("asc") &&
        !header.classList.contains("desc")
      ) {
        const icon = header.querySelector("i");
        if (icon) icon.style.opacity = "0.5";
      }
    });

    header.addEventListener("mouseout", () => {
      if (
        !header.classList.contains("asc") &&
        !header.classList.contains("desc")
      ) {
        const icon = header.querySelector("i");
        if (icon) icon.style.opacity = "0.2";
      }
    });
  });

  // Search functionality
  searchInput.addEventListener("keyup", function () {
    currentPage = 1; // Reset to first page on search
    updateTable();
  });

  // Initialize rich text editors if needed
  if (typeof tinymce !== "undefined") {
    tinymce.init({
      selector: "#content",
      height: 300,
      plugins: "link image code table lists",
      toolbar:
        "undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code",
    });
  }

  // Initial table setup
  updateTable();
});
