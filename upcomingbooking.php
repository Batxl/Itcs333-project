<?php
include 'db_connection.php';

try {

    $query = "SELECT booking_id, room_id, booking_date, start_time, end_time, duration 
              FROM bookings 
              WHERE booking_date >= NOW() 
              ORDER BY booking_date ASC";

    $stmt = $pdo->query($query);
    $upcomingBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<tr><td colspan='6'>Error fetching upcoming bookings: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="analysis.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Upcoming Bookings</title>
</head>
<body>
    <section class="dashboard">
        <div class="container">
            <!-- Sidebar -->
            <nav>
                <div class="menu-items">
                    <ul class="navLinks">
                        <li class="navList">
                            <a href="admin-dashboard.php">
                                <i class="fa-solid fa-house fa-lg" style="color: #ffffff; margin: 5px;"></i>
                                <span class="links">Dashboard</span>
                            </a>
                        </li>
                        <li class="navList">
                            <a href="analysis.php">
                                <i class="fa-solid fa-chart-simple fa-lg" style="color: #ffffff; margin: 5px"></i>    
                                <span class="links">Analysis</span>
                            </a>
                        </li>
                        <li class="navList">
                            <a href="pastbooking.php">
                                <i class="fa-regular fa-calendar" style="color: #ffffff; margin: 5px;"></i>
                                <span class="links">Past Bookings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Upcoming Bookings Table -->
            <div class="upcoming-bookings">
                <h2>Upcoming Bookings</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Room ID</th>
                            <th>Booking Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration (mins)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($upcomingBookings) {
                            foreach ($upcomingBookings as $row) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['booking_id']) . "</td>"; 
                                echo "<td>" . htmlspecialchars($row['room_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['booking_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['end_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['duration']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No upcoming bookings available.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>    
        </div>
    </section>
</body>
</html>
