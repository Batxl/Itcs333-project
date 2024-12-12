<?php
include 'db_connection.php';


try {
    $sql = "SELECT room_id, capacity, type, equipment FROM room"; 
    $stmt = $pdo->query($sql);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching room data: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Rooms</title>
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
        transition: background-color 0.3s ease, color 0.3s ease;
        height: 50px;
    }

    nav .menu-items li.active a,
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

    table td a {
        color: #274C77;
        text-decoration: none;
    }

    table td a:hover {
        text-decoration: underline;
    }
</style>
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
                        <i class="fa-solid fa-calendar fa-lg" style="color: #ffffff; margin:10px"></i>
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="room-table-container">
            <div class="title">Room Management</div>
            <table>
                <thead>
                    <tr>
                        <th>Room ID</th>
                        <th>Capacity</th>
                        <th>Type</th>
                        <th>Equipment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rooms)): ?>
                        <?php foreach ($rooms as $room): ?>
                            <tr>
                                <td><?= htmlspecialchars($room['room_id']) ?></td>
                                <td><?= htmlspecialchars($room['capacity']) ?></td>
                                <td><?= htmlspecialchars($room['type']) ?></td>
                                <td><?= htmlspecialchars($room['equipment']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No rooms available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
