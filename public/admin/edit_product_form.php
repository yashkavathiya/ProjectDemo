<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["role"])) {
    header("Location: ../public/login.php");
}
if (isset($_SESSION["role"])) {
    if ($_SESSION['role'] == 'user') {
        header("Location: ./../public/user/home.php");
        exit;
    }
}

// Assuming $existingProduct is already defined in your script
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Edit Product
                    </div>
                    <div class="card-body">
                        <form id="editProductForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $existingProduct['name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $existingProduct['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <img src="../assets/images/products/<?php echo $existingProduct['image']; ?>" height="80px" width="80px" alt="Product Image">
                                <input type="file" class="form-control-file" id="image" name="image">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?php echo $existingProduct['price']; ?>">
                            </div>
                            <input type="hidden" name="id" value="<?php echo $existingProduct['id']; ?>">
                            <button type="button" id="updateButton" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#updateButton').click(function() {
                // Serialize form data
                var formData = new FormData($('#editProductForm')[0]);

                // Send AJAX request
                $.ajax({
                    url: '../class/edit_product.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status == 200) {
                            Swal.fire("Success", data.message, "success").then(() => {
                                window.location.href = "../public/admin/home.php";
                            });
                        } else {
                            Swal.fire("Error", data.message, "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire("Error", "An error occurred while processing your request.", "error");
                    }
                });
            });
        });
    </script>
</body>

</html>
