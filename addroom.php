<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $room_id = htmlspecialchars(trim($_POST['room_id']));
    $capacity = !empty($_POST['capacity']) ? intval($_POST['capacity']) : null;
    $type = htmlspecialchars(trim($_POST['type']));
    $equipment = isset($_POST['equipment']) ? $_POST['equipment'] : 'None';  


    $valid_equipment = ['None', 'Computer', 'Switch', 'Router'];
    if (!in_array($equipment, $valid_equipment)) {
        echo "Error: Invalid equipment selected.";
        exit;
    }

    if (empty($room_id) || empty($capacity) || empty($type)) {
        echo "Error: All fields are required.";
        exit;
    }

    $sql = "INSERT INTO room (room_id, capacity, type, equipment) 
            VALUES (:room_id, :capacity, :type, :equipment)";
    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':room_id' => $room_id,
            ':capacity' => $capacity,
            ':type' => $type,
            ':equipment' => $equipment 
        ]);


        header("Location: manage.php?message=Room and equipment booked successfully");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>

