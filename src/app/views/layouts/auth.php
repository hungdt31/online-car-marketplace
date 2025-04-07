<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo (!empty($page_title)) ? $page_title : "Trang chủ" ?></title>
    <?php require "imports.php"; ?>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT ?>/assets/static/css/auth.css" />
</head>

<body>
    <?php
    $this->render('pages/'. $view, $content);
    ?>
    <script type="text/javascript" src="<?php echo _WEB_ROOT ?>/assets/static/js/auth.js"></script>
</body>

</html>