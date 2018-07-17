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

$member_id = $_POST['user_id'];


 // retrieving reservations details , Rooms
 $result_partyhalls = mysql_query("SELECT reservations_details.ReservationID,reservations_details.Reserve_Date,reservations_details.Reserve_Time ,partyhalls.partyhall_name FROM reservations_details,partyhalls WHERE reservations_details.member_id=$member_id AND reservations_details.partyhall_flag=1 AND partyhalls.partyhall_id=reservations_details.partyhall_id");

 $num = mysql_num_rows($result_partyhalls);
 for($i=0 ; $i<$num ; $i++){
   array_push($rooms_array,mysql_fetch_assoc($result_partyhalls));
 }

 $response->my_rooms = $rooms_array ;
 echo json_encode($response);

?>
