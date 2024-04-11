<?php
// Establish database connection
require '../../config/dbconfig.php';

// Check if connection is successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../../assets/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chilanka&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <style>
        /* Add custom styles here if needed */
        .bg-info {
            background-color: #F9F3EC !important;
        }

        .navbar {
            background-color: #edd0af !important;
        }

        .product-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body class="bg-info">
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-sm">
                <!-- Brand -->
                <a class="navbar-brand" href="#"><?php if (isset($_SESSION["username"])) {
                                                        echo $_SESSION["username"];
                                                    } ?></a>
                <!-- Links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mt-2">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link" href="#product-list">Product</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link" href="./view_profile.php">Profile</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link" href="./change_password.php">Password</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link" href="./logout.php">Logout</a>
                    </li>
                </ul>
                <?php
                if (!empty($_SESSION['shopping_cart'])) {
                ?>
                    <div class="cart">
                        <a href="#" class="mx-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <iconify-icon icon="mdi:cart" class="fs-4 position-relative"></iconify-icon>
                            <span class="position-absolute translate-middle badge rounded-circle bg-primary pt-2">
                                <?php
                                echo count($_SESSION['shopping_cart']);
                                ?>
                            </span>
                        </a>
                    </div>
                <?php } ?>
            </nav>
        </div>
    </header>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
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
                <img src="../../assets/images/products/<?php echo $row['image']; ?>" class="product-image" alt="Product Image">
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Single Product View
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>: <?php echo $row['name']; ?>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>: <?php echo $row['description']; ?>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>: <?php echo $row['price']; ?>
                        </div>
                    </div>
                </div>
                <form method="post" action="home.php?action=add&page=single&id=<?php echo $row['id']; ?>"><input type="hidden" name="hidden_title" value="<?php echo $row['name']; ?>"><input type="hidden" name="hidden_price" value="<?php echo $row['price']; ?>"><button name="add_to_cart" class="btn btn-secondary btn-xs float-end add-cart" data-id="<?php echo $row['id']; ?>"><i class="fa fa-cart-arrow-down"></i> Add To Cart</button></form>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <?php
    if (!empty($_SESSION['shopping_cart'])) {
    ?>
      <div class="offcanvas-body">
        <div class="order-md-last">

          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Your cart</span>
            <span class="badge bg-primary rounded-circle pt-2">
              <?php
              if (!empty($_SESSION['shopping_cart'])) {
                echo count($_SESSION['shopping_cart']);
              }
              ?>
            </span>
          </h4>
          <ul class="list-group mb-3">
            <?php
            $total = 0;
            foreach ($_SESSION['shopping_cart'] as $keys => $values) {
            ?>
              <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                  <h6 class="my-0"><?php echo $values['item_title']; ?></h6>
                  <a href="home.php?action=delete&id=<?php echo $values["item_id"]; ?>"><small class="text-xs text-danger">Remove</small></a>
                </div>
                <span class="text-body-secondary">$<?php echo $values['item_price']; ?></span>
              </li>
            <?php
              $total += $values['item_price'];
            } ?>
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-bold">Total (USD)</span>
              <strong>$<?php echo $total; ?></strong>
            </li>
          </ul>

          <a href="home.php?action=checkout" class="w-100 btn btn-primary btn-lg">Continue to checkout</a>
        </div>
      </div>
    <?php } ?>
  </div>
  <script src="../../assets/js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="../../assets/js/plugins.js"></script>
  <script src="../../assets/js/script.js"></script>
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>