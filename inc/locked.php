<?php
$timestamps = strtotime($get_dev['unlock_date']);
$unlock_date = date('M d, Y', $timestamps);	
$unlock_time = $get_dev['unlock_time'];
$f_date = $unlock_date.' '.$unlock_time;

$date = strtotime($f_date);
$remaining = $date - time();
$diffweek = floor($remaining/ 604800);
$days_remaining = floor($remaining / 86400);
$hours_remaining = floor(($remaining % 86400) / 3600);
$min = floor(($remaining % 3600) / 60);
$sec = ($remaining % 60);
?>

<style>.ift_block h4.recip{width:98%; text-align:center; margin-left:1%}</style>
	<p class="dip_gift">Unlocks in</p>
	<div role="main" class="ui-content unwrap-content">
		<div class="ui-grid-d unlock-time">
			<span id="countdown"></span>
		</div><!-- /grid-c -->
		<script type="text/javascript">
		// set the date we're counting down to
		var target_date = new Date("<?php echo $f_date;?>");
		// variables for time units
		var weeks, days, hours, minutes, seconds;
		
		// get tag element
		var countdown = document.getElementById("countdown");
		
		// update the tag with id "countdown" every 1 second
		setInterval(function () {
		
		// find the amount of "seconds" between now and target
		var current_date = new Date().getTime();
		var seconds_left = (target_date - current_date) / 1000;
		
		// do some time calculations
		weeks = parseInt(seconds_left / 604800);
		//secondss_left = seconds_left % 604800;
		
		days = parseInt(seconds_left / 86400);
		seconds_left = seconds_left % 86400;
		 
		hours = parseInt(seconds_left / 3600);
		seconds_left = seconds_left % 3600;
		 
		minutes = parseInt(seconds_left / 60);
		seconds = parseInt(seconds_left % 60);
		 
		// format countdown string + set tag value
		countdown.innerHTML ="<div class='ui-block-a'><div class='ui-bar ui-bar-a'>"+weeks+"</div>weeks</div><div class='ui-block-b'><div class='ui-bar ui-bar-a'>"+days+"</div>days</div><div class='ui-block-c'><div class='ui-bar ui-bar-a'>"+hours+"</div>Hours</div><div class='ui-block-d'><div class='ui-bar ui-bar-a'>"+minutes+"</div>Min</div><div class='ui-block-e'><div class='ui-bar ui-bar-a'>"+seconds+"</div>Sec</div>"
		}, 1000);
		</script>

		<?php
		$timestamps = strtotime($get_dev['unlock_date']);
		$unlock_date = date('l F d, Y', $timestamps);
		?>
		<div class="user_time_details"><?php echo $unlock_date?> @ <?php echo $get_dev['unlock_time']; ?></div>
	</div>
	<div role="main" class="ui-content jqm-content jqm-content-c">
		<img src="<?php echo ru_resource;?>images/safe_icon.jpg" />
		<?php if($get_dev['release_request'] == 0) { ?>
		<a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop" data-theme="b" class="ui-btn ui-btn-c">Release Request</a>
		<?php } ?>
		<div data-role="popup" id="popupDialog" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:400px;">
							<div data-role="header" data-theme="a">
								<h1>iftGift Release Request</h1>
								<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b closed" title="Closed" data-rel="back"></a>
							</div>
							<div role="main" class="ui-content">
								<form id="Releaserequest" action="<?php echo ru; ?>process/process_releaserequest.php" method="post" data-ajax="false">
								<input name="delivery_id" id="delivery_id" value="<?php echo $get_dev['delivery_id']; ?>" type="hidden">
								<input name="giv_email" id="giv_email" value="<?php echo $get_dev['giv_email']; ?>" type="hidden">
								<input name="recp_email" id="recp_email" value="<?php echo $get_dev['recp_email']; ?>" type="hidden">
								<input name="giv_name" id="giv_name" value="<?php echo $get_dev['giv_first_name']; ?>" type="hidden">
								<input name="recp_name" id="recp_name" value="<?php echo $get_dev['recp_first_name']; ?>" type="hidden">
								<input name="unlock_date" id="unlock_date" value="<?php echo $get_dev['unlock_date']; ?>" type="hidden">
								<input name="unlock_time" id="unlock_time" value="<?php echo $get_dev['unlock_time']; ?>" type="hidden">
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
		<script type="text/javascript">
		function ReleaseRequests(){
		document.getElementById("Releaserequest").submit()	
		}
		</script>				
		<div class="ui-grid-a contains">
			<div class="ui-block-a"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_a.jpg" alt="Box A Icon" /></a></div></div>
			<div class="ui-block-b"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_b.jpg" alt="Box b Icon" /></a></div></div>
			<div class="ui-block-a"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_c.jpg" alt="Box c Icon" /></a></div></div>
			<div class="ui-block-b"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_d.jpg" alt="Box D Icon" /></a></div></div>
			<div class="ui-block-a"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_e.jpg" alt="Box E Icon" /></a></div></div>
			<div class="ui-block-b"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_f.jpg" alt="Box F Icon" /></a></div></div>
		</div><!-- /grid-a -->
	</div>