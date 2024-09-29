<?php
include "../classes/AdminProduct.php";
include "../classes/AdminOrder.php";

session_start(); 
// Admin login check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: ../views/login.php"); 
    exit();
}

$adminProduct = new AdminProduct();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    // Handle image upload 
    $targetDirectory = "../assets/images/"; 
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]); 
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]); 
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        header("Location: ../views/manage_products.php?error=File is not an image."); 
        exit;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        $uploadOk = 0;
        header("Location: ../views/manage_products.php?error=Sorry, file already exists."); 
        exit;
    }

    // Check file size (e.g., limit to 5MB)
    if ($_FILES["image"]["size"] > 5000000) { 
        $uploadOk = 0;
        header("Location: ../views/manage_products.php?error=Sorry, your file is too large."); 
        exit;
    }

    // Allow certain file formats
    $allowedTypes = array("jpg", "jpeg", "png", "gif"); 
    if (!in_array($imageFileType, $allowedTypes)) {
        $uploadOk = 0;
        header("Location: ../views/manage_products.php?error=Sorry, only JPG, JPEG, PNG & GIF files are allowed."); 
        exit;
    }

    if ($uploadOk == 1) { 
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Image uploaded successfully
            $imagePath = $targetFile; 

            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            if ($adminProduct->addProduct($name, $description, $price, $imagePath)) {
                header("Location: ../views/manage_products.php?success=Product added successfully."); 
                exit;
            } else {
                header("Location: ../views/manage_products.php?error=Error adding product."); 
                exit;
            } 
        } else {
            header("Location: ../views/manage_products.php?error=Sorry, there was an error uploading your file."); 
            exit;
        }
    } else {
        header("Location: ../views/manage_products.php?error=Image upload failed."); 
        exit;
    } 

} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_product'])) {
    $productIdToDelete = $_GET['delete_product'];

    if ($adminProduct->deleteProduct($productIdToDelete)) {
        header("Location: ../views/manage_products.php?success=Product deleted successfully."); 
        exit;
    } else {
        header("Location: ../views/manage_products.php?error=Error deleting product."); 
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $productId = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle image upload (optional, only if a new image is uploaded)
    if ($_FILES['image']['error'] === 0) { 
        // Handle image upload (same logic as in the add product section)
        $targetDirectory = "../assets/images/"; 
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]); 
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]); 
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            header("Location: ../views/manage_products.php?error=File is not an image."); 
            exit;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            $uploadOk = 0;
            header("Location: ../views/manage_products.php?error=Sorry, file already exists."); 
            exit;
        }

        // Check file size (e.g., limit to 5MB)
        if ($_FILES["image"]["size"] > 5000000) { 
            $uploadOk = 0;
            header("Location: ../views/manage_products.php?error=Sorry, your file is too large."); 
            exit;
        }

        // Allow certain file formats
        $allowedTypes = array("jpg", "jpeg", "png", "gif"); 
        if (!in_array($imageFileType, $allowedTypes)) {
            $uploadOk = 0;
            header("Location: ../views/manage_products.php?error=Sorry, only JPG, JPEG, PNG & GIF files are allowed."); 
            exit;
        }

        if ($uploadOk == 1) { 
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Image uploaded successfully
                $imagePath = $targetFile; 

                if ($adminProduct->updateProduct($productId, $name, $description, $price, $imagePath)) {
                    header("Location: ../views/manage_products.php?success=Product updated successfully."); 
                    exit;
                } else {
                    header("Location: ../views/manage_products.php?error=Error updating product."); 
                    exit;
                } 
            } else {
                header("Location: ../views/manage_products.php?error=Sorry, there was an error uploading your file."); 
                exit;
            }
        } else {
            header("Location: ../views/manage_products.php?error=Image upload failed."); 
            exit;
        } 

    } else {
        $imagePath = null; // No new image uploaded

        if ($adminProduct->updateProduct($productId, $name, $description, $price, $imagePath)) {
            header("Location: ../views/manage_products.php?success=Product updated successfully."); 
            exit;
        } else {
            header("Location: ../views/edit_product.php?id=$productId&error=Error updating product."); 
            exit;
        }
    }
}
?>