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
//selecting all records from almost all tables. Return an error if there are no records in the tables
$result=mysql_query("SELECT members.member_id, members.firstname, members.lastname, billing_details.Street_Address, billing_details.Mobile_No, orders_details.*, food_details.*, cart_details.*, quantities.* FROM members, billing_details, orders_details, quantities, food_details, cart_details WHERE members.member_id=orders_details.member_id AND billing_details.billing_id=orders_details.billing_id AND orders_details.cart_id=cart_details.cart_id AND cart_details.food_id=food_details.food_id AND cart_details.quantity_id=quantities.quantity_id")
or die("There are no records to display ... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<title>Orders</title>
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
		 <h2 id="subtitle">Orders Management</h2>
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
		<div class="row" style="background:lightblue; padding:10px;">
			 <h3 style="text-align: center;">Orders List</h3> <hr>
			 <table class="table table-responsive table-condensed table-hover" style="text-align:center;">
			 <tr class="danger">
			 <th>Order ID</th>
			 <th>Customer Names</th>
			 <th>Food Name</th>
			 <th>Food Price</th>
			 <th>Quantity</th>
			 <th>Total Cost</th>
			 <th>Delivery Date</th>
			 <th>Delivery Address</th>
			 <th>Mobile No</th>
			 <th>Actions(s)</th>
			 <th>Allocated Satff ID</th>
			 </tr>

			 <?php
			 //loop through all tables rows
			 while ($row=mysql_fetch_assoc($result)){
			 echo "<tr>";
			 echo "<td>" . $row['order_id']."</td>";
			 echo "<td>" . $row['firstname']."\t".$row['lastname']."</td>";
			 echo "<td>" . $row['food_name']."</td>";
			 echo "<td>" . $row['food_price']."</td>";
			 echo "<td>" . $row['quantity_value']."</td>";
			 echo "<td>" ."Rs.". $row['total']."</td>";
			 echo "<td>" . $row['delivery_date']."</td>";
			 echo "<td>" . $row['Street_Address']."</td>";
			 echo "<td>" . $row['Mobile_No']."</td>";
			 echo '<td><a href="delete-order.php?id=' . $row['order_id'] . '">Remove Order</a></td>';
			 if($row['StaffID']==0){echo "<td> Not Allocated </td>";}
			 if($row['StaffID']!=0){echo "<td>" . $row['StaffID']."</td>";}
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
