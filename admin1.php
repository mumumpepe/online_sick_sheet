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

$data = array();

$query = "SELECT * FROM sick_sheet_requests";
$result = $conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo 'Query error: ' . $conn->error;
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // SQL query to delete the submission
    $sql = "DELETE FROM sick_sheet_requests WHERE id = $delete_id";

    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully.";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Sidebar Styles */
        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: -250px;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            background-color: #007bff;
            color: white;
        }

        .closebtn {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 30px;
            color: white;
        }

        /* Content Styles */
        .content {
            margin-left: 0;
            padding: 20px;
            transition: margin-left 0.5s;
        }

        /* Menu Icon Styles */
        #menu-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 30px;
            cursor: pointer;
            color: white;
            z-index: 2;
        }

        /* Table Styles */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Message Styles */
        .message {
            color: #28a745;
            margin-top: 10px;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .sidenav {
                width: 100%;
                left: 0;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body style="background-color: white;">
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="home.php">Home</a>
        <a href="receive.php">Chat</a>
        <a href="html.php">Contact Submission</a>
        <a href="index.php">Logout</a>
    </div>
    <span id="menu-icon" onclick="openNav()">&#9776;</span>
    <div class="content">
        <center>
            <h2>Admin Panel - View Requests</h2>
            <?php
            if (isset($message)) {
                echo "<p class='message'>$message</p>";
            }
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Residence Area</th>
                        <th>Registration Number</th>
                        <th>Course</th>
                        <th>Department</th>
                        <th>Year of Study</th>
                        <th>Reason</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['residence_area']; ?></td>
                            <td><?php echo $row['registration_number']; ?></td>
                            <td><?php echo $row['course']; ?></td>
                            <td><?php echo $row['department']; ?></td>
                            <td><?php echo $row['year_of_study']; ?></td>
                            <td><?php echo $row['reason']; ?></td>
                            <td><?php echo $row['start_date']; ?></td>
                            <td><?php echo $row['end_date']; ?></td>
                            <td><button onclick="deleteRecord(<?php echo $row['id']; ?>)">Delete</button></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </center>
    </div>

    <script>
    // Function to delete a record without page shifting
    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            // Send an AJAX request to delete_record.php
            fetch(`delete_record.php?id=${id}`, {
                method: "GET",
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Handle success (update table)
                    alert('Record deleted successfully.');
                    updateTable(data.data);
                } else {
                    // Handle error
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    }

    // Function to update the table with new data
    function updateTable(data) {
        // Get the table body element
        const tableBody = document.querySelector("table tbody");

        // Clear existing table rows
        tableBody.innerHTML = "";

        // Iterate through the data and create table rows
        data.forEach(rowData => {
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${rowData.id}</td>
                <td>${rowData.name}</td>
                <td>${rowData.phone_number}</td>
                <td>${rowData.residence_area}</td>
                <td>${rowData.registration_number}</td>
                <td>${rowData.course}</td>
                <td>${rowData.department}</td>
                <td>${rowData.year_of_study}</td>
                <td>${rowData.reason}</td>
                <td>${rowData.start_date}</td>
                <td>${rowData.end_date}</td>
                <td><button onclick="deleteRecord(${rowData.id})">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
        });
    }
</script>


</body>

</html>
