<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="fill in css.css">
</head>
<body style="color:whitesmoke">
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="home.php">Home</a>
    <a href="request_sick_sheet.php">Request Sick Sheet</a>
    <a href="chat.php">View Messages</a>
    <a href="#">Approval Status</a>
    <a href="#info">Contact us</a>
    <a href="logout.php">Logout</a>

  </div>
  <div class="content">
  <span style="font-size:30px;cursor:pointer" onclick="openNav()"><h3 style="margin-top:0px">&#9776;<img src="must.png" alt=""><center>MUST ONLINE SICK SHEET</center></h3></span>
  </div>
        
            <h1 style="color:black; margin-top:50px; margin-bottom:-20px">Your Online System</h1>
    
    <?php
    // Assuming you have retrieved the approval status from your database or other source
    // For the sake of this example, we'll use a hardcoded status
    $approvalStatus = "SS_APPROVED"; // Replace this with the actual status code

    // Define an array to map status codes to user-friendly status messages
    $statusMessages = array(
        "SS_SUBMITTED" => "Submitted",
        "SS_PENDING_REVIEW" => "Pending Review",
        "SS_UNDER_VERIFICATION" => "Under Verification",
        "SS_APPROVED" => "Approved",
        // Add more status codes and messages as needed
    );

    // Check if the approval status exists in the status messages array
    if (array_key_exists($approvalStatus, $statusMessages)) {
        $statusMessage = $statusMessages[$approvalStatus];
    } else {
        $statusMessage = "Unknown Status"; // Display a default message if status is not found
    }
   
    // Get the current date in a desired format (e.g., "August 7, 2023")
    $currentDate = date("F j, Y");

    $remarks = "Everything Looks Good.";
    ?>

   
   

    <!-- Add more content or information about the approval status here -->
    <div class="container">
        <h2>Status Page</h2>
        <div id="statusContainer">
       <div class="status-item">
                <span class="status-label">Approval Status:</span>
                <span class="status-value approved"> <p>Your sick sheet submission is currently: <?php echo $statusMessage; ?></p></span>
            </div>
            <div class="status-item">
                <span class="status-label">Approval Date:</span>
                <span class="status-value"> <p>Current Date: <?php echo $currentDate; ?></p></span>
            </div>
            <div class="status-item">
                <span class="status-label">Remarks:</span>
                <span class="status-value"><p><?php echo $remarks; ?></p></span>
            </div>
        </div>
    </div>
    <script src="script.js"></script>


<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>

</body>
</html> 
