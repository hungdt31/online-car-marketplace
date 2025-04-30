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
        margin-left: auto; /* Đẩy user-nav sang phải */
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
            top: 20px; /* Đặt ở trên cùng */
            right: 70px; /* Cách nút toggle */
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
    }
</style>

<script>
    document.querySelector('.toggle-nav').addEventListener('click', function() {
        document.querySelector('.sys-nav').classList.toggle('active');
        document.querySelector('.user-nav').classList.toggle('active');
        document.querySelector('.overlay').classList.toggle('active');
        document.body.classList.toggle('menu-active');
    });

    // Đóng menu khi click vào overlay
    document.querySelector('.overlay').addEventListener('click', function() {
        document.querySelector('.sys-nav').classList.remove('active');
        document.querySelector('.user-nav').classList.remove('active');
        document.querySelector('.overlay').classList.remove('active');
        document.body.classList.remove('menu-active');
    });
</script>