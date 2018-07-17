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

//retrive categories from the categories table
$categories=mysql_query("SELECT * FROM categories")
or die("There are no records to display ... \n" . mysql_error());

//retrieve quantities from the quantities table
$quantities=mysql_query("SELECT * FROM quantities")
or die("Something is wrong ... \n" . mysql_error());

//retrieve currencies from the currencies table (deleting)
$currencies=mysql_query("SELECT * FROM currencies")
or die("Something is wrong ... \n" . mysql_error());

//retrieve currencies from the currencies table (updating)
$currencies_1=mysql_query("SELECT * FROM currencies")
or die("Something is wrong ... \n" . mysql_error());

//retrieve polls from the ratings table
$ratings=mysql_query("SELECT * FROM ratings")
or die("Something is wrong ... \n" . mysql_error());

//retrieve timezones from the timezones table (deleting)
$timezones=mysql_query("SELECT * FROM timezones")
or die("Something is wrong ... \n" . mysql_error());

//retrieve timezones from the timezones table (updating)
$timezones_1=mysql_query("SELECT * FROM timezones")
or die("Something is wrong ... \n" . mysql_error());

//retrieve tables from the tables table
$tables=mysql_query("SELECT * FROM tables")
or die("Something is wrong ... \n" . mysql_error());

//retrieve partyhalls from the partyhalls table
$partyhalls=mysql_query("SELECT * FROM partyhalls")
or die("Something is wrong ... \n" . mysql_error());

