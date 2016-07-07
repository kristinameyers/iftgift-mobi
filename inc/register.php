<div role="main" class="ui-content jqm-content jqm-content-c">
		<h2>Register</h2>
		<?php if(isset($_GET['s']) == '') { ?>
		<form method="post" id="register" action="<?php echo ru; ?>process/process_register.php" data-ajax="false">
		<div class="ui-field-contain field">
			<label for="textinput-1">First Name *</label>
			<input name="fname" id="fname" placeholder="First Name" value="<?php echo $_SESSION['register']['fname'];?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Last Name *</label>
			<input name="lname" id="lname" placeholder="Last Name" value="<?php echo $_SESSION['register']['lname'];?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Email *</label>
			<input name="email" id="email" placeholder="Email" value="<?php echo $_SESSION['register']['email'];?>" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Password *</label>
			<input name="password" id="password" placeholder="Password" value="" type="password">
		</div>
		<a href="#" onclick="validate()" class="ui-btn ui-btn-c">Register</a>
		</form>
		<?php } else {?>
		<form method="post" id="new_register" action="<?php echo ru; ?>process/process_newregister.php" data-ajax="false">
		<input name="userId" id="userId" value="<?php echo $_GET['s']?>" type="hidden">
		<div class="ui-field-contain field">
			<label for="textinput-1">Password *</label>
			<input name="password" id="password" placeholder="Password" value="" type="password">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Confirm Password *</label>
			<input name="cpassword" id="cpassword" placeholder="Confirm Password" value="" type="password">
		</div>
		<a href="#" onclick="validate_reg()" class="ui-btn ui-btn-c">Register</a>
		</form>
		<?php } ?>
	</div>
	<?php if(isset($_GET['s']) == '') { ?>
	<script language="javascript">
function validate(){
	var fname = document.getElementById('fname').value;
	var lname = document.getElementById('lname').value;
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;
	
	if(fname == '')
	{
		alert("Please enter first name!");
		document.getElementById('fname').focus();
		return false;
	}
	
	if(lname == '')
	{
		alert("Please enter last name!");
		document.getElementById('lname').focus();
		return false;
	}
	
	if(email == '')
	{
		alert("Please enter email address!");
		document.getElementById('email').focus();
		return false;
	}
	
	var x=document.forms["register"]["email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	  {
	  alert("Please enter valid email address.");
	  return false;
	  }
	if(password == '')
	{
		alert("Please enter password!");
		document.getElementById('password').focus();
		return false;
	}  
   else {   
	document.getElementById("register").submit();
		
 }
		
}
</script>
	<?php } else {?>
	<script language="javascript">
function validate_reg(){
	
	var password = document.getElementById('password').value;
	var cpassword = document.getElementById('cpassword').value;
	
	if(password == '')
	{
		alert("Please enter password!");
		document.getElementById('password').focus();
		return false;
	}  
	if(cpassword == '')
	{
		alert("Please enter confirm password!");
		document.getElementById('cpassword').focus();
		return false;
	}  
	if(password != cpassword)
	{
		alert("Password did not match !");
		document.getElementById('password').focus();
		return false;
	}  
   else {   
	document.getElementById("new_register").submit();
		
 }
		
}
</script>
	<?php } ?>
<?php  unset($_SESSION['register']);?>