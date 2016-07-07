<?php
 if(isset($_SESSION['delivery_id']['New'])) {
 $get_delivery = "select * from ".tbl_delivery." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and  delivery_id  = '".$_SESSION['delivery_id']['New']."'";
 $dev_rs  = $db->get_row($get_delivery,ARRAY_A);
 $first_name = $dev_rs['recp_first_name'];
 $last_name = $dev_rs['recp_last_name'];
 $cash_amount = $dev_rs['cash_amount'];
 
 $checkout = "select * from ".tbl_checkout." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and delivery_id = '".$_SESSION['delivery_id']['New']."'";
 $checkout_rs  = $db->get_row($checkout,ARRAY_A);
 $total_cash = $checkout_rs['total_cash'];
 
 $recipient = "select * from ".tbl_recipient." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and recipit_id = '".$_SESSION['recipit_id']['New']."'";
 $recipient_rs  = $db->get_row($recipient,ARRAY_A);
 
 $get_occasion = "select * from ".tbl_occasion." where occasionid = '".$recipient_rs['ocassion']."'";
 $occs_rs  = $db->get_row($get_occasion,ARRAY_A);
 } else if(isset($_SESSION['cart'])) {
 	include_once("process/cart_functions.php");
 	$total_cash = get_order_total();
 }
?>
	<div role="main" class="ui-content jqm-content jqm-content-c">
		<p>You will receive an email confirmation shortly. <a href="javascript:;" onclick="printArea();">Print order details</a></p>
		<div id="print_area">
		<?php if(isset($_SESSION['delivery_id']['New'])) { ?>
		<div class="ui-field-contain field">
			<label for="textinput-1">iftGift Recipient</label>
			<input name="textinput-1" id="textinput-1" placeholder="<?php echo $first_name; ?>" value="<?php echo ucfirst($first_name.'&nbsp;'.$last_name); ?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Occasion</label>
			<input name="textinput-1" id="textinput-1" placeholder="<?php echo $occs_rs['occasion_name'];?>" value="<?php echo $occs_rs['occasion_name'];?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Notification Email date and time</label>
			<?php $timestamps = strtotime($dev_rs['date']);
				  $notify_date = date('M d, Y', $timestamps);?>
			<input name="textinput-1" id="textinput-1" placeholder="<?php echo $dev_rs['date']; ?>" value="<?php echo $notify_date.'&nbsp;@&nbsp;'.$dev_rs['time']; ?>" type="text">
		</div>
		
		<div class="ui-field-contain field">
			<label for="textinput-1">Unlock Notification Email date and time</label>
			<?php $timestamp = strtotime($dev_rs['unlock_date']);
				  $unblock_date = date('M d, Y', $timestamp);?>
			<input name="textinput-1" id="textinput-1" placeholder="<?php echo $dev_rs['unlock_date']; ?>" value="<?php echo $unblock_date.'&nbsp;@&nbsp;'.$dev_rs['unlock_time']; ?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Total cash gift sent</label>
			<input name="textinput-1" id="textinput-1" placeholder="<?php echo $cash_amount; ?>" value="$<?php echo $cash_amount; ?>" type="text">
		</div>
		<?php } ?>
		<div class="ui-field-contain field">
			<label for="textinput-1">Total cost</label>
			<input name="textinput-1" id="textinput-1" placeholder="$<?php echo $total_cash; ?>" value="$<?php echo $total_cash; ?>" type="text">
		</div>
		</div>
		<img src="<?php echo ru_resource;?>images/jester_d.jpg" alt="Jester Image" />
	</div><!-- /content -->
	
<script language="javascript" type="text/javascript" >	
function printArea(){
	jQuery("#print_area").printArea();
}
</script>	

<?php 
unset($_SESSION['delivery_id']['New']);
unset($_SESSION['recipit_id']['New']);
unset($_SESSION['cart']);	  
?>