<?php
$host = "localhost";
$dbname = "registrations";
$username = "root";
$password = "";

// Create a new mysqli object
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $delete_id = $_GET['id'];

    // SQL query to delete the submission
    $sql = "DELETE FROM sick_sheet_requests WHERE id = $delete_id";

    if ($conn->query($sql) === TRUE) {
        // Fetch the updated data
        $query = "SELECT * FROM sick_sheet_requests";
        $result = $conn->query($query);

        if ($result) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error fetching data: ' . $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting record: ' . $conn->error]);
    }
}

$conn->close();
?>
