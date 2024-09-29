<?php
include '../classes/Cart.php';
include '../classes/Order.php'; 

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if user is not logged in
    exit;
}

$cart = new Cart();
$cartItems = $cart->getCartItems(); 
$cartTotal = $cart->getCartTotal();

// Handle order placement
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $userId = $_SESSION['user_id'];
    $paymentMethod = $_POST['payment_method'];
    $address = $_POST['address'];

    $order = new Order(); 
    var_dump($cartItems);
    $orderId = $order->createOrder($userId, $cartItems, $cartTotal, $paymentMethod, $address);

    if ($orderId) {
        // Redirect to order confirmation page (create order_confirmation.php next)
        header("Location: order_confirmation.php?order_id=$orderId"); 
        exit; 
    } else {
        // Display an error message (order creation failed)
        echo "Error: There was a problem placing your order. Please try again."; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dark Secret - Checkout</title>
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

  <!-- Checkout Section -->
  <section class="checkout">
    <h2>Checkout</h2>

    <h3>Order Summary</h3>
    <!-- Display the cart items (you can reuse code from cart.php) -->
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

    <h3>Shipping Details</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="address">Delivery Address:</label>
        <textarea id="address" name="address" required></textarea> <br><br>

        <label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="cod">Cash on Delivery</option>
            <option value="credit_card">Credit Card</option>
            <!-- Add more payment methods as needed -->
        </select> <br><br>

        <button type="submit" name="place_order" class="btn">Place Order</button> 
    </form>

  </section>

  <!-- Footer Section -->
  <footer>
    <p>© 2023 Dark Secret. All rights reserved.</p>
  </footer>
</body>
</html>