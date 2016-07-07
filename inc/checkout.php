 	<!--<div role="main" class="ui-content jqm-content jqm-content-c ift_block">
		<h4 class="recip delivery">Checkout</h4>
	</div>--><!-- /content -->
	<div role="main" class="ui-content jqm-content jqm-content-c">
		<button class="ui-btn ui-corner-all clnc" onclick="cancel_iftgift('<?php echo $_SESSION['delivery_id']['New']; ?>')">CANCEL IFTGIFT</button>
		<h3 class="total"><div class="value">1</div>Total Purchase</h3>	
		<div class="ui-field-contain field">
			<label for="textinput-1">Cash Gift</label>
			<?php
		 $get_recipit = "select r.first_name,r.last_name,r.recipit_id,r.cash_gift,r.ocassion,o.occasionid,o.occasion_name from ".tbl_recipient." as r left join ".tbl_occasion." as o on r.ocassion=o.occasionid where r.recipit_id = '".$_SESSION['recipit_id']['New']."'";
		 $view = $db->get_row($get_recipit,ARRAY_A);
		?>
			<input name="textinput-1" id="textinput-1" disabled="disabled" placeholder="$<?php echo $view['cash_gift'];?>" value="$<?php echo $view['cash_gift'];?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Cash Transfer Fee (4%)</label>
			<?php
			$calculate_tax = $view['cash_gift'] /100 * 4.00; 
			$add_fee = $view['cash_gift'] + $calculate_tax;
			$get_user = "select available_cash,first_name,email from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'";
			$view_user = $db->get_row($get_user,ARRAY_A);
			$sfirst_name = $view_user['first_name'];
			if($view_user['available_cash'] == '0.00' || $view_user['available_cash'] < '0.00' || $view_user['available_cash'] < $view['cash_gift'])
			{
			$available_cashs = 500;
			$update = mysql_query("update ".tbl_user." set available_cash = '".$available_cashs."' where userId = '".$_SESSION['LOGINDATA']['USERID']."'");
			}	 
			?>
			<input name="textinput-1" id="textinput-1" disabled="disabled" placeholder="$<?php echo number_format($calculate_tax,'2');?>" value="$<?php echo number_format($calculate_tax,'2');?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Total</label>
			<input name="textinput-1" id="textinput-1" disabled="disabled" placeholder="$<?php echo number_format($add_fee,'2');?>" value="$<?php echo number_format($add_fee,'2');?>" type="text">
		</div>
		<h3 class="total tranf"><div class="value">2</div>Transfer Funds From</h3>
		<span style="color:#FF0000; font-weight:bold; float:left; width:100%"><?php echo $_SESSION['biz_gift_err']['checkout_method'];?></span>	
		<div class="ui-field-contain">
			<fieldset data-role="controlgroup">
				<?php
				$get_blance = "select available_cash from ".tbl_user." where userid = '".$_SESSION['LOGINDATA']['USERID']."'";
				$view_blance = $db->get_row($get_blance,ARRAY_A);
				?>
				<form id="payment-form" data-ajax="false" class="form-horizontal" method="post" action="<?php echo ru;?>process/process_delivery.php">
				<input name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" type="hidden">
				<input name="email" id="email" value="<?php echo $view_user['email'];?>" type="hidden">
				<input name="delivery_id" id="delivery_id" value="<?php echo $_SESSION['delivery_id']['New'];?>" type="hidden">
				<input name="total_cash" id="total_cash" value="<?php echo number_format($add_fee,'2');?>" type="hidden">
				<input name="cash_gift" id="cash_gift" value="<?php echo $view['cash_gift'];?>" type="hidden">
				<input name="calculate_tax" id="calculate_tax" value="<?php echo number_format($calculate_tax,'2');?>" type="hidden">
				<input name="SendGift" id="SendGift" value="1" type="hidden">
				<input name="checkout_method" id="radio-choice-v-1a" value="cash_stash" type="radio" <?php if($view_blance['available_cash'] <= 0 ) { ?> onclick="chk_blance();" <?php } ?>>
				<label for="radio-choice-v-1a"><span class="pink">Cash</span> <span class="blue">^</span> <span class="orange">Stash</span>: <strong>$<?php echo $view_blance['available_cash'];?></strong> Balance</label>
				<!--<div class="inactive"><h4>[Inactive - Coming Soon]</h4></div>-->
				
					<?php /*?><img src="<?php echo ru_resource;?>images/disable_icon.png" alt="bank_account" /><?php */?>
					<input name="checkout_method" id="radio-choice-v-1b" value="bank_account" type="radio">
					<label for="radio-choice-v-1b">Bank Account</label>
				
				<!--------------BANK ACCOUNT METHOD START------------>
				<div id="bank_account_form" style="display:none">BANK ACCOUNT</div>
				<!--------------BANK ACCOUNT METHOD END------------>
				<?php
				$get_card = $db->get_results("select card_number,memberID from ".tbl_member_card." where userId = '".$_SESSION['LOGINDATA']['USERID']."'",ARRAY_A); 
				if($get_card) {
				foreach($get_card as $card) {
				$card_num = decrypt($card['card_number']);
				$last_four_digits = substr("$card_num", -4);
				$masked = "xxxx-xxxx-xxxx-".$last_four_digits;
				?><fieldset data-role="controlgroup">
					<input name="checkout_method" id="radio-choice-v-1d" value="<?php echo $card['memberID']; ?>" type="radio">
					<label for="radio-choice-v-1d">Use account <?php  echo $masked; ?></label></fieldset>
				<?php } } ?>	
					<?php /*?><img src="<?php echo ru_resource;?>images/disable_icon.png" alt="credit_card" /><?php */?>
					<input name="checkout_method" id="radio-choice-v-1c" value="credit_card" <?php if($_SESSION['biz_gift']['checkout_method'] == 'credit_card') echo 'checked="checked"'; ?> type="radio">
					<label for="radio-choice-v-1c">Credit Card</label>
				
				<div class="credit_card">
					<a href="#"><img src="<?php echo ru_resource;?>images/card_a.jpg" alt="Visa Card" /></a>
					<a href="#"><img src="<?php echo ru_resource;?>images/card_b.jpg" alt="Master Card" /></a>
					<a href="#"><img src="<?php echo ru_resource;?>images/card_c.jpg" alt="American Express Card" /></a>
					<a href="#"><img src="<?php echo ru_resource;?>images/card_d.jpg" alt="Discover Network Card" /></a>
				</div>
				 <!--------------CREDIT CARD METHOD START------------>
				<div id="credit_card_form" <?php if($_SESSION['biz_gift_err'] != '') { } else { ?> style="display:none;" <?php } ?>>
					<div class="form-group">
     					 <div class="ui-field-contain field" id="test">
        					<input type="text" id="cardnumber" name="cardnumber" autocomplete="off" maxlength="19" placeholder="Card Number" class="card-number form-control">
							<span id="error" style="color:#a94442; font-weight:normal; float:left; width:100%; margin-left:10px;font-family: 'open_sanslight';"><?php echo $_SESSION['biz_gift_err']['cardnumber'];?>
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
      						<input type="text" name="fname" id="fname" maxlength="65" value="<?php echo $_SESSION['biz_gift']['fname']; ?>" placeholder="First Name" class="fname form-control">
    					</div>
  					</div>
					<div class="form-group">
    					<div class="ui-field-contain field">
      						<input type="text" name="lname" id="lname" maxlength="65" value="<?php echo $_SESSION['biz_gift']['lname']; ?>" placeholder="Last Name" class="lname form-control">
    					</div>
  					</div>
					<div class="form-group">
    					<div class="ui-field-contain field">
      						<input type="text" name="address1" id="address1" value="<?php echo $_SESSION['biz_gift']['address1']; ?>" placeholder="Address 1" class="address form-control">
    					</div>
  					</div>
					<div class="form-group">
    					<div class="ui-field-contain field">
      						<input type="text" name="address2" id="address2" value="<?php echo $_SESSION['biz_gift']['address2']; ?>" placeholder="Address 2" class="address2 form-control">
    					</div>
  					</div>
					<div class="form-group">
    					<div class="ui-field-contain field">
      						<input type="text" name="city" id="city" value="<?php echo $_SESSION['biz_gift']['city']; ?>" placeholder="City" class="city form-control">
    					</div>
  					</div>
					<div class="form-group">
    						<div class="ui-field-contain field select_fleid">
								<label for="textinput-1">State *</label>
	  							<select name="state" class="state form-control" id="select-native-1">
									<option>Select State</option>
									<?php foreach($StateAbArray as $key => $val) { ?>
									<option value="<?php echo $key;?>" <?php if($_SESSION['biz_gift']['state'] == $key) echo 'selected="selected"'; ?>><?php echo $val;?></option>
									<?php } ?>	
								</select>
    						</div>
  					</div>
					<div class="form-group">
    						<div class="ui-field-contain field">
      							<input type="text" name="zip" id="zip" value="<?php echo $_SESSION['biz_gift']['zip']; ?>" maxlength="9" placeholder="Postal Code" class="zip form-control">
    						</div>
  					</div>
