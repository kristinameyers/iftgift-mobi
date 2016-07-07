<?php
 $get_cuser = $db->get_row("select available_cash,party_mode from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'",ARRAY_A);
 $available_cash = $get_cuser['available_cash'];
?>
<style>
.ui-page .jqm-content a.ui-btn-b, .jqm-content button.ui-btn, .btn-success{background:url("resource/images/btnc_bg.jpg") repeat-x 0 0;font-size:13px;padding: 0 1em 1em;margin: 0 auto;width: 55%;}
.has-error .help-block, .has-error .control-label, .has-error .radio, .has-error .checkbox, .has-error .radio-inline, .has-error .checkbox-inline{color:#a94442}
</style>
<script>
$(document).ready(function(){
  $("#radio-choice-v-1a,#radio-choice-v-1b,#radio-choice-v-1c").click(function(){
  	var transfer_cash = this.value;
	if(transfer_cash == 'bank_account') {
		$('#account-nmbr').show();
		$('#credit-card').hide();
	} else if(transfer_cash == 'credit_card') {
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
		$('#test').show();
		$('#test1').hide();
		$('#account-nmbr').hide();
	} else {
		$.ajax({
			url : "<?php echo ru;?>process/get_checkoutcreditcard.php?card_id="+transfer_cash,
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
				$('#test').hide();
				$('#test1').show();
				$('#credit-card').show();
				$('#account-nmbr').hide();
			}
		});
	}
  });
});
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="<?php echo ru_resource; ?>bootstrap_js/bootstrap-min.js"></script>
<script src="<?php echo ru_resource; ?>bootstrap_js/bootstrap-formhelpers-min.js"></script>
<script type="text/javascript" src="<?php echo ru_resource; ?>bootstrap_js/bootstrapValidator-min.js"></script>	
<script type="text/javascript">
$(document).ready(function() {
    $('#payment-form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            //valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		submitHandler: function(validator, form, submitButton) {
                    //var chargeAmount = 3000; //amount you want to charge, in cents. 1000 = $10.00, 2000 = $20.00 ...
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val(),
						name: $('.fname').val()+" "+$('.lname').val(),
						address_line1: $('.address').val(),
						address_line2: $('.address2').val(),
						address_city: $('.city').val(),
						address_zip: $('.zip').val(),
						address_state: $('.state').val()
                    }, stripeResponseHandler);
                    return false; // submit from callback
        },
        fields: {
			amount: {
                validators: {
                    notEmpty: {
                        message: 'The Amount is required and cannot be empty'
                    },
					digits: {
                        message: 'The Amount can contain digits only'
                    }
                }
            },
			cardnumber: {
		selector: '#cardnumber',
                validators: {
                    notEmpty: {
                        message: 'The credit card number is required and can\'t be empty'
                    },
					creditCard: {
						message: 'The credit card number is invalid'
					},
                }
            },
			cvv: {
		selector: '#cvv',
                validators: {
                    notEmpty: {
                        message: 'The cvv is required and can\'t be empty'
                    },
					cvv: {
                        message: 'The value is not a valid CVV',
                        creditCardField: 'cardnumber'
                    }
                }
            },
			expMonth: {
                selector: '[data-stripe="exp-month"]',
                validators: {
                    notEmpty: {
                        message: 'The expiration month is required'
                    },
                    digits: {
                        message: 'The expiration month can contain digits only'
                    },
                    callback: {
                        message: 'Expired',
                        callback: function(value, validator) {
                            value = parseInt(value, 10);
                            var year         = validator.getFieldElements('expYear').val(),
                                currentMonth = new Date().getMonth() + 1,
                                currentYear  = new Date().getFullYear();
                            if (value < 0 || value > 12) {
                                return false;
                            }
                            if (year == '') {
                                return true;
                            }
                            year = parseInt(year, 10);
                            if (year > currentYear || (year == currentYear && value > currentMonth)) {
                                validator.updateStatus('expYear', 'VALID');
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
            expYear: {
                selector: '[data-stripe="exp-year"]',
                validators: {
                    notEmpty: {
                        message: 'The expiration year is required'
                    },
                    digits: {
                        message: 'The expiration year can contain digits only'
                    },
                    callback: {
                        message: 'Expired',
                        callback: function(value, validator) {
                            value = parseInt(value, 10);
                            var month        = validator.getFieldElements('expMonth').val(),
                                currentMonth = new Date().getMonth() + 1,
                                currentYear  = new Date().getFullYear();
                            if (value < currentYear || value > currentYear + 100) {
                                return false;
                            }
                            if (month == '') {
                                return false;
                            }
                            month = parseInt(month, 10);
                            if (value > currentYear || (value == currentYear && month > currentMonth)) {
                                validator.updateStatus('expMonth', 'VALID');
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
			fname: {
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    }
                }
            },
			lname: {
                validators: {
                    notEmpty: {
                        message: 'The Last Name is required and cannot be empty'
                    }
                }
            },
            address1: {
                validators: {
                    notEmpty: {
                        message: 'The Address 1 is required and cannot be empty'
                    },
					stringLength: {
                        min: 6,
                        max: 96,
                        message: 'The Address 1 must be more than 6 and less than 96 characters long'
                    }
                }
            },
            city: {
                validators: {
                    notEmpty: {
                        message: 'The city is required and cannot be empty'
                    }
                }
            },
			state: {
                validators: {
                    notEmpty: {
                        message: 'The state is required and cannot be empty'
                    }
                }
            },
			zip: {
                validators: {
                    notEmpty: {
                        message: 'The zip is required and cannot be empty'
                    },
					stringLength: {
                        min: 3,
                        max: 9,
                        message: 'The zip must be more than 3 and less than 9 characters long'
                    },
					digits: {
                        message: 'The Zip Code can contain digits only'
                    }
                }
            },
        }
    });
});
</script>
<script type="text/javascript">
            // this identifies your website in the createToken call below
            Stripe.setPublishableKey('pk_test_Ir5dMFev812wsnO2YahXMUDz');
 
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
					// show hidden div
					//document.getElementById('a_x200').style.display = 'block';
                    // show the errors on the form
                    //$(".payment-errors").html(response.error.message);
                } else {
					
                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }
 
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
	<?php if(isset($_SESSION['biz_deposit_err']['depositcashstash'])) { ?>
	<span style="color:#FF0000; font-weight:bold; float:left; width:100%; margin-left:10px;"><?php echo $_SESSION['biz_deposit_err']['depositcashstash'];?></span>	
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
		<a href="#" class="ui-btn cash_button deposite_b">Deposit <b>INTO</b> Cash Stash <img src="<?php echo ru_resource;?>images/icon_downc.png" /></a>
		<?php
			$get_user = "select email from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'";
			$view_user = $db->get_row($get_user,ARRAY_A);
		?>
		<form id="payment-form" data-ajax="false" class="form-horizontal" method="post" action="<?php echo ru;?>process/process_depositcash.php">
		<input name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" type="hidden">
		<input name="email" id="email" value="<?php echo $view_user['email'];?>" type="hidden">
		<input name="calculate_tax" id="calculate_tax" value="" type="hidden">
		<input name="DepositCash" id="DepositCash" value="1" type="hidden">
			<div class="deposite_cash">
				<div class="form-group">
					<div class="ui-field-contain field gift">
						<label for="textinput-1">Enter Amount</label>
						<input name="amount" id="amount" placeholder="Amount" class="amount form-control" value="<?php echo $_SESSION['biz_deposit']['amount']; ?>" onClick="event.stopPropagation()" type="text">
						<p>USD</p>
					</div>
				</div>
			<?php $payment_setting = mysql_fetch_array(mysql_query("select * from ".tbl_payment_setting.""));
				  if($payment_setting['payment_option'] == '1')
				  {
			?>	
			<h5>...AND take from bank account</h5>
			<div class="ui-field-contain">
            	<!--<fieldset data-role="controlgroup">
					<input name="radio-choice-v-1" id="radio-choice-v-1a" value="on" checked="checked" type="radio">
                    <label for="radio-choice-v-1a">Use account xxxxxx-6754</label>
				</fieldset>-->
                <fieldset data-role="controlgroup">
					<input name="checkout_method" id="radio-choice-v-1a" value="bank_account" type="radio">
                    <label for="radio-choice-v-1a">Enter New Bank Account</label>
				</fieldset>
			</div>
            <div id="account-nmbr" style="display:none">
			 Coming Soon
                <?php /*?><div class="ui-field-contain field gift">
                    <input name="routing_number" id="textinput-1" placeholder="Routing Number" value="" type="text">
                    <input name="account_number" id="textinput-1" placeholder="Account Number" value="" type="text">
                </div><?php */?>
            </div>
			<h5>...OR take from credit card</h5>
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
					<input name="checkout_method" id="radio-choice-v-1b" value="credit_card" <?php if($_SESSION['biz_deposit']['checkout_method'] == 'credit_card') echo 'checked="checked"'; ?> type="radio">
					<label for="radio-choice-v-1b">Enter New Credit Card</label>
				</fieldset>
        </div>
        <div class="credit_card_deposit">
            <a href="#"><img src="<?php echo ru_resource;?>images/card_a.jpg" alt="Visa Card" /></a>
            <a href="#"><img src="<?php echo ru_resource;?>images/card_b.jpg" alt="Master Card" /></a>
            <a href="#"><img src="<?php echo ru_resource;?>images/card_c.jpg" alt="American Express Card" /></a>
            <a href="#"><img src="<?php echo ru_resource;?>images/card_d.jpg" alt="Discover Network Card" /></a>
      	</div>
        <div id="credit-card" <?php if($_SESSION['biz_deposit_err'] != '') { } else { ?>style="display:none"<?php } ?>>
			<div class="form-group">
				<div class="ui-field-contain field" id="test">
					<input type="text" id="cardnumber" name="cardnumber" autocomplete="off" maxlength="19" placeholder="Card Number" class="card-number form-control">
					<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_deposit_err']['cardnumber'];?></span>
				</div>
				<div class="ui-field-contain field" id="test1" style="display:none">
					<input type="text" id="cardnumbers" maxlength="19" autocomplete="off" placeholder="Card Numbersssssss">
				</div>
			</div>
			<div class="form-group">
				<div class="ui-field-contain field">
					<input type="text" id="cvv" name="cvv" autocomplete="off" placeholder="3 Digit PIN" maxlength="3" class="card-cvc form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="ui-field-contain field">
					<div class="form-inline">
						<input type="text" id="month" maxlength="2" autocomplete="off" data-stripe="exp-month" placeholder="Month" class="card-expiry-month stripe-sensitive required form-control">
					</div>
				</div>
			</div>		
			<span style="float:none"> / </span>
			<div class="form-group">
				<div class="ui-field-contain field">
					<div class="form-inline">			
						<input type="text" name="year" id="year" autocomplete="off" data-stripe="exp-year" placeholder="Year" class="card-expiry-year stripe-sensitive required form-control">
					</div>
				</div>
			</div>
			<h3><strong>Your Billing Address</strong></h3>
			<div class="form-group">
				<div class="ui-field-contain field">
					<input type="text" name="fname" id="fname" maxlength="65" placeholder="First Name" value="<?php echo $_SESSION['biz_deposit']['fname']; ?>" class="fname form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="ui-field-contain field">
					<input type="text" name="lname" id="lname" maxlength="65" placeholder="Last Name" value="<?php echo $_SESSION['biz_deposit']['lname']; ?>" class="lname form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="ui-field-contain field">
					<input type="text" name="address1" id="address1" placeholder="Address 1" value="<?php echo $_SESSION['biz_deposit']['address1']; ?>" class="address form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="ui-field-contain field">
					<input type="text" name="address2" id="address2" placeholder="Address 2" value="<?php echo $_SESSION['biz_deposit']['address2']; ?>" class="address2 form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="ui-field-contain field">
					<input type="text" name="city" id="city" placeholder="City" value="<?php echo $_SESSION['biz_deposit']['city']; ?>" class="city form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="ui-field-contain field select_fleid">
					<label for="textinput-1">State *</label>
					<select name="state" class="state form-control" id="select-native-1">
						<option>Select State</option>
						<?php foreach($StateAbArray as $key => $val) { ?>
						<option value="<?php echo $key;?>" <?php if($_SESSION['biz_deposit']['state'] == $key) echo 'selected="selected"'; ?>><?php echo $val;?></option>
						<?php } ?>	
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="ui-field-contain field">
					<input type="text" name="zip" id="zip" maxlength="9" placeholder="Postal Code" value="<?php echo $_SESSION['biz_deposit']['zip']; ?>" class="zip form-control">
				</div>
			</div>
        </div>
		<?php } ?>
        <div class="total-deposit">
        	<label for="textinput-1">Total Deposit</label>
        	
            <div class="calculate">
        		<input type="text" name="total_amount" id="total_amount" placeholder="[calculate total]" value="<?php echo $_SESSION['biz_deposit']['total_amount']; ?>" class="deposit">
                <h6>Plus 6.0% fee</h6>
            </div>
            
        </div>
		<?php if($payment_setting['payment_option'] == '1') { ?>		
        <button class="btn btn-success" type="submit">Complete Transaction</button>
		<?php } ?>
	</div>
		</form>
		<div class="cancel">
			<a href="<?php echo ru;?>transfercashstash" data-ajax="false">Cancel</a>
		</div>
	</div>
<?php
unset($_SESSION['biz_deposit_err']);
unset($_SESSION['biz_deposit']);
?>	