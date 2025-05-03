<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo (!empty($page_title)) ? $page_title : "Trang chủ" ?></title>
    <?php require "imports.php"; ?>
    <?php 
        if ($page_title != "Reset password") {
            echo '<link type="text/css" rel="stylesheet" href="'. _WEB_ROOT .'/assets/static/css/auth.css" />';
        }
    ?>
</head>

<body>
    <?php
    $this->render('pages/'. $view, $content);
    ?>
    <!-- <script type="text/javascript" src="<?php echo _WEB_ROOT ?>/assets/static/js/pages/auth.js"></script> -->
</body>

</html>