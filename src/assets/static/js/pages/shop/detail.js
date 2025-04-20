document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating i');
    const ratingInput = document.getElementById('commentRating');

    // Function to update stars
    function updateStars(rating) {
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-rating'));
            if (starValue <= rating) {
                star.classList.remove('far');
                star.classList.add('fas', 'text-warning');
            } else {
                star.classList.remove('fas', 'text-warning');
                star.classList.add('far');
            }
        });
        ratingInput.value = rating;
    }

    // Add click event to stars
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            updateStars(rating);
        });

        // Add hover effects
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));

            stars.forEach(s => {
                const starValue = parseInt(s.getAttribute('data-rating'));
                if (starValue <= rating) {
                    s.classList.add('hover');
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            stars.forEach(s => {
                s.classList.remove('hover');
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
            input.classList.add('is-invalid');
            input.value = ''; // Clear the input
            clearFilePreview();
            return false;
        } else {
            // Clear error if previously shown
            input.classList.remove('is-invalid');
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
    const previewContainer = document.getElementById('filePreviewContainer');
    const previewElement = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    // Show the preview container
    previewContainer.style.display = 'block';

    // Set file information
    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);

    // Clear previous preview
    previewElement.innerHTML = '';

    // Create preview based on file type
    if (file.type.startsWith('image/')) {
        // Create image preview
        const img = document.createElement('img');
        img.style.maxHeight = '80px';
        img.style.maxWidth = '100px';
        img.style.borderRadius = '4px';

        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);

        previewElement.appendChild(img);

    } else if (file.type.startsWith('video/')) {
        // Create video icon for video files
        const icon = document.createElement('i');
        icon.className = 'fas fa-file-video fa-3x text-primary';
        previewElement.appendChild(icon);
    }
}

function clearFileUpload() {
    const fileInput = document.getElementById('commentFile');
    fileInput.value = '';
    clearFilePreview();
}

function clearFilePreview() {
    const previewContainer = document.getElementById('filePreviewContainer');
    previewContainer.style.display = 'none';
}

function formatFileSize(bytes) {
    if (bytes < 1024) return bytes + ' bytes';
    else if (bytes < 1048576) return (bytes / 1024).toFixed(2) + ' KB';
    else return (bytes / 1048576).toFixed(2) + ' MB';
}