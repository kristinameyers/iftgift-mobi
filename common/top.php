<?php if($page == 'search') { } else if($page == 'open_iftgift' || $page == 'locked' || $page == 'unwraped') {?>
	<div class="sugg_top sugg_top_b">
		<h2>PENDING</h2>
	</div>
<?php } else if($page == 'checkout' || $page == 'checkoutshop') { ?>
	<div class="sugg_top sugg_top_b">
		<h2>checkout</h2>
	</div>	
<?php } else if($page == 'confirmation') { ?>
	<div class="sugg_top sugg_top_b">
		<h2>CONFIRMATION</h2>
	</div>	
<?php } else { ?>
<div class="sugg_top">
	
	<?php /*?><a href="<?php echo ru;?>search" data-ajax="false" class="search"><img src="<?php echo ru_resource;?>images/search_icon.png" alt="Search Icon" /></a><?php */?>
	<?php if($page == 'open_iftgift' || $page == 'locked' || $page == 'unwraped') { ?>
		<h3 class="send">Send</h3>
	<?php } else {?>
		<h3>Send</h3>
	<?php } ?>
	<?php if($page == 'open_iftgift' || $page == 'locked' || $page == 'unwraped' || $page == 'confirmation' || $page == 'checkout') { } else {?>
	<?php
		if(isset($_SESSION["products"])) { 
				$get_delivery = mysql_query("select * from ".tbl_delivery." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and delivery_id = '".$_SESSION['delivery_id']['New']."'");
				if(mysql_num_rows($get_delivery) > 0) { ?>
					<a href="<?php echo ru?>checkout" data-ajax="false" class="ui-btn">Check Out</a>
				<?php } else { ?>
					<a href="javascript:;" onclick="delivery_detail('1')" data-ajax="false" class="ui-btn">Check Out</a>
				<?php } 
				} else if(isset($_SESSION["cart"])) { ?>
					<a href="<?php echo ru?>checkoutshop" data-ajax="false" class="ui-btn">Check Out</a>
			<?php } else { ?>
				<a href="javascript:;" onclick="chk_checkout()" class="ui-btn">Check Out</a>
			<?php 
			}
		} 
	 $get_recipit = "select r.first_name,r.last_name,r.recipit_id,r.email,r.cash_gift,r.ocassion,o.occasionid,o.occasion_name from ".tbl_recipient." as r left join ".tbl_occasion." as o on r.ocassion=o.occasionid where r.recipit_id = '".$_SESSION['recipit_id']['New']."'";
	 $view = $db->get_row($get_recipit,ARRAY_A);
	?>
	<?php if($page == 'open_iftgift' || $page == 'locked' || $page == 'unwraped' || $page == 'confirmation' || $page == 'checkout') { } else {?>
	<?php if($_SESSION['cart']) {} else {?>
	<h4 class="recip"><span><?php echo $view['occasion_name'];?></span> iftGift for <span><?php echo ucfirst($view['first_name'].' '.$view['last_name']);?></span></h4>
	<?php } } ?>
</div>
<?php } ?>

	<?php if($page == 'delivery_detail' || $page == 'giver_info' || $page == 'recp_info' || $page == 'notify_datetime' || $page == 'unlock_datetime' || $page == 'personal_note' || $page == 'checkout' || $page == 'confirmation' || $page == 'cart' || $page == 'review_gift' || $page == 'checkoutshop') {} else if($page == 'open_iftgift' || $page == 'locked' || $page == 'unwraped') {
	$delivery_id = $_GET['s'];
	$get_dev = $db->get_row("select * from ".tbl_delivery." where delivery_id = '".$delivery_id."'",ARRAY_A);
	$occassionid = $get_dev['occassionid'];
	$userId = $get_dev['userId'];
	
	$get_user = $db->get_row("select user_image,available_cash from ".tbl_user." where userId = '".$userId."'",ARRAY_A);
	if($get_user['user_image'])
	{
		$user_image = ru."media/user_image/".$userId.'/thumb/'.$get_user['user_image'];
	} else {
		$user_image = ru_resource."images/profile_img.jpg";
	}
	
	$get_occas = $db->get_row("select occasion_name from ".tbl_occasion." where occasionid = '".$occassionid."'",ARRAY_A);
	?>
	<div role="main" class="ui-content jqm-content jqm-content-c ift_block">
		<h4 class="recip"><img src="<?php echo $user_image?>" />
		Your <span><?php echo $get_occas['occasion_name'];?></span> iftGift from <span><?php echo $get_dev['giv_first_name'].' '.$get_dev['giv_last_name'];?></span></h4>
	</div><!-- /content -->
	<?php } else if($page == 'search') { ?>
	<div role="main" class="ui-content jqm-content jqm-content-c ift_block ift_block_b">
		<div class="control">
			<h5>Who is in Control?</h5>
			<div class="ui-field-contain">
				<fieldset data-role="controlgroup">
					<img src="<?php echo ru_resource;?>images/jester_img.png" class="jester_img" id="jster_img" <?php if($page == 'only' || $page == 'iftClique'  || $page == 'similar_persons' || $page == 'search_result') { } else { ?> style="display:none" <?php } ?> />
					<?php if($page == 'search') { ?>
					<input name="control" id="radio-choice-v-1a" value="2" <?php if($page == 'only' || $page == 'iftClique'  || $page == 'similar_persons' || $page == 'search_result') echo 'checked="checked"';?>  type="radio" onchange="redirect2()">
					<?php } else { ?>
					<input name="control" id="radio-choice-v-1a" value="2" <?php if($page == 'only' || $page == 'iftClique'  || $page == 'similar_persons' || $page == 'search_result') echo 'checked="checked"';?>  type="radio">
					<?php } ?>
					<script type="text/javascript">
					function redirect2()
					{
						var url = '<?php echo ru;?>only';
						$(location).attr('href',url);
					}
					</script>
					<label for="radio-choice-v-1a">s'Jester</label>
					<?php if($page == 'only' || $page == 'iftClique' || $page == 'similar_persons' || $page == 'search_result') { ?>
					<input name="control" id="radio-choice-v-1b" value="1" type="radio" onchange="redirect()">
					<script type="text/javascript">
					function redirect()
					{
						var url = '<?php echo ru;?>step_2a';
						$(location).attr('href',url);
					}
					</script>
					<?php } else if($page == 'step_2b') { ?>
					<img src="<?php echo ru_resource;?>images/user_img.png" class="jester_img" id="you_img" />
					<input name="control" id="radio-choice-v-1b" value="1"<?php if($_SESSION['LOGINDATA']['USERID'] != '') echo 'checked="checked"'; ?> type="radio">
					<?php } else { ?>
					<img src="<?php echo ru_resource;?>images/user_img.png" class="jester_img" id="you_img" />
					<input name="control" id="radio-choice-v-1b" value="1"<?php if($_SESSION['LOGINDATA']['USERID'] != '') echo 'checked="checked"'; ?> type="radio">
					<?php } ?>
					<label for="radio-choice-v-1b">You</label>
				</fieldset>
			</div>
		</div>
		<?php /*?><a href="#" class="search"><img src="<?php echo ru_resource;?>images/search_icon.jpg" alt="Search Icon" /></a><?php */?>
	</div>
	<?php } else { ?>
	<div id="option_panel" style="display:none">
  	<div role="main" class="ui-content jqm-content jqm-content-c ift_block ift_block_b">
		<div class="control">
			<h5>Who is in Control?</h5>
			<div class="ui-field-contain">
				<fieldset data-role="controlgroup">
					<img src="<?php echo ru_resource;?>images/jester_img.png" class="jester_img" id="jster_img" <?php if($page == 'only' || $page == 'iftClique'  || $page == 'similar_persons' || $page == 'search_result') { } else { ?> style="display:none" <?php } ?> />
					<?php if($page == 'step_2a' || $page == 'step_2b' || $page == 'category' || $page == 'listings' || $page == 'product_detail') { ?>
					<input name="control" id="radio-choice-v-1a" value="2" <?php if($page == 'only' || $page == 'iftClique'  || $page == 'similar_persons' || $page == 'search_result') echo 'checked="checked"';?>  type="radio" onchange="redirect2()">
					<?php } else { ?>
					<input name="control" id="radio-choice-v-1a" value="2" <?php if($page == 'only' || $page == 'iftClique'  || $page == 'similar_persons' || $page == 'search_result') echo 'checked="checked"';?>  type="radio">
					<?php } ?>
					<script type="text/javascript">
					function redirect2()
					{
						var url = '<?php echo ru;?>only';
						$(location).attr('href',url);
					}
					</script>
					<label for="radio-choice-v-1a">s'Jester</label>
					<?php if($page == 'only' || $page == 'iftClique' || $page == 'similar_persons' || $page == 'search_result') { ?>
					<input name="control" id="radio-choice-v-1b" value="1" type="radio" onchange="redirect()">
					<script type="text/javascript">
					function redirect()
					{
						var url = '<?php echo ru;?>step_2a';
						$(location).attr('href',url);
					}
					</script>
					<?php } else if($page == 'step_2b') { ?>
					<img src="<?php echo ru_resource;?>images/user_img.png" class="jester_img" id="you_img" />
					<input name="control" id="radio-choice-v-1b" value="1"<?php if($_SESSION['LOGINDATA']['USERID'] != '') echo 'checked="checked"'; ?> type="radio">
					<?php } else { ?>
					<img src="<?php echo ru_resource;?>images/user_img.png" class="jester_img" id="you_img" />
					<input name="control" id="radio-choice-v-1b" value="1"<?php if($_SESSION['LOGINDATA']['USERID'] != '') echo 'checked="checked"'; ?> type="radio">
					<?php } ?>
					<label for="radio-choice-v-1b">You</label>
				</fieldset>
			</div>
		</div>
		<?php /*?><a href="#" class="search"><img src="<?php echo ru_resource;?>images/search_icon.jpg" alt="Search Icon" /></a><?php */?>
	</div><!-- /content -->
	<script type="text/javascript">
	$(document).ready(function() {
    $('input:radio[name=control]').change(function() {
        if (this.value == '1') {
		$("input[name='location']").val("1");
			$('#default_cat').show();
			$('#control_cat').hide();
			$('#pro_control').hide();
			$('#view_defaultpor').show();
			$('#you_cat').show();
			$('#you_img').show();
			$('#sjester').hide();
			$('#jster_img').hide();
			$('#only').removeClass( "selected" );
        }
        else if (this.value == '2') {
		$("input[name='location']").val("2");
			$('#default_cat').hide();
			$('#control_cat').show();
			$('#pro_control').show();
			$('#jster_img').show();
			$('#you_img').hide();
			$('#you_cat').hide();
			$('#sjester').show();
        }
    	});
	});
	</script>
	<?php } ?>
	<?php if($page == 'cart' || $page == 'detail' || $page == 'delivery_detail' || $page == 'giver_info' || $page == 'recp_info' || $page == 'notify_datetime' || $page == 'unlock_datetime' || $page == 'review_gift' || $page == 'personal_note' || $page == 'checkout' || $page == 'confirmation' || $page == 'locked' || $page == 'open_iftgift' || $page == 'unwraped' || $page == 'search' || $page == 'checkoutshop') { } else {?>
	<script type="text/javascript">
	$(document).ready(function () {
		$('#only').click(function () {
		$('#only').removeClass( "ui-bar-a" ).addClass('selected');
		$('#sperson').removeClass( "selected" );
		$('#iftclique').removeClass( "selected" );
		//var cat_name = 'only';
		//alert(cat_name);
		var url = '<?php echo ru;?>only/';
		$(location).attr('href',url);
		/*$.ajax({
		url: '<?php echo ru;?>process/get_filterpro.php',
		type: 'POST', 
		data: {filter:cat_name} ,
		success: function(output) {
		$('#filtered_pro').html(output);
		$('#sjester').hide();
		$('#view_defaultpor').hide();
		}
		});*/
		});
		
		$('#iftclique').click(function () {
		$('#iftclique').removeClass( "ui-bar-a" ).addClass('selected');
		$('#sperson').removeClass( "selected" );
		$('#only').removeClass( "selected" );
		//var cat_name = 'iftclique';
		//alert(cat_name);
		var url = '<?php echo ru;?>iftClique/';
		$(location).attr('href',url);
		/*$.ajax({
		url: '<?php echo ru;?>process/get_filterpro.php',
		type: 'POST', 
		data: {filter:cat_name} ,
		success: function(output) {
		$('#filtered_pro').html(output);
		$('#sjester').hide();
		$('#view_defaultpor').hide();
		}
		});*/
		});
		
		$('#sperson').click(function () {
		var url = '<?php echo ru;?>similar_persons/';
		$(location).attr('href',url);
		});
	});
	</script>
	<div role="main" class="ui-content jqm-content jqm-content-c ift_block">
		<div class="dashbd select-check">
			<h4 class="recip accm">Select</h4> 
			<div class="count">
			<?php $count = 6 - count($_SESSION["products"]); ?>
				<input name="textinput-1" id="textinput-1" placeholder="Text input" value="<?php echo $count?>" type="text"> 
			</div>
			<h4 class="recip accm">Suggestions to accompany</h4>
		</div>
		<div class="dashbd select-check select-check-b">
			<h4 class="recip accm">your</h4>
			<div class="count">
				<input name="textinput-1" id="textinput-1" placeholder="Text input" value="$<?php echo number_format($view['cash_gift'],'0');?>" type="text" class="amount"> 
			</div>
			<h4 class="recip accm">cash gift</h4>
		</div>
		<?php if($page == 'step_2a' || $page == 'step_2b' || $page == 'listings' || $page == 'category' || $page == 'product_detail' || $page == 'only' || $page == 'iftClique' || $page == 'similar_persons') {?>
		<div class="menu">
			<div class="menu_inner">
				<div class="home-nav-overlay">
				<a href="#overlayPanel" class="home-nav-btn" onClick="show_menu()"></a> <span>category <br/>list</span>
				<div data-role="panel" id="overlayPanel" data-display="overlay">
				<!-- Onpage Load Shows Default You Category -->
				<div id="default_cat">
				<?php
				$get_cat = "select * from ".tbl_category." where status = 1 and p_catid = 0 and you_cat = 1";
				$view_cat = $db->get_results($get_cat,ARRAY_A);
				if($view_cat)
				{
					foreach($view_cat as $category )
					{
				?>
					<div data-role="collapsible">
						<h3><?php echo stripslashes($category['cat_name']);?></h3>
						<?php
						$get_subcat = "select * from ".tbl_category." where status = 1 and p_catid = '".$category['catid']."'";
						$view_subcat = $db->get_results($get_subcat,ARRAY_A);
						if($view_subcat)
						{
							foreach($view_subcat as $subcategory )
							{
					?>
							<?php /*?><p><a href="#" onClick="get_pro('<?php echo mysql_real_escape_string(stripslashes(trim($subcategory['cat_name'])));?>');" dtaa-ajax="false"><?php echo stripslashes($subcategory['cat_name']);?></a></p><?php */?>
							<p><a href="<?php echo ru;?>category/<?php echo urlencode($category['cat_name']); ?>" data-ajax="false"><?php echo stripslashes($subcategory['cat_name']);?></a></p>
						<?php 
							} 
					   } 
					?>
					</div>
				<?php 
					} 
				} 
				?>
				</div>
				<!-- Onpage Load Shows Default You Category -->
				
				<!-- Onclick S'jester Shows Jester Category -->
				<div id="control_cat" style="display:none;">
				<?php
				$get_cat = "select * from ".tbl_category." where status = 1 and p_catid = 0 and sjester = 2";
				$view_cat = $db->get_results($get_cat,ARRAY_A);
				if($view_cat)
				{
					foreach($view_cat as $category )
					{
				?>
					<div data-role="collapsible">
						<h3><?php echo stripslashes($category['cat_name']);?></h3>
						<?php
						$get_subcat = "select * from ".tbl_category." where status = 1 and p_catid = '".$category['catid']."'";
						$view_subcat = $db->get_results($get_subcat,ARRAY_A);
						if($view_subcat)
						{
							foreach($view_subcat as $subcategory )
							{
					?>
							<p><a href="#" onClick="get_pro('<?php echo mysql_real_escape_string(stripslashes(trim($subcategory['cat_name'])));?>');" dtaa-ajax="false"><?php echo stripslashes($subcategory['cat_name']);?></a></p>
						<?php
							} 
					   } 
					?>
					</div>
				<?php 
					} 
				} 
				?>
				</div>
				<!-- Onclick S'jester Shows Jester Category -->
				</div>
			</div>
			</div>
			<div class="menu_inner"><a href="<?php echo ru;?>search" data-ajax="false" class="search"><img src="<?php echo ru_resource;?>images/search_icon.png" alt="Search Icon" /></a><span>search <br/>tools</span></div>
		</div>
		<?php } else {?>
		<div class="menu">
			<div class="menu_inner menu_inner_b"><a href="<?php echo ru;?>search" data-ajax="false" class="search"><img src="<?php echo ru_resource;?>images/search_icon.png" alt="Search Icon" /></a><span>search <br/>tools</span></div>
		</div>
		<?php }?>
	</div><!-- /content -->
	</div>
	<div class="option_main" id="expand_img"><img src="<?php echo ru_resource;?>images/expand_img.png"  /></div>
	<div class="option_main option_main_b" id="hide_img" style="display:none"><img src="<?php echo ru_resource;?>images/hide_img.png"  /></div>
	<?php } ?>
