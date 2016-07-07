<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
require_once ('../common/function.php');

unset($_SESSION['biz_giv_err']);
unset($_SESSION['biz_giv']);
//echo "<pre>";
//print_r($_POST); exit;
function get_images($image)
{
	$img =  preg_replace("/<a[^>]+\>/i", "", $image);
	preg_match("/src=([^>\\']+)/", $img, $result);
	$view_image = array_pop($result);
	return $view_image;
}

//////////////////////////////////////GIVER INFO./////////////////////////////////////////////////
if (isset($_POST['SaveGiver'])){ 

     	unset($_SESSION['biz_giv_err']);
	    unset($_SESSION['biz_giv']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_giv'][$k]=$v;
	}
  	$flgs = false;


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


//////////////////////////////////////RECIPIT INFO./////////////////////////////////////////////////
if (isset($_POST['SaveRecp'])){ 

     	unset($_SESSION['biz_rec_err']);
	    unset($_SESSION['biz_rec']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_rec'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name validation////////	
	$cash_amounts = str_replace('$','',$cash_amount);
	if($cash_amounts==''){
		$_SESSION['biz_rec_err']['cash_amount'] = 'Please enter cash gift';
		$flgs = true;
	
	} else if(!is_numeric($cash_amounts)) {
		$_SESSION['biz_rec_err']['cash_amount'] = 'Please enter Numeric value';
		$flgs = true;
	}
	
	if($first_name==''){
		$_SESSION['biz_rec_err']['first_name'] = 'Please enter first name';
		$flgs = true;
	
	}
	
	if($last_name==''){
		$_SESSION['biz_rec_err']['last_name'] = 'Please enter last name';
		$flgs = true;
	
	}
	
	if($email==''){
		$_SESSION['biz_rec_err']['email'] = $_ERR['register']['email'];
		$flgs = true;
	
	}elseif($email!=''){
			
			if (vpemail($email )){
			
				$_SESSION['biz_rec_err']['email'] = $_ERR['register']['emailg'];
				$flgs = true;
			
			}
	}	
	  
  if($flgs)
  {
	
		header('location:'.ru.'recp_info'); exit;
		
  }else{
			  
			 $chkQry = mysql_query("select * from ".tbl_delivery." where delivery_id = '".$delivery_id."'");
			  if(mysql_num_rows($chkQry) == 0) {
			  $insQry ="insert into ".tbl_delivery." set cash_amount = '$cash_amounts',
			  									recp_first_name		= '$first_name',
			 									recp_last_name 		= '$last_name',
												recp_email 		= '$email',
												occassionid		= '$occassionid',
												userId			= '$userId'";
									
  		 	  mysql_query($insQry)or die (mysql_error());
			  $_SESSION['delivery_id']['New'] = mysql_insert_id();
			  } else {
   			  $insUpd ="update ".tbl_delivery." set cash_amount = '$cash_amounts',
			  									recp_first_name		= '$first_name',
			 									recp_last_name 		= '$last_name',
												recp_email 		= '$email',
												occassionid		= '$occassionid',
												userId			= '$userId'
												where
												delivery_id= '$delivery_id'";
									
  		 mysql_query($insUpd)or die (mysql_error());
		 }
		unset($_SESSION['biz_rec_err']);
		unset($_SESSION['biz_rec']);
		//$_SESSION['biz_rec_err']['Recp_edit'] = 'Recipient Info successfully updated!';
		header('location:'.ru.'delivery_detail'); exit;
  }
  
}

//////////////////////////////////////NOTIFY DATETIME/////////////////////////////////////////////////
if (isset($_POST['Notify'])){ 

     	unset($_SESSION['biz_not_err']);
	    unset($_SESSION['biz_not']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_not'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name validation////////	
	$cash_amounts = str_replace('$','',$cash_amount);
	if($cash_amounts==''){
		$_SESSION['biz_not_err']['cash_amount'] = 'Please enter cash gift';
		$flgs = true;
	
	} else if(!is_numeric($cash_amounts)) {
		$_SESSION['biz_not_err']['cash_amount'] = 'Please enter Numeric value';
		$flgs = true;
	}
	
	if($notification==''){
		$_SESSION['biz_not_err']['notification'] = 'Select an option in the section "When should we NOTIFY them about this iftGift?"';
		$flgs = true;
	
	} else if($notification=='1') {
		if($day=='')
		{
			$_SESSION['biz_not_err']['day'] = 'Please enter day';
			$flgs = true;
		}
		if($month=='')
		{
			$_SESSION['biz_not_err']['month'] = 'Please enter month';
			$flgs = true;
		}
		if($year=='')
		{
			$_SESSION['biz_not_err']['year'] = 'Please enter year';
			$flgs = true;
		}
		
		if($hour=='')
		{
			$_SESSION['biz_not_err']['hour'] = 'Please enter hour';
			$flgs = true;
		}
		if($minute=='')
		{
			$_SESSION['biz_not_err']['minute'] = 'Please enter minute';
			$flgs = true;
		}
		if($sec=='')
		{
			$_SESSION['biz_not_err']['sec'] = 'Please enter AM/PM';
			$flgs = true;
		}
	} else if($notification=='2') {
		if($day1=='')
		{
			$_SESSION['biz_not_err']['day1'] = 'Please enter day';
			$flgs = true;
		}
		if($month1=='')
		{
			$_SESSION['biz_not_err']['month1'] = 'Please enter month';
			$flgs = true;
		}
		if($year1=='')
		{
			$_SESSION['biz_not_err']['year1'] = 'Please enter year';
			$flgs = true;
		}
		
		if($hours=='')
		{
			$_SESSION['biz_not_err']['hours'] = 'Please enter hour';
			$flgs = true;
		}
		if($minutes=='')
		{
			$_SESSION['biz_not_err']['minutes'] = 'Please enter minute';
			$flgs = true;
		}
		if($secs=='')
		{
			$_SESSION['biz_not_err']['secs'] = 'Please enter AM/PM';
			$flgs = true;
		}
	}	
	
	if($notification=='1') {
	$immediately = $notification;
	$ndate = $day.'-'.$month.'-'.$year;
	$ntime = $hour.':'.$minute.' '.$sec;
	
	$utime =  convert_unixdatetime($ndate,$ntime);
	
	} else if($notification=='2') {
	$future = $notification;
	$ndate = $day1.'-'.$month1.'-'.$year1;
	$ntime = $hours.':'.$minutes.' '.$sec;
	
	$utime =  convert_unixdatetime($ndate,$ntime);
	
	}
	 
  if($flgs)
  {
	
		header('location:'.ru.'notify_datetime'); exit;
		
  }else{
			  $chkQry = mysql_query("select * from ".tbl_delivery." where delivery_id = '".$delivery_id."'");
			  if(mysql_num_rows($chkQry) == 0) {
			  $insQry ="insert into ".tbl_delivery." set cash_amount = '$cash_amounts',
			  									notification		= '$Notify',
			 									immediately 		= '$immediately',
												future 		= '$future',
												date 		= '$ndate',
												time		= '$ntime',
												idate_time  = '$utime',
												userId			= '$userId'";
			  mysql_query($insQry)or die (mysql_error());
			  $_SESSION['delivery_id']['New'] = mysql_insert_id();									
			  } else {
   			  $insUpd ="update ".tbl_delivery." set cash_amount = '$cash_amounts',
			  									notification		= '$Notify',
			 									immediately 		= '$immediately',
												future 		= '$future',
												date 		= '$ndate',
												time		= '$ntime',
												idate_time  = '$utime',
												userId			= '$userId'
												where
												delivery_id= '$delivery_id'";
			  	
  		 	mysql_query($insUpd)or die (mysql_error());
		 	}
		unset($_SESSION['biz_not_err']);
		unset($_SESSION['biz_not']);
		//$_SESSION['biz_rec_err']['Recp_edit'] = 'Recipient Info successfully updated!';
		header('location:'.ru.'delivery_detail'); exit;
  }
  
}



//////////////////////////////////////UNLOCK DATETIME/////////////////////////////////////////////////
if (isset($_POST['Unlock'])){ 

     	unset($_SESSION['biz_unl_err']);
	    unset($_SESSION['biz_unl']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_unl'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name validation////////	
	$cash_amounts = str_replace('$','',$cash_amount);
	if($cash_amounts==''){
		$_SESSION['biz_unl_err']['cash_amount'] = 'Please enter cash gift';
		$flgs = true;
	
	} else if(!is_numeric($cash_amounts)) {
		$_SESSION['biz_unl_err']['cash_amount'] = 'Please enter Numeric value';
		$flgs = true;
	}
	
	if($unlock==''){
		$_SESSION['biz_unl_err']['unlock'] = 'Select an option in the section "When should we NOTIFY them about this iftGift?"';
		$flgs = true;
	
	} else if($unlock=='1') {
		if($day=='')
		{
			$_SESSION['biz_unl_err']['day'] = 'Please enter day';
			$flgs = true;
		}
		if($month=='')
		{
			$_SESSION['biz_unl_err']['month'] = 'Please enter month';
			$flgs = true;
		}
		if($year=='')
		{
			$_SESSION['biz_unl_err']['year'] = 'Please enter year';
			$flgs = true;
		}
		
		if($hour=='')
		{
			$_SESSION['biz_unl_err']['hour'] = 'Please enter hour';
			$flgs = true;
		}
		if($minute=='')
		{
			$_SESSION['biz_unl_err']['minute'] = 'Please enter minute';
			$flgs = true;
		}
		if($sec=='')
		{
			$_SESSION['biz_unl_err']['sec'] = 'Please enter AM/PM';
			$flgs = true;
		}
	} else if($unlock=='2') {
		if($day1=='')
		{
			$_SESSION['biz_unl_err']['day1'] = 'Please enter day';
			$flgs = true;
		}
		if($month1=='')
		{
			$_SESSION['biz_unl_err']['month1'] = 'Please enter month';
			$flgs = true;
		}
		if($year1=='')
		{
			$_SESSION['biz_unl_err']['year1'] = 'Please enter year';
			$flgs = true;
		}
		
		if($hours=='')
		{
			$_SESSION['biz_unl_err']['hours'] = 'Please enter hour';
			$flgs = true;
		}
		if($minutes=='')
		{
			$_SESSION['biz_unl_err']['minutes'] = 'Please enter minute';
			$flgs = true;
		}
		if($secs=='')
		{
			$_SESSION['biz_unl_err']['secs'] = 'Please enter AM/PM';
			$flgs = true;
		}
	}	
	
	if($unlock=='1') {
	$immediately = $unlock;
	$ndate = $day.'-'.$month.'-'.$year;
	$ntime = $hour.':'.$minute.' '.$sec;
	
	$utime =  convert_unixdatetime($ndate,$ntime);
	
	} else if($unlock=='2') {
	$future = $unlock;
	$ndate = $day1.'-'.$month1.'-'.$year1;
	$ntime = $hours.':'.$minutes.' '.$secs;
	
	$utime =  convert_unixdatetime($ndate,$ntime);
	
	}
	  
  if($flgs)
  {
	
		header('location:'.ru.'unlock_datetime'); exit;
		
  }else{
			  $chkQry = mysql_query("select * from ".tbl_delivery." where delivery_id = '".$delivery_id."'");
			  if(mysql_num_rows($chkQry) == 0) {
			  $insQry ="insert into ".tbl_delivery." set cash_amount = '$cash_amounts',
			  									unlocks		= '$Unlock',
			 									unlock_immediately 		= '$immediately',
												unlock_future 		= '$future',
												unlock_date 		= '$ndate',
												unlock_time		= '$ntime',
												fdate_time		= '$utime',
												unlock_status	= '1',
												userId			= '$userId'";
  		 	  mysql_query($insQry)or die (mysql_error());
			  $_SESSION['delivery_id']['New'] = mysql_insert_id();
			  } else {
   			  $insUpd ="update ".tbl_delivery." set cash_amount = '$cash_amounts',
			  									unlocks		= '$Unlock',
			 									unlock_immediately 		= '$immediately',
												unlock_future 		= '$future',
												unlock_date 		= '$ndate',
												unlock_time		= '$ntime',
												fdate_time		= '$utime',
												unlock_status	= '1',
												userId			= '$userId'
												where
												delivery_id= '$delivery_id'";
  		 	mysql_query($insUpd)or die (mysql_error());
		  	}
		unset($_SESSION['biz_unl_err']);
		unset($_SESSION['biz_unl']);
		//$_SESSION['biz_rec_err']['Recp_edit'] = 'Recipient Info successfully updated!';
		header('location:'.ru.'delivery_detail'); exit;
  }
  
}


//////////////////////////////////////IMAGE CAPTION/////////////////////////////////////////////////
if (isset($_POST['Caption'])){ 

	$delivery_id = $_POST['delivery_id'];
	$uId 		 = $_POST['userId'];
	$proId		 = $_POST['proId'];
	$cap		 = $_POST['img_caption'];
  	
	foreach ($proId as $index => $value1) {
     	$value2 = $cap[$index];
	 	$value1 = $proId[$index];
    	$pro[] = array('proid' => "$value1" ,'caption' => "$value2");
	}
	
		$json = json_encode($pro);
		//echo '<pre>';print_r($json);exit;
		$chkQry = mysql_query("select * from ".tbl_delivery." where delivery_id = '".$delivery_id."'");
		if(mysql_num_rows($chkQry) == 0) {
		$insQry ="insert into ".tbl_delivery." set 	proid			= '".mysql_real_escape_string(stripslashes(trim($json)))."',
												userId			= '$uId'";
  		 mysql_query($insQry)or die (mysql_error());
		 $_SESSION['delivery_id']['New'] = mysql_insert_id();
		} else {
   		$insUpd ="update ".tbl_delivery." set 	proid			= '".mysql_real_escape_string(stripslashes(trim($json)))."',
												userId			= '$uId'
												where
												delivery_id= '$delivery_id'";
  		 mysql_query($insUpd)or die (mysql_error());
		} 
		header('location:'.ru.'delivery_detail'); exit;
 
  
}


//////////////////////////////////////ADD NOTES/////////////////////////////////////////////////
if (isset($_POST['Notes'])){ 

     	unset($_SESSION['biz_note_err']);
	    unset($_SESSION['biz_note']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_note'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name validation////////	
	$cash_amounts = str_replace('$','',$cash_amount);
	if($cash_amounts==''){
		$_SESSION['biz_note_err']['cash_amount'] = 'Please enter cash gift';
		$flgs = true;
	
	} else if(!is_numeric($cash_amounts)) {
		$_SESSION['biz_note_err']['cash_amount'] = 'Please enter Numeric value';
		$flgs = true;
	}
	
  if($flgs)
  {
	
		header('location:'.ru.'personal_notes'); exit;
		
  }else{
			  $chkQry = mysql_query("select * from ".tbl_delivery." where delivery_id = '".$delivery_id."'");
		      if(mysql_num_rows($chkQry) == 0) {
			  $insQry ="insert into ".tbl_delivery." set cash_amount = '$cash_amounts',
			  									notes			= '$notes',
												dated			= now()";
  		 	  mysql_query($insQry)or die (mysql_error());
			  } else {
   			  $insUpd ="update ".tbl_delivery." set cash_amount = '$cash_amounts',
			  									notes			= '$notes',
												dated			= now()
												where
												delivery_id= '$delivery_id'";
  		 	 mysql_query($insUpd)or die (mysql_error());
		 	}
		unset($_SESSION['biz_note_err']);
		unset($_SESSION['biz_note']);
		//$_SESSION['biz_rec_err']['Recp_edit'] = 'Recipient Info successfully updated!';
		header('location:'.ru.'delivery_detail'); exit;
  }
  
}

//////////////////////////////////////SEND GIFT/////////////////////////////////////////////////
if (isset($_POST['SendGift'])){ 

     	unset($_SESSION['biz_gift_err']);
	    unset($_SESSION['biz_gift']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_gift'][$k]=$v;
	}
  	$flgs = false;


	if($checkout_method==''){
		$_SESSION['biz_gift_err']['checkout_method'] = 'Select Method for Transfer Funds';
		$flgs = true;
	
	} 
	
	if($checkout_method == 'credit_card') {
		if($cardnumber != ''){
			$match_card = mysql_query("select memberID,card_number from ".tbl_member_card." where card_number = '".encrypt($cardnumber)."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'");
			if(mysql_num_rows($match_card) > 0) {
			 	$get_card = mysql_fetch_array($match_card);
			 	$get_card_num = decrypt($get_card['card_number']);
			 	if($cardnumber == $get_card_num) {
			 		$_SESSION['biz_gift_err']['cardnumber'] = 'This card number already Exists.Please check exsiting crads.';
					$flgs = true;
			 	}
			}
		}
	}
	
  if($flgs)
  {
	
		header('location:'.ru.'checkout'); exit;
		
  }else{
  		
		$chk_card = @mysql_fetch_array(mysql_query("select payment_method,memberID from ".tbl_member_card." where memberID = '".$checkout_method."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'"));
		$checkout_methods = $chk_card['payment_method'];
		$memberID = $chk_card['memberID'];
  	
		if($checkout_method == 'credit_card' || $checkout_methods == 'credit_card') {
			include('../../stripe/lib/Stripe.php');
			Stripe::setApiKey("sk_test_hf7OqosaMYdhpJbE5s8yi5WI");	
			$amount = $total_cash;
	 		$charge=Stripe_Charge::create(array("amount" => $amount*100,
                                "currency" => "usd",
								"card" => $_POST['stripeToken'],
								"description" => $email));		
			//echo '<pre>';print_r($charge);exit;
			
			if($charge->paid == '1') {
				
				$collect_card_info = @mysql_fetch_array(mysql_query("select card_number from ".tbl_member_card." where memberID = '".$memberID."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'"));
				$card_number = decrypt($collect_card_info['card_number']);
				if($cardnumber == $card_number)
				{
					$member_card_info = mysql_query("update ".tbl_member_card." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($charge->card->exp_month)."', expiry_year = '".encrypt($charge->card->exp_year)."', card_type = '".encrypt($charge->card->brand)."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$charge->card->address_line1."', address2 = '".$charge->card->address_line2."', state = '".$state."', city = '".$charge->card->address_city."', zip = '".$charge->card->address_zip."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', payment_method = '".$checkout_methods."', dated = now() where memberID = '".$memberID."'");
				
				 	$query = mysql_query("insert into ".tbl_payment." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($charge->card->exp_month)."', expiry_year = '".encrypt($charge->card->exp_year)."', card_type = '".encrypt($charge->card->brand)."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$charge->card->address_line1."', address2 = '".$charge->card->address_line2."', state = '".$state."', city = '".$charge->card->address_city."', zip = '".$charge->card->address_zip."', userId = '".$userId."', transactionID = '".$charge->id."', ip = '".$_SERVER['REMOTE_ADDR']."', total_price = '$".$amount."', commission = '$".$calculate_tax."', netamount = '$".$cash_gift."', payment_method = '".$checkout_methods."', dated = now()");
				} else {	
				$member_card_info = mysql_query("insert into ".tbl_member_card." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($charge->card->exp_month)."', expiry_year = '".encrypt($charge->card->exp_year)."', card_type = '".encrypt($charge->card->brand)."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$charge->card->address_line1."', address2 = '".$charge->card->address_line2."', state = '".$state."', city = '".$charge->card->address_city."', zip = '".$charge->card->address_zip."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', payment_method = '".$checkout_method."', dated = now()");
				
				$query = mysql_query("insert into ".tbl_payment." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($charge->card->exp_month)."', expiry_year = '".encrypt($charge->card->exp_year)."', card_type = '".encrypt($charge->card->brand)."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$charge->card->address_line1."', address2 = '".$charge->card->address_line2."', state = '".$state."', city = '".$charge->card->address_city."', zip = '".$charge->card->address_zip."', userId = '".$userId."', transactionID = '".$charge->id."', ip = '".$_SERVER['REMOTE_ADDR']."', total_price = '$".$amount."', commission = '$".$calculate_tax."', netamount = '$".$cash_gift."', payment_method = '".$checkout_method."', dated = now()");
				} 
				$insQry ="insert into ".tbl_checkout." set delivery_id	= '".$delivery_id."',
			  									cash_gift 		= '".$cash_gift."',
			  									total_cash		= '".$total_cash."',
												userId			= '".$userId."',
												payment_method  = '".$checkout_method."',
												commission		= '".$calculate_tax."',
												ip				= '".$_SERVER['REMOTE_ADDR']."',
												dated			= now()";
  		 		$query = mysql_query($insQry)or die (mysql_error());
				if($query) {
					$check_points = "select * from ".tbl_userpoints." where userId = '".$userId."'";
					$view_points = $db->get_row($check_points,ARRAY_A);
					$points = $view_points['points'];
					$new_points = $points + 75;
					if($view_points) {
						$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$userId."'");
					} else {
						$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '75',userId = '".$userId."'");
					}	
				}	
			}
		} else if($checkout_method == 'cash_stash') { 
			$insQry ="insert into ".tbl_checkout." set delivery_id	= '".$delivery_id."',
			  									cash_gift 		= '".$cash_gift."',
			  									total_cash		= '".$total_cash."',
												userId			= '".$userId."',
												payment_method  = '".$checkout_method."',
												commission		= '".$calculate_tax."',
												ip				= '".$_SERVER['REMOTE_ADDR']."',
												dated			= now()";
  		 	$query = mysql_query($insQry)or die (mysql_error());
		 
		 	if($query)
		 	{
				$get_user = "select available_cash,first_name,email from ".tbl_user." where userId = '".$userId."'";
				$view_user = $db->get_row($get_user,ARRAY_A);
				$sfirst_name = $view_user['first_name'];
				$available_cash = $view_user['available_cash'] - $total_cash;
				$update = mysql_query("update ".tbl_user." set available_cash = '".$available_cash."' where userId = '".$userId."'");
			
				$check_points = "select * from ".tbl_userpoints." where userId = '".$userId."'";
				$view_points = $db->get_row($check_points,ARRAY_A);
				$points = $view_points['points'];
				$new_points = $points + 75;
				if($view_points) {
					$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$userId."'");
				} else {
					$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '75',userId = '".$userId."'");
				}		
		 	}
		} 
		 
		unset($_SESSION['biz_gift_err']);
		unset($_SESSION['biz_gift']);
		unset($_SESSION['products']);
		//$_SESSION['biz_rec_err']['Recp_edit'] = 'Recipient Info successfully updated!';
		header('location:'.ru.'confirmation'); exit;
  }
  
}


//////////////////////////////////////CANCEL GIFT/////////////////////////////////////////////////

if($_GET['dId'])
{
	$delivery_id = $_GET['dId'];
	
	$del = mysql_query("delete from ".tbl_delivery." where delivery_id = '".$delivery_id."'");
	unset($_SESSION['delivery_id']['New']);
	unset($_SESSION['products']);
	if($del)
	{
		echo "Success";
	}
}



?>