<?php
include 'db_connection.php';

$ID= $_GET['room_id'];
mysqli_query($conn , "DELETE FROM reservations WHERE room_id=$ID ");
header('Location: Main page.php')
?>

