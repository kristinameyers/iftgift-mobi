<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
require_once ('../common/function.php');

unset($_SESSION['biz_giv_err']);
unset($_SESSION['biz_giv']);
echo "<pre>";
print_r($_POST); exit;

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
			include('../stripe/lib/Stripe.php');
			Stripe::setApiKey("sk_test_5mQN7bLY41wsXW0x1rwj5QGZ");
			$customer = Stripe_Customer::create(array("card" => $_POST['stripeToken'],
 	 		"description" => $email));	
			
			$amount = $total_cash;
	 		$charge=Stripe_Charge::create(array("amount" => $amount*100,
                                "currency" => "usd",
								"customer" => $customer->id));		
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