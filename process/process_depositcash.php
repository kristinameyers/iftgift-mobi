<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
require_once ('../common/function.php');

unset($_SESSION['biz_deposit_err']);
unset($_SESSION['biz_deposit']);
//echo "<pre>";
//print_r($_POST); exit;


//////////////////////////////////////SEND GIFT/////////////////////////////////////////////////
if (isset($_POST['DepositCash'])){ 

     	unset($_SESSION['biz_deposit_err']);
	    unset($_SESSION['biz_deposit']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_deposit'][$k]=$v;
	}
  	$flgs = false;

	
	if($checkout_method==''){
		$_SESSION['biz_deposit_err']['checkout_method'] = 'Payment method not selected.';
		$flgs = true;
	
	} 
	
	if($checkout_method == 'credit_card') {
		if($cardnumber != ''){
			$match_card = mysql_query("select memberID,card_number from ".tbl_member_card." where card_number = '".encrypt($cardnumber)."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'");
			if(mysql_num_rows($match_card) > 0) {
			 	$get_card = mysql_fetch_array($match_card);
			 	$get_card_num = decrypt($get_card['card_number']);
			 	if($cardnumber == $get_card_num) {
			 		$_SESSION['biz_deposit_err']['cardnumber'] = 'This card number already Exists.Please check exsiting crads.';
					$flgs = true;
			 	}
			}
		}
	}
	
  if($flgs)
  {
	
		header('location:'.ru.'deposit_cashstash'); exit;
		
  }else{
  		$chk_card = @mysql_fetch_array(mysql_query("select payment_method,memberID from ".tbl_member_card." where memberID = '".$checkout_method."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'"));
		$checkout_methods = $chk_card['payment_method'];
		$memberID = $chk_card['memberID'];
  	
		if($checkout_method == 'credit_card' || $checkout_methods == 'credit_card') {
		
			include('../../stripe/lib/Stripe.php');
			Stripe::setApiKey("sk_test_hf7OqosaMYdhpJbE5s8yi5WI");
			$amounts = str_replace('$','',$total_amount);
	 		$charge=Stripe_Charge::create(array("amount" => $amounts*100,
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
				
					$query = mysql_query("insert into ".tbl_depositcash." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($charge->card->exp_month)."', expiry_year = '".encrypt($charge->card->exp_year)."', card_type = '".encrypt($charge->card->brand)."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$charge->card->address_line1."', address2 = '".$charge->card->address_line2."', state = '".$state."', city = '".$charge->card->address_city."', zip = '".$charge->card->address_zip."', userId = '".$userId."', transactionID = '".$charge->id."', ip = '".$_SERVER['REMOTE_ADDR']."', total_price = '$".$amounts."', commission = '".$calculate_tax."', netamount = '$".$amount."', payment_method = '".$checkout_methods."', dated = now()");
				} else {
				
				 	$member_card_info = mysql_query("insert into ".tbl_member_card." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($charge->card->exp_month)."', expiry_year = '".encrypt($charge->card->exp_year)."', card_type = '".encrypt($charge->card->brand)."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$charge->card->address_line1."', address2 = '".$charge->card->address_line2."', state = '".$state."', city = '".$charge->card->address_city."', zip = '".$charge->card->address_zip."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', payment_method = '".$checkout_method."', dated = now()");
					
					 $query = mysql_query("insert into ".tbl_depositcash." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($charge->card->exp_month)."', expiry_year = '".encrypt($charge->card->exp_year)."', card_type = '".encrypt($charge->card->brand)."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$charge->card->address_line1."', address2 = '".$charge->card->address_line2."', state = '".$state."', city = '".$charge->card->address_city."', zip = '".$charge->card->address_zip."', userId = '".$userId."', transactionID = '".$charge->id."', ip = '".$_SERVER['REMOTE_ADDR']."', total_price = '$".$amounts."', commission = '".$calculate_tax."', netamount = '$".$amount."', payment_method = '".$checkout_method."', dated = now()");
				
				}
				if($query)
				{
					$get_user = mysql_fetch_array(mysql_query("select userId,available_cash from ".tbl_user." where userId = '".$userId."'"));
					$available_cash = $get_user['available_cash'];
					$netamount = str_replace('$','',$amount);
					$new_cash = $available_cash + $netamount;
					$updt_cash = mysql_query("update ".tbl_user." set available_cash = '".$new_cash."' where userId = '".$userId."'");
				}
			}
		} 
		 
		unset($_SESSION['biz_deposit_err']);
		unset($_SESSION['biz_deposit']);
		$_SESSION['biz_deposit_err']['depositcashstash'] = 'Your Transaction Successfully!';
		header('location:'.ru.'deposit_cashstash'); exit;
  }
  
}
?>