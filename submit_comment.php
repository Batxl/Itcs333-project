<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'admin-database.php'; 

$successMessage = '';
$errorMessage = '';

Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $errorMessage = "You must be logged in to submit a comment.";
   header("Location: comments.php?errorMessage=" . urlencode($errorMessage));
    exit(); 
} 

$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
$comments = isset($_POST['comment']) ? trim($_POST['comment']) : '';
$user_id = $_SESSION['user_id'];


$room_check_sql = "SELECT COUNT(*) FROM room WHERE room_id = :room_id";
$stmt = $pdo->prepare($room_check_sql);
$stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
$stmt->execute();
$room_exists = $stmt->fetchColumn();

if ($room_exists == 0) {
    $errorMessage = "Room ID does not exist.";
} else {
    if ($comments !== '') {
        $sql = "INSERT INTO comments (room_id, user_id, content) VALUES (:room_id, :user_id, :content)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $comments, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $successMessage = "Comment posted successfully!";
        } else {
            $errorMessage = "Error submitting comment: " . $stmt->errorInfo()[2];
        }
    } else {
        $errorMessage = "Please enter a comment.";
    }
}

header("Location: comments.php?successMessage=" . urlencode($successMessage) . "&errorMessage=" . urlencode($errorMessage));
exit();
?>
