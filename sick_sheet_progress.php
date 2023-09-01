<?php
session_start();

// Check if the user is logged in (you might need to modify this check)
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
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

// Fetch all the sick sheet requests associated with the user's account
$userId = $_SESSION["user_id"]; // Replace with the actual user identifier

$query = "SELECT * FROM sick_sheet_requests WHERE user_id = '$userId'";
$result = $conn->query($query);

// Check if there are any requests
if ($result && $result->num_rows > 0) {
    $requests = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $requests = []; // No requests found
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sick Sheet Progress</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive styles */
        @media screen and (max-width: 600px) {
            table {
                width: 100%;
            }

            th, td {
                display: block;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Sick Sheet Progress</h1>

    <table>
        <tr>
            <th>Student Name</th>
            <th>Registration Number</th>
            <th>Action</th>
        </tr>
        <?php foreach ($requests as $request) : ?>
            <tr>
                <td><?php echo $request["name"]; ?></td>
                <td><?php echo $request["registration_number"]; ?></td>
                <td>
                    <a href="view_sick_sheet.php?registration_number=<?php echo $request["registration_number"]; ?>">View Sick Sheet</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
