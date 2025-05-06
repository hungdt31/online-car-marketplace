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
    $userItems = [
        'HelpPage' => ['url' => '/help', 'icon' => 'fa-question-circle', 'title' => 'Help'],
        'CartPage' => ['url' => '/cart', 'icon' => 'fa-shopping-cart', 'title' => 'Cart'],
        'AccountPage' => ['url' => '/account', 'icon' => 'fa-user', 'title' => 'Account']
    ];
} else {
    $userItems = [
        'SignIn' => ['url' => '/auth', 'name' => 'Sign In / Sign Up'],
    ];
}
/*  $userItems = [
       'HelpPage' => ['url' => '/help', 'icon' => 'fa-question-circle', 'title' => 'Help'],
       'CartPage' => ['url' => '/cart', 'icon' => 'fa-shopping-cart', 'title' => 'Cart'],
       'AccountPage' => ['url' => '/account', 'icon' => 'fa-user', 'title' => 'Account']
   ]; */
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
            <?php
            foreach ($userItems as $item) {
                if (isset($item['icon'])) {
                    // Nếu có icon, hiển thị dạng biểu tượng
                    echo '<a href="' . $item['url'] . '" title="' . $item['title'] . '"><i class="fa ' . $item['icon'] . '"></i></a>';
                } else {
                    // Nếu không có icon, hiển thị dạng văn bản
                    echo '<a href="' . $item['url'] . '">' . $item['name'] . '</a>';
                }
            }
            ?>
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
        /* Màu xanh trong suốt */
        backdrop-filter: blur(10px);
        /* Làm mờ nền phía sau */
        -webkit-backdrop-filter: blur(10px);
        /* Hỗ trợ Safari */
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

    .sys-nav,
    .user-nav {
        display: flex;
        gap: 15px;
    }

    .sys-nav {
        justify-self: center;
    }

    .spacer {
        flex: 1;
    }

    /* Định dạng cho mục active (dạng nút) */
    .nav a.active {
        background-color: #4E6CFB;
        /* Màu nền giống nút */
        border-radius: 50px;
        /* Bo tròn giống nút */
        color: white;
        /* Màu chữ */
        padding: 10px 20px;
        /* Khoảng cách bên trong để giống nút */
    }

    /* Đảm bảo hiệu ứng hover không ảnh hưởng đến mục active */
    .nav a.active:hover {
        background-color: #3b55d9;
        /* Giữ màu nền khi hover */
    }

    /* CSS mới để thêm z-index và định dạng biểu tượng */
    .nav {
        z-index: 999;
        /* Thêm z-index để đảm bảo nav luôn ở trên cùng */
    }

    .user-nav a i {
        font-size: 20px;
        /* Kích thước biểu tượng */
    }

    .toggle-nav {
        padding: 10px;
        /* Khoảng cách bên trong */
        min-width: 40px;
        /* Chiều rộng */
        color: white;
        border: none;
        /* Bỏ viền */
        display: none;
        /* Ẩn nút toggle */
        background-color: rgba(0, 0, 0, 0);
        /* Nền trong suốt */
        backdrop-filter: blur(10px);
        /* Thêm hiệu ứng blur phía sau */
        -webkit-backdrop-filter: blur(10px);
        /* Hỗ trợ cho các trình duyệt Webkit (Safari) */
    }

    @media screen and (max-width: 768px) {

        .sys-nav,
        .spacer {
            display: none;
        }

        .toggle-nav {
            display: block;
            /* Hiển thị nút toggle */
        }
    }
</style>

<script>
    document.querySelector('.toggle-nav').addEventListener('click', function () {
        document.querySelector('.sys-nav').classList.toggle('active');
        document.querySelector('.user-nav').classList.toggle('active');
        document.querySelector('.overlay').classList.toggle('active');
        document.body.classList.toggle('menu-active');
    });

    // Đóng menu khi click vào overlay
    document.querySelector('.overlay').addEventListener('click', function () {
        document.querySelector('.sys-nav').classList.remove('active');
        document.querySelector('.user-nav').classList.remove('active');
        document.querySelector('.overlay').classList.remove('active');
        document.body.classList.remove('menu-active');
    });
</script>