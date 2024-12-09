<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "project";

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;  // Stop execution if the connection fails
}
?>
