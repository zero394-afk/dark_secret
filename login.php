<?php
session_start();

// Handle display of error messages
if (isset($_GET['error'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>"; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Secret - Login</title>
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
                <li><a href="cart.php">Cart 
                    <?php 
                    if (isset($_SESSION['cart'])) {
                        echo "(" . count($_SESSION['cart']) . ")"; 
                    } else {
                        echo "(0)"; 
                    }
                    ?>
                </a></li>
            </ul>
        </nav>
    </header>

    <!-- Login Form -->
    <section class="login">
        <h2>Login</h2>
        <form method="post" action="../actions/user-actions.php"> 
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
        
        <!-- Add "Forgot Password" link -->
        <p><a href="forgot_password.php">Forgot your password?</a></p>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>© 2023 Dark Secret. All rights reserved.</p>
    </footer>
</body>
</html>