<input type="hidden" name="cash_amount" id="cash_amount" value="<?php echo number_format($view['cash_gift'],'0');?>" /> 
<input type="hidden" name="recp_first_name" id="recp_first_name" value="<?php echo $view['first_name'];?>" /> 
<input type="hidden" name="recp_last_name" id="recp_last_name" value="<?php echo $view['last_name'];?>" /> 
<input type="hidden" name="recp_email" id="recp_email" value="<?php echo $view['email'];?>" /> 
<input type="hidden" name="occassionid" id="occassionid" value="<?php echo $view['ocassion'];?>" />
<input type="hidden" name="giv_first_name" id="giv_first_name" value="<?php echo $_SESSION['LOGINDATA']['NAME'];?>" /> 
<input type="hidden" name="giv_last_name" id="giv_last_name" value="<?php echo $_SESSION['LOGINDATA']['LNAME'];?>" /> 
<input type="hidden" name="giv_email" id="giv_email" value="<?php echo $_SESSION['LOGINDATA']['EMAIL'];?>" /> 
<?php 
$proId = $_SESSION["products"];
if($proId){
foreach($proId as $index){
 $value1 = $index['proid'];
$pro[] = array('proid' => "$value1" ,'caption' => "");
}}
$json = json_encode($pro);
?>
<textarea style="display:none;" name="proid" id="proid" ><?php echo $json;?></textarea> 

