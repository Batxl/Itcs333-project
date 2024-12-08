<style>
    .comment {
        margin-bottom: 20px;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
    }

    .reply {
        margin-left: 20px;
        background-color: #f9f9f9;
    }

    .comment-text, .reply-text {
        margin: 5px 0;
    }
</style>
<?php

include 'db_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['reply'])) {
    $response = $_POST['response'];
    $comment_id = $_POST['comment_id'];
    $user_id = 1;

    $sql = "INSERT INTO comments (content, parent_id, user_id, created_at) 
            VALUES ('$response', '$comment_id', '$user_id', NOW())";
    if ($conn->query($sql) === TRUE) {
        echo "Reply posted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT comment_id, content, created_at, parent_id FROM comments WHERE parent_id IS NULL";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["comment_id"] . " - Comment: " . $row["content"] . " - Created At: " . date("d-M-Y h:i A", strtotime($row["created_at"])) . "<br>";
        
        
        $reply_sql = "SELECT comment_id, content, created_at FROM comments WHERE parent_id = " . $row['comment_id'];
        $reply_result = $conn->query($reply_sql);
        
        if ($reply_result->num_rows > 0) {
            while ($reply = $reply_result->fetch_assoc()) {
                echo "  - Reply: " . $reply["content"] . " - Created At: " . date("d-M-Y h:i A", strtotime($reply["created_at"])) . "<br>";
            }
        }
       
        echo '<form action="comments.php" method="POST">
                <textarea name="response" placeholder="Reply here..."></textarea>
                <input type="hidden" name="comment_id" value="' . $row['comment_id'] . '">
                <button type="submit" name="reply">Submit Reply</button>
              </form>';
    }
} else {
    echo "No comments found.";
}

$conn->close();
?>

