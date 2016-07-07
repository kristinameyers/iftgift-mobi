<?php
$userId = $_SESSION['LOGINDATA']['USERID'];
$get_user = $db->get_row("select * from ".tbl_user." where userId = '".$userId."'",ARRAY_A);
$email = $get_user['email'];

$get_reminder = $db->get_row("select count(inbox) as cnt from ".tbl_delivery." where recp_email = '".$email."' and inbox = '1' GROUP BY inbox HAVING Count( inbox )",ARRAY_A); 
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
		<h2>InBox: iftGifts You've Received</h2>
		<div class="dashbd wnwrap remdt">
			<h4 class="recip accm">You have received</h4>
			<div class="count">
				<input name="textinput-1" id="textinput-1" placeholder="Text input" value="<?php  if($get_reminder > 0 ) { echo $get_reminder['cnt']; } else { echo '0';} ?>" type="text">
			</div>
			<h4 class="recip accm">iftGifts</h4>
		</div>
	</div>
	
	<div role="main" class="ui-content unwrap-content jqm-content jqm-content-c">
		<ul id="toggle-view">
			<li class="remd_title">
				<div class="ui-block-a"></div>
				<div class="ui-block-b">From</div>
				<div class="ui-block-c">Ocassion</div>
				<span class="ui-block-d"></span>
			</li>
		<script type="text/javascript">
		$(document).ready(function () {
			$('span').on('click', function () {
				var id = this.id;
				var getImgId =  id.split("-");
				var divid = getImgId[1]; 
				if ($('#panel-'+divid).css("display")=="none") {
					$('#remd_list-'+divid).addClass('active');
					$('#test-'+divid).css('background','#ae2ee3');
				} else {
					$('#remd_list-'+divid).removeClass('active');
					$('#test-'+divid).css('background','#969492');
				}	
			});
			
		});
		</script>
		<?php
		$delveryOpn = $db->get_results("select * from ".tbl_delivery." where recp_email = '".$email."' and inbox = '1'",ARRAY_A);
		if($delveryOpn) {
		foreach($delveryOpn as $open) { 
		?>
			<li>
				<div class="ui-block-c" id="test-<?php echo $open['delivery_id'];?>" style="background:#969492;width: 10%;">&nbsp;</div>
				<div class="remd_list" id="remd_list-<?php echo $open['delivery_id']; ?>">
					<div class="ui-block-b"><?php echo ucfirst($open['giv_first_name']).'&nbsp;'.ucfirst($open['giv_last_name']); ?></div>
					<?php
				$view_occs = $db->get_row("select * from ".tbl_occasion." where occasionid = '".$open['occassionid']."'",ARRAY_A);
				?>
					<div class="ui-block-c"><?php echo $view_occs['occasion_name'];?></div>
				</div>	
				<span class="ui-block-d" id="remd_arrow-<?php echo $open['delivery_id'];?>"><img src="<?php echo ru_resource;?>images/plus_sign.png" /></span>
					<div class="panel" id="panel-<?php echo $open['delivery_id']; ?>">
						<div class="ui-block-a">&nbsp;</div>
						<div class="ui-block-b">Notification: 
						<?php $timestamps = strtotime($open['date']);
						echo $notify_date = date('m/d/y', $timestamps);?> @ <?php echo $open['time'];?></div>
						<div class="ui-block-c">&nbsp;</div>
					</div>
				<div class="panel panel-b">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Unlock:
					<?php 
					$timestamps = strtotime($open['unlock_date']);
					echo $unlock_date = date('m/d/y', $timestamps);?> @ <?php echo $open['unlock_time'];?></div>
					<div class="ui-block-c">&nbsp;</div>
				</div>
				<div class="panel">
					<div class="ui-block-a">&nbsp;</div>
					<div class="ui-block-b">Unwrap:
					<?php
					$timestamps = strtotime($open['dated']);
					echo $unlock_date = date('m/d/y', $timestamps);?> @ <?php echo date('h:i A',$open['dated']);?></div>
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
									<button onclick="Thankform2()" type="button" id="submit-1" class="ui-shadow ui-btn ui-corner-all">Submit</button>
								</div>
								</form>
							</div>
						</div>
				<div class="panel">
					<fieldset class="ui-grid-a unwrap-button">
					<?php if($open['thank_mail'] == '0') {?>
						<div class="ui-block-a"><a href="#popupDialog-<?php echo $open['delivery_id']; ?>" data-rel="popup" data-position-to="window" data-transition="pop" data-theme="b"><input value="Thank you due" data-theme="a" type="button"></a></div>
						<?php } else { ?>
						<div class="ui-block-a" style="border:none"></div>
						<?php } ?>
						<div class="ui-block-b blue-button"><a href="<?php echo ru; ?>step_1" style="text-decoration:none" data-ajax="false"><input value="Send an iftGift" data-theme="b" type="button"></a></div>
						<div class="ui-block-a gray-button"><a href="<?php echo ru; ?>unwraped/<?php echo $open['delivery_id']; ?>" style="text-decoration:none" data-ajax="false"><input value="View unwrapped iftGift" data-theme="a" type="button" ></a></div>
					</fieldset>
				</div>
			</li>
		<?php } } ?>	
		</ul>
	</div>
<script type="text/javascript">
function Thankform2(){
		document.getElementById("sndEmail").submit()	
		}
</script>	