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

//selecting all records from the food_details table. Return an error if there are no records in the table
$foods=mysql_query("SELECT * FROM food_details")
or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");

//selecting all records from the ratings table. Return an error if there are no records in the table
$ratings=mysql_query("SELECT * FROM ratings")
or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");
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
<title><?php echo APP_NAME ?>:Rating</title>
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
<body style="background-color: #f1f1f1;">
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
        <a href="logout.php"> &nbsp;&nbsp;<i class="fa fa-lock"> </i> &nbsp;Logout</a>
      </div>
  <div class="col-md-10" id="inbox_main">
    <h1>Rate Us</h1>
    <p style="font-size: 18px;">
      Please rate us as your ratings are very value able for us. Rate us according to our service. It will help us
     to improve our services and quality.
    </p>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <h2 style="text-align:center;">Rate Our Food</h2> <br>
        <form name="ratingForm" id="ratingForm" method="post" action="ratings-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return ratingValidate(this)" style="text-align:center;">
                  <select name="food" id="food" class="form-control">
                    <option value="select"> Select Food
                    <?php
                    //loop through food_details table rows
                    while ($row=mysql_fetch_array($foods)){
                    echo "<option value=$row[food_id]>$row[food_name]";
                    }
                    ?>
                    </select>
                    <br> <br>
                    <select name="scale" id="scale" class="form-control">
                    <option value="select"> Select Scale
                    <?php
                    //loop through ratings table rows
                    while ($row=mysql_fetch_array($ratings)){
                    echo "<option value=$row[rate_id]>$row[rate_name]";
                    }
                    ?>
                  </select>  <br> <br>
                  <input type="submit" name="Submit" value="Rate" class="form-control btn btn-primary"/>
      </form>
      </div>
    </div>
    <br><img src="Assests/images/rating.jpg" alt="" style="width:350px; height:200px; display:block;margin:auto;">
   <?php require('footer.php') ?>
  </div>
</div>
</div>
</body>
</html>
