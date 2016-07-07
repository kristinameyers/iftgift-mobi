<?php
$userId = $_SESSION['LOGINDATA']['USERID'];
$get_user_info = $db->get_row("select * from ".tbl_user." where userId = '".$userId."'",ARRAY_A);
$giver_email = $get_user_info['email'];
$get_user_dev = $db->get_results("select distinct(recp_email) from ".tbl_delivery." where giv_email = '".$giver_email."'",ARRAY_A);
if($get_user_dev) {
	foreach($get_user_dev as $users) {
		$recp_email = $users['recp_email'];
 		$get_recp_info = $db->get_results("select distinct(recp_email) from ".tbl_delivery." where giv_email = '".$recp_email."'",ARRAY_A);
		if($get_recp_info) {
			foreach($get_recp_info as $users2) {
			$recp_email2 = $users2['recp_email'];
			if($giver_email == $recp_email2) {
				$friend_count = count($recp_email2);
			 	$totalfriend_count += $friend_count;
				$query = mysql_fetch_array(mysql_query("select userId from ".tbl_user." where email = '".$recp_email."'"));
				$get_user_points = mysql_fetch_array(mysql_query("select * from ".tbl_userpoints." where userId = '".$query['userId']."'"));
				$points = $get_user_points['points'];
				$total += $points;
				} 
	  		}	
		}
	}
}
?>

<script type="text/javascript">	
	$(document).ready(function () {
		$('.icon').on('click', function () {
			var id = this.id;
			var getImgId =  id.split("-");
			var divid = getImgId[1];
		if ($('#remd_form-'+divid).css("display")=="none") { 
			$('#remd_form-'+divid).slideDown('slow');
			$('#icon-'+divid).html('<img src="<?php echo ru_resource;?>images/nagative_sign.png" />');
			$('#creat_remd-'+divid).addClass('active');
		} else {
			$('#remd_form-'+divid).slideUp('slow');
			$('#icon-'+divid).html('<img src="<?php echo ru_resource;?>images/plus_sign.png" />');
			$('#creat_remd-'+divid).removeClass('active');
		}	
		});
	});
</script>

