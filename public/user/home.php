<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <style>
    /* Add custom styles here if needed */
  </style>
</head>

<body class="bg-info">
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="#">UI-MONK</a>
    <!-- Links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item mt-2">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="#">Shop</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="#">My Account</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="#">Contact</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link" href="./logout.php">Logout</a>
      </li>
    </ul>
  </nav>
  <section id="banner" style="background: #F9F3EC;">
    <div class="container">
      <div class="swiper main-swiper">
        <div class="swiper-wrapper">

          <div class="swiper-slide py-5">
            <div class="row banner-content align-items-center">
              <div class="img-wrapper col-md-5">
                <img src="images/banner-img.png" class="img-fluid">
              </div>
              <div class="content-wrapper col-md-7 p-5 mb-5">
                <div class="secondary-font text-primary text-uppercase mb-4">Save 10 - 20 % off</div>
                <h2 class="banner-title display-1 fw-normal">Best destination for <span class="text-primary">your
                    pets</span>
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
                <img src="images//banner-img3.png" class="img-fluid">
              </div>
              <div class="content-wrapper col-md-7 p-5 mb-5">
                <div class="secondary-font text-primary text-uppercase mb-4">Save 10 - 20 % off</div>
                <h2 class="banner-title display-1 fw-normal">Best destination for <span class="text-primary">your
                    pets</span>
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
                <img src="images/banner-img4.png" class="img-fluid">
              </div>
              <div class="content-wrapper col-md-7 p-5 mb-5">
                <div class="secondary-font text-primary text-uppercase mb-4">Save 10 - 20 % off</div>
                <h2 class="banner-title display-1 fw-normal">Best destination for <span class="text-primary">your
                    pets</span>
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
    echo '<div class="content mt-5">';
    echo '<ul class="rig columns-4">';

    // Loop through each product
    while ($row = $result->fetch_assoc()) {
      echo '<li>';
      $imagePath = '../../assets/images/products/' . $row['image']; // Adjust path accordingly
      echo '<!-- Debug: Image Path: ' . $imagePath . ' -->';
      echo '<a href="#"><img class="product-image" src="' . $imagePath . '"></a>';
      echo '<h4>' . $row['title'] . '</h4>';
      echo '<p>' . $row['description'] . '</p>';
      echo '<div class="price">$' . $row['price'] . '</div>';
      echo '<hr>';
      echo '<button class="btn btn-default btn-xs pull-right" type="button">';
      echo '<i class="fa fa-cart-arrow-down"></i> Add To Cart';
      echo '</button>';
      echo '<button class="btn btn-default btn-xs pull-left" type="button">';
      echo '<a href="single_product.php?id=' . $row['id'] . '" class="fa fa-eye">Details</a>';
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
  <script src="../../assets/js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="../../assets/js/plugins.js"></script>
  <script src="../../assets/js/script.js"></script>
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>

</html>