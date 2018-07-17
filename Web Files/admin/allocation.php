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

    //selecting all records from the staff table. Return an error if there are no records in the tables
    $staff=mysql_query("SELECT * FROM staff")
    or die("There are no records to display ... \n" . mysql_error());
?>
<?php
    //get order ids from the orders_details table based on flag=0
    $flag_0 = 0;
    $orders=mysql_query("SELECT * FROM orders_details WHERE flag='$flag_0'")
    or die("There are no records to display ... \n" . mysql_error());
?>
<?php
    //get reservation ids from the reservations_details table based on flag=0
    $flag_0 = 0;
    $reservations=mysql_query("SELECT * FROM reservations_details WHERE flag='$flag_0'")
    or die("There are no records to display ... \n" . mysql_error());
?>
<?php
    //selecting all records from the staff table. Return an error if there are no records in the tables
    $staff_1=mysql_query("SELECT * FROM staff")
    or die("There are no records to display ... \n" . mysql_error());
?>
<?php
    //selecting all records from the staff table. Return an error if there are no records in the tables
    $staff_2=mysql_query("SELECT * FROM staff")
    or die("There are no records to display ... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<title>Staff</title>
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
		 <h2 id="subtitle">Staff Allocation</h2>
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
	<div class="row" style="background:lightblue; padding:20px">
		<table class="table table-responsive table-hover">
		<h3 style="text-align: center;">Staff List</h3>
		<tr class="danger">
		<th>Staff ID</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Street Address</th>
		<th>Action(s)</th>
		</tr>

		<?php
		//loop through all table rows
		while ($row=mysql_fetch_array($staff)){
		echo "<tr>";
		echo "<td>" . $row['StaffID']."</td>";
		echo "<td>" . $row['First_Name']."</td>";
		echo "<td>" . $row['lastname']."</td>";
		echo "<td>" . $row['Street_Address']."</td>";
		echo '<td><a href="delete-staff.php?id=' . $row['StaffID'] . '">Remove Staff</a></td>';
		echo "</tr>";
		}
		mysql_free_result($staff);
		mysql_close($link);
		?>
		</table>
		<hr>
		<table align="center">
		<tr>
		<form id="ordersAllocationForm" name="ordersAllocationForm" method="post" action="orders-allocation.php" onsubmit="return ordersAllocationValidate(this)">
		<td>
		  <table width="450" border="0" cellpadding="2" cellspacing="0">
		  <CAPTION><h3>ORDERS ALLOCATION</h3></CAPTION>
			<tr>
				<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Required fields</td>
			</tr>
		    <tr>
		      <th width="124">Order ID</th>
		      <td width="168"><font color="#FF0000">* </font><select name="orderid" id="orderid">
		        <option value="select">- select one option -
		        <?php
		        //loop through orders_details table rows
		        while ($row=mysql_fetch_array($orders)){
		        echo "<option value=$row[order_id]>$row[order_id]";
		        }
		        ?>
		        </select></td>
		    </tr>
		    <tr>
		      <th>Staff ID</th>
		      <td><font color="#FF0000">* </font><select name="staffid" id="staffid">
		        <option value="select">- select one option -
		        <?php
		        //loop through staff table rows
		        while ($row=mysql_fetch_array($staff_1)){
		        echo "<option value=$row[StaffID]>$row[StaffID]";
		        }
		        ?>
					</select> <br> </td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td><input type="submit" name="Submit" value="Allocate Staff" /></td>
		    </tr>
		  </table>
		</td>
		</form>
		<td>
		<form id="reservationsAllocationForm" name="reservationsAllocationForm" method="post" action="reservations-allocation.php" onsubmit="return reservationsAllocationValidate(this)">
		  <table width="400" border="0" align="center" cellpadding="2" cellspacing="0">
		  <CAPTION><h3>RESERVATIONS ALLOCATION</h3></CAPTION>
			<tr>
				<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Required fields</td>
			</tr>
		    <tr>
		      <th>Reservation ID </th>
		      <td><font color="#FF0000">* </font><select name="reservationid" id="reservationid">
		        <option value="select">- select one option -
		        <?php
		        //loop through reservations_details table rows
		        while ($row=mysql_fetch_array($reservations)){
		        echo "<option value=$row[ReservationID]>$row[ReservationID]";
		        }
		        ?>
		        </select></td>
		    </tr>
			<tr>
		      <th>Staff ID </th>
		      <td><font color="#FF0000">* </font><select name="staffid" id="staffid">
		        <option value="select">- select one option -
		        <?php
		        //loop through staff table rows
		        while ($row=mysql_fetch_array($staff_2)){
		        echo "<option value=$row[StaffID]>$row[StaffID]";
		        }
		        ?>
		        </select></td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td><input type="submit" name="Submit" value="Allocate Staff" /></td>
		    </tr>
		  </table>
		</td>
		</form>
		</tr>
		</table>
		<p>&nbsp;</p>
		<hr>
	 </div>
</div>
</body>
</html>
