<?php
require '../config/dbconfig.php';

class Product {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getProduct($productId) {
        $stmt = $this->mysqli->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        return $product;
    }

    public function updateProduct($productId, $name, $description, $price, $image) {
        $stmt = $this->mysqli->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssdsi", $name, $description, $price, $image, $productId); // fixed bind_param parameters
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function closeConnection() {
        $this->mysqli->close();
    }
}

// Check if product ID is provided via GET request
if(isset($_GET['id'])) {
    // Create an instance of the Product class
    $product = new Product($mysqli);

    // Get the product ID from GET data
    $productId = $_GET['id'];

    // Get the existing product data
    $existingProduct = $product->getProduct($productId);

    if ($existingProduct) {
        // Check if form is submitted for updating the product
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $image = $_POST["image"];

            // Update the product and echo the result
            if ($product->updateProduct($productId, $name, $description, $price,$image)) {
                echo "Product updated successfully!";
            } else {
                echo "Error occurred while updating product.";
            }

            // Close database connection
            $product->closeConnection();
        } else {
            // Include the HTML form
            include '../public/admin/edit_product_form.php';
        }
    } else {
        echo "Product not found.";
    }
}

if(isset($_POST['id'])) {
    // Create an instance of the Product class
    $product = new Product($mysqli);

    // Get the product ID from POST data
    $productId = $_POST['id'];

    // Get the existing product data
    $existingProduct = $product->getProduct($productId);

    if ($existingProduct) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            if(!empty($_FILES["image"]['name'])) {
                $image = $_FILES["image"]['name'];
                move_uploaded_file($_FILES["image"]['tmp_name'], '../assets/images/products/' . $image);
            } else {
                $image = $existingProduct['image'];
            }
            
            // Update the product and echo the result
            if ($product->updateProduct($productId, $name, $description, $price, $image)) {
                $data['status'] = 200; 
                $data['message'] = "Product updated successfully!"; 
            } else {
                $data['status'] = 400; 
                $data['message'] = "Error occurred while saving product."; 
            }

            // Close database connection
            $product->closeConnection();
        } else {
            // Include the HTML form
            include '../public/admin/edit_product_form.php';
        }
    } else {
        $data['status'] = 400; 
        $data['message'] = "Product not found"; 
    }
    echo json_encode($data);
}

?>
