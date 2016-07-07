<?php
include('../connect/connect.php');
include('../config/config.php');
//get the posted values

$posted_username = addslashes($_POST['username']);
$posted_password = md5(addslashes($_POST['password']));

$res_login = mysql_query("SELECT email,userId,password,status,first_name,last_name FROM ".tbl_user." WHERE email = '" .$posted_username."' and password = '".$posted_password."'");
	if(mysql_num_rows($res_login) == 1)	{
		$row_login = mysql_fetch_array($res_login);
		if($row_login['status'] == '1'){
			$_SESSION['LOGINDATA']['ISLOGIN'] = 'yes';
			$_SESSION['LOGINDATA']['USERID'] = $row_login['userId'];
			$_SESSION['LOGINDATA']['EMAIL'] = $row_login['email'];
			$_SESSION['LOGINDATA']['NAME'] = $row_login['first_name'];
			$_SESSION['LOGINDATA']['LNAME'] = $row_login['last_name'];
			$_SESSION['LOGINDATA']['username'] = $row_login['user_name'];
			
			header("location:".ru."dashboard");
		} 
		elseif($row_login['status'] == '0')
		{
			$_SESSION["login"]["error"] = 'Please activate your account before login';
			header("location:".ru.'thankyou/');exit;
		}
		else
		{
			$_SESSION["login"]["error"] = 'Your account has been blocked, Please contact admin';
			header("location:".ru."login/");exit;
		}
	}
	else{
		$_SESSION["login"]["error"] = 'Invalid login information';
		header("location:".ru."login/");exit;
	}
?>