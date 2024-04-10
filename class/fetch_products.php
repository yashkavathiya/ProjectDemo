<?php
require '../config/dbconfig.php'; // Assuming dbconfig.php contains the database connection information and $mysqli object is created there.

class Product {
    private $mysqli;

    // Constructor to initialize the $mysqli property
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function fetchProducts() {
        $sql = "SELECT * FROM `products`";
        $result = $this->mysqli->query($sql);
        
        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result->fetch_assoc()) {
                $products[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'price' => $row['price'],
                    'image' => $row['image']
                );
            }
            return $products;
        } else {
            return array();
        }
    }

    public function closeConnection() {
        $this->mysqli->close();
    }
}

// Create an instance of the Product class
$product = new Product($mysqli);

// Fetch products and echo the JSON response
echo json_encode($product->fetchProducts());

// Close database connection
$product->closeConnection();
?>
