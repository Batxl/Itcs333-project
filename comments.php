<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .comment {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #ffffff;
        }
        .reply {
            margin-left: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
        .comment-text, .reply-text {
            margin: 5px 0;
        }
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
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
    <h1>Comments Section</h1>
    <?php
    include 'db_connection.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['reply'])) {
        $response = $conn->real_escape_string($_POST['response']);
        $comment_id = intval($_POST['comment_id']);
        $user_id = 1; 

        $sql = "INSERT INTO comments (content, parent_id, user_id, created_at) 
                VALUES ('$response', '$comment_id', '$user_id', NOW())";
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>Reply posted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    }

   
    $sql = "SELECT comment_id, content, created_at FROM comments WHERE parent_id IS NULL ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="comment">';
            echo '<p class="comment-text"><strong>Comment ID:</strong> ' . $row["comment_id"] . '</p>';
            echo '<p class="comment-text"><strong>Content:</strong> ' . htmlspecialchars($row["content"]) . '</p>';
            echo '<p class="comment-text"><strong>Created At:</strong> ' . date("d-M-Y h:i A", strtotime($row["created_at"])) . '</p>';

            
            $reply_sql = "SELECT content, created_at FROM comments WHERE parent_id = " . $row['comment_id'];
            $reply_result = $conn->query($reply_sql);

            if ($reply_result->num_rows > 0) {
                while ($reply = $reply_result->fetch_assoc()) {
                    echo '<div class="reply">';
                    echo '<p class="reply-text"><strong>Reply:</strong> ' . htmlspecialchars($reply["content"]) . '</p>';
                    echo '<p class="reply-text"><strong>Created At:</strong> ' . date("d-M-Y h:i A", strtotime($reply["created_at"])) . '</p>';
                    echo '</div>';
                }
            }

            // Reply Form
            echo '<form action="comments.php" method="POST">
                    <textarea name="response" placeholder="Reply here..." required></textarea>
                    <input type="hidden" name="comment_id" value="' . $row['comment_id'] . '">
                    <button type="submit" name="reply">Submit Reply</button>
                  </form>';
            echo '</div>';
        }
    } else {
        echo "<p>No comments found.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
