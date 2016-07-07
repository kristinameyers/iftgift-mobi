<?php
include_once("../connect/connect.php");
include_once("../config/config.php");
include_once("cart_functions.php");


//////////////////////////////////////ADD GIFT IN CART/////////////////////////////////////////////////

if($_REQUEST['command']=='add' && $_REQUEST['productid']>0){
	$pid=$_REQUEST['productid'];
	addtocart($pid,1);
	header("location:".ru."cart");
	exit();
}
 
//////////////////////////////////////REMOVE GIFT FROM CART/////////////////////////////////////////////////
 
if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
	remove_product($_REQUEST['pid']);
	header("location:".ru."cart");
	exit();
} 	

//////////////////////////////////////CANCEL GIFT/////////////////////////////////////////////////

if($_GET['dId'])
{
	$delivery_id = $_GET['dId'];
	unset($_SESSION['cart']);
	echo "Success";
}
?>