<?php require('connection/config.php') ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>:Gallery</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<!--  Including Boostrap and JQuery Files   -->
   <link rel="stylesheet"  href="Assests/css/bootstrap.min.css">
   <link rel="stylesheet"  href="Assests/css/font-awesome.min.css">
   <script src="Assests/js/bootstrap.min.js"> </script>
   <script src="/Assests/js/jquery.min.js"> </script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!---------------------------------------------->
<link rel="stylesheet"  href="Assests/css/animate_css_stylesheet.css">
<script language="JavaScript" src="validation/user.js"> </script>
<style>
 .col-md-4{
   margin-bottom: 10px;
 }
  .col-md-4:hover{animation: shake 0.9s; animation-iteration-count: 1;}
  @keyframes shake {
    100% { transform: translate(1px, -2px) rotate(360deg); }

    /* 0% { transform: translate(1px, 1px) rotate(0deg); }
    10% { transform: translate(-1px, -2px) rotate(-1deg); }
    20% { transform: translate(-3px, 0px) rotate(1deg); }
    30% { transform: translate(3px, 2px) rotate(0deg); }
    40% { transform: translate(1px, -1px) rotate(1deg); }
    50% { transform: translate(-1px, 2px) rotate(-1deg); }
    60% { transform: translate(-3px, 1px) rotate(0deg); }
    70% { transform: translate(3px, 1px) rotate(-1deg); }
    80% { transform: translate(-1px, -1px) rotate(1deg); }
    90% { transform: translate(1px, 2px) rotate(0deg); }
    100% { transform: translate(1px, -2px) rotate(-1deg); } */
}
</style>
</head>
<body>
  <?php require('navbar.php') ?>
<div class="container" style="margin-top: 50px;">
  <div class="row">
    <h1 style="text-align: center;">Gallery</h1> <hr>

    <div class="col-md-4">
      <img src="Assests/images/gallery/pic.jpg" alt="test" class="img img-responsive">
    </div>
    <div class="col-md-4">
      <img src="Assests/images/gallery/pic.jpg" alt="test" class="img img-responsive">
    </div>
    <div class="col-md-4">
      <img src="Assests/images/gallery/pic.jpg" alt="test" class="img img-responsive">
    </div>
    <div class="col-md-4">
      <img src="Assests/images/gallery/pic.jpg" alt="test" class="img img-responsive">
    </div>
    <div class="col-md-4">
      <img src="Assests/images/gallery/pic.jpg" alt="test" class="img img-responsive">
    </div>
    <div class="col-md-4">
      <img src="Assests/images/gallery/pic.jpg" alt="test" class="img img-responsive">
    </div>
    <div class="col-md-4">
      <img src="Assests/images/gallery/pic.jpg" alt="test" class="img img-responsive">
    </div>
    <div class="col-md-4">
      <img src="Assests/images/gallery/pic.jpg" alt="test" class="img img-responsive">
    </div>
    <div class="col-md-4">
      <img src="Assests/images/gallery/pic.jpg" alt="test" class="img img-responsive">
    </div>
  </div>
</div>
<?php require('footer.php') ?>
</body>
</html>
