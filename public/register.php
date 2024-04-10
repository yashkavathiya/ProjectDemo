<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../class/Common.php';
require '../config/dbconfig.php';

$GLOBALS['mysqli'] = $mysqli;
$title = "Register";
$style =
    "<style>
    .login-container {
        max-width: 400px;
        margin: auto;
        margin-top: 100px;
    }
</style>";
include('./admin/includes/admin_header.php');
?>
<div class="container login-container">
    <h2 class="text-center mb-4">Register Here</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <!-- <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary">Register</button>
        </div> -->
    </form>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/jquery-3.7.1.js"></script>
<?php include('./admin/includes/admin_footer.php'); ?>