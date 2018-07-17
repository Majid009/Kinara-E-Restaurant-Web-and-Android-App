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
    $result=mysql_query("SELECT * FROM food_details,categories WHERE food_details.food_category=categories.category_id")
    or die("There are no records to display ... \n" . mysql_error());
?>
<?php
    //retrive categories from the categories table
    $categories=mysql_query("SELECT * FROM categories")
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Foods</title>
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
		 <h2 id="subtitle">Foods Management</h2>
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
		<div class="row" style="background:lightblue; padding:10px; padding-bottom: 100px;">
      <div class="col-md-4">
        <h3 style="text-align: center;">Add A New Food</h3> <hr>
        <form name="foodsForm" id="foodsForm" action="foods-exec.php" method="post" enctype="multipart/form-data" onsubmit="return foodsValidate(this)">
            <input type="text" name="name" id="name" class="form-control" placeholder="Name"/> <br>
            <textarea name="description" id="description" class="form-control" rows="2" cols="15" placeholder="Description"></textarea> <br>
            <input type="text" name="price" id="price" class="form-control" placeholder="Price"/> <br>
            <b>Category:</b> <select name="category" id="category" class="form-control">
            <option value="select">- select one option -
            <?php
            //loop through categories table rows
            while ($row=mysql_fetch_array($categories)){
            echo "<option value=$row[category_id]>$row[category_name]";
            }
            ?>
          </select><br>
            <b>Photo:</b> <input type="file" name="photo" id="photo" class="form-control"/> <br>
            <input type="submit" name="Submit" value="Add" class="form-control btn btn-primary"/> <br>
        </form>
      </div>
      <div class="col-md-8" style="border-left: 2px solid purple; padding-bottom: 100px;">
        <h3 style="text-align: center;">Available Foods</h3> <hr>
        <table class="table table-responsive table-condensed table-hover">
        <tr class="danger">
        <th>Food Photo</th>
        <th>Food Name</th>
        <th>Food Description</th>
        <th>Food Price</th>
        <th>Food Category</th>
        <th>Action(s)</th>
        </tr>

        <?php
        //loop through all table rows
        $symbol=mysql_fetch_assoc($currencies); //gets active currency
        while ($row=mysql_fetch_array($result)){
        echo "<tr>";
        echo '<td><img src=../images/'. $row['food_photo']. ' width="80" height="70"></td>';
        echo "<td>" . $row['food_name']."</td>";
        echo "<td>" . $row['food_description']."</td>";
        echo "<td>" . $symbol['currency_symbol']. "" . $row['food_price']."</td>";
        echo "<td>" . $row['category_name']."</td>";
        echo '<td><a href="delete-food.php?id=' . $row['food_id'] . '">Remove Food</a></td>';
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
