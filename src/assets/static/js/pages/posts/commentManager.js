document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const commentsTable = document.getElementById('commentsTableBody');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const commentRows = commentsTable.querySelectorAll('.comment-row');
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = searchInput.value.toLowerCase();
        let hasResults = false;
        
        commentRows.forEach(row => {
            const commentText = row.querySelector('.comment-text').textContent.toLowerCase();
            const authorName = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const blogTitle = row.querySelector('td:nth-child(2)') ? 
                row.querySelector('td:nth-child(2)').textContent.toLowerCase() : '';
            
            // Search in comment content, author name, and blog title
            if (commentText.includes(searchTerm) || 
                authorName.includes(searchTerm) || 
                blogTitle.includes(searchTerm)) {
                row.style.display = '';
                hasResults = true;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show "no results" message if no matching comments
        if (hasResults) {
            noResultsMessage.classList.add('d-none');
        } else {
            noResultsMessage.classList.remove('d-none');
        }
    });
    
    // Sorting functionality
    const sortableHeaders = document.querySelectorAll('.sortable');
    
    sortableHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.dataset.sort;
            const currentDirection = this.getAttribute('data-direction') || 'asc';
            const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            
            // Update direction for all headers
            sortableHeaders.forEach(h => {
                h.removeAttribute('data-direction');
                h.querySelector('.fas').className = 'fas fa-sort ms-1';
            });
            
            // Set new direction for clicked header
            this.setAttribute('data-direction', newDirection);
            this.querySelector('.fas').className = `fas fa-sort-${newDirection === 'asc' ? 'up' : 'down'} ms-1`;
            
            // Sort rows
            const sortedRows = Array.from(commentRows).sort((a, b) => {
                let valA, valB;
                
                switch(sortBy) {
                    case 'id':
                        valA = parseInt(a.querySelector('td:first-child').textContent);
                        valB = parseInt(b.querySelector('td:first-child').textContent);
                        break;
                    case 'blog':
                        valA = a.querySelector('td:nth-child(2)') ? 
                            a.querySelector('td:nth-child(2)').textContent.toLowerCase() : '';
                        valB = b.querySelector('td:nth-child(2)') ? 
                            b.querySelector('td:nth-child(2)').textContent.toLowerCase() : '';
                        break;
                    case 'comment':
                        valA = a.querySelector('.comment-text').textContent.toLowerCase();
                        valB = b.querySelector('.comment-text').textContent.toLowerCase();
                        break;
                    case 'author':
                        valA = a.querySelector('td:nth-child(4) span').textContent.toLowerCase();
                        valB = b.querySelector('td:nth-child(4) span').textContent.toLowerCase();
                        break;
                    case 'created_at':
                        valA = new Date(a.querySelector('td:nth-child(5)').textContent);
                        valB = new Date(b.querySelector('td:nth-child(5)').textContent);
                        break;
                    default:
                        return 0;
                }
                
                // Handle direction
                const result = valA > valB ? 1 : valA < valB ? -1 : 0;
                return newDirection === 'asc' ? result : -result;
            });
            
            // Reorder DOM
            sortedRows.forEach(row => commentsTable.appendChild(row));
        });
    });
    
    // Pagination
    const rowsPerPage = 10;
    const pagination = document.getElementById('pagination');
    
    function setupPagination() {
        if (commentRows.length <= rowsPerPage) {
            pagination.innerHTML = '';
            return;
        }
        
        const pageCount = Math.ceil(commentRows.length / rowsPerPage);
        let paginationHTML = '';
        
        // Previous button
        paginationHTML += `
            <li class="page-item" id="prev-page">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        `;
        
        // Page numbers
        for (let i = 1; i <= pageCount; i++) {
            paginationHTML += `
                <li class="page-item ${i === 1 ? 'active' : ''}" data-page="${i}">
                    <a class="page-link" href="#">${i}</a>
                </li>
            `;
        }
        
        // Next button
        paginationHTML += `
            <li class="page-item" id="next-page">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        `;
        
        pagination.innerHTML = paginationHTML;
        
        // Show first page by default
        goToPage(1);
        
        // Add event listeners for page navigation
        document.querySelectorAll('#pagination .page-item[data-page]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const pageNum = parseInt(this.getAttribute('data-page'));
                goToPage(pageNum);
            });
        });
        
        // Previous button
        document.getElementById('prev-page').addEventListener('click', function(e) {
            e.preventDefault();
            const currentPage = parseInt(document.querySelector('#pagination .page-item.active').getAttribute('data-page'));
            if (currentPage > 1) {
                goToPage(currentPage - 1);
            }
        });
        
        // Next button
        document.getElementById('next-page').addEventListener('click', function(e) {
            e.preventDefault();
            const currentPage = parseInt(document.querySelector('#pagination .page-item.active').getAttribute('data-page'));
            if (currentPage < pageCount) {
                goToPage(currentPage + 1);
            }
        });
    }
    
    function goToPage(pageNum) {
        // Update active class
        document.querySelectorAll('#pagination .page-item').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelector(`#pagination .page-item[data-page="${pageNum}"]`).classList.add('active');
        
        // Show/hide rows
        const startIdx = (pageNum - 1) * rowsPerPage;
        const endIdx = startIdx + rowsPerPage;
        
        commentRows.forEach((row, idx) => {
            if (idx >= startIdx && idx < endIdx) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Initialize pagination if we have rows
    if (commentRows.length > 0) {
        setupPagination();
    }
    
    // View Comment Modal
    const viewCommentModal = document.getElementById('viewCommentModal');
    if (viewCommentModal) {
        viewCommentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const commentId = button.getAttribute('data-id');
            const row = document.querySelector(`tr[data-id="${commentId}"]`) || button.closest('tr');
            
            const commentContent = row.querySelector('.comment-text').textContent;
            const commentAuthor = row.querySelector('td:nth-child(4) span').textContent;
            const commentDate = row.querySelector('td:nth-child(5)').textContent;
            
            // Find blog title if available (depends on the table structure)
            let blogTitle = '';
            if (row.querySelector('td:nth-child(2) a')) {
                blogTitle = row.querySelector('td:nth-child(2) a').textContent;
            }
            
            // Update modal content
            document.getElementById('commentContent').textContent = commentContent;
            document.getElementById('commentAuthor').textContent = commentAuthor;
            document.getElementById('commentDate').textContent = commentDate;
            
            if (blogTitle && document.getElementById('commentBlogTitle')) {
                document.getElementById('commentBlogTitle').textContent = blogTitle;
            }
            
            // Check for attachment
            const attachmentDiv = document.getElementById('commentAttachment');
            const attachmentLink = document.getElementById('attachmentLink');
            
            if (row.querySelector('.comment-attachment')) {
                const attachmentUrl = row.querySelector('.attachment-link').getAttribute('href');
                const attachmentName = row.querySelector('.attachment-link').textContent;
                
                attachmentDiv.classList.remove('d-none');
                attachmentLink.setAttribute('href', attachmentUrl);
                attachmentLink.textContent = attachmentName;
            } else {
                attachmentDiv.classList.add('d-none');
            }
        });
    }
    
    // Delete Comment
    const deleteCommentModal = document.getElementById('deleteCommentModal');
    const deleteCommentForm = document.getElementById('deleteCommentForm');
    
    if (deleteCommentModal && deleteCommentForm) {
        deleteCommentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const commentId = button.getAttribute('data-id');
            
            // Set the form action
            deleteCommentForm.setAttribute('action', `/admin/blogComments/delete/${commentId}`);
        });
        
        deleteCommentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formAction = this.getAttribute('action');
            console.log(formAction)
            
            $.ajax({
                url: formAction,
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(data) {
                    if (data.success) {
                        // Đóng modal
                        const modal = bootstrap.Modal.getInstance(deleteCommentModal);
                        modal.hide();
                        
                        // Xóa hàng bình luận khỏi bảng
                        const commentId = formAction.split('/').pop();
                        const commentRow = document.querySelector(`.delete-btn[data-id="${commentId}"]`).closest('tr');
                        commentRow.remove();
                        
                        // Hiển thị thông báo thành công
                        toastr.success('Comment deleted successfully!');
                        
                        // Tải lại trang nếu không còn bình luận nào
                        if (document.querySelectorAll('#commentsTableBody tr').length === 0) {
                            window.location.reload();
                        }
                    } else {
                        toastr.error('Comment cannot be deleted: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toastr.error('An error occurred while deleting the comment.');
                }
            });
        });
    }
}); 