<?php
	require_once('connection/config.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login Failed</title>
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
    <div class="col-md-6 col-md-offset-3 animated bounceInRight" style="background:#ddffdd; padding:0px; padding-bottom: 50px;">
     <h1 style="background:limegreen; margin:0px; padding:10px; color:white;"> Login Failed !</h1>
     <h4>Please check your username and password and <a href="login-form.php" class="btn btn-primary" style="padding:5px 40px; border-radius:0px;">Try Again</a></h4>
    </div>
  </div>


</body>
</html>
