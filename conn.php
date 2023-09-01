<?php

$con = new mysqli('localhost', 'root', '', 'registrations');
  
$usertrim = trim($_POST['username']);

$userstrip = stripcslashes($usertrim);
$finaluser = htmlspecialchars($userstrip);


$passtrim = trim($_POST['password']);

$passstrip = stripcslashes($passtrim);
$finalpass = htmlspecialchars($passstrip);


$sql=" SELECT * FROM reg_tbl where username='$finaluser' AND  password='$finalpass' ";

$result = mysqli_query($con,$sql);



if(mysqli_num_rows($result)>=1)
{
    $_SESSION["myadmin"]= $finaluser; 
    header("Location:home.php");
}

?>