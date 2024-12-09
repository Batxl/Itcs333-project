<?php

include 'admin-database.php';

try {
    // SQL query to calculate total rooms
    $sql = "SELECT 
                COUNT(*) AS total_rooms,
                SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) AS available_rooms,
                SUM(CASE WHEN status = 'booked' THEN 1 ELSE 0 END) AS booked_rooms,
                SUM(CASE WHEN status = 'under maintenance' THEN 1 ELSE 0 END) AS undermaintenance_rooms
            FROM room";

    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // SQL query to fetch upcoming bookings
    $bookingSql = "SELECT ID, Capacity, Date FROM Room WHERE Date >= NOW() ORDER BY Date ASC";
    $bookingStmt = $pdo->query($bookingSql);
    $bookings = $bookingStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin-dashboard-style.css">
    <link rel="stylesheet" href="upcoming.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin Dashboard</title>
</head>

<body>
    <!--Sidebar-->
    <nav>
        <div class="menu-items">
            <ul class="navLinks">
                <li class="navList active">
                    <a href="admin-dashboard.php">
                        <i class="fa-solid fa-house fa-lg" style="color: #3a7ca5; margin: 5px;"></i>
                        <span class="links">Dashboard</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="manage.php">
                        <i class="fa-solid fa-file fa-lg" style="color: #ffffff; margin: 10px"></i>
                        <span class="links">Manage Rooms</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="analysis.php">
                        <i class="fa-solid fa-chart-simple fa-lg" style="color: #ffffff; margin: 10px"></i>
                        <span class="links">Analytics</span>
                    </a>
                </li>
                
                <li class="navList">
                    <a href="#">
                        <i class="fa-solid fa-comment fa-lg" style="color: #ffffff; margin: 10px;"></i>
                        <span class="links">Comments</span>
                    </a>
                </li>
            </ul>
            <ul class="bottom-link">
                <li>
                    <a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-lg" style="color: #ffffff; margin: 10px"></i>
                        <span class="links">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!--Dashboard-->
    <section class="dashboard">
        <div class="container">
            <div class="overview">
                <div class="title">
                <i class="fa-solid fa-gauge fa-2xl" style="color: #1e304f;"></i>
                    <span class="text">Dashboard</span>
                </div>
                <div class="boxes">
                    <div class="box box1">
                        <br><i class="fa-solid fa-list-ol fa-xl" style="color: #1e304f;"></i>
                        <br><p><?php echo "Total Rooms: " . $result['total_rooms']; ?></p>
                    </div>
                    <div class="box box2">
                        <br><i class="fa-solid fa-list-check fa-xl" style="color: #1e304f;"></i>
                        <br><p><?php echo "Booked Rooms: " . $result['booked_rooms']; ?></p>
                    </div>
                    <div class="box box3">
                        <br><i class="fa-solid fa-list fa-xl" style="color: #16425b; margin-top=10px"></i>
                        <br><p><?php echo "Available Rooms: " . $result['available_rooms']; ?></p>
                    </div>
                    <div class="box box4">
                        <br><i class="fa-solid fa-screwdriver-wrench fa-xl" style="color: #1e304f;"></i>
                        <br><p><?php echo "Under Maintenance Rooms: " . $result['undermaintenance_rooms']; ?></p>
                    </div>
                </div> 
            </div>

        <!-- Upcoming Bookings -->
        <div class="upcoming-bookings">
            <div class="title">
            <i class="fa-solid fa-calendar fa-2xl" style="color: #1e304f;"></i>
                <span class="text">Upcoming Bookings</span>
            </div>
            <table>
            <thead>
            <tr>
                <th>Room ID</th>
                <th>Capacity</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?php echo htmlspecialchars($booking['ID']); ?></td>
                <td><?php echo htmlspecialchars($booking['Capacity']); ?></td>
                <td><?php echo htmlspecialchars($booking['Date']); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>

        </div>
    </section>
</body>
</html>
