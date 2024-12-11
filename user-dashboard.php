<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

echo "<h1>Welcome to the User Dashboard!</h1>";
echo "<p>You are successfully logged in.</p>";
echo "<a href='logout.php'>Logout</a>"; // Create a logout file if needed
?>