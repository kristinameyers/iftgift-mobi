<?php
	$sub_category = mysql_real_escape_string(stripslashes(trim(str_replace('_',' ',$_GET['s']))));
	
 	$recption_id = $_SESSION['recipit_id']['New'];
 
 	$get_recp = get_recp_info($recption_id);
 	$cash = $get_recp['cash_gift'];
	$gender = $get_recp['gender'];
	$age = $get_recp['age'];
	$ocassion = $get_recp['ocassion'];
	$get_price = get_price($cash);
	$get_data = get_category($gender,$age);
	$get_occassion_data = get_ocassion($ocassion);
	
	$chk_users = mysql_query("select userId,email from ".tbl_user." where email = '".$get_recp['email']."'");
	if(mysql_num_rows($chk_users) > 0) {
	$get_userid = mysql_fetch_array($chk_users);
	$uId = $get_userid['userId'];
	$owndata = "and own_id not like '%".$uId."%'";
	$hidedata = "and hide_id not like '%".$uId."%'";
	$lovedata = "and love_id like '%".$uId."%'";
	$query_udemo = "Union select * from ".tbl_product." where sub_category like '%".$sub_category."%' and (status = 1 or status = 0) $get_price $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' $lovedata ORDER BY FIND_IN_SET('".$uId."',love_id) DESC";
	$query1 = "Union select distinct category,sub_category,love_id from ".tbl_product." where (status = 1 or status = 0) $get_price $lovedata ORDER BY FIND_IN_SET('".$uId."',love_id) DESC";
	}
	

 $query_demo = "select * from ".tbl_product." where sub_category like '%".$sub_category."%' and (status = 1 or status = 0) $get_data $get_price $get_occassion_data $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";

 $select_products =  $query_demo." ".$query_udemo;

 $view_pro = $db->get_row($select_products,ARRAY_A);

 
 $querys = "select distinct category,sub_category,love_id from ".tbl_product." where (status = 1 or status = 0) $get_data $get_price $get_occassion_data";
 
 $cat_query =  $querys." ".$query1;
 $view_pros = $db->get_results($cat_query,ARRAY_A);
 

 
/***********************GET NEXT PRODUCT********************************/
 $nxtsql = "SELECT proid FROM ".tbl_product." WHERE proid>{$view_pro['proid']} and sub_category like '%".$sub_category."%'  $get_data $get_price $get_occassion_data and (status = 1 or status = 0) $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
 if(mysql_num_rows($chk_users) > 0) {
 $nxtsqls = "UNION SELECT proid FROM ".tbl_product." WHERE proid>{$view_pro['proid']} and sub_category like '#".$sub_category."#' $get_price and (status = 1 or status = 0) $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' $lovedata";
 }
 	$next_pro =  $nxtsql." ".$nxtsqls."ORDER BY proid LIMIT 1";
 
    $result = mysql_query($next_pro);
    if (@mysql_num_rows($result)>0) {
        $nextid = mysql_result($result,0);
    }
/***********************GET NEXT PRODUCT********************************/

/***********************GET PREVIOUS PRODUCT********************************/
$prevsql = "SELECT proid FROM ".tbl_product." WHERE proid<{$view_pro['proid']} and sub_category like '%".$sub_category."%' $get_data $get_price $get_occassion_data and (status = 1 or status = 0) $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
if(mysql_num_rows($chk_users) > 0) {
$prevsqls = "UNION SELECT proid FROM ".tbl_product." WHERE proid<{$view_pro['proid']} and sub_category like '%".$sub_category."%' $get_price and (status = 1 or status = 0) $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' $lovedata";
}
$prev_pro =  $prevsql." ".$prevsqls."ORDER BY proid DESC LIMIT 1";

    $results = mysql_query($prev_pro);
    if (@mysql_num_rows($results)>0) {
        $previd = mysql_result($results,0);
    }
/***********************GET PREVIOUS PRODUCT********************************/	

