<?php
session_start();

// Check if the user is logged in as a director
if ($_SESSION["role"] !== "director") {
    header("Location: login1.php");
    exit();
}

// Database connection and similar logic as in student_dashboard.php
// ...

// Fetch messages for the director
// ...

// Similar display logic as in student_dashboard.php
// ...
?>
<!DOCTYPE html>
<html>
<head>
    <title>Director Dashboard</title>
</head>
<body>
    <h1>Welcome, Director!</h1>
    
    <!-- Display messages -->
    <div>
        <!-- Display messages similar to student_dashboard.php -->
        <!-- ... -->
    </div>
</body>
</html>
