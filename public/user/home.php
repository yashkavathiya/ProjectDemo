<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Establish database connection
require '../../config/dbconfig.php';

// Check if connection is successful
if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION["role"])) {
  header("Location: ../login.php");
}
if (isset($_SESSION["role"])) {
  if ($_SESSION['role'] == 'admin') {
    header("Location: ./../admin/home.php");
    exit;
  }
}
if (isset($_POST['add_to_cart'])) {
  if (isset($_SESSION['shopping_cart'])) {
    $item_aray_id = array_column($_SESSION['shopping_cart'], 'item_id');
    if (!in_array($_GET['id'], $item_aray_id)) {
      $count = count($_SESSION['shopping_cart']);
      $item_array = array(
        'item_id' => $_GET['id'],
        'item_title' => $_POST['hidden_title'],
        'item_price' => $_POST['hidden_price'],
      );
      $_SESSION['shopping_cart'][$count] = $item_array;
    } else {
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
          Swal.fire({
            text: responseData.message,
            icon: "success"
          });
      </script>;
<?php
      if (!isset($_GET['page'])) {
        echo '<script>window.location="home.php"</script>';
      } else {
        echo "<script>window.location='single_product.php?id=" . $_GET['id'] . "'</script>";
      }
    }
  } else {
    $item_array = array(
      'item_id' => $_GET['id'],
      'item_title' => $_POST['hidden_title'],
      'item_price' => $_POST['hidden_price'],
    );
    $_SESSION['shopping_cart'][0] = $item_array;
  }
}

if (isset($_GET['action'])) {
  if ($_GET['action'] == "delete") {
    foreach ($_SESSION['shopping_cart'] as $keys => $values) {
      if ($values['item_id'] == $_GET['id']) {
        unset($_SESSION['shopping_cart'][$keys]);
        echo '<script>alert("Product Removed")</script>';
        echo '<script>window.location="home.php"</script>';
      }
    }
  }
  if ($_GET['action'] == "checkout") {
    if (isset($_SESSION['shopping_cart'])) {
      unset($_SESSION['shopping_cart']);
      echo '<script>alert("Checkout Success")</script>';
      echo '<script>window.location="home.php"</script>';
    }
  }
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
  <section id="banner" style="background: #F9F3EC;">
    <div class="container">
      <div class="swiper main-swiper">
        <div class="swiper-wrapper">

          <div class="swiper-slide py-5">
            <div class="row banner-content align-items-center">
              <div class="img-wrapper col-md-5">
                <img src="./../../assets/images/defaults/01.jpg" class="img-fluid">
              </div>
              <div class="content-wrapper col-md-7 p-5 mb-5">
                <div class="secondary-font text-primary text-uppercase mb-4">Save 10 - 20 % off</div>
                <h2 class="banner-title display-1 fw-normal">Best Product 1
                </h2>
                <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                  shop now
                  <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                    <use xlink:href="#arrow-right"></use>
                  </svg></a>
              </div>

            </div>
          </div>
          <div class="swiper-slide py-5">
            <div class="row banner-content align-items-center">
              <div class="img-wrapper col-md-5">
                <img src="./../../assets/images/defaults/01.jpg" class="img-fluid">
              </div>
              <div class="content-wrapper col-md-7 p-5 mb-5">
                <div class="secondary-font text-primary text-uppercase mb-4">Save 10 - 20 % off</div>
                <h2 class="banner-title display-1 fw-normal">Best Product 2
                </h2>
                <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                  shop now
                  <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                    <use xlink:href="#arrow-right"></use>
                  </svg></a>
              </div>

            </div>
          </div>
          <div class="swiper-slide py-5">
            <div class="row banner-content align-items-center">
              <div class="img-wrapper col-md-5">
                <img src="./../../assets/images/defaults/01.jpg" class="img-fluid">
              </div>
              <div class="content-wrapper col-md-7 p-5 mb-5">
                <div class="secondary-font text-primary text-uppercase mb-4">Save 10 - 20 % off</div>
                <h2 class="banner-title display-1 fw-normal">Best Product 3
                </h2>
                <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                  shop now
                  <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                    <use xlink:href="#arrow-right"></use>
                  </svg></a>
              </div>

            </div>
          </div>
        </div>

        <div class="swiper-pagination mb-5"></div>

      </div>
    </div>
  </section>
  <?php
  $query = "SELECT * FROM products";
  $result = $mysqli->query($query);

  // Check for errors during query execution  
  if (!$result) {
    printf("Error: %s\n", $mysqli->error);
    exit();
  }

  if ($result->num_rows > 0) {
    echo '<div class="content mt-5" id="product-list">';
    echo '<ul class="rig columns-4">';

    // Loop through each product
    while ($row = $result->fetch_assoc()) {
      echo '<li>';
      $imagePath = '../../assets/images/products/' . $row['image']; // Adjust path accordingly
      echo '<!-- Debug: Image Path: ' . $imagePath . ' -->';
      echo '<a href="#"><img class="product-image" src="' . $imagePath . '"></a>';
      echo '<h4>' . $row['name'] . '</h4>';
      echo '<p>' . $row['description'] . '</p>';
      echo '<div class="price">$' . $row['price'] . '</div>';
      echo '<hr>';
      echo "<form method='post' action='home.php?action=add&id=" . $row['id'] . "'>";
      echo "<input type='hidden' name='hidden_title' value='" . $row["name"] . "'>";
      echo '<input type="hidden" name="hidden_price" value="' . $row["price"] . '">';
      echo '<button name="add_to_cart" class="btn btn-secondary btn-xs float-end add-cart" data-id="' . $row["id"] . '">';
      echo '<i class="fa fa-cart-arrow-down"></i> Add To Cart';
      echo '</button>';
      echo '</form>';
      // echo '<button class="btn btn-default btn-xs pull-left" type="button">';
      echo '<button class="btn btn-secondary btn-xs pull-left" onclick="location.href=\'single_product.php?id=' . $row['id'] . '\'"><i class="fa fa-eye"></i> Details</button>';
      echo '</button>';
      echo '</li>';
    }

    echo '</ul>';
    echo '</div>';
  } else {
    echo 'No products found.';
  }

  // Close database connection
  $mysqli->close();
  ?>
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
  <div id="footer-bottom">
    <div class="container">
      <hr class="m-0">
      <div class="row mt-3">
        <div class="col-md-6 copyright">
          <p class="secondary-font">© 2024 Woodshop. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <p class="secondary-font">Free HTML Template by <a href="https://templatesjungle.com/" target="_blank"
              class="text-decoration-underline fw-bold text-black-50"> TemplatesJungle</a> </p>
          <p class="secondary-font">Distributed by <a href="https://themewagon.com/" target="_blank"
              class="text-decoration-underline fw-bold text-black-50"> ThemeWagon</a> </p>
        </div>
      </div>
    </div>
  </div>
  <script src="../../assets/js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="../../assets/js/plugins.js"></script>
  <script src="../../assets/js/script.js"></script>
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>

</html>