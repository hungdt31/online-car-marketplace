<?php
session_start();
$_SESSION['username'] = 'JohnDoe';
require_once "bootstrap.php";
require_once 'vendor/autoload.php';
$app = new App();