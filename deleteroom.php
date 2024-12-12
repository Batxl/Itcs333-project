<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the room ID to delete
    $room_id_to_delete = htmlspecialchars(trim($_POST['room_id'])); // Clean input

    if (empty($room_id_to_delete)) {
        echo "Error: Room ID is required.";
        exit;
    }

    try {

        $check_sql = "SELECT * FROM room WHERE room_id = :room_id";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->bindParam(':room_id', $room_id_to_delete);
        $check_stmt->execute();

        if ($check_stmt->rowCount() == 0) {
            echo "Error: Room with this ID does not exist.";
            exit;
        }


        $delete_reservations_sql = "DELETE FROM reservations WHERE room_id = :room_id";
        $delete_reservations_stmt = $pdo->prepare($delete_reservations_sql);
        $delete_reservations_stmt->bindParam(':room_id', $room_id_to_delete);
        $delete_reservations_stmt->execute();


        $delete_room_sql = "DELETE FROM room WHERE room_id = :room_id";  
        $delete_room_stmt = $pdo->prepare($delete_room_sql);
        $delete_room_stmt->bindParam(':room_id', $room_id_to_delete);
        $delete_room_stmt->execute();


        header("Location: manage.php?message=Room and its reservations deleted successfully");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
