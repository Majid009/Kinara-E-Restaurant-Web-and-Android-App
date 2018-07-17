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
    $member_id = "";

     if(isset($_POST['email']) && isset($_POST['street']) && isset($_POST['city']) && isset($_POST['mobile']) && isset($_POST['landline']) && isset($_POST['pobox']))
   	{
      $email = clean($_POST['email']);
      $street = clean($_POST['street']);
      $city = clean($_POST['city']);
      $mobile = clean($_POST['mobile']);
      $landline = clean($_POST['landline']);
      $pobox = clean($_POST['pobox']);
      //Create query
     	$qry="SELECT * FROM members WHERE login='$email'";
     	$result=mysql_query($qry);

      if(mysql_num_rows($result) == 1)
      {
   			 $member = mysql_fetch_assoc($result);
         $member_id = $member['member_id'];
      }

      //Create INSERT query
    	$qry = "INSERT INTO billing_details(member_id,Street_Address,P_O_Box_No,City,Mobile_No,Landline_No) VALUES('$member_id','$street','$pobox','$city','$mobile','$landline')";
    	$result = mysql_query($qry);
      if ($result) {
        echo "Billing Address Added Successfully";
      }
 }

?>
