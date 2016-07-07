<?php
include_once("../connect/connect.php");
include_once("../config/config.php");

$userId = $_GET['dId'];
$friend_info = mysql_fetch_array(mysql_query("select * from ".tbl_user." where userId = ".$userId.""));
if($friend_info['user_image']) {	
		$user_image = ru."media/user_image/".$friend_info['userId']."/".$friend_info['user_image']; 
	} else {
		$user_image = ru_resource."images/profile_img.jpg";
	}
$friend_points = mysql_fetch_array(mysql_query("select * from ".tbl_userpoints." where userId = ".$userId.""));	

$friend_dev_detail = mysql_fetch_array(mysql_query("select * from ".tbl_delivery." where recp_email = '".$friend_info['email']."' order by delivery_id desc"));	
$timestamps = strtotime($friend_dev_detail['dated']);
$dated = date('m/d/Y', $timestamps);
?>
<div class="friend_cards">
			<div class="cards_top">
				<a href="<?php echo ru;?>dashboard" data-ajax="false">TAG, YOU'RE IT! <br/> Send and iftGift</a>
				<div class="last_gift">
					<img src="<?php echo ru_resource;?>images/gift_icon.jpg" alt="Gift Icon" />
					<h4>Last IftGift From <br/><span><strong>THEM</strong> <?php echo $dated; ?></span></h4>
				</div>
			</div>
			<div class="friendimg_bar">
				<h4><?php echo ucfirst($friend_info['first_name']).'&nbsp;'.ucfirst($friend_info['last_name']); ?></h4>
				<img src="<?php echo $user_image;?>" width="109" height="110" alt="Friend Image"  />
				<h4><?php echo $friend_points['points']; ?> Pts</h4>
				<div class="last_gift">
					<img src="<?php echo ru_resource;?>images/time_icon.jpg" alt="Time Icon" />
					<h4>Birthday <?php echo $friend_info['dob']; ?></h4>
				</div>
			</div>
			<div class="cards_top cards_top_b">
				<a href="#">TAG, Q&A IT! <br/>s'Jester Q&A</a>
				<div class="last_gift">
					<img src="<?php echo ru_resource;?>images/qa_icon.jpg" alt="Gift Icon" />
					<h4>Last Q&A From <br/><span><strong>THEM</strong> 07/06/13</span></h4>
				</div>
			</div>
			<img src="<?php echo ru_resource;?>images/jester_icon.png" alt="Gift Icon" class="jstr_icon" />
			<div class="ui-field-contain">
				<fieldset class="ui-controlgroup ui-controlgroup-vertical ui-corner-all" data-role="controlgroup">
				<div class="ui-controlgroup-label" role="heading">
					<legend>Count Em Out</legend>
					</div>
					<div class="ui-controlgroup-controls">
					<div class="ui-checkbox"><label for="checkbox-1" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-checkbox-off ui-first-child ui-last-child"></label><input type="checkbox" id="checkbox-1" name="checkbox-1"></div>
				</div>
				</fieldset>
			</div>
		</div>