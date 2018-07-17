<?php require 'connection/config.php'?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> <?php echo APP_NAME ?>:Registration Failed</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js"> </script>
<!--  Including Boostrap and JQuery Files   -->
   <link rel="stylesheet"  href="Assests/css/bootstrap.min.css">
   <link rel="stylesheet"  href="Assests/css/font-awesome.min.css">
   <script src="Assests/js/bootstrap.min.js"> </script>
   <script src="/Assests/js/jquery.js"> </script>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!---------------------------------------------->
<link rel="stylesheet"  href="Assests/css/animate_css_stylesheet.css">
</head>
<body style="background: #363C33;">
	<?php include 'navbar.php'; ?>
 <div class="container-fluid">
	 <div class="row">
    <div class="col-md-4 col-md-offset-4 animated zoomIn" style="margin-top:100px;  text-align:center; color:white;">
			<h1> Registration Failed !</h1>
      <p style="text-align:justify;">You are seeing this page because your attempt to create a new account has failed.
        You have used an email address that is already in use.
        <a href="login-register.php">Click Here</a> to try again. Or <a href="JavaScript: resetPassword()">Click Here</a> to
         reset your password.</p>
		 <br><p><a class="btn btn-primary" style="padding:5px 30px; border-radius:0px;" href="login-register.php">Try Again To Register</a></p>
		 <br><p><a class="btn btn-primary" style="padding:5px 30px; border-radius:0px;" href="JavaScript: resetPassword()">Reset You Password</a></p>
		</div>
	 </div>
 </div>
</body>
</html>
