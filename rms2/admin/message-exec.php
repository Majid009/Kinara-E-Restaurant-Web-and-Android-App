<?php
	//checking connection and connecting to a database
	require_once('connection/config.php');
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

    //retrive a timezone from the timezones table
    //define a default value for flag_1
    $flag_1 = 1;
    $timezones=mysql_query("SELECT * FROM timezones WHERE flag='$flag_1'")
    or die("Something is wrong. ".mysql_error());

    $row=mysql_fetch_assoc($timezones); //gets retrieved row

    $active_reference = $row['timezone_reference']; //gets active timezone

    date_default_timezone_set($active_reference); //sets the default timezone for use

    $current_date = date("Y-m-d"); //gets the current date

    $current_time = date("H:i:s"); //gets the current time

	//Sanitize the POST values
    $new_subject = clean($_POST['subject']);
	$new_message = clean($_POST['txtmessage']);

    $from = "admin"; //sets default to the administrator (it can be changed if PM will be implemented in the future)

     // update the entry
     $result = mysql_query("INSERT INTO messages(message_from,message_date,message_time,message_subject,message_text) VALUES('$from','$current_date','$current_time','$new_subject','$new_message')")
     or die("Message sending failed ..." . mysql_error());

     if($result){
         // redirect back to the messages page
         header("Location: messages.php");
         exit();
     }
     else
     // if not sent, give an error
     {
        die("Message sending failed ..." . mysql_error());
     }
?>
