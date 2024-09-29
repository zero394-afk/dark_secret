<?php
include '../classes/Product.php';

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$product = new Product(); // Create a Product object
$featuredProducts = $product->getFeaturedProducts(); // Get featured products using a new method in Product class

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit;
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Secret</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> 
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <h1>Dark Secret</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                
                <li><a href="contact.php">Contact</a></li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li><a href="profile.php">Profile</a></li>';
                    echo '<li><a href="../actions/actions.logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="register.php">Register</a></li>';
                }
                ?>
                <li><a href="cart.php">Cart (<?php echo count($_SESSION['cart']); ?>)</a></li>
            </ul>
            <button class="nav-toggle">Menu</button> 
        </nav>
    </header>

    <div class="main-content"> <section class="hero">
        <h2>Welcome to Dark Secret</h2>
        <p>Indulge in the aroma of freshly baked goods and treat yourself to our delectable creations.</p>
        <a href="products.php" class="btn">Explore Our Products</a>
    </section>

    <section class="product-gallery">
        <h2>Our Featured Products</h2>
        <div class="products">
            <?php 
            if (!empty($featuredProducts)) {
                foreach ($featuredProducts as $product) {
                    echo "<div class='product-card'>";
                    echo "<img src='" . $product['image'] . "' alt='" . $product['name'] . "'>";
                    echo "<h3>" . $product['name'] . "</h3>";
                    echo "<p>" . $product['description'] . "</p>";
                    echo "<p>$" . $product['price'] . "</p>";
                    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                    echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
                    echo "<input type='number' name='quantity' value='1' min='1'>";
                    echo "<button type='submit' name='add_to_cart' class='btn'>Add to Cart</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products available.</p>";
            }
            ?>
        </div>
    </section>
    </div>

    <footer>
        <p>© 2023 Dark Secret. All rights reserved.</p>
    </footer>

    <script src="../assets/js/script.js"></script> 
</body>
</html>