<html lang="en">
<head>
    <title><?php echo (!empty($page_title)) ? $page_title : "Trang chủ" ?></title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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