</div>
				<!--------------CREDIT CARD METHOD END------------>
				<img src="<?php echo ru_resource;?>images/jester_c.jpg" alt="Jester Image" />
				<?php if($view_blance['available_cash'] <= 0 ) { ?>
		<a href="javascript:;" onclick="chk_blance()" class="ui-btn ui-btn-c">Complete Order</a>
		<?php } else { ?>
		<button class="btn btn-success" type="submit" style="display:none">Complete Order</button>
		<a href="javascript:;" onclick="SendGift()" id="cash_stash_btn" class="ui-btn ui-btn-c">Complete Order</a>
		<?php } ?>
		</form>
			</fieldset>
		</div>
		
	</div><!-- /content -->
<script language="javascript">
	function SendGift(){
		document.getElementById("payment-form").submit()	
	}
	
	$(document).ready(function () {
		$('#radio-choice-v-1c,#radio-choice-v-1b,#radio-choice-v-1a,#radio-choice-v-1d').click(function () {
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
				$('#credit_card_form').show();
				$('.btn').css('display','block');
				$('#bank_account_form').hide();
				$('#test').show();
				$('#test1').hide(); 
				$('#cash_stash_btn').hide();
			} else if(pay_method == 'bank_account') {
				$('#bank_account_form').show();
				$('#credit_card_form').hide();
			} else if(pay_method == 'cash_stash') {
				$('#cash_stash_btn').show();
				$('.btn').css('display','none');
				$('#bank_account_form').hide();
				$('#credit_card_form').hide();
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
						$('#test').hide();
						$('#test1').show();
						$('#credit_card_form').show();
						$('.btn').css('display','block');
						$('#bank_account_form').hide(); 
						$('#cash_stash_btn').hide();
					}
				});
			}
		});
	});	
