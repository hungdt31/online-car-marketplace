<?php
$userItems = [];
// Lấy URL hiện tại của trang
$currentUrl = $_SERVER['REQUEST_URI'];
$menuItems = [
    'HomePage' => ['url' => '/', 'name' => 'Home'],
    'ShopPage' => ['url' => '/shop', 'name' => 'Shop'],
    'BlogPage' => ['url' => '/blog', 'name' => 'Blog'],
    'ContactPage' => ['url' => '/contact', 'name' => 'Contact us'],
    'AboutPage' => ['url' => '/about', 'name' => 'About us'],
];

$currentUser = SessionFactory::createSession('account');
if ($currentUser->getProfile()) {
    $currentUser->getProfile()['role'] == 'admin' ? $userItems['AdminPage'] = ['url' => '/dashboard', 'icon' => 'bi bi-kanban','title' => 'Dashboard'] :
    $userItems = [
        'ProfilePage' => ['url' => '/account', 'icon' => 'fa fa-user', 'title' => 'Profile'],
        'AppointmentsPage' => ['url' => '/account?tab=appointments', 'icon' => 'bi bi-calendar-check-fill', 'title' => 'Appointments'],
    ];
} else {
    $userItems = [
        'SignIn' => ['url' => '/auth', 'name' => 'Sign In / Sign Up'],
    ];
}
?>
<div class="nav">
    <button class="toggle-nav">
        <i class="fa-solid fa-bars"></i>
    </button>
    <div class="overlay"></div>
    <div class="sys-nav">
        <?php foreach ($menuItems as $item): ?>
            <!-- So sánh URL hiện tại với URL của mục, nếu trùng thì thêm class "active" -->
            <a href="<?= $item['url'] ?>" class="<?= $currentUrl === $item['url'] ? 'active' : '' ?>">
                <?= $item['name'] ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="user-nav">
        <?php if ($currentUser->getProfile()): ?>
            <div class="user-dropdown">
                <button class="user-dropdown-toggle">
                    <div class="user-avatar">
                        <?php if (!empty($currentUser->getProfile()['avatar'])): ?>
                            <img src="<?= $currentUser->getProfile()['avatar'] ?>" alt="Avatar">
                        <?php else: ?>
                            <i class="fa-solid fa-user"></i>
                        <?php endif; ?>
                    </div>
                    <div class="user-info d-none d-md-block">
                        <div class="user-name"><?= htmlspecialchars($currentUser->getProfile()['username']) ?></div>
                        <div class="user-email"><?= htmlspecialchars($currentUser->getProfile()['email']) ?></div>
                    </div>
                    <i class="fa-solid fa-chevron-down ms-2"></i>
                </button>
                <div class="user-dropdown-menu">
                    <div class="user-dropdown-header d-block d-md-none">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar-large me-2">
                                <?php if (!empty($currentUser->getProfile()['avatar'])): ?>
                                    <img src="<?= $currentUser->getProfile()['avatar'] ?>" alt="Avatar">
                                <?php else: ?>
                                    <i class="fa-solid fa-user"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="user-name-large"><?= htmlspecialchars($currentUser->getProfile()['username']) ?></div>
                                <div class="user-email-small"><?= htmlspecialchars($currentUser->getProfile()['email']) ?></div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($userItems as $key => $item): ?>
                        <a href="<?= $item['url'] ?>" class="user-dropdown-item">
                            <i class="<?= $item['icon'] ?>"></i>
                            <span><?= $item['title'] ?></span>
                        </a>
                    <?php endforeach; ?>
                    <div class="dropdown-divider"></div>
                    <button id="signout-btn" class="user-dropdown-item btn w-100">
                        <i class="fa-solid fa-sign-out-alt"></i>
                        <span>Sign Out</span>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <a href="/auth" class="auth-btn">
                <i class="fa-solid fa-user me-2"></i>
                <span>Sign In / Sign Up</span>
            </a>
        <?php endif; ?>
    </div>
</div>

