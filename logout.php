<?php
session_start();


session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Out</title>
    <link rel="stylesheet" href="logout.css">
</head>
<body>
    <div class="logout-container">
        <h1>You are logged out</h1>
        <p>You have successfully logged out of the system.</p>
        <a href="login.php" class="login-btn">Go to Login</a>
    </div>
</body>
</html>
