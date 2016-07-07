<?php
$userId = $_SESSION['LOGINDATA']['USERID'];
$get_user = $db->get_row("select * from ".tbl_user." where userId = '".$userId."'",ARRAY_A);
$email = $get_user['email']; 
$get_delivery = $db->get_row("select count(recp_email) as cnt from ".tbl_delivery." where recp_email = '".$email."' and deliverd_status = 'deliverd' and (unlock_status = '1' or open_status = '2') GROUP BY recp_email HAVING Count( recp_email )",ARRAY_A);

$get_reminders = $db->get_row("select count(userId) as cnt from ".tbl_reminder." where userId = '".$userId."' GROUP BY userId HAVING Count( userId )",ARRAY_A);

$current_date = date('Y-m-d');
$date = date('Y');
$json_response = file_get_contents("http://holidayapi.com/v1/holidays?country=US&year=".$date);
$obj = json_decode($json_response);
foreach($obj->holidays as $val) {
if($current_date < $val[0]->date) {
$count_rem = count($val[0]->name);
$upcmp_reminder += $count_rem;
} } 
$get_reminder = $upcmp_reminder + $get_reminders['cnt'];
?>
<script type="text/javascript" language="javascript">
   		$(document).ready(function() {
			$("#down-arrow").click(function () {
				$(".listing").slideToggle("slow")
	  		});
			
			$(".cross_icon").click(function (){
				$("#demo-page").slideToggle()
			});	
	  	});
	</script>
	<div role="main" class="ui-content jqm-content jqm-content-c">
		<h2>SEND</h2>
		<div class="dashbd">
			<h3 class="remd">You have</h3>
			<div class="count">
				<input name="textinput-1" id="textinput-1" placeholder="Text input" value="<?php  if($get_reminder > 0 ) { echo $get_reminder; } else { echo '0';} ?>" type="text">
				<a href="#" id="down-arrow"></a>
			</div>
			<div data-url="demo-page" data-role="page" id="demo-page" data-title="Inbox" style="display:none" class="listing">
				<div data-role="header" data-position="fixed" data-theme="b">
					<h1>Your Reminders</h1>
					<a href="#" class="cross_icon"><img src="<?php echo ru_resource?>images/cross_sign_b.png" /></a>
				</div><!-- /header -->
				<div role="main" class="ui-content">
					<ul id="list" class="touch" data-role="listview" data-icon="false" data-split-icon="delete" style="display:block">
					<?php
						$current_date = date('Y-m-d');
						$date = date('Y');
						$json_response = file_get_contents("http://holidayapi.com/v1/holidays?country=US&year=".$date);
						$obj = json_decode($json_response);
						foreach($obj->holidays as $val) {
						if($current_date < $val[0]->date) {
					?>
					<li>
							<a href="#demo-mail">
								<img src="<?php echo ru_resource?>images/list_img.png" alt="User List Image" />
								<h3><?php echo $val[0]->name; ?></h3>
								<?php
								$timestamps = strtotime($val[0]->date);
								$events_date = date('M d, Y', $timestamps)
								?>
								<p class="topic"><strong><?php echo $events_date;?></strong></p>
							</a>
							<a href="javascript:;" onclick="del_reminder('<?php echo $reminder['reminder_id']; ?>');" class="delete">Delete</a>
							<button class="list_btn" onclick="send_gift()">Send an iftGift</button>
						</li>
					<?php } } ?>	
					<?php
						$reminder_Qry = "select * from ".tbl_reminder." where userId = '".$userId."' limit 0,10";
						$view_reminder = $db->get_results($reminder_Qry,ARRAY_A);
						if($view_reminder) {
						foreach($view_reminder as $reminder) {
					?>	
						<li>
							<a href="#demo-mail">
								<img src="<?php echo ru_resource?>images/list_img.png" alt="User List Image" />
								<h3><?php echo $reminder['event_name']; ?></h3>
								<?php
								$timestamps = strtotime($reminder['dated']);
								$notify_date = date('M d, Y', $timestamps)
								?>
								<p class="topic"><strong><?php echo $notify_date;?></strong></p>
							</a>
							<a href="javascript:;" onclick="del_reminder('<?php echo $reminder['reminder_id']; ?>');" class="delete">Delete</a>
							<button class="list_btn" onclick="send_gift()">Send an iftGift</button>
						</li>
						<?php } } ?>
					</ul>
					<script type="text/javascript">
					function send_gift()
					{
						window.location = "<?php echo ru?>step_1";
					}
					</script>
				</div><!-- /content -->
				<div data-role="header" data-position="fixed" data-theme="b" class="list_footer">
					<a href="<?php echo ru;?>reminder" data-ajax="false" class="ui-btn">Go to Reminder Library ></a>
				</div><!-- /Footer -->
				<div id="confirm" class="ui-content" data-role="popup" data-theme="a">
					<p id="question">Are you sure you want to delete:</p>
					<div class="ui-grid-a">
						<div class="ui-block-a">
							<a id="yes" class="ui-btn ui-corner-all ui-mini ui-btn-a" data-rel="back">Yes</a>
						</div>
						<div class="ui-block-b">
							<a id="cancel" class="ui-btn ui-corner-all ui-mini ui-btn-a" data-rel="back">Cancel</a>
						</div>
					</div>
				</div><!-- /popup -->
			</div>
			<h3 class="remd">reminders</h3>
		</div>
		<img src="<?php echo ru_resource?>images/jester.jpg" alt="Jester Image" />
		<a href="<?php echo ru;?>step_1" data-ajax="false" class="ui-btn">Send an iftGift</a>
	</div>
	<div role="main" class="ui-content jqm-content jqm-content-c">
		<h2 class="wrap">UNWRAP</h2>
		<div class="dashbd">
			<h3 class="remd wrap">You have</h3>
			<div class="count">
				<input name="textinput-1" id="textinput-1" placeholder="Text input" class="unwrap" value="<?php  if($get_delivery > 0 ) { echo $get_delivery['cnt']; } else { echo '0';} ?>" type="text">
				<a href="<?php echo ru;?>unwrap" data-ajax="false" id="down-arrow" class="down-arrow-b"></a>
			</div>
			<h3 class="remd wrap">active gifts</h3>	
		</div>
		<img src="<?php echo ru_resource?>images/jester_b.jpg" alt="Jester Image" />
		<a href="<?php echo ru?>unwrap" data-ajax="false" class="ui-btn ui-btn-b">Unwrap an iftGift</a>
	</div>
<script type="text/javascript">
function del_reminder(id) {
	var dId = id;
	$.ajax({
	url: '<?php echo ru;?>process/process_reminder.php?dId='+dId,
	type: 'get', 
	success: function(output) {
		if(output == 'Success')
		 {
			window.location = "<?php echo ru?>dashboard";
	   	}
	 }
	});
}
</script>	