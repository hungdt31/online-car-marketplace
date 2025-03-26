<div class="search-bar">
    <div class="search-field">
        <input type="text" placeholder="Search Car's" />
    </div>
    <div class="search-field">
        <select>
            <option>All Model's</option>
            <option>Model 1</option>
            <option>Model 2</option>
        </select>
    </div>
    <div class="search-field location">
        <input type="text" placeholder="LOCATION" />
        <i class="fa fa-map-marker-alt"></i>
    </div>
    <button class="search-btn">
        <i class="fa fa-search"></i> Search now
    </button>
</div>
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
</style>