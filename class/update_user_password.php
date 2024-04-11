<?php
require '../config/dbconfig.php';

class Profile {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function updateProfile($opassword, $npassword) {
        $hashed_npassword = md5($npassword);

        $id = $_SESSION['id'];
        $query = "SELECT * FROM users where id='$id'";
        $result = $this->mysqli->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];

            if (md5($opassword) == $stored_password) {
                $update_query = "UPDATE users SET password = ? WHERE id='$id'";
                $stmt = $this->mysqli->prepare($update_query);

                if ($stmt) {
                    $stmt->bind_param("s", $hashed_npassword);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        $stmt->close();
                        return true;
                    } else {
                        $stmt->close();
                        return false;
                    }
                } else {
                    return "Prepare failed: " . $this->mysqli->error;
                }
            } else {
                return "Old password does not match.";
            }
        } else {
            return "Query failed: " . $this->mysqli->error;
        }
    }    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profile = new Profile($mysqli);

    $opassword = $_POST["opassword"];
    $npassword = $_POST["npassword"];

    $response = array(); // Initialize response array

    $updateResult = $profile->updateProfile($opassword, $npassword);
    if ($updateResult === true) {
        $response['status'] = 200; 
        $response['message'] = "User profile password updated successfully!";
    } else {
        $response['status'] = 400; 
        $response['message'] = $updateResult; // Assign error message from updateProfile method
    }
    echo json_encode($response);
}
?>
