<!-- admin_panel.php -->
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

$query = "SELECT con_id, email, message FROM contants";
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
    $sql = "DELETE FROM contants WHERE con_id = $delete_id";

    if ($conn->query($sql) === TRUE) {
        $message[]= "Record deleted successfully.";
    } else {
        $message[]="Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="fill in css.css">
</head>
<body style="background-color:white">
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="home.php">Home</a>
    <a href="receive.php">Chat</a>
    <a href="admin.php">Sick Sheet Submission</a>
    <a href="index.php">Logout</a>

  </div>
  <div class="content">
  <span style="font-size:30px;cursor:pointer" onclick="openNav()"><h3 style="margin-top:0px">&#9776;<img src="must.png" alt=""><center>MUST ONLINE SICK SHEET</center></h3></span>
  </div>
  
    <h1 style="color:black; margin-bottom:-40px; margin-top:80px ; font-size:25px">CONCTACT SUBMISSIONS</h1>
   <center><table border="1" style="font-size:25px;">
       <tr>
                <th>ID</th>
                <th>USERNAME</th>
                <th>PASSWORD</th>
                <th></th>
            </tr>

            <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?php echo $row['con_id']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                    <td><a href="html.php?delete_id=<?php echo $row['con_id']; ?>">delete</a></td>
</tr>
            <?php endforeach; ?>
        </table></center>
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
