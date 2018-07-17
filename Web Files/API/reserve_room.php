<?php
	//Start session
	session_start();
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

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}

	//Sanitize the POST values
    $partyhall_id = 0;
    $table_id = 0;
    $partyhall_flag = 0;
    $table_flag = 0;

    if( isset($_POST['user_id']) && isset($_POST['room_id']) && isset($_POST['date']) && isset($_POST['time']))
	  {
				 $partyhall_id = clean($_POST['room_id']);
				 $q = "SELECT * FROM reservations_details WHERE partyhall_id = '$partyhall_id'";
         $res = mysql_query($q);
 	       if(mysql_num_rows($res) == 1){
					  echo "This Room is booked already !";
				 }
				 else{
					 $member_id = clean($_POST['user_id']);
					 $partyhall_flag = 1;
					 $date = clean($_POST['date']);
	 				 $time = clean($_POST['time']);
	 				 $flag = 0;
					 $staff = 0; // default value

					$qry = "INSERT INTO reservations_details(member_id,table_id,partyhall_id,Reserve_Date,Reserve_Time,staffID,table_flag,partyhall_flag,flag) VALUES('$member_id','$table_id','$partyhall_id','$date','$time','$staff','$table_flag','$partyhall_flag','$flag')";
 			    $result = mysql_query($qry);
					if($result){
						echo "Room reserverd successfully";
					}
					else{
						 echo "Reservation failed!";
					}
 			  }

		}
?>
