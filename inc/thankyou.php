<?php  unset($_SESSION['register']);?>
<div role="main" class="ui-content jqm-content jqm-content-c">
		<?php
			if($_SESSION["login"]["error"])
			{
			?>
			<h3 class="ift"><?php echo $_SESSION["login"]["error"];?></h3>
			<?php
			} else {
		?>
		<h3 class="ift">Thank you for submitting your registration. </h3>
		<?php } ?>
		<p>Check your email to confirm your registration.</p>
	</div>
<?php  unset($_SESSION["login"]["error"]);?>	