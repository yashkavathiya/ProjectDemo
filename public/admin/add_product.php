<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["role"])) {
    if ($_SESSION['role'] == 'user') {
        header("Location: ./../user/home.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Product Form
                    </div>
                    <div class="card-body">
                        <form id="productForm">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                                <small class="text-danger" id="nameError"></small>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                <small class="text-danger" id="descriptionError"></small>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" id="image" name="image">
                                <small class="text-danger" id="fileError"></small>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price">
                                <small class="text-danger" id="priceError"></small>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#productForm').submit(function(e) {
                e.preventDefault();
                var name = $('#name').val();
                var description = $('#description').val();
                var price = $('#price').val();

                // Reset error messages
                $('.text-danger').text('');

                // Validate form fields
                var isValid = true;
                if (name.trim() == '') {
                    $('#nameError').text('Name is required');
                    isValid = false;
                }
                if (description.trim() == '') {
                    $('#descriptionError').text('Description is required');
                    isValid = false;
                }
                if (price.trim() == '') {
                    $('#priceError').text('Price is required');
                    isValid = false;
                }

                // Submit form if valid
                if (isValid) {
                    // Perform AJAX request to save data
                    $.ajax({
                        url: '../../class/save_product.php',
                        type: 'post',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var responseData = JSON.parse(response);
                            if (responseData.status == 200) {
                                Swal.fire({
                                    text: responseData.message,
                                    icon: "success"
                                });
                                $('#productForm')[0].reset();
                            } else {
                                Swal.fire({
                                    text: responseData.message,
                                    icon: "error"
                                });
                            }
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