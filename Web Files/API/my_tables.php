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

$tables_array  = array();

$member_id = $_POST['user_id'];

// retrieving reservations details , Tables
$result_tables = mysql_query("SELECT reservations_details.ReservationID,reservations_details.Reserve_Date,reservations_details.Reserve_Time ,tables.table_name FROM reservations_details,tables WHERE reservations_details.member_id=$member_id AND reservations_details.table_flag=1 AND tables.table_id=reservations_details.table_id");

 $num = mysql_num_rows($result_tables);
 for($i=0 ; $i<$num ; $i++){
   array_push($tables_array,mysql_fetch_assoc($result_tables));
 }

 $response->my_tables = $tables_array ;
 echo json_encode($response);

?>
