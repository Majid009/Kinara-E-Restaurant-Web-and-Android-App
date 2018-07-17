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
//selecting all records from the reservations_details table based on table ids. Return an error if there are no records in the table
$tables=mysql_query("SELECT members.firstname, members.lastname, reservations_details.ReservationID, reservations_details.table_id, reservations_details.Reserve_Date, reservations_details.Reserve_Time,reservations_details.staffID, tables.table_id, tables.table_name,staff.First_Name FROM members, reservations_details, tables, staff WHERE members.member_id = reservations_details.member_id AND tables.table_id=reservations_details.table_id AND staff.staffID=reservations_details.staffID")
or die("There are no records to display ... \n" . mysql_error());

//selecting all records from the reservations_details table based on partyhall ids. Return an error if there are no records in the table
$partyhalls=mysql_query("SELECT members.firstname, members.lastname, reservations_details.ReservationID, reservations_details.partyhall_id, reservations_details.Reserve_Date, reservations_details.Reserve_Time,reservations_details.staffID, partyhalls.partyhall_id, partyhalls.partyhall_name,staff.First_Name FROM members, reservations_details, partyhalls,staff WHERE members.member_id = reservations_details.member_id AND partyhalls.partyhall_id=reservations_details.partyhall_id  AND staff.staffID=reservations_details.staffID")
or die("There are no records to display ... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<title>Reservations</title>
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
		 <h2 id="subtitle">Reservations Management</h2>
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
		<div class="row" style="background:lightblue; padding:10px 50px;">
			<table class="table table-responsive table-condensed table-hover">
			<CAPTION><h3 style="text-align: center;">Tables Reserved</h3></CAPTION>
			<tr class="danger">
			<th>Reservation ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Table Name</th>
			<th>Reserved Date</th>
			<th>Reserved Time</th>
			<th>Allocated Satff</th>
			<th>Action(s)</th>
			</tr>

			<?php
			//loop through all table rows
			while ($row=mysql_fetch_array($tables)){
			echo "<tr>";
			echo "<td>" . $row['ReservationID']."</td>";
			echo "<td>" . $row['firstname']."</td>";
			echo "<td>" . $row['lastname']."</td>";
			echo "<td>" . $row['table_name']."</td>";
			echo "<td>" . $row['Reserve_Date']."</td>";
			echo "<td>" . $row['Reserve_Time']."</td>";
			echo "<td>" . $row['First_Name']."</td>";
			echo '<td><a href="delete-reservation.php?id=' . $row['ReservationID'] . '" class="btn btn-primary">Delete Reservation</a></td>';
			echo "</tr>";
			}
			mysql_free_result($tables);
			//mysql_close($link);
			?>
			</table>
			<hr>
			<table class="table table-responsive table-condensed table-hover">
			<CAPTION><h3 style="text-align: center;">Room Reserved</h3></CAPTION>
			<tr class="danger">
			<th>Reservation ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Room Name</th>
			<th>Reserved Date</th>
			<th>Reserved Time</th>
			<th>Allocated Staff</th>
			<th>Action(s)</th>
			</tr>

			<?php
			//loop through all table rows
			while ($row=mysql_fetch_array($partyhalls)){
			echo "<tr>";
			echo "<td>" . $row['ReservationID']."</td>";
			echo "<td>" . $row['firstname']."</td>";
			echo "<td>" . $row['lastname']."</td>";
			echo "<td>" . $row['partyhall_name']."</td>";
			echo "<td>" . $row['Reserve_Date']."</td>";
			echo "<td>" . $row['Reserve_Time']."</td>";
			echo "<td>" . $row['First_Name']."</td>";
			echo '<td><a href="delete-reservation.php?id=' . $row['ReservationID'] . '" class="btn btn-primary">Delete Reservation</a></td>';
			echo "</tr>";
			}
			mysql_free_result($partyhalls);
			mysql_close($link);
			?>
			</table>
		 </div>
	 </div>
</body>
</html>
