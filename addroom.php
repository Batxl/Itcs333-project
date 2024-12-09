<?php
include 'admin-database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = htmlspecialchars(trim($_POST['room_id']));
    $capacity = !empty($_POST['capacity']) ? intval($_POST['capacity']) : null;
    $status = htmlspecialchars(trim($_POST['status']));
    $added_by = htmlspecialchars(trim($_POST['added_by']));

    if (empty($id) || empty($capacity) || empty($status) || empty($added_by)) {
        echo "Error: All fields are required.";
        exit;
    }

    try {
        $sql = "INSERT INTO room (ID, Capacity, Status, Added_by, Date, Times_Used) 
                VALUES (:id, :capacity, :status, :added_by, NOW(), 0)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id,
            ':capacity' => $capacity,
            ':status' => $status,
            ':added_by' => $added_by,
        ]);

        header("Location: manage.php?message=Room added successfully");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>