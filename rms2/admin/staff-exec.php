<?php
	//Start session
	session_start();

	//Include database connection details
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

	//Sanitize the POST values
	$FirstName = clean($_POST['fName']);
	$LastName = clean($_POST['lName']);
	$StreetAddress = clean($_POST['sAddress']);
	$MobileNo = clean($_POST['mobile']);


	//Create INSERT query
	$qry = "INSERT INTO staff(First_name,lastname,Street_Address,Mobile_Tel) VALUES('$FirstName','$LastName','$StreetAddress','$MobileNo')";
	$result = @mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		echo "<html><script language='JavaScript'>alert('Staff information added successifully.')</script></html>";
		header("location: allocation.php");
		exit();
	}else {
		die("Adding staff information failed ... " . mysql_error());
	}
?>
