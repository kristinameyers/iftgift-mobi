<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
require_once ('../common/function.php');

unset($_SESSION['biz_rep_err']);
unset($_SESSION['biz_rep']);
//echo "<pre>";
//print_r($_POST); exit;


if (isset($_POST['SaveRecipit'])){ 

     	unset($_SESSION['biz_rep_err']);
	    unset($_SESSION['biz_rep']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_rep'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name validation////////	
	$cash_amounts = str_replace('$','',$cash_amount);
	if($cash_amounts==''){
		$_SESSION['biz_rep_err']['cash_amount'] = 'Please enter cash gift';
		$flgs = true;
	
	} else if(!is_numeric($cash_amounts)) {
		$_SESSION['biz_rep_err']['cash_amount'] = 'Please enter Numeric value';
		$flgs = true;
	}
	
	if($first_name==''){
		$_SESSION['biz_rep_err']['first_name'] = 'Please enter first name';
		$flgs = true;
	
	}
	
	if($email==''){
		$_SESSION['biz_rep_err']['email'] = $_ERR['register']['email'];
		$flgs = true;
	
	}elseif($email!=''){
			
			if (vpemail($email )){
			
				$_SESSION['biz_rep_err']['email'] = $_ERR['register']['emailg'];
				$flgs = true;
			
			}
	}	
	
	if($age==''){
		$_SESSION['biz_rep_err']['age'] = 'Please enter age';
		$flgs = true;
	
	}	
	
	if($ocassion=='Event'){
		$_SESSION['biz_rep_err']['ocassion'] = 'Please select ocassion';
		$flgs = true;
	
	}	
	  
  if($flgs)
  {
	
		header('location:'.ru.'step_1'); exit;
		
  }else{

   			  $insQry ="insert into ".tbl_recipient." set cash_gift = '$cash_amount',
			  									first_name		= '$first_name',
			 									last_name 		= '$last_name',
												email 		= '$email',
												gender   	= '$gender',
												age      = '$age',
												location = '$location',
												ocassion = '$ocassion',
												userId= '$userId',
												dated 		= now()";
  		 mysql_query($insQry)or die (mysql_error());
		$_SESSION['recipit_id']['New'] = mysql_insert_id();
		unset($_SESSION['biz_rep_err']);
		unset($_SESSION['biz_rep']);
		//$_SESSION['biz_rep_err']['Product_add'] = 'Product added successfully!';
		header('location:'.ru.'step_2a'); exit;
  }
  
}
?>