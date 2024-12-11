<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff5f8;
            color: #333;
        }
        header {
            background-color: #ffc2d1;
            color: #333;
            padding: 10px 20px;
            text-align: center;
            border-bottom: 4px solid #ff8fa3;
        }
        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 15px 0;
        }
        nav a {
            text-decoration: none;
            color: #ff4f6d;
            font-weight: bold;
            padding: 8px 16px;
            border: 2px solid #ff8fa3;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        nav a:hover {
            background-color: #ff8fa3;
            color: #fff;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffe5eb;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #ffc2d1;
            color: #333;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 4px solid #ff8fa3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Room booking system</h1>
    </header>
    <nav>
        <a href="login.php">Log in</a>
        <a href="register.php">Register</a>
        <a href="admin-dashboard.php">Admin</a>
        <a href="profile.html">Profile</a>
        <a href="notifications.php">Notifications</a>
        <a href="comments.php">comments</a>
    </nav>
    <div class="container">
        <h2> <?php include 'roomtable.php'; ?></h2>
        <p></p>
    </div>
    <footer>
        
    </footer>
</body>
</html>
