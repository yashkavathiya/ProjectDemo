<?php
session_start(); // Start session to access session data
session_destroy(); // Destroy all session data
header("Location: ../login.php"); // Redirect to login page after logout
exit;
?>
