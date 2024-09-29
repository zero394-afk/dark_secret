<?php
include '../classes/Product.php'; 

session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$product = new Product();
$products = $product->getProducts();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page after adding to cart
    exit; 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dark Secret - Products</title>
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
    </nav>
  </header>

  <!-- Product Gallery Section -->
  <section class="product-gallery">
    <h2>Our Products</h2>
    <div class="products">
      <?php
      if (!empty($products)) { 
        foreach ($products as $product) {
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

  <!-- Footer Section -->
  <footer>
    <p>© 2023 Dark Secret. All rights reserved.</p>
  </footer>
</body>

</html>