</script>	
<?php /*?><link rel="stylesheet" href="<?php echo ru_resource; ?>bootstrap_css/bootstrap-min.css">
<link rel="stylesheet" href="<?php echo ru_resource; ?>bootstrap_css/bootstrap-formhelpers-min.css" media="screen">
<link rel="stylesheet" href="<?php echo ru_resource; ?>bootstrap_css/bootstrapValidator-min.css"/>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" />
<link rel="stylesheet" href="<?php echo ru_resource; ?>bootstrap_css/bootstrap-side-notes.css" /><?php */?>
<style>
.has-error .help-block, .has-error .control-label, .has-error .radio, .has-error .checkbox, .has-error .radio-inline, .has-error .checkbox-inline{color:#a94442}
.ui-page .jqm-content a.ui-btn-b, .jqm-content button.ui-btn, .btn-success{
background:url("resource/images/btnc_bg.jpg") repeat-x 0 0; 
}
</style>
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
			/*amount: {
                validators: {
                    notEmpty: {
                        message: 'The Amount is required and cannot be empty'
                    },
					digits: {
                        message: 'The Amount can contain digits only'
                    }
                }
            },*/
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
 

</script>	
<?php
unset($_SESSION['biz_gift_err']);
unset($_SESSION['biz_gift']);
?>	
<script type="text/javascript">
function chk_blance()
{
	alert("You have Insufficient balance!")
}


function cancel_iftgift(dId)
{
	var delivery = dId;
	$.ajax({
	url: '<?php echo ru;?>process/process_delivery.php?dId='+delivery,
	type: 'get', 
	success: function(output) {
	if(output == 'Success')
	{
		window.location = "<?php echo ru?>dashboard";
	}
	}
	});
}
</script>	
