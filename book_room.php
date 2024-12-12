<?php
include 'db_connection.php';


session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $room_id = $_POST['room_id'];
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time']; 
    $duration = $_POST['duration']; 

    if (empty($room_id) || empty($booking_date) || empty($start_time) || empty($duration)) {
        echo "Error: All fields are required.";
        exit;
    }

    $start_datetime = $booking_date . ' ' . $start_time; 

    $end_datetime = date('Y-m-d H:i', strtotime($start_datetime . ' + ' . $duration . ' hours')); 


    $pdo->beginTransaction();

    try {
        $query = "SELECT * FROM bookings WHERE room_id = :room_id 
                  AND booking_date = :booking_date
                  AND (
                      (start_time < :end_time AND end_time > :start_time)
                  ) FOR UPDATE"; 
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':room_id' => $room_id,
            ':booking_date' => $booking_date,
            ':start_time' => $start_datetime,
            ':end_time' => $end_datetime
        ]);

        if ($stmt->rowCount() > 0) {
            echo "Error: The room is already booked during this time.";
        } else {

            $sql = "INSERT INTO bookings (user_id, room_id, booking_date, start_time, end_time, duration) 
                    VALUES (:user_id, :room_id, :booking_date, :start_time, :end_time, :duration)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':room_id' => $room_id,
                ':booking_date' => $booking_date,
                ':start_time' => $start_datetime,
                ':end_time' => $end_datetime,
                ':duration' => $duration
            ]);


            $pdo->commit();


            echo "Booking successful!";
        }
    } catch (Exception $e) {

        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
