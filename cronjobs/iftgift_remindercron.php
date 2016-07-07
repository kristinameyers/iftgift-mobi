<?php
include("../connect/connect.php");
include("../config/config.php");
//mail("atif_awan@aol.com","HELLO","How Are You!");exit;

$chk_ddetail = $db->get_results("select * from ".tbl_reminder."",ARRAY_A);
foreach($chk_ddetail as $detail)
{
	$reminder_id = $detail['reminder_id'];
	$event_name = $detail['event_name'];
	$celebrant = $detail['celebrant'];
	$dated = $detail['dated'];
	$one_time = $detail['one_time'];
	$remind_me = $detail['remind_me'];
	$month = $detail['month'];
	$weeks = $detail['weeks'];
	$week = $detail['week'];
	$days = $detail['days'];
	$day = $detail['day'];
	$userId = $detail['userId'];
	
    $get_user = mysql_fetch_array(mysql_query("select email from ".tbl_user." where userid = '".$userId."'"));
	$email = $get_user['email'];
    if($month == '1 Month')
	{
		$pDate = strtotime("$dated - 1 month");
		$dates = date('Y-m-d',$pDate);
		$cdates = date('Y-m-d');
		if($cdates == $dates) {
			$to = $email;
			$subject="Your Personal Reminder";
			$from = "Info@iftgift.com";
			$headers = 'From: '.$from. "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message = 'Celebrant :'.$celebrant.'<br />';
			$message .= 'Holiday :'.$event_name.'<br />';
			$message .= 'Date :'.$dated.'\n';
			$mailsent = mail($to,$subject,$message,$headers);	
		}
	}
	
	if($weeks == '2 Week')
	{
		$pDate = strtotime("$dated - 2 week");
		$dates = date('Y-m-d',$pDate);
		$cdates = date('Y-m-d');
		if($cdates == $dates) {
			$to = $email;
			$subject="you Personal Reminder";
			$from = "Info@iftgift.com";
			$headers = 'From: '.$from. "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message = 'Celebrant :'.$celebrant.'<br />';
			$message .= 'Holiday :'.$event_name.'<br />';
			$message .= 'Date :'.$dated.'<br />';
			$mailsent = mail($to,$subject,$message,$headers);	
		}
	}
	
	if($week == '1 Week')
	{
		$pDate = strtotime("$dated - 1 week");
		$dates = date('Y-m-d',$pDate);
		$cdates = date('Y-m-d');
		if($cdates == $dates) {
			$to = $email;
			$subject="you Personal Reminder";
			$from = "Info@iftgift.com";
			$headers = 'From: '.$from. "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message = 'Celebrant :'.$celebrant.'<br />';
			$message .= 'Holiday :'.$event_name.'<br />';
			$message .= 'Date :'.$dated.'<br />';
			$mailsent = mail($to,$subject,$message,$headers);	
		} 
	}
	
	if($days == '3 Days')
	{
		$pDate = strtotime("$dated - 3 days");
		$dates = date('Y-m-d',$pDate);
		$cdates = date('Y-m-d');
		if($cdates == $dates) {
			$to = $email;
			$subject="you Personal Reminder";
			$from = "Info@iftgift.com";
			$headers = 'From: '.$from. "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message = 'Celebrant :'.$celebrant.'<br />';
			$message .= 'Holiday :'.$event_name.'<br />';
			$message .= 'Date :'.$dated.'<br />';
			$mailsent = mail($to,$subject,$message,$headers);	
		} 
	}
	
	if($day == '1 Day')
	{
		$pDate = strtotime("$dated - 1 days");
		$dates = date('Y-m-d',$pDate);
		$cdates = date('Y-m-d');
		if($cdates == $dates) {
			$to = $email;
			$subject="you Personal Reminder";
			$from = "Info@iftgift.com";
			$headers = 'From: '.$from. "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message = 'Celebrant :'.$celebrant.'<br />';
			$message .= 'Holiday :'.$event_name.'<br />';
			$message .= 'Date :'.$dated.'<br />';
			$mailsent = mail($to,$subject,$message,$headers);	
		} 
	}

 }

 
  
 
	
?>