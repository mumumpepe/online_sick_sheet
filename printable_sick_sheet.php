<?php
session_start();

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

// Retrieve form data from the URL query parameters
$registration_number = urldecode($_GET["registration_number"]);

// Fetch student sick sheet details from the database
$sickSheetData = fetchSickSheetData($conn, $registration_number);

// Fetch Director and Medical Officer approval statuses from the database
$directorApprovalStatus = $sickSheetData["director_approval_status"] ?? 'Not Available';
$medicalOfficerApprovalStatus = $sickSheetData["approval_status"] ?? 'Not Available';

// Calculate the approval percentage
$approvalPercentage = calculateApprovalPercentage($directorApprovalStatus, $medicalOfficerApprovalStatus);

function fetchSickSheetData($conn, $registration_number) {
    $query = "SELECT * FROM sick_sheet_requests WHERE registration_number = '$registration_number'";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // No sick sheet data found
    }
}

function calculateApprovalPercentage($directorApprovalStatus, $medicalOfficerApprovalStatus) {
    if ($directorApprovalStatus === 'Approved' && $medicalOfficerApprovalStatus === 'Approved') {
        return 100;
    } elseif ($directorApprovalStatus === 'Approved' || $medicalOfficerApprovalStatus === 'Approved') {
        return 50;
    } else {
        return 0;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Printable Sick Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 10px 0;
        }

        .content {
            padding: 20px;
        }

        .footer {
            text-align: center;
            background-color: #f5f5f5;
            padding: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .print-link, .home-link {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .print-link:hover, .home-link:hover {
            background-color: #0056b3;
        }

        /* Progress bar container */
        .progress-container {
            width: 100%;
            margin: 20px 0;
            text-align: center;
        }

        /* Progress bar */
        .progress-bar {
            display: inline-block;
            width: 80%;
            background-color: #ccc;
            border-radius: 4px;
            height: 20px;
            position: relative;
        }

        /* Filled progress */
        .filled-progress {
            background-color: #007bff;
            border-radius: 4px;
            height: 100%;
            width: <?= $approvalPercentage; ?>%;
            position: absolute;
            transition: width 1s ease;
        }

        /* Faded button */
        .faded-button {
            background-color: #ccc !important;
        }

        /* Media query to hide links when printing */
        @media print {
            .print-link, .home-link {
                display: none;
            }
        }
    .print-link {
        display: inline-block;
        margin-right: 10px;
        padding: 10px 20px;
        background-color: green;
        color: white; /* Set the color to green */
        text-decoration: none;
        border-radius: 5px;
    }

    .back-button {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    /* Style the back button on hover */
    .back-button:hover {
        background-color: #0056b3;
    }

    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Sick Sheet</h1>
    </div>

    <div class="content">
        <h2>Student Sick Sheet Details:</h2>
        <table>
            <?php if ($sickSheetData) : ?>
                <tr>
                    <td>Name:</td>
                    <td><?= $sickSheetData["name"] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>Start Date:</td>
                    <td><?= $sickSheetData["start_date"] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>End Date:</td>
                    <td><?= $sickSheetData["end_date"] ?? ''; ?></td>
                </tr>
                <!-- Additional fields -->
                <tr>
                    <td>Phone Number:</td>
                    <td><?= $sickSheetData["phone_number"] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>Residence Area:</td>
                    <td><?= $sickSheetData["residence_area"] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>Registration Number:</td>
                    <td><?= $sickSheetData["registration_number"] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>Course:</td>
                    <td><?= $sickSheetData["course"] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>Department:</td>
                    <td><?= $sickSheetData["department"] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>Year of Study:</td>
                    <td><?= $sickSheetData["year_of_study"] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>Reason for Sick Leave:</td>
                    <td><?= $sickSheetData["reason"] ?? ''; ?></td>
                </tr>
              <!-- Director Approval Status -->
<tr>
    <td>Director Approval Status:</td>
    <td>
        <?php
        $directorStatus = $directorApprovalStatus;
        $directorColor = '';

        if ($directorStatus === 'Approved') {
            $directorColor = 'green';
        } elseif ($directorStatus === 'Pending') {
            $directorColor = 'yellow';
        } elseif ($directorStatus === 'Rejected') {
            $directorColor = 'red';
        }

        echo '<span style="color: ' . $directorColor . ';">' . $directorStatus . '</span>';
        ?>
    </td>
</tr>

<!-- Medical Officer Approval Status -->
<tr>
    <td>Medical Officer Approval Status:</td>
    <td>
        <?php
        $medicalOfficerStatus = $medicalOfficerApprovalStatus;
        $medicalOfficerColor = '';

        if ($medicalOfficerStatus === 'Approved') {
            $medicalOfficerColor = 'green';
        } elseif ($medicalOfficerStatus === 'Pending') {
            $medicalOfficerColor = 'yellow';
        } elseif ($medicalOfficerStatus === 'Rejected') {
            $medicalOfficerColor = 'red';
        }

        echo '<span style="color: ' . $medicalOfficerColor . ';">' . $medicalOfficerStatus . '</span>';
        ?>
    </td>
</tr>
            <?php else : ?>
                <tr>
                    <td colspan="2">Sick sheet data not found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="footer">
        <p>This is an automated sick sheet.</p>
        <!-- Approval Percentage Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar">
                <div class="filled-progress"></div>
            </div>
            <p><?= $approvalPercentage; ?>% Approval</p>
        </div>

        <?php if ($approvalPercentage === 100) : ?>
            <a href="javascript:window.print();" class="print-link">Print Sick Sheet</a>
        <?php else : ?>
            <a class="print-link faded-button" style="pointer-events: none;">Print Sick Sheet</a>
        <?php endif; ?>
        <a href="home.php" class="home-link">Return to Home</a>
        <button class="back-button" onclick="history.back()">Back</button>

    </div>
</div>
</body>
</html>
