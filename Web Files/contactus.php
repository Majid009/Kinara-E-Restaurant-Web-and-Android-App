<?php require_once('connection/config.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo APP_NAME; ?>:Contacts</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
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
<body>
<?php include 'navbar.php'; ?>
<div id="center" style="margin-top:60px;">
  <h1>Contact Us</h1>

  <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
  <table width="500" height="50">
  <tr><td rowspan="11"><img width="400" height="400" src="images/pizza-inn-map4-mombasa-road.png" /></td></tr>
  <tr><td rowspan="11"></td></tr>
  <tr><td><?php echo APP_NAME ?> Restaurant</td></tr>
  <tr><td>P.O. Box: 45640-00100</td></tr>
  <tr><td>Ikorodu</td></tr>
  <tr><td>Lagos</td></tr>
  <tr><td>Nigeria</td></tr>
  <tr><td>Landline: +014553456</td></tr>
  <tr><td>Mobile: +2348022334455/+2348011223344/+2347012345678</td></tr>
  <tr><td>Email: sales@kinarahotel.com</td></tr>
  </table>
  </div>
</div>
<?php include 'footer.php'; ?>
</div>

</body>
</html>
