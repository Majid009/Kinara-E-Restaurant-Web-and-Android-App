<?php require 'connection/config.php'?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>:Registration Successful</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
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
			<h1> Registration Successful </h1>
			<h3> Registration completed successfully !</h3>
			<p><a class="btn btn-primary" style="padding:5px 30px; border-radius:0px;" href="login-register.php">Login To Your Account</a></p>
		</div>
	 </div>
 </div>
</body>
</html>
