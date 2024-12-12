<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in first.");
}

$user_id = $_SESSION['user_id'];

try {

    $sql = "SELECT booking_id, room_id, booking_date, start_time, end_time 
            FROM bookings 
            WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);

    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>My Bookings</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f4f3ee;
                margin: 0;
                display: flex;
            }

            nav {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 250px;
                background-color: #274C77;
                padding: 20px 10px;
                display: flex;
                flex-direction: column;
                align-items: start;
                overflow-y: auto;
            }

            nav .menu-items {
                margin-top: 30px;
                display: flex;
                flex-direction: column;
                gap: 10px;
                height: calc(100vh - 150px);
                justify-content: flex-start;
            }

            nav .menu-items li {
                list-style: none;
            }

            nav .menu-items li a {
                text-decoration: none;
                color: #E7ECEF;
                display: flex;
                align-items: center;
                padding: 12px 20px;
                border-radius: 25px;
                transition: background-color 0.3s ease, color 0.3s ease;
                height: 50px;
            }

            nav .menu-items li a:hover {
                background-color: #6096BA;
                color: #f4f3ee;
            }

            .main-content {
                margin-left: 250px;
                padding: 20px;
                width: calc(100% - 250px);
            }

            .room-table-container {
                padding: 20px;
                background-color: #E7ECEF;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .room-table-container .title {
                font-size: 1.5rem;
                color: #274C77;
                font-weight: bold;
                margin-bottom: 15px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table th, table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            table th {
                background-color: #6096BA;
                color: #E7ECEF;
                font-weight: bold;
            }

            table td {
                color: #555;
            }

            table tr:hover {
                background-color: #A3CEF1;
            }
        </style>
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav>
            <ul class='menu-items'>
                <li><a href='index.php'>Dashboard</a></li>
                <li><a href='book_form.php'>Book Room</a></li>
                <li><a href='bookingtable.php'>My Bookings</a></li>
            </ul>
        </nav>

        <div class='main-content'>
            <div class='room-table-container'>
                <h2 class='title'>My Bookings</h2>";

    if ($stmt->rowCount() > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Room ID</th>
                        <th>Booking Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['booking_id']}</td>
                    <td>{$row['room_id']}</td>
                    <td>{$row['booking_date']}</td>
                    <td>{$row['start_time']}</td>
                    <td>{$row['end_time']}</td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No bookings found.</p>";
    }

    echo "      </div>
            </div>
        </body>
    </html>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
