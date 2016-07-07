<?php
include('../connect/connect.php');
include('../config/config.php');
//get the posted values

$action = $_REQUEST["action"];
switch($action){
	case "fblogin":
	include('../facebook/facebook/facebook.php');
	$appid 		= "338285303000069";
	$appsecret  = "53d15c2a4bd71fac6974c6b01f726034";
	$facebook   = new Facebook(array(
  		'appId' => $appid,
  		'secret' => $appsecret,
  		'cookie' => TRUE,
	));
	$fbuser = $facebook->getUser();
	if ($fbuser) {
		try {
		    $user_profile = $facebook->api('/me');
			//echo '<pre>';print_r($user_profile);exit;
		}
		catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}
		$user_fbid	= $fbuser;
		$user_email = $user_profile["email"];
		$user_fnmae = $user_profile["first_name"];
		$user_lnmae = $user_profile["last_name"];
		$user_image = "https://graph.facebook.com/".$user_fbid."/picture?type=small";
		$check_select = mysql_query("SELECT * FROM ".tbl_user." WHERE email = '$user_email'");
		if(mysql_num_rows($check_select) == 1){
			$row_login = mysql_fetch_array($check_select);
			if($row_login['status'] == '1'){
				$_SESSION['LOGINDATA']['ISLOGIN'] = 'yes';
				$_SESSION['LOGINDATA']['USERID'] = $row_login['userId'];
				$_SESSION['LOGINDATA']['EMAIL'] = $row_login['email'];
				$_SESSION['LOGINDATA']['NAME'] = $row_login['first_name'];
				$_SESSION['LOGINDATA']['LNAME'] = $row_login['last_name'];
				$_SESSION['LOGINDATA']['username'] = $row_login['user_name'];
			
				header("location:".ru."dashboard");
			} 
		} else {
			$inst_user = mysql_query("INSERT INTO ".tbl_user." (first_name, last_name, email, status, available_cash, user_image, dated) VALUES ('$user_fnmae', '$user_lnmae', '$user_email', '1', '500', '$user_image', now())");
			$check_selects = mysql_query("SELECT * FROM ".tbl_user." WHERE email = '$user_email'");
			$row_logins = mysql_fetch_array($check_selects);
			if($row_logins['status'] == '1'){
				$_SESSION['LOGINDATA']['ISLOGIN'] = 'yes';
				$_SESSION['LOGINDATA']['USERID'] = $row_logins['userId'];
				$_SESSION['LOGINDATA']['EMAIL'] = $row_logins['email'];
				$_SESSION['LOGINDATA']['NAME'] = $row_logins['first_name'];
				$_SESSION['LOGINDATA']['LNAME'] = $row_logins['last_name'];
				//$_SESSION['LOGINDATA']['username'] = $row_login['user_name'];
			
				header("location:".ru."dashboard");
			} 
		}
	}
	break;
}
?>