<?php
 $get_cuser = $db->get_row("select available_cash,party_mode from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'",ARRAY_A);
 $available_cash = $get_cuser['available_cash'];
?>
<style>.ift_block h4.recip{width:98%; text-align:center; margin-left:1%}</style>
<div class="sugg_top sugg_top_b">
		<h2>Cash Stash</h2>
	</div>
	<div role="main" class="ui-content jqm-content jqm-content-c">
		<div class="cash_count">
			<div class="cash_count_left">
				<span>Cash^Stash<br/>Balance</span>
				<img src="<?php echo ru_resource; ?>images/down_arrow_cs.png" />
			</div>
			<div class="cash_count_right">
				<h3>$<?php echo $available_cash;?></h3>
			</div>
		</div>
		<a href="<?php echo ru;?>withdraw_cashstash" data-ajax="false" class="ui-btn cash_button">Withdraw <b>FROM</b> Cash Stash <img src="<?php echo ru_resource; ?>images/icon_a_right.png" /></a>
		<a href="<?php echo ru;?>deposit_cashstash" data-ajax="false" class="ui-btn cash_button deposite">Deposit <b>INTO</b> Cash Stash <img src="<?php echo ru_resource; ?>images/icon_b_right.png" /></a>
	</div>