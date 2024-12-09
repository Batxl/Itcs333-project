<?php
include 'admin-database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $room_id = htmlspecialchars(trim($_POST['room_id']));
    $capacity = !empty($_POST['capacity']) ? intval($_POST['capacity']) : null;
    $type = htmlspecialchars(trim($_POST['type']));
    $user_id = htmlspecialchars(trim($_POST['user_id']));
    $date = htmlspecialchars(trim($_POST['date'])); 
    $time = htmlspecialchars(trim($_POST['time']));  
    $equipment = isset($_POST['equipment']) ? $_POST['equipment'] : [];


    if (empty($room_id) || empty($capacity) || empty($type) || empty($user_id) || empty($date) || empty($time)) {
        echo "Error: All fields are required.";
        exit;
    }


    $datetime = $date . ' ' . $time;  

    $check_query = "SELECT * FROM reservations WHERE room_id = :room_id AND date = :datetime";  // Using 'date' column
    try {
        $stmt = $pdo->prepare($check_query);
        $stmt->execute([':room_id' => $room_id, ':datetime' => $datetime]);
        $existing_reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_reservation) {
            echo "Error: The room is not available on the chosen date and time.";
            exit;
        }

        
        $sql = "INSERT INTO reservations (room_id, capacity, type, date, user_id) 
                VALUES (:room_id, :capacity, :type, :datetime, :user_id)"; 
        $stmt = $pdo->prepare($sql);


        $stmt->execute([
            ':room_id' => $room_id,
            ':capacity' => $capacity,
            ':type' => $type,
            ':datetime' => $datetime,  
            ':user_id' => $user_id
        ]);

    
        foreach ($equipment as $equip) {
            $equip_sql = "INSERT INTO equipment (equipment_name, room_id, date_added) 
                         VALUES (:equipment_name, :room_id, :date_added)";
            $equip_stmt = $pdo->prepare($equip_sql);
            $equip_stmt->execute([
                ':equipment_name' => $equip,
                ':room_id' => $room_id,
                ':date_added' => $date  
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

