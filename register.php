<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['desired-username'];

    // Validate UoB email format
    if (!filter_var($username, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@uob\.edu\.bh$/', $username)) {
        echo "Invalid email format. Please use a UoB email (e.g., username@uob.edu.bh).";
        exit; // Stop further processing
    }

    // Proceed with registration logic...
}
?>