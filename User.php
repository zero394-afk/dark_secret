<?php
require_once "Database.php"; 

class User extends Database { 
    public function register($name, $email, $password) {
        // Sanitize inputs
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);

        // Check if the email already exists
        $checkEmailSql = "SELECT * FROM users WHERE email = '$email'";
        $checkEmailResult = $this->conn->query($checkEmailSql);

        if ($checkEmailResult->num_rows > 0) {
            return "Error: This email address is already registered.";
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

            if ($this->conn->query($sql)) {
                return "Registration successful!"; 
            } else {
                return "Error: " . $sql . "<br>" . $this->conn->error; 
            }
        }
    }

    public function login($email, $password) {
        $email = mysqli_real_escape_string($this->conn, $email); 

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                // Check if the user is an admin
                if ($user['isAdmin'] == 1) {
                    $_SESSION['admin'] = true;
                    header("Location: ../views/admin_dashboard.php"); // Redirect to admin dashboard
                } else {
                    $_SESSION['admin'] = false;
                    header("Location: ../views/index.php"); // Redirect to user homepage
                }
                exit; 
            } else {
                return "Invalid password.";
            }
        } else {
            return "User not found.";
        }
    }

    public function getUserDetails($userId) {
        $userId = mysqli_real_escape_string($this->conn, $userId);
        $sql = "SELECT * FROM users WHERE id = '$userId'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null; 
        }
    }

    public function updateProfile($userId, $name, $email, $password = null) { 
        $userId = mysqli_real_escape_string($this->conn, $userId);
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);

        $updateFields = "name = '$name', email = '$email'";

        // Only update the password if a new one is provided
        if (!is_null($password) && !empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $updateFields .= ", password = '$password'";
        }

        $sql = "UPDATE users SET $updateFields WHERE id = '$userId'";

        if ($this->conn->query($sql)) {
            return true; 
        } else {
            return false; 
        }
    }

    // Add the executeQuery method
    public function executeQuery($sql) {
        return $this->conn->query($sql);
    }
}
?>