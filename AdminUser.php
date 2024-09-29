<?php
require_once "Database.php";

class AdminUser extends Database {

    public function displayUsers() {
        $sql = "SELECT * FROM users WHERE isAdmin = 0";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return []; 
        }
    }

    public function deleteUser($userId) {
        $userId = mysqli_real_escape_string($this->conn, $userId);
        $sql = "DELETE FROM users WHERE id = '$userId' AND isAdmin = 0"; 

        if ($this->conn->query($sql) === TRUE) {
            return true; 
        } else {
            return false; 
        }
    }

    public function updateUser($userId, $name, $email, $password = null, $loyaltyPoints) {
        $userId = mysqli_real_escape_string($this->conn, $userId);
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $loyaltyPoints = mysqli_real_escape_string($this->conn, $loyaltyPoints);

        $updateFields = "name = '$name', email = '$email', loyalty_points = '$loyaltyPoints'";

        // Only update the password if a new one is provided
        if (!is_null($password) && !empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $updateFields .= ", password = '$password'";
        }

        $sql = "UPDATE users SET $updateFields WHERE id = '$userId'";

        if ($this->conn->query($sql) === TRUE) {
            return true; 
        } else {
            return false; 
        }
    } 

    public function executeQuery($sql) {
        return $this->conn->query($sql);
    }

    // You can add other admin user management methods here (e.g., getUserDetails())
    public function getUserDetails($userId) {
        $userId = mysqli_real_escape_string($this->conn, $userId);
        $sql = "SELECT * FROM users WHERE id = '$userId'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null; // Return null if the user is not found
        }
    }
}
?>