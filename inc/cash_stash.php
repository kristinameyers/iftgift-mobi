 	<div role="main" class="ui-content jqm-content jqm-content-c ift_block">
		<h4 class="recip delivery">Cash Stash</h4>
	</div><!-- /content -->
	<div role="main" class="ui-content jqm-content jqm-content-c">
		<div class="ui-field-contain">
			
				<?php
				$get_blance = "select available_cash from ".tbl_user." where userid = '".$_SESSION['LOGINDATA']['USERID']."'";
				$view_blance = $db->get_row($get_blance,ARRAY_A);
				?>
				<label><span style="width:100%"><strong>Remaining Balance : $<?php echo $view_blance['available_cash'];?></strong> </span></label>
			
		</div>
		
	</div><!-- /content -->