<?php
$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$password_file_path = getenv('PASSWORD_FILE_PATH');
$db_pass = trim(file_get_contents($password_file_path));

$config['database'] = [
    'host' => $db_host,
    'user' => $db_user,
    'pass' => $db_pass,
    'db' => $db_name,
];