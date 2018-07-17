<?php
	session_start();
	require_once('config.php');

	//Array to store validation errors
	$errmsg_arr = array();

	//Validation error flag
	$errflag = false;

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

  if(isset($_POST['email']) && isset($_POST['password']))
	{
	//Sanitize the POST values
	  $email = clean($_POST['email']);
	  $password = clean($_POST['password']);

	//Create query
	$qry="SELECT * FROM staff WHERE email='$email' AND password='$password'";
	$result=mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			$boy = mysql_fetch_assoc($result);
			$_SESSION['SESS_DB_ID'] = $boy['StaffID'];
			$_SESSION['SESS_DB_FIRST_NAME'] = $boy['First_Name'];
			$_SESSION['SESS_DB_LAST_NAME'] = $boy['lastname'];
      $response = "200,".$_SESSION['SESS_DB_ID'].",".$_SESSION['SESS_DB__FIRST_NAME'].",".$_SESSION['SESS_DB_LAST_NAME'];
			echo $response;
			exit();
		}else {
			echo ("400");
			exit();
		}
	}else {
		die("Query failed");
	}
}
?>
