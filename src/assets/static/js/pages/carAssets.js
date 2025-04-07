document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap components
    const uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));
    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    
    // Show notification function
    function showToast(message, type = 'success') {
        const toastContainer = document.querySelector('.toast-container');
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        const toast = new bootstrap.Toast(toastContainer.lastElementChild);
        toast.show();
        
        // Remove toast after it's hidden
        toastContainer.lastElementChild.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    }

    // File preview
    document.getElementById('media').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        preview.innerHTML = '';
        
        [...this.files].forEach(file => {
            const reader = new FileReader();
            const div = document.createElement('div');
            div.className = 'col-4';
            
            reader.onload = function(e) {
                if (file.type.startsWith('image/')) {
                    div.innerHTML = `
                        <div class="ratio ratio-16x9">
                            <img src="${e.target.result}" class="img-thumbnail">
                        </div>
                    `;
                } else if (file.type.startsWith('video/')) {
                    div.innerHTML = `
                        <div class="ratio ratio-16x9">
                            <video src="${e.target.result}" controls></video>
                        </div>
                    `;
                }
            }
            reader.readAsDataURL(file);
            preview.appendChild(div);
        });
    });

    // Upload handling
    document.getElementById('uploadButton').addEventListener('click', function() {
        const form = document.getElementById('uploadForm');
        const formData = new FormData(form);
        
        fetch('/cars/uploadAssets', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Media uploaded successfully');
                uploadModal.hide();
                location.reload();
            } else {
                showToast(data.message, 'danger');
            }
        })
        .catch(error => {
            showToast('Failed to upload media', 'danger');
        });
    });

    // Delete handling
    document.querySelectorAll('.delete-media').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this media?')) {
                const mediaId = this.dataset.id;
                
                fetch(`/cars/deleteAsset/${mediaId}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.media-container').remove();
                        showToast('Media deleted successfully');
                    } else {
                        showToast(data.message, 'danger');
                    }
                })
                .catch(error => {
                    showToast('Failed to delete media', 'danger');
                });
            }
        });
    });

    // Copy URL
    document.querySelectorAll('.copy-url').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.dataset.url;
            navigator.clipboard.writeText(url).then(() => {
                showToast('URL copied to clipboard');
            });
        });
    });

    // Image preview modal
    document.querySelectorAll('[data-bs-target="#imageModal"]').forEach(img => {
        img.addEventListener('click', function() {
            document.getElementById('modalImage').src = this.dataset.imgUrl;
        });
    });

    // Filter media
    document.querySelectorAll('[data-filter]').forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('[data-filter]').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');

            // Filter items
            const filter = this.dataset.filter;
            document.querySelectorAll('.media-container').forEach(container => {
                if (filter === 'all' || container.classList.contains(`${filter}-item`)) {
                    container.style.display = '';
                } else {
                    container.style.display = 'none';
                }
            });
        });
    });
});