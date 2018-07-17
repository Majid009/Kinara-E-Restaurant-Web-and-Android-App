<?php
//checking connection and connecting to a database
require_once('connection/config.php');
error_reporting(1);
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

//retrieve questions from the questions table
$questions=mysql_query("SELECT * FROM questions")
or die("Something is wrong ... \n" . mysql_error());
?>
<?php
//setting-up a remember me cookie
    if (isset($_POST['Submit'])){
        //setting up a remember me cookie
        if($_POST['remember']) {
            $year = time() + 31536000;
            setcookie('remember_me', $_POST['login'], $year);
        }
        else if(!$_POST['remember']) {
            if(isset($_COOKIE['remember_me'])) {
                $past = time() - 100;
                setcookie(remember_me, gone, $past);
            }
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>:Login</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
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
<script language="JavaScript" src="validation/user.js"> </script>
</head>
<body style="background: #DFE3EE;">
  <?php include 'navbar.php'; ?>
  <div class="container-fluid" style="margin-top:50px;">
    <div class="row">
      <div class="col-md-3 col-md-offset-1 animated bounceInDown">
        <h1 style="text-align:center;">Login</h1>
        <form id="loginForm" name="loginForm" method="post" action="login-exec.php" onsubmit="return loginValidate(this)">
          <input name="login" type="text" class="form-control" id="login" placeholder="Email" Required/>
          <input name="password" type="password" class="form-control" id="password" placeholder="Password" Required/>
           <label>
           <input name="remember" type="checkbox" class="" id="remember" value="1" onselect="cookie()" <?php if(isset($_COOKIE['remember_me'])) {
                    echo 'checked="checked"';
                }
                else {
                    echo '';
                }
                ?>/> Remember me </label>
               <a href="JavaScript: resetPassword()">Forgot password?</a>
               <input type="reset" value="Clear Fields" class="form-control btn btn-primary" id="clear_feilds"/> <br><br>
              <input type="submit" name="Submit" value="Login" class="form-control btn btn-primary" id="login_btn"/>
        </form>
      </div>
      <div class="col-md-3 col-md-offset-2 animated bounceInUp">
        <h1 style="text-align:center;">Register</h1>
        <form id="loginForm" name="loginForm" method="post" action="register-exec.php" onsubmit="return registerValidate(this)">
          <input name="fname" type="text" class="form-control" id="fname" placeholder="First Name" Required/>
          <input name="lname" type="text" class="form-control" id="lname" placeholder="Last Name" Required/>
          <input name="login" type="text" class="form-control" id="login" placeholder="E mail" Required/>
          <input name="password" type="password" class="form-control" id="password"  placeholder="Password" Required/>
          <input name="cpassword" type="password" class="form-control" id="cpassword"  placeholder="Confirm Password" Required/>
          <select name="question" id="question" class="form-control">
                <option value="select"> Select a Security Question
                <?php
                //loop through quantities table rows
                while ($row=mysql_fetch_array($questions)){
                echo "<option value=$row[question_id]>$row[question_text]";
                }
                ?>
          </select>
          <input name="answer" type="text" class="form-control" id="answer" placeholder="Write Answer" required/>
         <!--   <input type="reset" value="Clear Fields" class="form-control btn btn-primary" id="clear_feilds"/> <br> _--> <br>
          <input type="submit" name="Submit" value="Register" class="form-control btn btn-primary" id="SignUp_btn" />
        </form>
      </div>
    </div>
  </div>
</body>
</html>
