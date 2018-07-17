<?php
	//Start session
	session_start();

	//Unset the variables stored in session
	unset($_SESSION['SESS_ADMIN_ID']);
	unset($_SESSION['SESS_ADMIN_NAME']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Logged Out</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<!--  Including Boostrap and JQuery Files   -->
  <link rel="stylesheet"  href="../Assests/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!---------------------------------------------->
<link rel="stylesheet"  href="../Assests/css/animate_css_stylesheet.css">
</head>
<body>
	<div class="container" style="text-align: center; margin-top: 100px;">
    <div class="col-md-6 col-md-offset-3 animated bounceInLeft" style="background:#ddffdd; padding:0px; padding-bottom: 50px;">
     <h1 style="background:limegreen; margin:0px; padding:10px; color:white;"> Logout </h1>
     <h4>You have been logged out ! </h4> <br>
     <p><a href="login-form.php" class="btn btn-primary" style="padding:5px 50px; border-radius:50px;">Login Again</a></p>
    </div>
  </div>
</body>
</html>
