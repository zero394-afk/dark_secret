<?php
include 'contact_form.php';
include '../Classes/Database.php';

session_start();

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $db = new Database();
    $contactForm = new ContactForm($db);
    $contactForm->handleFormSubmission($name, $email, $message);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Secret - Contact</title>
    <link rel="stylesheet" href="styles.css">
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

    <!-- Contact Section -->
    <section class="contact">
        <h2>Contact Us</h2>
        <div class="contact-info">
            <p>Phone: +1 (123) 456-7890</p>
            <p>Email: info@darksecret.com</p>
            <p>Address: 123 Bakery Street, City, Country</p>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
            <button type="submit" class="btn">Send Message</button>
        </form>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 Dark Secret. All rights reserved.</p>
    </footer>
</body>
</html>
