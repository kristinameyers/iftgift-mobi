<?php
	include_once("../connect/connect.php");
	include_once("../config/config.php");
	mysql_query("SET NAMES 'utf8'");
   $category = mysql_real_escape_string(stripslashes(trim($_GET['picID'])));
   $get_catnames = "select * from ".tbl_category." where catid = '".$category."' and p_catid = '0'";
	
   $view_cat = $db->get_row($get_catnames,ARRAY_A);
	
	$get_subcat = "select distinct(sub_category),image_code from ".tbl_product." where category = '".$view_cat['cat_name']."' and (status = 1 or status = 0) and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' group by sub_category LIMIT 0 , 6";

	 $view_subcat = $db->get_results($get_subcat,ARRAY_A);


/***********************GET NEXT PRODUCT********************************/
 $nxtsql = "SELECT catid FROM ".tbl_category." WHERE catid>{$view_cat['catid']} and p_catid = '0' ORDER BY catid LIMIT 1";
 
    $result = mysql_query($nxtsql);
    if (@mysql_num_rows($result)>0) {
        $nextid = mysql_result($result,0);
    }
/***********************GET NEXT PRODUCT********************************/	

/***********************GET PREVIOUS PRODUCT********************************/
$prevsql = "SELECT catid FROM ".tbl_category." WHERE catid<{$view_cat['catid']} and p_catid = '0' ORDER BY catid DESC LIMIT 1";

    $results = mysql_query($prevsql);
    if (@mysql_num_rows($results)>0) {
        $previd = mysql_result($results,0);
    }
/***********************GET PREVIOUS PRODUCT********************************/ 	 
?>
<div id="view_defaultpor">
	<!-- Default Next/Prev Product Div -->
	<div role="main" class="ui-content jqm-content jqm-content-c cate_image" id="picture">
		<h3 class="item_name">Category: <span><?php  echo ucfirst($view_cat['cat_name']);?></span></h3>
		<div class="cate_arrow">
			<?php if($previd != '') { ?>
			<a href="#" id="getPicButton_<?php echo $previd;?>" class="prod_arrow_left"></a>
			<?php } ?>
		</div>
		<div class="ui-grid-b">
		<?php
		if($view_subcat) {
		foreach($view_subcat as $sub_cat) { ?>
			<div class="ui-block-a"><div class="ui-bar ui-bar-a"><a href="<?php echo ru;?>listings/<?php echo encodeURL($sub_cat['sub_category']);?>" data-ajax="false"><img src="<?php  get_image($sub_cat['image_code']);?>" align="Category Image" title="<?php echo $sub_cat['sub_category'];?>" class="cata_img"/><span><?php echo substr(ucfirst($sub_cat['sub_category']),0,11); ?></span></a></div></div>
		<?php } } ?>	
		</div><!-- /grid-b -->
		<div class="cate_arrow cate_arrow_b">
			<?php if($nextid != '') { ?>
			<a href="#" id="getPicButton_<?php echo $nextid;?>" class="prod_arrow_left prod_arrow_right"></a>
			<?php } ?>
		</div>
	</div>
		<div class="show_all_cata">Show All within category</div>
		<div role="main" class="ui-content jqm-content jqm-content-c product_bar" id="sub_catgeorys" style="display:none">
		<?php 
		$get_subcats = "select distinct(sub_category),image_code from ".tbl_product." where category = '".$view_cat['cat_name']."' and (status = 1 or status = 0) and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%' group by sub_category";

	 	$view_subcats = $db->get_results($get_subcats,ARRAY_A);
			if($view_subcats) {
			foreach($view_subcats as $child_cat ) { 
			?>
		<div class="product_title"><span><?php echo ucfirst($view_cat['cat_name']);?>:</span> <?php echo ucfirst($child_cat['sub_category']);?> <img src="<?php echo ru_resource;?>images/arrow_b.jpg" alt="Arrow" /></div>
		<div tabindex="-1" id="horizontal-scrollbar-demo" class="default-skin demo scrollable">
			<div  class="viewport">
				<div style="top:0px; left:0;" class="overview">
				<?php
					$get_pro = "select * from ".tbl_product." where category = '".mysql_real_escape_string(stripslashes(trim($view_cat['cat_name'])))."' and sub_category = '".mysql_real_escape_string(stripslashes(trim($child_cat['sub_category'])))."' $get_data $get_price $get_occassion_data and (status = 1 or status = 0) $owndata $hidedata  and  hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
					
					$get_pros =  $get_pro;
					
					$view_pro = $db->get_results($get_pros,ARRAY_A);
					if($view_pro)
					 {
					 foreach($view_pro as $product)
					 {
				?>
					<div class="list">
						<?php /*?><a href="<?php echo ru;?>listings/<?php echo encodeURL($product['sub_category']);?>" data-ajax="false"><img src="<?php  get_image($product['image_code']);?>" alt="<?php echo substr($product['pro_name'],0,20);?>"></a><?php */?>
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
		</div>
	<!-- Default You Product Div -->	
</div>
	<div id="product_test"></div>
<style>
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
    url: "<?php echo ru;?>process/get_lictcat.php",
	type: "GET",
    dataType:'html',
	data:myData,
    success:function(response)
    {
		$('#product_test').html(response);
		$('#view_defaultpor').hide();
		$(".demo").customScrollbar();
        $("#fixed-thumb-size-demo").customScrollbar({fixedThumbHeight: 50, fixedThumbWidth: 60});
    }
    });
}

$(document).ready(function () {
	$('.show_all_cata').click(function () {
		$('#sub_catgeorys').toggle("slow");
		$('.show_all_cata').toggleClass('active');
	})
})
</script>
<!-- Function For Next/Prev Product -->		
	