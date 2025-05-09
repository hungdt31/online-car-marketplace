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
    'HelpPage' => ['url' => '/help', 'name' => 'Help'],
];

$currentUser = SessionFactory::createSession('account');
if ($currentUser->getProfile()) {
    $currentUser->getProfile()['role'] == 'admin' ? $userItems['AdminPage'] = ['url' => '/dashboard', 'icon' => 'bi bi-kanban','title' => 'Dashboard'] :
    $userItems = [
        'ProfilePage' => ['url' => '/account', 'icon' => 'fa fa-user', 'title' => 'Profile'],
        'AppointmentsPage' => ['url' => '/account?tab=appointments', 'icon' => 'bi bi-calendar-check-fill', 'title' => 'Appointments'],
        'HelpPage' => ['url' => '/help', 'icon' => 'fa fa-question-circle', 'title' => 'Help'],
    ];
} else {
    $userItems = [
        'SignIn' => ['url' => '/auth', 'name' => 'Sign In / Sign Up']
    ];
}
?>
<div class="nav">
    <div class="menu-dropdown">
        <button class="menu-dropdown-toggle">
            <i class="fa-solid fa-bars me-2"></i>
            <span>Menu</span>
        </button>
        <div class="menu-dropdown-menu">
            <?php foreach ($menuItems as $item): ?>
                <a href="<?= $item['url'] ?>" class="menu-dropdown-item <?= $currentUrl === $item['url'] ? 'active' : '' ?>">
                    <?= $item['name'] ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
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
            <a href="/auth" class="me-2">
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
        background-color: rgba(255, 255, 255, 0.1);
        cursor: pointer;
        z-index: 1000;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .toggle-nav:hover {
        background-color: rgba(255, 255, 255, 0.2);
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
        border-radius: 8px;
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
        border-radius: 10px;
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
        margin: 2px 8px;
        border-radius: 8px;
    }

    .user-dropdown-item:hover {
        background-color: rgba(78, 108, 251, 0.1) !important;
        color: #4E6CFB !important;
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

    /* Menu Dropdown Styles */
    .menu-dropdown {
        position: relative;
        display: none;
    }

    .menu-dropdown-toggle {
        display: flex;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50px;
        padding: 10px 20px;
        cursor: pointer;
        transition: all 0.3s;
        color: white;
        font-weight: 600;
    }

    .menu-dropdown-toggle:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .menu-dropdown-toggle i {
        margin-right: 8px;
    }

    .menu-dropdown-menu {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 50px;
        background-color: white;
        border-radius: 12px;
        min-width: 320px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        display: none;
        overflow: hidden;
        z-index: 1000;
        padding: 8px;
        display: none;
        grid-template-columns: 1fr 1fr;
        gap: 4px;
    }

    .menu-dropdown-item {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        color: #333 !important;
        text-decoration: none;
        transition: all 0.2s;
        font-weight: 500 !important;
        margin: 2px;
        border-radius: 8px;
        justify-content: center;
    }

    .menu-dropdown-item:hover {
        background-color: rgba(78, 108, 251, 0.1) !important;
        color: #4E6CFB !important;
    }

    .menu-dropdown-item.active {
        background-color: #4E6CFB !important;
        color: white !important;
    }

    .menu-dropdown.active .menu-dropdown-menu {
        display: grid;
        animation: fadeInDown 0.3s ease forwards;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px) translateX(-50%);
        }
        to {
            opacity: 1;
            transform: translateY(0) translateX(-50%);
        }
    }

    @media screen and (max-width: 768px) {
        .nav {
            justify-content: space-between;
            padding: 15px 15px;
        }

        .toggle-nav {
            display: none;
        }

        .overlay.active {
            display: block;
        }

        .sys-nav {
            display: none;
        }

        .menu-dropdown {
            display: block;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .user-nav {
            display: flex;
        }

        .user-dropdown-toggle {
            padding: 6px;
            border-radius: 8px;
        }

        .user-avatar {
            margin-right: 0;
        }

        .user-dropdown {
            position: static;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 50px;
            right: 0;
            width: 250px;
            max-height: 80vh;
            overflow-y: auto;
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.08);
            padding: 8px 0;
        }

        @media (hover: none) {
            .user-dropdown-item,
            .menu-dropdown-item {
                padding: 16px 20px;
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
                
                // Đóng menu dropdown nếu đang mở
                if (menuDropdown && menuDropdown.classList.contains('active')) {
                    menuDropdown.classList.remove('active');
                }
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

        // Xử lý menu dropdown
        const menuDropdown = document.querySelector('.menu-dropdown');
        if (menuDropdown) {
            const menuToggle = menuDropdown.querySelector('.menu-dropdown-toggle');
            const menuDropdownMenu = menuDropdown.querySelector('.menu-dropdown-menu');

            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                menuDropdown.classList.toggle('active');
                
                // Đóng user dropdown nếu đang mở
                if (userDropdown && userDropdown.classList.contains('active')) {
                    userDropdown.classList.remove('active');
                }
            });

            // Đóng dropdown khi click bên ngoài
            document.addEventListener('click', function(e) {
                if (!menuDropdown.contains(e.target)) {
                    menuDropdown.classList.remove('active');
                }
            });
            
            // Đảm bảo các liên kết trong dropdown hoạt động đúng
            const menuItems = menuDropdown.querySelectorAll('.menu-dropdown-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        }
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