$(document).ready(function () {
  // Search functionality
  $("#searchInput").on("keyup", function () {
    const searchTerm = $(this).val().toLowerCase();
    filterPosts();
  });

  // Category filter
  $("#categoryFilter").on("change", function () {
    filterPosts();
  });

  // Sorting functionality
  $(".sortable").click(function () {
    const sortBy = $(this).data("sort");
    const currentIcon = $(this).find("i");

    // Reset all sort icons
    $(".sortable i").removeClass("fa-sort-up fa-sort-down").addClass("fa-sort");

    if (
      currentIcon.hasClass("fa-sort") ||
      currentIcon.hasClass("fa-sort-down")
    ) {
      currentIcon.removeClass("fa-sort fa-sort-down").addClass("fa-sort-up");
      sortTable(sortBy, "asc");
    } else {
      currentIcon.removeClass("fa-sort fa-sort-up").addClass("fa-sort-down");
      sortTable(sortBy, "desc");
    }
  });

  // Delete post
  $("#deletePostForm").submit(function (e) {
    e.preventDefault();
    const postId = $(".delete-btn").data("id");

    $.ajax({
      url: "/admin/posts/delete/" + postId,
      type: "POST",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          toastr.success(response.message);
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          toastr.error(response.message);
        }
      },
      error: function () {
        toastr.error("Failed to delete post. Please try again.");
      },
    });
  });

  // Set post ID on delete button click
  $(".delete-btn").click(function () {
    const postId = $(this).data("id");
    $("#deletePostForm").data("post-id", postId);
  });

  // Function to filter posts
  function filterPosts() {
    const searchTerm = $("#searchInput").val().toLowerCase();
    const categoryId = $("#categoryFilter").val();
    let visibleRows = 0;

    $(".post-row").each(function () {
      const title = $(this).find(".post-title span").text().toLowerCase();
      const author = $(this).find("td:nth-child(3)").text().toLowerCase();
      const row = $(this);

      if (title.includes(searchTerm) || author.includes(searchTerm)) {
        row.removeClass("d-none");
        visibleRows++;
      } else {
        row.addClass("d-none");
      }
    });

    if (visibleRows === 0) {
      $("#noResultsMessage").removeClass("d-none");
    } else {
      $("#noResultsMessage").addClass("d-none");
    }
  }

  // Function to sort table
  function sortTable(column, direction) {
    const rows = $(".post-row").get();

    rows.sort(function (a, b) {
      let aValue, bValue;

      if (column === "id") {
        aValue = parseInt($(a).find("td:first-child").text());
        bValue = parseInt($(b).find("td:first-child").text());
      } else if (column === "title") {
        aValue = $(a).find(".post-title span").text().toLowerCase();
        bValue = $(b).find(".post-title span").text().toLowerCase();
      } else if (column === "author") {
        aValue = $(a).find("td:nth-child(3)").text().toLowerCase();
        bValue = $(b).find("td:nth-child(3)").text().toLowerCase();
      } else if (column === "views") {
        aValue = parseInt($(a).find("td:nth-child(4)").text());
        bValue = parseInt($(b).find("td:nth-child(4)").text());
      } else if (column === "created_at") {
        aValue = new Date($(a).find("td:nth-child(5)").text()).getTime();
        bValue = new Date($(b).find("td:nth-child(5)").text()).getTime();
      }

      if (direction === "asc") {
        return aValue > bValue ? 1 : -1;
      } else {
        return aValue < bValue ? 1 : -1;
      }
    });

    $.each(rows, function (index, row) {
      $("#blogTableBody").append(row);
    });
  }
});
