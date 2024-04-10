<?php
$title = "Product List";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./../../assets/css/bootstrap.min.css" rel="stylesheet">

    <title><?php if (isset($title)) {
                echo $title;
            } ?></title>
    <?php
    if (isset($style)) {
        echo $style;
    }
    ?>
</head>

<body>
    <div class="container mt-5">
        <div class="">
            <h2 class="text-center mb-4">Product List</h2>
            <button class="btn btn-primary">Add</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="https://via.placeholder.com/100" alt="Product Image"></td>
                        <td>Product 1</td>
                        <td>$100</td>
                        <td><a href="#" class="btn btn-primary">View Details</a></td>
                    </tr>
                    <tr>
                        <td><img src="https://via.placeholder.com/100" alt="Product Image"></td>
                        <td>Product 2</td>
                        <td>$150</td>
                        <td><a href="#" class="btn btn-primary">View Details</a></td>
                    </tr>
                    <tr>
                        <td><img src="https://via.placeholder.com/100" alt="Product Image"></td>
                        <td>Product 3</td>
                        <td>$200</td>
                        <td><a href="#" class="btn btn-primary">View Details</a></td>
                    </tr>
                    <!-- Add more rows for additional products -->
                </tbody>
            </table>
        </div>
    </div>
    <script src="./../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="./../../assets/js/jquery-3.7.1.js"></script>
</body>

</html>