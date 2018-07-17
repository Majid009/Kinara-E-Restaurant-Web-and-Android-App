<?php
session_start();
//checking connection and connecting to a database
require_once('config.php');
//Connect to mysql server
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    if(!$link) {
        die('Failed to connect to server: ' . mysql_error());
    }

    if(isset($_POST['staff_id']) && isset($_POST['latitude']) && isset($_POST['longitude'])){
      $staff_id = $_POST['staff_id'] ;
      $lat = $_POST['latitude'] ;
      $long = $_POST['longitude'] ;

          $sql = "UPDATE staff SET latitude='$lat' , longitude='$long' WHERE StaffID='$staff_id'";
          $result = mysqli_query($link ,$sql);
          if($result) echo "System is tracking you";
      }

?>
