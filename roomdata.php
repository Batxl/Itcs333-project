<?php 
$servername="localhost";
$username="root";
$password="";
$dbanme="room";
$conn = new mysqli($servername, $username, $password,$dbanme);

if($conn->connect_error){
    die("Connection Failed:" . $conn->connect_error);

}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $id=$_POST["id"];
    $type=$_POST[ "type" ];
    $capacity=$_POST["capacity"];
    $equipment=$_POST["equipment"];



$sql = "INSERT INTO `rooms`(`id`, `type`, `capacity`, `equipment`)
 VALUES ('$id','$type','$capacity','$equipment')";

}
$conn->close();

?>



