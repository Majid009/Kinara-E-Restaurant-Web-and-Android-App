<?php
//Start session
session_start();

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
?>
<?php
    if(isset($_POST['Submit'])){
        //Function to sanitize values received from the form. Prevents SQL injection
        function clean($str) {
            $str = @trim($str);
            if(get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            return mysql_real_escape_string($str);
        }
        //get email
        $email = clean($_POST['email']);

        //selecting a specific record from the members table. Return an error if there are no records in the table
        $result=mysql_query("SELECT * FROM members WHERE login='$email'")
        or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");
    }
?>
<?php
    if(isset($_POST['Change'])){
        //Function to sanitize values received from the form. Prevents SQL injection
        function clean($str) {
            $str = @trim($str);
            if(get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            return mysql_real_escape_string($str);
        }
        if(trim($_SESSION['member_id']) != ''){
            $member_id=$_SESSION['member_id']; //gets member id from session
            //get answer and new password from form
            $answer = clean($_POST['answer']);
            $new_password = clean($_POST['new_password']);

         // update the entry
         $result = mysql_query("UPDATE members SET passwd='".md5($_POST['new_password'])."' WHERE member_id='$member_id' AND answer='".md5($_POST['answer'])."'")
         or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours. \n");

         if($result){
                unset($_SESSION['member_id']);
                header("Location: reset-success.php"); //redirect to reset success page
         }
         else{
                unset($_SESSION['member_id']);
                header("Location: reset-failed.php"); //redirect to reset failed page
         }
            }
            else{
                unset($_SESSION['member_id']);
                header("Location: reset-failed.php"); //redirect to reset failed page
            }
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>:Password Reset</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
<!--  Including Boostrap and JQuery Files   -->
   <link rel="stylesheet"  href="Assests/css/bootstrap.min.css">
   <link rel="stylesheet"  href="Assests/css/font-awesome.min.css">
   <script src="Assests/js/bootstrap.min.js"> </script>
   <script src="/Assests/js/jquery.js"> </script>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!---------------------------------------------->
<link rel="stylesheet"  href="Assests/css/animate_css_stylesheet.css">
</head>
<body style="background:#DFE3EE;">
  <div class="container" style="padding-left: 100px; padding-right: 100px;">
  <form name="passwordResetForm" id="passwordResetForm" method="post" action="password-reset.php" onsubmit="return passwordResetValidate(this)">
    <input name="email" type="text" id="email" placeholder="Account Email"class="form-control"/> <br>
    <input type="submit" name="Submit" value="Check" class="form-control btn btn-primary" style="border-radius:20px;"/>
 </form>
</div>
  <hr>
  <?php
    if(isset($_POST['Submit'])){
        $row=mysql_fetch_assoc($result);
        $_SESSION['member_id']=$row['member_id']; //creates a member id session
        session_write_close(); //closes session
        $question_id=$row['question_id'];

        //get question text based on question_id
        $question=mysql_query("SELECT * FROM questions WHERE question_id='$question_id'")
        or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours.");

        $question_row=mysql_fetch_assoc($question);
        $question=$question_row['question_text'];
        if($question!=""){
            echo "<b>Your Member ID:</b> ".$_SESSION['member_id']."<br>";
            echo "<b>Your Security Question:</b> ".$question;
        }
        else{
            echo "<b>Your Security Question:</b> THIS ACCOUNT DOES NOT EXIST! PLEASE CHECK YOUR EMAIL AND TRY AGAIN.";
        }
    }
  ?>
  <div class="container" style=" margin:0px; padding-left: 100px; padding-right: 100px;">
   <form name="passwordResetForm" id="passwordResetForm" method="post" action="password-reset.php" onsubmit="return passwordResetValidate_2(this)">
        <input name="answer" type="text" class="form-control" id="answer" placeholder="Your Security Answer" style="border-radius:20px;" required/>
  <br>  <input name="new_password" type="password" class="form-control" id="new_password" placeholder="New Password" style="border-radius:20px;" required/>
  <br>  <input name="confirm_new_password" type="password" class="form-control" id="confirm_new_password" placeholder="Confirm New Password" style="border-radius:20px;" required />
  <br>  <input type="submit" name="Change" value="Change Password" class="form-control btn btn-primary" style="border-radius:20px;"/>
   </form>
  </div>
</body>
</html>
