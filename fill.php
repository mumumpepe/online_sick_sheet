<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sick Sheet Form</title>
    <link rel="stylesheet" href="fill in css.css">
</head>
<body>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="home.php">Home</a>
    <a href="request_sick_sheet.php">Request Sick Sheet</a>
    <a href="#">View Messages</a>
    <a href="approval_status.php">Approval Status</a>
    <a href="#info">Contact us</a>
    <a href="logout.php">Logout</a>


  </div>
  <div class="content">
  <span style="font-size:30px;cursor:pointer" onclick="openNav()"><h3 style="margin-top:0px">&#9776;<img src="must.png" alt=""><center>MUST ONLINE SICK SHEET</center></h3></span>
  </div>
    <div class="container">
        <h1>Student Sick Sheet Form</h1>
        <form action="submit.php" method="post">
            <label for="name">Name of Patient:</label>
            <input type="text" id="name" name="name"  required>

            <label for="regNo">Registration Number:</label>
            <input type="text" id="regNo" name="regNo"  required>

            <label for="level">Level:</label>
            <input type="text" id="level" name="level" required>

            <label for="course">Course:</label>
            <input type="text" id="course" name="course" required>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>

            <label for="yearOfStudy">Year of Study:</label>
            <select id="yearOfStudy" name="yearOfStudy" required>
                <option value="" disabled selected>Select Year of Study</option>
                <option value="1st">1st Year</option>
                <option value="2nd">2nd Year</option>
                <option value="3rd">3rd Year</option>
                <option value="4th">4th Year</option>
            </select>

            <label for="mobilePhone">Mobile Phone:</label>
            <input type="tel" id="mobilePhone" name="mobilePhone" pattern="[0-9]{10}" required>

            <label for="college">College/Institute/School:</label>
            <input type="text" id="college" name="college" required>

            <label for="accommodation">Status of Accommodation:</label><br>
            <select id="accommodation" name="accommodation" required><br>
                <option value="" disabled selected></option>
                <option value="1st">inCampus</option>
                <option value="2nd">offCampus</option>
            </select><br>

            <label for="hallOfResidence">Hall of Residence:</label>
            <input type="text" id="hallOfResidence" name="hallOfResidence" required>

            <label for="roomNo">Room No:</label>
            <input type="text" id="roomNo" name="roomNo" required>

            <button type="button" id="submitButton">Submit</button>
        </form>
        <div id="successMessage" style="display: none;">
        <p>Form submitted successfully!</p>
        <a href="printable_a4_page.php" target="_blank">Printable A4 Form</a>
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
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Get references to form elements
    const form = document.querySelector("form");
    const submitButton = document.getElementById("submitButton");
    const successMessage = document.getElementById("successMessage");

    submitButton.addEventListener("click", function () {
        // Create a FormData object to collect form data
        const formData = new FormData(form);

        // Send form data to the server using AJAX
        fetch("submit.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            // Hide the form and display success message
            form.style.display = "none";
            successMessage.style.display = "block";
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });
});
</script>













