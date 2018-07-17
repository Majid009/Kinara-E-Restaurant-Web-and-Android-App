<?php
//checking connection and connecting to a database
require_once('config.php');
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


$flag_0 = 0;  //define default values for flag_0

if(isset($_POST['user_id']) ){

	$member_id = $_POST['user_id'];

	//selecting particular records from the food_details and cart_details tables. Return an error if there are no records in the tables
	$result=mysql_query("SELECT food_name,food_description,food_price,food_photo,cart_id,quantity_value,total,flag,category_name FROM food_details,cart_details,categories,quantities WHERE cart_details.member_id='$member_id' AND cart_details.flag='$flag_0' AND cart_details.food_id=food_details.food_id AND food_details.food_category=categories.category_id AND cart_details.quantity_id=quantities.quantity_id")
	or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");

	    //retrieving quantities from the quantities table
	    $quantities=mysql_query("SELECT * FROM quantities");


	    //retrieving cart ids from the cart_details table
	    //define a default value for flag_0
	    $flag_0 = 0;
	    $items=mysql_query("SELECT * FROM cart_details WHERE member_id='$member_id' AND flag='$flag_0'");


	    //retrive a currency from the currencies table
	    //define a default value for flag_1
	    $flag_1 = 1;
	    $currencies=mysql_query("SELECT * FROM currencies WHERE flag='$flag_1'");

	 // calculation of tatal bill
	 $total_bill=mysql_query("SELECT SUM(total) as total_price FROM cart_details WHERE member_id=$member_id AND flag=0");
	 $row_x = mysql_fetch_array($total_bill);
	 $total_bill = $row_x['total_price'];

	 $symbol=mysql_fetch_assoc($currencies);  //gets active currency

	 $output = array();

	 $size = mysql_num_rows($result);
	 for ($i=0; $i < $size ; $i++) {
	 	array_push($output,mysql_fetch_assoc($result));
	 }

	 $response->cart_items = $output ;
	 $response->total_bill = $total_bill;
	 echo json_encode($response);
}

?>
