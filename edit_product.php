<?php
include '../Classes/Database.php';
include '../classes/AdminProduct.php'; // Include the AdminProduct class
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_product.php");
    exit();
}

$productId = $_GET['id'];
$adminProduct = new AdminProduct();
$productToEdit = $adminProduct->getProduct($productId); // Fetch product details

// Display error message
if (isset($_GET['error'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>"; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Secret - Edit Product</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h2>Edit Product</h2>
    <?php if ($productToEdit): ?>
    <form method="post" action="../actions/admin-product-actions.php"> 
        <input type="hidden" name="product_id" value="<?php echo $productToEdit['id']; ?>">

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $productToEdit['name']; ?>" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $productToEdit['description']; ?></textarea><br><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo $productToEdit['price']; ?>" required><br><br>

        <label for="image">Product Image URL:</label>
        <input type="text" id="image" name="image" value="<?php echo $productToEdit['image']; ?>"><br><br>

        <button type="submit" name="update_product" class="btn">Update Product</button>
    </form>
    <?php else: ?> 
        <p>Product not found.</p>
    <?php endif; ?>
    <a href="manage_product.php">Back to Manage Products</a>
</body>
</html>
