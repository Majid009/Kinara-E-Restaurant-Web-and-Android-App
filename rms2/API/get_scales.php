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

$scales_array = array();

//selecting all records from the ratings table. Return an error if there are no records in the table
$ratings=mysql_query("SELECT * FROM ratings");
$size = mysql_num_rows($ratings);
for($i=0 ; $i<$size ; $i++){
  array_push($scales_array,mysql_fetch_assoc($ratings));
}

$response->scales = $scales_array;
echo json_encode($response);

?>