<style>
    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        width: 100%;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        background-color: rgba(78, 108, 251, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        position: relative;
        z-index: 999;
    }

    .nav a {
        text-decoration: none;
        color: white;
        font-weight: bold;
        padding: 10px;
        transition: 0.3s;
    }

    .nav a:hover {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }

    .sys-nav {
        display: flex;
        gap: 15px;
        justify-content: center;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .user-nav {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-left: auto;
        /* Đẩy user-nav sang phải */
    }

    .user-nav a i {
        font-size: 20px;
    }

    .toggle-nav {
        padding: 10px;
        min-width: 40px;
        color: white;
        border: none;
        display: none;
        background-color: transparent;
        cursor: pointer;
        z-index: 1000;
    }

    .nav a.active {
        background-color: #4E6CFB;
        border-radius: 50px;
        color: white;
        padding: 10px 20px;
    }

    .nav a.active:hover {
        background-color: #3b55d9;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        z-index: 998;
        transition: all 0.3s ease;
    }

    /* User Navigation Styles */
    .user-dropdown {
        position: relative;
        display: inline-block;
    }

    .user-dropdown-toggle {
        display: flex;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 50px;
        padding: 8px 16px;
        cursor: pointer;
        transition: all 0.3s;
        color: white;
    }

    .user-dropdown-toggle:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        overflow: hidden;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-avatar i {
        font-size: 16px;
        color: white;
    }

    .user-info {
        text-align: left;
    }

    .user-name {
        font-size: 14px;
        font-weight: bold;
        line-height: 1.2;
    }

    .user-email {
        font-size: 11px;
        opacity: 0.8;
        line-height: 1.2;
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-dropdown-menu {
        position: fixed;
        right: 20px;
        /* Khoảng cách từ cạnh phải của viewport */
        top: 80px;
        /* Khoảng cách từ cạnh trên của viewport, điều chỉnh theo chiều cao của navbar */
        background-color: white;
        border-radius: 10px;
        min-width: 220px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        display: none;
        overflow: hidden;
        pointer-events: auto;
        /* Đảm bảo các sự kiện click hoạt động đúng */
        -webkit-tap-highlight-color: transparent;
        /* Fix cho iOS Safari */
        max-height: calc(100vh - 100px);
        /* Giới hạn chiều cao tối đa */
        overflow-y: auto;
        /* Cho phép cuộn nếu nội dung quá dài */
    }

    .user-dropdown-header {
        padding: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .user-avatar-large {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #4E6CFB;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .user-avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-avatar-large i {
        font-size: 24px;
        color: white;
    }

    .user-name-large {
        font-size: 16px;
        font-weight: bold;
        line-height: 1.2;
        color: #333;
    }

    .user-email-small {
        font-size: 13px;
        color: #666;
        line-height: 1.2;
    }

    .user-dropdown-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #333 !important;
        text-decoration: none;
        transition: background-color 0.2s;
        font-weight: normal !important;
        position: relative;
        /* Tạo context cho pseudo-elements */
    }

    .user-dropdown-item:hover {
        background-color: rgba(78, 108, 251, 0.1) !important;
        border-radius: 0 !important;
    }

    .user-dropdown-item i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
        color: #4E6CFB;
    }

    .user-dropdown-item::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        /* Đảm bảo phần tử này nằm trên cùng để nhận sự kiện click */
    }

    .dropdown-divider {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        margin: 5px 0;
    }

    .user-dropdown.active .user-dropdown-menu {
        display: block;
    }

    .user-dropdown-toggle:focus {
        outline: none;
        /* Khắc phục vấn đề với focus */
    }

    .auth-btn {
        display: flex;
        align-items: center;
        background-color: #4E6CFB;
        border-radius: 50px;
        padding: 8px 18px;
        color: white;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s;
    }

    .auth-btn:hover {
        background-color: #3b55d9;
        color: white !important;
    }

    @media screen and (max-width: 768px) {
        .nav {
            justify-content: flex-end;
        }

        .toggle-nav {
            display: block;
            position: relative;
            z-index: 1000;
        }

        .overlay.active {
            display: block;
        }

        .sys-nav {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(78, 108, 251, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            z-index: 999;
            transform: translateX(0);
            transition: all 0.3s ease;
        }

        .sys-nav.active {
            display: flex;
        }

        .user-nav {
            display: none;
            position: fixed;
            top: 20px;
            /* Đặt ở trên cùng */
            right: 70px;
            /* Cách nút toggle */
            background-color: transparent;
            flex-direction: row;
            justify-content: flex-end;
            gap: 20px;
            z-index: 999;
            margin-left: 0;
        }

        .user-nav.active {
            display: flex;
        }

        body.menu-active {
            overflow: hidden;
        }

        .user-dropdown-toggle {
            padding: 6px;
            border-radius: 50%;
        }

        .user-avatar {
            margin-right: 0;
        }

        .user-dropdown {
            position: static;
        }

        .user-dropdown-menu {
            position: fixed;
            top: 70px;
            left: 10%;
            right: 10%;
            width: 80%;
            max-height: 80vh;
            overflow-y: auto;
        }

        @media (hover: none) {
            .user-dropdown-item {
                padding: 14px 15px;
                /* Tăng kích thước vùng có thể click */
            }
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý user dropdown
        const userDropdown = document.querySelector('.user-dropdown');
        if (userDropdown) {
            const dropdownToggle = userDropdown.querySelector('.user-dropdown-toggle');
            const dropdownMenu = userDropdown.querySelector('.user-dropdown-menu');

            // Hàm để cập nhật vị trí menu
            function updateDropdownPosition() {
                const toggleRect = dropdownToggle.getBoundingClientRect();
                dropdownMenu.style.top = (toggleRect.bottom + 10) + 'px';
                dropdownMenu.style.right = (window.innerWidth - toggleRect.right) + 'px';
            }

            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Cập nhật vị trí trước khi hiển thị
                updateDropdownPosition();
                userDropdown.classList.toggle('active');
            });

            // Cập nhật vị trí khi resize cửa sổ
            window.addEventListener('resize', function() {
                if (userDropdown.classList.contains('active')) {
                    updateDropdownPosition();
                }
            });

            // Cập nhật vị trí khi cuộn trang
            window.addEventListener('scroll', function() {
                if (userDropdown.classList.contains('active')) {
                    updateDropdownPosition();
                }
            });

            // Đóng dropdown khi click bên ngoài
            document.addEventListener('click', function(e) {
                if (!userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('active');
                }
            });

            // Đảm bảo các liên kết trong dropdown hoạt động đúng
            const dropdownItems = userDropdown.querySelectorAll('.user-dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();

                    const href = this.getAttribute('href');
                    if (href && href !== '#') {
                        window.location.href = href;
                    }
                });
            });
        }

        // Phần code xử lý mobile menu giữ nguyên...
        const toggleNavBtn = document.querySelector('.toggle-nav');
        if (toggleNavBtn) {
            toggleNavBtn.addEventListener('click', function() {
                document.querySelector('.sys-nav').classList.toggle('active');
                document.querySelector('.user-nav').classList.toggle('active');
                document.querySelector('.overlay').classList.toggle('active');
                document.body.classList.toggle('menu-active');

                // Đóng user dropdown nếu đang mở khi toggle mobile menu
                if (userDropdown && userDropdown.classList.contains('active')) {
                    userDropdown.classList.remove('active');
                }
            });
        }

        // Đóng menu khi click vào overlay
        const overlay = document.querySelector('.overlay');
        if (overlay) {
            overlay.addEventListener('click', function() {
                document.querySelector('.sys-nav').classList.remove('active');
                document.querySelector('.user-nav').classList.remove('active');
                this.classList.remove('active');
                document.body.classList.remove('menu-active');

                // Đóng user dropdown nếu đang mở
                if (userDropdown && userDropdown.classList.contains('active')) {
                    userDropdown.classList.remove('active');
                }
            });
        }

        // Đóng menu khi click vào các liên kết trong menu
        const sysNavLinks = document.querySelectorAll('.sys-nav a');
        sysNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Chỉ áp dụng cho mobile view
                if (window.innerWidth <= 768) {
                    document.querySelector('.sys-nav').classList.remove('active');
                    document.querySelector('.user-nav').classList.remove('active');
                    document.querySelector('.overlay').classList.remove('active');
                    document.body.classList.remove('menu-active');
                }
            });
        });
    });
    $(document).ready(function() {
        $('#signout-btn').click(function() {
            $.ajax({
                type: 'POST',
                url: '/auth/logout',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = '/auth';
                        }, 2000);
                    }
                }
            });
        });
    });
</script>