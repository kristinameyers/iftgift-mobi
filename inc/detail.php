<?php
$proid = $_GET['s'];
$query = "select * from ".tbl_product." where proid = '".$proid."'";
$view_pro = $db->get_row($query,ARRAY_A);
?>
<div role="main" class="ui-content jqm-content jqm-content-c">
		<a href="<?php echo ru;?>cart" data-ajax="false"><img src="<?php echo ru_resource;?>images/backarrow.jpg" alt="Back Arrow" class="backarrow" /></a>
		<div class="ui-grid-b">
			<div class="ui-block-a ui-block-pd">
				<div class="ui-bar ui-bar-a"><img src="<?php  get_image($view_pro['image_code']);?>" width="280" height="230" alt="Product image" /></div>
				<h3><?php echo wordwrap($view_pro['pro_name'], 20, "<br />\n");?></h3>
				<h3 class="item_price">$ <?php echo $view_pro['price'];?></h3>
			</div>
		</div><!-- /grid-b -->
	</div>
	