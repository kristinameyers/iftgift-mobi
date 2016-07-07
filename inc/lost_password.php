<style>
.login p.message {
    background-color: #FFFFE0;
    border: 1px solid #E6DB55;
    color: #333333;
    padding: 5px;
	font-size:14px;
	text-align:center
}
p {
    margin-bottom: 18px;
}
.ui-widget-content {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #D9D9D9;
    box-shadow: 0 4px 3px #7F7F7F;
    left: 0 !important;
    margin: 0 17%;
    width: auto !important;
}	

.ui-widget-content li {
    list-style: none outside none;
}

.ui-widget-content li a:hover{
	background:#eeeeee;
}

.ui-widget-content li a {
    border-radius: 0;
    display: block;
    padding: 8px 15px;
	color:#000000;
	font-size:.9em;
}
.main-header2 {
    background: linear-gradient(to bottom, #60CC7B 0%, #1F9B40 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    padding: 1.5em;
    text-align: center;
}
.ui-page-theme-a .ui-btn:hover, html .ui-bar-a .ui-btn:hover, html .ui-body-a .ui-btn:hover, html body .ui-group-theme-a .ui-btn:hover, html head + body .ui-btn.ui-btn-a:hover {
text-shadow:0 0
}
</style>

	 
   
       <h3 class="inner-page-hdng">Lost Password</h3>
  
       <div data-role="main" class="ui-content">
		<div id="lost_password" class="login">
		<p class="message">Please enter your email address. You will receive a link to create a new password via email.</p>
	</div>
	
	<?php if(isset($_SESSION["passwordrest"]["msg"])) { ?>
	<div style="color:#FF4242"><?php echo $_SESSION["passwordrest"]["msg"];?></div>
	<?php  unset($_SESSION["passwordrest"]["msg"]); }?>
	
		<form id="get_pass" method="post" action="<?php echo ru; ?>process/process_password.php" data-ajax="false">
                	
                    	
                        	<label>Please Enter Your Email Address</label>
                            <input type="email"  name="email" placeholder="Email" required>
                        
							<input style="background: none repeat scroll 0 0 #3F48CC;border: medium none;color: #FFFFFF; margin-bottom:2%;" type="submit" name="getpassword" class="ui-btn ui-input-btn ui-corner-all ui-shadow" value="Get Password">
						
						
		</form>
		<ul class="cntct-form">		
		<form id="register" action="<?php echo ru?>login">
				<li>  
				<input  type="submit" class="ui-btn ui-input-btn ui-corner-all ui-shadow" value="Login">
				   </li>
		</form>
		
		<form id="register" action="<?php echo ru?>register">
				   <li>
					<input type="submit" onclick="location.href='<?php echo ru;?>edit-profile'" class="ui-btn ui-input-btn ui-corner-all ui-shadow" value="Register">
				   </li>
		</form>
		</ul>		
	</div>
<link rel="stylesheet" href="<?php echo ru; ?>resource/css/cmxform.css" />
<script src="<?php echo ru; ?>resource/js/jquery.validate.js"></script>
	
<script language="javascript">
	function formsubmit(){
		document.getElementById("searchForm").submit()	
	}
</script>

<script type="text/javascript">
$(document).ready(function(){
	$(function() {
		$("#keyword").autocomplete({
			source: "<?php  echo ru;?>process/autosearch.php",
			minLength:1
		});
	});
	});
	
$.validator.setDefaults({
	submitHandler: function() { document.getElementById("get_pass").submit() }
});	
	$(document).ready(function() {
	// validate the comment form when it is submitted
	$("#get_pass").validate();

});
	
</script>