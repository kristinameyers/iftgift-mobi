<?php
$userId = $_SESSION['LOGINDATA']['USERID'];
$get_user = $db->get_row("select * from ".tbl_user." where userId = '".$userId."'",ARRAY_A);
$email = $get_user['email']; 
$get_delivery = $db->get_row("select count(recp_email) as cnt from ".tbl_delivery." where recp_email = '".$email."' and deliverd_status = 'deliverd' and (unlock_status = '1' or open_status = '2') GROUP BY recp_email HAVING Count( recp_email )",ARRAY_A);

$delveryQry = $db->get_results("select * from ".tbl_delivery." where recp_email = '".$email."' and deliverd_status = 'deliverd' and unlock_status = '1'",ARRAY_A);
?>

<script type="text/javascript">
	$(document).ready(function () {
		$('#toggle-view li').click(function () {
			var text = $(this).children('div.panel');
			if (text.is(':hidden')) {
				text.slideDown('slow');
				$(this).children('span').html('<img src="<?php echo ru_resource;?>images/nagative_sign.png" />');		
			} else {
				text.slideUp('slow');
				$(this).children('span').html('<img src="<?php echo ru_resource;?>images/plus_sign.png" />');		
			}
		});
	});
</script>
<div class="sugg_top sugg_top_b">
		<h2>UNWRAP</h2>
		<div class="dashbd wnwrap">
			<h4 class="recip accm">You have</h4>
			<div class="count">
				<input name="textinput-1" id="textinput-1" placeholder="Text input" value="<?php  if($get_delivery > 0 ) { echo $get_delivery['cnt']; } else { echo '0';} ?>" type="text">
			</div>
			<h4 class="recip accm">active iftGifts</h4>
		</div>
	</div>
	
	<div role="main" class="ui-content unwrap-content">
		<ul id="toggle-view">
			<?php 
			if($delveryQry) {
			foreach($delveryQry as $unlock) { ?>
			<li>
				<div class="ui-block-a">&nbsp;</div>
				<div class="ui-block-b"> <?php echo ucfirst($unlock['giv_first_name']).'&nbsp;'.ucfirst($unlock['giv_last_name']); ?></div>
				<?php
				$view_occs = $db->get_row("select * from ".tbl_occasion." where occasionid = '".$unlock['occassionid']."'",ARRAY_A);
				?>
				<div class="ui-block-c"><?php echo $view_occs['occasion_name'];?></div>
				<span class="ui-block-d"><img src="<?php echo ru_resource;?>images/plus_sign.png" /></span>
				<div class="panel">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Notification: 
					<?php 
					$timestamps = strtotime($unlock['date']);
					echo $notify_date = date('m/d/y', $timestamps);?> @ <?php echo $unlock['time'];?></div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel panel-b">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Unlock: <span>
					<?php 
					$timestamps = strtotime($unlock['unlock_date']);
					echo $unlock_date = date('m/d/y', $timestamps);?> @ <?php echo $unlock['unlock_time'];?></span></div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Unwrap</div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel panel-b">
					<div class="ui-block-a">&nbsp;</div>
					<?php if($unlock['release_request'] == 1 && $unlock['release_request_respond'] == '' ) { 
							$release_Request = "They're Waiting - respond";
						  } else if($unlock['release_request'] == 1 && $unlock['release_request_respond'] == 'change_release' ) {
						  	$release_Request = "REVISED".'&nbsp;'.$unlock_date.'&nbsp;'.$unlock['unlock_time'];
						  } else if($unlock['release_request'] == 1 && $unlock['release_request_respond'] == 'keep_release' ) {
						  	$release_Request = "REINSTATED".'&nbsp;'.$unlock_date.'&nbsp;'.$unlock['unlock_time'];
						  }
					?>
					<div class="ui-block-b">Release Request: <span><?php echo $release_Request; ?></span></div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel">
				<div data-role="popup" id="popupDialog-<?php echo $unlock['delivery_id']; ?>" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:400px;">
							<div data-role="header" data-theme="a">
								<h1>iftGift Release Request</h1>
								<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b closed" title="Closed" data-rel="back"></a>
							</div>
							<div role="main" class="ui-content">
								<form id="Releaserequest" action="<?php echo ru; ?>process/process_releaserequest.php" method="post" data-ajax="false">
								<input name="delivery_id" id="delivery_id" value="<?php echo $unlock['delivery_id']; ?>" type="hidden">
								<input name="giv_email" id="giv_email" value="<?php echo $unlock['giv_email']; ?>" type="hidden">
								<input name="recp_email" id="recp_email" value="<?php echo $unlock['recp_email']; ?>" type="hidden">
								<input name="giv_name" id="giv_name" value="<?php echo $unlock['giv_first_name']; ?>" type="hidden">
								<input name="recp_name" id="recp_name" value="<?php echo $unlock['recp_first_name']; ?>" type="hidden">
								<input name="unlock_date" id="unlock_date" value="<?php echo $unlock['unlock_date']; ?>" type="hidden">
								<input name="unlock_time" id="unlock_time" value="<?php echo $unlock['unlock_time']; ?>" type="hidden">
								<input name="ReleaseRequest" id="ReleaseRequest" value="ReleaseRequest" type="hidden">
								<div class="ui-field-contain">
									<label for="textinput-1">Tell <?php echo $unlock['giv_first_name'] .' '. $unlock['giv_last_name']; ?> why you would like to change the Unwrap Date/Time of this iftGift..</label>
								</div>
								<div class="ui-field-contain">
									<label for="textinput-1">Thank you <?php echo $unlock['giv_first_name'] .' '. $unlock['giv_last_name']; ?>,</label>
								</div>
								<div class="ui-field-contain">
									<textarea cols="40" rows="8" name="message" id="textarea-1" placeholder="[Enter Text Here]"></textarea>
								</div>
								<div class="ui-field-contain">
									<label for="textinput-1">Thank you <?php echo $unlock['recp_first_name'] .' '. $unlock['recp_last_name']; ?></label>
								</div>
								<div class="ui-field-contain send_btn">
									<button onclick="ReleaseRequests()" type="button" id="submit-1" class="ui-shadow ui-btn ui-corner-all">Send</button>
								</div>
								</form>
							</div>
						</div>
					<fieldset class="ui-grid-a unwrap-button">
						<div class="ui-block-a"><a href="<?php echo ru; ?>locked/<?php echo $unlock['delivery_id']; ?>" style="text-decoration:none" data-ajax="false"><input value="Locked iftGift" data-theme="a" type="button"></a></div>
						<?php if($unlock['release_request'] == 0 && $unlock['release_request_respond'] == '') { ?>
						<div class="ui-block-b"><a href="#popupDialog-<?php echo $unlock['delivery_id']; ?>" data-rel="popup" data-position-to="window" data-transition="pop" data-theme="b"><input value="Send Release Request" data-theme="b" type="button"></a></div>
						<?php } else { ?>
						<div class="ui-block-b"><input value="Pending" data-theme="b" type="button"></div>
						<?php } ?>
					</fieldset>
				</div>
			</li>
			<?php } } ?>
		</ul>
		<ul id="toggle-view">
			<?php
				$delveryOpn = $db->get_results("select * from ".tbl_delivery." where recp_email = '".$email."' and open_status = '2'",ARRAY_A);
				if($delveryOpn) {
				foreach($delveryOpn as $open) { 
			?>
			<li>
				<div class="ui-block-a purple">&nbsp;</div>
				<div class="ui-block-b purple"><?php echo ucfirst($open['giv_first_name']).'&nbsp;'.ucfirst($open['giv_last_name']); ?></div>
				<?php
				$view_occs = $db->get_row("select * from ".tbl_occasion." where occasionid = '".$open['occassionid']."'",ARRAY_A);
				?>
				<div class="ui-block-c purple"><?php echo $view_occs['occasion_name'];?></div>
				<span class="ui-block-d"><img src="<?php echo ru_resource;?>images/plus_sign.png" /></span>
				<div class="panel">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Notification: 
					<?php $timestamps = strtotime($open['date']);
					echo $notify_date = date('m/d/y', $timestamps);?> @ <?php echo $open['time'];?></div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel panel-b">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Unlock: <span>
					<?php 
					$timestamps = strtotime($open['unlock_date']);
					echo $unlock_date = date('m/d/y', $timestamps);?> @ <?php echo $open['unlock_time'];?></span></div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Unwrap</div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel panel-b">
					<div class="ui-block-a">&nbsp;</div>
					<?php if($open['release_request'] == 1 && $open['release_request_respond'] == 'open_immediately' ) { 
							$release_Request = "RELEASE".'&nbsp;'.$unlock_date.'&nbsp;'.$open['unlock_time'];
						  } else if($open['release_request'] == 1 && $open['release_request_respond'] == 'change_release' ) {
						  	$release_Request = "REVISED".'&nbsp;'.$unlock_date.'&nbsp;'.$open['unlock_time'];
						  } else if($open['release_request'] == 1 && $open['release_request_respond'] == 'keep_release' ) {
						  	$release_Request = "REINSTATED".'&nbsp;'.$unlock_date.'&nbsp;'.$open['unlock_time'];
						  }
					?>
					<div class="ui-block-b">Release Request: <span><?php echo $release_Request; ?></span></div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel">
					<div data-role="popup" id="popupDialog-<?php echo $open['delivery_id']; ?>" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:400px;">
							<div data-role="header" data-theme="a">
								<h1>iftGift eCard</h1>
								<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b closed" title="Closed" data-rel="back"></a>
							</div>
							<div role="main" class="ui-content">
								<img src="<?php echo ru_resource;?>images/jester_ecard.jpg" alt="Jester ECard Image" />
								<form id="sndEmail" action="<?php echo ru; ?>process/process_thankmail.php" method="post" data-ajax="false">
								<input name="delivery_id" id="delivery_id" value="<?php echo $open['delivery_id']; ?>" type="hidden">
								<input name="giv_email" id="giv_email" value="<?php echo $open['giv_email']; ?>" type="hidden">
								<input name="recp_email" id="recp_email" value="<?php echo $open['recp_email']; ?>" type="hidden">
								<input name="giv_name" id="giv_name" value="<?php echo $open['giv_first_name']; ?>" type="hidden">
								<input name="recp_name" id="recp_name" value="<?php echo $open['recp_first_name']; ?>" type="hidden">
								<input name="ThankMail" id="ThankMail" value="ThankMail" type="hidden">
								<div class="ui-field-contain">
									<label for="textinput-1">Fill in your desired text to accompany your iftGift.</label>
									<input name="subject" id="textinput-1" placeholder="Text input" value="" type="text">
								</div>
								<div class="ui-field-contain">
									<textarea cols="40" rows="8" name="message" id="textarea-1"></textarea>
								</div>
								<div class="ui-field-contain send_btn">
									<button onclick="Thankform()" type="button" id="submit-1" class="ui-shadow ui-btn ui-corner-all">Submit</button>
								</div>
								</form>
							</div>
						</div>
					<fieldset class="ui-grid-a unwrap-button">
						<div class="ui-block-a pink-button"><a href="<?php echo ru; ?>open_iftgift/<?php echo $open['delivery_id']; ?>" style="text-decoration:none" data-ajax="false"><input value="Open iftGift" data-theme="a" type="button" ></a></div>
						<?php if($open['thank_mail'] == 0) { ?>
						<div class="ui-block-b blue-button" id="send_thank"><a href="#popupDialog-<?php echo $open['delivery_id']; ?>" data-rel="popup" data-position-to="window" data-transition="pop" data-theme="b"> Send Thank You</a></div>
						<?php } ?>
					</fieldset>
				</div>
			</li>
			<?php } } ?>	
		</ul>
		<ul id="toggle-view">
			<?php
				$delveryUnwrp = $db->get_results("select * from ".tbl_delivery." where recp_email = '".$email."' and unwrap_status = '3'",ARRAY_A);
				if($delveryUnwrp) {
				foreach($delveryUnwrp as $unwrap) { 
			?>
			<li>
				<div class="ui-block-a dark-grayb"><a href="javascript:;" onclick="del_unwrap('<?php echo $unwrap['delivery_id']; ?>');"><img src="<?php echo ru_resource;?>images/cross_sign.png" alt="Cross Icon" /></a></div>
				<div class="ui-block-b dark-gray"><?php echo ucfirst($unwrap['giv_first_name']).'&nbsp;'.ucfirst($unwrap['giv_last_name']); ?></div>
				<?php
				$view_occs = $db->get_row("select * from ".tbl_occasion." where occasionid = '".$unwrap['occassionid']."'",ARRAY_A);
				?>
				<div class="ui-block-c dark-gray"><?php echo $view_occs['occasion_name'];?></div>
				<span class="ui-block-d"><img src="<?php echo ru_resource;?>images/plus_sign.png" /></span>
				<div class="panel">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Notification:
					<?php $timestamps = strtotime($unwrap['date']);
					echo $notify_date = date('m/d/y', $timestamps);?> @ <?php echo $unwrap['time'];?>
					</div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel panel-b">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Unlock: <span>
					<?php 
					$timestamps = strtotime($unwrap['unlock_date']);
					echo $unlock_date = date('m/d/y', $timestamps);?> @ <?php echo $unwrap['unlock_time'];?>
					</span></div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Unwrap:
					<?php 
					$timestamps = strtotime($unwrap['dated']);
					echo $unlock_date = date('m/d/y', $timestamps);?> @ <?php echo date('h:i A',$unwrap['dated']);?>
					</div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel panel-b">
					<div class="ui-block-a">&nbsp;</div>
					<?php if($unwrap['release_request'] == 1 && $unwrap['release_request_respond'] == 'open_immediately' ) { 
							$release_Request = "RELEASE".'&nbsp;'.$unlock_date.'&nbsp;'.$unwrap['unlock_time'];
						  } else if($unwrap['release_request'] == 1 && $unwrap['release_request_respond'] == 'change_release' ) {
						  	$release_Request = "REVISED".'&nbsp;'.$unlock_date.'&nbsp;'.$unwrap['unlock_time'];
						  } else if($unwrap['release_request'] == 1 && $unwrap['release_request_respond'] == 'keep_release' ) {
						  	$release_Request = "REINSTATED".'&nbsp;'.$unlock_date.'&nbsp;'.$unwrap['unlock_time'];
						  }
					?>
					<div class="ui-block-b">Release Request: <span><?php echo $release_Request; ?></span></div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel">
					<fieldset class="ui-grid-a unwrap-button">
						<div class="ui-block-a gray-button"><a href="<?php echo ru; ?>unwraped/<?php echo $unwrap['delivery_id']; ?>" style="text-decoration:none" data-ajax="false"><input value="Unwrapped" data-theme="a" type="button"></a></div>
						<div data-role="popup" id="popupDialog-<?php echo $unwrap['delivery_id']; ?>" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:400px;">
							<div data-role="header" data-theme="a">
								<h1>iftGift eCard</h1>
								<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b closed" title="Closed" data-rel="back"></a>
							</div>
							<div role="main" class="ui-content">
								<img src="<?php echo ru_resource;?>images/jester_ecard.jpg" alt="Jester ECard Image" />
								<form id="sndEmail" action="<?php echo ru; ?>process/process_thankmail.php" method="post" data-ajax="false">
								<input name="delivery_id" id="delivery_id" value="<?php echo $unwrap['delivery_id']; ?>" type="hidden">
								<input name="giv_email" id="giv_email" value="<?php echo $unwrap['giv_email']; ?>" type="hidden">
								<input name="recp_email" id="recp_email" value="<?php echo $unwrap['recp_email']; ?>" type="hidden">
								<input name="giv_name" id="giv_name" value="<?php echo $unwrap['giv_first_name']; ?>" type="hidden">
								<input name="recp_name" id="recp_name" value="<?php echo $unwrap['recp_first_name']; ?>" type="hidden">
								<input name="ThankMail" id="ThankMail" value="ThankMail" type="hidden">
								<div class="ui-field-contain">
									<label for="textinput-1">Fill in your desired text to accompany your iftGift.</label>
									<input name="subject" id="textinput-1" placeholder="Text input" value="" type="text">
								</div>
								<div class="ui-field-contain">
									<textarea cols="40" rows="8" name="message" id="textarea-1"></textarea>
								</div>
								<div class="ui-field-contain send_btn">
									<button onclick="Thankform()" type="button" id="submit-1" class="ui-shadow ui-btn ui-corner-all">Submit</button>
								</div>
								</form>
							</div>
						</div>
						<?php if($unwrap['thank_mail'] == 0) { ?>
						<div class="ui-block-b blue-button" id="send_thank"><a href="#popupDialog-<?php echo $unwrap['delivery_id']; ?>" data-rel="popup" data-position-to="window" data-transition="pop" data-theme="b"> Send Thank You</a></div>
						<?php } ?>
					</fieldset>
				</div>
			</li>
			<?php } } ?>
		</ul>
		<script type="text/javascript">
		function ReleaseRequests(){
		document.getElementById("Releaserequest").submit()	
		}
		
		function Thankform(){
		document.getElementById("sndEmail").submit()	
		}
		
		function del_unwrap(id)
		{
			var dId = id;
			$.ajax({
			url: '<?php echo ru;?>process/process_unwrap.php?dId='+dId,
			type: 'get', 
			success: function(output) {
			if(output == 'Success')
			{
				window.location = "<?php echo ru?>unwrap";
			}
			}
			});
		}
		</script>
	</div>
	<div role="main" class="ui-content unwrap-content">
		<p>After 30 days, all unwrapped iftGifts are automatically transferred to your <a href="<?php echo ru;?>inbox" data-ajax="false">In.Box Archive</a></p>
		<p class="tran_manull">To transfer manually click <a href="#"><img src="<?php echo ru_resource;?>images/cross_sign.jpg" /></a></p>
		<div class="ui-field-contain ui-field-contain-b">
			<label>Party Mode!</label>
			<select name="flip-5" id="flip-5" data-role="slider" data-mini="true">
				<option value="off">Off</option>
				<option value="on">On</option>
			</select>
		</div>
		<p class="dip_gift">Display your IftGifts, but keep cash amounts private</p>
	</div>