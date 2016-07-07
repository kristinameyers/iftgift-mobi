<?php
include('../connect/connect.php');
include('../config/config.php');
//echo '<pre>';print_r($_REQUEST);exit;

if($_POST['userinfo']) {

	foreach($_POST as $key => $val)
	{
		$$key=addslashes(trim($val));
		$_SESSION['profile'][$key]=$val;
	}
	
	$query = mysql_query("UPDATE ".tbl_user." set first_name='".$first_name."',last_name='".$last_name."',address='".$address."',phone='".$phone."',dob='".$dob."',email='".$email."',dated=now() where userId = '".$userId."'");	
	header("location:".ru."personalinformation");
}
?>