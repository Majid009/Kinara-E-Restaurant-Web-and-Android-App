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
//selecting all records from the messages table. Return an error if there is a problem
$result=mysql_query("SELECT * FROM messages")
or die("There are no records to display ... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Messages</title>
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
		 <h2 id="subtitle">Messages Management</h2>
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
		<div class="col-md-3">
      <h3 style="text-align: center;"> Send A Message </h3> <hr>
			<form id="messageForm" name="messageForm" method="post" action="message-exec.php" onsubmit="return messageValidate(this)">
			  <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject"/> <br>
			  <textarea name="txtmessage" class="form-control" rows="5" placeholder="Write You Message"></textarea> <br>
			  <input type="submit" name="Submit" value="Send Message" class="form-control btn btn-primary"/> <br> <br>
				  <input type="reset" name="Reset" value="Clear Field" class="form-control btn btn-primary"/> <br> <br>
			</form>
		</div>

		<div class="col-md-9">
      <h3 style="text-align: center;"> Sent Messages </h3> <hr>
			<table class="table table-responsive table-condensed table-hover">
			<tr class="danger">
			<th>Message ID</th>
			<th>Date Sent</th>
			<th>Time Sent</th>
			<th>Message Subject</th>
			<th>Message Text</th>
			<th>Action(s)</th>
			</tr>

			<?php
			//loop through all table rows
			while ($row=mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['message_id']."</td>";
			echo "<td>" . $row['message_date']."</td>";
			echo "<td>" . $row['message_time']."</td>";
			echo "<td>" . $row['message_subject']."</td>";
			echo "<td width='300' align='left'>" . $row['message_text']."</td>";
			echo '<td><a href="delete-message.php?id=' . $row['message_id'] . '">Remove Message</a></td>';
			echo "</tr>";
			}
			mysql_free_result($result);
			mysql_close($link);
			?>
			</table>
		</div>
	</div>
</div>
</body>
</html>
