<?php
include 'admin-database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $old_id = htmlspecialchars(trim($_POST['old_id']));
    $new_id = !empty($_POST['new_id']) ? htmlspecialchars(trim($_POST['new_id'])) : null;
    $new_capacity = !empty($_POST['new_capacity']) ? intval($_POST['new_capacity']) : null;
    $new_type = !empty($_POST['new_type']) ? htmlspecialchars(trim($_POST['new_type'])) : null;
    $new_user_id = !empty($_POST['new_user_id']) ? htmlspecialchars(trim($_POST['new_user_id'])) : null;
    $new_date = !empty($_POST['new_date']) ? htmlspecialchars(trim($_POST['new_date'])) : null;
    $new_time = !empty($_POST['new_time']) ? htmlspecialchars(trim($_POST['new_time'])) : null;

   
    if ($new_date && $new_time) {
        $new_datetime = $new_date . ' ' . $new_time;  // Concatenate date and time
    } else {
        $new_datetime = null;
    }

  
    if (empty($old_id)) {
        echo "Error: Old Room ID is required.";
        exit;
    }


    if ($new_datetime !== null) {
        $check_query = "SELECT * FROM reservations WHERE room_id = :room_id AND date = :datetime";  // Use 'date' column
        try {
            $stmt = $pdo->prepare($check_query);
            $stmt->execute([
                ':room_id' => $old_id, 
                ':datetime' => $new_datetime, 
            ]);


            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "Error: The room is not available on the chosen date and time.";
                exit;
            }
        } catch (PDOException $e) {
            echo "Error checking availability: " . $e->getMessage();
            exit;
        }
    }

   
    $sql = "UPDATE reservations SET "; 
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


    if ($new_user_id !== null) {
        $sql .= "user_id = :new_user_id, ";
        $params[':new_user_id'] = $new_user_id;
    }

    if ($new_datetime !== null) {
        $sql .= "date = :new_datetime, ";
        $params[':new_datetime'] = $new_datetime;  


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
