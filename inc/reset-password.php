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

.ui-checkbox {
   
    width: 100%;
}

.cntct-form > label {
    width: 100%;
}

</style>	
<?php 
$ack_key = $_GET['s'];
$username = $_GET['o'];
$query = mysql_query("select * from wp_users where user_activation_key = '".$ack_key."' and user_nicename = '".$username."'");
$get_user = mysql_fetch_array($query);
$userId = $get_user['ID'];
?>       
       <h3 class="inner-page-hdng">Resrt Password</h3>
  
       <div data-role="main" class="ui-content">
            <div class="contact-us">
				
						   <div id="login_continue" class="login">
								<p class="message">Enter your new password below.</p>
						   </div>
				
			
                <form id="loginForm" method="post" action="<?php echo ru;?>process/process_password.php" data-ajax="false">
				<input type="hidden" name="reset_pass" value="1" />
				<input type="hidden" name="userId" id="userId" value="<?php echo $userId;?>" />
				<input type="hidden" name="ack_key" id="ack_key" value="<?php echo $ack_key;?>" />
				<input type="hidden" name="username" id="username" value="<?php echo $username;?>" />
                	<ul class="cntct-form">
                    	<li>
                        	<label>New password</label>
                            <input type="password"  name="password" placeholder="Password" required>
							<?php if($_SESSION['error']['password']){?>
								<div style="color:#FF4242"><?php echo $_SESSION['error']['password']?></div>
								<?php }?>
                        </li>
                        
                        <li>
                        	<label>Confirm New password</label>
                            <input type="password" name="cpassword" placeholder="Password">
							<?php if($_SESSION['error']['pass']){?>
								<div style="color:#FF4242"><?php echo $_SESSION['error']['pass']?></div>
								<?php }?>
                        </li>
	  						   <label>Hint: The password should be at least 6 characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ & ).</label>
                       <li>
                        <input type="submit" onclick="Loginform()" class="ui-btn ui-input-btn ui-corner-all ui-shadow" value="Reset Password">
					 </li>
                    </ul>
                </form>
				<ul class="cntct-form">
				<form id="login" action="<?php echo ru?>login">
					
                    	<li>
					<input type="submit" class="ui-btn ui-input-btn ui-corner-all ui-shadow" value="Login">
					</li>
				</form>
				<form id="register" action="<?php echo ru?>register">
					
                    	<li>
					<input type="submit" class="ui-btn ui-input-btn ui-corner-all ui-shadow" value="Register">
					</li>
				</form>
				</ul>
            </div> 
        </div>

        
<script language="javascript">
	function formsubmit(){
		document.getElementById("searchForm").submit()	
	}
</script>
<script language="javascript">
	function Loginform(){
		document.getElementById("loginForm").submit()	
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
	
</script>
       <?php
	   
	   unset($_SESSION['error']);
	   ?> 
       
