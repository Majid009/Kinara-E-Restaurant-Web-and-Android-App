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
$result=mysql_query("SELECT * FROM specials")
or die("There are no records to display ... \n" . mysql_error());
?>
<?php
    //retrive a currency from the currencies table
    //define a default value for flag_1
    $flag_1 = 1;
    $currencies=mysql_query("SELECT * FROM currencies WHERE flag='$flag_1'")
    or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo APP_NAME; ?>:Specials</title>
<!--  Including Boostrap and JQuery Files   -->
   <link rel="stylesheet"  href="Assests/css/bootstrap.css">
   <link rel="stylesheet"  href="Assests/css/font-awesome.min.css">
   <script src="Assests/js/bootstrap.js"> </script>
   <script src="Assests/js/jquery.js"> </script>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!---------------------------------------------->
<link href="stylesheets/user_styles.css"  rel="stylesheet" type="text/css">
<script language="JavaScript" src="validation/user.js"> </script>

</head>
<body>
<?php include 'navbar.php'; ?>
  <div class="container" style="margin-top: 50px;">
  	<h1> Special Deals </h1> <hr>
		<p style="font-size: 18px;"> <i class="fa fa-bullhorn fa-2x"></i> Check out our special deals below. These are for a limited time only. Make your decision now.</p>
    <h3><i class="fa fa-book"></i> In order to create your order, please go to Food Zone and choose Specials under categories list.</h3>

 <table class="table table-responsive" style="text-align:center;">
    <CAPTION> <h3>Special Deals</h3> </CAPTION>
        <tr class="danger">
                <th> <center>Promo Photo </center> </th>
                <th> <center>Promo Name </center> </th>
                <th> <center>Promo Description </center> </th>
                <th> <center>Sart Date </center> </th>
                <th> <center>End Date </center> </th>
                <th> <center>Promo Price </center> </th>
        </tr>
        <?php
                $symbol=mysql_fetch_assoc($currencies); //gets active currency
                while ($row=mysql_fetch_assoc($result)){
                    echo "<tr>";
                    echo '<td><a href=images/'. $row['special_photo']. ' alt="click to view full image" target="_blank"><img src=images/'. $row['special_photo']. ' width="80" height="70"></a></td>';
                    echo "<td>" . $row['special_name']."</td>";
                    echo "<td width='250' align='left'>" . $row['special_description']."</td>";
                    echo "<td>" . $row['special_start_date']."</td>";
                    echo "<td>" . $row['special_end_date']."</td>";
                    echo "<td>" . $symbol['currency_symbol']. " " . $row['special_price']."</td>";
                    echo "</td>";
                    echo "</tr>";
                    }
            mysql_free_result($result);
            mysql_close($link);
?>
</table>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
