<?php
include 'admin-database.php';

try {
    // Fetch total rooms, lab rooms, and class rooms
    $sql = "
        SELECT 
            COUNT(DISTINCT room_id) AS total_rooms, 
            SUM(CASE WHEN type = 'Lab' THEN 1 ELSE 0 END) AS lab_rooms,
            SUM(CASE WHEN type = 'Class' THEN 1 ELSE 0 END) AS class_rooms
        FROM room";
        
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="upcoming.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f3ee;
    line-height: 1.6;
    width: 100%;
}

/* Navigation Sidebar */
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
}

nav .menu-items {
    margin-top: 30px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    height: calc(100vh - 150px);
    justify-content: space-between;
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
    transition: background-color 0.3s ease;
    height: 50px;
}

nav .menu-items li.active a,
nav .menu-items li a:hover {
    background-color: #6096BA;
    color: #A3CEF1;
}

/* Dashboard Layout */
.dashboard {
    position: relative;
    left: 250px;
    width: calc(100% - 250px);
    min-height: 100vh;
    background-color: #f4f3ee;
    padding: 0px 15px;
}

.container {
    padding-left: 10px;
}

.container .title {
    display: flex;
    align-items: center;
    margin: 40px 0 20px;
}

.container .title .text {
    font-size: 24px;
    font-weight: 600;
    color: #274C77;
    margin-left: 10px;
}

.container .boxes {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

.container .boxes .box {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    max-width: 250px;
    padding: 15px 20px;
    border-radius: 10px;
    background-color: #A3CEF1;
    text-align: center;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

/* Table Section */
.upcoming-bookings {
    margin-top: 40px;
    background-color: #E7ECEF;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.upcoming-bookings h2 {
    font-size: 24px;
    color: #274C77;
    font-weight: 600;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background-color: #E7ECEF;
    border-radius: 8px;
    overflow: hidden;
    table-layout: fixed;
}

table th, table td {
    padding: 15px;
    text-align: left;
    font-size: 16px;
    color: #8B8C89;
    border-bottom: 1px solid #8B8C89;
}

table th {
    background-color: #274C77;
    color: #E7ECEF;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .container .stat-card {
        flex: 1 1 calc(50% - 10px);
        max-width: calc(50% - 10px);
    }

    nav {
        width: 200px;
    }

    .dashboard {
        margin-left: 200px;
    }
}

@media (max-width: 768px) {
    .container .stat-card {
        flex: 1 1 100%;
        max-width: 100%;
    }

    nav {
        width: 150px;
    }

    .dashboard {
        margin-left: 150px;
    }
}
</style>
    <title>Admin Dashboard</title>
</head>
<body>

    <!-- Sidebar -->
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
                    <a href="managetable.php">
                        <i class="fa-solid fa-table fa-lg" style="color: #ffffff; margin:10px;"></i>
                        <span class="links">Rooms</span>
                    </a>
                </li>
            </ul>
            <ul class="bottom-link">
                <li>
                    <a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-lg" style="color: #ffffff; margin: 10px;"></i>
                        <span class="links">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard -->
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
                    <br><i class="fa-solid fa-chalkboard fa-xl" style="color: #16425b;"></i>
                    <br><p><?php echo "Lab Rooms: " . $result['lab_rooms']; ?></p>
                </div>
                <div class="box box3">
                    <br><i class="fa-solid fa-chalkboard fa-xl" style="color: #16425b;"></i>
                    <br><p><?php echo "Class Rooms: " . $result['class_rooms']; ?></p>
                </div>
            </div>
        </div>

        <!-- Upcoming Bookings Table -->
        <div class="upcoming-bookings">
            <h2>Upcoming Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Room ID</th>
                        <th>Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'admin-database.php';

                    $query = "SELECT booking_id, room_id, booking_date FROM bookings WHERE booking_date > NOW() ORDER BY booking_date ASC";
                    try {
                        $stmt = $pdo->query($query);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['booking_id']) . "</td>"; 
                            echo "<td>" . htmlspecialchars($row['room_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['booking_date']) . "</td>";
                            echo "</tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='3'>Error fetching upcoming bookings: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>    
    </div>
    </section>
</body>
</html>
