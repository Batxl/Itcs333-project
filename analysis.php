<?php
include 'db_connection.php';

try {
    // Fetch total, lab, and class room count
    $sql = "
        SELECT 
            COUNT(DISTINCT room_id) AS total_rooms, 
            SUM(CASE WHEN type = 'Lab' THEN 1 ELSE 0 END) AS lab_rooms,
            SUM(CASE WHEN type = 'Class' THEN 1 ELSE 0 END) AS class_rooms
        FROM room"; 
    $stmt = $pdo->query($sql);
    $roomStats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch booking data for usage by day
    $sqlBookings = "
        SELECT room_id, DAYOFWEEK(booking_date) AS day_of_week, COUNT(*) AS usage_count
        FROM bookings
        GROUP BY room_id, day_of_week
        ORDER BY room_id, day_of_week";
    $stmtBookings = $pdo->query($sqlBookings);
    $popularRooms = $stmtBookings->fetchAll(PDO::FETCH_ASSOC);

    $roomUsageByDay = [];
    foreach ($popularRooms as $row) {
        $room_id = $row['room_id'];
        $day_of_week = $row['day_of_week'];
        $usage_count = $row['usage_count'];

        $roomUsageByDay[$room_id][$day_of_week] = $usage_count;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            line-height: 1.6;
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #274C77;
            padding: 20px;
            color: #E7ECEF;
            font-size: 18px;
            display: flex;
            flex-direction: column;
        }

        nav .menu-items {
            margin-top: 30px;
            list-style: none;
            flex-grow: 1;
        }

        nav .menu-items li {
            margin-bottom: 20px;
        }

        nav .menu-items li a {
            text-decoration: none;
            color: #E7ECEF;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }

        nav .menu-items li a:hover {
            background-color: #6096BA;
        }

        .dashboard {
            margin-left: 250px;
            padding: 40px 20px;
            background-color: #f4f3ee;
            min-height: 100vh;
        }

        .container {
            display: flex;
            justify-content: space-evenly;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .stat-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 240px;
            padding: 15px 20px;
            border-radius: 10px;
            background-color: #A3CEF1;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            margin: 10px 0;
            color: #274C77;
            font-weight: 600;
        }

        .booking-buttons {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 20px;
            gap: 20px;
        }

        .booking-button {
            text-decoration: none;
            background-color: #274C77;
            color: #E7ECEF;
            font-size: 18px;
            padding: 12px 25px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
            text-align: center;
            width: 45%;
        }

        .booking-button:hover {
            background-color: #6096BA;
            color: #f4f3ee;
        }

        .chart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            margin-top: 30px;
        }

        .chart-container h2 {
            color: #274C77;
        }

        .chart {
            flex: 1;
            min-width: 45%;
            background-color: #E7ECEF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .chart h2 {
            font-size: 24px;
            color: #274C77;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .chart canvas {
            width: 100% !important;
            height: auto !important;
            border-radius: 8px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                justify-content: center;
            }

            .stat-card {
                max-width: 48%;
            }
        }

        @media (max-width: 768px) {
            .container {
                gap: 15px;
            }

            .stat-card {
                max-width: 100%;
            }

            nav {
                width: 200px;
            }

            .dashboard {
                margin-left: 200px;
            }

            .chart {
                min-width: 100%;
            }
        }
    </style>
    <title>Analysis</title>
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
                        <li class="navList active">
                            <a href="analysis.php">
                                <i class="fa-solid fa-chart-simple fa-lg" style="color: #ffffff; margin: 10px"></i>
                                <span class="links">Analysis</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Dashboard Cards -->
            <div class="stat-card">
                <br><i class="fa-solid fa-list-ol fa-xl" style="color: #2F6690;"></i>
                <br><h3><?php echo "Total Rooms: " . $roomStats['total_rooms']; ?></h3>
            </div>
            <div class="stat-card">
                <br><i class="fa-solid fa-list-check fa-xl" style="color: #1e304f;"></i>
                <br><h3><?php echo "Lab Rooms: " . $roomStats['lab_rooms']; ?></h3>
            </div>
            <div class="stat-card">
                <br><i class="fa-solid fa-list fa-xl" style="color: #16425b;"></i>
                <br><h3><?php echo "Class Rooms: " . $roomStats['class_rooms']; ?></h3>
            </div>

            <div class="booking-buttons">
                <a href="pastbooking.php" class="booking-button">Past Bookings</a>
                <a href="upcomingbooking.php" class="booking-button">Upcoming Bookings</a>
            </div>

            <!-- Popular Rooms Chart -->
            <div class="chart-container" style="margin-top: 40px;">
                <h2>Popular Rooms (Based on Usage by Day of the Week)</h2>
                <canvas id="popularRoomsChart"></canvas>
            </div>
        </div>
    </section>

<script>
const roomIds = <?php echo json_encode(array_column($popularRooms, 'room_id')); ?>; 
const roomUsageByDay = <?php echo json_encode($roomUsageByDay); ?>;

const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

const popularRoomsData = {
    labels: daysOfWeek,
    datasets: roomIds.map((roomId, index) => {
        return {
            label: "Room " + roomId,
            data: Array(7).fill(0).map((_, dayIndex) => roomUsageByDay[roomId] ? roomUsageByDay[roomId][dayIndex + 1] || 0 : 0),
            borderColor: 'rgba(54, 162, 235, 0.2)',
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderWidth: 1
        };
    })
};

const ctx = document.getElementById('popularRoomsChart').getContext('2d');
const popularRoomsChart = new Chart(ctx, {
    type: 'bar',
    data: popularRoomsData,
    options: {
        responsive: true,
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Days of the Week'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Room Usage Count'
                },
                beginAtZero: true
            }
        }
    }
});
</script>
</body>
</html>
