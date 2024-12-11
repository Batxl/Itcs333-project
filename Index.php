<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Main Page</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f3ee;
        line-height: 1.6;
        width: 100%;
    }

    /* Navigation Sidebar */
    nav {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        background-color: #274C77;
        padding: 20px 10px;
        display: flex;
        flex-direction: column;
        align-items: start;
    }

    nav .menu-items {
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        height: calc(100vh - 150px);
        justify-content: space-between;
    }

    nav .menu-items li {
        list-style: none;
    }

    nav .menu-items li a {
        text-decoration: none;
        color: #E7ECEF;
        display: flex;
        align-items: center;
        padding: 12px 20px;
        border-radius: 25px;
        transition: background-color 0.3s ease;
        height: 50px;
    }

    nav .menu-items li.active a,
    nav .menu-items li a:hover {
        background-color: #6096BA;
        color: #A3CEF1;
    }

    /* Dashboard Layout */
    .dashboard {
        position: relative;
        left: 250px;
        width: calc(100% - 250px);
        min-height: 100vh;
        background-color: #f4f3ee;
        padding: 20px 15px;
    }

    .welcome-message {
        font-size: 2rem;
        font-weight: bold;
        color: #274C77;
        margin-bottom: 20px;
    }

    .upcoming-bookings {
        margin: 20px 20px 20px 0;
        padding: 15px;
        background-color: #E7ECEF;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .upcoming-bookings h2 {
        font-size: 1.8rem;
        color: #274C77;
        font-weight: bold;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th,
    table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #8B8C89;
    }

    table th {
        background-color: #274C77;
        color: #E7ECEF;
        font-weight: bold;
    }

    table td {
        color: #8B8C89;
    }

    table tr:hover {
        background-color: #A3CEF1;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        nav {
            width: 200px;
        }

        .dashboard {
            left: 200px;
            width: calc(100% - 200px);
        }
    }

    @media (max-width: 768px) {
        nav {
            width: 150px;
        }

        .dashboard {
            left: 150px;
            width: calc(100% - 150px);
        }
    }
</style>
</head>

<body>
    <!--Sidebar-->
    <nav>
        <div class="menu-items">
            <ul class="navLinks">
                <li class="navList active">
                    <a href="index.php">
                        <i class="fa-solid fa-house fa-lg" style="color: #3a7ca5; margin: 5px;"></i>
                        <span class="links">Index</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="booking.php">
                    <i class="fa-solid fa-plus fa-lg" style="color: #ffffff; margin:15px;"></i>
                        <span class="links">Booking</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="#.php">
                    <i class="fa-solid fa-table fa-lg" style="color: #ffffff; margin: 10px"></i>
                        <span class="links">Booked</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="comments.php">
                        <i class="fa-solid fa-comment fa-lg" style="color: #ffffff; margin: 10px"></i>
                        <span class="links">Comment</span>
                    </a>
                </li>
            </ul>
            <ul class="bottom-link">
                <li>
                    <a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-lg" style="color: #ffffff; margin: 10px;"></i>
                        <span class="links">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="dashboard">
        <div class="welcome-message">Welcome</div>
        <div class="upcoming-bookings">
            <h2>Upcoming Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Room ID</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'admin-database.php';

                    $query = "SELECT reservation_id, room_id, reservation_date FROM reservations WHERE reservation_date < NOW() ORDER BY reservation_date DESC";
                    try {
                        $stmt = $pdo->query($query);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['reservation_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['room_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['reservation_date']) . "</td>";
                            echo "</tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='3'>Error fetching upcoming bookings: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>