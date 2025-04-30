document.addEventListener('DOMContentLoaded', function() {
    const bioInput = document.getElementById('bio');
    const bioHtml = document.getElementById('bio-view');
    bioInput.style.display = 'none'; // Hide the original input field
    const toolBar = document.querySelector('.editor-toolbar');
    const editorContainer = document.querySelector('.editor-container');
    const toggleEditBtn = document.getElementById('toggleEdit');
    const cancelEditBtn = document.getElementById('cancelEdit');
    const formActions = document.querySelector('.form-actions');
    const allInputs = document.querySelectorAll('input, select, textarea');

    toolBar.style.display = 'none'; // Hide toolbar initially
    editorContainer.style.display = 'none'; // Hide editor container initially
    // Store original values when page loads
    const originalValues = {};
    allInputs.forEach(input => {
        if (input.type === 'select-one') {
            originalValues[input.id] = input.selectedIndex;
        } else if (input.type === 'checkbox' || input.type === 'radio') {
            originalValues[input.id] = input.checked;
        } else {
            originalValues[input.id] = input.value;
        }
    });

    function toggleEditMode(enabled) {
        isEdit = enabled;
        allInputs.forEach(input => {
            input.disabled = !enabled;
        });
        formActions.style.display = enabled ? 'flex' : 'none';
        toggleEditBtn.style.display = enabled ? 'none' : 'flex';
    }

    toggleEditBtn.addEventListener('click', function() {
        toggleEditMode(true);
        bioHtml.style.display = 'none'; // Hide the HTML view of bio
        toolBar.style.display = 'block'; // Show toolbar when in edit mode
        editorContainer.style.display = 'block'; // Show editor container when in edit mode
    });

    cancelEditBtn.addEventListener('click', function() {
        // Reset form values to original
        bioHtml.style.display = 'block'; // Show the HTML view of bio
        editorContainer.parentNode.querySelector('.editor-content').innerHTML = originalValues['bio'] || ''; // Reset editor content
        editorContainer.style.display = 'none'; // Hide editor container
        toolBar.style.display = 'none'; // Hide toolbar when canceling edit

        allInputs.forEach(input => {
            if (input.type === 'select-one') {
                input.selectedIndex = originalValues[input.id];
            } else if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = originalValues[input.id];
            } else {
                input.value = originalValues[input.id];
            }
        });

        // Switch back to view mode
        toggleEditMode(false);
    });

    // Initialize form in view mode
    toggleEditMode(false);
});
$(document).ready(function() {
    $('#profileForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        const bio = $('#editorContent').val(); // Get the value from the editor
        $('#bio').val(bio); // Set the value back to the hidden input field

        // Show loading effect
        const formActions = $('.form-actions');
        const originalContent = formActions.html(); // Store original buttons
        
        // Replace buttons with loading effect
        formActions.html(`
            <button class="btn btn-primary"><i class="fas fa-spinner fa-spin"></i> Saving changes...</button>
        `);

        // Perform your AJAX request here
        setTimeout(() => {
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                // trừ trường editorContent ra khỏi data
                data: $(this).serializeArray().filter(item => item.name !== 'editorContent'),
                dataType: 'json',
                success: function(response) {
                    if (typeof toastr !== "undefined") {
                        response.success
                          ? toastr.success(response.message)
                          : toastr.error(response.message);
                    } else {
                        alert(response.message);
                    }
                    setTimeout(() => {
                        // Reset form actions to original state
                        location.reload(); // Reload the page to reflect changes
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    if (typeof toastr !== "undefined") {
                        toastr.error("An error occurred while saving changes.");
                    } else {
                        alert("An error occurred while saving changes.");
                    }
                },
                complete: function() {
                    // Reset form actions to original state
                    formActions.html(originalContent);
                }
            });
        }, 1500);
    });
});