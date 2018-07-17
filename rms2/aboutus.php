<?php require 'connection/config.php'?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo APP_NAME ?>:About</title>
<script type="text/javascript" src="swf/swfobject.js"></script>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page">
  <div id="menu"><ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="foodzone.php">Food Zone</a></li>
  <li><a href="specialdeals.php">Special Deals</a></li>
  <li><a href="member-index.php">My Account</a></li>
  <li><a href="contactus.php">Contact Us</a></li>
  </ul>
  </div>
<div id="header">
  <div id="logo"> <a href="index.php" class="blockLink"></a></div>
  <div id="company_name"><?php echo APP_NAME ?></div>
</div>
<div id="center">

  <h1>ABOUT <?php echo APP_NAME ?></h1>
  <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
  <p><?php echo APP_NAME ?> is a multinational restaurant food chain and delivery service with an aim of providing nutritious food to all our current and esteemed customers in Kenya and the world. This is achieved through quality services that surpases customers' satisfaction.</p>
  <p>Along with our business philosophy, we aim to be a convenient way of delivering food right at your door step with no extra shipping cost incurred. Yes we are here to serve you and to meet your stomach needs.</p>
  <h3>Mission</h3>
  <p>To provide affordable, quality, and nutritious food to all our customers and esteemed customers.</p>
  <h3>Vision</h3>
  <p>To become the world's most respected brand in delivering quality food to all our customers and esteeemed customers.</p>
  </div>
</div>
<?php include 'footer.php'; ?>
</div>

</body>
</html>
