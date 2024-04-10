<?php
require '../config/dbconfig.php'; // Assuming dbconfig.php contains the database connection information and $mysqli object is created there.

class Product {
    private $mysqli;

    // Constructor to initialize the $mysqli property
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function saveProduct($name, $description, $price, $image) {
        // Process uploaded file
        $file_name = '';
        if($image['error'] == 0) {
            $file_name = $image['name'];
            move_uploaded_file($image['tmp_name'], '../assets/images/products/' . $file_name);
        }

        // Prepare SQL statement to prevent SQL injection
        $stmt = $this->mysqli->prepare("INSERT INTO products (name, description, price, image, created_at) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->bind_param("ssds", $name, $description, $price, $file_name);

        // Execute the statement
        $result = $stmt->execute();

        // Check if execution was successful
        if($result) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
}

// Usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have $mysqli object available here from your dbconfig.php
    $product = new Product($mysqli);

    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_FILES['image'];

    if ($product->saveProduct($name, $description, $price, $image)) {
        $data['status'] = 200; 
        $data['message'] = "Product saved successfully!"; 
    } else {
        $data['status'] = 400; 
        $data['message'] = "Error occurred while saving product."; 
    }
    echo json_encode($data);
}
?>
