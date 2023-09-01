<?php
session_start();

if ($_SESSION["role"] !== "medical_officer") {
    header("Location: login1.php"); // Redirect unauthorized users
    exit();
}

// Your database connection code goes here

?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical Officer Chat</title>
    <!-- Include CSS for styling -->
    <link rel="stylesheet" type="text/css" href="chat.css">
</head>
<body>
    <h1>Medical Officer Chat</h1>
    <div id="chat">
        <!-- Messages will be displayed here -->
    </div>
    <input type="text" id="message" placeholder="Enter your message">
    <button onclick="sendMessage()">Send</button>

    <script>
        // WebSocket client code for medical officers
        // Connect to the WebSocket server and handle real-time chat
        // ...
    </script>
</body>
</html>
