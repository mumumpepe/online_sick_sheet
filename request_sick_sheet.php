<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect the user to the login page if not logged in
    header("Location: login1.php");
    exit();
}

// Initialize variables
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "registrations"; // Change to your database name

$successMessage = $errorMessage = $printableLink = "";
// Establish database connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Process the sick sheet request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID from the session
    $userId = $_SESSION["user_id"];

    // Retrieve form data and sanitize inputs (to prevent SQL injection)
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $phone_number = mysqli_real_escape_string($conn, $_POST["phone_number"]);
    $residence_area = mysqli_real_escape_string($conn, $_POST["residence_area"]);
    $registration_number = mysqli_real_escape_string($conn, $_POST["registration_number"]);
    $course = mysqli_real_escape_string($conn, $_POST["course"]);
    $department = mysqli_real_escape_string($conn, $_POST["department"]);
    $year_of_study = mysqli_real_escape_string($conn, $_POST["year_of_study"]);
    $reason = mysqli_real_escape_string($conn, $_POST["reason"]);
    $start_date = mysqli_real_escape_string($conn, $_POST["start_date"]);
    $end_date = mysqli_real_escape_string($conn, $_POST["end_date"]);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set the approval_status to 'Pending' by default
    $approvalStatus = 'Pending';

    // Prepare and execute the SQL query with default approval_status
    $sql = "INSERT INTO sick_sheet_requests (user_id, name, phone_number, residence_area, registration_number, course, department, year_of_study, reason, start_date, end_date, approval_status) 
            VALUES ('$userId', '$name', '$phone_number', '$residence_area', '$registration_number', '$course', '$department', '$year_of_study', '$reason', '$start_date', '$end_date', '$approvalStatus')";

    if ($conn->query($sql) === TRUE) {
        // Construct the printable link URL
        $printableLink = "printable_sick_sheet.php?name=" . urlencode($name) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date)
            . "&phone_number=" . urlencode($phone_number) . "&residence_area=" . urlencode($residence_area)
            . "&registration_number=" . urlencode($registration_number) . "&course=" . urlencode($course)
            . "&department=" . urlencode($department) . "&year_of_study=" . urlencode($year_of_study)
            . "&reason=" . urlencode($reason);

        $successMessage = "Sick sheet request submitted successfully!";
    } else {
        $errorMessage = "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Sick Sheet</title>
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            text-align: center;
        }

        h2 {
            margin: 0 0 20px;
            color: #333;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: #28a745;
            margin-top: 10px;
        }

        .error-message {
            color: #dc3545;
            margin-top: 10px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        a {
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 10px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Request Sick Sheet</h2>

        <?php
        if (!empty($successMessage)) {
            echo "<p class='success-message'>$successMessage</p>";
        } elseif (!empty($errorMessage)) {
            echo "<p class='error-message'>$errorMessage</p>";
        }
        ?>

        <!-- Sick sheet request form -->
        <form action="request_sick_sheet.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required>

            <label for="residence_area">Residence Area:</label>
            <input type="text" id="residence_area" name="residence_area" required>

            <label for="registration_number">Registration Number:</label>
            <input type="text" id="registration_number" name="registration_number" required>

            <label for="course">Course:</label>
            <input type="text" id="course" name="course" required>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>

            <label for="year_of_study">Year of Study:</label>
            <input type="number" id="year_of_study" name="year_of_study" required>

            <label for="reason">Reason for Sick Leave:</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <input type="submit" value="Submit Request">
            <button onclick="history.back()">Back</button>
        </form>
        
        <?php
        if (!empty($printableLink)) {
            echo "<a href='$printableLink' target='_blank'>Printable Sick Sheet</a>";
        }
        ?>
    </div>
</body>
</html>
