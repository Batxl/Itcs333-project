<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {

    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $query_rooms = "SELECT room_id, type, capacity, equipment FROM room";
    $stmt_rooms = $pdo->query($query_rooms);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f3ee;
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #274C77;
            padding: 20px;
        }

        nav .menu-items {
            margin-top: 30px;
            list-style: none;
        }

        nav .menu-items li {
            margin-bottom: 20px;
        }

        nav .menu-items li a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: block;
        }

        nav .menu-items li a:hover {
            background-color: #6096BA;
        }

        .main-content {
            margin-left: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background-color: #E7ECEF;
            padding: 20px;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #274C77;
            font-weight: 600;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            color: #6096BA;
            font-weight: 500;
        }

        .form-container input,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #274C77;
            outline: none;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #A3CEF1;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #6096BA;
        }
    </style>
</head>
<body>
    <nav>
        <ul class="menu-items">
            <li><a href="Location:/11/index.php">Dashboard</a></li>
            <li><a href="book_form.php">Book Room</a></li>
            <li><a href="bookingtable.php">My Bookings</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="form-container">
            <h2>Book a Room</h2>
            <form action="book_room.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">

                <label for="room_id">Select Room:</label>
                <select name="room_id" id="room_id" required>
                    <option value="">-- Select a Room --</option>
                    <?php while ($room = $stmt_rooms->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo htmlspecialchars($room['room_id']); ?>">
                            Room ID: <?php echo htmlspecialchars($room['room_id']); ?> |
                            Type: <?php echo htmlspecialchars(ucfirst($room['type'])); ?> |
                            Capacity: <?php echo htmlspecialchars($room['capacity']); ?> |
                            Equipment: <?php echo htmlspecialchars(ucfirst($room['equipment'])); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="booking_date">Booking Date:</label>
                <input type="date" name="booking_date" id="booking_date" required>

                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time" id="start_time" required>

                <label for="duration">Duration (hours):</label>
                <input type="number" name="duration" id="duration" min="1" value="1" required>

                <button type="submit">Book Room</button>
            </form>
        </div>
    </div>
</body>
</html>
