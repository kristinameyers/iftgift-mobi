<?php
require_once("../connect/connect.php");
require_once("../common/function.php");
include('../common/pluggable.php');


if($_POST['getpassword']){
	$email =  addslashes($_POST['email']);
	$res_password = mysql_query("select * from wp_users where user_email = '".$email."' ");
	
if(mysql_num_rows($res_password) > 0){
$row_user = mysql_fetch_array($res_password);
$userID = $row_user['ID'];
$activation = md5(uniqid(rand(), true));
$ins_key = mysql_query("UPDATE wp_users SET user_activation_key = '".$activation."' WHERE ID = '".$userID."'");
$get_key = mysql_fetch_array(mysql_query("SELECT user_activation_key from wp_users WHERE ID = '".$userID."'"));
$ack_key = $get_key['user_activation_key'];
$username = $row_user['user_nicename'];
$to = $email;
$subject="[Muvao] Password Reset";
$from = "Muvao [wordpress@muvao.com]";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$from. "\r\n";
$headers .= "Content-type: text/html\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "X-Priority: 1\r\n";
			
$message = "Someone requested that the password be reset for the following account:"."<br /><br />";
$message .= "<a href='".ru."'>http://www.muvao.com/</a>"."<br /><br />";
$message .= "Username:".$username."<br /><br />";
$message .= "If this was a mistake, just ignore this email and nothing will happen."."<br /><br />";
$message .= "To reset your password, visit the following address:".'<br /><br />';
$activationlink = ru .'reset-password/'.$ack_key.'/'.$username;
$message .= "<a href='".$activationlink."'>".$activationlink."</a>";
$mailsent = mail($to,$subject,$message,$headers);
$_SESSION["passwordrest"]["msg"] = 'Check your e-mail for the confirmation link.';
}
else
{
$_SESSION["passwordrest"]["msg"] = 'There is no user registered with that email address.';
}
header("location:".ru."lost_password");exit;
}


if($_POST['reset_pass']){
	$userId = $_POST['userId'];
	$ack_key = $_POST['ack_key'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
	
	$flag = false;
	if(verifypassword($password)){
			$_SESSION['error']['password'] = 'The password syntax must contain minimum 6 characters in lowercase, uppercase, numeric or symbols like ! " ? $ % ^ &.';
		$flgs = true;
	}
	
	if($password != $cpassword)
	{
		$_SESSION['error']['pass'] = $_ERR['register']['passc'];
		$flag = true;
	}
	
	if($flag){
			header('location:'.ru.'reset-password/'.$ack_key.'/'.$username); 
			exit;
	} else {
	
		$user_pass = wp_hash_password($_POST['password']);
		$upd_pass = "UPDATE wp_users SET user_pass = '".$user_pass."' WHERE ID = '".$userId."'";
		mysql_query($upd_pass);
		header('location:'.ru.'login'); 
			exit;
		
	}
}
?>
