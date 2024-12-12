<!DOCTYPE html>
<html lang="en">
    <head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"></head>
   <body>
<?php
include 'db_connection.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $id=$_POST["room_id"];
    $date=$_POST[ "reservation_date" ];
}
$sql = "DELETE FROM reservations WHERE room_id ='".$_GET ["room_id"] . "' ";
if(mysqli_query($conn, $sql)){
    echo "<br>";
    echo "The reservation has been cancelled successfully";
    }
    else{
        echo "Operation failed". mysqli_error($conn);
    }
    
    //$conn->close();
mysqli_close($conn);
?>
<br>
  <a href="Main page.php">Back</a>
   </body>
</html>







