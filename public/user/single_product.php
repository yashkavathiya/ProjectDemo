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
    <title>Single Product View</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Single Product View
                    </div>
                    <div class="card-body">
                    <?php
                        $productId = $_GET['id'];
                        $query = "SELECT * FROM products where id=$productId";
                        $result = $mysqli->query($query);
                        
                        if (!$result) {
                            printf("Error: %s\n", $mysqli->error);
                            exit();
                        }

                        $row = $result->fetch_assoc();
                    ?>
                        <div class="form-group">
                            <label for="name">Name</label>:-<?php echo $row['name']; ?>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <img src="../../assets/images/products/<?php echo $row['image']; ?>" height="80px" width="80px" alt="Product Image">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>:-<?php echo $row['description']; ?>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>:-<?php echo $row['price']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
