<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo (!empty($page_title)) ? $page_title : "Trang chủ" ?></title>
    <link rel="icon" href="<?php echo _WEB_ROOT ?>/assets/static/images/carvan-logo.png" type="image/x-icon" />
    <?php include "imports.php"; ?>
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/assets/static/css/base/user/bootstrap-override.css" />
</head>

<body>
    <?php
    echo '<div style="min-height: 100vh; display: flex; flex-direction: column;">';
    $this->render('components/Header/index');
    echo '<div style="flex: 1;">';
    $this->render('pages/'. $view,  $content);
    echo '</div>';
    $this->render('components/Footer/index');
    echo '</div>';
    ?>
</body>

</html>