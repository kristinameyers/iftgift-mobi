<div role="main" class="ui-content jqm-content jqm-content-c ift_block">
		<h4 class="recip delivery">Delivery Details</h4>
	</div><!-- /content -->
	<div role="main" class="ui-content jqm-content jqm-content-c">
		<div class="ui-field-contain field">
			<label for="textinput-1">is the cash amount you want to send still?</label>
			<?php
		 $get_recipit = "select r.first_name,r.last_name,r.recipit_id,r.cash_gift,r.ocassion,o.occasionid,o.occasion_name from ".tbl_recipient." as r left join ".tbl_occasion." as o on r.ocassion=o.occasionid where r.recipit_id = '".$_SESSION['recipit_id']['New']."'";
		 $view = $db->get_row($get_recipit,ARRAY_A);
		?>
			<input name="textinput-1" id="textinput-1" placeholder="$<?php echo $view['cash_gift'];?>" value="$<?php echo $view['cash_gift'];?>" type="text">
		</div>
		<div class="ui-grid-a">
			<div class="ui-block-a"><a href="<?php echo ru;?>giver_info/" data-ajax="false"><div class="ui-bar ui-bar-a">Edit<br /> Giver<br /> Info</div></a></div>
			<div class="ui-block-b"><a href="<?php echo ru;?>recp_info/" data-ajax="false"><div class="ui-bar ui-bar-a">Edit<br /> Recipient <br />Info</div></a></div>
			<div class="ui-block-a"><a href="<?php echo ru;?>notify_datetime/" data-ajax="false"><div class="ui-bar ui-bar-a">Edit<br /> Notify <br /> Date / Time</div></a></div>
			<div class="ui-block-b"><a href="<?php echo ru;?>unlock_datetime/" data-ajax="false"><div class="ui-bar ui-bar-a">Edit <br />Unlock<br /> Date / Time</div></a></div>
			<div class="ui-block-a"><a href="<?php echo ru;?>review_gift/" data-ajax="false"><div class="ui-bar ui-bar-a">Review<br /> Gift<br /> Suggestions</div></a></div>
			<div class="ui-block-b"><a href="<?php echo ru;?>personal_note/" data-ajax="false"><div class="ui-bar ui-bar-a">Send<br /> Personal<br /> Note</div></a></div>
		</div><!-- /grid-a -->
		<?php
		$get_delivery = mysql_query("select * from ".tbl_delivery." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and delivery_id = '".$_SESSION['delivery_id']['New']."'");
		if(mysql_num_rows($get_delivery) > 0)
		{
		?>
		<a href="<?php echo ru;?>checkout" class="ui-btn ui-btn-c" data-ajax="false">Checkout</a>
		<?php } else {?>
		<a href="javascript:;" onclick="chk_checkouts()" class="ui-btn ui-btn-c">Check Out</a>
		<?php } ?>
	</div><!-- /content -->

<script type="text/javascript">
function chk_checkouts()
{
	alert("Please fill all delivery details and continue.");
}
</script>	