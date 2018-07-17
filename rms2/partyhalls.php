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
<?php
    //retrieve partyhalls from the partyhalls table
    $partyhalls=mysql_query("SELECT * FROM partyhalls")
    or die("Something is wrong ... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>:Party Halls</title>
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
<body style="background:#f1f1f1 ;">
<?php require ('navbar.php'); ?>
<div class="container-fluid" id="inbox_wrapper">
  <div class="col-md-2" id="sidenav">
    <a href="member-profile.php"> &nbsp;&nbsp;<i class="fa fa-user"> </i> &nbsp;<?php echo $_SESSION['SESS_FIRST_NAME'];?> </a>
    <a href="member-index.php"> &nbsp;&nbsp;<i class="fa fa-home"> </i> &nbsp;Home </a>
    <a href="cart.php"> &nbsp;&nbsp;<i class="fa fa-shopping-cart"> </i> &nbsp;Cart <span class="badge"><?php echo $num_items;?></span> &nbsp;&nbsp; </a>
    <a href="inbox.php"> &nbsp;&nbsp;<i class="fa fa-envelope-open"> </i> &nbsp;Inbox <span class="badge"><?php echo $num_messages;?></span> &nbsp;&nbsp; </a>
    <a href="tables.php"> &nbsp;&nbsp;<i class="fa fa-star"> </i> &nbsp;Tables</a>
    <a href="partyhalls.php"> &nbsp;&nbsp;<i class="fa fa-circle"> </i> &nbsp;Rooms</a>
    <a href="ratings.php"> &nbsp;&nbsp;<i class="fa fa-line-chart"> </i> &nbsp;Rate Us</a>
    <a href="post_review.php"> &nbsp;&nbsp;<i class="fa fa-star"> </i> &nbsp;Post Review</a>
    <a href="logout.php"> &nbsp;&nbsp;<i class="fa fa-lock"> </i> &nbsp;Logout</a>
  </div>
  <div class="col-md-10" id="inbox_main">
    <h1>Reserve Room(S)</h1>
    <form name="partyhallForm" id="partyhallForm" method="post" action="reserve-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return partyhallValidate(this)">
        <table align="center" width="400">
            <CAPTION><h2 style="text-align: center;">Reserve A Room</h2></CAPTION>
            <tr>
                <td><b>Room Number:</b></td>
                <td>
                <select name="partyhall" id="partyhall" class="form-control">
                <option value="select">- select Room -</option>
                <?php
                //loop through partyhalls table rows
                while ($row=mysql_fetch_array($partyhalls)){
                echo "<option value=$row[partyhall_id]>$row[partyhall_name]</option>";
                }
                ?>
              </select> <br>
                </td>
            </tr>
            <tr>
                <td><b>Date:</b></td><td><input type="date" placeholder="yyyy-mm-dd" name="date" id="date" class="form-control"/> <br> </td></tr>
            <tr>
                <td><b>Time:</b></td><td><input type="time" name="time" id="time" class="form-control"/> <br>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="Reserve" class="form-control btn btn-primary"></td>
            </tr>
        </table>
    </form>
  </div>
</div>
</body>
</html>
