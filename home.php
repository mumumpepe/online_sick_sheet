<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="fill in css.css">
</head>
<body style="background-color:white">
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="request_sick_sheet.php">Request Sick Sheet</a>
    <a href="student_messaging.php">View Messages</a>
    <a href="sick_sheet_progress.php">Approval Status</a>
    <a href="#info">Contact us</a>
    <a href="logout.php">Logout</a>


  </div>
  <div class="content">
  <span style="font-size:30px;cursor:pointer" onclick="openNav()"><h3 style="margin-top:0px">&#9776;<img src="must.png" alt=""><center>MUST ONLINE SICK SHEET</center></h3></span>
  </div>
  <div class="hero">
  <marquee><center><h2 >Welcome to Online Sick Sheet System</h2>
    </center></marquee>
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
  <p>Provision of full approved Student's Sick Sheet Form</p>
</div>
<div class="service2">
  <h3>Service 2</h3>
  <p>Linkage to nearby hospitals to favour generations of sick sheets within a short time</p>
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
    <!-- Add more testimonial sections here -->

  <!-- Add more content sections as needed -->

  <div class="footer">
 <div  class="form_container">
 <h3>NEED HELP</h3>
    <form action="help.php" method="post">
    <input type="email" placeholder="Enter your email" width="2%s" name= "email" id="email" />
    <input type="text" class="message-box" placeholder="Enter Message" name= "message"id="message" />
     <br><button type="submit" name="submit" id="submit" required>
       Submit
      </button>
      </form>
      </div>
      <div class="contact-section" >
  <a id="info">
  <h3>CONTACT US</h3>
  <a href="">Address: P.o.Box<div style="font-family:arial; margin-bottom:0px"> 131</div>,Mbeya</a>
    <a href="">Email: must@mustnet.ac.tz</a >
    <a href="" >Phone: <div style="font-family:arial; margin-bottom:-25px">+255 (0)25 2502302, (0)736608528</div></a >
<a>
</div>
</div>
<div class="copyright"><u><p>................................................................................</p></u>
<center><p >
         copyright &copy;<span id="displayYear"></span>2023 mbeya university of science and technology|
         </p><p>|developed and maintained by: mbeya university COICT group2 field students </p> </center>
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

