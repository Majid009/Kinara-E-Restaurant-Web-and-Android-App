<?php
session_start();
require 'connection/config.php';
// include autoloader
require_once 'dompdf/autoload.inc.php';

//Connect to mysql server
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
$db = mysql_select_db(DB_DATABASE);

$flag_0 = 0;
$member_id = $_SESSION['SESS_MEMBER_ID'];
$items=mysql_query("SELECT * FROM cart_details WHERE member_id='$member_id' AND flag='$flag_0'");

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

?>

<?php

$bill_content = "<h1 align='center'>". APP_NAME ."</h1><hr>";
$bill_content .= "<h3>Recipient name: ".$_SESSION['SESS_FIRST_NAME'] ." ".$_SESSION['SESS_LAST_NAME']."</h3 >";
$bill_content .= "<h3>Receipt No: ".rand(100000, 1000000) ."</h3>";
$bill_content .="<h3>Date: ".date("m-d-Y",time())."</h3> <br>";
$bill_content .= "<h2 style='background:black; color: white; padding:10px;'>Items Details</h2><br>";

$bill_content .= "<table style='width:500px; text-align:center;'>";
$bill_content .= "<tr>";
$bill_content .= "<th> Item Name </th>";
$bill_content .= "<th> Price </th>";
$bill_content .= "<th> Quantity </th>";
$bill_content .= "<th> Total Cost </th>";
$bill_content .= "</tr>";
$bill_content .= $_SESSION['$data_for_Bill'];
$bill_content .= "</table><hr>";
unset($_SESSION['$data_for_Bill']);

// calculation of tatal bill
 $total_bill=mysql_query("SELECT SUM(total) as total_price FROM cart_details WHERE member_id=$member_id AND flag=0");
 $row_x = mysql_fetch_array($total_bill);
 $total_bill = $row_x['total_price'];
 $bill_content .= "<h3>Total: ".$total_bill." PRK </h3";

$dompdf->loadHtml($bill_content);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
?>


<?php
$html = file_get_contents("pdf-content.html");
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream("codexworld",array("Attachment"=>0));
?>

<?php
$html = file_get_contents("pdf-content.html");
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream("codexworld",array("Attachment"=>0));
?>
