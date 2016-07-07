<?php
if(isset($_SESSION["products"])) {
?>
<div role="main" class="ui-content jqm-content jqm-content-c">
	<a href="<?php echo ru;?>step_2a/" data-ajax="false"><img src="<?php echo ru_resource;?>images/backarrow.jpg" alt="Back Arrow" class="backarrow" /></a>
		<div class="ui-grid-b">
			<?php if(count($_SESSION["products"]) >= 6) {?>
				<p class="item_sugg">To suggest an additional item you must replace one of the items in your iftCart.</p>	
			<?php } 
				if(isset($_SESSION["products"])) { 
					foreach ($_SESSION["products"] as $cart_itm) { ?>
						<div class="ui-block-b">
							<div class="replace"><a href="<?php echo ru;?>process/process_cart.php?removep=<?php echo $cart_itm['proid'];?>" data-ajax="false"><img src="<?php echo ru_resource;?>images/replace_icon.png" alt="Replace Icon" /><span>replace</span></a></div>
							<div class="ui-bar ui-bar-a"><a class="list_img" href="<?php echo ru;?>detail/<?php echo $cart_itm['proid']; ?>" data-ajax="false"><img src="<?php  get_image($cart_itm['image']);?>" width="98" height="91" alt="<?php echo $cart_itm['name'];?>"></a></div>
							<h3><?php echo substr($cart_itm["name"],0,20)?></h3>
							<h3 class="item_price">$<?php echo $cart_itm["price"]?></h3>
						</div>
			<?php 	} 
				} else { echo 'Your Cart is empty';} ?>
		</div>
</div>
<?php } else if(isset($_SESSION['cart'])) {
include_once("process/cart_functions.php");
?>
<div role="main" class="ui-content jqm-content jqm-content-c">
	<a href="<?php echo ru;?>step_2a/" data-ajax="false"><img src="<?php echo ru_resource;?>images/backarrow.jpg" alt="Back Arrow" class="backarrow" /></a>
		<div class="ui-grid-b">
			<?php if(count($_SESSION["cart"]) >= 6) {?>
				<p class="item_sugg">To suggest an additional item you must replace one of the items in your iftCart.</p>	
			<?php } 
				if(is_array($_SESSION["cart"])) { 
					$max=count($_SESSION['cart']);
					for($i=0;$i<$max;$i++){
					$pid=$_SESSION['cart'][$i]['productid'];
					$q=$_SESSION['cart'][$i]['qty'];
					$pname=get_product_name($pid);
					$image=get_pro_image($pid);
					 ?>
						<div class="ui-block-b">
							<div class="replace"><a href="javascript:del(<?php echo $pid?>)" data-ajax="false"><img src="<?php echo ru_resource;?>images/replace_icon.png" alt="Replace Icon" /><span>replace</span></a></div>
							<div class="ui-bar ui-bar-a"><a class="list_img" href="<?php echo ru;?>detail/<?php echo $pid; ?>" data-ajax="false"><img src="<?php  get_image($image);?>" width="98" height="91" alt="<?php echo $pname;?>"></a></div>
							<h3><?php echo substr($pname,0,20)?></h3>
							<h3 class="item_price">$<?php echo get_prices($pid)?></h3>
						</div>
			<?php 	} 
				} else { echo 'Your Cart is empty';} ?>
		</div>
</div>
<form name="form1" method="post" action="<?php echo ru;?>process/process_buysuggest.php" data-ajax="false">
<input type="hidden" name="pid" />
<input type="hidden" name="command" />
</form>
<script type="text/javascript">
function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
</script>
<?php } ?>