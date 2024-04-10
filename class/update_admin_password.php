<?php
require '../config/dbconfig.php'; // Assuming dbconfig.php contains the database connection information and $mysqli object is created there.

class Profile {
    private $mysqli;

    // Constructor to initialize the $mysqli property
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function updateProfile($opassword, $npassword) {
        // Hash the new password
        $hashed_npassword = md5($npassword);

        // Fetch the stored password from the database
        $query = "SELECT password FROM users WHERE role_type = 1";
        $result = $this->mysqli->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];

            // Check if the old password matches the one stored in the database
            if (md5($opassword) == $stored_password) {
                // Update the password in the database
                $update_query = "UPDATE users SET password = ? WHERE role_type = 1";
                $stmt = $this->mysqli->prepare($update_query);

                if ($stmt) {
                    $stmt->bind_param("s", $hashed_npassword);
                    $stmt->execute();

                    // Check if the update was successful
                    if ($stmt->affected_rows > 0) {
                        $stmt->close();
                        return true; // Password updated successfully
                    } else {
                        $stmt->close();
                        return false; // No rows affected, likely due to no change in password
                    }
                } else {
                    die("Prepare failed: " . $this->mysqli->error);
                }
            } else {
                die("Old password does not match.");
            }
        } else {
            die("Query failed: " . $this->mysqli->error);
        }
    }    
}

// Usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have $mysqli object available here from your dbconfig.php
    $profile = new Profile($mysqli);

    $opassword = $_POST["opassword"];
    $npassword = $_POST["npassword"];

    if ($profile->updateProfile($opassword, $npassword)) {
        echo "Admin profile password updated successfully!";
    } else {
        echo "Error occurred while updating profile.";
    }
}
?>
