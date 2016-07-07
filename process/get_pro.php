<?php
include_once("../connect/connect.php");
include_once("../config/config.php");
mysql_query("SET NAMES 'utf8'");
//echo "HERE HERE HERE";exit;
$category = mysql_real_escape_string(stripslashes(trim($_POST['category'])));
//$query = "select * from ".tbl_product." where (sub_category = '".$category."' || category = '".$category."') and (status = 1 or status = 0) and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
$query = "select * from ".tbl_product." where (sub_category = '".$category."') and (status = 1 or status = 0) and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
$get_pro = $db->get_results($query,ARRAY_A);

$view_cat = "select * from ".tbl_category." where status = 1 and cat_name='".$category."'";
$child_cat = $db->get_row($view_cat,ARRAY_A);

$view_cats = "select * from ".tbl_category." where status = 1 and catid='".$child_cat['p_catid']."'";
$parent_cat = $db->get_row($view_cats,ARRAY_A);
 
$query = "select * from ".tbl_product." where sub_category = '".mysql_real_escape_string(stripslashes(trim($child_cat['cat_name'])))."' and (status = 1 or status = 0) and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
 $view_pro = $db->get_row($query,ARRAY_A);
 
/***********************GET NEXT PRODUCT********************************/
 $sql = "SELECT proid FROM gift_product WHERE proid>{$view_pro['proid']}  and category = '".mysql_real_escape_string(stripslashes(trim($view_pro['category'])))."' and sub_category = '".mysql_real_escape_string(stripslashes(trim($view_pro['sub_category'])))."' and (status = 1 or status = 0) and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' ORDER BY proid LIMIT 1";
    $result = mysql_query($sql);
    if (@mysql_num_rows($result)>0) {
        $nextid = mysql_result($result,0);
    }
/***********************GET NEXT PRODUCT********************************/

/***********************GET PREVIOUS PRODUCT********************************/
$sqls = "SELECT proid FROM gift_product WHERE proid<{$view_pro['proid']} and category = '".mysql_real_escape_string(stripslashes(trim($view_pro['category'])))."' and sub_category = '".mysql_real_escape_string(stripslashes(trim($view_pro['sub_category'])))."' and (status = 1 or status = 0) and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' ORDER BY proid DESC LIMIT 1";
    $results = mysql_query($sqls);
    if (@mysql_num_rows($results)>0) {
        $previd = mysql_result($results,0);
    }	
