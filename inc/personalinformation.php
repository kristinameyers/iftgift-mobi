<?php
	$userId = $_SESSION['LOGINDATA']['USERID'];
	$get_userinfo = "select first_name,last_name,email,address,phone,dob from ".tbl_user." where userId = '".$userId."'";
	$userinfo = $db->get_row($get_userinfo,ARRAY_A);
	$_SESSION['profile'] = $userinfo;
?>
<div role="main" class="ui-content jqm-content jqm-content-c">
		<h2>Your Personal Information</h2>
		<form method="post" id="userInfo" action="<?php echo ru; ?>process/process_userinfo.php" data-ajax="false">
		<input name="userId" id="userId" value="<?php echo $userId;?>" type="hidden">
		<input name="userinfo" id="userinfo" value="1" type="hidden">
		<div class="ui-field-contain field">
			<label for="textinput-1">First Name</label>
			<input name="first_name" id="first_name" placeholder="First Name" value="<?php echo $_SESSION['profile']['first_name'];?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Last Name</label>
			<input name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $_SESSION['profile']['last_name'];?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Address</label>
			<input name="address" id="address" placeholder="Address" value="<?php echo $_SESSION['profile']['address'];?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Phone</label>
			<input name="phone" id="phone" placeholder="Phone" value="<?php echo $_SESSION['profile']['phone'];?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Date of Birth</label>
			<input name="dob" id="datepicker" placeholder="Date of Birth" value="<?php echo $_SESSION['profile']['dob'];?>" type="text">
			<?php /*?><input name="day" id="day" placeholder="dd" value="<?php echo $_SESSION['register']['dob'];?>" class="date" type="text">
			<input name="year" id="year" placeholder="yy" value="<?php echo $_SESSION['register']['dob'];?>" class="date" type="text"><?php */?>
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Email</label>
			<input name="email" id="email" placeholder="Email" value="<?php echo $_SESSION['profile']['email'];?>" type="text">
		</div>
		<a href="#" onclick="validate()" class="ui-btn ui-btn-c">Save</a>
		</form>

	</div>
	<script language="javascript">
	$(function() {
	var date = new Date();
	date.setMonth(date.getMonth() - 540, 1);
		$( "#datepicker" ).datepicker({defaultDate: date});
	});
		
		
function validate(){
	document.getElementById("userInfo").submit();
}
</script>

<?php  unset($_SESSION['profile']);?>