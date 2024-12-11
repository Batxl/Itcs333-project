<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = '';
$errorMessage = '';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $errorMessage = "You must be logged in to submit a comment.";
    header("Location: comments.php?errorMessage=" . urlencode($errorMessage));
    exit();
}

$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
$comments = isset($_POST['comment']) ? trim($_POST['comment']) : '';
$user_id = $_SESSION['user_id'];

// Check if room ID exists
$room_check_sql = "SELECT COUNT(*) FROM room WHERE room_id = ?";
$stmt = $conn->prepare($room_check_sql);
if ($stmt === false) {
    die('Error preparing room check statement: ' . $conn->error);
}
$stmt->bind_param("i", $room_id);
$stmt->execute();
$stmt->bind_result($room_exists);
$stmt->fetch();
$stmt->close();

if ($room_exists == 0) {
    $errorMessage = "Room ID does not exist.";
} else {
    if ($comments !== '') {
        $sql = "INSERT INTO comments (room_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
       
        if ($stmt === false) {
            die('Error preparing insert statement: ' . $conn->error . ' Query: ' . $sql);
        }
        
        if (!$stmt->bind_param("iis", $room_id, $user_id, $comments)) {
            die('Error binding parameters: ' . $stmt->error);
        }

        if ($stmt->execute()) {
            $successMessage = "Comment posted successfully!";
        } else {
            $errorMessage = "Error submitting comment: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $errorMessage = "Please enter a comment.";
    }
}

$conn->close();

header("Location: comments.php?successMessage=" . urlencode($successMessage) . "&errorMessage=" . urlencode($errorMessage));
exit();
?>



