<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@(stu|admin)\.uob\.edu\.bh$/", $email)) {
        $error_message = "Invalid email format. Please use a valid email.";
    } else {
        // Extract user_id from email (part before '@')
        $user_id = substr($email, 0, strpos($email, '@'));

        // Check if email already exists
        $sql_check = "SELECT * FROM user WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $error_message = "This email is already registered. Please log in.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user
            $sql_insert = "INSERT INTO user (user_id, email, password) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sss", $user_id, $email, $hashed_password);

            if ($stmt_insert->execute()) {
                // Redirect to login page after successful registration
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error: Could not register user. Please try again later.";
            }
        }
    }
}
?>

<!-- HTML PART -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }

    body {
    font-family: 'Poppins', sans-serif;
        background-color: #f4f3ee;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .container {
        background: #E7ECEF;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
    }
    .container h1 {
        margin-bottom: 20px;
        color: #274C77;
    }
    input[type="email"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #6096BA;
        border-radius: 5px;
        background-color: #A3CEF1;
        color: #274C77;
    }
    input[type="email"]::placeholder, input[type="password"]::placeholder {
        color: #8B8C89;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #274C77;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    button:hover {
        background-color: #6096BA;
    }
    .message {
        margin-top: 10px;
        text-align: center;
        color: red;
    }
    .success {
        color: green;
    }
    .link {
        text-align: center;
        margin-top: 15px;
    }
    .link a {
        text-decoration: none;
        color: #274C77;
    }
    .link a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST" action="register.php">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Register</button>
        </form>
        <div class="message">
            <?php
            if (!empty($error_message)) {
                echo '<p>' . $error_message . '</p>';
            } elseif (!empty($success_message)) {
                echo '<p class="success">' . $success_message . '</p>';
            }
            ?>
        </div>
        <div class="link">
            <p>Already have an account? <br><a href="login.php">Log in</a></p>
        </div>
    </div>
</body>
</html>
