<?php 
require_once("../connect/connect.php");
require_once("../config/config.php");
require_once ('../common/function.php');

//unset($_SESSION['biz_giv_err']);
//unset($_SESSION['biz_giv']);
//echo "<pre>";
//print_r($_POST); exit;


//////////////////////////////////////GIVER INFO./////////////////////////////////////////////////
if (isset($_POST['save_dev'])){ 

     	//unset($_SESSION['biz_giv_err']);
	    unset($_SESSION['biz_givs']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_givs'][$k]=$v;
	}
  	
  $userId = $_SESSION['LOGINDATA']['USERID'];
  $date = strtotime(date('Y-m-d'));
  $current_date = date('d-m-Y',$date);
  $current_time = date("h:i A",time());
  $notification = '1';
  $immediately = $notification;
  $unlock = '2';
  $uimmediately = '1';	
  $utime =  convert_unixdatetime($current_date,$current_time);
			 // $chkQry = mysql_query("select * from ".tbl_delivery." where delivery_id = '".$delivery_id."'");
			  //if(mysql_num_rows($chkQry) == 0) {
			  $insQry ="insert into ".tbl_delivery." set cash_amount = '$cash_amount',
			  									occassionid		= '$occassionid',
			  									giv_first_name		= '$giv_first_name',
			 									giv_last_name 		= '$giv_last_name',
												giv_email 		= '$giv_email',
												recp_first_name		= '$recp_first_name',
			 									recp_last_name 		= '$recp_last_name',
												recp_email 		= '$recp_email',
												notification		= '$notification',
			 									immediately 		= '$immediately',
												date 		= '$current_date',
												time		= '$current_time',
												idate_time  = '$utime',
												unlocks		= '$unlock',
			 									unlock_immediately 		= '$uimmediately',
												unlock_date 		= '$current_date',
												unlock_time		= '$current_time',
												fdate_time		= '$utime',
												proid			= '$proid',
												deliverd_status = 'pending',
												unlock_status	= '1',
												userId			= '$userId',
												dated			= now()";
									
			 $ExQry = mysql_query($insQry)or die (mysql_error());
			 $_SESSION['delivery_id']['New'] = mysql_insert_id();
			 if($ExQry) {
			 echo "Success";
			 }
			 //} else {
				//$updQry ="update ".tbl_delivery." set cash_amount = '$cash_amounts',
					//								occassionid		= '$occassionid',
						//							giv_first_name		= '$first_name',
							//						giv_last_name 		= '$last_name',
								//					giv_email 		= '$email',
									//				userId			= '$userId'
										//			where delivery_id = '$delivery_id'";
				// mysql_query($updQry)or die (mysql_error());									
			 //}
		//unset($_SESSION['biz_giv_err']);
		unset($_SESSION['biz_givs']);
		//$_SESSION['biz_giv_err']['Giver_edit'] = 'Giver Info successfully updated!';
 
  
}



?>