<?php
 $get_cuser = $db->get_row("select available_cash,party_mode from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'",ARRAY_A);
 $available_cash = $get_cuser['available_cash'];
?>
<style>
.ui-page .jqm-content a.ui-btn-b, .jqm-content button.ui-btn, .btn-success{background:url("resource/images/btnc_bg.jpg") repeat-x 0 0;font-size:13px;padding: 0 1em 1em;margin: 0 auto;width: 55%;}
.has-error .help-block, .has-error .control-label, .has-error .radio, .has-error .checkbox, .has-error .radio-inline, .has-error .checkbox-inline{color:#a94442}
</style>
<script type="text/javascript">
function copy_amount() {
	var amount =  document.getElementById('amount').value;
	if(amount != '') {
	var calculate_tax = Number(amount) / 100 * 6.00;
	document.getElementById('calculate_tax').value="$"+calculate_tax.toFixed(2);
	var add_tax_amount = Number(amount) + Number(calculate_tax);
	var total_amount = add_tax_amount.toFixed(2);
	document.getElementById('total_amount').value="$"+total_amount;
	}
}
</script>	
<div class="sugg_top sugg_top_b">
		<h2>Cash Stash</h2>
	</div>
	<?php if(isset($_SESSION['biz_withdraw_err']['withdrawcashstash'])) { ?>
	<span style="color:#FF0000; font-weight:bold; float:left; width:100%; margin-left:10px;"><?php echo $_SESSION['biz_withdraw_err']['withdrawcashstash'];?></span>	
	<?php } ?>
	<div class="option"><a href="<?php echo ru;?>transfercashstash" data-ajax="false">Back To Transfer Option</a></div>
	<div role="main" class="ui-content jqm-content jqm-content-c" onclick="copy_amount();">
		<div class="cash_count">
			<div class="cash_count_left">
				<span>Cash^Stash<br/>Balance</span>
				<img src="<?php echo ru_resource; ?>images/down_arrow_cs.png" />
			</div>
			<div class="cash_count_right">
				<h3>$<?php echo $available_cash;?></h3>
			</div>
		</div>
		<a href="#" class="ui-btn cash_button deposite_b">Withdraw <b>FROM</b> Cash Stash <img src="<?php echo ru_resource;?>images/icon_downc.png" /></a>	
		<?php
			$get_user = "select email from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'";
			$view_user = $db->get_row($get_user,ARRAY_A);
		?>
		<form id="payment-form" data-ajax="false" class="form-horizontal" method="post" action="<?php echo ru;?>process/process_withdrawcash.php">
		<input name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" type="hidden">
		<input name="calculate_tax" id="calculate_tax" value="" type="hidden">
		<input name="WithdrawCash" id="WithdrawCash" value="1" type="hidden">
			<div class="deposite_cash">
				<div class="form-group">
					<div class="ui-field-contain field gift">
						<label for="textinput-1">Enter Amount</label>
						<input type="text" name="amount" id="amount" value="<?php echo $_SESSION['biz_withdraw']['amount'];?>" placeholder="Amount" class="amount form-control" />
						<p>USD</p>
						<span style="color:#a94442; float:left; width:100%"><?php echo $_SESSION['biz_withdraw_err']['amount'];?></span>
					</div>
				</div>
			<?php $payment_setting = mysql_fetch_array(mysql_query("select * from ".tbl_payment_setting.""));
				  if($payment_setting['payment_option'] == '1')
				  {
			?>		
			<h5>...AND send to bank account</h5>
			<span style="color:#a94442; float:left; width:100%"><?php echo $_SESSION['biz_withdraw_err']['checkout_method'];?></span>
			<?php
				$get_ach = $db->get_results("select ach_number,acchID from ".tbl_achnumber." where userId = '".$_SESSION['LOGINDATA']['USERID']."'",ARRAY_A);
			?>
			<div class="ui-field-contain">
			<?php 
			if($get_ach) {
			foreach($get_ach as $card) {
			$ach_num = decrypt($card['ach_number']);
			$last_four_digits = substr("$ach_num", -4);
			$masked = "xxxxxxxx-".$last_four_digits;
			?>
            	<fieldset data-role="controlgroup">
					<input name="checkout_method" id="radio-choice-v-1b" value="<?php echo $card['acchID']; ?>" <?php if($_SESSION['biz_withdraw']['checkout_method'] == $card['acchID']) echo 'checked="checked"'; ?>  type="radio">
                    <label for="radio-choice-v-1b">Use account <?php  echo $masked; ?></label>
				</fieldset>
			<?php } } ?>		
                <fieldset data-role="controlgroup">
					<input name="checkout_method" id="radio-choice-v-1a" value="bank_account" <?php if($_SESSION['biz_withdraw']['checkout_method'] == 'bank_account') echo 'checked="checked"'; ?> type="radio">
                    <label for="radio-choice-v-1a">Enter New Bank Account</label>
				</fieldset>
			</div>
            <div id="account-nmbr" <?php if($_SESSION['biz_withdraw']['checkout_method'] == 'bank_account') { } else { ?> style="display:none"<?php } ?>>
                <div id="test">
					<div class="ui-field-contain field gift">
                   	 	<input name="routing_number" id="routing_number" autocomplete="off" maxlength="16" placeholder="Routing Number" type="text">
						<span id="error" style="color:#a94442; float:left; width:100%"><?php echo $_SESSION['biz_withdraw_err']['routing_number'];?></span>
					</div>
					<div class="ui-field-contain field gift">
                    	<input name="account_number" id="account_number" autocomplete="off" maxlength="16" placeholder="Account Number" type="text">
						<span id="error" style="color:#a94442; float:left; width:100%"><?php echo $_SESSION['biz_withdraw_err']['account_number'];?></span>
					</div>
                </div>
				<div id="test1" style="display:none">
					<div class="ui-field-contain field gift">
						<input type="text" id="routing_numbers" autocomplete="off" maxlength="16" placeholder="Routing Number">
					</div>
					<div class="ui-field-contain field gift">
						<input type="text" id="account_numbers" autocomplete="off" maxlength="16" placeholder="Account Number">
					</div>
				</div>
            </div>
			<h5>...OR send to credit card</h5>
			 <?php
				$get_card = $db->get_results("select card_number,memberID from ".tbl_member_card." where userId = '".$_SESSION['LOGINDATA']['USERID']."'",ARRAY_A);
			?>
			<div class="ui-field-contain">
			<?php 
			if($get_card) {
			foreach($get_card as $card) {
			$card_num = decrypt($card['card_number']);
			$last_four_digits = substr("$card_num", -4);
			$masked = "xxxx-xxxx-xxxx-".$last_four_digits;
			?>
            	<fieldset data-role="controlgroup">
					<input name="checkout_method" id="radio-choice-v-1c" value="<?php echo $card['memberID']; ?>" type="radio">
					<label for="radio-choice-v-1c">Use account <?php  echo $masked; ?></label>
				</fieldset>
				
			<?php } } ?>	
                <fieldset data-role="controlgroup">
					<input name="checkout_method" id="radio-choice-v-1d" value="credit_card" <?php if($_SESSION['biz_withdraw']['checkout_method'] == 'credit_card') echo 'checked="checked"'; ?> type="radio">
					<label for="radio-choice-v-1d">Enter New Credit Card</label>
				</fieldset>
        </div>
        <div class="credit_card_deposit">
            <a href="#"><img src="<?php echo ru_resource;?>images/card_a.jpg" alt="Visa Card" /></a>
            <a href="#"><img src="<?php echo ru_resource;?>images/card_b.jpg" alt="Master Card" /></a>
            <a href="#"><img src="<?php echo ru_resource;?>images/card_c.jpg" alt="American Express Card" /></a>
            <a href="#"><img src="<?php echo ru_resource;?>images/card_d.jpg" alt="Discover Network Card" /></a>
      	</div>
		<div id="credit-card" <?php if($_SESSION['biz_withdraw']['checkout_method'] == 'credit_card') { } else { ?>style="display:none"<?php } ?>>
				<div class="ui-field-contain field" id="original_val">
					<input type="text" id="cardnumber" name="cardnumber" autocomplete="off" maxlength="16" placeholder="Card Number" value="<?php echo $_SESSION['biz_withdraw']['cardnumber']; ?>">
					<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['cardnumber'];?></span>
				</div>
				<div class="ui-field-contain field" id="dumy_val" style="display:none">
					<input type="text" id="cardnumbers" name="cardnumbers" maxlength="16" autocomplete="off" placeholder="Card Number">
				</div>
				<div class="ui-field-contain field">
					<input type="text" id="cvv" name="cvv" autocomplete="off" placeholder="3 Digit PIN" maxlength="4" value="<?php echo $_SESSION['biz_withdraw']['cvv']; ?>">
					<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['cvv'];?></span>
				</div>
				<div class="ui-field-contain field">
						<input type="text" name="month" id="month" maxlength="2" autocomplete="off" data-stripe="exp-month" placeholder="Month" value="<?php echo $_SESSION['biz_withdraw']['month']; ?>">
						<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['month'];?>
				</div>
			<span style="float:none"> / </span>
				<div class="ui-field-contain field">
						<input type="text" name="year" id="year" autocomplete="off" data-stripe="exp-year" placeholder="Year" value="<?php echo $_SESSION['biz_withdraw']['year']; ?>">
						<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['year'];?>
					</div>
			<h3><strong>Your Billing Address</strong></h3>
			
				<div class="ui-field-contain field">
					<input type="text" name="fname" id="fname" maxlength="65" placeholder="First Name" value="<?php echo $_SESSION['biz_withdraw']['fname']; ?>">
					<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['fname'];?>
				</div>
			
			
				<div class="ui-field-contain field">
					<input type="text" name="lname" id="lname" maxlength="65" placeholder="Last Name" value="<?php echo $_SESSION['biz_withdraw']['lname']; ?>">
					<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['lname'];?>
				</div>
			
			
				<div class="ui-field-contain field">
					<input type="text" name="address1" id="address1" placeholder="Address 1" value="<?php echo $_SESSION['biz_withdraw']['address1']; ?>">
					<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['address1'];?>
				</div>
			
			
				<div class="ui-field-contain field">
					<input type="text" name="address2" id="address2" placeholder="Address 2" value="<?php echo $_SESSION['biz_withdraw']['address2']; ?>">
				</div>
			
			
				<div class="ui-field-contain field">
					<input type="text" name="city" id="city" placeholder="City" value="<?php echo $_SESSION['biz_withdraw']['city']; ?>">
					<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['city'];?>
				</div>
			
			
				<div class="ui-field-contain field select_fleid">
					<label for="textinput-1">State *</label>
					<select name="state" id="select-native-1">
						<option>Select State</option>
						<?php foreach($StateAbArray as $key => $val) { ?>
						<option value="<?php echo $key;?>" <?php if($_SESSION['biz_withdraw']['state'] == $key) echo 'selected="selected"'; ?>><?php echo $val;?></option>
						<?php } ?>	
					</select>
					<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['state'];?>
				</div>
			
			
				<div class="ui-field-contain field">
					<input type="text" name="zip" id="zip" maxlength="9" placeholder="Postal Code" value="<?php echo $_SESSION['biz_withdraw']['zip']; ?>">
					<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_withdraw_err']['zip'];?>
				</div>
			
        </div>
		<?php } ?>
        <div class="total-deposit">
        	<label for="textinput-1">Total Deposit</label>
        	
            <div class="calculate">
        		<input type="text" name="total_amount" id="total_amount" placeholder="[calculate total]" value="<?php echo $_SESSION['biz_withdraw']['total_amount']; ?>" class="deposit">
                <h6>Plus 6.0% fee</h6>
            </div>
            
        </div>	
        <?php
		if($payment_setting['payment_option'] == '1') { ?>		
        <button class="btn btn-success" type="submit">Complete Transaction</button>
		<?php } ?>
	</div>
		</form>
		<div class="cancel">
			<a href="<?php echo ru;?>transfercashstash" data-ajax="false">Cancel</a>
		</div>
	</div>
<script type="text/javascript">
$(document).ready(function () {
		$('#radio-choice-v-1a,#radio-choice-v-1b').click(function () {
		var pay_method = this.value;
		//alert(pay_method);
		if(pay_method == 'bank_account') {
				document.getElementById('account_number').value='';
				document.getElementById('routing_number').value='';
				$('#test1').hide();
				$('#test').show();
				$('#account-nmbr').show();
				$('#credit-card').hide();
		} else {
			$.ajax({
			url : "<?php echo ru;?>process/get_chechach.php?achid="+pay_method,
			type: "GET",
			dataType:'html',
			success:function(response)
			{
				var array = response.split("=");
				routnumber = array[0];
				var achnumber = array[1];
				//alert(routnumber);
				masked=achnumber;
				last_four_digits = masked.substr(8,4);
				card_number = "xxxxxxxx-"+last_four_digits;
				//alert(card_number);
				document.getElementById('routing_number').value=routnumber;
				document.getElementById('routing_numbers').value=routnumber;
				document.getElementById('account_number').value=masked;
				document.getElementById('account_numbers').value=card_number;
				$('span[id^="error"]').remove();
				$('#test').hide();
				$('#test1').show();
				$('#credit-card').hide();
				$('#account-nmbr').show();
			}
			});	
		}		
		});
	});	
	
$(document).ready(function () {
		$('#radio-choice-v-1c,#radio-choice-v-1d').click(function () {
		var pay_method = this.value;
		//alert(pay_method);
		if(pay_method == 'credit_card') {
				document.getElementById('cardnumber').value='';
				document.getElementById('cvv').value='';
				document.getElementById('month').value='';
				document.getElementById('year').value='';
				document.getElementById('fname').value='';
				document.getElementById('lname').value='';
				document.getElementById('address1').value='';
				document.getElementById('address2').value='';
				document.getElementById('select-native-1').value='';
				document.getElementById('city').value='';
				document.getElementById('zip').value='';
				$('#credit-card').show();
				$('#original_val').show();
				$('#dumy_val').hide();
				$('#account-nmbr').hide();
		} else {
			$.ajax({
			url : "<?php echo ru;?>process/get_checkoutcreditcard.php?card_id="+pay_method,
			type: "GET",
			dataType:'html',
			success:function(response)
			{
				var array = response.split("=");
					masked=array[0];
					last_four_digits = masked.substr(12,4);
					card_number = "xxxx-xxxx-xxxx-"+last_four_digits;
					pin=array[1];
					exp_month=array[2];
					exp_year=array[3];
					card_type=array[4];
					first_name=array[5];
					last_name=array[6];
					address1=array[7];
					address2=array[8];
					state=array[9];
					city=array[10];
					zip=array[11];
				//alert(card_number);
				document.getElementById('cardnumber').value=masked;
				document.getElementById('cardnumbers').value=card_number;
				document.getElementById('cvv').value=pin;
				document.getElementById('month').value=exp_month;
				document.getElementById('year').value=exp_year;
				document.getElementById('fname').value=first_name;
				document.getElementById('lname').value=last_name;
				document.getElementById('address1').value=address1;
				document.getElementById('address2').value=address2;
				document.getElementById('select-native-1').value=state;
				document.getElementById('city').value=city;
				document.getElementById('zip').value=zip;
				$('span[id^="error"]').remove();
				$('#original_val').hide();
				$('#account-nmbr').hide();
				$('#dumy_val').css('display','block');
				$('#credit-card').show();
			}
		});
		}		
		});
	});		
</script>	
<?php
unset($_SESSION['biz_withdraw_err']);
unset($_SESSION['biz_withdraw']);
?>	