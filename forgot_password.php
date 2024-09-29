<?php
session_start();

// Handle error messages
if (isset($_GET['error'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>"; 
} elseif (isset($_GET['success'])) {
    echo "<p style='color: green;'>" . htmlspecialchars($_GET['success']) . "</p>"; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Secret - Forgot Password</title>
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
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Forgot Password Form -->
    <section class="forgot-password">
        <h2>Forgot Password</h2>
        <form method="post" action="../actions/forgot_password_action.php">
            <label for="email">Enter your email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit" class="btn">Send Reset Link</button>
        </form>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>© 2023 Dark Secret. All rights reserved.</p>
    </footer>
</body>
</html>
