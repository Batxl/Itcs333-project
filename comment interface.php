<?php
include('db_connection.php');

if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
} else {
    echo "Room ID is missing!";
    exit;
}

$sql = "SELECT * FROM comments WHERE room_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Interface</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .comment {
            border: 1px solid #ddd;
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .comment-text {
            font-size: 14px;
        }
        .form-container {
            margin-top: 20px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
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

<h2>Leave a Comment</h2>
<form method="POST" action="">
    <div class="form-container">
        <textarea name="comment_content" rows="4" placeholder="Write your comment here..." required></textarea><br>
        <button type="submit">Submit Comment</button>
    </div>
</form>

<h3>Comments:</h3>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="comment">';
        echo '<p class="comment-text"><strong>User ' . $row['user_id'] . ':</strong> ' . htmlspecialchars($row['content']) . '</p>';
        echo '</div>';
    }
} else {
    echo "<p>No comments found.</p>";
}

// Add new comment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['comment_content'])) {
        $content = $_POST['comment_content'];
        $user_id = 1; 
        
        $insert_sql = "INSERT INTO comments (content, user_id, room_id, created_at) VALUES (?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sii", $content, $user_id, $room_id);
        $insert_stmt->execute();
        
        
        header("Location: " . $_SERVER['PHP_SELF'] . "?room_id=" . $room_id);
        exit;
    }
}

$conn->close();
?>

</body>
</html>
