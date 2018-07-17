<?php
    //Start session
    session_start();

    require_once('auth.php');

    //Include database connection details
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

    //Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysql_real_escape_string($str);
    }

    if(isset($_POST['quantity']) && isset($_POST['item']))
        {
            //get quantity_id
            $quantity_id = clean($_POST['quantity']);

            //get member_id from session
            $member_id = $_SESSION['SESS_MEMBER_ID'];

            //get cart_id
            $cart_id = clean($_POST['item']);
            //$cart_id = 5;

            //get the quantity value based on quantity_id
            $qry_select=mysql_query("SELECT * FROM quantities WHERE quantity_id='$quantity_id'")
            or die("The system is experiencing technical issues. Please try again after some few minutes.");

            //storing the quantity_value into a variable
            $row=mysql_fetch_array($qry_select);
            $quantity_value=$row['quantity_value'];

            //get the price of a food based on cart_details and food_details tables
            $result=mysql_query("SELECT * FROM food_details,cart_details WHERE cart_details.member_id='$member_id' AND cart_details.flag='$flag_0' AND cart_details.food_id=food_details.food_id AND cart_details.cart_id='$cart_id'") or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");

            //storing the value of food price into a variable
            $row=mysql_fetch_array($result);
            $food_price=$row['food_price'];

            //perform a simple calculation to get a total value of a food based on quantity_value and food_price
            $total = $quantity_value * $food_price;

            //Create UPDATE query (updates total and quantity_id in the cart based on cart_id and member_id)
            $qry_update = "UPDATE cart_details SET quantity_id='$quantity_id', total='$total' WHERE cart_id='$cart_id' AND member_id='$member_id'";
            mysql_query($qry_update);

            if($qry_update){
                header("location: cart.php");
            }
            else{
                //Do nothing
            }

        }else {
            die("Something went wrong! Our technical team are working on solving the problem. Please try again after few minutes.");
        }
?>
