<?php

include 'admin-database.php';

try {
    $statusQuery = "SELECT 
                        COUNT(*) AS total_rooms,
                        SUM(CASE WHEN Status = 'available' THEN 1 ELSE 0 END) AS available_rooms,
                        SUM(CASE WHEN Status = 'booked' THEN 1 ELSE 0 END) AS booked_rooms,
                        SUM(CASE WHEN Status = 'under maintenance' THEN 1 ELSE 0 END) AS undermaintenance_rooms
                    FROM Room"; // Using the correct table 'Room'
    $statusStmt = $pdo->query($statusQuery);
    $roomStatus = $statusStmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching room statuses: " . $e->getMessage();
    exit;
}

//Fetch popularity based on times used
try {
    $popularityQuery = "SELECT ID, Times_Used 
                        FROM Room
                        ORDER BY Times_Used DESC"; 
    $popularityStmt = $pdo->query($popularityQuery);

    $roomIds = [];
    $usageCounts = [];

    while ($row = $popularityStmt->fetch(PDO::FETCH_ASSOC)) {
        $roomIds[] = $row['ID'];
        $usageCounts[] = $row['Times_Used'];
    }
} catch (PDOException $e) {
    echo "Error fetching popular rooms: " . $e->getMessage();
    exit;
}

// Fetch monthly usage data for line chart based on the "Date" field
try {
    $usageQuery = "SELECT ID, MONTH(Date) AS booking_month, SUM(Times_Used) AS usage_count
                   FROM Room
                   GROUP BY ID, booking_month 
                   ORDER BY ID, booking_month";
    $usageStmt = $pdo->query($usageQuery);

    $roomUsageData = [];
    $months = range(1, 12);

    while ($row = $usageStmt->fetch(PDO::FETCH_ASSOC)) {
        $roomId = $row['ID'];
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

