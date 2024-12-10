<?php

include 'admin-database.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id_to_delete = $_POST['room-id'];

    try {
        // SQL query to delete a room
        $sql = "DELETE FROM room WHERE ID = :room_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':room_id', $room_id_to_delete);
        $stmt->execute();

        echo "Room deleted successfully!";
        header("Location: manage.php"); 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
