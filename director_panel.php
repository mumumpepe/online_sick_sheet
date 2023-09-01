<?php
// Retrieve the request ID from the URL parameter
$requestId = $_GET['id'];

// Perform database update to mark the request as approved
// ...

// Redirect back to the respective panel page
header("Location: director_panel.php"); // Redirect to the medical officer panel
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Director of Students Panel</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <h1>Director of Students Panel</h1>
    <!-- Display the list of pending requests in a table -->
    <table>
        <!-- Table headers -->
        <tr>
            <th>Student Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
        </tr>
        <!-- Loop through pending requests and display them -->
        <?php foreach ($pendingRequests as $request) : ?>
            <tr>
                <td><?php echo $request['student_name']; ?></td>
                <td><?php echo $request['start_date']; ?></td>
                <td><?php echo $request['end_date']; ?></td>
                <td>
                    <!-- Buttons to approve or reject requests -->
                    <a href="approve_request.php?id=<?php echo $request['id']; ?>">Approve</a>
                    <a href="reject_request.php?id=<?php echo $request['id']; ?>">Reject</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <!-- Add any additional content or styling as needed -->
</body>
</html>
