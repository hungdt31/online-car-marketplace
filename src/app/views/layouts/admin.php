<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo (!empty($page_title)) ? $page_title : "Trang chủ" ?></title>
    <?php include "imports.php"; ?>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/css/main.css" />
</head>

<body>
    <?php
    echo '<div style="min-height: 100vh; display: flex; flex-direction: column;">';
    $this->render('components/header');
    echo '<div style="flex: 1;">';
    $this->render('pages/'. $view, $content);
    echo '</div>';
    $this->render('components/footer');
    echo '</>';
    ?>
</body>
</html>