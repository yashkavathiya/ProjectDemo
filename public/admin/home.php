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
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product List</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <button onclick="window.location.href='view_profile.php';">View Profile</button>
                    <button onclick="window.location.href='change_password.php';">Change Password</button>
                    <button onclick="window.location.href='logout.php';">Logout</button>
                    <div class="card">
                        <button onclick="window.location.href='add_product.php';">Add Product</button>
                        <div class="card-header">
                            Product List
                        </div>
                        <div class="card-body">
                            <table class="table" id="list">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Product data will be dynamically populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap and jQuery scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Function to fetch and display product data
            function fetchProducts() {
                $.ajax({
                    url: '../../class/fetch_products.php',
                    type: 'GET',
                    success: function(response) {
                        // Parse the JSON response
                        var products = JSON.parse(response);

                        // Clear existing table rows
                        $('tbody').empty();

                        // Iterate through each product and append to table
                        $.each(products, function(index, product) {
                            var row = '<tr>';
                            row += '<td>' + product.id + '</td>';
                            row += '<td>' + product.name + '</td>';
                            row += '<td>' + product.description + '</td>';
                            row += '<td>' + product.price + '</td>';
                            row += '<td>';
                            row += '<button class="btn btn-sm btn-primary" onclick="editProduct(' + product.id + ')">Edit</button>';
                            row += '<button class="btn btn-sm btn-danger ml-2" onclick="deleteProduct(' + product.id + ')">Delete</button>';
                            row += '</td>';
                            row += '</tr>';
                            $('tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to handle edit product button click
            function editProduct(productId) {
                // Redirect to edit page with product ID parameter
                window.location.href = '../../class/edit_product.php?id=' + productId;
            }

            // Function to handle delete product button click
            function deleteProduct(productId) {
                if (confirm('Are you sure you want to delete this product?')) {
                    $.ajax({
                        url: '../../class/delete_product.php',
                        type: 'POST',
                        data: {
                            id: productId
                        },
                        success: function(response) {
                            var responseData = JSON.parse(response);
                            if (responseData.status == 200) {
                                Swal.fire({
                                    text: responseData.message,
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload(); // Reload the entire page
                                    }
                                });
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
            }

            // Fetch products when page loads
            $(document).ready(function() {
                fetchProducts();
            });
        </script>
    </body>

    </html>