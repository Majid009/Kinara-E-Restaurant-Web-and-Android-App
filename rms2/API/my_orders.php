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

$member_id = $_POST['user_id'];

$orders_array = array();
$orders=mysql_query("SELECT * FROM orders_details,cart_details,food_details,categories,quantities,members WHERE members.member_id='$member_id' AND orders_details.member_id='$member_id' AND orders_details.cart_id=cart_details.cart_id AND cart_details.food_id=food_details.food_id AND food_details.food_category=categories.category_id AND cart_details.quantity_id=quantities.quantity_id")
or die("There are no records to display ... \n" . mysql_error());

//$orders = mysql_query("select * from orders_details,cart_details where orders_details.member_id='$member_id' AND orders_details.cart_id=cart_details.cart_id");

$num = mysql_num_rows($orders);
for($i=0 ; $i<$num ; $i++){
  array_push($orders_array,mysql_fetch_assoc($orders));
}

$response->orders = $orders_array ;
echo json_encode($response);

?>