<div class="sugg_top sugg_top_b">
		<h2><span>i</span><span class="f">f</span><span class="t">t</span>CLIQUE</h2>
		<div class="dashbd wnwrap">
			<h4 class="recip accm">The are</h4>
			<div class="count">
				<input name="textinput-1" id="textinput-1" placeholder="Text input" value="<?php  if($totalfriend_count > 0 ) { echo $totalfriend_count; } else { echo '0';} ?>" type="text">
			</div>
			<h4 class="recip accm">in your iftClique</h4>
		</div>
	</div>
	
	<div role="main" class="ui-content unwrap-content jqm-content jqm-content-c">
		<div class="remd_top">
			<div class="creat_remd" id="creat_remd-stats">View Your iftClique Stats</div>
			<div class="icon" id="icon-stats"><img src="<?php echo ru_resource;?>images/plus_sign.png" /></div>
		</div>
		<div id="remd_form-stats" style="display:none">
			<p class="ift_stats"><span>Your iftClique's Total Friends</span> <span class="ift_point"><?php echo $totalfriend_count; ?></span></p>
			<p class="ift_stats"><span>Your IftClique's Total Points</span> <span class="ift_point"><?php echo $total; ?></span></p>
			<p class="ift_stats"><span>Your iftClique's Point Average</span> <span class="ift_point">1,800</span></p>
			<p class="ift_stats"><span>Your Personal Point Rank</span> <span class="ift_point">12th</span></p>
			<p class="ift_stats"><span><b>Largest Systemwide iftClique</b></span></p>
			<p class="ift_stats"><span>For Number of friends</span> <span class="ift_point">5,000</span></p>
			<p class="ift_stats"><span>For Number of Points</span> <span class="ift_point">575,000</span></p>
		</div>
		
		<div class="remd_top">
			<div class="creat_remd" id="creat_remd-shut">Shout Out</div>
			<div class="icon" id="icon-shut"><img src="<?php echo ru_resource;?>images/plus_sign.png" /></div>
		</div>
		<div id="remd_form-shut" style="display:none">
			<div class="shut_form">
				<p>Email the Members of Your iftClique</p>
				<img src="<?php echo ru_resource;?>images/jester_f.jpg" />
				<div data-role="popup" id="popupDialog" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:400px;">
							<div data-role="header" data-theme="a">
								<h1>iftGift Invitation</h1>
								<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b closed" title="Closed" data-rel="back"></a>
							</div>
							<div role="main" class="ui-content">
								<form id="sndEmail" action="<?php echo ru; ?>process/process_thankmail.php" method="post" data-ajax="false">
								<input name="delivery_id" id="delivery_id" value="<?php echo $unwrap['delivery_id']; ?>" type="hidden">
								<input name="giv_email" id="giv_email" value="<?php echo $unwrap['giv_email']; ?>" type="hidden">
								<input name="recp_email" id="recp_email" value="<?php echo $unwrap['recp_email']; ?>" type="hidden">
								<input name="giv_name" id="giv_name" value="<?php echo $unwrap['giv_first_name']; ?>" type="hidden">
								<input name="recp_name" id="recp_name" value="<?php echo $unwrap['recp_first_name']; ?>" type="hidden">
								<input name="ThankMail" id="ThankMail" value="ThankMail" type="hidden">
								<div class="ui-field-contain">
									<label for="textinput-1">Fill in your desired text asking (Recipient Name) to join iftGift.</label>
									<input name="subject" id="textinput-1" placeholder="Subject" value="" type="text">
								</div>
								<div class="ui-field-contain">
									<textarea cols="40" rows="8" name="message" id="textarea-1" placeholder="[Enter Your Text Here]"></textarea>
								</div>
								<div class="ui-field-contain send_btn">
									<button onclick="Thankform()" type="button" id="submit-1" class="ui-shadow ui-btn ui-corner-all">Send</button>
								</div>
								</form>
							</div>
						</div>
				<div class="ui-block-a"><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop" data-theme="b"><input value="Select" data-theme="a" type="button"></a></div>
			</div>
		</div>
		<div class="remd_top">
			<div class="creat_remd" id="creat_remd-expand">Expand Your iftClique</div>
			<div class="icon" id="icon-expand"><img src="<?php echo ru_resource;?>images/plus_sign.png" /></div>
		</div>
		<div id="remd_form-expand" style="display:none">
			<form method="post" id="register" action="" data-ajax="false">
				<div class="ui-field-contain field">
					<input name="fname" id="fname" placeholder="Enter Name" value="<?php echo $_SESSION['register']['fname'];?>" type="text">
				</div>
				<div class="ui-field-contain field">
					<input name="email" id="email" placeholder="Enter E-mail" value="<?php echo $_SESSION['register']['email'];?>" type="text">
				</div>
				<div class="ui-block-a"><a href="#" data-ajax="false"><input value="Invite Via Email" data-theme="a" type="button"></a></div>
				<div class="expand_right">
					<p>Invite to Your iftClique Via</p>
					<div class="social_icon">
						<a href="#"></a>
						<a href="#" class="f"></a>
						<a href="#" class="t"></a>
						<a href="#" class="g"></a>
						<a href="#" class="e"></a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="browse_cat browse_cat_c">What's Up With Your iftClique ?</div>
	<div role="main" class="ui-content unwrap-content jqm-content jqm-content-c">
		<div id="friends_iftClique"></div>
	</div>
	<div class="flexslider carousel">
		<ul class="slides">
		<?php
			$array = $get_user_dev;
			$count_array = count($array);
			$count       = 0;
			foreach($get_user_dev as $users) {
			$recp_email = $users['recp_email'];
			$get_recp_info = $db->get_results("select distinct(recp_email) from ".tbl_delivery." where giv_email = '".$recp_email."'",ARRAY_A);
			if($get_recp_info) {
			foreach($get_recp_info as $users2) {
			$recp_email2 = $users2['recp_email'];
			if($giver_email == $recp_email2) {	
			$query = mysql_fetch_array(mysql_query("select * from ".tbl_user." where email = '".$recp_email."'"));
			if($query['user_image']) {	
				$user_image = ru."media/user_image/".$query['userId']."/".$query['user_image']; 
			} else {
				$user_image = ru_resource."images/profile_img.jpg";
			}
    		$count++;
			if ($count % 4 == 1) {
		?>
			<li>
				<ul class="cros">
		<?php } ?>		
					<li onclick="friendimg('<?php echo $query['userId']; ?>')" id="friend_<?php echo $query['userId']; ?>">
						<span><?php echo ucfirst($query['first_name']).'&nbsp;'.ucfirst($query['last_name']); ?></span>
						<img src="<?php echo $user_image;?>" alt="Friend Image" width="130px" height="130px" style="border-color:#c71dec"/>
					</li>	
					<?php if ($count % 4 == 0 || $count_array == $count) {?>	
				</ul>
			</li>	
				<?php } ?>
			<?php } } } } ?>
  	    </ul>
	</div>
<script type="text/javascript">
function friendimg(id) {
	var userId = id;
	$.ajax({
			url: '<?php echo ru;?>process/get_friendiftclique.php?dId='+userId,
			type: 'get', 
			success: function(output) {
				$("#friends_iftClique").html(output);
				$("li.active").removeClass("active");
				$("#friend_"+userId).toggleClass('active');
			}
	}); 
}

	$(function(){
		SyntaxHighlighter.all();
		});
			$(window).load(function(){
				$('.flexslider').flexslider({
				animation: "slide",
				animationLoop: false,
				//itemWidth: 210,
				//itemMargin: 5,
				pausePlay: false,
				start: function(slider){
				$('body').removeClass('loading');
			}
		});
	});
</script>