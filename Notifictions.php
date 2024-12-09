<?php
include 'db_connection.php';  

// Fetch notifications
function fetchNotifications($conn, $user_id) {
    $sql = "SELECT id, message, status, created_at 
            FROM notifications 
            WHERE user_id = ? AND status = 'unread'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Mark notifications as read
function markAsRead($conn, $user_id) {
    $sql = "UPDATE notifications SET status = 'read' WHERE user_id = ? AND status = 'unread'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    return $stmt->execute();
}


$example_user_id = 1; 
$notifications = fetchNotifications($conn, $example_user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 20px;
        }
        .notification {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .notification p {
            margin: 0;
            font-size: 16px;
        }
        .notification small {
            font-size: 12px;
            color: #666;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h3>Notifications:</h3>
    <?php if ($notifications->num_rows > 0): ?>
        <?php while ($row = $notifications->fetch_assoc()): ?>
            <div class="notification">
                <p><?php echo htmlspecialchars($row['message']); ?></p>
                <small><?php echo date("d-M-Y h:i A", strtotime($row['created_at'])); ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No new notifications.</p>
    <?php endif; ?>

    
    <form method="post">
        <button type="submit" name="mark_read">Mark All as Read</button>
    </form>

    <?php
    // Mark all notifications as read
    if (isset($_POST['mark_read'])) {
        if (markAsRead($conn, $example_user_id)) {
            echo "<p>All notifications marked as read.</p>";
        } else {
            echo "<p>Error marking notifications as read.</p>";
        }
    }

    $conn->close();
    ?>
</body>
</html>
