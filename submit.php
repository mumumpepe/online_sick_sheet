<?php
$mysqli = new mysqli("localhost", "root", "", "registrations");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Gather form data
$name = $_POST['name'];
// Add similar lines for other form fields

$sql = "INSERT INTO std_sub (name, regNo, level, course, department, yearOfStudy, mobilePhone, college, accommodation, hallOfResidence, roomNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare and execute the statement
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("sssssssssss", $name, $regNo, $level, $course, $department, $yearOfStudy, $mobilePhone, $college, $accommodation, $hallOfResidence, $roomNo);

    if ($stmt->execute()) {
        // Form submitted successfully
        echo "Form submitted successfully!";
    } else {
        echo "Error: " . $mysqli->error;
    }

    $stmt->close();
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>
