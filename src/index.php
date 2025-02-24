<?php
session_start();
$_SESSION['username'] = 'JohnDoe';
require_once "bootstrap.php";
require 'vendor/autoload.php';
$app = new App();