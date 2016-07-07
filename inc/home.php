<div role="main" class="ui-content jqm-content">
		<h3>Send up to <span>six suggestions</span> of gifts they might choose...</h3>
		<h4>So it’s more <span>personal</span> than a <span>gift card...</span></h4>
		<h3>...while you actually <span>transfer cash</span> they can always use.</h3>
		<h4>So it’s more <span>versatile</span> than <span>any gift!</span></h4>
		<a href="<?php echo ru;?>register" data-ajax="false" class="ui-btn">New? Get Started</a>
		<a href="<?php echo ru;?>login" data-ajax="false" class="ui-btn ui-btn-b">Returning? Sign In</a>
	</div><!-- /content -->
	<div role="main" class="ui-content jqm-content jqm-content-b">
		<div id="video_ipad" style="display:none">
		<iframe id="player" type="text/html" width="575" height="402" src="http://www.youtube.com/embed/VS47gCb7NpQ?rel=0" frameborder="0"></iframe>
		<?php /*?><embed width="575" height="402" src="http://www.youtube.com/embed/VS47gCb7NpQ?rel=0" type="application/x-shockwave-flash"><?php */?>
		</div>
		<div id="video_iphone" style="display:none">
		<iframe id="player" type="text/html" width="280" height="196" src="http://www.youtube.com/embed/VS47gCb7NpQ?rel=0" frameborder="0"></iframe>
		<?php /*?><embed width="280" height="196" src="http://www.youtube.com/embed/VS47gCb7NpQ?rel=0" type="application/x-shockwave-flash"><?php */?>
		</div>
		<div class="ipad">
			<img src="<?php echo ru_resource?>images/video_img_ipad_old.jpg" alt="Video Image Ipad"/>
			<div class="play">
				<img src="<?php echo ru_resource?>images/ipad_video_button.jpg" style="cursor:pointer" onclick="video_ipad()" id="video_img"/>
			</div>
		</div>
		<div class="iphone">
			<img src="<?php echo ru_resource?>images/video_img_iphone_old.jpg" alt="Video Image Ipad"/>
			<div class="play">
				<img src="<?php echo ru_resource?>images/iphone_video_button.jpg" onclick="play_iphone()" id="video_img2" style="cursor:pointer"/>
			</div>
		</div>
		<?php /*?><img src="<?php echo ru_resource?>images/video_img_iphone.jpg" alt="Video Image Iphone" class="video_iphone" onclick="play_iphone()" id="video_img2" style="cursor:pointer" /><?php */?>
		<h3>It’s <span>personal shopper</span> meets <span>gift card</span> meets <span>bank/e-wallet.</span></h3>
		<a href="<?php echo ru?>learn_more" data-ajax="false" class="ui-btn">What is ift?</a>
	</div><!-- /content -->
	
	
<script type="text/javascript">
function video_ipad()
{
	$("#video_ipad").show();
	$(".ipad").hide();
	$("#player").play();
}

function play_iphone()
{
	$("#video_iphone").show();
	$(".iphone").hide();
	$("#player").play();
}
</script>	