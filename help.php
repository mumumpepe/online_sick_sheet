<?php
$mysqli = new mysqli("localhost", "root", "", "registrations");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Gather form data
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO contants (email, message) VALUES ('$email', '$message' )";

if ($mysqli->query($sql) === TRUE) {
    echo "Thanks for your submission";
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>
