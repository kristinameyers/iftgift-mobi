<?php if($page == 'dashboard' || $page == 'cash_stash' || $page == 'profile' || $page == 'step_1' || $page == 'step_2a' || $page == 'step_2b' || $page == 'listings' || $page == 'cart' || $page == 'detail' || $page == 'delivery_detail' || $page == 'giver_info' || $page == 'recp_info' || $page == 'notify_datetime' || $page == 'unlock_datetime' || $page == 'review_gift' || $page == 'personal_note' || $page == 'checkout' || $page == 'confirmation' || $page == 'upload_image' || $page == 'unwrap' || $page == 'search' || $page == 'locked' || $page == 'open_iftgift' || $page == 'unwraped') { ?>
	<div data-role="footer">
		<a href="<?php echo ru;?>unwrap" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline <?php if($page == 'unwrap') {?>selected_b<?php } ?>"><span>Unwrap</span><img src="<?php echo ru_resource?>images/wrap.png" alt="Unwrap Icon" /></a>
		<a href="<?php echo ru;?>step_1" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline <?php if($page == 'step_1' || $page == 'step_2a' || $page == 'step_2b' || $page == 'listings' || $page == 'cart' || $page == 'detail') {?>selected_b<?php } ?>"><span>Send</span><img src="<?php echo ru_resource?>images/send.png" alt="Send Icon" /></a>
		<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline"><span>Q&A </span><img src="<?php echo ru_resource?>images/q&a.png" alt="Q&A Icon" /></a>
		<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline last"><span><img src="<?php echo ru_resource?>images/tag.png" alt="Tag Icon" />Redeem</span><div class="points"><h5>100,000</h5><h5 class="point">Your Points</h5></div></a>
	</div>
	<style>.ui-mobile .ui-page{ padding:0 0 100px 0}</style>
	<?php } ?>
</body>
</html>