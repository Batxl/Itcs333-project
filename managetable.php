<?php
include 'admin-database.php';

// Fetch room data along with the equipment column directly from the room table
$sql = "SELECT room_id, capacity, type, user_id, equipment 
        FROM room";  // No need to join an equipment table
$stmt = $pdo->query($sql);
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f7fc;
        line-height: 1.6;
        }
        
        .room-table-container {
            margin: 10px 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .room-table-container .title {
            display: flex;
            align-items: center;
            margin-top: 0; 
            margin-bottom: 10px; 
        }

        .room-table-container .title .text {
            font-size: 1.5rem;
            color: #5E548E;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0; 
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #5E548E;
            color: #ddd;
            font-weight: bold;
        }

        table td {
            color: #555;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table td a {
            color: #1e304f;
            text-decoration: none;
        }

        table td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="room-table-container">
        <div class="title">
            <span class="text">Room Management</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Room ID</th>
                    <th>Capacity</th>
                    <th>Type</th>
                    <th>User ID</th>
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
                            <td><?= htmlspecialchars($room['user_id']) ?></td>
                            <td><?= htmlspecialchars($room['equipment']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No rooms available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
