<?php
session_start();

// Check if the user is logged in and is a medical officer
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "medical_officer") {
    header("Location: login1.php");
    exit();
}

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

// Fetch and display pending student requests
$pendingRequests = fetchRequests($conn, 'Pending');
$approvedRequests = fetchRequests($conn, 'Approved');
$rejectedRequests = fetchRequests($conn, 'Rejected');

function fetchRequests($conn, $status) {
    $requests = array();

    // Query to fetch requests with a specific status
// Query to fetch requests with a specific status and director approval
$query = "SELECT * FROM sick_sheet_requests WHERE approval_status = '$status' AND director_approval_status = 'Approved'";


    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
    }

    return $requests;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical Officer Dashboard</title>
    <!-- Include your CSS and JavaScript files here -->
    <style>
/* CSS for styling the Medical Officer Dashboard */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 80%;
    margin: 0 auto;
    text-align: center;
}

h1 {
    color: #333;
    margin-bottom: 20px;
}

h2 {
    color: #007bff;
    margin-top: 40px;
    margin-bottom: 20px;
}

/* Styling for tables */
.requests-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.requests-table th, .requests-table td {
    border: 1px solid #ccc;
    padding: 12px;
    text-align: left;
}

.requests-table th {
    background-color: #f2f2f2;
}

.requests-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.requests-table tr:hover {
    background-color: #ddd;
}

/* Styling for links in tables */
.table-links a {
    text-decoration: none;
    color: #007bff;
    margin-right: 10px;
}

.table-links a:hover {
    text-decoration: underline;
}

/* Logout link style */
.logout-link {
    text-decoration: none;
    color: #dc3545;
    font-weight: bold;
}

.logout-link:hover {
    text-decoration: underline;
    color: #c82333;
}

/* Responsive design for smaller screens */
@media (max-width: 768px) {
    .container {
        width: 100%;
        padding: 10px;
    }

    .requests-table {
        font-size: 14px;
    }
}

    </style>
</head>
<body>
    <h1>Medical Officer Dashboard</h1>

    <!-- Display pending requests -->
    <h2>Pending Requests</h2>
    <table class="requests-table">
        <tr>
            <th>Request ID</th>
            <th>Student Name</th>
            <th>Registration No</th>
            <th>Request Date</th>
            <th>Reason</th>
            <th>Action</th>
        </tr>
        <?php foreach ($pendingRequests as $request) : ?>
            <tr>
                <td><?php echo $request["id"]; ?></td>
                <td><?php echo $request["name"]; ?></td>
                <td><?php echo $request["registration_number"]; ?></td>
                <td><?php echo $request["time_stamp"]; ?></td>
                <td><?php echo $request["reason"]; ?></td>
                <td class="table-links">
                    <a href="approve_request.php?id=<?php echo $request["id"]; ?>">Approve</a> |
                    <a href="reject_request.php?id=<?php echo $request["id"]; ?>">Reject</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Display approved requests -->
    <h2>Approved Requests</h2>
    <table class="requests-table">
        <tr>
            <th>Request ID</th>
            <th>Student Name</th>
            <th>Registration No</th>
            <th>Request Date</th>
            <th>Reason</th>
        </tr>
        <?php foreach ($approvedRequests as $request) : ?>
            <tr>
                <td><?php echo $request["id"]; ?></td>
                <td><?php echo $request["name"]; ?></td>
                <td><?php echo $request["registration_number"]; ?></td>
                <td><?php echo $request["time_stamp"]; ?></td>
                <td><?php echo $request["reason"]; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Display rejected requests -->
    <h2>Rejected Requests</h2>
    <table class="requests-table">
        <tr>
            <th>Request ID</th>
            <th>Student Name</th>
            <th>Registration No</th>
            <th>Request Date</th>
            <th>Reason</th>
        </tr>
        <?php foreach ($rejectedRequests as $request) : ?>
            <tr>
                <td><?php echo $request["id"]; ?></td>
                <td><?php echo $request["name"]; ?></td>
                <td><?php echo $request["registration_number"]; ?></td>
                <td><?php echo $request["time_stamp"]; ?></td>
                <td><?php echo $request["reason"]; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Other content and features can be added here -->

    <p><a href="logout.php">Logout</a></p>
    <p><a href="medical_officer_messaging.php">Chatting</a></p>
</body>
</html>
