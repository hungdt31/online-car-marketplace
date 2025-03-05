<?php
$routes['default_controller'] = 'home';
$routes['san-pham'] = 'product/index';
$routes['san-pham/chi-tiet/(:num)'] = 'product/detail/$1'; // Chỉ chấp nhận số
$routes['trang-chu'] = 'home';
$routes['tin-tuc/.+-(\d+).html'] = 'news/category/$1';
$routes['contact'] = 'home/contact';
$routes['account'] = 'user/account';