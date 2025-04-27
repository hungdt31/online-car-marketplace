document.addEventListener("DOMContentLoaded", function () {
  const stars = document.querySelectorAll(".star-rating i");
  const ratingInput = document.getElementById("commentRating");

  // Function to update stars
  function updateStars(rating) {
    stars.forEach((star) => {
      const starValue = parseInt(star.getAttribute("data-rating"));
      if (starValue <= rating) {
        star.classList.remove("far");
        star.classList.add("fas", "text-warning");
      } else {
        star.classList.remove("fas", "text-warning");
        star.classList.add("far");
      }
    });
    ratingInput.value = rating;
  }

  // Add click event to stars
  stars.forEach((star) => {
    star.addEventListener("click", function () {
      const rating = parseInt(this.getAttribute("data-rating"));
      updateStars(rating);
    });

    // Add hover effects
    star.addEventListener("mouseenter", function () {
      const rating = parseInt(this.getAttribute("data-rating"));

      stars.forEach((s) => {
        const starValue = parseInt(s.getAttribute("data-rating"));
        if (starValue <= rating) {
          s.classList.add("hover");
        }
      });
    });

    star.addEventListener("mouseleave", function () {
      stars.forEach((s) => {
        s.classList.remove("hover");
      });
    });
  });
});

// Add this to your existing script or create a new script block
function validateFileSize(input) {
  // 5MB size limit in bytes
  const maxSize = 5 * 1024 * 1024;

  if (input.files && input.files[0]) {
    const fileSize = input.files[0].size;

    if (fileSize > maxSize) {
      // Show error
      input.classList.add("is-invalid");
      input.value = ""; // Clear the input
      clearFilePreview();
      return false;
    } else {
      // Clear error if previously shown
      input.classList.remove("is-invalid");
      return true;
    }
  }
  return true;
}

function handleFileUpload(input) {
  // Validate file size first
  if (!validateFileSize(input)) {
    return;
  }

  const file = input.files[0];
  if (!file) {
    clearFilePreview();
    return;
  }

  // Get references to preview elements
  const previewContainer = document.getElementById("filePreviewContainer");
  const previewElement = document.getElementById("filePreview");
  const fileName = document.getElementById("fileName");
  const fileSize = document.getElementById("fileSize");

  // Show the preview container
  previewContainer.style.display = "block";

  // Set file information
  fileName.textContent = file.name;
  fileSize.textContent = formatFileSize(file.size);

  // Clear previous preview
  previewElement.innerHTML = "";

  // Create preview based on file type
  if (file.type.startsWith("image/")) {
    // Create image preview
    const img = document.createElement("img");
    img.style.maxHeight = "80px";
    img.style.maxWidth = "100px";
    img.style.borderRadius = "4px";

    const reader = new FileReader();
    reader.onload = function (e) {
      img.src = e.target.result;
    };
    reader.readAsDataURL(file);

    previewElement.appendChild(img);
  } else if (file.type.startsWith("video/")) {
    // Create video icon for video files
    const icon = document.createElement("i");
    icon.className = "fas fa-file-video fa-3x text-primary";
    previewElement.appendChild(icon);
  }
}

function clearFileUpload() {
  const fileInput = document.getElementById("commentFile");
  fileInput.value = "";
  clearFilePreview();
}

function clearFilePreview() {
  const previewContainer = document.getElementById("filePreviewContainer");
  previewContainer.style.display = "none";
}

function formatFileSize(bytes) {
  if (bytes < 1024) return bytes + " bytes";
  else if (bytes < 1048576) return (bytes / 1024).toFixed(2) + " KB";
  else return (bytes / 1048576).toFixed(2) + " MB";
}

$(document).ready(function () {
  // Comment form submission
  $("#exampleModal").submit(function (event) {
    event.preventDefault();

    // Get form input values
    const commentTitle = $("#commentTitle").val().trim();
    const commentContent = $(".editor-container .editor-content").html();
    const commentRating = $("#commentRating").val();
    const fileInput = document.getElementById("commentFile");

    // Get IDs from button data attributes
    const btn = $(this).find("button.save-comment-btn");
    const userId = btn.data("user-id");
    const carId = btn.data("car-id");

    // Validate form
    if (!commentTitle || !commentContent || !commentRating) {
      if (typeof toastr !== "undefined") {
        toastr.error(
          "Please fill in all required fields: Title, Content, and Rating are required."
        );
      } else {
        alert(
          "Please fill in all required fields: Title, Content, and Rating are required."
        );
      }
      return;
    }

    // Create FormData object to handle files properly
    const formData = new FormData();
    formData.append("title", commentTitle);
    formData.append("content", commentContent);
    formData.append("rating", commentRating);
    formData.append("user_id", userId);
    formData.append("car_id", carId);

    // Only append file if one was selected
    if (fileInput && fileInput.files.length > 0) {
      formData.append("commentFile", fileInput.files[0]);
    }

    // Show loading state
    const submitBtn = $(this).find('button[type="submit"]');
    const originalBtnText = submitBtn.html();
    submitBtn.prop("disabled", true);
    submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

    setTimeout(() => {
      $.ajax({
        url: "/shop/replyCarPost",
        type: "POST",
        data: formData,
        dataType: "json",
        processData: false, // Important for FormData
        contentType: false, // Important for FormData
        success: function (result) {
          console.log(result);

          if (typeof toastr !== "undefined") {
            result.success
              ? toastr.success(result.message)
              : toastr.error(result.message);
          } else {
            alert(result.message);
          }

          // Store current scroll position in sessionStorage
          const scrollPosition =
            window.scrollY || document.documentElement.scrollTop;
          sessionStorage.setItem("scrollPosition", scrollPosition);

          // Wait 2 seconds before reloading
          setTimeout(() => {
            // Close modal first if open
            if ($("#exampleModal").hasClass("show")) {
              $("#exampleModal").modal("hide");

              // Small additional delay after modal closes
              setTimeout(() => {
                location.reload();
              }, 300);
            } else {
              // Reload directly if no modal is open
              location.reload();
            }
          }, 2000);
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);

          if (typeof toastr !== "undefined") {
            toastr.error(
              "An error occurred while submitting the comment. Please try again."
            );
          } else {
            alert(
              "An error occurred while submitting the comment. Please try again."
            );
          }
        },
        complete: function () {
          // Reset button state
          submitBtn.prop("disabled", false);
          submitBtn.html(originalBtnText);
        },
      });
    }, 1500);
  });

  // Restore scroll position if available
  if (sessionStorage.getItem("scrollPosition")) {
    // Small timeout to ensure DOM is fully loaded
    setTimeout(() => {
      window.scrollTo(0, parseInt(sessionStorage.getItem("scrollPosition")));
      sessionStorage.removeItem("scrollPosition"); // Clear stored position
    }, 100);
  }
});
