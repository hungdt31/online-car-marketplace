<html lang="en">
<head>
    <title><?php echo (!empty($page_title)) ? $page_title : "Trang chủ" ?></title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/clients/css/style.css"/>
</head>
<body>
    <?php
        $this->render('blocks/header');
        $this->render($content, $sub_content);
        $this->render('blocks/footer');
    ?>
    <script type="text/javascript" src="<?php echo _WEB_ROOT ?>/public/assets/clients/js/script.js"></script>
</body>
</html>