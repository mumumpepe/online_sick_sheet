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

$query = "SELECT msg_id, messageInput  FROM messages";
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
    $sql = "DELETE FROM messages WHERE msg_id = $delete_id";

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
    <a href="html.php">Contact Submission</a>
     <a href="admin.php">Sick Sheet Submission</a>
    <a href="login1.php">Logout</a>

  </div>
  <div class="content">
  <span style="font-size:30px;cursor:pointer" onclick="openNav()"><h3 style="margin-top:0px">&#9776;<img src="must.png" alt=""><center>MUST ONLINE SICK SHEET</center></h3></span>
  </div>
  
  <h1 style="color:black; margin-top:50px; margin-bottom:-20px">Your Online System</h1>
    <div class="container" style="width:500px">
        <h2 style="color:black">Chat Page</h2>
        <div id="chatContainer">
            <div id="chatMessages">
            <?php foreach ($data as $row) : ?>
            
             <div class="message received" style="margin-left:150px">
                    <p style="color:#007bff;text-transform:capitalize"><td><?php echo $row['messageInput']; ?><br><br><br><br><a href="receive.php?delete_id=<?php echo $row['msg_id']; ?>" style="text-decoration:none;margin-left:250px">delete</a></td></p>
                </div>' 
                <?php endforeach; ?>
            </div>
            <div id="chatInput">
            <form action="send.php" method="post">
                <input type="text" name="message" id="message" placeholder="Type a message...">
                <button type="submit" name="submit" id="submit" required>Send</button>
                </form>
            </div>
        </div>
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
