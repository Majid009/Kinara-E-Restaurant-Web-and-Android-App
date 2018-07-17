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
//retrive promotions from the specials table
$result=mysql_query("SELECT * FROM specials")
or die("There are no records to display ... \n" . mysql_error());
?>
<?php
    //retrive a currency from the currencies table
    //define a default value for flag_1
    $flag_1 = 1;
    $currencies=mysql_query("SELECT * FROM currencies WHERE flag='$flag_1'")
    or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");
?>
<!DOCTYPE html>
<html>
<head>
<title>Specials</title>
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
		 <h2 id="subtitle">Specials Deals Management</h2>
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

	<div class="row" style="background:lightblue; padding:5px">
		<div style="width:400px; margin:auto;">
			<h3 style="text-align: center;">Manage Promotion</h3> <hr>
			<form name="specialsForm" id="specialsForm" action="specials-exec.php" method="post" enctype="multipart/form-data" onsubmit="return specialsValidate(this)">
			 <input type="text" name="name" id="name" class="form-control" placeholder="Promotion Name"/> <br>
				<textarea name="description" id="description" class="form-control" rows="2" placeholder="Description"></textarea> <br>
				 <input type="text" name="price" id="price" class="form-control" placeholder="Price"/> <br>
				<b>Start Date:</b> <input type="date" name="start_date" id="start_date" class="form-control" /> <br>
				 <b>End Date:</b><input type="date" name="end_date" id="end_date" class="form-control" /> <br>
				 <b>Photo:</b><input type="file" name="photo" id="photo" class="form-control"/> <br>
				 <input type="submit" name="Submit" value="Add" class="form-control btn btn-primary"/> <br>
		 </form>
		</div>
		<table class="table table-responsive"width="950" align="center">
		<h3 style="text-align: center;">Promotions List</h3>
		<tr class="success">
		<th>Promo Photo</th>
		<th>Promo Name</th>
		<th>Promo Description</th>
		<th>Promo Price</th>
		<th>Start Date</th>
		<th>End Date</th>
		<th>Action(s)</th>
		</tr>
		<?php
		//loop through all table rows
		$symbol=mysql_fetch_assoc($currencies); //gets active currency
		while ($row=mysql_fetch_array($result)){
		echo "<tr>";
		echo '<td><img src=../images/'. $row['special_photo']. ' width="80" height="70"></td>';
		echo "<td>" . $row['special_name']."</td>";
		echo "<td width='180' align='left'>" . $row['special_description']."</td>";
		echo "<td>" . $symbol['currency_symbol']. "" . $row['special_price']."</td>";
		echo "<td>" . $row['special_start_date']."</td>";
		echo "<td>" . $row['special_end_date']."</td>";
		echo '<td><a href="delete-special.php?id=' . $row['special_id'] . '">Remove Promo</a></td>';
		echo "</tr>";
		}
		mysql_free_result($result);
		mysql_close($link);
		?>
		</table>
	</div>
</div>

</body>
</html>
