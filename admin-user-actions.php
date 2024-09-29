<?php
include "../classes/AdminUser.php"; 

session_start(); 
// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin']) || !$_SESSION['admin']) { 
    header("Location: ../views/login.php"); 
    exit();
}

$adminUser = new AdminUser();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_user'])) { 
    $userIdToDelete = $_GET['delete_user']; 

    if ($adminUser->deleteUser($userIdToDelete)) {
        // Redirect to manage_users.php with a success message
        header("Location: ../views/manage_users.php?success=User deleted successfully.");
        exit;
    } else {
        // Redirect to manage_users.php with an error message
        header("Location: ../views/manage_users.php?error=Error deleting user.");
        exit;
    }
} 
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) { 
    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null; 
    $loyaltyPoints = $_POST['loyalty_points']; 

    if ($adminUser->updateUser($userId, $name, $email, $password, $loyaltyPoints)) {
        header("Location: ../views/manage_users.php?success=User updated successfully."); 
        exit;
    } else {
        header("Location: ../views/edit_user.php?id=$userId&error=Error updating user."); 
        exit;
    }
}
?>