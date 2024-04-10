<?php
// Establish database connection
require '../../config/dbconfig.php';

// Check if connection is successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Admin Profile Password
                    </div>
                    <div class="card-body">
                    <?php
                        $query = "SELECT * FROM users where role_type=1";
                        $result = $mysqli->query($query);
                        
                        if (!$result) {
                            printf("Error: %s\n", $mysqli->error);
                            exit();
                        }

                        $row = $result->fetch_assoc();
                    ?>
                        <form id="productForm">
                            <div class="form-group">
                                <label for="opassword">Enter Old Password</label>
                                <input type="text" class="form-control" id="opassword" name="opassword">
                                <small class="text-danger" id="oError"></small>
                            </div>
                            <div class="form-group">
                                <label for="npassword">Enter New Password</label>
                                <input type="text" class="form-control" id="npassword" name="npassword">
                                <small class="text-danger" id="nError"></small>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#productForm').submit(function(e){
                e.preventDefault();
                var opassword = $('#opassword').val();
                var npassword = $('#npassword').val();

                // Reset error messages
                $('.text-danger').text('');

                // Validate form fields
                var isValid = true;
                if(opassword.trim() == '') {
                    $('#oError').text('Old password is required');
                    isValid = false;
                }
                if(npassword.trim() == '') {
                    $('#nError').text('New password is required');
                    isValid = false;
                }
                
                if(isValid) {
                    $.ajax({
                        url: '../../class/update_admin_password.php',
                        type: 'post',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            alert(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
