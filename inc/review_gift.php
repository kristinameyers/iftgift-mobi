<div role="main" class="ui-content jqm-content jqm-content-c">
		<a href="<?php echo ru;?>delivery_detail/" data-ajax="false"><img src="<?php echo ru_resource;?>images/backarrow.jpg" alt="Back Arrow" class="backarrow" /></a>
		<div class="ui-grid-b">
		<?php 
		if(count($_SESSION["products"]) >= 6)
		{
		?>
		<p class="item_sugg">To suggest an additional item you must replace one of the items in your iftCart.</p>	
		<?php } ?>
		<form id="form_caption" method="post" action="<?php echo ru;?>process/process_delivery.php">
		<input name="delivery_id" id="delivery_id" value="<?php echo $_SESSION['delivery_id']['New'];?>" type="hidden">
		<input name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" type="hidden">
		<input name="Caption" id="Caption" value="1" type="hidden">
		<?php
			if(isset($_SESSION["products"]))
			{ 
			foreach ($_SESSION["products"] as $cart_itm)
    		{
		?>
			<div class="ui-block-b">
				<div class="replace"><a href="<?php echo ru;?>process/process_cart.php?removep=<?php echo $cart_itm['proid'];?>" data-ajax="false"><img src="<?php echo ru_resource;?>images/replace_icon.png" alt="Replace Icon" /><span>replace</span></a></div>
				<div class="ui-bar ui-bar-a"><a class="list_img" href="<?php echo ru;?>detail/<?php echo $cart_itm['proid']; ?>" data-ajax="false"><img src="<?php  get_image($cart_itm['image']);?>" width="98" height="91" alt="<?php echo $cart_itm['name'];?>"></a></div>
				<h3><?php echo substr($cart_itm["name"],0,20)?></h3>
				<h3 class="item_price">$<?php echo $cart_itm["price"]?></h3>
				<a href="javascript:;" onclick="add_caption('<?php echo $cart_itm['proid'];?>');" class="ui-btn ui-corner-all caption" id="caption_<?php echo $cart_itm['proid']; ?>">Add Caption</a>
				<div class="ui-field-contain caption-area" id="caption-area_<?php echo $cart_itm['proid']; ?>" style="display:none">
				<input name="proId[]" id="proId" value="<?php echo $cart_itm['proid'];?>" type="hidden">
					<textarea cols="40" rows="8" name="img_caption[]" id="textarea-1" placeholder="Enter Image Caption Here ...."></textarea>
				</div>
			</div>
			<?php } } else{
    echo 'Your Cart is empty';
} ?>
		</div>
		<a href="javascript:;" onclick="Captions()" class="ui-btn ui-btn-c">Save and Continue</a>
		</form>
	</div>
	
<script>
function add_caption(id)
{
	var pId = id;
	$("#caption-area_"+pId).show("slow");
	$("#caption_"+pId).hide("slow");
}

function Captions(){
		document.getElementById("form_caption").submit()	
	}
</script>