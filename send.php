<?php
$mysqli = new mysqli("localhost", "root", "", "registrations");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Gather form data
$message = $_POST['message'];
$sql = "INSERT INTO receiver (message) VALUES ('$message')";

if ($mysqli->query($sql) === TRUE) {
    echo "Thanks for your submission";
    header('Location:receive.php');
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>
