<div class="search-bar-container">
    <form id="searchForm" class="search-form" autocomplete="off">
        <div class="search-field">
            <input type="text" name="keyword" id="searchInput" class="search-input" placeholder="Search cars..." />
        </div>

        <div class="search-field">
            <select name="fuel_type" id="fuel_type" class="search-select">
                <option value="">All Fuel Types</option>
                <option value="Petrol">Petrol</option>
                <option value="Electric">Electric</option>
                <option value="Hybrid">Hybrid</option>
                <option value="Diesel">Diesel</option>
            </select>
        </div>

        <div class="search-field location-field">
            <input type="text" name="location" class="search-input" placeholder="Location" />
            <i class="fas fa-map-marker-alt location-icon"></i>
        </div>

        <button type="submit" class="search-button">
            <i class="fas fa-search"></i>
            <span>Search</span>
        </button>
    </form>
</div>

<div id="searchResults" class="search-results-container">
    <div class="search-loading" style="display: none;">
        <i class="fas fa-spinner"></i>
    </div>
    <div class="search-results-grid"></div>
</div>

<script>
    $(document).ready(function () {
        const searchForm = $('#searchForm');
        const searchResults = $('#searchResults');
        const loadingIndicator = $('.search-loading');
        const resultsContainer = $('.search-results-grid');

        // 🔧 Tính chiều cao thanh tìm kiếm và set margin-top cho phần kết quả
        function adjustSearchResultsMargin() {
            const headerHeight = $('.search-bar-container').outerHeight();
            $('#searchResults').css('margin-top', headerHeight + 20); // +20 để tạo khoảng cách
        }

        adjustSearchResultsMargin();
        $(window).on('resize', adjustSearchResultsMargin);

        searchForm.on('submit', function (e) {
            e.preventDefault();
            loadingIndicator.show();
            resultsContainer.hide();

            const formData = {
                keyword: $('#searchInput').val().trim(),
                fuel_type: $('#fuel_type').val(),
                location: $('input[name="location"]').val().trim()
            };

            $.ajax({
                url: '<?= _WEB_ROOT ?>/Home/searchCars',
                method: 'GET',
                data: formData,
                success: function (response) {
                    loadingIndicator.hide();
                    resultsContainer.show();

                    if (response.success) {
                        if (response.data && response.data.length > 0) {
                            resultsContainer
                                .html(response.html)
                                .hide()
                                .fadeIn(300);

                            // 🔽 Cuộn xuống phần kết quả
                            $('html, body').animate({
                                scrollTop: $('#searchResults').offset().top - 10
                            }, 500);
                        } else {
                            resultsContainer.html(`
                            <div class="no-results">
                                <i class="fas fa-car-crash"></i>
                                <h3>No vehicles found</h3>
                                <p>Try adjusting your search criteria</p>
                            </div>
                        `);
                        }
                    } else {
                        resultsContainer.html(`
                        <div class="no-results">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h3>Search Error</h3>
                            <p>An error occurred while searching. Please try again.</p>
                        </div>
                    `);
                    }
                },
                error: function () {
                    loadingIndicator.hide();
                    resultsContainer.html(`
                    <div class="no-results">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Connection Error</h3>
                        <p>Unable to connect to the server. Please check your connection and try again.</p>
                    </div>
                `).show();
                }
            });
        });

        $('.search-button').on('click', function () {
            if (!$('#searchInput').val() && !$('#fuel_type').val() && !$('input[name="location"]').val()) {
                resultsContainer.empty();
            }
        });

        $('.search-input, .search-select').on('focus', function () {
            $(this).closest('.search-field').addClass('focused');
        }).on('blur', function () {
            $(this).closest('.search-field').removeClass('focused');
        });
    });
</script>

