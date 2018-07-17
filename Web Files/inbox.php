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
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>: Inbox</title>

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
        <h1> Messages</h1>
        <table class="table table-stripped table-bordered table-condensed table-hover" style="text-align:center; background:white;">
         <CAPTION><center><h2> Inbox </h2></center></CAPTION>
        <tr style="text-align:center;" class="danger">
        <th>From</th>
        <th>Date Received</th>
        <th>Time Received</th>
        <th>Subject</th>
        <th>Text</th>
        </tr>

        <?php
        //loop through all table rows
        while ($row=mysql_fetch_array($messages)){
        echo "<tr>";
        echo "<td>" . $row['message_from']."</td>";
        echo "<td>" . $row['message_date']."</td>";
        echo "<td>" . $row['message_time']."</td>";
        echo "<td>" . $row['message_subject']."</td>";
        echo "<td width='350' align='left'>" . $row['message_text']."</td>";
        echo "</tr>";
        }
        mysql_free_result($messages);
        mysql_close($link);
        ?>
        </table>
        <br>
        <?php include 'footer.php'; ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
