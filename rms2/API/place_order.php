<?php

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

    $member_id = $_POST['user_id'] ;  // user id
    $id = $_POST['cart_id'] ;  // this is cart_id

    //checks whether the member has a billing address setup
    //get the billing_id from the billing_details table based on the member_id
    $qry_select=mysql_query("SELECT * FROM billing_details WHERE member_id='$member_id'")
    or die("The system is experiencing technical issues.\n Our team is working on it.\nPlease try again after some few minutes.");

       if(mysql_num_rows($qry_select)>0 && isset($id) ){
             $flag_0 = 0;
             $flag_1 = 1;

            //retrive a timezone from the timezones table
            $timezones=mysql_query("SELECT * FROM timezones WHERE flag='$flag_1'")
            or die("Something is wrong. \n Our team is working on it at the moment.\n Please check back after some few minutes.");
            $row=mysql_fetch_assoc($timezones); //gets retrieved row

            $active_reference = $row['timezone_reference']; //gets active timezone

           // date_default_timezone_set($active_reference); //sets the default timezone for use
            $time_stamp = date("H:i:s"); //gets the current time
            $delivery_date = date("Y-m-d"); //gets the current date

	        //storing the billing_id into a variable
	        $row=mysql_fetch_array($qry_select);
	        $billing_id=$row['billing_id'];

	        $staff = 0;  // Defaualt value When oreder is placed

	        //Create INSERT query
	        $qry_create = "INSERT INTO orders_details(member_id,billing_id,cart_id,delivery_date,staffID,flag,time_stamp) VALUES('$member_id','$billing_id','$id','$delivery_date','$staff','$flag_0','$time_stamp')";
	        mysql_query($qry_create);

            //Create UPDATE query (updates flag value in the cart_details table)
	        $qry_update = "UPDATE cart_details SET flag='$flag_1' WHERE cart_id='$id' AND member_id='$member_id'";
            mysql_query($qry_update);

            if($qry_create && $qry_update){
              echo "Your Order Placed";
            }

    }else {
	        echo "Set your biling address fisrt";
	    }
?>
