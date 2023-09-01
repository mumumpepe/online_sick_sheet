<?php
session_start();

// Check if the user is logged in (You may add your login check here)

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

// Fetch sick sheet data for the selected request
$registration_number = $_GET["registration_number"];
$sickSheetData = fetchSickSheetData($conn, $registration_number);

// Fetch Director and Medical Officer approval statuses
$directorApprovalStatus = strtoupper($sickSheetData["director_approval_status"] ?? 'PENDING');
$medicalOfficerApprovalStatus = strtoupper($sickSheetData["approval_status"] ?? 'PENDING');

function fetchSickSheetData($conn, $registration_number) {
    // Query to fetch sick sheet data for the selected request
    $query = "SELECT * FROM sick_sheet_requests WHERE registration_number = '$registration_number'";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // No sick sheet data found
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Sick Sheet</title>
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

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        /* Button styles */
        .print-button {
            background-color: #ff0000; /* Red color for print button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        
        .home-button {
            background-color: #007bff; /* Blue color for home button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            text-decoration: none;
        }
        
        .back-button {
            background-color: #00cc00; /* Green color for back button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Progress bar styles */
        .progress-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .progress-bar {
            flex-grow: 1;
            height: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            width: <?php echo ($directorApprovalStatus === 'APPROVED' && $medicalOfficerApprovalStatus === 'APPROVED') ? '100%' : '0%'; ?>;
            background-color: #007bff;
            border-radius: 5px;
            transition: width 0.5s ease;
        }

        .progress-text {
            margin-left: 10px;
            font-weight: bold;
            color: #007bff;
        }

        /* Disable the print button when approval status is not 100% */
        <?php if ($directorApprovalStatus !== 'APPROVED' || $medicalOfficerApprovalStatus !== 'APPROVED') : ?>
        .print-button {
            background-color: #ff6666; /* Light red for disabled print button */
            cursor: not-allowed;
        }
        <?php endif; ?>

        /* Hide buttons and links when printing */
        @media print {
            .print-button,
            .home-button,
            .back-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1>View Sick Sheet</h1>

    <div class="container">
        <h2>Student Sick Sheet Details:</h2>
        <table>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
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
    <td class="progress-text" style="color:
        <?php
        if ($directorApprovalStatus === 'APPROVED') {
            echo 'green'; // Green color for approved
        } elseif ($directorApprovalStatus === 'REJECTED') {
            echo 'red'; // Red color for rejected
        } else {
            echo 'yellow'; // Yellow color for pending (default)
        }
        ?>
    ;">
        <?= $directorApprovalStatus; ?>
    </td>
</tr>

<!-- Medical Officer Approval Status -->
<tr>
    <td>Medical Officer Approval Status:</td>
    <td class="progress-text" style="color:
        <?php
        if ($medicalOfficerApprovalStatus === 'APPROVED') {
            echo 'green'; // Green color for approved
        } elseif ($medicalOfficerApprovalStatus === 'REJECTED') {
            echo 'red'; // Red color for rejected
        } else {
            echo 'yellow'; // Yellow color for pending (default)
        }
        ?>
    ;">
        <?= $medicalOfficerApprovalStatus; ?>
    </td>
</tr>

            <?php else : ?>
                <tr>
                    <td colspan="2">Sick sheet data not found.</td>
                </tr>
            <?php endif; ?>
        </table>

       <!-- Progress bar -->
<div class="progress-container">
    <div class="progress-bar">
        <div class="progress-fill" style="width:
            <?php
            if ($directorApprovalStatus === 'APPROVED' && $medicalOfficerApprovalStatus === 'APPROVED') {
                echo '100%';
            } elseif ($directorApprovalStatus === 'APPROVED' || $medicalOfficerApprovalStatus === 'APPROVED') {
                echo '50%';
            } else {
                echo '0%';
            }
            ?>
        ;"></div>
    </div>
    <div class="progress-text">
        <?php
        if ($directorApprovalStatus === 'APPROVED' && $medicalOfficerApprovalStatus === 'APPROVED') {
            echo 'Approval Status: 100%';
        } elseif ($directorApprovalStatus === 'APPROVED' || $medicalOfficerApprovalStatus === 'APPROVED') {
            echo 'Approval Status: 50%';
        } else {
            echo 'Approval Status: 0%';
        }
        ?>
    </div>
</div>

        <!-- ... (previous code) ... -->

        <!-- Buttons for Home, Print, and Back -->
        <a href="home.php" class="home-button">Home</a>

        <?php if ($directorApprovalStatus === 'APPROVED' && $medicalOfficerApprovalStatus === 'APPROVED') : ?>
            <button class="print-button" onclick="window.print()">Print Sick Sheet</button>
        <?php else : ?>
            <button class="print-button" disabled>Print Sick Sheet</button>
        <?php endif; ?>

        <button class="back-button" onclick="history.back()">Back</button>

        <!-- ... (remaining code) ... -->
    </div>
</body>
</html>
