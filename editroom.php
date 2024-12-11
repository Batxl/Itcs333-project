<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $old_id = htmlspecialchars(trim($_POST['old_id']));
    $new_id = !empty($_POST['new_id']) ? htmlspecialchars(trim($_POST['new_id'])) : null;
    $new_capacity = !empty($_POST['new_capacity']) ? intval($_POST['new_capacity']) : null;
    $new_type = !empty($_POST['new_type']) ? htmlspecialchars(trim($_POST['new_type'])) : null;
    $new_equipment = !empty($_POST['new_equipment']) ? htmlspecialchars(trim($_POST['new_equipment'])) : null;

    if (empty($old_id)) {
        echo "Error: Old Room ID is required.";
        exit;
    }

    $sql = "UPDATE room SET ";
    $params = [];

    if ($new_id !== null) {
        $sql .= "room_id = :new_id, ";
        $params[':new_id'] = $new_id;
    }
    if ($new_capacity !== null) {
        $sql .= "capacity = :new_capacity, ";
        $params[':new_capacity'] = $new_capacity;
    }
    if ($new_type !== null) {
        $sql .= "type = :new_type, ";
        $params[':new_type'] = $new_type;
    }
    if ($new_equipment !== null) {

        $valid_equipment = ['None', 'Computer', 'Switch', 'Router'];
        if (in_array($new_equipment, $valid_equipment)) {
            $sql .= "equipment = :new_equipment, ";
            $params[':new_equipment'] = $new_equipment;
        } else {
            echo "Error: Invalid equipment type.";
            exit;
        }
    }


    $sql = rtrim($sql, ", ");
    $sql .= " WHERE room_id = :old_id";
    $params[':old_id'] = $old_id;

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);


        if ($stmt->rowCount() > 0) {
            header("Location: manage.php?message=Room updated successfully");
            exit;
        } else {
            echo "No changes were made. Verify the Old Room ID or provided inputs.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>


