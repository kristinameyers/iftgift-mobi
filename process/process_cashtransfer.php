<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
require_once ('../common/function.php');

echo "<pre>";
print_r($_POST); exit;

//////////////////////////////////////GIVER INFO./////////////////////////////////////////////////
if (isset($_POST['send_request'])){ 

echo	$to = $_POST['rec_email'];
echo	$message = $_POST['message'];     	
	exit;


	///////////////////////name validation////////	
	$cash_amounts = str_replace('$','',$cash_amount);
	if($cash_amounts==''){
		$_SESSION['biz_giv_err']['cash_amount'] = 'Please enter cash gift';
		$flgs = true;
	
	} else if(!is_numeric($cash_amounts)) {
		$_SESSION['biz_giv_err']['cash_amount'] = 'Please enter Numeric value';
		$flgs = true;
	}
	
	if($first_name==''){
		$_SESSION['biz_giv_err']['first_name'] = 'Please enter first name';
		$flgs = true;
	
	}
	
	if($last_name==''){
		$_SESSION['biz_giv_err']['last_name'] = 'Please enter last name';
		$flgs = true;
	
	}
	
	if($email==''){
		$_SESSION['biz_giv_err']['email'] = $_ERR['register']['email'];
		$flgs = true;
	
	}elseif($email!=''){
			
			if (vpemail($email )){
			
				$_SESSION['biz_giv_err']['email'] = $_ERR['register']['emailg'];
				$flgs = true;
			
			}
	}	
	  
  if($flgs)
  {
	
		header('location:'.ru.'giver_info'); exit;
		
  }else{
			  $chkQry = mysql_query("select * from ".tbl_delivery." where delivery_id = '".$delivery_id."'");
			  if(mysql_num_rows($chkQry) == 0) {
			  $insQry ="insert into ".tbl_delivery." set cash_amount = '$cash_amounts',
			  									occassionid		= '$occassionid',
			  									giv_first_name		= '$first_name',
			 									giv_last_name 		= '$last_name',
												giv_email 		= '$email',
												userId			= '$userId'";
									
			 mysql_query($insQry)or die (mysql_error());
			 $_SESSION['delivery_id']['New'] = mysql_insert_id();
			 } else {
				$updQry ="update ".tbl_delivery." set cash_amount = '$cash_amounts',
													occassionid		= '$occassionid',
													giv_first_name		= '$first_name',
													giv_last_name 		= '$last_name',
													giv_email 		= '$email',
													userId			= '$userId'
													where delivery_id = '$delivery_id'";
				 mysql_query($updQry)or die (mysql_error());									
			 }
		unset($_SESSION['biz_giv_err']);
		unset($_SESSION['biz_giv']);
		//$_SESSION['biz_giv_err']['Giver_edit'] = 'Giver Info successfully updated!';
		header('location:'.ru.'delivery_detail'); exit;
  }
  
}






?>