<script type="text/javascript">
function delivery_detail(dev)
{
	var save_dev = dev;
	var cash_amount=document.getElementById('cash_amount').value;
	var recp_first_name=document.getElementById('recp_first_name').value;
	var recp_last_name=document.getElementById('recp_last_name').value;
	var recp_email=document.getElementById('recp_email').value;
	var occassionid=document.getElementById('occassionid').value;
	var giv_first_name=document.getElementById('giv_first_name').value;
	var giv_last_name=document.getElementById('giv_last_name').value;
	var giv_email=document.getElementById('giv_email').value;
	var proid=document.getElementById('proid').value;
	
	$.ajax({
	url: '<?php echo ru;?>process/process_dev.php',
	type: 'POST', 
	data: {save_dev:save_dev,cash_amount:cash_amount,recp_first_name:recp_first_name,recp_last_name:recp_last_name,recp_email:recp_email,occassionid:occassionid,giv_first_name:giv_first_name,giv_last_name:giv_last_name,giv_email:giv_email,proid:proid} ,
	success: function(output) {
	if(output == 'Success')
	{
		window.location="<?php echo ru;?>delivery_detail";
	}
	}
	});
}

function chk_checkout()
{
	alert("Please select an item to continue.");
}

$(document).ready(function () {
	$('#expand_img').click(function () {
		$('#option_panel').slideDown(800);
		$('#hide_img').show();
		$('#expand_img').hide();
	});
	
	$('#hide_img').click(function () {
		$('#option_panel').slideUp(800);
		$('#hide_img').hide();
		$('#expand_img').show();		
	});
})
</script>