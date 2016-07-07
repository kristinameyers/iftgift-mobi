<?php if($page == 'dashboard' || $page == 'cash_stash' || $page == 'profile' || $page == 'step_1' || $page == 'step_2a' || $page == 'step_2b' || $page == 'listings' || $page == 'cart' || $page == 'detail' || $page == 'delivery_detail' || $page == 'giver_info' || $page == 'recp_info' || $page == 'notify_datetime' || $page == 'unlock_datetime' || $page == 'review_gift' || $page == 'personal_note' || $page == 'checkout' || $page == 'confirmation' || $page == 'upload_image' || $page == 'unwrap' || $page == 'search' || $page == 'locked' || $page == 'open_iftgift' || $page == 'unwraped' || $page == 'controls' || $page == 'personalinformation' || $page == 'inbox' || $page == 'outbox' || $page == 'reminder' || $page == 'iftcliques' || $page == 'iftscoreboards' || $page == 'retailerrewards' || $page == 'iftwishlist' || $page == 'owneditems' || $page == 'hiddenitems' || $page == 'iftClique' || $page == 'only' || $page == 'similar_persons' || $page == 'search_result' || $page == 'release_request' || $page == 'transfercashstash' || $page == 'deposit_cashstash' || $page == 'withdraw_cashstash') { ?>
	<style>
		#list-b{display:none}
		#list-b.open{display:block}
	</style>
	<div class="footer_outer">
		<div id="list-b">
		<div data-role="footer" class="footer_nav">
			<h3>Control Center Menu<img src="<?php echo ru_resource?>images/f_down_arrow.jpg"  /></h3>
			<a href="<?php echo ru;?>inbox" data-ajax="false" <?php if($page == 'inbox') { ?>class='active'<?php } ?>>In.Box Archive</a>
			<a href="<?php echo ru;?>outbox" data-ajax="false" <?php if($page == 'outbox') { ?>class='active'<?php } ?>>Out.Box Archive</a>
			<a href="<?php echo ru;?>reminder" data-ajax="false" <?php if($page == 'reminder') { ?>class='active'<?php } ?>>Personal Reminders</a>
			<a href="<?php echo ru;?>iftcliques" data-ajax="false" <?php if($page == 'iftcliques') { ?>class='active'<?php } ?>>Our IftClique</a>
			<a href="<?php echo ru;?>iftscoreboards" data-ajax="false" <?php if($page == 'iftscoreboards') { ?>class='active'<?php } ?>>iftScore Board</a>
			<a href="<?php echo ru;?>retailerrewards" data-ajax="false" <?php if($page == 'retailerrewards') { ?>class='active'<?php } ?>>Retailer Rewards</a>
			<a href="<?php echo ru;?>iftwishlist" data-ajax="false" <?php if($page == 'iftwishlist') { ?>class='active'<?php } ?>>Your iftWish List</a>
			<a href="<?php echo ru;?>owneditems" data-ajax="false" <?php if($page == 'owneditems') { ?>class='active'<?php } ?>>Owned Items</a>
			<a href="<?php echo ru;?>hiddenitems" data-ajax="false" <?php if($page == 'hiddenitems') { ?>class='active'<?php } ?>>Hidden Items</a>
		</div>
		<?php
		$get_points = "select points from ".tbl_userpoints." where userId = '".$_SESSION['LOGINDATA']['USERID']."'"; 
		$view_points = $db->get_row($get_points,ARRAY_A);
		if($view_points['points'] == '') {
			$view_points['points'] = 0;
		}
	?>		
		<div data-role="footer">
			<a href="<?php echo ru;?>unwrap" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline <?php if($page == 'unwrap') {?>selected_b<?php } ?>"><span>Unwrap</span><img src="<?php echo ru_resource?>images/wrap.png" alt="Unwrap Icon" /></a>
			<a href="<?php echo ru;?>step_1" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline <?php if($page == 'step_1' || $page == 'step_2a' || $page == 'step_2b' || $page == 'listings' || $page == 'cart' || $page == 'detail') {?>selected_b<?php } ?>"><span>Send</span><img src="<?php echo ru_resource?>images/send.png" alt="Send Icon" /></a>
			<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline"><span>Q&A </span><img src="<?php echo ru_resource?>images/q&a.png" alt="Q&A Icon" /></a>
			<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline last"><span><img src="<?php echo ru_resource?>images/tag.png" alt="Tag Icon" />Redeem</span><div class="points"><h5><?php echo $view_points['points']; ?></h5><h5 class="point">Your Points</h5></div></a>
		</div>
	</div>
		<!-------------------------Footer_Hide_Show--------------------------->
		<div class="footer_expand_bar">
		<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline redeem"><span><img src="<?php echo ru_resource?>images/tag.png" alt="Tag Icon" />Redeem</span><div class="points"><h5><?php echo $view_points['points']; ?></h5><h5 class="point">Your Points</h5></div></a>
		<a href="javascript:;" data-toggle="#list-b" class="ui-btn ui-corner-all ui-shadow ui-btn-inline footer_expand_right hide"><img src="<?php echo ru_resource?>images/expand_plus_icon.png" /><span>Expand</span></a>
	</div>
		<!-------------------------Footer_Hide_Show--------------------------->
	</div>
	<style>.ui-mobile .ui-page{ padding:0 0 100px 0}</style>
	<?php } ?>
</body>
</html>