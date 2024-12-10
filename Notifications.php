<?php
include 'db_connection.php';  

// Fetch unread comments
$sql = "SELECT room_id, comment_id, user_id, content, created_at FROM comments WHERE status = 'unread' ORDER BY created_at DESC";
$result = $conn->query($sql);

// Mark all comments as read
if (isset($_POST['mark_read'])) {
    $sql = "UPDATE comments SET status = 'read' WHERE status = 'unread'";
    if ($conn->query($sql) === TRUE) {
        echo "<p>All comments marked as read.</p>";
    } else {
        echo "<p>Error updating comments.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Comments</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #ffeef3; margin: 20px; color: #5a1d44; }
        h3 { color: #a7325c; }
        .notification { background-color: #fffbfc; border: 1px solid #f5cbd4; padding: 15px; margin-bottom: 10px; border-radius: 8px; }
        .notification p { margin: 0; font-size: 16px; }
        .notification small { font-size: 12px; color: #9a7480; }
        button { padding: 10px 20px; background-color: #f28ba1; color: white; border: none; border-radius: 8px; cursor: pointer; }
        button:hover { background-color: #d96e89; }
    </style>
</head>
<body>
    <h3>New Comments:</h3>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="notification">
            <p><strong>Room ID:</strong> <?php echo $row["room_id"]; ?></p>
                <p><strong>User ID:</strong> <?php echo $row["user_id"]; ?></p>
                <p><strong>Content:</strong> <?php echo htmlspecialchars($row["content"]); ?></p>
                <small><?php echo date("d-M-Y h:i A", strtotime($row['created_at'])); ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No new comments.</p>
    <?php endif; ?>

    <!-- Button to mark all comments as read -->
    <form method="post">
        <button type="submit" name="mark_read">Mark All as Read</button>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
