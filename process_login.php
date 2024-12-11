<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare the SQL query to fetch the user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: login.php");
        exit();
    }

    // If credentials are valid, set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];

    // Redirect based on user role
    if (preg_match('/^admin\./', $user['email'])) {
        header("Location: admin_dashboard.php"); // Admin dashboard
    } else {
        header("Location: index.php"); // User dashboard
    }
    exit();
}
?>