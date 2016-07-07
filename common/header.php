<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>iftgift mobi</title>
	<link rel="shortcut icon" href="favicon.ico"/>
	<link rel="stylesheet"  href="<?php echo ru_resource?>css/jquery.mobile-1.4.2.min.css"/>
	<link rel="stylesheet"  href="<?php echo ru_resource?>css/style.css"/>
	<script src="<?php echo ru_resource?>js/jquery.js"></script>
	<script src="<?php echo ru_resource?>js/jquery.min.js"></script>
	<?php if($page == 'notify_datetime' || $page == 'unlock_datetime' || $page == 'personalinformation' || $page == 'reminder' || $page == 'release_request') { ?>
		
		<!---------------------------------------Datepicker----------------------------------------------->	
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
		<script src="<?php echo ru_resource?>js/datepicker/jquery-ui.js"></script>
		<!---------------------------------------Datepicker----------------------------------------------->
		<!---------------------------------------Timepicker----------------------------------------------->	
		<link rel="stylesheet" href="<?php echo ru_resource?>js/timepicker/jquery-ui-1.10.0.custom.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo ru_resource?>js/timepicker/jquery.ui.timepicker.css?v=0.3.3" type="text/css" />
		<script type="text/javascript" src="<?php echo ru_resource?>js/timepicker/jquery.ui.core.min.js"></script>
		<script type="text/javascript" src="<?php echo ru_resource?>js/timepicker/jquery.ui.position.min.js"></script>
		<?php if($page == 'reminder' || $page == 'release_request') { ?>
		<script type="text/javascript" src="<?php echo ru_resource?>js/timepicker/jquery.ui.timepicker2.js?v=0.3.3"></script>
		<?php } else { ?>
		<script type="text/javascript" src="<?php echo ru_resource?>js/timepicker/jquery.ui.timepicker.js?v=0.3.3"></script>
		<?php } ?>
		<!---------------------------------------Timepicker----------------------------------------------->	
		<script type="text/javascript">
		$(document).ready(function () {
		$('#radio-choice-v-1a').click(function () {
		$('#future').hide('fast');
		$('#immediate').show('fast');
		});
		
		$('#radio-choice-v-1b').click(function () {
		$('#immediate').hide('fast');
		$('#future').show('fast');
		});	
		
		
		
		$('#timepicker_hours').timepicker({
					showMinutes: false,
					showPeriod: true,
					showLeadingZero: false
				});
		$('#timepicker_minutes').timepicker({
		showHours: false
		});	
		
		$('#timepicker_hourss').timepicker({
					showMinutes: false,
					showPeriod: true,
					showLeadingZero: false
				});
		$('#timepicker_minutess').timepicker({
		showHours: false
		});	
		
		$('#timepicker_hoursss').timepicker({
					showMinutes: true,
					showPeriod: true,
					showLeadingZero: true
		});
		});
		
		
		
		function onSelect(dateText, inst) {
		var pieces = dateText.split('/');
		$('#day').val(pieces[0]);
		$('#month').val(pieces[1]);
		$('#year').val(pieces[2]);
		};
		
		$(document).ready(function () {
		$('.date').click(function(event) {
		var d = $('#day').val() + '/' + $('#month').val() + '/' + $('#year').val();
		$(this).datepicker('dialog', d, onSelect, { dateFormat: 'dd/mm/yy', minDate: 0 }, [35, 672]);
		});
		});
		
		function onSelect2(dateText, inst) {
		var pieces = dateText.split('/');
		$('#day1').val(pieces[0]);
		$('#month1').val(pieces[1]);
		$('#year1').val(pieces[2]);
		};
		
		$(document).ready(function () {
		$('.dates').click(function(event) {
		var d = $('#day1').val() + '/' + $('#month1').val() + '/' + $('#year1').val();
		$(this).datepicker('dialog', d, onSelect2, { dateFormat: 'dd/mm/yy', minDate: 0 }, [35, 672]);
		});
		});
		</script>	
	<?php } ?> 
	<script src="<?php echo ru_resource?>js/scroll-bar.js"></script>
	<script src="<?php echo ru_resource?>js/index.js"></script>
	<script src="<?php echo ru_resource?>js/jquery.mobile-1.4.2.min.js"></script>
	<script src="<?php echo ru_resource?>js/tagcanvas.min.js"></script>	
	<script type="text/javascript">
		$(function(){
 		$('[data-toggle]').on('click', function(){
		  var id = $(this).data("toggle"),
			  $object = $(id),
			  className = "open";
		  
		  if ($object) {
			if ($object.hasClass(className)) {
			  $object.removeClass(className)
			  $(this).html('<img src="<?php echo ru_resource?>images/expand_plus_icon.png" /><span>Expand<span>');
			  $('#user_avatar').hide();
			  $('#gift_make').hide();
			} else {
			  $object.addClass(className)
			  $(this).html('<img src="<?php echo ru_resource?>images/expand_navg_icon.png" /><span>Hide<span>');
			  $('#user_avatar').show();
			  $('#gift_make').show();
			}
		  }
		});
	});
	</script>
	<style>
		#list{display:none}
		#list.open{display:block}
	</style>
	
	<?php if($page == 'confirmation') { ?>
	<script type="text/javascript" src="<?php echo ru_resource; ?>js/printarea.js"></script>
	<?php } ?>
	
	<script type="text/javascript">
	
	$(document)
    .on('focus', 'input,textarea', function(e) {
		//$(".ui-footer").hide();
	    $(".footer_expand_bar").hide();
    })
	.on('blur', 'input,textarea', function(e) {
		//$(".ui-footer").show();
	    $(".footer_expand_bar").show();
    });
	
	</script>
	<?php if($page == 'iftcliques') { ?>
	<!-- FlexSlider -->
	<script src="<?php echo ru_resource; ?>js/jquery.flexslider.js"></script>
	<?php } 
	mysql_query("SET NAMES 'utf8'");
	//mysql_query("SET CHARACTER SET utf8");
	//mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
	?>
