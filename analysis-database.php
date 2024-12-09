<?php

include 'admin-database.php';

try {
    $statusQuery = "SELECT 
                        COUNT(*) AS total_rooms,
                        SUM(CASE WHEN type = 'Lab' THEN 1 ELSE 0 END) AS Lab,
                        SUM(CASE WHEN type = 'Class' THEN 1 ELSE 0 END) AS Class
                    FROM reservations"; 
    $statusStmt = $pdo->query($statusQuery);
    $roomStatus = $statusStmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching room statuses: " . $e->getMessage();
    exit;
}

try {
    $popularityQuery = "SELECT room_id, COUNT(room_id) AS Times_Used
                        FROM reservations
                        GROUP BY room_id
                        ORDER BY Times_Used DESC"; 
    $popularityStmt = $pdo->query($popularityQuery);

    $roomIds = [];
    $usageCounts = [];

    while ($row = $popularityStmt->fetch(PDO::FETCH_ASSOC)) {
        $roomIds[] = $row['room_id'];  
        $usageCounts[] = $row['Times_Used'];  
    }
} catch (PDOException $e) {
    echo "Error fetching popular rooms: " . $e->getMessage();
    exit;
}

try {
    $usageQuery = "SELECT room_id, MONTH(Date) AS booking_month, COUNT(room_id) AS usage_count
                   FROM reservations
                   GROUP BY room_id, booking_month
                   ORDER BY room_id, booking_month";
    $usageStmt = $pdo->query($usageQuery);

    $roomUsageData = [];
    $months = range(1, 12); 

    while ($row = $usageStmt->fetch(PDO::FETCH_ASSOC)) {
        $roomId = $row['room_id'];
        $month = $row['booking_month'];
        $count = $row['usage_count'];

        if (!isset($roomUsageData[$roomId])) {
            $roomUsageData[$roomId] = array_fill(0, 12, 0); 
        }
        $roomUsageData[$roomId][$month - 1] = $count; 
    }
} catch (PDOException $e) {
    echo "Error fetching room usage data: " . $e->getMessage();
    exit;
}

?>

