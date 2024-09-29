<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../Classes/Database.php'; 
include 'ProductManager.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['admin']) {
    header("Location: login.php");
    exit();
}

// Initialize Database and ProductManager
$db = new Database('localhost', 'root', '', 'your_database_name');
$productManager = new ProductManager($db);

// Handle product creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image'];

    // Check if product image upload and product addition were successful
    if ($productManager->addProduct($product_name, $product_description, $product_price, $product_image)) {
        echo "<p>Product added successfully!</p>";
    } else {
        echo "<p>Error adding product!</p>";
    }
}

// Handle featured products update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_featured'])) {
    if (isset($_POST['featured']) && count($_POST['featured']) > 0) {
        $productManager->updateFeaturedProducts($_POST['featured']);
        echo "<p>Featured products updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: Please select at least one product to feature.</p>";
    }
}

// Get products for display
$products = $productManager->getProducts();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dark Secret - Manage Products</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h2>Manage Products</h2>

    <!-- Add Product Form -->
    <h3>Add New Product</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="product_name">Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="product_description">Description:</label>
        <textarea id="product_description" name="product_description" required></textarea><br><br>

        <label for="product_price">Price:</label>
        <input type="number" id="product_price" name="product_price" step="0.01" required><br><br>

        <label for="product_image">Image:</label>
        <input type="file" id="product_image" name="product_image" accept="image/*" required><br><br>

        <button type="submit" name="add_product">Add Product</button>
    </form>

    <!-- Product List -->
    <h3>Existing Products</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($products && $products->num_rows > 0) {
                    while ($row = $products->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td><img src='" . $row['image'] . "' alt='Product Image' width='50'></td>";
                        echo "<td><input type='checkbox' name='featured[" . $row['id'] . "]' value='1' " . ($row['featured'] ? 'checked' : '') . "></td>";
                        echo "<td>";
                        echo "<a href='edit_product.php?id=" . $row['id'] . "'>Edit</a> | ";
                        echo "<a href='delete_product.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No products found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button type="submit" name="update_featured">Update Featured Products</button>
    </form>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>

</html>
