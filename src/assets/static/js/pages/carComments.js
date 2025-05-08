document.addEventListener('DOMContentLoaded', function() {
    // --- Cấu hình sắp xếp và lọc ---
    const rowsPerPage = 10; // Số mục trên mỗi trang
    let currentPage = 1;
    let sortState = {
        column: null,
        direction: 'asc'
    };

    // Ánh xạ cột để sắp xếp
    const columnMap = {
        'user': {
            index: 1,
            type: 'string'
        },
        'car': {
            index: 2,
            type: 'string'
        },
        'rating': {
            index: 3,
            type: 'number'
        },
        'content': {
            index: 4,
            type: 'string'
        },
        'date': {
            index: 5,
            type: 'date'
        },
        'status': {
            index: 6,
            type: 'string'
        }
    };

    // --- Xử lý phê duyệt bình luận ---
    const approveButtons = document.querySelectorAll('.approve-comment');
    approveButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const commentId = this.getAttribute('data-id');
            console.log(commentId);

            // Thay đổi trạng thái nút để hiển thị đang tải
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang xử lý...';
            this.disabled = true;

            // Gọi API để phê duyệt bình luận với ajax
            $.ajax({
                url: `/admin/cars/changeStatusComment/${commentId}`,
                type: 'POST',
                dataType: 'json',
                data: {
                    status: 'approved'
                },
                success: function(data) {
                    if (data.success) {
                        // ghi tiếng Anh
                        toastr.success(data.message || 'Comment approved successfully!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Đã có lỗi xảy ra khi kết nối đến server');
                },
                complete: function() {
                    // Khôi phục trạng thái nút
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            });
        });
    });

    // --- Xử lý xóa bình luận ---
    const deleteButtons = document.querySelectorAll('.delete-comment');
    deleteButtons.forEach(button => {
        // bắt đầu sự kiện click
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const commentId = this.getAttribute('data-id');

            // Thay đổi trạng thái nút để hiển thị đang tải
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang xử lý...';
            this.disabled = true;

            // // Gọi API để xóa bình luận với ajax
            $.ajax({
                url: `/admin/cars/deleteComment/${commentId}`,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        // ghi tiếng Anh
                        toastr.success(data.message || 'Comment deleted successfully!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while connecting to the server.');
                },
                complete: function() {
                    // Khôi phục trạng thái nút
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            });
        });
    });

    // --- Xử lý từ chối bình luận ---
    const rejectButtons = document.querySelectorAll('.reject-comment');
    if (rejectButtons) {
        rejectButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const commentId = this.getAttribute('data-id');

                // Thay đổi trạng thái nút để hiển thị đang tải
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang xử lý...';
                this.disabled = true;

                // Gọi API để từ chối bình luận
                $.ajax({
                    url: `/admin/cars/changeStatusComment/${commentId}`,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        status: 'rejected'
                    },
                    success: function(data) {
                        if (data.success) {
                            // ghi tiếng Anh
                            toastr.success(data.message || 'Comment rejected successfully!');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr, status, error) {
                        // hiển thị thông báo lỗi tiếng Anh
                        toastr.error('An error occurred while connecting to the server');
                    },
                    complete: function() {
                        // Khôi phục trạng thái nút
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }
                });
            });
        });
    }

    // --- Xử lý modal trả lời ---
    const replyModal = document.getElementById('replyModal');
    if (replyModal) {
        replyModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const commentId = button.getAttribute('data-id');
            const userName = button.getAttribute('data-username') || '';
            const commentTitle = button.getAttribute('data-title') || '';

            document.getElementById('commentId').value = commentId;

            // Hiển thị thông tin người dùng và tiêu đề bình luận nếu có
            const replyUserName = document.getElementById('replyUserName');
            const replyTitle = document.getElementById('replyTitle');

            if (replyUserName) {
                replyUserName.textContent = userName || `ID #${commentId}`;
            }

            if (replyTitle) {
                replyTitle.textContent = commentTitle || '';
            }
            console.log(commentId, userName, commentTitle);
        });
    }

    // --- Xử lý gửi phản hồi ---
    const submitReply = document.getElementById('submitReply');
    if (submitReply) {
        submitReply.addEventListener('click', function() {
            const form = document.getElementById('replyForm');

            // Kiểm tra validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Thay đổi trạng thái nút
            this.disabled = true;
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang gửi...';

            const formData = new FormData(form);
            // console.log('Form data:', formData);
            // Complete the AJAX request for submitting a reply
            $.ajax({
                url: '/admin/cars/replyToComment',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    // console.log('Response data:', data);
                    if (data.success) {
                        // Show success notification in English
                        toastr.success(data.message || 'Reply sent successfully!');
                        
                        // Optionally reload after a delay to show updated data
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        // Show error notification in English
                        toastr.error(data.message || 'Failed to send reply');
                    }
                },
                error: function(xhr, status, error) {
                    // Show error notification in English
                    toastr.error('An error occurred while connecting to the server');
                    console.error('Error details:', xhr, status, error);
                },
                complete: function() {
                    // Restore button state
                    submitReply.disabled = false;
                    submitReply.innerHTML = originalText;
                }
            });
        });
    }

    // --- PHẦN TÌM KIẾM VÀ SẮP XẾP ---

    // --- Lấy các phần tử cần thiết ---
    const tableBody = document.querySelector('tbody');
    const rows = tableBody ? tableBody.querySelectorAll('tr') : [];
    const searchInput = document.getElementById('searchReviews');
    const filterForm = document.getElementById('filterForm');
    const pagination = document.querySelector('.pagination');

    // --- Định nghĩa hàm lấy giá trị ô dựa trên loại cột ---
    function getCellValue(row, columnName) {
        if (!columnMap[columnName]) return '';

        const cell = row.cells[columnMap[columnName].index];
        if (!cell) return '';

        const rawValue = cell.textContent.trim();

        // Xử lý giá trị dựa trên loại cột
        switch (columnMap[columnName].type) {
            case 'number':
                // Trích xuất số từ chuỗi đánh giá (ví dụ: lấy 4.0 từ "4.0")
                const ratingMatch = rawValue.match(/(\d+(\.\d+)?)/);
                return ratingMatch ? parseFloat(ratingMatch[1]) : 0;
            case 'date':
                // Chuyển đổi ngày sang timestamp để so sánh
                const dateStr = cell.querySelector('.text-secondary.text-xs').textContent.trim();
                return new Date(dateStr.split('/').reverse().join('-')).getTime();
            default:
                return rawValue.toLowerCase();
        }
    }

    // --- Hàm so sánh để sắp xếp ---
    function compareValues(a, b, columnName, direction) {
        const aValue = getCellValue(a, columnName);
        const bValue = getCellValue(b, columnName);

        // So sánh dựa trên kiểu dữ liệu
        if (columnMap[columnName].type === 'string') {
            return direction === 'asc' ?
                aValue.localeCompare(bValue) :
                bValue.localeCompare(aValue);
        } else {
            return direction === 'asc' ?
                aValue - bValue :
                bValue - aValue;
        }
    }

    // --- Hàm sắp xếp bảng theo cột ---
    function sortTable(columnName) {
        if (!columnName || !tableBody) return;

        // Reset tất cả tiêu đề
        document.querySelectorAll('th.sortable').forEach(th => {
            th.classList.remove('asc', 'desc');
            const icon = th.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-sort ms-1';
                icon.style.opacity = '0.2';
            }
        });

        // Cập nhật trạng thái sắp xếp
        if (sortState.column === columnName) {
            sortState.direction = sortState.direction === 'asc' ? 'desc' : 'asc';
        } else {
            sortState.column = columnName;
            sortState.direction = 'asc';
        }

        // Cập nhật kiểu tiêu đề
        const header = document.querySelector(`th[data-sort="${columnName}"]`);
        if (header) {
            header.classList.add(sortState.direction);
            const icon = header.querySelector('i');
            if (icon) {
                icon.className = `fas fa-sort-${sortState.direction === 'asc' ? 'up' : 'down'} ms-1`;
                icon.style.opacity = '1';
            }
        }

        // Lấy tất cả hàng dưới dạng mảng và sắp xếp
        const rowsArray = Array.from(tableBody.querySelectorAll('tr.review-row'));
        rowsArray.sort((a, b) => compareValues(a, b, columnName, sortState.direction));

        // Thêm các hàng theo thứ tự mới
        rowsArray.forEach(row => tableBody.appendChild(row));

        // Cập nhật lại bảng sau khi sắp xếp
        updateTable();
    }

    // --- Cập nhật hiển thị bảng dựa trên tìm kiếm và phân trang ---
    function updateTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';

        // Lấy giá trị bộ lọc
        let filters = {};
        if (filterForm) {
            const formData = new FormData(filterForm);
            for (const [key, value] of formData.entries()) {
                if (value) filters[key] = value.toLowerCase();
            }
        }

        // Lọc hàng dựa trên chuỗi tìm kiếm và bộ lọc
        const filteredRows = Array.from(rows).filter(row => {
            // Chỉ xem xét các hàng bình luận
            if (!row.classList.contains('review-row')) return false;

            // Lọc theo từ khóa tìm kiếm
            if (searchTerm) {
                const userName = row.querySelector('.car-name')?.textContent.toLowerCase() || '';
                const email = row.querySelector('.text-xs.text-secondary')?.textContent.toLowerCase() || '';
                const content = row.cells[4]?.textContent.toLowerCase() || '';

                // Nếu không khớp với từ khóa tìm kiếm, loại bỏ hàng này
                if (!userName.includes(searchTerm) && !email.includes(searchTerm) && !content.includes(searchTerm)) {
                    return false;
                }
            }

            // Lọc theo các bộ lọc khác
            for (const key in filters) {
                if (key === 'rating') {
                    const rating = row.getAttribute('data-rating') || '0';
                    if (rating !== filters[key]) return false;
                } else if (key === 'status') {
                    const status = row.getAttribute('data-status') || 'pending';
                    if (status !== filters[key]) return false;
                } else if (key === 'start_date' || key === 'end_date') {
                    let dateTime = row.getAttribute('data-date');
                    dateTime = new Date(dateTime).getTime();
                    const filterDate = new Date(filters[key]).getTime();

                    if (key === 'start_date' && dateTime < filterDate) return false;
                    if (key === 'end_date' && dateTime > (filterDate + 86400000)) return false; // +1 ngày
                }
            }

            return true;
        });

        // Hiển thị/ẩn thông báo không có kết quả
        const noResultsMessage = document.getElementById('noResultsMessage');
        if (noResultsMessage) {
            noResultsMessage.classList.toggle('d-none', filteredRows.length > 0);
        }

        // Tính toán phân trang
        const totalPages = Math.max(1, Math.ceil(filteredRows.length / rowsPerPage));
        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        // Tính toán chỉ mục bắt đầu và kết thúc
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = Math.min(startIndex + rowsPerPage, filteredRows.length);

        // Cập nhật hiển thị hàng
        rows.forEach(row => {
            if (row.classList.contains('review-row')) {
                row.style.display = 'none';
            }
        });
        filteredRows.slice(startIndex, endIndex).forEach(row => row.style.display = '');

        // Cập nhật điều khiển phân trang
        updatePagination(totalPages);
    }

    // --- Cập nhật điều khiển phân trang ---
    function updatePagination(totalPages) {
        if (!pagination) return;

        pagination.innerHTML = '';

        if (totalPages <= 1) return;

        // Nút Previous
        const prevLi = document.createElement('li');
        prevLi.classList.add('page-item');
        if (currentPage === 1) prevLi.classList.add('disabled');

        const prevLink = document.createElement('a');
        prevLink.classList.add('page-link');
        prevLink.href = '#';
        prevLink.innerHTML = '<i class="fa fa-angle-left"></i>';
        prevLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });

        prevLi.appendChild(prevLink);
        pagination.appendChild(prevLi);

        // Số trang
        const maxVisiblePages = 5; // Số lượng nút trang tối đa hiển thị
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        // Điều chỉnh nếu chúng ta đang ở gần cuối
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // Nút trang đầu tiên nếu không bắt đầu từ 1
        if (startPage > 1) {
            const firstLi = document.createElement('li');
            firstLi.classList.add('page-item');

            const firstLink = document.createElement('a');
            firstLink.classList.add('page-link');
            firstLink.href = '#';
            firstLink.textContent = '1';
            firstLink.addEventListener('click', function(e) {
                e.preventDefault();
                currentPage = 1;
                updateTable();
            });

            firstLi.appendChild(firstLink);
            pagination.appendChild(firstLi);

            // Dấu chấm ellipsis nếu không bắt đầu từ 2
            if (startPage > 2) {
                const ellipsisLi = document.createElement('li');
                ellipsisLi.classList.add('page-item', 'disabled');

                const ellipsisLink = document.createElement('a');
                ellipsisLink.classList.add('page-link');
                ellipsisLink.href = '#';
                ellipsisLink.textContent = '...';

                ellipsisLi.appendChild(ellipsisLink);
                pagination.appendChild(ellipsisLi);
            }
        }

        // Các nút số trang
        for (let i = startPage; i <= endPage; i++) {
            const li = document.createElement('li');
            li.classList.add('page-item');
            if (i === currentPage) li.classList.add('active');

            const link = document.createElement('a');
            link.classList.add('page-link');
            link.href = '#';
            link.textContent = i;
            link.addEventListener('click', function(e) {
                e.preventDefault();
                currentPage = i;
                updateTable();
            });

            li.appendChild(link);
            pagination.appendChild(li);
        }

        // Ellipsis và trang cuối nếu không kết thúc ở tổng số trang
        if (endPage < totalPages) {
            // Ellipsis nếu không kết thúc ở totalPages-1
            if (endPage < totalPages - 1) {
                const ellipsisLi = document.createElement('li');
                ellipsisLi.classList.add('page-item', 'disabled');

                const ellipsisLink = document.createElement('a');
                ellipsisLink.classList.add('page-link');
                ellipsisLink.href = '#';
                ellipsisLink.textContent = '...';

                ellipsisLi.appendChild(ellipsisLink);
                pagination.appendChild(ellipsisLi);
            }

            // Nút trang cuối cùng
            const lastLi = document.createElement('li');
            lastLi.classList.add('page-item');

            const lastLink = document.createElement('a');
            lastLink.classList.add('page-link');
            lastLink.href = '#';
            lastLink.textContent = totalPages;
            lastLink.addEventListener('click', function(e) {
                e.preventDefault();
                currentPage = totalPages;
                updateTable();
            });

            lastLi.appendChild(lastLink);
            pagination.appendChild(lastLi);
        }

        // Nút Next
        const nextLi = document.createElement('li');
        nextLi.classList.add('page-item');
        if (currentPage === totalPages) nextLi.classList.add('disabled');

        const nextLink = document.createElement('a');
        nextLink.classList.add('page-link');
        nextLink.href = '#';
        nextLink.innerHTML = '<i class="fa fa-angle-right"></i>';
        nextLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });

        nextLi.appendChild(nextLink);
        pagination.appendChild(nextLi);
    }

    // --- Kiểm tra xem bảng có trống không ---
    function checkEmptyTable() {
        const tableRows = document.querySelectorAll('tr.review-row');
        const emptyMessage = document.querySelector('#emptyTableMessage');

        if (tableRows.length === 0 && emptyMessage) {
            emptyMessage.classList.remove('d-none');
        } else if (emptyMessage) {
            emptyMessage.classList.add('d-none');
        }
    }

    // --- Cập nhật bộ đếm bình luận ---
    function updateCommentCounts(type, change) {
        const countElements = {
            'total': document.getElementById('totalReviewsCount'),
            'pending': document.getElementById('pendingReviewsCount'),
            'approved': document.getElementById('approvedReviewsCount'),
            'rejected': document.getElementById('rejectedReviewsCount')
        };

        if (countElements[type]) {
            const currentCount = parseInt(countElements[type].textContent);
            const newCount = Math.max(0, currentCount + change);
            countElements[type].textContent = newCount;
        }
    }

    // --- Thêm sự kiện cho các tiêu đề cột có thể sắp xếp ---
    document.querySelectorAll('th.sortable').forEach(header => {
        header.addEventListener('click', () => {
            const column = header.getAttribute('data-sort');
            if (column) {
                sortTable(column);
            }
        });

        // Thêm hiệu ứng hover
        header.addEventListener('mouseover', () => {
            if (!header.classList.contains('asc') && !header.classList.contains('desc')) {
                const icon = header.querySelector('i');
                if (icon) icon.style.opacity = '0.5';
            }
        });

        header.addEventListener('mouseout', () => {
            if (!header.classList.contains('asc') && !header.classList.contains('desc')) {
                const icon = header.querySelector('i');
                if (icon) icon.style.opacity = '0.2';
            }
        });
    });

    // --- Xử lý tìm kiếm ---
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentPage = 1; // Reset về trang đầu tiên khi tìm kiếm
            updateTable();
        });

        // Thêm nút xóa tìm kiếm
        const clearSearchBtn = document.getElementById('clearSearch');
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                currentPage = 1;
                updateTable();
            });
        }
    }

    // --- Xử lý submit form lọc ---
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            currentPage = 1; // Reset về trang đầu tiên khi áp dụng bộ lọc
            updateTable();
        });
    }

    // Thiết lập ban đầu của bảng
    updateTable();

    // --- Xử lý mở modal chi tiết ---
    document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target^="#viewCommentModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-bs-target');
            const modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
        });
    });

    // Đảm bảo các modal được dọn dẹp sau khi đóng
    document.querySelectorAll('.modal').forEach(modalElement => {
        modalElement.addEventListener('hidden.bs.modal', function() {
            // Xóa backdrop nếu còn sót lại
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => {
                backdrop.remove();
            });

            // Đảm bảo modal không còn hiển thị
            modalElement.style.display = 'none';

            // Đặt lại thuộc tính của body
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    });

    // Xử lý nút "Trả lời" trong modal chi tiết
    document.querySelectorAll('.modal button[data-bs-target="#replyModal"]').forEach(button => {
        button.addEventListener('click', function() {
            // Đóng modal hiện tại trước khi mở modal khác
            const currentModal = bootstrap.Modal.getInstance(this.closest('.modal'));
            if (currentModal) {
                currentModal.hide();

                // Đảm bảo tất cả backdrop được xóa
                setTimeout(() => {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(backdrop => {
                        backdrop.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }, 300);
            }

            // Lấy ID comment và truyền sang modal reply
            const commentId = this.getAttribute('data-id');
            document.getElementById('commentId').value = commentId;

            // Mở modal trả lời sau một khoảng thời gian ngắn
            setTimeout(() => {
                const replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
                replyModal.show();
            }, 350);
        });
    });
});