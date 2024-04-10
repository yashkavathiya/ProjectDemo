<?php
require '../config/dbconfig.php'; // Assuming dbconfig.php contains the database connection information and $mysqli object is created there.

class Profile {
    private $mysqli;

    // Constructor to initialize the $mysqli property
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function updateProfile($name, $email, $phone) {
        $stmt = $this->mysqli->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE role_type = 1");
        
        // Check for errors during query preparation
        if (!$stmt) {
            die("Prepare failed: " . $this->mysqli->error);
        }
        
        // Bind parameters
        $stmt->bind_param("sss", $name, $email, $phone); // Assuming phone is a string, adjust if necessary
        
        // Execute query
        $result = $stmt->execute();
    
        // Check if execution was successful
        if($result) {
            $stmt->close();
            return true;
        } else {
            // Error occurred, handle it
            die("Error occurred: " . $stmt->error);
        }
    }    
}

// Usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have $mysqli object available here from your dbconfig.php
    $profile = new Profile($mysqli);

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    if ($profile->updateProfile($name, $email, $phone)) {
        echo "Admin profile updated successfully!";
    } else {
        echo "Error occurred while updating profile.";
    }
}
?>
