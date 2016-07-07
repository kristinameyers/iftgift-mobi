<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
require_once ('../common/function.php');

//////////////////////////////////////REMOVE UNWRAP/////////////////////////////////////////////////

if($_GET['dId'])
{
	$delivery_id = $_GET['dId'];
	
	//$del = mysql_query("delete from ".tbl_delivery." where delivery_id = '".$delivery_id."'");
	$del = mysql_query("update ".tbl_delivery." set inbox = '1', unwrap_status = '0' where delivery_id = '".$delivery_id."'");
	if($del)
	{
		echo "Success";
	}
}

if($_GET['pId'])
{

	$delivery_id = $_GET['pId'];
	
	$Qry = mysql_query("update ".tbl_delivery." set open_status = '0', unwrap_status = '3', dated = now() where delivery_id = '".$delivery_id."'");
	if($Qry)
	{
		echo "Success";
	}
}


?>