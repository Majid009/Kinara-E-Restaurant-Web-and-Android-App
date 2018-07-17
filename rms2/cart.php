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

//define default values for flag_0
$flag_0 = 0;

//get member_id from session
$member_id = $_SESSION['SESS_MEMBER_ID'];

//selecting particular records from the food_details and cart_details tables. Return an error if there are no records in the tables
$result=mysql_query("SELECT food_name,food_description,food_price,food_photo,cart_id,quantity_value,total,flag,category_name FROM food_details,cart_details,categories,quantities WHERE cart_details.member_id='$member_id' AND cart_details.flag='$flag_0' AND cart_details.food_id=food_details.food_id AND food_details.food_category=categories.category_id AND cart_details.quantity_id=quantities.quantity_id")
or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");
?>
<?php
    if(isset($_POST['Submit'])){
        //Function to sanitize values received from the form. Prevents SQL injection
        function clean($str) {
            $str = @trim($str);
            if(get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            return mysql_real_escape_string($str);
        }
        //get category id
        $id = clean($_POST['category']);

        //selecting all records from the food_details table based on category id. Return an error if there are no records in the table
        $result=mysql_query("SELECT * FROM food_details WHERE food_category='$id'")
        or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");
    }
?>
<?php
    //retrieving quantities from the quantities table
    $quantities=mysql_query("SELECT * FROM quantities")
    or die("Something is wrong ... \n" . mysql_error());
?>
<?php
    //retrieving cart ids from the cart_details table
    //define a default value for flag_0
    $flag_0 = 0;
    $items=mysql_query("SELECT * FROM cart_details WHERE member_id='$member_id' AND flag='$flag_0'")
    or die("Something is wrong ... \n" . mysql_error());
?>
<?php
    //retrive a currency from the currencies table
    //define a default value for flag_1
    $flag_1 = 1;
    $currencies=mysql_query("SELECT * FROM currencies WHERE flag='$flag_1'")
    or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");
?>
<?php // calculation of tatal bill
 $total_bill=mysql_query("SELECT SUM(total) as total_price FROM cart_details WHERE member_id=$member_id AND flag=0");
 $row_x = mysql_fetch_array($total_bill);
 $total_bill = $row_x['total_price'];
 ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo APP_NAME ?>:Shopping Cart</title>
<script type="text/javascript" src="swf/swfobject.js"></script>
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
       <h1> My Shopping Cart </h1>
    <center>   <h3><a class="btn btn-danger" style="font-size:20px;border-radius:0px; padding:10px 30px;" href="foodzone.php"> Continue Shopping </a></h3> </center>
       <form name="quantityForm" id="quantityForm" method="post" action="update-quantity.php" onsubmit="return updateQuantity(this)">
            <table class="table table-stripped table-bordered table-condensed table-hover" style="text-align:center; background:white;">
                <tr>
                <td style="background:#c90128;"> <p style="font-size:20px;color:white;"> Change Item Quantity </p> </td>
                   <td><b>Item ID:</b> <select name="item" id="item">
                       <option value="select">- select -
                       <?php
                       //loop through cart_details table rows
                       while ($row=mysql_fetch_array($items)){
                       echo "<option value=$row[cart_id]>$row[cart_id]";
                       }
                       ?>
                       </select>
                   </td>

                   <td><b>Quantity:</b> <select name="quantity" id="quantity">
                       <option value="select">- select -
                       <?php
                       //loop through quantities table rows
                       while ($row=mysql_fetch_assoc($quantities)){
                       echo "<option value=$row[quantity_id]>$row[quantity_value]";
                       }
                       ?>
                     </select>
                   </td>
                   <td><input class="btn btn-danger" style="border-radius:0px;" type="submit" name="Submit" value="Change Quantity" /></td>
                </tr>
            </table>
       </form>
       <table class="table table-stripped  table-condensed table-hover" style=" background:white;">
        <tr class="danger">
            <th>Item ID</th>
            <th>Food Photo</th>
            <th>Food Name</th>
            <th>Food Category</th>
            <th>Food Price</th>
            <th>Quantity</th>
            <th>Total Cost</th>
            <th>Action(s)</th>
        </tr>

        <?php
        $data_for_Bill = "";
            //loop through all table rows
            $symbol=mysql_fetch_assoc($currencies); //gets active currency
            while ($row=mysql_fetch_array($result)){
                echo "<tr>";
                $data_for_Bill .= "<tr>";

                echo "<td>" . $row['cart_id']."</td>";
                echo '<td><a href=images/'. $row['food_photo']. ' alt="click to view full image" target="_blank"><img src=images/'. $row['food_photo']. ' width="80" height="70"></a></td>';

                echo "<td>" . $row['food_name']."</td>";
                $data_for_Bill .="<td>" . $row['food_name']."</td>";

                echo "<td>" . $row['category_name']."</td>";

                echo "<td>" . $symbol['currency_symbol']. " " . $row['food_price']."</td>";
                $data_for_Bill .= "<td>" . $symbol['currency_symbol']. " " . $row['food_price']."</td>";

                echo "<td>" . $row['quantity_value']."</td>";
                $data_for_Bill .= "<td>" . $row['quantity_value']."</td>";

                echo "<td>" . $symbol['currency_symbol']. " " . $row['total']."</td>";
                  $data_for_Bill .= "<td>" . $symbol['currency_symbol']. " " . $row['total']."</td>";

            echo '<td><a class="btn btn-danger" style="border-radius:0px;" href="order-exec.php?id=' . $row['cart_id'] . '">Place Order</a></td>';
            echo "</tr>";
            $data_for_Bill .= "</tr>";
            }
            mysql_free_result($result);
            mysql_close($link);

            $_SESSION['$data_for_Bill'] = $data_for_Bill ;
        ?>
      </table>
       <h3 id="bill_heading">  <?php echo "Total: $total_bill PKR"; ?> </h3>

       <!--------------------PayPal Payment Code------------------->
       <?php
         //Set useful variables for paypal form
         $paypalURL = "https://www.paypal.com/cgi-bin/webscr"; //Test PayPal API URL
         $paypalID = 'majidmehmood455@gmail.com'; //Business Email
       ?>

       <form action="<?php echo $paypalURL; ?>" method="post">
        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo $paypalID; ?>">

        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">

        <!-- Specify details about the item that buyers will purchase. -->
        <input type="hidden" name="item_name" value="Payment">
        <!-- <input type="hidden" name="item_number" value="<?php echo $row['id']; ?>"> -->
        <input type="hidden" name="amount" value="<?php echo $total_bill; ?>">
        <input type="hidden" name="currency_code" value="PKR">

        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost/pp/cancel.php'>
        <input type='hidden' name='return' value='http://localhost/pp/success.php'>

        <!-- Display the payment button. -->
        <input id="PayPal_btn" type="image" name="submit" border="0"
        src="Assests/images/ppb.png" alt="PayPal - The safer, easier way to pay online">
        <img alt="" border="0" width="1" height="1" src="Assests/images/ppb.png" >
    </form>

       <!--------------------PayPal Payment Code------------------->
      <br>
      <a  id="bill_link" href="generate_bill.php" class="btn btn-primary"> Generate Bill </a>


      <br> <br> <br>
      <?php include 'footer.php'; ?>
     </div>
   </div>
 </div>
</body>
</html>
