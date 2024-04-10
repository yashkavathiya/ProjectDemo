<?php
require '../config/dbconfig.php';

class User {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function saveUser($name, $email, $phone, $password) {
        $role_type = 2; // Assuming role_type is always 2 for new users
        $hashed_password = md5($password); // Hash the password using md5

        $stmt = $this->mysqli->prepare("INSERT INTO users (name, email, phone, password, role_type, created_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
        
        // Check for errors in preparing the SQL statement
        if (!$stmt) {
            error_log("Error in preparing SQL statement: " . $this->mysqli->error);
            return false;
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ssssi", $name, $email, $phone, $hashed_password, $role_type);
        $result = $stmt->execute();

        // Check if execution was successful
        if($result) {
            $stmt->close();
            return true;
        } else {
            error_log("Error in executing SQL statement: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }
}

// Usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have $mysqli object available here from your dbconfig.php
    $user = new User($mysqli);

    // Sanitize input data
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $password = $_POST["password"] ?? "";

    // Validate input data
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        echo "Please fill in all required fields.";
    } else {
        if ($user->saveUser($name, $email, $phone, $password)) {
            echo "User saved successfully!";
        } else {
            echo "Error occurred while saving user.";
        }
    }
}
?>
