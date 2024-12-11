<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in or signed up to submit a comment.'); window.location.href = 'index.php';</script>";
    exit; 
}
if ($conn->query($sql) === TRUE) {
    
    header("Location: notifications.php?message=New comment added!");
    exit();  
} else {
    echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id']; 

    //database connection and insert query 
    include 'db_connection.php';
    $sql = "INSERT INTO comments (room_id, user_id, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $room_id, $user_id, $comment);
    if ($stmt->execute()) {
        echo "Comment submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
