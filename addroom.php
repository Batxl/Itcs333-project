<?php
include 'admin-database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Fetching data from the form
    $room_id = htmlspecialchars(trim($_POST['room_id']));
    $capacity = !empty($_POST['capacity']) ? intval($_POST['capacity']) : null;
    $type = htmlspecialchars(trim($_POST['type']));
    $user_id = htmlspecialchars(trim($_POST['user_id']));
    $date = htmlspecialchars(trim($_POST['date'])); // This will be the date value from the form
    $time = htmlspecialchars(trim($_POST['time']));  // Time will be separate in the form
    $equipment = isset($_POST['equipment']) ? $_POST['equipment'] : [];

    // Check if all fields are provided
    if (empty($room_id) || empty($capacity) || empty($type) || empty($user_id) || empty($date) || empty($time)) {
        echo "Error: All fields are required.";
        exit;
    }

    // Combine date and time into a single value
    $datetime = $date . ' ' . $time;  // Combine both fields into a single datetime value

    // Check room availability on the chosen datetime
    $check_query = "SELECT * FROM reservations WHERE room_id = :room_id AND date = :datetime";  // Using 'date' column
    try {
        $stmt = $pdo->prepare($check_query);
        $stmt->execute([':room_id' => $room_id, ':datetime' => $datetime]);
        $existing_reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_reservation) {
            echo "Error: The room is not available on the chosen date and time.";
            exit;
        }

        // Prepare the SQL statement to insert the room booking into the 'reservations' table
        $sql = "INSERT INTO reservations (room_id, capacity, type, date, user_id) 
                VALUES (:room_id, :capacity, :type, :datetime, :user_id)"; // Insert into 'date' column
        $stmt = $pdo->prepare($sql);

        // Execute the query with the provided data
        $stmt->execute([
            ':room_id' => $room_id,
            ':capacity' => $capacity,
            ':type' => $type,
            ':datetime' => $datetime,  // Store combined date and time in the 'date' column
            ':user_id' => $user_id
        ]);

        // Insert equipment data
        foreach ($equipment as $equip) {
            $equip_sql = "INSERT INTO equipment (equipment_name, room_id, date_added) 
                         VALUES (:equipment_name, :room_id, :date_added)";
            $equip_stmt = $pdo->prepare($equip_sql);
            $equip_stmt->execute([
                ':equipment_name' => $equip,
                ':room_id' => $room_id,
                ':date_added' => $date  // You can still use the date for equipment's "date_added" if needed
            ]);
        }

        // Redirect to the manage page with a success message
        header("Location: manage.php?message=Room and equipment booked successfully");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
