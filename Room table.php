<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffe6f0; 
            color: #333;
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #d63384; 
            margin-bottom: 20px;
        }
        .table {
            border: 1px solid #d63384; 
            background-color: #fff0f6; 
        }
        .table-warning {
            background-color: #ffcce1;
            color: #d63384; 
        }
        .table-hover tbody tr:hover {
            background-color: #ffd6e8; 
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Available rooms</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <table class="table table-hover table-responsive">
                    <thead class="table-warning">
                        <tr>
                            <th scope="col">Room ID</th>
                            <th scope="col">Type</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Equipment</th>
                            <th scope="col">Comments</th>
                            <th scope="col">Leave a Comment</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db_connection.php';
                        $sql = "
                            SELECT r.room_id, r.type, r.capacity, r.equipment, 
                                   IFNULL(GROUP_CONCAT(c.content SEPARATOR '<br>'), 'No comment') AS comments
                            FROM room r
                            LEFT JOIN comments c ON r.room_id = c.room_id
                            GROUP BY r.room_id
                        ";
                        $result = $conn->query($sql);
                        
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['room_id']}</td>
                                    <td>{$row['type']}</td>
                                    <td>{$row['capacity']}</td>
                                    <td>{$row['equipment']}</td>
                                    <td>{$row['comments']}</td>
                                    <td>
                                        <form action='submit_comment.php' method='post'>
                                            <input type='hidden' name='room_id' value='{$row['room_id']}'>
                                            <textarea name='comment' placeholder='Leave a comment' required></textarea>
                                            <button type='submit' class='btn btn-primary'>Submit</button>
                                        </form>
                                        <td><a href='booking.php?room_id={$row['room_id']}' class='btn btn-primary'>Book</a></td>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No rooms available.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
