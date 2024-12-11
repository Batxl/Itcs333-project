<?php
include 'db_connection.php';  

// Fetch unread comments
$sql = "SELECT room_id, content, created_at FROM comments WHERE status = 'unread' ORDER BY created_at DESC";
$result = $conn->query($sql);

// Mark all comments as read
if (isset($_POST['mark_read'])) {
    $sql = "UPDATE comments SET status = 'read' WHERE status = 'unread'";
    if ($conn->query($sql) === TRUE) {
        $success_message = "All comments marked as read.";
    } else {
        $error_message = "Error updating comments.";
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
        body {
            font-family: Arial, sans-serif;
            background-color: #E7ECEF;
            color: #274C77;
            line-height: 1.6;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            color: #274C77;
            margin-bottom: 20px;
            text-align: center;
        }
        .notification-container {
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .notification {
            background-color: #A3CEF1;
            border-bottom: 1px solid #6096BA;
            padding: 15px;
            transition: background-color 0.3s ease;
        }
        .notification:last-child {
            border-bottom: none;
        }
       
        .notification p {
            margin: 5px 0;
            font-size: 16px;
        }
        .notification small {
            font-size: 12px;
            color: #274C77;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        button {
            background-color: #274C77;
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #6096BA;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .no-comments {
            text-align: center;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <h1>New Comments</h1>

    <?php if (isset($success_message)): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <div class="notification-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="notification">
                    <p><strong>Room ID:</strong> <?php echo htmlspecialchars($row["room_id"]); ?></p>
                    <p><strong>Message:</strong> <?php echo htmlspecialchars($row["content"]); ?></p>
                    <small><?php echo date("d-M-Y h:i A", strtotime($row['created_at'])); ?></small>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="button-container">
            <form method="post">
                <button type="submit" name="mark_read">Mark All as Read</button>
            </form>
        </div>
    <?php else: ?>
        <div class="no-comments">
            <p>No new comments.</p>
        </div>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>