//retrieve questions from the questions table
$questions=mysql_query("SELECT * FROM questions")
or die("Something is wrong ... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<title>Options</title>
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
		 <h2 id="subtitle">Operations Management</h2>
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
		<div class="row" style="background:lightblue; padding:10px 10px;">
      <table align="center" width="910">
      <CAPTION><h3 id="subtitle2">Manage Categories</h3> <br> </CAPTION>
      <tr>
      <form name="categoryForm" id="categoryForm" action="categories-exec.php" method="post" onsubmit="return categoriesValidate(this)">
      <td>
        <table width="250" border="0" cellpadding="2" cellspacing="0" align="center">
          <tr>
              <td>Category</td>
              <td><input type="text" name="name" class="textfield" /></td>
              <td><input type="submit" name="Insert" value="Add" /></td>
          </tr>
        </table>
      </td>
      </form>
      <td>
      <form name="categoryForm" id="categoryForm" action="delete-category.php" method="post" onsubmit="return categoriesValidate(this)">
        <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Category</td>
              <td><select name="category" id="category">
              <option value="select">- select category -
              <?php
              //loop through categories table rows
              while ($row=mysql_fetch_array($categories)){
              echo "<option value=$row[category_id]>$row[category_name]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Delete" value="Remove" /></td>
          </tr>
        </table>
      </form>
      </td>
      </tr>
      </table>
      <p>&nbsp;</p>

      <table align="center" width="910">
      <CAPTION><h3 id="subtitle2">Manage Quantities</h3> <br> </CAPTION>
      <tr>
      <form name="quantityForm" id="quantityForm" action="quantities-exec.php" method="post" onsubmit="return quantitiesValidate(this)">
      <td>
        <table width="250" border="0" cellpadding="2" cellspacing="0" align="center">
          <tr>
              <td>Quantity</td>
              <td><input type="text" name="name" class="textfield" /></td>
              <td><input type="submit" name="Insert" value="Add" /></td>
          </tr>
        </table>
      </td>
      </form>
      <td>
      <form name="quantityForm" id="quantityForm" action="delete-quantity.php" method="post" onsubmit="return quantitiesValidate(this)">
        <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Quantity</td>
              <td><select name="quantity" id="quantity">
              <option value="select">- select quantity -
              <?php
              //loop through quantities table rows
              while ($row=mysql_fetch_array($quantities)){
              echo "<option value=$row[quantity_id]>$row[quantity_value]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Delete" value="Remove" /></td>
          </tr>
        </table>
      </form>
      </td>
      </tr>
      </table>
      <p>&nbsp;</p>

      <table align="center" width="910">
      <CAPTION><h3 id="subtitle2"> Manage Currencies </h3> <br> </CAPTION>
      <tr>
      <td>
      <form name="currencyForm" id="currencyForm" action="currencies-exec.php" method="post" onsubmit="return currenciesValidate(this)">
        <table width="250" border="0" cellpadding="2" cellspacing="0" align="center">
          <tr>
              <td>Currency/Symbol</td>
              <td><input type="text" name="name" class="textfield" /></td>
              <td><input type="submit" name="Insert" value="Add" /></td>
          </tr>
        </table>
      </form>
      </td>
      <td>
      <form name="currencyForm" id="currencyForm" action="delete-currency.php" method="post" onsubmit="return currenciesValidate(this)">
        <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Currency/Symbol</td>
              <td><select name="currency" id="currency">
              <option value="select">- select currency -
              <?php
              //loop through currencies table rows
              while ($row=mysql_fetch_array($currencies)){
              echo "<option value=$row[currency_id]>$row[currency_symbol]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Delete" value="Remove" /></td>
          </tr>
        </table>
      </form>
      </td>
      <td>
      <form name="currencyForm" id="currencyForm" action="activate-currency.php" method="post" onsubmit="return currenciesValidate(this)">
        <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Currency/Symbol</td>
              <td><select name="currency" id="currency">
              <option value="select">- select a currency -
              <?php
              //loop through currencies table rows
              while ($row=mysql_fetch_array($currencies_1)){
              echo "<option value=$row[currency_id]>$row[currency_symbol]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Update" value="Activate" /></td>
          </tr>
        </table>
      </form>
      </td>
      </tr>
      </table>
      <p>&nbsp;</p>

      <table align="center" width="910">
      <CAPTION><h3 id="subtitle2">Manage Ratings</h3> <br> </CAPTION>
      <tr>
      <form name="ratingForm" id="ratingForm" action="ratings-exec.php" method="post" onsubmit="return ratingsValidate(this)">
      <td>
        <table width="300" border="0" cellpadding="2" cellspacing="0" align="center">
          <tr>
              <td>Rate Level</td>
              <td><input type="text" name="name" id="name" class="textfield" /></td>
              <td><input type="submit" name="Insert" value="Add" /></td>
          </tr>
        </table>
      </td>
      </form>
      <td>
      <form name="ratingForm" id="ratingForm" action="delete-rating.php" method="post" onsubmit="return ratingsValidate(this)">
        <table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Rate Level</td>
              <td><select name="rating" id="rating">
              <option value="select">- select level -
              <?php
              //loop through ratings table rows
              while ($row=mysql_fetch_array($ratings)){
              echo "<option value=$row[rate_id]>$row[rate_name]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Delete" value="Remove" /></td>
          </tr>
        </table>
      </form>
      </td>
      </tr>
      </table>
      <p>&nbsp;</p>

      <table align="center" width="910">
      <CAPTION><h3 id="subtitle2">Manage Timezones</h3> <br> </CAPTION>
      <tr>
      <td>
      <form name="timezoneForm" id="timezoneForm" action="timezone-exec.php" method="post" onsubmit="return timezonesValidate(this)">
        <table width="250" border="0" cellpadding="2" cellspacing="0" align="center">
          <tr>
              <td>Timezone</td>
              <td><input type="text" name="name" class="textfield" /></td>
              <td><input type="submit" name="Insert" value="Add" /></td>
          </tr>
        </table>
      </form>
      </td>
      <td>
      <form name="timezoneForm" id="timezoneForm" action="delete-timezone.php" method="post" onsubmit="return timezonesValidate(this)">
        <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Timezone</td>
              <td><select name="timezone" id="timezone">
              <option value="select">- select timezone -
              <?php
              //loop through timezones table rows
              while ($row=mysql_fetch_array($timezones)){
              echo "<option value=$row[timezone_id]>$row[timezone_reference]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Delete" value="Remove" /></td>
          </tr>
        </table>
      </form>
      </td>
      <td>
      <form name="timezoneForm" id="timezoneForm" action="activate-timezone.php" method="post" onsubmit="return timezonesValidate(this)">
        <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Timezone</td>
              <td><select name="timezone" id="timezone">
              <option value="select">- select timezone -
              <?php
              //loop through timezones table rows
              while ($row=mysql_fetch_array($timezones_1)){
              echo "<option value=$row[timezone_id]>$row[timezone_reference]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Update" value="Activate" /></td>
          </tr>
        </table>
      </form>
      </td>
      </tr>
      </table>
      <p>&nbsp;</p>

      <table align="center" width="910">
      <CAPTION><h3 id="subtitle2">Manage Tables</h3>  <br> </CAPTION>
      <tr>
      <form name="tableForm" id="tableForm" action="tables-exec.php" method="post" onsubmit="return tablesValidate(this)">
      <td>
        <table width="350" border="0" cellpadding="2" cellspacing="0" align="center">
          <tr>
              <td>Table Name/Number</td>
              <td><input type="text" name="name" class="textfield" /></td>
              <td><input type="submit" name="Insert" value="Add" /></td>
          </tr>
        </table>
      </td>
      </form>
      <td>
      <form name="tableForm" id="tableForm" action="delete-table.php" method="post" onsubmit="return tablesValidate(this)">
        <table width="350" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Table Name/Number</td>
              <td><select name="table" id="table">
              <option value="select">- select table -
              <?php
              //loop through tables table rows
              while ($row=mysql_fetch_array($tables)){
              echo "<option value=$row[table_id]>$row[table_name]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Delete" value="Remove" /></td>
          </tr>
        </table>
      </form>
      </td>
      </tr>
      </table>
      <p>&nbsp;</p>

      <table align="center" width="910">
      <CAPTION><h3 id="subtitle2">Manage Rooms</h3><br></CAPTION>
      <tr>
      <form name="partyhallForm" id="partyhallForm" action="partyhalls-exec.php" method="post" onsubmit="return partyhallsValidate(this)">
      <td>
        <table width="350" border="0" cellpadding="2" cellspacing="0" align="center">
          <tr>
              <td>Room Name/Number</td>
              <td><input type="text" name="name" class="textfield" /></td>
              <td><input type="submit" name="Insert" value="Add" /></td>
          </tr>
        </table>
      </td>
      </form>
      <td>
      <form name="partyhallForm" id="partyhallForm" action="delete-partyhall.php" method="post" onsubmit="return partyhallsValidate(this)">
        <table width="370" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Room Name/Number</td>
              <td><select name="partyhall" id="partyhall">
              <option value="select">- select Room -
              <?php
              //loop through partyhalls table rows
              while ($row=mysql_fetch_array($partyhalls)){
              echo "<option value=$row[partyhall_id]>$row[partyhall_name]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Delete" value="Remove" /></td>
          </tr>
        </table>
      </form>
      </td>
      </tr>
      </table>
      <p>&nbsp;</p>

      <table align="center" width="910">
      <CAPTION><h3 id="subtitle2">Manage Questions</h3><br></CAPTION>
      <tr>
      <form name="questionForm" id="questionForm" action="questions-exec.php" method="post" onsubmit="return questionsValidate(this)">
      <td>
        <table width="300" border="0" cellpadding="2" cellspacing="0" align="center">
          <tr>
              <td>Question</td>
              <td><input type="text" name="name" class="textfield" /></td>
              <td><input type="submit" name="Insert" value="Add" /></td>
          </tr>
        </table>
      </td>
      </form>
      <td>
      <form name="questionForm" id="questionForm" action="delete-question.php" method="post" onsubmit="return questionsValidate(this)">
        <table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
              <td>Question</td>
              <td><select name="question" id="question">
              <option value="select">- select question -
              <?php
              //loop through quantities table rows
              while ($row=mysql_fetch_array($questions)){
              echo "<option value=$row[question_id]>$row[question_text]";
              }
              ?>
              </select></td>
              <td><input type="submit" name="Delete" value="Remove" /></td>
          </tr>
        </table>
      </form>
      </td>
      </tr>
      </table>
      <p>&nbsp;</p>
      <br> <br>
    </div>
  </div>

</body>
</html>
