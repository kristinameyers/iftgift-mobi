<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
include ("../common/upload.php");

unset($_SESSION['biz_user_err']);
unset($_SESSION['biz_user']);
//echo "<pre>";
//print_r($_POST); exit;

if (isset($_POST['UploadImage'])){ 

     	unset($_SESSION['biz_user_err']);
	    unset($_SESSION['biz_user']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_user'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name validation////////	
	$userId = $userId;
	if($_FILES['image']['name']==''){
		$_SESSION['biz_user_err']['image'] = 'Select an image for upload';
		$flgs = true;
	
	}
	
  if($flgs)
  {
	
		header('location:'.ru.'upload_image'); exit;
		
  }else{

		if ( isset($_FILES['image']['tmp_name'])) 
		{ 
			@mkdir ('../media/user_image/'.$userId ,0777) ;
			@mkdir ('../media/user_image/'.$userId.'/thumb/', 0777);
		
			$upload_dir = '../media/user_image/'.$userId.'/';
			$thumb_folder = '../media/user_image/'.$userId.'/thumb/';
			
			$logo ='';			
			@chmod($upload_dir,0777);	
			@chmod($thumb_folder,0777);	
			$ext= array ('gif','jpg','jpeg','png','bmp');			
			$companylogo = "image"; 
		
			$file_type=$_FILES[$companylogo]['type'];   			
			if(!empty($_FILES[$companylogo]['name']))
			{
				$upload = new upload($companylogo, $upload_dir, '777', $ext);
				//echo '<pre>';print_r($upload);exit;
					$logo=$upload->filename;					
					require_once('../phpThumb/phpthumb.class.php');
					$phpThumb = new phpThumb();
					$thumbnail_width = 68;
					$phpThumb->setSourceFilename($upload_dir.$logo);
					$output_filename = $thumb_folder.$logo;
					
					// set parameters (see "URL Parameters" in phpthumb.readme.txt)
					$phpThumb->setParameter('w', $thumbnail_width);
					
					// generate & output thumbnail
					if ($phpThumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!
					if ($phpThumb->RenderToFile($output_filename)) {
						// do something on success
						//echo 'Successfully rendered to "'.$output_filename.'"';
					} 
				} 
				@unlink ($upload_dir.$oldimage);
				@unlink ($thumb_folder.$oldimage);

			}
		}
		
		mysql_query("update ".tbl_user." set user_image='$logo' where userId = '$userId'");
		
		$check_points = "select * from ".tbl_userpoints." where userId = '".$userId."'";
		$view_points = $db->get_row($check_points,ARRAY_A);
		$points = $view_points['points'];
		$new_points = $points + 25;
		if($view_points) {
			$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$userId."'");
		} else {
			$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '25',userId = '".$userId."'");
		}	
		unset($_SESSION['biz_user_err']);
		unset($_SESSION['biz_user']);
		$_SESSION['biz_user_err']['upload_image'] = 'Image Upload successfully!';
		header('location:'.ru.'upload_image'); exit;
  }
  
}


?>