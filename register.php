<?php
require 'db_connection.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Capture the role from the form
    $errors = [];

    // Validate email based on user role
    if ($role === 'user') {
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@stu\.uob\.edu\.bh$/", $email)) {
            $errors[] = "Please use a valid UoB student email address (username@stu.uob.edu.bh).";
        }
    } elseif ($role === 'admin') {
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@admin\.uob\.edu\.bh$/", $email)) {
            $errors[] = "Please use a valid UoB admin email address (username@admin.uob.edu.bh).";
        }
    }

    // Validate password
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $hashed_password, $role);
        
        if ($stmt->execute()) {
            echo "<p>Registration successful! You can <a href='login.php'>login</a> now.</p>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        
        <label for="role">Role:</label>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br>
        
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>