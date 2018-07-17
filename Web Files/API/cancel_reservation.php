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

$rooms_array  = array();

$reservation_id = $_POST['reservation_id'];
// delete the entry
$result = mysql_query("DELETE FROM reservations_details WHERE ReservationID='$reservation_id'")
or die("The reservation does not exist ... \n");

if($result){
  echo "Reservation deleted successfully";
}
?>
