<?php
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
require '../config/dbconfig.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    $stmt = $this->mysqli->prepare("INSERT INTO users (name, email, phone, password,role_type, created_at) VALUES (?, ?, ?, ?,2, CURRENT_TIMESTAMP)");
    $stmt->bind_param("ssss", $name, $email, $phone, $password);

    // Execute the statement
    $result = $stmt->execute();

    // Check if execution was successful
    if($result) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}
?>
<div class="container login-container">
    <h2 class="text-center mb-4">Register Here</h2>
    <form method="post" enctype="multipart/form-data" id="registerForm">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="number" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary">Register</button>
        </div>
    </form>
</div>  
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/jquery-3.7.1.js"></script>
<script>
        $(document).ready(function(){
            $('#registerForm').submit(function(e){
                e.preventDefault();
                var name = $('#name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var password = $('#password').val();

                // Reset error messages
                $('.text-danger').text('');

                // Validate form fields
                var isValid = true;
                // if(name.trim() == '') {
                //     $('#nameError').text('Name is required');
                //     isValid = false;
                // }
                // if(description.trim() == '') {
                //     $('#descriptionError').text('Description is required');
                //     isValid = false;
                // }
                // if(price.trim() == '') {
                //     $('#priceError').text('Price is required');
                //     isValid = false;
                // }

                // Submit form if valid
                if(isValid) {
                    // Perform AJAX request to save data
                    $.ajax({
                        url: '../class/save_user.php',
                        type: 'post',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            alert(response);
                            // You can perform further actions here, like redirecting to a different page.
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
<?php include('./admin/includes/admin_footer.php'); ?>