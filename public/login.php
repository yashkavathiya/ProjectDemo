<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../class/Common.php';
require '../config/dbconfig.php';

$GLOBALS['mysqli'] = $mysqli;
$title = "Login";

$style =
    "<style>
    .login-container {
        max-width: 400px;
        margin: auto;
        margin-top: 100px;
    }
</style>";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $h = new Common();
    $count = $h->Login($email, $password, 'users');

    if ($count != 0) {
        $_SESSION['email'] = $email;

        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $mysqli->real_escape_string($_POST['password']);
        
        $query = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
        $result = $mysqli->query($query);
        
        if ($result) {
            $partner = $result->fetch_assoc();
            if ($partner['role_type'] == '1') {
                $_SESSION['role'] = 'admin';
                header("Location: admin/home.php");
                exit;
            } else {
                $_SESSION['role'] = 'user';
                header("Location: user/home.php");
                exit;
            }
        } else {
            echo "Query error: " . $mysqli->error;
        }
    } else {
        echo "Invalid email or password";
    }
}

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin' && basename($_SERVER['PHP_SELF']) == 'user/home.php') {
        header("Location: admin/home.php");
        exit;
    } elseif ($_SESSION['role'] == 'user' && basename($_SERVER['PHP_SELF']) == 'admin/home.php') {
        header("Location: user/home.php");
        exit;
    }
}
?>

<?php include('./admin/includes/admin_header.php'); ?>
<div class="container login-container">
    <h2 class="text-center mb-4">Login</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-primary">Register</a>
        </div>
    </form>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/jquery-3.7.1.js"></script>
<?php include('./admin/includes/admin_footer.php'); ?>