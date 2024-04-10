<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$host = "localhost";
$user = "root";
$password = '';
$db_name = "woodshop";

$mysqli = mysqli_connect($host, $user, $password, $db_name);
if (mysqli_connect_errno()) {
  die("Failed to connect with MySQL: " . mysqli_connect_error());
}else{
  $mysqli->set_charset("utf8mb4");
}
