<?php 
include 'db_connection.php';
//$servername="localhost";
//$username="root";
//$password="";
//$dbanme="project";
//$conn = new mysqli($servername, $username, $password,$dbanme);

//if($conn->connect_error){
    //die("Connection Failed:" . $conn->connect_error);

//}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $id=$_POST["room_id"];
    $date=$_POST[ "reservation_date" ];
    

    $sql = "INSERT INTO `reservations`(`room_id`, `reservation_date`) 
    VALUES ('$id','$date')";

    if($conn->query($sql)==TRUE){
        echo "Booking Successfully";
      
    }else{
        echo "Error: " .$sql . "<br>" .$conn->error;
    }
} 
   $conn->close();


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewpore" content="width=device-width, initial-scale=1.0">
        <title> IT College</title>
        
        <script type="text/javascript">
          function preventBack(){window.history.forward()};
          setTimeout("preventBack()",0);
          window.onunload=function(){null;}
          </script></head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <body>  

<h1 style="text-align: center;">Reservations</h1>

<div class="container">

<div class="row">
    <div class="col-md-8">
        <table action="db_connection.php"  class="table table-hover table-responsive table-primary">
            <thead class="table-warning">

            <tr>
                <th scope="col">Room id</th>
                <th scope="col">Booking Date</th>
                 <th scope="col">more</th>
            </tr>
            </thead>
            <tbody>
                <?php
               include 'db_connection.php';
               
                  
                   if($conn->connect_error){
                       die("Connection Failed:" . $conn->connect_error);

                    }
                    $sql = "SELECT * FROM reservations";
                    $result = $conn-> query($sql);
                   
                    if($result-> num_rows > 0) {
                        while($row= $result->fetch_assoc()){
                            ?>
                            <tr>
                    <td><?php echo $row ['room_id']   ?></td>
                    <td><?php echo $row ['reservation_date']   ?></td>
                  
                    
                    <td> <a href="unbook.php?id=<?php echo $row['room_id']?>" >Unbooked</a></td>
                      
                    
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

    <br>
   <a href="Main page.php">Back</a>
    </body>
</html>
