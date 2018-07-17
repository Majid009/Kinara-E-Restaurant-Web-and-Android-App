<?php
	//Start session
	session_start();

	//Include database connection details
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
	//checks whether submit is set
	if( isset($_POST['user_id']) && isset($_POST['food_id']) && isset($_POST['scale_id']) )
	{
	      $member_id = clean($_POST['user_id']);
        $food_id = clean($_POST['food_id']);
        $scale_id = clean($_POST['scale_id']);

        //check whether there is duplication in the polls_details table
        $check = mysql_query("SELECT * FROM polls_details WHERE member_id='$member_id' AND food_id='$food_id'");

        if(mysql_num_rows($check)>0){
            echo "You already rated this Product";
        }
        else{
	        //Create INSERT query
	        $qry = "INSERT INTO polls_details(member_id,food_id,rate_id) VALUES('$member_id','$food_id','$scale_id')";
	        mysql_query($qry);
            if($qry){
	            echo "Rating Saved successfully";
            }
            else{
                echo "Rating Failed";
            }
        }
	}
?>
