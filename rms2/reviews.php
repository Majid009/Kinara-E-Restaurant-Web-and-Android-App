<?php
	//Include database connection details
	require_once('connection/config.php');
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}

  $result = mysql_query("SELECT * from reviews");
  $num = mysql_num_rows($result);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>:Registration Failed</title>
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
</script>
</head>
<body style="background:white;">
	<?php include 'navbar.php'; ?>
 <div class="container" style="background:white;">
	 <div class="row">
    <div class="col-md-8 col-md-offset-2 animated zoomIn" style="margin-top:40px;">
			<h1 style="text-align:center;"> Customer's Reviews </h1> <hr>

  <?php
  for ($i=0; $i <$num ; $i++) {
    $row = mysql_fetch_array($result);
     ?>
    <img src="Assests/images/user_icon.png" style="width:60px; height:60px;">
     <i style="font-size:20px;"> <?php echo $row['user_name']; ?> </i>
     <p style="margin-left:60px; margin-top:-15px; text-align:justify; width:600px;"> <?php echo $row['user_review']; ?> </p> <hr>
      <?php
   }
   ?>
		</div>
	 </div>
 </div>
</body>
</html>
