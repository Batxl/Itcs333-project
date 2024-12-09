<?php
include 'analysis-database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="analysis.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Analysis</title>
</head>
<body>
    <section class="dashboard">
        <div class="container">
            <!-- Navigation Sidebar -->
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
                <br><h3><?php echo "Total Rooms: " . $roomStatus['total_rooms']; ?></h3>
            </div>
            <div class="stat-card">
                <br><i class="fa-solid fa-list-check fa-xl" style="color: #1e304f;"></i>
                <br><h3><?php echo "Booked Rooms: " . $roomStatus['booked_rooms']; ?></h3>
            </div>
            <div class="stat-card">
                <br><i class="fa-solid fa-list fa-xl" style="color: #16425b;"></i>
                <br><h3><?php echo "Available Rooms: " . $roomStatus['available_rooms']; ?></h3>
            </div>
            <div class="stat-card">
                <br><i class="fa-solid fa-screwdriver-wrench fa-xl" style="color: #1e304f;"></i>
                <br><h3><?php echo "Under Maintenance Rooms: " . $roomStatus['undermaintenance_rooms']; ?></h3>
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
const roomIds = <?php echo json_encode($roomIds); ?>;
const usageCounts = <?php echo json_encode($usageCounts); ?>;
const roomUsageData = <?php echo json_encode($roomUsageData); ?>;
const roomUsageLabels = <?php echo json_encode($months); ?>;

// Popular Rooms Bar Chart
const popularRoomsData = {
    labels: roomIds.map(id => `Room ${id}`), 
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
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        const roomIndex = tooltipItem.dataIndex;
                        const timesUsed = usageCounts[roomIndex];
                        return `Room ${roomIds[roomIndex]}: ${timesUsed} times used`; 
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true, 
            }
        }
    }
});

//Room Usage Line Chart
const roomUsageDatasets = Object.keys(roomUsageData).map(roomId => ({
    label: `Room ${roomId}`, 
    data: roomUsageData[roomId],
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
        plugins: {
            legend: {
                position: 'top', 
                labels: {
                    font: {
                        size: 14, 
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        const roomId = tooltipItem.dataset.label;
                        const month = roomUsageLabels[tooltipItem.dataIndex];
                        const usage = tooltipItem.raw;
                        return `${roomId} in month ${month}: ${usage} times used`;
                    }
                }
            }
        },
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
