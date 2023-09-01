<?php
session_start();

// Check if the user is logged in as a medical officer
if ($_SESSION["role"] !== "medical_officer") {
    header("Location: login.php");
    exit();
}

// Database connection and similar logic as in student_dashboard.php
// ...

// Fetch messages for the medical officer
// ...

// Similar display logic as in student_dashboard.php
// ...
?>
<!DOCTYPE html>
<html>
<head>
    <title>Medical Officer Dashboard</title>
</head>
<body>
    <h1>Welcome, Medical Officer!</h1>
    
    <!-- Display messages -->
    <div>
        <!-- Display messages similar to student_dashboard.php -->
        <!-- ... -->
    </div>
</body>
</html>
