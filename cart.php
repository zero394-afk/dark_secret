<?php
include '../classes/Cart.php'; 

session_start();

$cart = new Cart();
$cartItems = $cart->getCartItems();
$cartTotal = $cart->getCartTotal();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dark Secret - Cart</title>
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
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                echo '<li><a href="login.php">Login</a></li>';
                echo '<li><a href="register.php">Register</a></li>';
            }
            ?>
            <li><a href="cart.php">Cart (<?php echo count($_SESSION['cart']); ?>)</a></li>
        </ul>
    </nav>
  </header>

  <!-- Cart Section -->
  <section class="cart"> 
    <h2>Your Cart</h2> 

    <?php if (!empty($cartItems)): ?> 
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>$<?php echo $item['price']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                </tr> 
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Total: $<?php echo number_format($cartTotal, 2); ?></strong></p>

        <!-- Add links or buttons for checkout or continuing shopping -->
        <a href="products.php" class="btn">Continue Shopping</a>
        <a href="checkout.php" class="btn">Proceed to Checkout</a> 

    <?php else: ?>
        <p>Your cart is empty.</p> 
    <?php endif; ?>

  </section> 

  <!-- Footer Section -->
  <footer>
    <p>© 2023 Dark Secret. All rights reserved.</p>
  </footer>
</body>
</html>