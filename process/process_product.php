<?php
include_once("../connect/connect.php");
include_once("../config/config.php");
if(isset($_GET['type']) && $_GET['type']=='own')
{
	
	$proId = filter_var($_GET['proid'], FILTER_SANITIZE_STRING);
	$userId = filter_var($_GET['userId'], FILTER_SANITIZE_STRING);
	
	//echo $query = "SELECT * FROM ".tbl_own." WHERE userId = '".$userId."' AND proid = '".$proId."'";
 	$inst = mysql_query("INSERT INTO ".tbl_own." SET own_it = '1', proid = '".$proId."', userId = '".$userId."'");
	
	$query = mysql_fetch_array(mysql_query("SELECT * FROM ".tbl_product." WHERE proid = '".$proId."'"));
	$ownId = $query['own_id'];
 	if($ownId == '0' || $ownId == '')
	{
		$upd_qry = mysql_query("UPDATE ".tbl_product." SET status = '1', own_id = '".$userId."' WHERE proid = '".$proId."'");
	} 
	else {
		
		$Id = $ownId.','.$userId;
	   //$cusId =	rtrim($id, ', ');
	   $upd_qry = mysql_query("UPDATE ".tbl_product." SET status = '1', own_id = '".$Id."' WHERE proid = '".$proId."'");
	}
	
	if($inst)
	{
		/*--------------Function Used For Gift Own It Points-------------------*/
		user_own_points($userId);
		/*--------------Function Used For Gift Own It Points-------------------*/
	$get_q = "SELECT count( own_it ) AS cnt FROM ".tbl_own." WHERE proid = '".$proId."' GROUP BY proid HAVING Count( own_it )";
	$view_q = $db->get_row($get_q,ARRAY_A);
	?>
		<div class="ui-block-a active"><div class="ui-bar ui-bar-a">Own it<div class="own_it"></div><span id="own"><?php echo $view_q{'cnt'}; ?> People Own it</span></div></div>
	<?php
	}	
}


if(isset($_GET['type']) && $_GET['type']=='love')
{
	
	$proId = filter_var($_GET['proid'], FILTER_SANITIZE_STRING);
	$userId = filter_var($_GET['userId'], FILTER_SANITIZE_STRING);
	
	
	//echo $query = "SELECT * FROM ".tbl_own." WHERE userId = '".$userId."' AND proid = '".$proId."'";
 	$inst = mysql_query("INSERT INTO ".tbl_love." SET love_it = '1', proid = '".$proId."', userId = '".$userId."'");
	
	$query = mysql_fetch_array(mysql_query("SELECT * FROM ".tbl_product." WHERE proid = '".$proId."'"));
	$loveId = $query['love_id'];
 	if($loveId == '0' || $loveId == '')
	{
		$upd_qry = mysql_query("UPDATE ".tbl_product." SET status = '1', love_id = '".$userId."' WHERE proid = '".$proId."'");
	} 
	else {
		
		$Id = $loveId.','.$userId;
	   //$cusId =	rtrim($id, ', ');
	   $upd_qry = mysql_query("UPDATE ".tbl_product." SET status = '1', love_id = '".$Id."' WHERE proid = '".$proId."'");
	}
	
	if($inst)
	{
		/*--------------Function Used For Gift Love It Points-------------------*/
		user_love_points($userId);
		/*--------------Function Used For Gift Love It Points-------------------*/
		
	$get_l = "SELECT count( love_it ) AS cnt FROM ".tbl_love." WHERE proid = '".$proId."' GROUP BY proid HAVING Count( love_it )";
	$view_l = $db->get_row($get_l,ARRAY_A);
	?>
		<div class="ui-block-b active"><div class="ui-bar ui-bar-a">Love it<div class="own_it love_it"></div><span><?php echo $view_l{'cnt'}; ?> People Love it</span></div></div>
	<?php
	}	
		
}

if(isset($_GET['type']) && $_GET['type']=='hide')
{
	
	$proId = filter_var($_GET['proid'], FILTER_SANITIZE_STRING);
	$userId = filter_var($_GET['userId'], FILTER_SANITIZE_STRING);
	
	$query = mysql_fetch_array(mysql_query("SELECT * FROM ".tbl_product." WHERE proid = '".$proId."'"));
	$customer_id = $query['hide_id'];
 	if($customer_id == '0' || $customer_id == '')
	{
		$upd_qry = mysql_query("UPDATE ".tbl_product." SET status = '1', hide_id = '".$userId."' WHERE proid = '".$proId."'");
	} 
	else {
		
		$Id = $customer_id.','.$userId;
	   //$cusId =	rtrim($id, ', ');
	   $upd_qry = mysql_query("UPDATE ".tbl_product." SET status = '1', customer_id = '".$Id."' WHERE proid = '".$proId."'");
	}
	$inst = mysql_query("INSERT INTO ".tbl_hide." SET hide_it = '1', proid = '".$proId."', userId = '".$userId."'");
	if($inst)
	{
	
		/*--------------Function Used For Gift Hide It Points-------------------*/
		user_hide_points($userId);
		/*--------------Function Used For Gift Hide It Points-------------------*/
		
	$get_h = "SELECT count( hide_it ) AS cnt FROM ".tbl_hide." WHERE proid = '".$proId."' GROUP BY proid HAVING Count( hide_it )";
	$get_h = $db->get_row($get_h,ARRAY_A);
	?>
		<div class="ui-block-c active"><div class="ui-bar ui-bar-a">Hide it<div class="own_it hide_it"></div><span><?php echo $get_h{'cnt'}; ?> People Hide it</span></div></div>
	<?php
	}
		
}

?>