<style>
    /* Định dạng chung cho thanh tìm kiếm */
    .search-bar {
        display: flex;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.9);
        /* Nền trắng bán trong suốt */
        backdrop-filter: blur(10px);
        /* Hiệu ứng blur phía sau */
        -webkit-backdrop-filter: blur(10px);
        /* Hỗ trợ cho trình duyệt Webkit */
        border-radius: 25px;
        /* Bo tròn các góc */
        padding: 15px;
        width: 100%;
        max-width: 800px;
        /* Chiều rộng tối đa */
        margin: 0 auto;
        /* Căn giữa */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        /* Đổ bóng nhẹ */
    }

    /* Định dạng cho từng trường tìm kiếm */
    .search-field {
        position: relative;
        flex: 1;
        /* Mỗi trường chiếm đều không gian */
        padding: 0 15px;
        border-right: 2px solid rgba(0, 0, 0, 0.2);
        /* Đường kẻ phân tách */
    }

    /* Bỏ đường kẻ cho trường cuối cùng */
    .search-field:last-child {
        border-right: none;
    }

    /* Định dạng input và select */
    .search-field input,
    .search-field select {
        border: none;
        outline: none;
        background: none;
        width: 100%;
        padding: 10px 0;
        font-size: 16px;
        color: #333;
    }

    /* Định dạng placeholder */
    .search-field input::placeholder {
        color: #333;
        font-weight: 500;
    }

    /* Định dạng select (dropdown) */
    .search-field select {
        appearance: none;
        /* Bỏ giao diện mặc định của select */
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
    }

    /* Thêm mũi tên xuống cho select */
    .search-field select::-ms-expand {
        display: none;
        /* Ẩn mũi tên mặc định trên IE */
    }

    .search-field select {
        position: relative;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="black" d="M7 10l5 5 5-5z"/></svg>') no-repeat right center;
        background-size: 20px;
    }

    /* Định dạng trường Location với biểu tượng pin */
    .search-field.location {
        display: flex;
        align-items: center;
    }

    .search-field.location i {
        margin-left: 5px;
        color: #333;
        font-size: 16px;
    }

    /* Định dạng nút Search now */
    .search-btn {
        display: flex;
        align-items: center;
        gap: 5px;
        background-color: #4E6CFB;
        /* Màu xanh giống trong hình */
        color: white;
        border: none;
        border-radius: 15px;
        /* Bo tròn */
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-left: 10px;
    }

    .search-btn:hover {
        background-color: #3b55d9;
        /* Màu xanh đậm hơn khi hover */
    }

    .search-btn i {
        font-size: 16px;
    }

    /* Responsive cho tablet (màn hình từ 769px đến 1024px) */
    @media screen and (max-width: 1024px) {
        .search-bar {
            max-width: 600px;
            padding: 8px;
        }

        .search-field input,
        .search-field select {
            font-size: 14px;
            margin-left: 0;
        }

        .search-btn {
            font-size: 14px;
            padding: 8px 15px;
        }
    }

    /* Responsive cho điện thoại (màn hình nhỏ hơn 768px) */
    @media screen and (max-width: 768px) {
        .search-bar {
            flex-direction: column;
            max-width: 100%;
            border-radius: 20px;
            padding: 15px;
        }

        .search-field {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.2);
            padding: 10px 0;
        }

        .search-field:last-child {
            border-bottom: none;
        }

        .search-btn {
            width: 100%;
            margin-top: 10px;
            border-radius: 20px;
            padding: 12px;
            justify-content: center;
            margin-left: 0;
        }
    }

    /* Định dạng placeholder */
    .search-field input::placeholder {
        color: #888;
        /* Màu xám cho placeholder */
        font-weight: 500;
    }

    /* Thanh tìm kiếm cố định */
    .search-bar-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        background-color: #ffffff;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .search-form {
        display: flex;
        flex-wrap: nowrap;
        gap: 15px;
        background-color: #fff;
        border-radius: 30px;
        padding: 10px 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 1200px;
    }

    .search-field {
        flex: 1;
        position: relative;
    }

    .search-input,
    .search-select {
        width: 100%;
        padding: 12px 20px;
        border: 1px solid #ddd;
        border-radius: 30px;
        font-size: 16px;
        outline: none;
        transition: border-color 0.3s ease;
    }

    .search-input:focus,
    .search-select:focus {
        border-color: #4E6CFB;
    }

    .search-select {
        appearance: none;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%23333" d="M7 10l5 5 5-5z"/></svg>') no-repeat right center;
        padding-right: 25px;
    }

    .location-field {
        display: flex;
        align-items: center;
    }

    .location-icon {
        color: #dc3545;
        margin-left: 8px;
        font-size: 1.2rem;
    }

    .search-button {
        display: flex;
        align-items: center;
        gap: 12px;
        background-color: #4E6CFB;
        color: white;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-button:hover {
        background-color: #3b55d9;
    }

    .search-loading {
        text-align: center;
        padding: 20px;
    }

    .search-loading i {
        font-size: 2rem;
        color: #4E6CFB;
    }

    .search-results-container {
        margin-top: 20px;
        /* Khoảng cách để kết quả không bị che khuất */
    }

    .search-results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .search-results-grid>.result-item {
        background-color: #f9f9f9;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 300px;
        box-sizing: border-box;
    }

    .no-results {
        text-align: center;
        padding: 30px;
    }

    .no-results i {
        font-size: 3rem;
        color: #dc3545;
        margin-bottom: 15px;
    }

    .no-results h3 {
        font-size: 1.7rem;
        margin-bottom: 12px;
    }

    .no-results p {
        font-size: 1.2rem;
        color: #666;
    }

    @media screen and (max-width: 768px) {
        .search-form {
            flex-direction: column;
        }

        .search-button {
            width: 100%;
            justify-content: center;
            padding: 12px 0;
        }
    }
</style>