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
   
    
<?php 
$servername="localhost";
$username="root";
$password="";
$dbanme="bookings";
$conn = new mysqli($servername, $username, $password,$dbanme);

if($conn->connect_error){
    die("Connection Failed:" . $conn->connect_error);

}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $name=$_POST["name"];
    $email=$_POST[ "email" ];
    

    $sql = "INSERT INTO `booking`(`name`, `email`) 
    VALUES ('$name','$email')";

    if($conn->query($sql)==TRUE){
        echo "Booking Successfully";
      
    }else{
        echo "Error: " .$sql . "<br>" .$conn->error;
    }

}
$conn->close();

?>
<br>
   <a href="rtable.php">Back</a>
    </body>
</html>

