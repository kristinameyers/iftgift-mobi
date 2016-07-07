<?php
 $get_recipiet = "select * from ".tbl_recipient." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and  recipit_id = '".$_SESSION['recipit_id']['New']."'";
 $recipiet_rs  = mysql_query($get_recipiet) or die (mysql_error());
 $recipiet_row = mysql_fetch_array($recipiet_rs);
 if ( mysql_num_rows($recipiet_rs) > 0 ){
		$_SESSION['biz_rep'] = $recipiet_row;
	}	
?>
<script type="text/javascript">
$(function()
{  
      $('input').focusin(function()
      {
        input = $(this);
        input.data('place-holder-text', input.attr('placeholder'))
        input.attr('placeholder', '');
      });

      $('input').focusout(function()
      {
          input = $(this);
          input.attr('placeholder', input.data('place-holder-text'));
      });
})

</script>
<?php /*?><script type="text/javascript" src="<?php echo ru_resource;?>js/jquery.maskedinput.js"></script><?php */?>
<div role="main" class="ui-content jqm-content jqm-content-c">
		<h2>SEND</h2>
		<h5>What is the cash amount you want to send?</h5>
		<form id="form_recipit" action="<?php echo ru;?>process/process_recipit.php" method="post">
		<input name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" type="hidden">
		<input name="SaveRecipit" id="SaveRecipit" value="1" type="hidden">
		<div class="ui-field-contain field gift">
			<label for="textinput-1">Cash Gift *</label>
			<input name="cash_amount" id="cash_amount" placeholder="$0.00" value="" type="text">
			<?php /*?><script type="text/javascript">
			jQuery(function($){
   			$("#cash_amount").mask("999999999999",{placeholder:" "});
			});
			</script><?php */?>
			<p>Your recipient can use this to buy from your suggestions, to shop for other items or they can transfer the cash to their bank.</p>
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_rep_err']['cash_amount'];?></span>
		</div>
		<h5>Tell us about your recipient ...</h5>
		<div class="ui-field-contain field">
			<label for="textinput-1">First Name *</label>
			<input name="first_name" id="first_name" placeholder="Enter Here..." value="<?php echo $_SESSION['biz_rep']['first_name']; ?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_rep_err']['first_name'];?></span>
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Last Name </label>
			<input name="last_name" id="last_name" placeholder="Enter Here..." value="<?php echo $_SESSION['biz_rep']['last_name']; ?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Email *</label>
			<input name="email" id="email" placeholder="Enter Here..." value="<?php echo $_SESSION['biz_rep']['email']; ?>" type="text">
			<span style="color:#FF0000; font-weight:bold;float:none"><?php echo $_SESSION['biz_rep_err']['email'];?></span>
		</div>
		<div class="ui-field-contain field select_fleid">
			<label for="select-native-1">Gender </label>
			<select name="gender" id="select-native-1">
				<?php /*?><option value="netural" <?php if($_SESSION['biz_rep']['gender'] == 'netural') echo 'selected="selected"'; ?>>Neutral</option><?php */?>
				<option value="female" <?php if($_SESSION['biz_rep']['gender'] == 'female') echo 'selected="selected"'; ?>>Female</option>
				<option value="male" <?php if($_SESSION['biz_rep']['gender'] == 'male') echo 'selected="selected"'; ?>>Male</option>
			</select>
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Age *</label>
			<input name="age" id="age" placeholder="(Guess if necessary)" value="<?php echo $_SESSION['biz_rep']['age']; ?>" type="text">
			<span style="color:#FF0000; font-weight:bold;float:none"><?php echo $_SESSION['biz_rep_err']['age'];?></span>
		</div>
		<div class="ui-field-contain field select_fleid">
			<label for="select-native-1">Location </label>
			<select name="location" id="select-native-1">
			<option>Select State</option>
			<?php foreach($StateAbArray as $key => $val) { ?>
				<option value="<?php echo $key;?>" <?php if($_SESSION['biz_rep']['location'] == $key) echo 'selected="selected"'; ?>><?php echo $val;?></option>
			<?php } ?>	
			</select>
		</div>
		<div class="ui-field-contain field select_fleid">
			<label for="select-native-1">Occassion *</label>
			<select name="ocassion" id="select-native-1">
			
			
			<option>Event</option>
				<?php
				$pcatQry = mysql_query("SELECT occasionid, occasion_name from ".tbl_occasion." where occasion_type = 1 and status = 1");
				while($pshort = mysql_fetch_array($pcatQry)){
				?>
				<option style="font-weight:bold; color:#000000" disabled="disabled"><?php echo $pshort['occasion_name']; ?></option>
				<?php 
				$catQry = mysql_query("SELECT occasionid, occasion_name from ".tbl_occasion." where p_occasionid = ".$pshort['occasionid']." and status = 1");
                while($short = mysql_fetch_array($catQry)){?>
				<option value="<?php echo $short['occasionid']; ?>" <?php if($_SESSION['biz_rep']['ocassion']==$short['occasionid']) { echo 'selected="selected"';}?> style="padding-left:30px;" ><?php echo $short['occasion_name']; ?></option>
				<?php }	} ?>
			</select>
			<span style="color:#FF0000; font-weight:bold;float:none"><?php echo $_SESSION['biz_rep_err']['ocassion'];?></span>
		</div>
		<h5 class="privacy">We never reveal any information to a third party without consent.  Click here to view our <a href="#">Privacy Policy.</a></h5>
		<h5 class="privacy">* Indicates a required field</h5>
		<a href="javascript:;" onclick="Recipitform()" class="ui-btn ui-btn-c">Send an iftGift</a>
		</form>
	</div>
<script language="javascript">
	function Recipitform(){
		document.getElementById("form_recipit").submit()	
	}
</script>	
<?php
unset($_SESSION['biz_rep_err']);
unset($_SESSION['biz_rep']);
?>	