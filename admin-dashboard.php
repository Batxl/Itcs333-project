<?php
include 'admin-database.php';

try {
    // Fetch the total number of rooms, lab rooms, and class rooms
    $sql = "
        SELECT 
            COUNT(DISTINCT room_id) AS total_rooms, 
            SUM(CASE WHEN type = 'Lab' THEN 1 ELSE 0 END) AS lab_rooms,
            SUM(CASE WHEN type = 'Class' THEN 1 ELSE 0 END) AS class_rooms
        FROM room";
        
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin-dashboard-style.css">
    <link rel="stylesheet" href="upcoming.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin Dashboard</title>
</head>

<body>

    <!--Sidebar-->
    <nav>
        <div class="menu-items">
            <ul class="navLinks">
                <li class="navList active">
                    <a href="admin-dashboard.php">
                        <i class="fa-solid fa-house fa-lg" style="color: #3a7ca5; margin: 5px;"></i>
                        <span class="links">Dashboard</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="manage.php">
                        <i class="fa-solid fa-file fa-lg" style="color: #ffffff; margin: 10px"></i>
                        <span class="links">Manage Rooms</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="managetable.php">
                    <i class="fa-solid fa-calendar fa-lg" style="color: #ffffff; margin:10px"></i>
                        <span class="links">Rooms</span>
                    </a>
                </li>
            </ul>
            <ul class="bottom-link">
            <li>
                    <a href="comments.php">
                        <i class="fa-solid fa-comment fa-lg" style="color: #ffffff; margin: 10px;"></i>
                        <span class="links">Comment</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-lg" style="color: #ffffff; margin: 10px;"></i>
                        <span class="links">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!--Dashboard-->
    <section class="dashboard">
        <div class="container">
                <!--welcome message-->
                <h1>Welcome to Admin Page</h1>
            <div class="overview">
                <div class="title">
                    <i class="fa-solid fa-gauge fa-2xl" style="color: #1e304f;"></i>
                    <span class="text">Dashboard</span>
                </div>
                <div class="boxes">
                    <div class="box box1">
                        <br><i class="fa-solid fa-list-ol fa-xl" style="color: #1e304f;"></i>
                        <br><p><?php echo "Total Rooms: " . $result['total_rooms']; ?></p>
                    </div>
                    <div class="box box2">
                        <br><i class="fa-solid fa-chalkboard fa-xl" style="color: #16425b;"></i>
                        <br><p><?php echo "Lab Rooms: " . $result['lab_rooms']; ?></p>
                    </div>
                    <div class="box box3">
                        <br><i class="fa-solid fa-chalkboard fa-xl" style="color: #16425b;"></i>
                        <br><p><?php echo "Class Rooms: " . $result['class_rooms']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
