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


function markAsRead($conn, $user_id) {
    $sql = "UPDATE notifications SET status = 'read' WHERE user_id = ? AND status = 'unread'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    return $stmt->execute();
}

// Fetch and display notifications
$example_user_id = 1; 
$notifications = fetchNotifications($conn, $example_user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
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

    //mark all notifications as read
    <form method="post">
        <button type="submit" name="mark_read">Mark All as Read</button>
    </form>

    <?php
    // Mark all notifications as read if the button is clicked
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