$suggest = count($_SESSION["products"]) + 1;
?>
<!-- Show Default Product Product on Page -->
<div id="view_defaultpor">
<div class="browse_cat sugg">Item #<?php echo $suggest ;?></div>
	<!-- Default Next/Prev Product Div -->
  	
	<div role="main" class="ui-content jqm-content jqm-content-c" id="picture">
		<?php if($previd != '') { ?>
		<a href="#" id="getPicButton_<?php echo $previd;?>" class="prod_arrow_left"></a>
		<?php } ?>
		<img src="<?php  get_image($view_pro['image_code']);?>" width="220" height="220" alt="<?php  echo substr($view_pro['pro_name'],0,50);?>" class="prod_img" />
		<?php if($nextid != '') { ?>
		<a href="#" id="getPicButton_<?php echo $nextid;?>" class="prod_arrow_left prod_arrow_right"></a>
		<?php } ?>
		<h3 class="item_name item_price">$<?php  echo $view_pro['price'];?></h3>
		<h3 class="item_name"><?php  echo substr($view_pro['pro_name'],0,50);?></h3>
		<p class="item_type"><strong>Vendor:</strong> <?php  echo $view_pro['vendor'];?>, <strong>Category:</strong> <?php  echo ucfirst($view_pro['category']).' , '.ucfirst($view_pro['sub_category']);?></p>
		<h3>More info <img src="<?php echo ru_resource;?>images/info_arrow.jpg" alt="More Info Arrow" id="more_info" /></h3>
		<div class="prod_desp">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
		<form method="post" action="<?php echo ru;?>process/process_cart.php" data-ajax="false">
			<input type="hidden" name="proId" id="proId" value="<?php echo $view_pro['proid'];?>" />
			<input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" />
			<input type="hidden" name="type" id="type" value="add" />
			<input type="hidden" name="qty" id="qty" value="1" />
			<button class="ui-btn ui-corner-all" id="suggest_test">Suggest</button>
		</form>
		<div class="user_love_it" style="display:none;">
			<img src="<?php echo ru_resource;?>images/user_love_it.jpg" alt="User Love It" /> <span>[ Test ] Loves it !</span>
		</div>
		<div class="ui-grid-b item-likes-type">
		<!---------------------OWN_IT------------------------------->
		<?php
			$get_own = mysql_num_rows(mysql_query("select userId from ".tbl_own." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
			$get_q = "SELECT count( own_it ) AS cnt FROM ".tbl_own." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( own_it )";
			$view_q = $db->get_row($get_q,ARRAY_A);
			?>
			<div id="own_it" class="ui-block-a <?php if($get_own > 0) {?>active<?php } ?>" <?php if($get_own == 0) { ?>onclick="own_it('<?php echo $view_pro['proid'];?>','<?php echo $_SESSION['LOGINDATA']['USERID'];?>','own')" <?php } ?>><div class="ui-bar ui-bar-a">Own it<div class="own_it"></div><span><?php echo $view_q{'cnt'}; ?> People Own it</span></div></div>
			<div id="own_itbtm"></div>
			
			<!-----------------------LOVE_IT----------------------------->
			<?php
			$get_love = mysql_num_rows(mysql_query("select userId from ".tbl_love." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
			$get_l = "SELECT count( love_it ) AS cnt FROM ".tbl_love." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( love_it )";
			$view_l = $db->get_row($get_l,ARRAY_A);
			?>
			<div id="love_it" class="ui-block-b <?php if($get_love > 0) {?>active<?php } ?>" <?php if($get_love == 0) { ?>onclick="love_it('<?php echo $view_pro['proid'];?>','<?php echo $_SESSION['LOGINDATA']['USERID'];?>','love')" <?php } ?>><div class="ui-bar ui-bar-a">Love it<div class="own_it love_it"></div><span><?php echo $view_l{'cnt'}; ?> People Love it</span></div></div>
			<div id="love_itbtm"></div>
			
			<!-----------------------HIDE_IT----------------------------->
			<?php
			$get_hide = mysql_num_rows(mysql_query("select userId from ".tbl_hide." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
			$get_h = "SELECT count( hide_it ) AS cnt FROM ".tbl_hide." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( hide_it )";
			$view_h = $db->get_row($get_h,ARRAY_A);
			?>
			<div id="hide_it" class="ui-block-c <?php if($get_hide > 0) {?>active<?php } ?>" <?php if($get_hide == 0) { ?>onclick="hide_it('<?php echo $view_pro['proid'];?>','<?php echo $_SESSION['LOGINDATA']['USERID'];?>','hide')" <?php } ?>><div class="ui-bar ui-bar-a">Hide it<div class="own_it hide_it"></div><span><?php echo $view_h{'cnt'}; ?> People Hide it</span></div></div>
			<div id="hide_itbtm"></div>
		</div><!-- /grid-b -->
	</div>
	<div id="you_cat">
	<!-- Default Next/Prev Product Div -->
	<!-- Next/Prev Product Div After Click On Next/Prev -->
	<div id="product_test"></div>
	<!-- Next/Prev Product Div After Click On Next/Prev -->
	<!-- Default You Product Div -->
	
		<?php /*?><div class="browse_cat">browse other categories</div><?php */?>
		<div class="show_all_cata"><a href="<?php echo ru; ?>step_2a" data-ajax="false" style="color: #aaa8a9;">Back to Category</a></div>
			<div role="main" class="ui-content jqm-content jqm-content-c product_bar">
		<?php 
			$get_subcats = "select distinct(sub_category),image_code from ".tbl_product." where category = '".$view_pro['category']."' and (status = 1 or status = 0) $get_data $get_price $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' group by sub_category";

	 		$view_subcats = $db->get_results($get_subcats,ARRAY_A);
			if($view_subcats) {
			foreach($view_subcats as $child_cat ) { 
			?>
		<div class="product_title"><span><?php echo ucfirst($view_pro['category']);?>:</span> <?php echo ucfirst($child_cat['sub_category']);?> <img src="<?php echo ru_resource;?>images/arrow_b.jpg" alt="Arrow" /></div>
		<div tabindex="-1" id="horizontal-scrollbar-demo" class="default-skin demo scrollable">
			<div  class="viewport">
				<div style="top:0px; left:0;" class="overview">
				<?php
					$get_pro = "select * from ".tbl_product." where category = '".mysql_real_escape_string(stripslashes(trim($view_pro['category'])))."' and sub_category = '".mysql_real_escape_string(stripslashes(trim($child_cat['sub_category'])))."' $get_data $get_price $get_occassion_data and (status = 1 or status = 0) $owndata $hidedata  and  hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
					if(mysql_num_rows($chk_users) > 0) {
					$get_pro1 = "UNION select * from ".tbl_product." where category = '".mysql_real_escape_string(stripslashes(trim($view_pro['category'])))."' and sub_category = '".mysql_real_escape_string(stripslashes(trim($child_cat['sub_category'])))."' $get_price and (status = 1 or status = 0) $owndata $hidedata  and  hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' $lovedata ORDER BY FIND_IN_SET('".$uId."',love_id) DESC";
					}
					$get_pros =  $get_pro." ".$get_pro1;
					
					$view_pro_pro = $db->get_results($get_pros,ARRAY_A);
					if($view_pro_pro)
					 {
					 foreach($view_pro_pro as $product)
					 {
				?>
					<div class="list">
						<a href="<?php echo ru;?>product_detail/<?php echo $product['proid'];?>" data-ajax="false"><img src="<?php  get_image($product['image_code']);?>" alt="<?php echo substr($product['pro_name'],0,20);?>"></a>
						<h4><?php echo substr($product['pro_name'],0,20);?></h4>
						<h4 class="price">$&nbsp;<?php echo $product['price']?></h4>
					</div>
					<?php } } else { ?>
					<div style="margin-left:20px;">
					No Any Product 
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } } ?>
		<script type="text/javascript">
    $(window).load(function () {
        $(".demo").customScrollbar();
        $("#fixed-thumb-size-demo").customScrollbar({fixedThumbHeight: 50, fixedThumbWidth: 60});
    });
</script>	
		</div>
		</div>
	<!-- Default You Product Div -->	
	<!-- S'jester Product Div -->	
		<?php /*?><div id="sjester" style="display:none">
		<div id="product_jtest"></div>
		<div class="browse_cat browse_cat_b">Gifts S'Jester is Suggesting For <?php echo ucfirst($view['first_name']);?>:</div>
		<div id="myCanvasContainer">
 			<canvas width="250" height="250" id="myCanvas">
  				<p>will be replaced by something else</p>
  		</canvas>
 	 </div>
		<div id="tags">
    	<ul>
	<?php	 
		//$get_pro = "select p.*,c.* from ".tbl_product." p, ".tbl_category." c where p.category = c.cat_name and c.sjester = '2' and (p.status = 1 or p.status = 0) $get_data $get_price $get_occassion_data $owndata $hidedata and p.hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' ORDER BY price";
					$view_pro = $db->get_results($select_products,ARRAY_A);
					if($view_pro)
					 {
					 foreach($view_pro as $product)
					 {
				?>
 				 <li><a style="font-size: 16pt"><?php echo substr($product['pro_name'],0,20);?></a></li>
			<?php } } ?>
  		</ul>
 </div>
 		
 		<?php include_once(ru_common."sjester_filter.php");?>		
	</div><?php */?>
	<!-- S'jester Product Div -->	
</div>
<!-- Show Default Product Product on Page -->	
	<!-- ***********************Show Div Onclick Menu Item************************* -->
<div id="pro_test"></div>
	<!-- ***********************Show Div Onclick Menu Item************************* -->
	<!--<div id="filtered_pro"></div>-->
<style>
.jqm-content-c{ overflow-x:visible; border:0}
</style>
<?php /*?><script type="text/javascript">
function funresets()
{
	document.getElementById("Searchforms").reset();
}

function funreset()
{
	document.getElementById("Searchforms2").reset();
}

      window.onload = function() {
        try {
          TagCanvas.Start('myCanvas','tags',{
            textColour: '#000000',
            outlineColour: '#ff00ff',
			outlineMethod: 'none',
            reverse: true,
            maxSpeed: 0.05,
			depth: 0.99,
  			weight: true,
  			weightMode: "size",
  			weightFrom: null,
			activeCursor: 'auto',
			initial : [0.1,-0.1],
			decel : 0.98,
			maxSpeed : 0.04,
			minBrightness : 0.2,
			depth : 0.92,
			pulsateTo : 0.6
          });
        } catch(e) {
          // something went wrong, hide the canvas container
          document.getElementById('myCanvasContainer').style.display = 'none';
        }
      };
    </script><?php */?>
	
<!-- Function For Next/Prev Product -->	
<script type="text/javascript">
$(document).ready(function() {
$(".prod_arrow_left").live("click", function() {
	var myPictureId = $(this).attr('id');
	var getImgId =  myPictureId.split("_");
	getPicture(getImgId[1]); 
	return false;
});
});

function getPicture(myPicId)
{
var myData = 'picID='+myPicId;
jQuery.ajax({
    url: "<?php echo ru;?>process/get_product.php",
	type: "GET",
    dataType:'html',
	data:myData,
    success:function(response)
    {
		$('#product_test').html(response);
        $('#product_jtest').html(response);
		$('#picture').hide();
    }
    });
}
</script>
<!-- Function For Next/Prev Product -->		
<script type="text/javascript">
function own_it(proid,uid,type)
{
	var proId = proid;
	var userId = uid;
	var type = type;
	$.ajax({
	url: '<?php echo ru;?>process/process_product.php?proid='+proId+'&userId='+userId+'&type='+type,
	type: 'get', 
	success: function(output) {
	$('#own_it').hide();
	$('#own_itbtm').html(output);
	}
	});
}

function love_it(proid,uid,type)
{
	var proId = proid;
	var userId = uid;
	var type = type;
	$.ajax({
	url: '<?php echo ru;?>process/process_product.php?proid='+proId+'&userId='+userId+'&type='+type,
	type: 'get', 
	success: function(output) {
	$('#love_it').hide();
	$('#love_itbtm').html(output);
	}
	});
}

function hide_it(proid,uid,type)
{
	var proId = proid;
	var userId = uid;
	var type = type;
	$.ajax({
	url: '<?php echo ru;?>process/process_product.php?proid='+proId+'&userId='+userId+'&type='+type,
	type: 'get', 
	success: function(output) {
	$('#hide_it').hide();
	$('#hide_itbtm').html(output);
	}
	});
}

$(document).ready(function () {
	$("#more_info").click(function () {
		var test = $(".prod_desp").slideToggle('slow', function () {
			if ($(".prod_desp").css('display') === 'none')
		{
			$("#more_info").attr("src", "<?php echo ru_resource ?>images/info_arrow.jpg");
		} else {
			$("#more_info").attr("src", "<?php echo ru_resource ?>images/info_arrow_btm.jpg");
		}
		});
	})
})
</script>	