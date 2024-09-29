<?php
class ProductManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addProduct($product_name, $product_description, $product_price, $product_image) {
        $product_name = $this->db->escape_string($product_name);
        $product_description = $this->db->escape_string($product_description);
        $product_price = $this->db->escape_string($product_price);
        $product_image_path = $this->uploadImage($product_image);

        if ($product_image_path) {
            $sql = "INSERT INTO products (name, description, price, image) 
                    VALUES ('$product_name', '$product_description', '$product_price', '$product_image_path')";
            return $this->db->query($sql);
        }
        return false;
    }

    private function uploadImage($file) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Check if image is valid
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return false;
        }

        // Check for file conditions
        if (file_exists($target_file)) {
            return false;
        }

        if ($file["size"] > 500000) {
            return false;
        }

        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            return false;
        }

        // Move uploaded file
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        }
        return false;
    }

    public function updateFeaturedProducts($featured_products) {
        foreach ($featured_products as $product_id => $is_featured) {
            $product_id = $this->db->escape_string($product_id);
            $is_featured = $is_featured == '1' ? 1 : 0;
            $sql = "UPDATE products SET featured = '$is_featured' WHERE id = '$product_id'";
            $this->db->query($sql);
        }
    }

    public function getProducts() {
        $sql = "SELECT * FROM products";
        return $this->db->query($sql);
    }
}
