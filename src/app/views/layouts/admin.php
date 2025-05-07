<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (!empty($page_title)) ? $page_title : "Admin Dashboard" ?></title>
    <?php include "imports.php"; ?>
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/assets/static/css/base/admin/bootstrap-override.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>

<body id="body-pd">
    <?php
    $this->render('components/Header/Admin/index');
    $this->render('components/Sidebar/index', ['menu' => [
        [
            'name' => 'Dashboard',
            'icon' => 'bi bi-house',
            'link' => _WEB_ROOT . '/dashboard',
        ],
        [
            'name' => 'Users',
            'icon' => 'bi bi-person',
            'link' => _WEB_ROOT . '/users-management',
        ],
        [
            'name' => 'Cars',
            'icon' => 'bi bi-car-front-fill',
            'link' => _WEB_ROOT . '/cars-management',
        ],
        [
            'name' => 'Blogs',
            'icon' => 'bi bi-postcard-heart',
            'link' => _WEB_ROOT . '/blogs-management',
        ],
        [
            'name' => 'Categories',
            'icon' => 'bi bi-tags',
            'link' => _WEB_ROOT . '/categories-management',
        ],
        [
            'name' => 'Settings',
            'icon' => 'bi bi-gear',
            'link' => _WEB_ROOT . '/settings',
        ]
    ]]);
    $this->render('pages/' . $view,  $content);
    ?>
    <script src="<?php echo _WEB_ROOT ?>/assets/static/js/admin.js"></script>
</body>


</html>