/***********************GET PREVIOUS PRODUCT********************************/	
$suggest = count($_SESSION["products"]) + 1; 
if($view_pro) {
?>
		<div class="browse_cat sugg">Item #<?php echo $suggest ;?></div>
  	<div role="main" class="ui-content jqm-content jqm-content-c" id="picture2">
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
		<h3>More info <img src="<?php echo ru_resource;?>images/info_arrow.jpg" style="cursor:pointer" alt="More Info Arrow" id="more_info2" /></h3>
		<div class="prod_desp">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
		<!--<h3>Product Description Display Here</h3>-->
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
			<div id="own_it2" class="ui-block-a <?php if($get_own > 0) {?>active<?php } ?>" <?php if($get_own == 0) { ?>onclick="own_it('<?php echo $view_pro['proid'];?>','<?php echo $_SESSION['LOGINDATA']['USERID'];?>','own')" <?php } ?>><div class="ui-bar ui-bar-a">Own it<div class="own_it"></div><span><?php echo $view_q{'cnt'}; ?> People Own it</span></div></div>
			<div id="own_itbtm2"></div>
			
			<!-----------------------LOVE_IT----------------------------->
			<?php
			$get_love = mysql_num_rows(mysql_query("select userId from ".tbl_love." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
			$get_l = "SELECT count( love_it ) AS cnt FROM ".tbl_love." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( love_it )";
			$view_l = $db->get_row($get_l,ARRAY_A);
			?>
			<div id="love_it2" class="ui-block-b <?php if($get_love > 0) {?>active<?php } ?>" <?php if($get_love == 0) { ?>onclick="love_it('<?php echo $view_pro['proid'];?>','<?php echo $_SESSION['LOGINDATA']['USERID'];?>','love')" <?php } ?>><div class="ui-bar ui-bar-a">Love it<div class="own_it love_it"></div><span><?php echo $view_l{'cnt'}; ?> People Love it</span></div></div>
			<div id="love_itbtm2"></div>
			
			<!-----------------------HIDE_IT----------------------------->
			<?php
			$get_hide = mysql_num_rows(mysql_query("select userId from ".tbl_hide." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
			$get_h = "SELECT count( hide_it ) AS cnt FROM ".tbl_hide." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( hide_it )";
			$view_h = $db->get_row($get_h,ARRAY_A);
			?>
			<div id="hide_it2" class="ui-block-c <?php if($get_hide > 0) {?>active<?php } ?>" <?php if($get_hide == 0) { ?>onclick="hide_it('<?php echo $view_pro['proid'];?>','<?php echo $_SESSION['LOGINDATA']['USERID'];?>','hide')" <?php } ?>><div class="ui-bar ui-bar-a">Hide it<div class="own_it hide_it"></div><span><?php echo $view_h{'cnt'}; ?> People Hide it</span></div></div>
			<div id="hide_itbtm2"></div>
		</div><!-- /grid-b -->
		
		<?php /*?><a href="<?php echo ru;?>step_2a" data-ajax="false" class="back_arrow"><img src="<?php echo ru_resource;?>images/backarrow.jpg" alt="Back Arrow" class="backarrow" /> <span>Back to list</span></a><?php */?>
	</div><!-- /content -->
	<?php } ?>
	<div id="product_test2"></div>
	<div class="browse_cat">browse other categories</div>
	<div role="main" class="ui-content jqm-content jqm-content-c product_bar">
		<div class="product_title"><span><?php echo stripslashes($parent_cat['cat_name']);?>:</span> <?php echo stripslashes($category);?> <img src="<?php echo ru_resource;?>images/arrow_b.jpg" alt="Arrow" /></div>
		<div tabindex="-1" id="horizontal-scrollbar-demo" class="default-skin demo scrollable">
			<div class="viewport">
				<div style="top:0px; left:0;" class="overview">
				<?php
					if($get_pro)
					 {
					 foreach($get_pro as $products)
					 {
				?>
					<div class="list" id="<?php echo $products['proid']; ?>">
						<a href="#" data-ajax="false"><img src="<?php  get_image($products['image_code']);?>" alt="<?php echo substr($products['pro_name'],0,20);?>"></a>
						<h4><?php echo substr($products['pro_name'],0,20);?></h4>
						<h4 class="price">$&nbsp;<?php echo $products['price']?></h4>
					</div>
					<?php } } else { ?>
					<div style="margin-left:20px;">
					No Any Product 
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
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
    url: "<?php echo ru;?>process/get_products.php",
	type: "GET",
    dataType:'html',
	data:myData,
    success:function(response)
    {
        $('#product_test2').html(response);
		$('#picture2').hide();
    }
    });
}

$(document).ready(function() {
	$(".list").on('click', function () {
	var proid = this.id;
	//alert(proid);
		$.ajax({
		url: '<?php echo ru ?>process/get_products.php?picID='+proid,
		type: 'get',
		success: function(output) {
			$("#product_test2").html(output);
			$('#picture2').hide();
		}
		})
	});
});
</script>
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
	$('#own_it2').hide();
	$('#own_itbtm2').html(output);
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
	$('#love_it2').hide();
	$('#love_itbtm2').html(output);
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
	$('#hide_it2').hide();
	$('#hide_itbtm2').html(output);
	}
	});
}

$(document).ready(function () {
	$("#more_info2").click(function () {
		var test = $(".prod_desp").slideToggle('slow', function () {
			if ($(".prod_desp").css('display') === 'none')
		{
			$("#more_info2").attr("src", "<?php echo ru_resource ?>images/info_arrow.jpg");
		} else {
			$("#more_info2").attr("src", "<?php echo ru_resource ?>images/info_arrow_btm.jpg");
		}
		});
	});
});
</script>		
			