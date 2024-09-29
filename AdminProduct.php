<?php
require_once "Database.php";

class AdminProduct extends Database {
    public function addProduct($name, $description, $price, $image) {
        $name = mysqli_real_escape_string($this->conn, $name);
        $description = mysqli_real_escape_string($this->conn, $description);
        $price = mysqli_real_escape_string($this->conn, $price);
        $image = mysqli_real_escape_string($this->conn, $image); 

        $sql = "INSERT INTO products (name, description, price, image) 
                VALUES ('$name', '$description', '$price', '$image')"; 

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getProducts() {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            return $products;
        } else {
            return []; 
        }
    }

    public function getProduct($productId) {
        $productId = mysqli_real_escape_string($this->conn, $productId);
        $sql = "SELECT * FROM products WHERE id = '$productId'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null; 
        }
    }

    public function updateProduct($productId, $name, $description, $price, $image = null) {
        $productId = mysqli_real_escape_string($this->conn, $productId);
        $name = mysqli_real_escape_string($this->conn, $name);
        $description = mysqli_real_escape_string($this->conn, $description);
        $price = mysqli_real_escape_string($this->conn, $price);

        $updateFields = "name = '$name', description = '$description', price = '$price'";

        // Only update the image if a new one is provided
        if (!is_null($image) && !empty($image)) {
            $image = mysqli_real_escape_string($this->conn, $image);
            $updateFields .= ", image = '$image'";
        }

        $sql = "UPDATE products SET $updateFields WHERE id = '$productId'";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProduct($productId) {
        $productId = mysqli_real_escape_string($this->conn, $productId);
        $sql = "DELETE FROM products WHERE id = '$productId'";

        if ($this->conn->query($sql) === TRUE) {
            return true; 
        } else {
            return false; 
        }
    }

    // Add the executeQuery method (if you haven't already)
    public function executeQuery($sql) {
        return $this->conn->query($sql);
    }
}
?>