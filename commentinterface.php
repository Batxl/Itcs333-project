<?php

include('db_connection.php');

if(isset($_GET['room_id'])) {
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

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
        echo "<div><strong>" . $row['user_id'] . ":</strong> " . $row['content'] . "</div>";
    }
} else {
    echo "No comments found.";
}

// new comment if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['comment_content'])) {
        $content = $_POST['comment_content'];
        $user_id = 1; 

        // Insert the new comment
        $insert_sql = "INSERT INTO comments (content, user_id, room_id, created_at) VALUES (?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sii", $content, $user_id, $room_id);
        $insert_stmt->execute();

        echo "Comment added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comment Interface</title>
</head>
<body>
    <h2>Leave a Comment</h2>
    <form method="POST" action="">
        <textarea name="comment_content" rows="4" cols="50" required></textarea><br>
        <input type="submit" value="Submit Comment">
    </form>

    <h3>Comments:</h3>
</body>
</html>
