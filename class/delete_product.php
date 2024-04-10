<?php
require '../config/dbconfig.php';

class Product {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function deleteProduct($productId) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $productId); // "i" indicates the parameter is an integer
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function closeConnection() {
        $this->mysqli->close();
    }
}

if(isset($_POST['id'])) {
    $product = new Product($mysqli);
    
    $productId = $_POST['id'];    
    if ($product->deleteProduct($productId)) {
        $data['status'] = 200; 
        $data['message'] = "Product deleted successfully!"; 
    } else {
        $data['status'] = 400; 
        $data['message'] = "Error occurred while saving product."; 
    }
    echo json_encode($data);
} else {
    echo "Product ID not provided.";
}
?>
