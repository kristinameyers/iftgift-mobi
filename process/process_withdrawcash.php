<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
require_once("../common/function.php");

unset($_SESSION['biz_withdraw_err']);
unset($_SESSION['biz_withdraw']);
//echo "<pre>";
//print_r($_POST); //exit;


//////////////////////////////////////SEND GIFT/////////////////////////////////////////////////
if (isset($_POST['WithdrawCash'])){ 

     	unset($_SESSION['biz_withdraw_err']);
	    unset($_SESSION['biz_withdraw']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_withdraw'][$k]=$v;
	}
  	$flgs = false;
	
	if($amount==''){
		$_SESSION['biz_withdraw_err']['amount'] = 'Please enter payment amount.';
		$flgs = true;
	
	} 
	
	if($checkout_method==''){
		$_SESSION['biz_withdraw_err']['checkout_method'] = 'Payment method not selected.';
		$flgs = true;
	
	} 
	
	if($checkout_method == 'bank_account') {
		
		if($routing_number==''){
			$_SESSION['biz_withdraw_err']['routing_number'] = 'Please enter routing number.';
			$flgs = true;
		}  
	
		if($account_number==''){
			$_SESSION['biz_withdraw_err']['account_number'] = 'Please enter bank account number.';
			$flgs = true;
		}
		
		if($account_number != '' && strlen($account_number) < 12 || strlen($account_number) > 16) {
			$_SESSION['biz_withdraw_err']['account_number'] = 'Your account number is incorrect';
			$flgs = true;
		}
		  
		if($account_number != ''){
			if(preg_match('/^\d+$/',$account_number)) {
				$match_card = mysql_query("select acchID,ach_number from ".tbl_achnumber." where ach_number = '".encrypt($account_number)."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'");
				if(mysql_num_rows($match_card) > 0) {
			 		$get_card = mysql_fetch_array($match_card);
			 		$get_card_num = decrypt($get_card['ach_number']);
			 		if($account_number == $get_card_num) {
			 			$_SESSION['biz_withdraw_err']['account_number'] = 'This account number already Exists.Please check exsiting accounts.';
						$flgs = true;
			 		}
				}
			} else {
				$_SESSION['biz_withdraw_err']['account_number'] = 'Account number contains only digits.';
					$flgs = true;
			}
		}
		if($routing_number != ''){
			if(!preg_match('/^\d+$/',$routing_number)) {
				$_SESSION['biz_withdraw_err']['routing_number'] = 'Routing number contains only digits.';
				$flgs = true;
			}
		}  
	}
	
	if($checkout_method == 'credit_card') {
		$current_month=date("m");
		$current_year=date("Y");
		
		if($cardnumber == '') {
			$_SESSION['biz_withdraw_err']['cardnumber'] = 'Please enter credit card number.';
			$flgs = true;
		}
		
		if($cardnumber != '' && strlen($cardnumber) < 12 || strlen($cardnumber) > 16) {
			$_SESSION['biz_withdraw_err']['cardnumber'] = 'Your credit card information is incorrect';
			$flgs = true;
		}
		
		if($cardnumber != '') {
			if(preg_match('/^\d+$/',$cardnumber)) {
				$match_card = mysql_query("select memberID,card_number from ".tbl_member_card." where card_number = '".encrypt($cardnumber)."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'");
				if(mysql_num_rows($match_card) > 0) {
			 		$get_card = mysql_fetch_array($match_card);
			 		$get_card_num = decrypt($get_card['card_number']);
			 		if($cardnumber == $get_card_num) {
			 			$_SESSION['biz_withdraw_err']['cardnumber'] = 'This card number already Exists.Please check exsiting crads.';
						$flgs = true;
			 		}
				}
			} else {
				$_SESSION['biz_withdraw_err']['cardnumber'] = 'Card number contains only digits.';
				$flgs = true;
			}
		}
		
		if($cvv == '') {
			$_SESSION['biz_withdraw_err']['cvv'] = 'Please enter cvv.';
			$flgs = true;
		}
		
		if($month == '') {
			$_SESSION['biz_withdraw_err']['month'] = 'Please enter expiry Month.';
			$flgs = true;
		}
		
		if($year == '') {
			$_SESSION['biz_withdraw_err']['year'] = 'Please enter expiry Year.';
			$flgs = true;
		}
		
		if($month != '' && $year != '') {
			if($month >= $current_month && $year >= $current_year || $month < $current_month && $year > $current_year) {
				
			} else {
				$_SESSION['biz_withdraw_err']['year'] = 'your expiry month or year is invalid.';
				$flgs = true;
			}
		}
		
		if($fname == '') {
			$_SESSION['biz_withdraw_err']['fname'] = 'Please enter first name.';
			$flgs = true;
		}
		
		if($lname == '') {
			$_SESSION['biz_withdraw_err']['lname'] = 'Please enter last name.';
			$flgs = true;
		}
		
		if($address1 == '') {
			$_SESSION['biz_withdraw_err']['address1'] = 'Please enter address.';
			$flgs = true;
		}
		
		if($city == '') {
			$_SESSION['biz_withdraw_err']['city'] = 'Please enter city.';
			$flgs = true;
		}
		
		if($state == '' || $state == 'Select State') {
			$_SESSION['biz_withdraw_err']['state'] = 'Please select state.';
			$flgs = true;
		}
		
		if($zip == '') {
			$_SESSION['biz_withdraw_err']['zip'] = 'Please enter zip code.';
			$flgs = true;
		}
	}
	
  if($flgs)
  {
		header('location:'.ru.'withdraw_cashstash'); exit;
		
  }else{
  		$chk_ach = @mysql_fetch_array(mysql_query("select ach_number,acchID from ".tbl_achnumber." where acchID = '".$checkout_method."' and ach_number = '".encrypt($account_number)."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'"));
		
		$chk_card = @mysql_fetch_array(mysql_query("select payment_method,memberID from ".tbl_member_card." where memberID = '".$checkout_method."' and card_number = '".encrypt($cardnumber)."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'"));
	
		if($chk_ach != '') {
			$acchID = $chk_ach['acchID'];
			$collect_card_info = @mysql_fetch_array(mysql_query("select ach_number from ".tbl_achnumber." where acchID = '".$acchID."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'"));	
			$ach_number = decrypt($collect_card_info['ach_number']);
			
			if($account_number == $ach_number)
			{
				$member_ach = mysql_query("update ".tbl_achnumber." set routing_number = '".encrypt($_POST['routing_number'])."', ach_number = '".encrypt($_POST['account_number'])."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."',  dated = now() where acchID = '".$acchID."'");
				
			} 
		} else {
		if($checkout_method == 'bank_account') {	
			$member_ach = mysql_query("insert into ".tbl_achnumber." set routing_number = '".encrypt($_POST['routing_number'])."', ach_number = '".encrypt($_POST['account_number'])."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', dated = now()");
			
		}
	  }	
		if($member_ach) { 
					 $query = mysql_query("insert into ".tbl_withdrawcash." set routing_number = '".encrypt($_POST['routing_number'])."', ach_number = '".encrypt($_POST['account_number'])."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', total_price = '".$total_amount."', commission = '".$calculate_tax."', netamount = '$".$amount."',wstatus = 'pending',payment_method = 'bank_account', dated = now()");
				
					$get_user = mysql_fetch_array(mysql_query("select userId,available_cash,email,first_name,last_name from ".tbl_user." where userId = '".$userId."'"));
					$available_cash = $get_user['available_cash'];
					$netamount = str_replace('$','',$total_amount);
					$new_cash = $available_cash - $netamount;
					$updt_cash = mysql_query("update ".tbl_user." set available_cash = '".$new_cash."' where userId = '".$userId."'");
				}
				
		if($chk_card != ''){
			$checkout_methods = $chk_card['payment_method'];
			$memberID = $chk_card['memberID'];
			$collect_card_info = @mysql_fetch_array(mysql_query("select card_number from ".tbl_member_card." where memberID = '".$memberID."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'"));
			$card_number = decrypt($collect_card_info['card_number']);
			if($checkout_methods == 'credit_card') {
				if($cardnumber == $card_number)
				{
					$member_card_info = mysql_query("update ".tbl_member_card." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($_POST['month'])."', expiry_year = '".encrypt($_POST['year'])."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$_POST['address1']."', address2 = '".$_POST['address2']."', state = '".$state."', city = '".$_POST['city']."', zip = '".$_POST['zip']."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', payment_method = '".$checkout_methods."', dated = now() where memberID = '".$memberID."'");
				}
			}	
		} else {
				if($checkout_method == 'credit_card') {
			 		$member_card_info = mysql_query("insert into ".tbl_member_card." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($_POST['month'])."', expiry_year = '".encrypt($_POST['year'])."', fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$_POST['address1']."', address2 = '".$_POST['address2']."', state = '".$state."', city = '".$_POST['city']."', zip = '".$_POST['zip']."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', payment_method = '".$checkout_method."', dated = now()");
		}
	}
		if($checkout_method == 'credit_card' || $checkout_methods == 'credit_card') {
		if($member_card_info) { 
					 $query = mysql_query("insert into ".tbl_withdrawcash." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($_POST['month'])."', expiry_year = '".encrypt($_POST['year'])."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', total_price = '".$total_amount."', commission = '".$calculate_tax."', netamount = '$".$amount."',wstatus = 'pending',payment_method = 'credit_card', dated = now()");
				
					$get_user = mysql_fetch_array(mysql_query("select userId,available_cash,email,first_name,last_name from ".tbl_user." where userId = '".$userId."'"));
					$available_cash = $get_user['available_cash'];
					$netamount = str_replace('$','',$total_amount);
					$new_cash = $available_cash - $netamount;
					$updt_cash = mysql_query("update ".tbl_user." set available_cash = '".$new_cash."' where userId = '".$userId."'");
				}
	}
		
		
		/*******************************************START SEND MAIL OF WITHDRAW CASH [For User]*****************************************************************/
			if($get_user['email'] != '') {
			$to = $get_user['email'];
			$subject="[iftGift] iftGift Withdraw Cash!";
			$from = "Info@iftgift.com";
			$headers  = 'From: '.$from. "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message	= '<div style="width:630px;border:#c5c4c4 2px solid;  margin:0 auto;background-color:#f6f0fa; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#000;">
  				<div style="border:#ede2f5 thin solid; ">
    				<div style="height:764px;font-size:15px !important; line-height:0.95">
    					<img src="'.ru_resource.'images/header-email-new.png" alt="iftgift" />
    					<div style="padding-left: 13px; padding-top: 15px;">
      						<div style="-moz-border-radius:6px;-webkit-border-radius:6px;background: #fff;margin-top: 20px;border: 1px solid #cccccc;width: 602px;padding-top: 15px;height: 632px;" >
									<p style="margin-left:10px"><strong>Cash Amount</strong> : '.$total_amount.'</p>
									<p style="margin-left:10px"><strong>Processing Fee</strong> : '.$calculate_tax.'</p>
									<center>
        							<p style="font-weight: bold">Your Cash Withdraw Successfully.Approved From Admin.</p>
        							<p></p>
      							</center>
      						</div>
      					</div>
    				</div>
  				</div>
  				<center>
      				<p>&nbsp;</p>
      					<table style="color:#726f6f;">
      						<tr>
      							<td><a href="#" style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Home</a></td>
      							<td>|</td>
      							<td><a href="whatisiftgift.php"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">What is <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Gift?</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Schedule of <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Points</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">FAQ</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Contact</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Terms</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Privacy</a></td>
     						</tr>
      					</table>
      					<p style="color:#726f6f;">Protected by one or more the following US Patents and Patents Pending: 8,280,825 and 8,589,314.<br />
        				Copyright � 2011, 2012, 2013 Morris Fritz Friedman � All Rights Reserved � iftGift</p>
      					<p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        				Please do not reply to this message.</p>
      					<p><a style="color: #726f6f;font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
  				</center>
  				<div style=" height:250px;"></div>
			</div>';
			//echo $message;exit;
			$mailsent = mail($to,$subject,$message,$headers);
		}	
		/*******************************************END SEND MAIL OF WITHDRAW CASH {For User}*****************************************************************/	
		
		
		/*******************************************START SEND MAIL OF WITHDRAW CASH [For Admin]*****************************************************************/
			$get_admin = mysql_fetch_array(mysql_query("select email from ".tbl_user." where userId = '1' and type = 'a'"));
			if($get_admin != '') {
			$to = $get_admin['email'];
			$subject="[iftGift] iftGift Withdraw Cash!";
			$from = "Info@iftgift.com";
			$headers  = 'From: '.$from. "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message	= '<div style="width:630px;border:#c5c4c4 2px solid;  margin:0 auto;background-color:#f6f0fa; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#000;">
  				<div style="border:#ede2f5 thin solid; ">
    				<div style="height:764px;font-size:15px !important; line-height:0.95">
    					<img src="'.ru_resource.'images/header-email-new.png" alt="iftgift" />
    					<div style="padding-left: 13px; padding-top: 15px;">
      						<div style="-moz-border-radius:6px;-webkit-border-radius:6px;background: #fff;margin-top: 20px;border: 1px solid #cccccc;width: 602px;padding-top: 15px;height: 632px;" >
									<p style="margin-left:10px"><strong>Cash Amount</strong> : '.$total_amount.'</p>
									<p style="margin-left:10px"><strong>Processing Fee</strong> : '.$calculate_tax.'</p>
									<center>
        							<p style="font-weight: bold">You Received Cash Withdraw Request From '.ucfirst($get_user['first_name']).' '.ucfirst($get_user['last_name']).'.</p>
        							<p></p>
      							</center>
      						</div>
      					</div>
    				</div>
  				</div>
  				<center>
      				<p>&nbsp;</p>
      					<table style="color:#726f6f;">
      						<tr>
      							<td><a href="#" style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Home</a></td>
      							<td>|</td>
      							<td><a href="whatisiftgift.php"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">What is <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Gift?</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Schedule of <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Points</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">FAQ</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Contact</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Terms</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Privacy</a></td>
     						</tr>
      					</table>
      					<p style="color:#726f6f;">Protected by one or more the following US Patents and Patents Pending: 8,280,825 and 8,589,314.<br />
        				Copyright � 2011, 2012, 2013 Morris Fritz Friedman � All Rights Reserved � iftGift</p>
      					<p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        				Please do not reply to this message.</p>
      					<p><a style="color: #726f6f;font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
  				</center>
  				<div style=" height:250px;"></div>
			</div>';
			//echo $message;exit;
			$mailsent = mail($to,$subject,$message,$headers);
		}	
		/*******************************************END SEND MAIL OF WITHDRAW CASH {For Admin}*****************************************************************/		
		unset($_SESSION['biz_withdraw_err']);
		unset($_SESSION['biz_withdraw']);
		$_SESSION['biz_withdraw_err']['withdrawcashstash'] = 'Your Cash was Withdrawn Successfully!';
		header('location:'.ru.'withdraw_cashstash'); exit;
  }
  
}
?>