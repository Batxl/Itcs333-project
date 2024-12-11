<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Bahrain Student Nationality Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
    <h1 style="text-align: center;">Boohing Room</h1>

    


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
                <th scope="col">date</th>
                <th scope="col">time</th>
                 <th scope="col">more</th>
            </tr>
            </thead>
            <tbody>
                <?php
                 $conn= mysqli_connect('localhost', 'root', '', 'room');
                 
                   if($conn->connect_error){
                       die("Connection Failed:" . $conn->connect_error);

                    }
                    $sql = "SELECT * FROM rooms";
                    $result = $conn-> query($sql);
                   
                    if($result-> num_rows > 0) {
                        while($row= $result->fetch_assoc()){
                            ?>
                            <tr>
                    <td><?php echo $row ['id']   ?></td>
                    <td><?php echo $row ['type']   ?></td>
                    <td><?php echo $row ['capacity']   ?></td>
                    <td><?php echo $row ['equipment']   ?></td>

                     <th > <label for="name?id=<?php echo $row ['id']?>"></label>
                    <input type="date" name="date" id="date" required></th> 

                    <th>  <label for="time?id=<?php echo $row['id']?>"></label>
                    <input type="time" name="time" id="time" required></th>

                    <td> <a href="http://localhost:1080/Itcs333-project-2/booking.php?id=<?php echo $row['id']?>" >Booking Room</a></td>
                      
                    
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