</head>
<body>
<div data-role="page">
	<div role="main" class="ui-content ui-content-b">
		
		<?php if($page == 'home' || $page == 'learn_more' || $page == 'register' || $page == 'login') { ?>
		<a href="<?php echo ru;?>" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline mono"><img src="<?php echo ru_resource?>images/monogram_b.jpg" alt="Monogram" /></a>
		<a href="<?php echo ru;?>" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline home <?php if($page == 'home') {?>selected<?php } ?>"><span>Home</span></a>
		<a href="<?php echo ru;?>learn_more" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline lrn_mr <?php if($page == 'learn_more') {?>selected<?php } ?>"><span>Learn More</span></a>
		<?php if($_SESSION['LOGINDATA']['ISLOGIN']) { ?>
		<a href="<?php echo ru;?>dashboard" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline dashboard <?php if($page == 'dashboard') {?>selected<?php } ?>"><span>Dashboard</span></a>
		<a href="<?php echo ru;?>logout" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline logout"> <span>Logout</span></a>
		<?php } else { ?>
		<a href="<?php echo ru;?>register" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline regs <?php if($page == 'register') {?>selected<?php } ?>"><span>Register</span></a>
		<a href="<?php echo ru;?>login" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline signin <?php if($page == 'login') {?>selected<?php } ?>"><span>Sign In</span></a>
		<?php } ?>
		<?php } else { ?>
		
		<a href="<?php echo ru;?>" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline mono"><img src="<?php echo ru_resource?>images/monogram_b.jpg" alt="Monogram" /></a>
		<?php
			$get_uimage = "select user_image from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'"; 
			$view_image = $db->get_row($get_uimage,ARRAY_A);
			if($view_image['user_image'])
			{	
				$image_path = ru_dir."media/user_image/".$_SESSION['LOGINDATA']['USERID'];
				if(is_dir($image_path)) {
				$user_image = ru."media/user_image/".$_SESSION['LOGINDATA']['USERID']."/thumb/".$view_image['user_image'];
				} else {
				$user_image = $view_image['user_image'];
				}
			} else {
				$user_image = ru_resource."images/profile_img.jpg";
			}
			?>
		<a href="#<?php echo ru;?>upload_image" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline prof"><img src="<?php echo $user_image?>" style="display:none" id="user_avatar" /></a>
		<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline iftgift"><div class="ift_gift" style="display:none" id="gift_make"><span>iftGifts I’m Making</span><div class="ift_value">2</div></div></a>
		<?php if(isset($_SESSION['products'])) { 
			   $cart_counter = count($_SESSION["products"]);
		} else if(isset($_SESSION['cart'])) {
			   $cart_counter = count($_SESSION["cart"]);
		}
		?>
		<a href="<?php echo ru?>cart/" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline iftgift item"><div class="ift_gift"><img src="<?php echo ru_resource?>images/item_icon.png" /><div class="ift_value"><?php if($cart_counter != '') { echo $cart_counter; } else { echo '0';} ?></div></div></a>
		<a  href="#" data-toggle="#list" class="ui-btn ui-corner-all ui-shadow ui-btn-inline singin expand hide"><img src="<?php echo ru_resource?>images/expand_plus_icon.png" /><span>Expand</span></a>
		<div id="list">
			<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline"><?php /*?><div class="ift_gift"><span>iftGifts I’m Making</span><div class="ift_value">2</div></div><?php */?></a>
			<a href="<?php echo ru;?>controls" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline control"><span>Controls</span></a>
			<a href="<?php echo ru;?>dashboard" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline dashboard <?php if($page == 'dashboard') {?>selected<?php } ?>"><span>Dashboard</span></a>
			<a href="<?php echo ru;?>transfercashstash" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline cash <?php if($page == 'transfercashstash') {?>selected<?php } ?>"><span>Cash^Stash</span></a>
			<a href="<?php echo ru;?>logout" data-ajax="false" class="ui-btn ui-corner-all ui-shadow ui-btn-inline logout"> <span>Logout</span></a>
		</div>
		
		
		<?php } ?>
	</div>
	<?php if($page == 'home') { ?>
	<div data-role="header" class="jqm-header">
		<div class="home-center">
			<div class="home-left">"No More Shop Til You Drop"</div>
			<div class="logo"><img src="<?php echo ru_resource?>images/logo.jpg" alt="Logo" /></div>
			<div class="home-left home-right">"No More Unhappy Returns"</div>
		</div>
	</div><!-- /header -->	
	<?php } ?>

<!-- *******************Function For Change Menu Product*********************** -->	
<script type="text/javascript">
function get_pro(str)
{
	var cat_name = str;
	$.ajax({
	url: '<?php echo ru;?>process/get_pro.php',
	type: 'POST', 
	data: {category:cat_name} ,
	success: function(output) {
	$('#view_defaultpor').hide();
	$('#product_test').hide();
	$('#overlayPanel').toggle('slow');
	$('#pro_test').html(output);
	$(".demo").customScrollbar();
    $("#fixed-thumb-size-demo").customScrollbar({fixedThumbHeight: 50, fixedThumbWidth: 60});	
	}
	});
}

function show_menu()
{
	$('#overlayPanel').show();
}
</script>	
<!-- *******************Function For Change Menu Product*********************** -->	