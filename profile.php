<?php
include '../classes/User.php'; 

session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = new User();
$userId = $_SESSION['user_id'];
$userDetails = $user->getUserDetails($userId); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null; 

    if ($user->updateProfile($userId, $name, $email, $password)) {
        // Update was successful - you can display a success message here
        echo "Profile updated successfully!"; 
        $userDetails = $user->getUserDetails($userId); // Re-fetch user details to display updated information
    } else {
        // Handle the update error
        echo "Error: There was a problem updating your profile. Please try again."; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Secret - Profile</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> 
   
</head>
<body>
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

  <section class="profile">
    <h2>User Profile</h2>

    <?php if ($userDetails): ?>
    <div class="profile-details"> 
        <p><strong>Name:</strong> <?php echo $userDetails['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $userDetails['email']; ?></p>
        <!-- ... (You can display other user details here as well) ... --> 
    </div>

    <div class="profile-update">
        <h3>Update Your Profile</h3> 
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $userDetails['name']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $userDetails['email']; ?>" required>
            <label for="password">New Password (optional):</label>
            <input type="password" id="password" name="password"> 
            <button type="submit" name="update_profile" class="btn">Update Profile</button>
        </form>
    </div>

    <div class="profile-section">
        <h3>Order History</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Address</th>
                <th>Status</th>
            </tr>
            <tbody>
                <?php
                $sql = "SELECT * FROM orders WHERE user_id='$userId'";

                // Use the executeQuery() method
                $result = $user->executeQuery($sql); 

                if ($result->num_rows > 0) {
                    // Use a different variable name (e.g., $orderRow)
                    while ($orderRow = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $orderRow['id'] . "</td>";
                        echo "<td>" . $orderRow['product_id'] . "</td>";
                        echo "<td>" . $orderRow['quantity'] . "</td>";
                        echo "<td>$" . $orderRow['total_price'] . "</td>";
                        echo "<td>" . $orderRow['payment_method'] . "</td>";
                        echo "<td>" . $orderRow['address'] . "</td>";
                        echo "<td>" . $orderRow['status'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php else: ?>
    <p>User details not found.</p>
    <?php endif; ?>

  </section>

  <footer>
    <p>© 2023 Dark Secret. All rights reserved.</p>
  </footer>
</body>
</html>