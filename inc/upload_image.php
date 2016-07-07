<?php 
$get_uimage = "select user_image from ".tbl_user." where userId = '".$_SESSION['LOGINDATA']['USERID']."'"; 
		$view_image = $db->get_row($get_uimage,ARRAY_A);
		if($view_image > 0)
		{
			$_SESSION['biz_user'] = $view_image;
		}
?>
<div role="main" class="ui-content jqm-content jqm-content-c">
		<h2>User Image</h2>
		<?php if($_SESSION['biz_user_err']['upload_image']){?>
			<div style="color:#FF4242"><?php echo $_SESSION['biz_user_err']['upload_image']?></div>
		<?php }?>
		<form id="uploadimages" enctype="multipart/form-data" method="post" action="<?php echo ru;?>process/process_user.php" data-ajax="false">
		<input name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" type="hidden">
		<input type="hidden" name="oldimage" id="oldimage" value="<?php echo $_SESSION['biz_user']['user_image']?>" />
		<input name="UploadImage" id="UploadImage" value="1" type="hidden">
		<div class="ui-field-contain field">
			<label for="textinput-1">Upload Image</label>
			<input name="image" id="image" value="" type="file">
			<span style="color:#FF0000; font-weight:bold; float:none"><?php echo $_SESSION['biz_user_err']['image'];?></span>
		</div>
		<a onclick="uploadimage()" class="ui-btn ui-btn-c">Upload</a>
		</form>
	</div>
<script language="javascript">
	function uploadimage(){
		document.getElementById("uploadimages").submit()	
	}
</script>	
<?php  unset($_SESSION["biz_user_err"]);?>	