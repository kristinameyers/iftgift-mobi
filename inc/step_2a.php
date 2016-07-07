<?php
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
	$query_udemo = "Union select * from ".tbl_product." where (status = 1 or status = 0)  $get_price $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' $lovedata ORDER BY FIND_IN_SET('".$uId."',love_id) DESC";
	$query1 = "Union select distinct category,sub_category,love_id from ".tbl_product." where (status = 1 or status = 0) $get_price $lovedata ORDER BY FIND_IN_SET('".$uId."',love_id) DESC";
	}
	
	$get_catnames = "select distinct(category) from ".tbl_product." where (status = 1 or status = 0) $get_data $get_occassion_data $get_price $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' group by sub_category";
	
	$view_cat = $db->get_row($get_catnames,ARRAY_A);
	
	$view_catnames = $db->get_results($get_catnames,ARRAY_A);
	if($view_catnames) {
	foreach($view_catnames as $categorys) {
		$get_catid = "select * from ".tbl_category." where cat_name = '".$categorys['category']."' and p_catid = '0'";
		$view_catid = $db->get_results($get_catid,ARRAY_A);	
		foreach($view_catid as $catids) {
			$categoryids[] = $catids['catid'];
		}
	} }
	$cat_array = $categoryids;
	//print_r($cat_array);
	$get_cat = "select * from ".tbl_category." where cat_name = '".$view_cat['category']."'";
	$view_current_catid = $db->get_row($get_cat,ARRAY_A);
	$product_ids = $view_current_catid['catid'];
	$current_index = @array_search($product_ids, $cat_array);
    $next = $current_index + 1;
	$prev = $current_index - 1;	
	
	$get_subcat = "select distinct(sub_category),image_code from ".tbl_product." where category = '".$view_cat['category']."' and (status = 1 or status = 0) $get_data $get_price $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' group by sub_category LIMIT 0 , 6";

	 $view_subcat = $db->get_results($get_subcat,ARRAY_A);	 
?>
<div id="view_defaultpor">
	<!-- Default Next/Prev Product Div -->
	<div role="main" class="ui-content jqm-content jqm-content-c cate_image" id="picture">
		<h3 class="item_name">Category: <span><?php  echo ucfirst($view_cat['category']);?></span></h3>
		<div class="cate_arrow">
			<?php if($prev > 0 or $prev == 0) { ?>
			<a href="#" id="getPicButton_<?php echo $cat_array[$prev];?>" class="prod_arrow_left"></a>
			<?php } ?>
		</div>
		<div class="ui-grid-b">
		<?php
		if($view_subcat) {
		foreach($view_subcat as $sub_cat) { ?>
			<div class="ui-block-a"><div class="ui-bar ui-bar-a"><a href="<?php echo ru;?>step_2b/<?php echo encodeURL($sub_cat['sub_category']);?>" data-ajax="false"><img src="<?php  get_image($sub_cat['image_code']);?>" align="Category Image" title="<?php echo $sub_cat['sub_category'];?>" class="cata_img"/><span><?php echo substr(ucfirst($sub_cat['sub_category']),0,11); ?></span></a></div></div>
		<?php } } ?>	
		</div><!-- /grid-b -->
		<div class="cate_arrow cate_arrow_b">
			<?php if($next < count($cat_array)) { ?>
			<a href="#" id="getPicButton_<?php echo $cat_array[$next];?>" class="prod_arrow_left prod_arrow_right"></a>
			<?php } ?>
		</div>
	</div>
		<div class="show_all_cata">Show All within category</div>
		<div role="main" class="ui-content jqm-content jqm-content-c product_bar" id="sub_catgeory" style="display:none">
		<?php 
		$get_subcats = "select distinct(sub_category),image_code from ".tbl_product." where category = '".$view_cat['category']."' and (status = 1 or status = 0) $get_data $get_price $owndata $hidedata and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' group by sub_category";

	 	$view_subcats = $db->get_results($get_subcats,ARRAY_A);
			if($view_subcats) {
			foreach($view_subcats as $child_cat ) { 
			?>
		<div class="product_title"><span><?php echo ucfirst($view_cat['category']);?>:</span> <?php echo ucfirst($child_cat['sub_category']);?> <img src="<?php echo ru_resource;?>images/arrow_b.jpg" alt="Arrow" /></div>
		<div tabindex="-1" id="horizontal-scrollbar-demo" class="default-skin demo scrollable">
			<div  class="viewport">
				<div style="top:0px; left:0;" class="overview">
				<?php
					$get_pro = "select * from ".tbl_product." where category = '".mysql_real_escape_string(stripslashes(trim($view_cat['category'])))."' and sub_category = '".mysql_real_escape_string(stripslashes(trim($child_cat['sub_category'])))."' $get_data $get_price $get_occassion_data and (status = 1 or status = 0) $owndata $hidedata  and  hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
					if(mysql_num_rows($chk_users) > 0) {
					$get_pro1 = "UNION select * from ".tbl_product." where category = '".mysql_real_escape_string(stripslashes(trim($view_cat['category'])))."' and sub_category = '".mysql_real_escape_string(stripslashes(trim($child_cat['sub_category'])))."' $get_price and (status = 1 or status = 0) $owndata $hidedata  and  hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' $lovedata ORDER BY FIND_IN_SET('".$uId."',love_id) DESC";
					}
					$get_pros =  $get_pro." ".$get_pro1;
					
					$view_pro = $db->get_results($get_pros,ARRAY_A);
					if($view_pro)
					 {
					 foreach($view_pro as $product)
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
	<!-- Default You Product Div -->	
</div>
	<div id="product_test"></div>
	<!-- ***********************Show Div Onclick Menu Item************************* -->
<div id="pro_test"></div>
	<!-- ***********************Show Div Onclick Menu Item************************* -->
<style>
.ui-page .footer_outer{position:absolute; bottom:0;}
.jqm-content-c{ overflow-x:visible; border:0}
</style>

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
    url: "<?php echo ru;?>process/get_product2.php",
	type: "GET",
    dataType:'html',
	data:myData,
    success:function(response)
    {
		$('#product_test').html(response);
		$('#view_defaultpor').hide();
    }
    });
}

$(document).ready(function () {
	$('.show_all_cata').click(function () {
		$('#sub_catgeory').toggle("slow");
		$('.show_all_cata').toggleClass('active');
	})
})
</script>
<!-- Function For Next/Prev Product -->		
	