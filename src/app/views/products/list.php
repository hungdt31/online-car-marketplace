<?php
echo '<h1>';
print_r($title);
echo '</h1>';

echo '<ul>';
foreach ($product_list as $product) {
    echo '<li>';
    echo $product;
    echo '</li>';
};
echo '</ul>';

