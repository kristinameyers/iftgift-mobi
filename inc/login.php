<div role="main" class="ui-content jqm-content jqm-content-c">
		<h2>Login</h2>
		<?php if($_SESSION['login']['error']){?>
			<div style="color:#FF4242"><?php echo $_SESSION['login']['error']?></div>
		<?php }?>
		<form id="loginForm" method="post" action="<?php echo ru;?>process/process_login.php" data-ajax="false">
		<div class="ui-field-contain field">
			<label for="textinput-1">Email *</label>
			<input name="username" id="username" placeholder="User Name" value="" type="text">
		</div>
		<div class="ui-field-contain field">
			<label for="textinput-1">Password *</label>
			<input name="password" id="password" placeholder="Password" value="" type="password">
		</div>
		<a onclick="Loginform()" class="ui-btn ui-btn-c">Login</a>
		<?php /*?><a onclick="FBLogin()" class="ui-btn fb_btn"><img src="<?php echo ru_resource;?>images/fb_login.png"  /></a><?php */?>
		</form>
	</div>
<script language="javascript">
	function Loginform(){
		document.getElementById("loginForm").submit()	
	}
</script>
<script type="text/javascript">
window.fbAsyncInit = function() {
	FB.init({
	appId      : '338285303000069',
	channelUrl : '//WWW.zs-dev.COM/iftgift', 
	status     : true, 
	cookie     : true, 
	xfbml      : true  
	});
};
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));

function FBLogin(){
	FB.login(function(response){
		if(response.authResponse){
			window.location.href = "<?php echo ru;?>process/process_fb.php?action=fblogin";
		}
	}, {scope: 'email,user_likes'});
}
</script>	
<?php  unset($_SESSION["login"]["error"]);?>	