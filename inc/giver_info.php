<?php
$giver_info = "select * from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'";
$view_info = $db->get_row($giver_info,ARRAY_A);

$recp_info = "select * from ".tbl_recipient." where recipit_id = '".$_SESSION['recipit_id']['New']."'";
$view_infos = $db->get_row($recp_info,ARRAY_A);
?>
	<div role="main" class="ui-content jqm-content jqm-content-c ift_block">
		<h4 class="recip delivery">Delivery Details</h4>
	</div><!-- /content -->
	<div role="main" class="ui-content jqm-content jqm-content-c">
	<form id="form_giver" method="post" action="<?php echo ru;?>process/process_delivery.php">
		<div class="ui-field-contain field" style="display:none">
		<?php if($_SESSION['biz_giv_err']['Giver_edit']) { ?>
		<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_giv_err']['Giver_edit'];?></span>
		<?php } ?>
			<label for="textinput-1">is the cash amount you want to send still?</label>
			<?php
		 $get_recipit = "select r.first_name,r.last_name,r.recipit_id,r.cash_gift,r.ocassion,o.occasionid,o.occasion_name from ".tbl_recipient." as r left join ".tbl_occasion." as o on r.ocassion=o.occasionid where r.recipit_id = '".$_SESSION['recipit_id']['New']."'";
		 $view = $db->get_row($get_recipit,ARRAY_A);
		?>
			<input name="cash_amount" id="textinput-1" placeholder="$<?php echo $view['cash_gift'];?>" value="$<?php echo $view['cash_gift'];?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_giv_err']['cash_amount'];?></span>
		</div>
		<h3 class="recip delivery">Edit Giver Info</h3>
		<input name="delivery_id" id="delivery_id" value="<?php echo $_SESSION['delivery_id']['New'];?>" type="hidden">
		<input name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" type="hidden">
		<input name="occassionid" id="occassionid" value="<?php echo $view_infos['ocassion'];?>" type="hidden">
		<input name="SaveGiver" id="SaveGiver" value="1" type="hidden">
		<div class="ui-field-contain field">
			<label for="textinput-1">First Name *</label>
			<input name="first_name" id="textinput-1" placeholder="First Name(s)" value="<?php echo $view_info['first_name'];?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_giv_err']['first_name'];?></span>
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Last Name *</label>
			<input name="last_name" id="textinput-1" placeholder="Last Name" value="<?php echo $view_info['last_name'];?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_giv_err']['last_name'];?></span>
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Email *</label>
			<input name="email" id="textinput-1" placeholder="Email" value="<?php echo $view_info['email'];?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_giv_err']['email'];?></span>
		</div>
		<a href="javascript:;" onclick="Recipitform()" class="ui-btn ui-btn-c">Save and Continue</a>
		</form>
	</div><!-- /content -->

<script language="javascript">
	function Recipitform(){
		document.getElementById("form_giver").submit()	
	}
</script>	
<?php
unset($_SESSION['biz_giv_err']);
unset($_SESSION['biz_giv']);
?>		