<?php
require_once _DIR_ROOT.'/app/views/blocks/header.php';
echo '<h1>';
print_r($title);
echo '</h1>';
echo $info;
require_once _DIR_ROOT.'/app/views/blocks/footer.php';