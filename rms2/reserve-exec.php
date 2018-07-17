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
    $partyhall_id = 0;
    $table_id = 0;
    $partyhall_flag = 0;
    $table_flag = 0;

    if(isset($_POST['table'])){
        $table_id = clean($_POST['table']);
        $table_flag = 1;
        $phd = $_POST['table'];

	    $q = "SELECT * FROM reservations_details WHERE table_id = '$phd' ";
        $res = mysql_query($q);
	    if(mysql_num_rows($res) == 1){

	    	header("location: booked.php");
	    }else{

		    $date = clean($_POST['date']);
				$time = clean($_POST['time']);
				$staff = 0; // default value
				$flag = 0;



		//check if the id is set at the link
			if (isset($_GET['id'])){


			    //get user id
			    $id = $_GET['id'];

			    //Create INSERT query
			    $qry = "INSERT INTO reservations_details(member_id,table_id,partyhall_id,Reserve_Date,Reserve_Time,staffID,table_flag,partyhall_flag,flag) VALUES('$id','$table_id','$partyhall_id','$date','$time','$staff','$table_flag','$partyhall_flag','$flag')";
			    mysql_query($qry);

			    //redirect to the reserve success page
			    header("location: reserve-success.php");

			}else {
				die("Reservation failed! Please try again after a few minutes.");
			}

	   }


    }else if(isset($_POST['partyhall'])){
        $partyhall_id = clean($_POST['partyhall']);
        $partyhall_flag = 1;

        $phd = $_POST['partyhall'];

	    $q = "SELECT * FROM reservations_details WHERE partyhall_id = '$phd' ";
        $res = mysql_query($q);
	    if(mysql_num_rows($res) == 1){

	    	header("location: booked.php");
	    }else{

	    	$date = clean($_POST['date']);
			$time = clean($_POST['time']);
			$staff = 5;
			$flag = 0;



	//check if the id is set at the link
		if (isset($_GET['id'])){


		    //get user id
		    $id = $_GET['id'];

		    //Create INSERT query
		    $qry = "INSERT INTO reservations_details(member_id,table_id,partyhall_id,Reserve_Date,Reserve_Time,staffID,table_flag,partyhall_flag,flag) VALUES('$id','$table_id','$partyhall_id','$date','$time','$staff','$table_flag','$partyhall_flag','$flag')";
		    mysql_query($qry);

		    //redirect to the reserve success page
		    header("location: reserve-success.php");

		}else {
			die("Reservation failed! Please try again after a few minutes.");
		}

	}

}





?>
