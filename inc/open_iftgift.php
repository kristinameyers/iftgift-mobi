<?php
$delivery_id = $_GET['s'];
?>
<style>.ift_block h4.recip{width:98%; text-align:center; margin-left:1%}</style>
	<div role="main" class="ui-content unwrap-content">
		<div class="ui-grid-d unlock-time">
			<div class="ui-block-a"><div class="ui-bar ui-bar-a">O</div></div>
			<div class="ui-block-b"><div class="ui-bar ui-bar-a">P</div></div>
			<div class="ui-block-c"><div class="ui-bar ui-bar-a">E</div></div>
			<div class="ui-block-d"><div class="ui-bar ui-bar-a">N</div></div>
			<div class="ui-block-e"><div class="ui-bar ui-bar-a">!</div></div>
		</div><!-- /grid-c -->
	</div>
	<div role="main" class="ui-content unwrap-content">
		<div class="ui-field-contain ui-field-contain-b">
			<label>Party Mode!</label>
			<select name="flip-5" id="flip-5" data-role="slider" data-mini="true">
				<option value="off">Off</option>
				<option value="on">On</option>
			</select>
		</div>
		<p class="dip_gift">Display your IftGifts, but keep cash amounts private</p>
	</div>
	<div role="main" class="ui-content jqm-content jqm-content-c">
		<img src="<?php echo ru_resource;?>images/safe_icon.jpg" />
		<div class="ui-field-contain ui-field-contain-b ui-field-2">
			<fieldset data-role="controlgroup" data-mini="true">
				<input name="radio-choice-v-5" id="radio-choice-v-5a" value="on" onclick="go_unwrap('<?php echo $delivery_id; ?>');" type="radio">
					<label for="radio-choice-v-5a">Unwrap Your iftGift</label>
			</fieldset>
		</div>
		<script type="text/javascript">
		function go_unwrap(Id)
		{
			var dId = Id;
			$.ajax({
			url: '<?php echo ru;?>process/process_unwrap.php?pId='+dId,
			type: 'get', 
			success: function(output) {
			if(output == 'Success')
			{
				window.location = "<?php echo ru?>unwraped/"+dId;
			}
			}
			});
		}
		</script>
		<div class="ui-grid-a contains">
			<div class="ui-block-a"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_a.jpg" alt="Box A Icon" /></a></div></div>
			<div class="ui-block-b"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_b.jpg" alt="Box b Icon" /></a></div></div>
			<div class="ui-block-a"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_c.jpg" alt="Box c Icon" /></a></div></div>
			<div class="ui-block-b"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_d.jpg" alt="Box D Icon" /></a></div></div>
			<div class="ui-block-a"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_e.jpg" alt="Box E Icon" /></a></div></div>
			<div class="ui-block-b"><div class="ui-bar ui-bar-a"><a href="#"><img src="<?php echo ru_resource;?>images/box_f.jpg" alt="Box F Icon" /></a></div></div>
		</div><!-- /grid-a -->
	</div>