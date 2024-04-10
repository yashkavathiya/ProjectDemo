<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["role"])) {
    header("Location: ../login.php");
}
if (isset($_SESSION["role"])) {
    if ($_SESSION['role'] == 'user') {
        header("Location: ./../user/home.php");
        exit;
    }
}

session_start(); // Start session to access session data
session_destroy(); // Destroy all session data
header("Location: ../login.php"); // Redirect to login page after logout
exit;
