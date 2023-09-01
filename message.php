<?php
$mysqli = new mysqli("localhost", "root", "", "registrations");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Gather form data
$messageInput = $_POST['messageInput'];
$sql = "INSERT INTO messages (messageInput) VALUES ('$messageInput')";

if ($mysqli->query($sql) === TRUE) {
    echo "Thanks for your submission";
    header('Location:chat.php');
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>
