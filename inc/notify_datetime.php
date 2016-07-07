<div role="main" class="ui-content jqm-content jqm-content-c ift_block">
		<h4 class="recip delivery">Delivery Details</h4>
	</div><!-- /content -->
	<div role="main" class="ui-content jqm-content jqm-content-c">
	<form id="form_notify" method="post" action="<?php echo ru;?>process/process_delivery.php">
	<input name="delivery_id" id="delivery_id" value="<?php echo $_SESSION['delivery_id']['New'];?>" type="hidden">
	<input name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" type="hidden">
	<input name="Notify" id="Notify" value="1" type="hidden">
		<div class="ui-field-contain field"  style="display:none">
			<label for="textinput-1">is the cash amount you want to send still?</label>
			<?php
		 $get_recipit = "select r.first_name,r.last_name,r.recipit_id,r.cash_gift,r.ocassion,o.occasionid,o.occasion_name from ".tbl_recipient." as r left join ".tbl_occasion." as o on r.ocassion=o.occasionid where r.recipit_id = '".$_SESSION['recipit_id']['New']."'";
		 $view = $db->get_row($get_recipit,ARRAY_A);
		?>
			<input name="cash_amount" id="textinput-1" placeholder="$<?php echo $view['cash_gift'];?>" value="$<?php echo $view['cash_gift'];?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['cash_amount'];?></span>
		</div>
		<?php
		 $get_delivery = "select * from ".tbl_delivery." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and delivery_id = '".$_SESSION['delivery_id']['New']."'";
		 $view_dev = $db->get_row($get_delivery,ARRAY_A);
		?>
		<h3 class="recip delivery">Edit Notification Date / Time</h3>
		<div class="ui-field-contain">
			<fieldset data-role="controlgroup">
				<input name="notification" id="radio-choice-v-1a" <?php if (isset($view_dev['immediately']) && $view_dev['immediately'] == 1) echo "checked"; ?> value="1"  type="radio">
				<label for="radio-choice-v-1a">Immediate Notification</label>
				<div class="or">or</div>
				<input name="notification" id="radio-choice-v-1b" <?php if (isset($view_dev['future']) && $view_dev['future'] == 2) echo "checked"; ?> value="2" type="radio">
				<label for="radio-choice-v-1b">Set Future Date and Time</label>
			</fieldset>
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['notification'];?></span>
		</div>
		<div id="immediate" <?php if ($view_dev['immediately'] == '1') { } else {?> style="display:none" <?php } ?>>
		<div class="ui-grid-b ui-grid-mm">
			<div class="ui-block-a ui-block dd"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="month" id="month" placeholder="mm" value="<?php 		$month = date('m',strtotime($view_dev['date']));
			echo $month;?>" class="date" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['month'];?></span>
			</div></div></div>
			<div class="ui-block-b ui-block mm"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="day" id="day" placeholder="dd" value="<?php 		$day = date('d',strtotime($view_dev['date']));
			echo $day;?>" class="date" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['day'];?></span>
			</div></div></div>
			<div class="ui-block-c ui-block yy"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="year" id="year" placeholder="yy" value="<?php 		$year = date('Y',strtotime($view_dev['date']));
			echo $year;?>" class="date" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['year'];?></span>
			</div></div></div>
		</div><!-- /grid-b -->
		<h3 class="anchor">@</h3>
		<div class="ui-grid-b ui-grid-mm">
			<div class="ui-block-a ui-block dd"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="hour" id="timepicker_hours" placeholder="hour" value="<?php 		$hour = date('h',strtotime($view_dev['time']));
			echo $hour;?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['hour'];?></span>
			</div></div></div>
			<div class="ui-block-b ui-block mm"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="minute" id="timepicker_minutes" placeholder="min" value="<?php 		$minutes = date('i',strtotime($view_dev['time']));
			echo $minutes;?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['minute'];?></span>
			</div></div></div>
			<div class="ui-block-c ui-block yy"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field">
			<input name="sec" id="textinput-1" placeholder="AM/PM" value="<?php 		$sec = date('A',strtotime($view_dev['time']));
			echo $sec;?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['sec'];?></span>
			</div></div></div>
		</div><!-- /grid-b -->
		</div>
		
		<div id="future" <?php if ($view_dev['future'] == '2') { } else {?> style="display:none" <?php } ?>>
		<div class="ui-grid-b ui-grid-mm">
			<div class="ui-block-a ui-block dd"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="month1" id="month1" placeholder="mm" value="<?php 		$month = date('m',strtotime($view_dev['date']));
			echo $month;?>" class="dates" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['month1'];?></span>
			</div></div></div>
			<div class="ui-block-b ui-block mm"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="day1" id="day1" placeholder="dd" value="<?php 		$day = date('d',strtotime($view_dev['date']));
			echo $day;?>" class="dates" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['day1'];?></span>
			</div></div></div>
			<div class="ui-block-c ui-block yy"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="year1" id="year1" placeholder="yy" value="<?php 		$year = date('Y',strtotime($view_dev['date']));
			echo $year;?>" class="dates" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['year1'];?></span>
			</div></div></div>
		</div><!-- /grid-b -->
		<h3 class="anchor">@</h3>
		<div class="ui-grid-b ui-grid-mm">
			<div class="ui-block-a ui-block dd"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="hours" id="timepicker_hourss" placeholder="hour" value="<?php 		$hour = date('h',strtotime($view_dev['time']));
			echo $hour;?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['hours'];?></span>
			</div></div></div>
			<div class="ui-block-b ui-block mm"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="minutes" id="timepicker_minutess" placeholder="min" value="<?php 		$minutes = date('i',strtotime($view_dev['time']));
			echo $minutes;?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['minutes'];?></span>
			</div></div></div>
			<div class="ui-block-c ui-block yy"><div class="ui-bar ui-bar-a"><div class="ui-field-contain field"><input name="secs" id="textinput-1" placeholder="AM/PM" value="<?php 		$sec = date('A',strtotime($view_dev['time']));
			echo $sec;?>" type="text">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_not_err']['secs'];?></span>
			</div></div></div>
		</div><!-- /grid-b -->
		</div>
		<a href="javascript:;" onclick="NotifyDate()" class="ui-btn ui-btn-c">Save and Continue</a>
		</form>
	</div><!-- /content -->
	
<script language="javascript">
	function NotifyDate(){
		document.getElementById("form_notify").submit()	
	}
</script>	
<?php
unset($_SESSION['biz_not_err']);
unset($_SESSION['biz_not']);
?>			