<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printable A4 Page</title>
    <style>
        /* Add your CSS styles for the printable page here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px; /* Adjust as needed */
            margin: 0 auto;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Printable A4 Page</h1>
        </div>
        <div class="content">
            <!-- Display form data here -->
            <h2>Form Data:</h2>
            <?php
// Check if form data exists in the POST request
if (isset($_POST['name']) && isset($_POST['regNo']) && isset($_POST['level']) && isset($_POST['course']) && isset($_POST['department']) && isset($_POST['yearOfStudy']) && isset($_POST['mobilePhone']) && isset($_POST['college']) && isset($_POST['accommodation']) && isset($_POST['hallOfResidence']) && isset($_POST['roomNo'])) {
    // Retrieve form data from the POST request
     // Retrieve form data from the URL query parameters
     $name = urldecode($_GET["name"]);
     $start_date = urldecode($_GET["start_date"]);
     $end_date = urldecode($_GET["end_date"]);
     $phone_number = urldecode($_GET["phone_number"]);
     $residence_area = urldecode($_GET["residence_area"]);
     $registration_number = urldecode($_GET["registration_number"]);
     $course = urldecode($_GET["course"]);
     $department = urldecode($_GET["department"]);
     $year_of_study = urldecode($_GET["year_of_study"]);
     $reason = urldecode($_GET["reason"]);
    

    // Display the form data
    echo '<p><strong>Name of Patient:</strong> ' . $name . '</p>';
    echo '<p><strong>Registration Number:</strong> ' . $start_date . '</p>';
    echo '<p><strong>Level:</strong> ' . $end_date . '</p>';
    echo '<p><strong>Course:</strong> ' . $residence_area . '</p>';
    echo '<p><strong>Department:</strong> ' . $registration_number . '</p>';
    echo '<p><strong>Year of Study:</strong> ' . $course . '</p>';
    echo '<p><strong>Mobile Phone:</strong> ' . $department . '</p>';
    echo '<p><strong>College/Institute/School:</strong> ' . $year_of_study . '</p>';
    echo '<p><strong>Status of Accommodation:</strong> ' . $reason . '</p>';
} else {
    echo '<p>No form data available.</p>';
}
?>

        </div>
        <div class="footer">
            <p>Footer content here</p>
        </div>
    </div>
</body>
</html>
