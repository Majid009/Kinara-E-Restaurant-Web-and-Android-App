<?php
//Start session
session_start();

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


//------------ Code to check Email and get Security question ---------------------------
if (isset($_GET['email'])) {
  // get Email
  $email = $_GET['email'];

  //selecting a specific record from the members table. Return an error if there are no records in the table
  $result=mysql_query("SELECT * FROM members WHERE login='$email'")
  or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");

 $rows = mysql_num_rows($result);
 if($rows==0){
   echo "Email doesn't exists";
 }
 // if  eamil exists
 if($rows==1){
   $data = mysql_fetch_assoc($result);
   $q_id = $data['question_id'];
   $_SESSION['member_id'] =$data['member_id']; //creates a member id session
   $result = mysql_query("SELECT * from questions WHERE question_id='$q_id'");
   $data = mysql_fetch_assoc($result);
   echo $member_id;
   echo "Email exists.<br>Your Security Question: ".$data['question_text'];
 }
}

   //------------ Code to update password ---------------------------
    if( isset($_GET['answer']) && isset($_GET['new_password']) && isset($_SESSION['member_id']) )
    {
          //get answer and new password from form
          $answer = md5($_GET['answer']);
          $new_password = md5($_GET['new_password']);

       // update the entry
       $result_x = mysql_query("UPDATE members SET passwd='$new_password' WHERE member_id='$member_id' AND answer='$answer'");

        echo "<hr>$answer<hr>";
        echo "<hr>$new_password<hr>";
        echo "<hr>".$_SESSION['member_id'].""<hr>";

       if($result_x)
       {
            echo "Password Reset Successful"; //redirect to reset success page
       }
       else
       {
           echo "Password Reset Failed"; //redirect to reset failed page
       }
   }

?>
