<?php
session_start();
include 'db_connection.php';

$successMessage = '';
$errorMessage = '';

$successMessage = isset($_GET['successMessage']) ? $_GET['successMessage'] : '';
$errorMessage = isset($_GET['errorMessage']) ? $_GET['errorMessage'] : '';

$room = [];
$sql = "SELECT room_id FROM room";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $room[] = $row['room_id'];
    }
}

$comments = [];
foreach ($room as $room_id) {
    $sql = "SELECT content FROM comments WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $comments[$room_id] = $result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E7ECEF;
            color: #274C77;
            line-height: 1.6;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h1, h2 {
            color: #274C77;
            margin-bottom: 20px;
        }
        .container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .comments-section, .form-section {
            flex: 1;
            min-width: 300px;
            background-color: #A3CEF1;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-section {
            align-self: flex-start;
        }
        .room {
            background-color: #ffffff;
            border: 1px solid #6096BA;
            border-radius: 4px;
            margin-bottom: 10px;
            padding: 10px;
        }
        .room-id {
            font-weight: bold;
            color: #274C77;
            margin-bottom: 5px;
        }
        .comment {
            background-color: #E7ECEF;
            border-radius: 4px;
            padding: 5px 10px;
            margin-top: 5px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #274C77;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #6096BA;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #274C77;
            color: #E7ECEF;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #6096BA;
        }
        .message {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <h1>Comment Section</h1>

    <?php if ($successMessage): ?>
        <div class="message success-message"><?php echo htmlspecialchars($successMessage); ?></div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="message error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <div class="container">
        <div class="comments-section">
            <h2>Comments by Room</h2>
            <?php foreach ($room as $room_id): ?>
                <div class="room">
                    <div class="room-id">Room ID: <?php echo htmlspecialchars($room_id); ?></div>
                    <?php if (isset($comments[$room_id]) && count($comments[$room_id]) > 0): ?>
                        <?php foreach ($comments[$room_id] as $comment): ?>
                            <div class="comment"><?php echo htmlspecialchars($comment['content']); ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="comment">No comments yet.</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="form-section">
            <h2>Add a Comment</h2>
            <form action="submit_comment.php" method="POST">
                <label for="room_id">Room ID:</label>
                <input type="number" id="room_id" name="room_id" min="1" required>
                
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" rows="4" required></textarea>
                
                <button type="submit">Submit Comment</button>
            </form>
        </div>
    </div>
</body>
</html>
