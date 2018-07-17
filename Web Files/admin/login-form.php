<?php
  require_once('connection/config.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Form</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<!--  Including Boostrap and JQuery Files   -->
  <link rel="stylesheet"  href="../Assests/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!---------------------------------------------->
<link rel="stylesheet"  href="../Assests/css/animate_css_stylesheet.css">
<script language="JavaScript" src="validation/admin.js"> </script>
</head>
<body>
  <div class="container" style="text-align: center; margin-top: 100px;">
    <div class="col-md-6 col-md-offset-3 animated bounceInLeft" style="background:#ddffdd; padding:0px; padding-bottom: 50px;">
     <h1 style="background:limegreen; margin:0px; padding:10px; color:white;"> Administrator Login </h1>
     <div style="width:80%; margin:auto;">
     <form id="loginForm" name="loginForm" method="post" action="login-exec.php" onsubmit="return loginValidate(this)">
       <br> <input name="login" type="text" class="form-control" id="login" placeholder="Email / Username"/> <br>
       <input name="password" type="password" class="form-control" id="password" placeholder="Password"/> <br>
       <input type="submit" name="Submit" value="Login" class="form-control btn btn-success" id="login_btn" /> <br>
     </form>
   </div>
    </div>
  </div>
</body>
</html>
