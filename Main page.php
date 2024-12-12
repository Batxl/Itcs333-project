<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff5f8;
            color: #333;
        }
        header {
            background-color: #ffc2d1;
            color: #333;
            padding: 10px 20px;
            text-align: center;
            border-bottom: 4px solid #ff8fa3;
        }
        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 15px 0;
        }
        nav a {
            text-decoration: none;
            color: #ff4f6d;
            font-weight: bold;
            padding: 8px 16px;
            border: 2px solid #ff8fa3;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        nav a:hover {
            background-color: #ff8fa3;
            color: #fff;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffe5eb;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table{
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffe5eb;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-warning {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffe5eb;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
      
        .container{

            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffe5eb;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #ffc2d1;
            color: #333;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 4px solid #ff8fa3;
        }
    </style>
</head>

<body>
    <!--Room details-->
    <header>
        <h1>Room booking system</h1>
    </header>
    <nav>
        <a href="profile.html">Profile</a>
        <a href="comments.php">Comments</a>
        <a href="notifications.php">Notifications</a>
        <a href="Registration & login Page.html">Regiser and Log in</a>
    </nav>
    <div class="container"> 
        <h1 style="text-align: center;">Booking Room</h1>
        
       
       

    
<!--display room data in table-->

<h1 style="text-align: center;">Book Room</h1>

    


<div class="container">

<div class="row">
    <div class="col-md-8">
        <table action="roomdata.php"  class="table table-hover table-responsive table-primary">
            <thead class="table-warning">

            <tr>
                <th scope="col">id</th>
                <th scope="col">type</th>
                <th scope="col">capacity</th>
                <th scope="col">equipment</th>
        
                 <th scope="col">more</th>
            </tr>
            </thead>
            <tbody>
                <?php
              include 'db_connection.php';
            

                   if($conn->connect_error){
                       die("Connection Failed:" . $conn->connect_error);

                    } 
                    $sql = "SELECT * FROM room ";
                    $result = $conn-> query($sql);
                   
                    if($result-> num_rows > 0) {
                        while($row= $result->fetch_assoc()){
                            ?>
                            <tr>
                    <td><?php echo $row ['room_id']   ?></td>
                    <td><?php echo $row ['type']   ?></td>
                    <td><?php echo $row ['Capacity']   ?></td>
                    <td><?php echo $row ['equipment']   ?></td>
                    <td> <a href="http://localhost:1080/Itcs333-project-4/bookingform.php?id=<?php echo $row['room_id']?>" >Book Room</a></td>
                      
                    
                </tr>
                        
                <?php
                        }

                    }

?>

            </tbody>
        </table>
    </div>
</div>
</div>

</body>
</html>

