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
/* Your existing CSS styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 20px;
}

h2 {
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ccc;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.message {
    color: green;
    font-weight: bold;
}

/* Additional styles */
.content {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #007bff;
    color: white;
    padding: 10px;
    font-size: 20px;
}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 8px 8px 8px 16px;
    text-decoration: none;
    font-size: 20px;
    color: white;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

/* Media query for small screens */
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
}

    </style>
</head>
<body style="background-color:white">
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="home.php">Home</a>
    <a href="receive.php">Chat</a>
    <a href="html.php">Contact Submission</a>
    <a href="index.php">Logout</a>

  </div>
  <div class="content">
  <span style="font-size:30px;cursor:pointer" onclick="openNav()"><h3 style="margin-top:0px">&#9776;<img src="must.png" alt=""><center>MUST ONLINE SICK SHEET</center></h3></span>
  </div>
   <center> <table border="1">
   <div class="container">
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
                        <td><a href="admin_panel.php?delete_id=<?php echo $row['id']; ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
   

  </script>
