<?php
	require_once('auth.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Profile</title>
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
	<div class="container" style="margin-top: 10px; padding:0px;">
		<div class="row">
		<h1 id="title">Administrator Control Panel</h1>
		 <h2 id="subtitle"><i class="fa fa-user-o"></i> Profile</h2>
		<ul id="navbar" class="nav nav-pills">
			<li><a href="index.php"> <img src="../Assests/admin_icons/13.png" width="55px" height="55px"><br> &nbsp; Home</a></li>
			<li> <a href="profile.php"> <img src="../Assests/admin_icons/2.png" width="55px" height="55px"><br>&nbsp;Profile</a> </li>
			<li> <a href="categories.php"> &nbsp;&nbsp;<img src="../Assests/admin_icons/3.png" width="55px" height="55px"><br>Categories</a> </li>
			<li> <a href="foods.php"> <img src="../Assests/admin_icons/4.png" width="55px" height="55px"><br>Foods</a> </li>
			<li> <a href="accounts.php"> <img src="../Assests/admin_icons/5.png" width="55px" height="55px"><br>Accounts</a> </li>
			<li> <a href="orders.php"> <img src="../Assests/admin_icons/6.png" width="55px" height="55px"><br>&nbsp;Orders</a> </li>
			<li> <a href="reservations.php">&nbsp;&nbsp; <img src="../Assests/admin_icons/7.png" width="55px" height="55px"><br>Reservations</a> </li>
			<li> <a href="specials.php"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../Assests/admin_icons/8.png" width="55px" height="55px"><br>Specials Deals</a> </li>
			<li> <a href="allocation.php"> <img src="../Assests/admin_icons/9.png" width="55px" height="55px"><br>&nbsp;Allocation</a> </li>
			<li> <a href="messages.php"> &nbsp; <img src="../Assests/admin_icons/10.png" width="55px" height="55px"><br>Messages</a> </li>
			<li> <a href="options.php"> <img src="../Assests/admin_icons/1.png" width="55px" height="55px"><br> Options</a> </li>
			<li> <a href="logout.php"> <img src="../Assests/admin_icons/11.png" width="55px" height="55px"><br> Logout</a> </li>
    </ul>
	</div>
		<div class="row" style="background:lightblue;">
			<div class="col-md-6" style="padding:0px 100px;">
				<h3 style="text-align: center;">Change Password</h3> <hr>
				<form id="updateForm" name="updateForm" method="post" action="update-exec.php?id=<?php echo $_SESSION['SESS_ADMIN_ID'];?>" onsubmit="return updateValidate(this)">
				  <input name="opassword" type="password" class="form-control" id="opassword" placeholder="Current Password"/> <br>
				  <input name="npassword" type="password" class="form-control" id="npassword" placeholder="New Password"/> <br>
				  <input name="cpassword" type="password" class="form-control" id="cpassword" placeholder="confirm New Password"/> <br>
				  <input type="submit" name="Submit" value="Change" class="form-control btn btn-primary" /> <br>
				</form>
			</div>
			<div class="col-md-6" style="padding:0px 100px;">
				<h3 style="text-align: center;">Add New Staff</h3> <hr>
				<form id="staffForm" name="staffForm" method="post" action="staff-exec.php" onsubmit="return staffValidate(this)">
				  <input name="fName" type="text" class="form-control" id="fName" placeholder="First Name"/> <br>
				  <input name="lName" type="text" class="form-control" id="lName" placeholder="Last Name"/> <br>
				  <input name="sAddress" type="text" class="form-control" id="sAddress" placeholder="Street Address"/> <br>
				  <input name="mobile" type="text" class="form-control" id="mobile" placeholder="Mobile No"/> <br>
				  <input type="submit" name="Submit" value="Add" class="form-control btn btn-primary" /> <br> <br>
				</form>
			</div>
		</div>
	</div>

</body>
</html>
