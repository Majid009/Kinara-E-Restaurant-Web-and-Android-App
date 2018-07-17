<?php
    require_once('auth.php');
    require_once('connection/config.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>:Alternative Billing</title>
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
</script>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row">
      <h1>Billing Address</h1>
      <p style="font-size:16px; text-align:justify;">We have found out that you don't have a billing address in your account. Please add a billing
         address in the form below. It is the same address that will be used to deliver your food orders.
          Please note that ONLY correct street/physical addresses should be used in order to ensure smooth
          delivery of your food orders. For more information <a href="contactus.php">Click Here</a> to contact us.</p>
          <hr>
      <div class="col-md-4 col-md-offset-4 animated bounceInRight">
            <form id="billingForm" name="billingForm" method="post" action="billing-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return billingValidate(this)">
              <h3 style="text-align:center;">Add Delivery / Billing Address</h3>
                  <input name="sAddress" type="text" class="form-control" id="sAddress" placeholder="Street Address" required/>
                  <input name="box" type="text" class="form-control" id="box" placeholder="P O Box Number" required/>
                  <input name="city" type="text" class="form-control" id="city" placeholder="City" required/>
                  <input name="mNumber" type="text" class="form-control" id="mNumber" placeholder="Mobile No." required/>
                  <input name="lNumber" type="text" class="form-control" id="lNumber" placeholder="LandLine No." required/>
                  <input type="submit" name="Submit" value="Add" id="btn_add" class="form-control btn btn-primary"/>
            </form>
      </div>
    </div>
  </div>
   <?php include 'footer.php'; ?>
  <body>
</html>
