<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];


    if (!preg_match("/^[a-zA-Z0-9._%+-]+@(stu|admin)\.uob\.edu\.bh$/", $email)) {
        $error_message = "Invalid email format. Please use a valid stu or admin email.";
    } else {

        $user_id = substr($email, 0, strpos($email, '@'));


        $sql = "SELECT * FROM user WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();


            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];

                // Redirect based on user role
                if (strpos($email, '@stu.uob.edu.bh') !== false) {
                    header("Location: http://localhost/11/index.php");
                    exit();
                } elseif (strpos($email, '@admin.uob.edu.bh') !== false) {
                    header("Location: http://localhost/11/admin-dashboard.php");
                    exit();
                }
            } else {
                $error_message = "Incorrect password. Please try again.";
            }
        } else {
            $error_message = "Email not found. Please register first.";
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
    <title>Login</title>
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
        <h1>Login</h1>
        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
        <div class="message">
            <?php
            if (!empty($error_message)) {
                echo '<p>' . $error_message . '</p>';
            }
            ?>
        </div>
        <div class="link">
            <p>Don’t have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>
