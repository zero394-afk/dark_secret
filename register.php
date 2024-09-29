<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Display success or error messages from user-actions.php
if (isset($_GET['success'])) {
    echo "<p style='color: green;'>" . htmlspecialchars($_GET['success']) . "</p>";
} elseif (isset($_GET['error'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Secret - Register</title>
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

    <!-- Registration Form -->
    <section class="registration">
        <h2>Register</h2>
        <form method="post" action="../actions/user-actions.php"> <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="register" class="btn">Register</button>
        </form>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>© 2023 Dark Secret. All rights reserved.</p>
    </footer>
</body>
</html>