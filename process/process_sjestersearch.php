<?php 
include('../connect/connect.php');
if($_POST['keyword'] != '') {
$kw = urlencode($_POST['keyword']);
$search = $kw;
} else if($_POST['price_from'] != '' && $_POST['price_to'] == '') {
$price_from = $_POST['price_from'];
if($_POST['price_to'] == '')
{
$price_to = 0; 
} else {
$price_to = $_POST['price_to'];
}
$search = $price_from.'/'.$price_to;
} else if($_POST['price_to'] != '' && $_POST['price_from'] == '') {
$price_to = $_POST['price_to'];
if($_POST['price_from'] == '')
{
$price_from = 0; 
} else {
$price_from = $_POST['price_from'];
}
$search = $price_from.'/'.$price_to;
} else if($_POST['price_to'] != '' && $_POST['price_from'] != '') {
$price_to = $_POST['price_to'];
$price_from = $_POST['price_from'];
$search = $price_from.'/'.$price_to;
} 
header("location:".ru."search_result/".$search);
exit;		
?>