<?php
session_start();

// Check if the user is logged in and is a director
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "director") {
    header("Location: login1.php");
    exit();
}

// Check if the request ID is provided in the URL
if (isset($_GET["id"])) {
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

    // Update the request's approval status to "Rejected"
    $updateQuery = "UPDATE sick_sheet_requests SET director_approval_status = 'Rejected' WHERE id = $requestId";

    if ($conn->query($updateQuery) === TRUE) {
        // Redirect back to the Director Dashboard
        header("Location: director_dashboard1.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    // If no request ID is provided, redirect to the dashboard
    header("Location: director_dashboard1.php");
    exit();
}
?>
