<?php
include 'analysis-database.php';

try {

    $sql = "
        SELECT 
            COUNT(DISTINCT room_id) AS total_rooms, 
            SUM(CASE WHEN type = 'Lab' THEN 1 ELSE 0 END) AS lab_rooms,
            SUM(CASE WHEN type = 'Class' THEN 1 ELSE 0 END) AS class_rooms
        FROM reservations";
    $stmt = $pdo->query($sql);
    $roomStats = $stmt->fetch(PDO::FETCH_ASSOC);

    
    $sqlPopular = "
        SELECT room_id, COUNT(*) AS usage_count
        FROM reservations
        GROUP BY room_id
        ORDER BY usage_count DESC";
    $stmtPopular = $pdo->query($sqlPopular);
    $popularRooms = $stmtPopular->fetchAll(PDO::FETCH_ASSOC);

    
    $sqlUsage = "
        SELECT room_id, MONTH(date) AS month, COUNT(*) AS usage_count
        FROM reservations
        GROUP BY room_id, MONTH(date)
        ORDER BY room_id, month";
    $stmtUsage = $pdo->query($sqlUsage);
    $roomUsageData = [];
    $months = range(1, 12); 

    while ($row = $stmtUsage->fetch(PDO::FETCH_ASSOC)) {
        $room_id = $row['room_id'];
        $month = $row['month'];
        $usage_count = $row['usage_count'];
        $roomUsageData[$room_id][$month] = $usage_count;
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
    <link rel="stylesheet" href="analysis.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            <!-- Dashboard -->
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

            <!-- Popular Rooms -->
            <div class="chart-container" style="margin-top: 40px;">
                <h2>Popular Rooms (Based on Times Used)</h2>
                <canvas id="popularRoomsChart"></canvas>
            </div>

            <!-- Room Usage -->
            <div class="chart-container" style="margin-top: 40px;">
                <h2>Room Usage Report</h2><br>
                <canvas id="roomUsageChart"></canvas>
            </div>
        </div>
    </section>

<script>
// Fetch data from PHP
const roomIds = <?php echo json_encode(array_column($popularRooms, 'room_id')); ?>; 
const usageCounts = <?php echo json_encode(array_column($popularRooms, 'usage_count')); ?>; 
const roomUsageData = <?php echo json_encode($roomUsageData); ?>; 
const roomUsageLabels = <?php echo json_encode($months); ?>; 

// Popular Rooms Bar Chart
const popularRoomsData = {
    labels: roomIds.map(room_id => `Room ${room_id}`), 
    datasets: [{
        label: 'Times Used',
        data: usageCounts, 
        backgroundColor: '#2F6690',
        borderColor: '#fff',
        borderWidth: 1
    }]
};

const ctxPopularRooms = document.getElementById('popularRoomsChart').getContext('2d');
const popularRoomsChart = new Chart(ctxPopularRooms, {
    type: 'bar',
    data: popularRoomsData,
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
            }
        }
    }
});

// Room Usage Line Chart
const roomUsageDatasets = Object.keys(roomUsageData).map(room_id => ({
    label: `Room ${room_id}`,
    data: roomUsageData[room_id], 
    borderColor: '#2F6690',
    fill: false,
    tension: 0.1
}));

const roomUsageDataForChart = {
    labels: roomUsageLabels, 
    datasets: roomUsageDatasets
};

const ctxRoomUsage = document.getElementById('roomUsageChart').getContext('2d');
const roomUsageChart = new Chart(ctxRoomUsage, {
    type: 'line',
    data: roomUsageDataForChart,
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
            }
        }
    }
});
</script>
</body>
</html>
