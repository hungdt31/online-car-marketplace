document.addEventListener("DOMContentLoaded", function() {
    const editBtn = document.getElementById("editBtn");
    const cancelBtn = document.getElementById("cancelBtn");
    const saveBtn = document.getElementById("saveBtn");
    const form = document.getElementById("postForm");
    const inputs = form.querySelectorAll("input:not([type=hidden]):not([type=file])");
    const statusSelect = document.getElementById("status");
    const coverImageInput = document.getElementById("coverImage");
    const imagePreview = document.getElementById("imagePreview");
    const uploadBtn = document.getElementById("uploadBtn");
    const imageUpload = document.getElementById("imageUpload");
    const contentView = document.getElementById("contentView");
    const editorContainer = document.querySelector(".editor-container");

    // Store original values
    const originalValues = {};
    inputs.forEach(input => {
        originalValues[input.id] = input.value;
    });
    originalValues["status"] = statusSelect.value;

    // Original image source
    const originalImageSrc = imagePreview.src;
    let originalContent = contentView.innerHTML;
    let editor = null;

    // Handle file upload button
    uploadBtn.addEventListener("click", function() {
        imageUpload.click();
    });

    // Handle file selection
    imageUpload.addEventListener("change", function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                // Preview the image
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    });

    // Update image preview when cover image URL changes
    coverImageInput.addEventListener("input", function() {
        if (this.value.trim() !== "") {
            imagePreview.src = this.value;
        }
    });

    // Edit button functionality
    editBtn.addEventListener("click", async function() {
        // Show spinner while loading editor
        editBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
        editBtn.disabled = true;

        // Enable form inputs
        inputs.forEach(input => {
            input.disabled = false;
        });
        statusSelect.disabled = false;

        uploadBtn.disabled = false;

        // Show editor, hide content view
        contentView.style.display = "none";
        editorContainer.style.display = "block";

        // Update button states
        editBtn.style.display = "none";
        cancelBtn.style.display = "inline-block";
        saveBtn.style.display = "inline-block";

        // Reset edit button state (in case user cancels and tries again)
        editBtn.innerHTML = '<i class="fas fa-edit me-2"></i>Edit';
        editBtn.disabled = false;
    });

    // Cancel button functionality
    cancelBtn.addEventListener("click", function() {
        const editorContent = document.querySelector(".editor-container .tiptap");
        // Reset to original values
        inputs.forEach(input => {
            input.value = originalValues[input.id];
            input.disabled = true;
        });
        statusSelect.value = originalValues["status"];
        statusSelect.disabled = true;

        // Reset image
        imagePreview.src = originalImageSrc;
        uploadBtn.disabled = true;
        imageUpload.value = "";

        // Hide editor, restore content view
        editorContainer.style.display = "none";
        contentView.style.display = "block";
        contentView.innerHTML = originalContent;

        if (editorContent) {
            editorContent.innerHTML = originalContent;
        }

        // Cleanup editor if it exists
        if (editor && typeof editor.destroy === 'function') {
            editor.destroy();
            editor = null;
        }

        // Update button states
        editBtn.style.display = "inline-block";
        cancelBtn.style.display = "none";
        saveBtn.style.display = "none";

        // Show toast notification
        showToast('Changes discarded', 'info');
    });

    // Save button functionality with jQuery AJAX
    saveBtn.addEventListener("click", function() {
        // Collect form data
        const postId = document.getElementById("postId").value;
        const title = document.getElementById("title").value;
        const cover_image_id = $(this).data("cover-image-id");
        
        // Get content from editor or fallback
        let content;
        if (document.getElementById("editorContent")) {
            content = document.getElementById("editorContent").value;
        } else if (document.getElementById("fallbackEditor")) {
            content = document.getElementById("fallbackEditor").value;
        } else {
            const editorContent = document.querySelector(".editor-container .tiptap");
            content = editorContent ? editorContent.innerHTML : contentView.innerHTML;
        }
        
        // Create form data object for file upload
        const formData = new FormData();
        formData.append("id", postId);
        formData.append("title", title);
        formData.append("content", content);
        formData.append("cover_image_id", cover_image_id);
        formData.append("status", statusSelect.value);
        
        // If a file was selected, add it to the form data
        if (imageUpload.files && imageUpload.files[0]) {
            formData.append("cover_image", imageUpload.files[0]);
        } else {
            // Otherwise use the URL
            formData.append("cover_image_url", coverImageInput.value);
        }
        
        // Show loading state with elegant animation
        $(saveBtn).prop('disabled', true)
                  .html('<i class="fas fa-spinner fa-spin me-1"></i><span>Saving...</span>')
                  .addClass('position-relative overflow-hidden');
        
        // console.log("Form data:", formData); // Debugging line
        // Send jQuery AJAX request
        $.ajax({
            url: "/admin/posts/update/" + postId,
            type: "POST",
            data: formData,
            dataType: "json",
            // These two settings are crucial for FormData objects:
            processData: false,  // Don't process the data
            contentType: false,  // Don't set content type (browser will set it to multipart/form-data)
            success: function(data) {
                // console.log("Response data:", data); // Debugging line
                if (data.success) {
                    // Show success toast
                    showToast(data.message, 'success', 1000);
                    setTimeout(function() {
                        // Redirect to the post detail page after a short delay
                        window.location.href = "/blogs-management/details/" + postId;
                    }, 2000); // 2 seconds delay
                } else {
                    // Show error toast with server message
                    showToast(data.message || 'Failed to update post. Please try again.', 'error', 0);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error updating post:", error);
                
                // Try to parse error message from response if available
                let errorMsg = 'Failed to update post. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                // Show detailed error toast
                showToast(errorMsg, 'error', 5000);
            },
            complete: function() {
                // Re-enable the save button and reset its state
                $(saveBtn).prop('disabled', false)
                          .html('<i class="fas fa-save me-2"></i>Save')
                          .removeClass('position-relative overflow-hidden');
            }
        });
    });

    // Helper function to show toast messages
    function showToast(message, type = 'success', delay = 3000) {
        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector(".toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.className = "toast-container position-fixed bottom-0 end-0 p-3";
            toastContainer.style.zIndex = "5";
            document.body.appendChild(toastContainer);
        }

        // Set toast color based on type
        let bgClass = 'bg-success';
        let icon = 'fa-check-circle';

        if (type === 'error') {
            bgClass = 'bg-danger';
            icon = 'fa-exclamation-circle';
        } else if (type === 'info') {
            bgClass = 'bg-info';
            icon = 'fa-info-circle';
        }

        // Create toast HTML
        const toastHtml = `
        <div class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas ${icon} me-2"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

        // Add toast to container
        toastContainer.insertAdjacentHTML("beforeend", toastHtml);

        // Initialize and show the toast
        const toastElement = toastContainer.lastElementChild;
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: delay
        });
        toast.show();

        // Remove toast after it's hidden
        toastElement.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    }

     // Toggle button state when clicked
     $(document).on('click', '.category-item', function() {
        const button = $(this);
        const checkbox = button.find('input[type="checkbox"]');
        const categoryId = button.data('id');
        const dataName = button.data('name');
        const blogId = $('input[name="blog_id"]').val();
        const isCurrentlySelected = button.hasClass('btn-outline-primary');
        
        // Toggle visual appearance immediately for better UX
        if (isCurrentlySelected) {
            button.removeClass('btn-outline-primary').addClass('btn-outline-secondary');
            checkbox.prop('checked', false);
        } else {
            button.removeClass('btn-outline-secondary').addClass('btn-outline-primary');
            checkbox.prop('checked', true);
        }
        
        // Update counter immediately for better UX
        updateSelectedCount();
        
        // Show a subtle loading indicator on the button
        const originalContent = button.html();
        if (!isCurrentlySelected) {
            // Only show spinner when selecting (not when deselecting)
            button.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>' + 
                        button.text());
        }
        
        // Disable button during the request
        button.prop('disabled', true);
        
        // Make AJAX call to update the category in real-time
        $.ajax({
            url: '/admin/posts/toggleCategory',
            type: 'POST',
            data: {
                blog_id: Number(blogId),
                category_id: Number(categoryId),
                action: isCurrentlySelected ? 'remove' : 'add'
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);  
                if (response.success) {
                    // Show success message
                    if (isCurrentlySelected) {
                        toastr.info('Category ' + dataName + ' removed');
                    } else {
                        toastr.success('Category ' + dataName + ' added');
                    }
                } else {
                    // If the request failed, revert the visual change
                    if (isCurrentlySelected) {
                        button.removeClass('btn-outline-secondary').addClass('btn-outline-primary');
                        checkbox.prop('checked', true);
                    } else {
                        button.removeClass('btn-outline-primary').addClass('btn-outline-secondary');
                        checkbox.prop('checked', false);
                    }
                    
                    // Update counter again to reflect the reverted state
                    updateSelectedCount();
                    
                    // Show error message
                    toastr.error(response.message || 'Failed to update category');
                }
            },
            error: function(xhr, status, error) {
                // If the request failed, revert the visual change
                if (isCurrentlySelected) {
                    button.removeClass('btn-outline-secondary').addClass('btn-outline-primary');
                    checkbox.prop('checked', true);
                } else {
                    button.removeClass('btn-outline-primary').addClass('btn-outline-secondary');
                    checkbox.prop('checked', false);
                }
                
                // Update counter again to reflect the reverted state
                updateSelectedCount();
                
                // Show error message
                toastr.error('Network error occurred while updating category');
                console.error('AJAX error:', error);
            },
            complete: function() {
                // Restore original button content and enable it
                button.html(originalContent);
                button.prop('disabled', false);
            }
        });
    });

    // Search functionality
    $('#categorySearch').on('input', function() {
        const searchText = $(this).val().toLowerCase();
        let anyVisible = false;
        
        $('.category-item').each(function() {
            const name = $(this).data('name');
            const type = $(this).data('type');
            const typeFilter = $('#categoryTypeFilter').val();
            
            // Check if item matches both search and type filter
            const matchesSearch = name.includes(searchText);
            const matchesType = typeFilter === '' || type === typeFilter;
            const shouldShow = matchesSearch && matchesType;
            
            $(this).toggle(shouldShow);
            if (shouldShow) {
                anyVisible = true;
            }
        });
        
        // Show/hide no results message
        $('#noResults').toggleClass('d-none', anyVisible);
    });
    
    // Type filter functionality
    $('#categoryTypeFilter').on('change', function() {
        const typeFilter = $(this).val();
        let anyVisible = false;
        
        $('.category-item').each(function() {
            const type = $(this).data('type');
            const name = $(this).data('name');
            const searchText = $('#categorySearch').val().toLowerCase();
            
            // Check if item matches both search and type filter
            const matchesSearch = name.includes(searchText);
            const matchesType = typeFilter === '' || type === typeFilter;
            const shouldShow = matchesSearch && matchesType;
            
            $(this).toggle(shouldShow);
            if (shouldShow) {
                anyVisible = true;
            }
        });
        
        // Show/hide no results message
        $('#noResults').toggleClass('d-none', anyVisible);
    });

    // Update the selected categories count in the header badge
    function updateSelectedCount() {
        const count = $('input[name="categories[]"]:checked').length;
        $('#selectedCategoriesCount').text(count);
    }

    // Update selected count on load
    updateSelectedCount();
});