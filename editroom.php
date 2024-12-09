<?php

include 'admin-database.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $old_id = htmlspecialchars(trim($_POST['old_id']));
    $new_id = !empty($_POST['new_id']) ? htmlspecialchars(trim($_POST['new_id'])) : null;
    $new_capacity = !empty($_POST['new_capacity']) ? intval($_POST['new_capacity']) : null;
    $new_status = !empty($_POST['new_status']) ? htmlspecialchars(trim($_POST['new_status'])) : null;
    $new_added_by = !empty($_POST['new_added_by']) ? htmlspecialchars(trim($_POST['new_added_by'])) : null;

    if (empty($old_id)) {
        echo "Error: Old Room ID is required.";
        exit;
    }

    $sql = "UPDATE room SET ";
    $params = [];

    if ($new_id !== null) {
        $sql .= "ID = :new_id, ";
        $params[':new_id'] = $new_id;
    }

    if ($new_capacity !== null) {
        $sql .= "Capacity = :new_capacity, ";
        $params[':new_capacity'] = $new_capacity;
    }

    if ($new_status !== null) {
        $sql .= "Status = :new_status, ";
        $params[':new_status'] = $new_status;
    }

    if ($new_added_by !== null) {
        $sql .= "Added_by = :new_added_by, ";
        $params[':new_added_by'] = $new_added_by;
    }

    $sql = rtrim($sql, ", ");
    $sql .= " WHERE ID = :old_id";
    $params[':old_id'] = $old_id;


    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // Check if any rows were updated
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
