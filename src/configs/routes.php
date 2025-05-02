<?php
$routes['default_controller'] = 'home';
$routes['san-pham'] = 'product/index';
$routes['san-pham/chi-tiet/(:num)'] = 'product/detail/$1'; // Chỉ chấp nhận số
$routes['trang-chu'] = 'home';
$routes['tin-tuc/.+-(\d+).html'] = 'news/category/$1';
$routes['contact'] = 'home/contact';
$routes['account'] = 'user/account';
$routes['auth/google-redirect'] = 'auth/googleAuth';
$routes['auth/facebook-redirect'] = 'auth/facebookAuth';
$routes['cars-management'] = 'admin/cars';
$routes['car-assets/(:num)'] = 'admin/cars/assets/$1';
$routes['dashboard'] = 'admin/dashboard';
$routes['blogs-management'] = 'admin/posts';
$routes['forgot-password'] = 'auth/forgotPassword';
$routes['reset-password'] = 'auth/resetPassword';