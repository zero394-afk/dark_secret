<?php
require_once "Database.php";

class Product extends Database {
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
            return []; // Return an empty array if no products are found
        }
    }

    public function getProduct($productId) {
        $productId = mysqli_real_escape_string($this->conn, $productId);
        $sql = "SELECT * FROM products WHERE id = '$productId'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null; // Return null if the product is not found
        }
        
    }
    public function getFeaturedProducts() {
      $sql = "SELECT * FROM products WHERE featured = 1"; 
      $result = $this->conn->query($sql);

      if ($result->num_rows > 0) {
          $products = [];
          while ($row = $result->fetch_assoc()) {
              $products[] = $row; 
          }
          return $products; 
      } else {
          return []; // Return an empty array if no featured products are found
      }
  }
}





