<?php
 $cash_amount = $get_dev['cash_amount'];
 $get_cuser = $db->get_row("select available_cash,party_mode from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'",ARRAY_A);;
 $available_cash = $get_cuser['available_cash'];
 $party_mode = $get_cuser['party_mode'];
?>
<style>.ift_block h4.recip{width:98%; text-align:center; margin-left:1%}</style>
	<div role="main" class="ui-content unwrap-content">
		<div class="ui-field-contain ui-field-contain-b">
			<label>Party Mode!</label>
			<select name="flip-5" id="flip-5" data-role="slider" data-mini="true">
				<option value="off" <?php if($party_mode == 'off') echo 'selected="selected"'; ?>>Off</option>
				<option value="on" <?php if($party_mode == 'on') echo 'selected="selected"'; ?>>On</option>
			</select>
		</div>
		<script type="text/javascript">
		$('select').on('change', function() {
  			var id = this.value;
			var uid = '<?php echo $_SESSION['LOGINDATA']['USERID']; ?>';
			$.ajax({
			url: '<?php echo ru;?>process/process_mode.php',
			type: 'POST', 
			data: {mode:id,userid:uid} ,
			success: function(output) {
				if(output == 'on')
				{
					$('#row_dim').hide();
				} else {
					$('#row_dim').show(); 
				}
			}
			})
		});
		</script>
		<p class="dip_gift">Display your IftGifts, but keep cash amounts private</p>
		<?php if($party_mode == 'off' || $party_mode == '') { ?>
		<div class="total_cash" id="row_dim">
			<h3>$<?php echo $cash_amount;?></h3>
			<div class="total_stach">Total Cash^Stash <span>$<?php echo $available_cash;?></span></div>
		</div>
		<?php } else { ?>
		<div class="total_cash" id="row_dim" style="display:none">
			<h3>$<?php echo $cash_amount;?></h3>
			<div class="total_stach">Total Cash^Stash <span>$<?php echo $available_cash;?></span></div>
		</div>
		<?php } ?>
	</div>
	<div role="main" class="ui-content unwrap-content">
		<fieldset class="ui-grid-a unwrap-button">
			<div class="ui-block-a pink-button"><input value="Continue Shopping" data-theme="a" type="submit"></div>
			<div class="ui-block-b blue-button"><input value="Transfer Cash Stash" data-theme="b" type="button" onclick="goto_transfer()"></div>
		</fieldset>
	</div>	
	<div role="main" class="ui-content jqm-content jqm-content-c unwrap_item">
		<div class="ui-grid-b">
		<?php
		$proId = stripslashes($get_dev['proid']);
		$proid = json_decode($proId,true);
		if($proid) {
			foreach($proid as $pro )
			{
				$product_id = $pro['proid'];
				$caption = $pro['caption'];
				$get_pro = "select * from ".tbl_product." where proid = '".$product_id."'";
				$view_pro = $db->get_results($get_pro,ARRAY_A);
				foreach($view_pro as $product)
				{
		?>
			<div class="ui-block-a suggest">
				<div class="ui-bar ui-bar-a">
					<div class="replay">
					<?php /*?><?php echo ru; ?>product_detail/<?php echo $product_id;?><?php */?>
						<a href="<?php echo ru;?>product_detail/<?php echo $product_id; ?>" data-ajax="false"><img src="<?php echo ru_resource?>images/replay_icon.jpg" alt="Replay Icon" /></a>
					</div>
					<img src="<?php  get_image($product['image_code']);?>" width="98" height="91" alt="Product image" />
					<?php if($caption != '') { ?>
					<div class="replay comment">
						<a href="javascript:;" id="img_<?php echo $product_id;?>" onclick="show_caption('<?php echo $product_id;?>');"><img src="<?php echo ru_resource?>images/comment_icon.jpg" alt="Comment Icon" /></a>
						<?php /*?><a href="#popupInfo_<?php echo $product_id;?>" data-rel="popup" data-transition="pop" class="my-tooltip-btn ui-btn ui-alt-icon ui-nodisc-icon ui-btn-inline ui-icon-info " title="Learn more"><img src="<?php echo ru_resource?>images/comment_icon.jpg" alt="Comment Icon" /></a><?php */?>
						
						<?php /*?><a href="#popupCloseLeft_<?php echo $product_id;?>" data-rel="popup" class="ui-btn ui-corner-all ui-shadow ui-btn-inline"><img src="<?php echo ru_resource?>images/comment_icon.jpg" alt="Comment Icon" /></a><?php */?>
						<?php /*?><div data-role="popup" id="popupInfo_<?php echo $product_id;?>" class="ui-content" data-theme="a">
							<p><?php echo $caption;?></p>
						</div><?php */?>
						
						<?php /*?><div data-role="popup" id="popupCloseLeft_<?php echo $product_id;?>" class="ui-content">
							<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-left">Close</a>
							<p><?php echo $caption;?></p>
						</div><?php */?>
					</div>
					<?php } ?>
				</div>
				
					<?php if($caption != '') { ?>
					<div class="caption_btm" id="cap_<?php echo $product_id; ?>" style="display:none">
						<h3><?php echo $caption;?></h3>
					</div>
					<?php } ?>
				
					<h3 id="proname_<?php echo $product_id; ?>"><?php echo substr($product['pro_name'],0,33);?></h3>
					<p><?php echo $product['vendor'];?></p>
					<h3 class="item_price">$<?php echo $product['price'];?></h3>
				<fieldset class="ui-grid-a unwrap-button">
					<div class="ui-block-a"><input value="Buy this Suggestion" data-theme="a" type="button" onclick="addtocart(<?php echo $product_id;?>)"></div>
				</fieldset>
			</div>
			<?php } } } ?>
		</div>
	</div>
<form name="form1" method="post" action="<?php echo ru;?>process/process_buysuggest.php" data-ajax="false">
<input type="hidden" name="productid" />
<input type="hidden" name="command" />
</form>		
<script type="text/javascript">
function show_caption(proid)
{
	var pid = proid;
	$("#cap_"+pid).slideDown();
	//$("#proname_"+pid).hide();
	$("#img_"+pid).hide();
}

function addtocart(pid){
		document.form1.productid.value=pid;
		document.form1.command.value='add';
		document.form1.submit();
	}
	
function goto_transfer() {
	window.location = "<?php echo ru;?>transfercashstash";
}	
</script>	