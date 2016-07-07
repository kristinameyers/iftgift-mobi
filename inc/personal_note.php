 	<div role="main" class="ui-content jqm-content jqm-content-c ift_block">
		<h4 class="recip delivery">Edit Recipient Info</h4>
	</div><!-- /content -->
	<div role="main" class="ui-content jqm-content jqm-content-c">
	<form id="form_note" method="post" action="<?php echo ru;?>process/process_delivery.php">
	<input name="delivery_id" id="delivery_id" value="<?php echo $_SESSION['delivery_id']['New'];?>" type="hidden">
	<input name="Notes" id="Notes" value="1" type="hidden">
		<div class="ui-field-contain field" style="display:none">
			<label for="textinput-1">is the cash amount you want to send still?</label>
			<?php
		 $get_recipit = "select r.first_name,r.last_name,r.recipit_id,r.cash_gift,r.ocassion,o.occasionid,o.occasion_name from ".tbl_recipient." as r left join ".tbl_occasion." as o on r.ocassion=o.occasionid where r.recipit_id = '".$_SESSION['recipit_id']['New']."'";
		 $view = $db->get_row($get_recipit,ARRAY_A);
		?>
			<input name="cash_amount" id="textinput-1" placeholder="$<?php echo $view['cash_gift'];?>" value="$<?php echo $view['cash_gift'];?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_note_err']['cash_amount'];?></span>
		</div>
		<h3>Send a Personal Note</h3>
		<div class="ui-field-contain">
			<textarea cols="40" rows="8" name="notes" id="textarea-1" class="text-area" placeholder="Enter Your Personal Note Here ...."></textarea>
		</div>
		<a href="javascript:;" onclick="add_note()" class="ui-btn ui-btn-c">Save and Continue</a>
		</form>
	</div><!-- /content -->

<script language="javascript">
	function add_note(){
		document.getElementById("form_note").submit()	
	}
</script>	
<?php
unset($_SESSION['biz_note_err']);
unset($_SESSION['biz_note']);
?>				