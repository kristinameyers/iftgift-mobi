<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
require_once ('../common/function.php');
include_once("cart_functions.php");

unset($_SESSION['biz_suggift_err']);
unset($_SESSION['biz_suggift']);
//echo "<pre>";
//print_r($_POST); exit;
//////////////////////////////////////SEND GIFT/////////////////////////////////////////////////
if (isset($_POST['BuySuggest'])){ 

     	unset($_SESSION['biz_suggift_err']);
	    unset($_SESSION['biz_suggift']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_suggift'][$k]=$v;
	}
  	$flgs = false;
	
	$get_uInfo = $db->get_row("select first_name,last_name,address,phone from ".tbl_user." where userId = '".$userId."'",ARRAY_A);
	
	if($ship_fname==''){
		$_SESSION['biz_suggift_err']['ship_fname'] = 'Enter shipping first name.';
		$flgs = true;
	
	} 
	
	if($ship_lname==''){
		$_SESSION['biz_suggift_err']['ship_lname'] = 'Enter shipping last name.';
		$flgs = true;
	
	} 
	
	if($ship_address1==''){
		$_SESSION['biz_suggift_err']['ship_address1'] = 'Enter shipping address 1.';
		$flgs = true;
	
	} 
	
	if($ship_city==''){
		$_SESSION['biz_suggift_err']['ship_city'] = 'Enter shipping city';
		$flgs = true;
	
	} 
	
	if($ship_state=='' || $ship_state == 'Select State'){
		$_SESSION['biz_suggift_err']['ship_state'] = 'Select shipping state.';
		$flgs = true;
	
	} 
	
	if($ship_zip==''){
		$_SESSION['biz_suggift_err']['ship_zip'] = 'Enter shipping zip code.';
		$flgs = true;
	
	} 
	
	if($checkout_method==''){
		$_SESSION['biz_suggift_err']['checkout_method'] = 'Select Method for Transfer Funds';
		$flgs = true;
	
	} 
	
	if($checkout_method == 'credit_card') {
		if($cardnumber != ''){
			$match_card = mysql_query("select memberID,card_number from ".tbl_member_card." where card_number = '".encrypt($cardnumber)."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'");
			if(mysql_num_rows($match_card) > 0) {
			 	$get_card = mysql_fetch_array($match_card);
			 	$get_card_num = decrypt($get_card['card_number']);
			 	if($cardnumber == $get_card_num) {
			 		$_SESSION['biz_suggift_err']['cardnumber'] = 'This card number already Exists.Please check exsiting crads.';
					$flgs = true;
			 	}
			}
		}
	}
	
  if($flgs)
  {
	
		header('location:'.ru.'checkoutshop'); exit;
		
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
								"description" => $email
				)
			);				
  			//echo '<pre>';print_r($charge);exit;
			if($charge->paid == '1') {
				$collect_card_info = @mysql_fetch_array(mysql_query("select card_number from ".tbl_member_card." where memberID = '".$memberID."' and userId = '".$_SESSION['LOGINDATA']['USERID']."'"));
				$card_number = decrypt($collect_card_info['card_number']);
				if($cardnumber == $card_number)
				{
					$member_card_info = mysql_query("update ".tbl_member_card." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($charge->card->exp_month)."', expiry_year = '".encrypt($charge->card->exp_year)."', card_type = '".encrypt($charge->card->brand)."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$charge->card->address_line1."', address2 = '".$charge->card->address_line2."', state = '".$state."', city = '".$charge->card->address_city."', zip = '".$charge->card->address_zip."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', payment_method = '".$checkout_methods."', dated = now() where memberID = '".$memberID."'");
				} else {
					$member_card_info = mysql_query("insert into ".tbl_member_card." set card_number = '".encrypt($_POST['cardnumber'])."', pin = '".encrypt($_POST['cvv'])."', expiry_month = '".encrypt($charge->card->exp_month)."', expiry_year = '".encrypt($charge->card->exp_year)."', card_type = '".encrypt($charge->card->brand)."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', address1 = '".$charge->card->address_line1."', address2 = '".$charge->card->address_line2."', state = '".$state."', city = '".$charge->card->address_city."', zip = '".$charge->card->address_zip."', userId = '".$userId."', ip = '".$_SERVER['REMOTE_ADDR']."', payment_method = '".$checkout_method."', dated = now()");
				}	
		 		$max=count($_SESSION['cart']);
				$insOrdr = "insert into ".tbl_order." set customerID	= '".$userId."',
			  									num_of_item 		= '".$max."',
			  									net_amount		= '".$net_amount."',
												tax			= '".$calculate_tax."',
												total_cost  = '".$total_cash."',
												ostatus		= 'pending',
												transactionID = '".$charge->id."',
												payment_method = 'credit_card',
												ip = '".$_SERVER['REMOTE_ADDR']."',
												dated		  = now()";
				$query = mysql_query($insOrdr)or die (mysql_error());									
				$orderid=mysql_insert_id();		
				
				$insQry ="insert into ".tbl_shipping_address." set customerID	= '".$userId."',
												orderID			= '".$orderid."',
			  									cus_fname 		= '".$ship_fname."',
			  									cus_lname		= '".$ship_lname."',
												cus_address  = '".$ship_address1."',
												ship_address2 = '".$ship_address2."',
												ship_city = '".$ship_city."',
												ship_state = '".$ship_state."',
												ship_zip	= '".$ship_zip."'";
  		 		$query1 = mysql_query($insQry)or die (mysql_error());
				
				for($i=0;$i<$max;$i++){
				$pid=$_SESSION['cart'][$i]['productid'];
				$q=$_SESSION['cart'][$i]['qty'];
				$price=get_prices($pid);
				mysql_query("insert into ".tbl_order_detail." set orderID = '".$orderid."',
											   product_id = '".$pid."',
											   pro_qty    = '".$q."',
											   price	  = '".$price."',
											   dated	  = now()");								   
				}								
			}
		}	else if($checkout_method == 'cash_stash') {
				
				$max=count($_SESSION['cart']);
				$insOrdr = "insert into ".tbl_order." set customerID	= '".$userId."',
			  									num_of_item 		= '".$max."',
			  									net_amount		= '".$net_amount."',
												tax			= '".$calculate_tax."',
												total_cost  = '".$total_cash."',
												ostatus		= 'pending',
												payment_method = '".$checkout_method."',
												ip = '".$_SERVER['REMOTE_ADDR']."',
												dated		  = now()";
				$query = mysql_query($insOrdr)or die (mysql_error());									
				$orderid=mysql_insert_id();		
				
				$insQry ="insert into ".tbl_shipping_address." set customerID	= '".$userId."',
												orderID			= '".$orderid."',
			  									cus_fname 		= '".$ship_fname."',
			  									cus_lname		= '".$ship_lname."',
												cus_address  = '".$ship_address1."',
												ship_address2 = '".$ship_address2."',
												ship_city = '".$ship_city."',
												ship_state = '".$ship_state."',
												ship_zip	= '".$ship_zip."'";
  		 		$query1 = mysql_query($insQry)or die (mysql_error());
				
				for($i=0;$i<$max;$i++){
				$pid=$_SESSION['cart'][$i]['productid'];
				$q=$_SESSION['cart'][$i]['qty'];
				$price=get_prices($pid);
				mysql_query("insert into ".tbl_order_detail." set orderID = '".$orderid."',
											   product_id = '".$pid."',
											   pro_qty    = '".$q."',
											   price	  = '".$price."',
											   dated	  = now()");								   
				}	
				
				if($query1)
		 		{
					$get_user = "select available_cash,first_name,email from ".tbl_user." where userId = '".$userId."'";
					$view_user = $db->get_row($get_user,ARRAY_A);
					$sfirst_name = $view_user['first_name'];
					$available_cash = $view_user['available_cash'] - $total_cash;
					$update = mysql_query("update ".tbl_user." set available_cash = '".$available_cash."' where userId = '".$userId."'");	
		 		}							
				
			}
		
		/*******************************************START SEND MAIL OF ORDER PROCESS [For User]*****************************************************************/
			$to = $email;
			$subject="[iftGift] iftGift Order Processing!";
			$from = "Info@iftgift.com";
			$headers  = 'From: '.$from. "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message	= '<div style="width:630px;border:#c5c4c4 2px solid;  margin:0 auto;background-color:#f6f0fa; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#000;">
  				<div style="border:#ede2f5 thin solid; ">
    				<div style="height:764px;font-size:15px !important; line-height:0.95">
    					<img src="'.ru_resource.'images/header-email-new.png" alt="iftgift" />
    					<div style="padding-left: 13px; padding-top: 15px;">
      						<div style="-moz-border-radius:6px;-webkit-border-radius:6px;background: #fff;margin-top: 20px;border: 1px solid #cccccc;width: 602px;padding-top: 15px;height: 632px;" >';
								for($i=0;$i<$max;$i++){
								$pid=$_SESSION['cart'][$i]['productid'];
								$pro_name=get_product_name($pid);
								$price=get_prices($pid);
								$message	.='<p style="margin-left:10px;"><strong>Product Name</strong> : '.$pro_name.'</p>
									<p style="margin-left:10px;"><strong>Product Price</strong> : $'.$price.'</p>';
								}	
      							$message .='<center><p style="font-weight: bold">Your Order is Still Under Processing.We will Come Back to You Soon.</p>
        									<p></p></center>
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
        				Copyright © 2011, 2012, 2013 Morris Fritz Friedman · All Rights Reserved · iftGift</p>
      					<p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        				Please do not reply to this message.</p>
      					<p><a style="color: #726f6f;font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
  				</center>
  				<div style=" height:250px;"></div>
			</div>';
			//echo $message;exit;
			$mailsent = mail($to,$subject,$message,$headers);
		/*******************************************END SEND MAIL OF ORDER PROCESS {For User}*****************************************************************/		
					 
		unset($_SESSION['biz_suggift_err']);
		unset($_SESSION['biz_suggift']);
		//unset($_SESSION['cart']);
		header('location:'.ru.'confirmation'); exit;
  }
  
}
?>