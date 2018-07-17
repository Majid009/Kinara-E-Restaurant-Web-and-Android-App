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
    if( isset($_POST['staff_id']) ){
      $staff_id = $_POST['staff_id'] ;

          $sql = "select latitude , longitude from staff WHERE StaffID='$staff_id'";
          $result = mysql_query($sql);
          if($result) {
            $latLang = mysql_fetch_array($result);
            echo $latLang['latitude'].",".$latLang['longitude'];
          }
      }

?>
