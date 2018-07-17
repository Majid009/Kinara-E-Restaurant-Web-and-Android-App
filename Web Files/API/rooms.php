<?php require_once('config.php');

 $output = array();
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

  $rooms=mysql_query("SELECT * FROM partyhalls");
  $rows = mysql_num_rows($rooms);

  for ($i=0; $i < $rows; $i++) {
    //$data=mysql_fetch_assoc($tables);
     array_push($output,mysql_fetch_assoc($rooms));
    //echo json_encode(mysql_fetch_assoc($tables));
    //echo $data['table_id']."  ".$data['table_name']."<br>";
  }

  $response->rooms = $output ;
  echo json_encode($response);

 //  while ($data=mysql_fetch_array($tables)) {
 //   echo $data['table_id']."  ".$data['table_name']."<br>";
 // }
  ?>
