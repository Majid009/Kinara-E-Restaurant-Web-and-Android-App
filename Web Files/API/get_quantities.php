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

  $quantities=mysql_query("SELECT * FROM quantities");
  $rows = mysql_num_rows($quantities);

  for ($i=0; $i < $rows; $i++) {
     array_push($output,mysql_fetch_assoc($quantities));
  }

  $response->quantities = $output ;
  echo json_encode($response);

?>
