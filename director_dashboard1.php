<?php
session_start();

// Check if the user is logged in and is a director
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "director") {
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

    // Query to fetch requests based on status
    $query = "SELECT * FROM sick_sheet_requests WHERE director_approval_status = '$status'";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) { // Check if the query was successful
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
    <title>Director Dashboard</title>
    <!-- Include your CSS and JavaScript files here -->
    <style>
body, h1, h2, table {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Overall page styles */
        body {
            background-color: #f4f4f4;
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
        }

        h2 {
            color: #007bff;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Links styles */
        a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Separate section headers for tables */
        .section-header {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Director Dashboard</h1>

        <!-- Display pending requests -->
        <h2>Pending Requests</h2>
        <table>
            <!-- Table header -->
            <tr>
                <th>Request ID</th>
                <th>Student Name</th>
                <th>Registration No</th>
                <th>Request Date</th>
                <th>Reason</th>
                <th>Action</th>
            </tr>
            <!-- Iterate through pending requests and display them -->
            <?php foreach ($pendingRequests as $request) : ?>
                <tr>
                    <td><?php echo $request["id"]; ?></td>
                    <td><?php echo $request["name"]; ?></td>
                    <td><?php echo $request["registration_number"]; ?></td>
                    <td><?php echo $request["time_stamp"]; ?></td>
                    <td><?php echo $request["reason"]; ?></td>
                    <td>
                        <a href="approve_request1.php?id=<?php echo $request["id"]; ?>">Approve</a> |
                        <a href="reject_request1.php?id=<?php echo $request["id"]; ?>">Reject</a>
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
        <p><a href="director_messaging.php">Chatting</a></p>
    </div>
</body>
</html>
