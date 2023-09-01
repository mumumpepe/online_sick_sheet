<?php
session_start();

// Check if the user is logged in and is a medical officer
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "medical_officer") {
    header("Location: login1.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $requestId = $_GET["id"];

    // Database connection parameters
    $dbHost = "localhost"; // Hostname
    $dbUser = "root";      // Username
    $dbPass = "";          // Password (leave it empty for no password)
    $dbName = "registrations"; // Database name

    // Create a connection to the database
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the approval status in the database
    $updateQuery = "UPDATE sick_sheet_requests SET approval_status = 'Approved' WHERE id = $requestId";

    if ($conn->query($updateQuery) === TRUE) {
        // Redirect back to the Medical Officer Dashboard after approval
        header("Location: medical_officer_dashboard.php");
        exit();
    } else {
        echo "Error updating approval status: " . $conn->error;
    }

    $conn->close();
} else {
    // Handle invalid or missing request ID
    echo "Invalid request.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Approve Request</title>
    <!-- Include your CSS and JavaScript files here -->
</head>
<body>
    <h1>Approve Request</h1>
    <!-- You can add additional content here if needed -->
</body>
</html>
