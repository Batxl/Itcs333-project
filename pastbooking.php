<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="analysis.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Past Bookings</title>
</head>
<body>
    <section class="dashboard">
        <div class="container">
            <!-- Navigation Sidebar -->
            <nav>
                <div class="menu-items">
                    <ul class="navLinks">
                        <li class="navList">
                            <a href="admin-dashboard.php">
                            <i class="fa-solid fa-house fa-lg" style="color: #ffffff; margin: 5px;"></i>
                                <span class="links">Dashboard</span>
                            </a>
                        </li>
                        <li class="navList">
                            <a href="analysis.php">
                            <i class="fa-solid fa-chart-simple fa-lg" style="color: #ffffff; margin: 5px"></i>
                                <span class="links">Analysis</span>
                            </a>
                        </li>
                        <li class="navList">
                            <a href="upcomingbooking.php">
                            <i class="fa-solid fa-calendar fa-lg" style="color: #ffffff; margin:5px"></i>
                                <span class="links">Upcoming Bookings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Past Bookings Table -->
            <div class="past-bookings">
                <h2>Past Bookings</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Room ID</th>
                            <th>Capacity</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        include 'admin-database.php';

                        // Query to fetch past bookings 
                        $query = "SELECT ID, Capacity, Date FROM Room WHERE Date < NOW() ORDER BY Date DESC";
                        try {
                            $stmt = $pdo->query($query);

                            // Fetch and display each row
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Capacity']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                                echo "</tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='3'>Error fetching past bookings: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>    
        </div>
    </section>
</body>
</html
