<?php
if(isset($_GET['s'])) {
 $reminder_id = $_GET['s'];
 $reminders = "select * from ".tbl_reminder." where reminder_id = '".$reminder_id."'";
 $reminds = mysql_query($reminders) or die (mysql_error());
	if ( mysql_num_rows($reminds) ==0 ){
		
		header('location:'.ru.'reminder');
		exit;
	}
	
	if ( !isset ($_SESSION['biz_rem']) or ($_SESSION['biz_rem']['reminder_id'] != $reminder_id ) )
	{
		$reminder_row = mysql_fetch_array($reminds);
		$_SESSION['biz_rem'] =$reminder_row;
	}
} 
$userId = $_SESSION['LOGINDATA']['USERID'];
$get_reminder = $db->get_row("select count(userId) as cnt from ".tbl_reminder." where userId = '".$userId."' GROUP BY userId HAVING Count( userId )",ARRAY_A);
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
	
	$(document).ready(function () {
		$('.icon').click(function () {
		if ($('#remd_form').css("display")=="none") { 
			$('#remd_form').slideDown('slow');
			$('.icon').html('<img src="<?php echo ru_resource;?>images/nagative_sign.png" />');
			$('.creat_remd').addClass('active');
		} else {
			$('#remd_form').slideUp('slow');
			$('.icon').html('<img src="<?php echo ru_resource;?>images/plus_sign.png" />');
			$('.creat_remd').removeClass('active');
		}	
		})
	})
</script>

