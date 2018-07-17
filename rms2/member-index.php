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

//selecting all records from the orders_details table. Return an error if there are no records in the table
$result=mysql_query("SELECT * FROM orders_details,cart_details,food_details,categories,quantities,members WHERE members.member_id='$memberId' AND orders_details.member_id='$memberId' AND orders_details.cart_id=cart_details.cart_id AND cart_details.food_id=food_details.food_id AND food_details.food_category=categories.category_id AND cart_details.quantity_id=quantities.quantity_id")
or die("There are no records to display ... \n" . mysql_error());
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
<?php
    //retrive a currency from the currencies table
    //define a default value for flag_1
    $flag_1 = 1;
    $currencies=mysql_query("SELECT * FROM currencies WHERE flag='$flag_1'")
    or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");
?>
<?php
// retrieving reservations details , Tables
$result_tables = mysql_query("SELECT reservations_details.ReservationID,reservations_details.Reserve_Date,reservations_details.Reserve_Time ,tables.table_name FROM reservations_details,tables WHERE reservations_details.member_id=$memberId AND reservations_details.table_flag=1 AND tables.table_id=reservations_details.table_id");

 ?>
 <?php
 // retrieving reservations details , Rooms
 $result_partyhalls = mysql_query("SELECT reservations_details.ReservationID,reservations_details.Reserve_Date,reservations_details.Reserve_Time ,partyhalls.partyhall_name FROM reservations_details,partyhalls WHERE reservations_details.member_id=$memberId AND reservations_details.partyhall_flag=1 AND partyhalls.partyhall_id=reservations_details.partyhall_id");

  ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME; ?>:Member Home</title>
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
       <h2> Welcome <i><?php echo $_SESSION['SESS_FIRST_NAME'];?></i> </h2>
			 <p style="font-size: 16px;">Here you can view order history and delete old orders from your account. Invoices can be viewed from
			 	 the order history. You can also make table reservations in your account.
			 	 For more information <a href="contactus.php">Click Here</a> to contact us.

				<center> <h3><a class="btn btn-danger" style="font-size:20px;border-radius:0px; padding:10px 30px;" href="foodzone.php"> Order More Food </a></h3> </center>
				 <hr>
				 <table class="table table-stripped table-condensed table-hover" style="text-align:center; background:white;">
				 <center><h2>Order History</h2></center>
				 <tr class="danger">
				 <th> <center>Order ID</center></th>
				 <th><center>Food Photo</center></th>
				 <th><center>Food Name</center></th>
				 <th><center>Food Category</center></th>
				 <th><center>Food Price</center></th>
				 <th><center>Quantity</center></th>
				 <th><center>Total Cost</center></th>
				 <th><center>Delivery Date</center></th>
				 <th><center>Action(s)</center></th>
				 </tr>

				 <?php
				 //loop through all table rows
				 $symbol=mysql_fetch_assoc($currencies); //gets active currency
				 while ($row=mysql_fetch_array($result)){
				 echo "<tr>";
				 echo "<td>" . $row['order_id']."</td>";
				 echo '<td><a href=images/'. $row['food_photo']. ' alt="click to view full image" target="_blank"><img src=images/'. $row['food_photo']. ' width="80" height="80"></a></td>';
				 echo "<td>" . $row['food_name']."</td>";
				 echo "<td>" . $row['category_name']."</td>";
				 echo "<td>" . $symbol['currency_symbol']. " " . $row['food_price']."</td>";
				 echo "<td>" . $row['quantity_value']."</td>";
				 echo "<td>" . $symbol['currency_symbol']. " " . $row['total']."</td>";
				 echo "<td>" . $row['delivery_date']."</td>";
				 echo '<td><a class="btn btn-danger" style="border-radius:0px;" href="delete-order.php?id=' . $row['order_id'] . '">Cancel Order</a></td>';
				 echo "</tr>";
				 }
				 mysql_free_result($result);
				 mysql_close($link);
				 ?>
				 </table>
          <h2 style="text-align:center;"> Reserved Tables </h2>
				 <table class="table table-hover">
				  <tr class="danger">
						<th> Reserved Table </th>
						<th> Reserved Date </th>
						<th> Reserved Time </th>
						<th> Action(s) </th>
					</tr>
					<?php
 				 while ($row=mysql_fetch_array($result_tables)){
 				 echo "<tr>";
 				 echo "<td>" . $row['table_name']."</td>";
				 echo "<td>" . $row['Reserve_Date']."</td>";
				 echo "<td>" . $row['Reserve_Time']."</td>";
				 echo '<td><a href="delete-reservation.php?id=' . $row['ReservationID'] . '" class="btn btn-primary">Cancel Reservation</a></td>';
 				 echo "</tr>";
 				 }
 				 ?>
				 </table>

			 </table>
				<h2 style="text-align:center;"> Reserved Rooms </h2>
			 <table class="table table-hover">
				<tr class="danger">
					<th> Reserved Room </th>
					<th> Reserved Date </th>
					<th> Reserved Time </th>
					<th> Action(s) </th>
				</tr>
				<?php
			 while ($row=mysql_fetch_array($result_partyhalls)){
			 echo "<tr>";
			 echo "<td>" . $row['partyhall_name']."</td>";
			 echo "<td>" . $row['Reserve_Date']."</td>";
			 echo "<td>" . $row['Reserve_Time']."</td>";
			 echo '<td><a href="delete-reservation.php?id=' . $row['ReservationID'] . '" class="btn btn-primary">Cancel Reservation</a></td>';
			 echo "</tr>";
			 }
			 ?>
			 </table>
				 <?php include 'footer.php'; ?>
			</div>
		</div>
	</div>
</body>
</html>
