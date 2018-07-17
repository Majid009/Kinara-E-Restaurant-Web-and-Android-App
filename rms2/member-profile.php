<?php
	require_once('auth.php');
?>
<?php
//checking connection and connecting to a database
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
//get member id from session
$memberId=$_SESSION['SESS_MEMBER_ID'];
?>
<?php
    //retrieving all rows from the cart_details table based on flag=0
    $flag_0 = 0;
    $items=mysql_query("SELECT * FROM cart_details WHERE member_id='$memberId' AND flag='$flag_0'")
    or die("Something is wrong ... \n" . mysql_error());
    //get the number of rows
    $num_items = mysql_num_rows($items);
?>
<?php
    //retrieving all rows from the messages table
    $messages=mysql_query("SELECT * FROM messages")
    or die("Something is wrong ... \n" . mysql_error());
    //get the number of rows
    $num_messages = mysql_num_rows($messages);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>:My Profile</title>
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
<script language="JavaScript" src="validation/user.js"> </script>
</head>
<body>
	<?php include 'navbar.php'; ?>
	<div class="container-fluid" id="inbox_wrapper">
		<div class="row">
			<div class="col-md-2" id="sidenav">
				<a href="member-profile.php"> &nbsp;&nbsp;<i class="fa fa-user"> </i> &nbsp;<?php echo $_SESSION['SESS_FIRST_NAME'];?> </a>
				<a href="member-index.php"> &nbsp;&nbsp;<i class="fa fa-home"> </i> &nbsp;Home </a>
				<a href="cart.php"> &nbsp;&nbsp;<i class="fa fa-shopping-cart"> </i> &nbsp;Cart <span class="badge"><?php echo $num_items;?></span> &nbsp;&nbsp; </a>
				<a href="inbox.php"> &nbsp;&nbsp;<i class="fa fa-envelope-open"> </i> &nbsp;Inbox <span class="badge"><?php echo $num_messages;?></span> &nbsp;&nbsp; </a>
        <a href="tables.php"> &nbsp;&nbsp;<i class="fa fa-star"> </i> &nbsp;Tables</a>
        <a href="partyhalls.php"> &nbsp;&nbsp;<i class="fa fa-circle"> </i> &nbsp;Rooms</a>
        <a href="ratings.php"> &nbsp;&nbsp;<i class="fa fa-line-chart"> </i> &nbsp;Rate Us</a>
				<a href="post_review.php"> &nbsp;&nbsp;<i class="fa fa-line-chart"> </i> &nbsp;Post Review</a>
        <a href="logout.php"> &nbsp;&nbsp;<i class="fa fa-lock"> </i> &nbsp;Logout</a>
			</div>
			<div class="col-md-10" id="inbox_main">
				<h1>My Profile</h1>
				<p style="font-size:16px;">Here you can change your password and also add a billing or delivery address.
					 The delivery address will be used to bill your food orders as well as providing
					 us with details on where to deliver your food. For more information <a href="contactus.php">Click Here</a> to contact us.</p>
					 <hr>
					 <div class="row" style="margin-bottom: 30px;">
					 	 <div class="col-md-4 col-md-offset-1">
							 <h3 style="text-align:center;">Change Your Password</h3>
 	 					 <form id="updateForm" name="updateForm" method="post" action="update-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return updateValidate(this)">
 	 					    <input name="opassword" type="password" class="form-control" id="opassword" placeholder="Old Password" required/>
 	 					    <input name="npassword" type="password" class="form-control" id="npassword" placeholder="New Password" required/>
 	 						  <input name="cpassword" type="password" class="form-control" id="cpassword" placeholder="Confirm New Password" required/>
 	 					     <input type="submit" name="Submit" value="Change" class="btn btn-primary form-control" id="btn_change" />
 	             </form>
					 	 </div>
						 <div class="col-md-4 col-md-offset-1">
							 <h3 style="text-align:center;">Add Delivery / Billing Address</h3>
							 <form id="billingForm" name="billingForm" method="post" action="billing-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return billingValidate(this)">
								 <input name="sAddress" type="text" class="form-control" id="sAddress" placeholder="Street Address" required/>
								 <input name="box" type="text" class="form-control" id="box" placeholder="P.O. Box No" required/>
								 <input name="city" type="text" class="form-control" id="city" placeholder="City" required/>
								 <input name="mNumber" type="text" class="form-control" id="mNumber" placeholder="Mobile No" required/>
								 <input name="lNumber" type="text" class="form-control" id="lNumber" placeholder="Landline No" required />
								 <input type="submit" name="Submit" value="Add" class="form-control btn btn-primary" id="btn_add" />
							 </form>
						 </div>
					 </div>
						<?php include 'footer.php'; ?>
</div>
</div>
</body>
</html>
