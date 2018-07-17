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

$staff_id = $_POST['staff_id'];

$orders_array = array();
$orders=mysql_query("SELECT * FROM orders_details , billing_details , cart_details , food_details WHERE orders_details.staffID='$staff_id' AND billing_details.member_id=orders_details.member_id AND orders_details.cart_id=cart_details.cart_id AND cart_details.food_id=food_details.food_id")
or die("There are no records to display ... \n" . mysql_error());

//$orders = mysql_query("select * from orders_details,cart_details where orders_details.member_id='$member_id' AND orders_details.cart_id=cart_details.cart_id");

$num = mysql_num_rows($orders);
for($i=0 ; $i<$num ; $i++){
  array_push($orders_array,mysql_fetch_assoc($orders));
}

$response->orders = $orders_array ;
echo json_encode($response);
echo $num;

?>