<div class="sugg_top sugg_top_b">
		<h2>REMINDER LIBRARY</h2>
		<div class="dashbd wnwrap remdt">
			<h4 class="recip accm">You have</h4>
			<div class="count">
				<input name="textinput-1" id="textinput-1" placeholder="Text input" value="<?php  if($get_reminder > 0 ) { echo $get_reminder['cnt']; } else { echo '0';} ?>" type="text">
			</div>
			<h4 class="recip accm">personal reminders</h4>
		</div>
	</div>
	
	<div role="main" class="ui-content unwrap-content jqm-content jqm-content-c">
		<div class="remd_top">
			<div class="creat_remd <?php if($_GET['s']) { ?>active<?php } else { } ?>">Create a Reminder</div>
			<?php if($_GET['s']) { ?>
			<div class="icon"><img src="<?php echo ru_resource;?>images/nagative_sign.png" /></div>
			<?php } else { ?>
			<div class="icon"><img src="<?php echo ru_resource;?>images/plus_sign.png" /></div>
			<?php } ?>
		</div>
		<div id="remd_form" <?php if($_GET['s']) { } else {?> style="display:none" <?php } ?>>
			<form id="reminderSub" method="post" action="<?php echo ru;?>process/process_reminder.php">
					<input type="hidden" name="userId" value="<?php echo $userId;?>" />
					<?php if($_GET['s']) { ?>
					<input type="hidden" name="reminder_id" value="<?php echo $reminder_id;?>" />
					<input type="hidden" name="editReminder" value="editReminder" />
					<?php } else {?>
					<input type="hidden" name="reminder" value="reminder" />
					<?php } ?>
					<div class="ui-field-contain field">
						<label for="textinput-1">Name Your Event...</label>
						<input name="event_name" id="event_name" placeholder="Event" value="<?php echo $_SESSION['biz_rem']['event_name']?>" type="text">
					</div>
					<h4 class="or_txt">OR</h4>
					<div class="ui-field-contain field select_fleid">
						<label for="select-native-1">Pick from holidays</label>
						<?php
							$date = date('Y');
							$json_response = file_get_contents("http://holidayapi.com/v1/holidays?country=US&year=".$date);
							$obj = json_decode($json_response);
						?>
						<select name="event_select" id="select-native-1">
							<option value="holidays">Holidays</option>
							<?php 
								foreach($obj->holidays as $val) {
							?>
							<option value="<?php echo $val[0]->name.'/'.$val[0]->date; ?>" <?php if($_SESSION['biz_rem']['event_select'] == $val[0]->name.'/'.$val[0]->date) echo 'selected="selected"';?>><?php echo $val[0]->name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div style="color:#FF4242"><?php echo $_SESSION['biz_rem_err']['event_name'];?></div>
					<div class="ui-field-contain field">
						<input name="celebrant" id="celebrant" placeholder="Celebrant(s)" value="<?php echo $_SESSION['biz_rem']['celebrant']?>" type="text">
					</div>
					<div style="color:#FF4242"><?php echo $_SESSION['biz_rem_err']['celebrant'];?></div>
					<div class="date_outer">
						<div class="date_inner">
						<label for="textinput-1">Set the Date:</label>
						<div class="date_flied">
							<input data-role="date" name="dated" type="text" id="datepicker" value="<?php echo $_SESSION['biz_rem']['dated']?>" placeholder="dd/mm/yy">
						</div>
						<div class="am_pm">
							<div class="ui-field-contain">
								<fieldset data-role="controlgroup" data-mini="true">
									<input name="one_time" id="checkbox-5" type="checkbox" class="example1" value="One Time" <?php if($_SESSION['biz_rem']['one_time'] == 'Annualy') {  } else { ?> checked="checked" <?php } ?>>
									<label for="checkbox-5">One-Time</label>
								</fieldset>
							</div>
							<div class="ui-field-contain">
								<fieldset data-role="controlgroup" data-mini="true">
									<input name="one_time" id="checkbox-5" type="checkbox" class="example2" value="Annualy" <?php if($_SESSION['biz_rem']['one_time'] == 'Annualy') echo 'checked="checked"'; ?>>
									<label for="checkbox-5">Annualy</label>
								</fieldset>
							</div>
						</div>
					</div>
					<div style="color:#FF4242"><?php echo $_SESSION['biz_rem_err']['dated'];?></div>
						<div class="date_inner">
							<label for="textinput-1">Remind Me At:</label>
							<div class="date_flied time">
								<input data-role="date" type="text" name="remind_me" id="timepicker_hoursss" value="<?php echo $_SESSION['biz_rem']['remind_me']?>" placeholder="07:00 PM">
							</div>
						</div>
						<div class="date_inner">
							<h2>Start Sending Reminders:</h2>
							<div class="am_pm">
								<div class="ui-field-contain">
									<fieldset data-role="controlgroup" data-mini="true">
										<input name="month" id="checkbox-5" type="checkbox" class="month" value="1 Month" <?php if($_SESSION['biz_rem']['month'] == '1 Month') echo 'checked="checked"'; ?>>
										<label for="checkbox-5">1 Month</label>
									</fieldset>
								</div>
							</div>
							<div class="am_pm">
								<div class="ui-field-contain">
									<fieldset data-role="controlgroup" data-mini="true">
										<input name="weeks" id="checkbox-5" type="checkbox" class="weeks" value="2 Week" <?php if($_SESSION['biz_rem']['weeks'] == '2 Week') echo 'checked="checked"'; ?>>
										<label for="checkbox-5">2 Week</label>
									</fieldset>
								</div>
							</div>
							<div class="am_pm">
								<div class="ui-field-contain">
									<fieldset data-role="controlgroup" data-mini="true">
										<input name="week" id="checkbox-5" type="checkbox" class="week" value="1 Week" <?php if($_SESSION['biz_rem']['week'] == '1 Week') echo 'checked="checked"'; ?>>
										<label for="checkbox-5">1 Week</label>
									</fieldset>
								</div>
							</div>
							<div class="am_pm">
								<div class="ui-field-contain">
									<fieldset data-role="controlgroup" data-mini="true">
										<input name="days" id="checkbox-5" type="checkbox" class="days" value="3 Days" <?php if($_SESSION['biz_rem']['days'] == '3 Days') echo 'checked="checked"'; ?>>
										<label for="checkbox-5">3 Days</label>
									</fieldset>
								</div>
							</div>
							<div class="am_pm">
								<div class="ui-field-contain">
									<fieldset data-role="controlgroup" data-mini="true">
										<input name="day" id="checkbox-5" type="checkbox" class="day" value="1 Day" <?php if($_SESSION['biz_rem']['day'] == '1 Day') echo 'checked="checked"'; ?>>
										<label for="checkbox-5">1 Day</label>
									</fieldset>
								</div>
							</div>
						</div>
					</div>
					<a href="#" onclick="reminder_process()" class="ui-btn ui-btn-c">Save Reminder</a>
				</form>
		</div>
		<img src="<?php echo ru_resource;?>images/reminder_img.jpg" alt="Reminder Image" class="remd_img" />
		<h3 class="remind">Saved Personal Reminders</h3>
		<ul id="toggle-view">
			<li class="remd_title">
				<div class="ui-block-a"></div>
				<div class="ui-block-b">Event</div>
				<div class="ui-block-c">Date</div>
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
				} else {
					$('#remd_list-'+divid).removeClass('active');
				}	
			});
			
		});
		</script>
		<?php
			$reminder_Qry = "select * from ".tbl_reminder." where userId = '".$userId."'";
			$view_reminder = $db->get_results($reminder_Qry,ARRAY_A);
			if($view_reminder) {
			foreach($view_reminder as $reminder) {
		?>	
			<li>
				<div class="ui-block-a dark_orchid"><a href="javascript:;" onclick="del_reminder('<?php echo $reminder['reminder_id']; ?>');"><img src="<?php echo ru_resource;?>images/cross_sign.png" alt="Cross Icon" /></a></div>
				<div class="remd_list" id="remd_list-<?php echo $reminder['reminder_id']; ?>">
					<div class="ui-block-b"><?php echo $reminder['event_name']; ?></div>
					<?php
						$timestamps = strtotime($reminder['dated']);
						$notify_date = date('m/d/Y', $timestamps)
					?>
					<div class="ui-block-c"><?php echo $notify_date; ?></div>
				</div>	
				<span class="ui-block-d" id="remd_arrow-<?php echo $reminder['reminder_id'];?>"><img src="<?php echo ru_resource;?>images/plus_sign.png" /></span>
					<div class="panel" id="panel-<?php echo $reminder['reminder_id']; ?>">
						<div class="ui-block-a">&nbsp;</div>
						<div class="ui-block-b">Celebrant: <?php echo $reminder['celebrant']; ?></div>
						<div class="ui-block-c">&nbsp;</div>
					</div>
					<div class="panel panel-b">
						<div class="ui-block-a">&nbsp;</div>
						<div class="ui-block-b">Frequency: <?php echo $reminder['one_time']; ?></div>
						<div class="ui-block-c">&nbsp;</div>
					</div>
					<div class="panel panel-b">
						<fieldset class="ui-grid-a unwrap-button">
							<div class="ui-block-a"><a href="<?php echo ru; ?>reminder/<?php echo $reminder['reminder_id']; ?>" style="text-decoration:none" data-ajax="false"><input value="Edit Reminder" data-theme="a" type="button"></a></div>
							<div class="ui-block-b blue-button"><a href="<?php echo ru; ?>step_1" style="text-decoration:none" data-ajax="false"><input value="Send an iftGift" data-theme="b" type="button"></a></div>
							<div class="ui-block-a gray-button"><input value="Email Reminder to other" data-theme="a" type="submit"></div>
						</fieldset>
					</div>
			</li>
		<?php } } ?>	
		</ul>
	</div>
	<style>
	.someClass { color: #ff0000 }
	</style>
<script language="javascript">
$(document).ready(function () {
	$(".example1").on('click', function () {
	if ($(this).is(":checked")) {
		$('.example2').prop('checked', false).checkboxradio('refresh');
	}
	});
	
	$(".example2").on('click', function () {
    if ($(this).is(":checked")) {
        $('.example1').prop('checked', false).checkboxradio('refresh');
    }
	});
	

	$('.month').click(function(event) {  
	if(this.checked) { 
		$('.weeks').prop('checked', true).checkboxradio('refresh');
		$('.week').prop('checked', true).checkboxradio('refresh');
		$('.days').prop('checked', true).checkboxradio('refresh');
		$('.day').prop('checked', true).checkboxradio('refresh');
	}
	});

	$('.weeks').click(function(event) {  
	if(this.checked) { 
		$('.week').prop('checked', true).checkboxradio('refresh');
		$('.days').prop('checked', true).checkboxradio('refresh');
		$('.day').prop('checked', true).checkboxradio('refresh');    
	}
	});

	$('.week').click(function(event) {  
	if(this.checked) { 
		$('.days').prop('checked', true).checkboxradio('refresh');
		$('.day').prop('checked', true).checkboxradio('refresh');           
	}
	});

	$('.days').click(function(event) {  
	if(this.checked) { 
		$('.day').prop('checked', true).checkboxradio('refresh');            
	}
	});
	
	
	$('#select-native-1').change(function () {
		var txt = $(this).val();
		 var myArray = txt.split('/');
		 //alert(myArray);
		 if(myArray == 'holidays') { 
		 $("input[name='event_name']").val('');
		 $("input[name='dated']").val('');
		 } else {
		$("input[name='event_name']").val(myArray[0]);
		$("input[name='dated']").val(myArray[1]);
		}
	});
});
			
$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
		
		
function reminder_process(){
	document.getElementById("reminderSub").submit();
}

function del_reminder(id)
		{
			var dId = id;
			$.ajax({
			url: '<?php echo ru;?>process/process_reminder.php?dId='+dId,
			type: 'get', 
			success: function(output) {
			if(output == 'Success')
			{
				window.location = "<?php echo ru?>reminder";
			}
			}
			});
		}
</script>	
<?php unset($_SESSION['biz_rem_err']);
	  unset($_SESSION['biz_rem']);
?>