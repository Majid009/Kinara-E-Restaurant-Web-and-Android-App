<?php

//checking connection and connecting to a database
require_once('config.php');
//Connect to mysql server
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
    if(!$link) {
        die('Failed to connect to server: ' . mysql_error());
    }
    // Selecting database
    mysql_select_db(DB_DATABASE);

$foods_array = array();

//selecting all records from the food_details table. Return an error if there are no records in the table
$foods=mysql_query("SELECT * FROM food_details");
$size = mysql_num_rows($foods);
for($i=0 ; $i<$size ; $i++){
  array_push($foods_array,mysql_fetch_assoc($foods));
}
$response->foods = $foods_array;
echo json_encode($response);

?>
