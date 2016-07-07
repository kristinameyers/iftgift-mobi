<?php
include_once("../connect/connect.php");
include_once("../config/config.php");

$method = $_GET['method'];
if($method == 'withdraw') {
?>
			<div class="ui-field-contain field">
				Enter Amount <input type="text" name="amount" id="amount" /> USD
			</div>
			<div class="ui-field-contain field">
				<label for="textinput-1">Total Deposit</label>
				<input type="text" name="total_deposit" id="total_deposit" />
			</div>
			<a href="javascript:;" onclick="Transfer_Cash()" class="ui-btn ui-btn-c">Complete Transaction</a>
<?php } else if($method == 'deposit') { ?>
			<div class="ui-field-contain field">
				Enter Amount Here <input type="text" name="amount" id="amount" /> USD
			</div>
			...AND take from your bank account
			<div class="ui-field-contain ui-field-contain-b ui-field-2">
				<fieldset data-role="controlgroup" data-mini="true">
					<input name="payment_method" class="method" id="radio-choice-v-5a" value="bank" type="radio" /><label for="radio-choice-v-5a"> Bank Account </label>
				</fieldset>
			</div>
			<div id="bank_account" style="display:none;">
				<div class="ui-field-contain field">	
					<input type="text" name="routing_number" id="routing_number" placeholder="Routing Number" />
				</div>
				<div class="ui-field-contain field">	
					<input type="text" name="account_number" id="account_number" placeholder="Account Number" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">First Name *</label> 
					<input type="text" name="first_name" id="first_name" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">Last Name *</label> 
					<input type="text" name="last_name" id="last_name" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">Address 1 *</label> 
					<input type="text" name="address1" id="address1" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">Address 2</label> 
					<input type="text" name="address2" id="address2" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">City *</label> 
					<input type="text" name="city" id="city" />
				</div>
				<div class="ui-field-contain field select_fleid">
					<label for="select-native-1">State * </label>
					<select name="state" id="select-native-1">
					<option>Select State</option>
					<?php foreach($StateAbArray as $key => $val) { ?>
						<option value="<?php echo $key;?>" <?php if($_SESSION['biz_rep']['location'] == $key) echo 'selected="selected"'; ?>><?php echo $val;?></option>
					<?php } ?>	
					</select>
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">Zip Code *</label> 
					<input type="text" name="zip_code" id="zip_code" />
				</div>
			</div>		
			...OR take from your credit card
			<div class="ui-field-contain ui-field-contain-b ui-field-2">
				<fieldset data-role="controlgroup" data-mini="true">
					<input name="payment_method" class="method" id="radio-choice-v-5a" value="credit_card" type="radio" /><label for="radio-choice-v-5a"> Credit Card </label>
				</fieldset>	
			</div>	
			<div id="credit_card" style="display:none;">
				<div class="ui-field-contain field">	
					<input type="text" name="cc_number" id="cc_number" placeholder="Credit Card Number" />
				</div>
				<div class="ui-field-contain field">	
					<input type="text" name="digit_pin" id="digit_pin" placeholder="3 Digit PIN" />
				</div>
				<div class="ui-field-contain field">	
					<input type="text" name="month" id="month" placeholder="Month" />
				</div>
				<div class="ui-field-contain field">	
					<input type="text" name="year" id="year" placeholder="Year" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">First Name *</label> 
					<input type="text" name="first_name" id="first_name" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">Last Name *</label> 
					<input type="text" name="last_name" id="last_name" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">Address 1 *</label> 
					<input type="text" name="address1" id="address1" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">Address 2</label> 
					<input type="text" name="address2" id="address2" />
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">City *</label> 
					<input type="text" name="city" id="city" />
				</div>
				<div class="ui-field-contain field select_fleid">
					<label for="select-native-1">State * </label>
					<select name="state" id="select-native-1">
					<option>Select State</option>
					<?php foreach($StateAbArray as $key => $val) { ?>
						<option value="<?php echo $key;?>" <?php if($_SESSION['biz_rep']['location'] == $key) echo 'selected="selected"'; ?>><?php echo $val;?></option>
					<?php } ?>	
					</select>
				</div>
				<div class="ui-field-contain field">	
					<label for="textinput-1">Zip Code *</label> 
					<input type="text" name="zip_code" id="zip_code" />
				</div>
			</div>
			<div class="ui-field-contain field">	
				<label for="textinput-1">Total Deposit</label> 
				<input type="text" name="total_deposit" id="total_deposit" />
			</div>
			<a href="javascript:;" onclick="Transfer_Cash()" class="ui-btn ui-btn-c">Complete Transaction</a>
<?php } ?>		
<script type="text/javascript">
$(function () {
	$('.method').click(function () {
		var method = this.value;
		if(method == 'bank') {
			$('#credit_card').hide();
			$('#bank_account').show();
		} else {
			$('#bank_account').hide();
			$('#credit_card').show();
		}
	});
})

function Transfer_Cash(){
		document.getElementById("transfer_cash").submit()	
	}
</script>