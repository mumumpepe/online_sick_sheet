<?php
session_start();

if ($_SESSION["role"] !== "student") {
    header("Location: login1.php"); // Redirect unauthorized users
    exit();
}

// Your database connection code goes here
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "registrations"; // Replace with your actual database name

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle sending messages
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sender = $_SESSION["username"];
    $message = $_POST["message"];

    // Insert the sent message into the database (you should implement this part)
    // Example SQL query (replace with your actual table and column names):
    $sql = "INSERT INTO messages (sender_id, message_content) VALUES ('$sender', '$message')";
    if ($conn->query($sql) === TRUE) {
        // Message inserted successfully
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Rest of your HTML and JavaScript code...
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Chat</title>
    <!-- Include CSS for styling -->
    <style>
        /* Reset some default browser styles */
body, h1, p {
    margin: 0;
    padding: 0;
}

/* Body styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

/* Header styles */
h1 {
    background-color: #007bff;
    color: white;
    padding: 15px;
    text-align: center;
    margin: 0;
}

/* Chat container styles */
#chat {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

/* Message styles */
.message {
    background-color: #f2f2f2;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 15px;
    max-width: 70%;
    word-wrap: break-word;
    position: relative;
}

.message.incoming {
    background-color: #e0e0e0;
    float: left;
}

.message.outgoing {
    background-color: #007bff;
    color: white;
    float: right;
}

/* Message status (ticks) styles */
.message .status {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-left: 5px;
}

.message .status.sent {
    background-color: #007bff; /* Blue tick */
}

.message .status.delivered {
    background-color: #4caf50; /* Green tick */
}

.message .status.read {
    background-color: #ff9800; /* Orange tick */
}

/* Message input and send button styles */
#message-form {
    margin-top: 20px;
    display: flex;
}

#message-input {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
}

#send-button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    margin-left: 10px;
}

#send-button:hover {
    background-color: #0056b3;
}

/* Optional: Add scrollbars for long chat history */
#chat {
    max-height: 500px;
    overflow-y: auto;
}
</style>
    <link rel="stylesheet" type="text/css" href="chat.css">
</head>
<body>
    <h1>Student Chat</h1>
    <div id="chat">
        <!-- Messages will be displayed here -->
    </div>
    <input type="text" id="message" placeholder="Enter your message">
    <button onclick="sendMessage()">Send</button>

    <script>
        const socket = new WebSocket('ws://localhost:8080');
        const chat = document.getElementById('chat');
        const messageInput = document.getElementById('message');

        // Handle incoming messages from the WebSocket server
        socket.onmessage = (event) => {
            const message = document.createElement('p');
            message.textContent = event.data;
            chat.appendChild(message);
        };

        // Send a message to the WebSocket server
        function sendMessage() {
            const message = messageInput.value;
            socket.send(message);
            messageInput.value = '';

// Insert the sent message into the database
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $senderId = $_SESSION["user_id"]; // Assuming you have a user ID for the student
    $receiverId = 1; // Replace with the appropriate receiver's user ID (e.g., medical officer)

    // Get the message from the POST request
    $message = $_POST["message"];

    // Create a prepared statement to insert the message
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $senderId, $receiverId, $message);

    // Execute the statement
    if ($stmt->execute()) {
        // Message inserted successfully
    } else {
        // Error occurred while inserting the message
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}


            // Display the sent message locally (for demonstration)
            const sentMessage = document.createElement('p');
            sentMessage.textContent = message;
            chat.appendChild(sentMessage);
        }
    </script>
</body>
</html>
