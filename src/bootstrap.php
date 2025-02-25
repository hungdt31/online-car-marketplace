<?php
if (!defined('_DIR_ROOT')) {
    define('_DIR_ROOT', dirname(__FILE__));
}

// handle http root
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = 'https://'.$_SERVER['HTTP_HOST'];
} else {
    $web_root = 'http://'.$_SERVER['HTTP_HOST'];
}

$lastPart = basename(_DIR_ROOT);
$web_root = $web_root.'/'.$lastPart;

if (!defined('_WEB_ROOT')) {
    define('_WEB_ROOT', $web_root);
}

$dir_arr = [
    'core',
    'configs',
    'libs'
];
foreach ($dir_arr as $dir) {
    if (is_dir(_DIR_ROOT.'/'.$dir)) {
        $dir_files = scandir(_DIR_ROOT.'/'.$dir);
        if (!empty($dir_files)) {
            foreach ($dir_files as $file) {
                if ($file != '.' && $file != '..' && file_exists(_DIR_ROOT.'/'.$dir.'/'.$file)) {
                    require_once _DIR_ROOT.'/'.$dir.'/'.$file;
                }
            }
        }
    }
}
require_once _DIR_ROOT . '/app/App.php';
