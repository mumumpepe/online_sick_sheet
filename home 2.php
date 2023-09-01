<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="fill in css.css">
</head>
<body style="background-color:white">
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="receive.php">Chat</a>
    <a href="admin.php">Sick Sheet Submission</a>
    <a href="html.php">Contact Submission</a>
    <a href="index.php">Logout</a>

  </div>
  <div class="content">
  <span style="font-size:30px;cursor:pointer" onclick="openNav()"><h3 style="margin-top:0px">&#9776;<img src="must.png" alt=""><center>MUST ONLINE SICK SHEET</center></h3></span>
  </div>
  <div class="hero">
  <center><h2 >Welcome to Online Sick Sheet System</h2>
    </center>
</div>

<div class="features">
    <h2>Key Features</h2>
    <ul class="*">
      <li>Easy sick sheet submission</li>
      <li>Real-time chat with medical staff</li>
      <li>Check approval status online</li>
      <li>Link to nearby hospitals</li>
    </ul>
  </div>

  <div class="services">
    <h2><center>Our Services</h2>
    <div class="service1">
      <h3>Service 1</h3>
      <p></p>
    </div>
    <div class="service2">
      <h3>Service 2</h3>
      <p></p>
    </div>
    </div>
    <!-- Add more service sections here -->
<div class="testimonials">
    <h2><center>Testimonials</h2>
    <div class="testimonial1" >
      <p >" there have been several cases whereby students fall sick and are unable to attend classes, participate in university activities sometimes unable to attend course works and university examminations "</p>
    </div>
    <div class="testimonial2" >
      <p >" we made this system to enable students to send their ill information to the university on time also on university side to be able to receive those informations on time "</p>
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

