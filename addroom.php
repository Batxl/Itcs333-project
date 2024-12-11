<?php
include 'admin-database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $room_id = htmlspecialchars(trim($_POST['room_id']));
    $capacity = !empty($_POST['capacity']) ? intval($_POST['capacity']) : null;
    $type = htmlspecialchars(trim($_POST['type']));
    $user_id = htmlspecialchars(trim($_POST['user_id']));
    $equipment = isset($_POST['equipment']) ? $_POST['equipment'] : [];


    if (empty($room_id) || empty($capacity) || empty($type) || empty($user_id)) {
        echo "Error: All fields are required.";
        exit;
    }

    try {

        $sql = "INSERT INTO room (room_id, capacity, type, user_id) 
                VALUES (:room_id, :capacity, :type, :user_id)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':room_id' => $room_id,
            ':capacity' => $capacity,
            ':type' => $type,
            ':user_id' => $user_id,
        ]);


        foreach ($equipment as $equip) {
            $equip_sql = "INSERT INTO equipment (equipment_name, room_id) 
                         VALUES (:equipment_name, :room_id)";
            $equip_stmt = $pdo->prepare($equip_sql);
            $equip_stmt->execute([
                ':equipment_name' => $equip,
                ':room_id' => $room_id,
            ]);
        }


        header("Location: manage.php?message=Room and equipment booked successfully");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>

