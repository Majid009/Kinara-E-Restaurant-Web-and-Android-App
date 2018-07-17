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
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo APP_NAME; ?>:Home</title>

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
<link href="stylesheets/user_styles.css"  rel="stylesheet" type="text/css">
<script language="JavaScript" src="validation/user.js"> </script>
<script language="JavaScript" src="Assests/js/scrolling.js"> </script>

</head>
<body>
<div id="menu" class="navbar navbar-inverse navbar-fixed-top animated slideInDown">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="text-decoration:none; font-size:26px; color:yellow;"> Akbar's Kinara </a>
            </div>
			<div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#foodZone">Food Zone</a></li>
                    <li><a href="specialdeals.php">Special Deals</a></li>
                    <li><a href="member-index.php">My Account</a></li>
                    <li><a href="#login_section">Login</a></li>
                    <li><a href="#SignUp_section">Sign Up</a></li>
                    <li><a href="reviews.php">Reviews</a></li>
                    <li><a href="#ContactUs_section">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
<?php include 'carousel.php'; ?>
<div id="wellcome_message" class="container-fluid">
  <h2><center> <i class="fa fa-circle-o-notch"> </i> Welcome To Akbar's Kinara <i class="fa fa-circle-o-notch"> </i> </center></h2>
  <p style="text-align:justify;">
   Order your food today from the Food Zone and it will be delivered at your door step.
   Jump in to our weekly special deals in the Special Deals menu. Register an account with
   us to enjoy fast ordering, delivery, and convenient payment of your food. Start now by
   logging in below or registering if you don't have an account with us </p>
</div>

<div id="login_section" class="container-fluid">
  <div class="row">
    <div id="login_form" class="col-md-6 col-md-offset-3">
      <h1> Login </h1>
      <form id="loginForm" name="loginForm" method="post" action="login-exec.php" onsubmit="return loginValidate(this)">
         <input name="login" type="text" id="login" class="form-control" placeholder="Email / Username"/>
         <input name="password" type="password" class="form-control" id="password" placeholder="Password"/>
         <a id="forget_password" href="JavaScript: resetPassword()">Forgot password?</a>
      <label>
        <input name="remember" type="checkbox" class="" id="remember" value="1" onselect="cookie()" <?php if(isset($_COOKIE['remember_me'])) {
          echo 'checked="checked"';
      }
      else {
          echo '';
      }
      ?>/> Remember me </label>
      <input type="reset" value="Clear Fields" class="form-control btn btn-primary" id="clear_feilds"/> <br><br>
      <input type="submit" name="Submit" value="Login" class="form-control btn btn-primary" id="login_btn"/>
      </form>
      <center> <p style="margin-top:20px;"> Don't have Account? <a href="#SignUp_section">SignUp</a> </p> </center>
    </div>
  </div>
</div>

<div id="SignUp_section" class="container-fluid">
  <div class="row">
    <div id="SignUp_form" class="col-md-6 col-md-offset-3">
      <h1> Sign Up </h1>
      <form id="loginForm" name="loginForm" method="post" action="register-exec.php" onsubmit="return registerValidate(this)">
        <input name="fname" type="text" class="form-control" id="fname" placeholder="First Name"/>
        <input name="lname" type="text" class="form-control" id="lname" placeholder="Last Name" />
        <input name="login" type="text" class="form-control" id="login" placeholder="E mail"/>
        <input name="password" type="password" class="form-control" id="password"  placeholder="Password"/>
        <input name="cpassword" type="password" class="form-control" id="cpassword"  placeholder="Confirm Password"/>
        <select name="question" id="question" class="form-control" placeholder="Select Security Question">
        <option value="select"> Select Security Question
        <?php
        //loop through quantities table rows
        while ($row=mysql_fetch_array($questions)){
        echo "<option value=$row[question_id]>$row[question_text]";
        }
        ?>
        </select>
        <input name="answer" type="text" class="form-control" id="answer"  placeholder="Write Answer"/>
        <input type="reset" value="Clear Fields" class="form-control btn btn-primary" id="clear_feilds"/> <br> <br>
        <input type="submit" name="Submit" value="Register" class="form-control btn btn-primary" id="SignUp_btn"/>
      </form>
    </div>
  </div>
</div>

<div id="foodZone" class="container-fluid">
  <div class="row">
    <div id="foodZone_internal" class="col-md-8 col-md-offset-2">
      <h1> Food Zone <br> <small style="color: #2E4053;"> Get Variety Of Foods At Door Step </small> </h1>
      <a  id="foodzone_link" href="foodzone.php" class="btn btn-primary"> Visit Our Food Zone </a>
    </div>
  </div>
</div>
<?php include 'carousel2.php'; ?>
<div id="ContactUs_section" class="container-fluid">
  <div class="row">
    <div id="ContactUs_form" class="col-md-4">
      <h1> Contact Us </h1>
      <form id="loginForm" name="loginForm" method="post" action="register-exec.php" onsubmit="return registerValidate(this)">
        <input name="name" type="text" class="form-control" id="name" placeholder="Your Name"/>
        <input name="email" type="text" class="form-control" id="email" placeholder="Your Email" />
        <textarea name="message" id="message" placeholder="Write Your Message" class="form-control">
          </textarea
        <input type="reset" value="Clear Fields" class="ripple form-control btn btn-primary" id="clear_feilds"/> <br> <br>
        <input type="submit" name="Submit" value="Send Message" class="form-control btn btn-primary" id="Contact_btn"/>
      </form>
    </div>
    <div id="location" class="col-md-4">
      <h1> Location </h1>
      <p id="location_wording">
       <i class="fa fa-home"> </i>  Food Street Lahore , Punjab , Pakistan <br>
       <i class="fa fa-phone"> </i>  <b>Call:</b> + 92 345 5791343 <br>
       <i class="fa fa-mail"> </i>  <b>Email:</b> info@eresturant.com
       </p>
    </div>
    <div id="Social" class="col-md-4">
      <h1> Social Connectivity </h1>
      <p id="location_wording">
       <a href="#"> <i id="icons" class="fa fa-facebook fa-3x"> </i> </a>
       <a href="#"> <i id="icons" class="fa fa-instagram fa-3x"> </i> </a>
       <a href="#"> </i> <i id="icons" class="fa fa-youtube fa-3x"> </i> </a>  <br>
       <a href="#"> <i id="icons" class="fa fa-twitter fa-3x"> </i> </a>
       <a href="#"> <i id="icons" class="fa fa-google fa-3x"> </i> </a>
       <a href="#"> <i id="icons" class="fa fa-linkedin fa-3x"> </i> </a>
       </p>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
