<?php
include("../connect/connect.php");
include("../config/config.php");
//mail("atif_awan@aol.com","HELLO","How Are You!");exit;
function get_images($image)
{
	$img =  preg_replace("/<a[^>]+\>/i", "", $image);
	preg_match("/src=([^>\\']+)/", $img, $result);
	$view_image = array_pop($result);
	return $view_image;
}

$chk_ddetail = $db->get_results("select * from ".tbl_delivery."",ARRAY_A);
foreach($chk_ddetail as $detail)
{
	$delivery_id = $detail['delivery_id'];
	$userId = $detail['userId'];
	$cash_amount = $detail['cash_amount'];
	$recp_first_name = $detail['recp_first_name'];
	$recp_last_name = $detail['recp_last_name'];
	$recp_email = $detail['recp_email'];
	$giv_first_name = $detail['giv_first_name'];
	$giv_last_name = $detail['giv_last_name'];
	$giv_email = $detail['giv_email'];
	$immediately = $detail['immediately'];
	$future = $detail['future'];
	$timestamps = strtotime($detail['date']);
	$notify_date = date('M d, Y', $timestamps);
	$notify_time = $detail['time'];
	$delivery_date = $detail['idate_time'];
	$deliverd_status = $detail['deliverd_status'];
	$fdelivery_date = $detail['fdate_time'];
	$unlock_status = $detail['unlock_status'];
	$timestamp = strtotime($detail['unlock_date']);
	$unblock_date = date('M d, Y', $timestamp);
	$proId = $detail['proid'];
	
	//////////////////////////////////////RECEIVER MAIL CRONJOB/////////////////////////////////////////////////////
	if($recp_email)
	{
	if($immediately == '1')
	{
		$cdate = date('Y-m-d h:i:s');
	    $delivery_datetime = DATE("Y-m-d h:i:s",$delivery_date);
	
		if($deliverd_status == 'pending') {
				
				$chk_email = mysql_query("select email from ".tbl_user." where email = '".$recp_email."'");
				////////////////////////////////////////CHECK USER EXIST OR NOT? IF NOT EXIST////////////////////////////////////////////////////
				if(mysql_num_rows($chk_email) == 0)
				{ 
				$insert = mysql_query("insert into ".tbl_user." set first_name		= '$recp_first_name',
			 									last_name 		= '$recp_first_name',
												email 		= '$recp_email',
												status		= '0',
												available_cash = '500',
												dated		= now()");
				$new_userId = mysql_insert_id();																
				$to = $recp_email;
				$subject=$recp_first_name.", you have received a iftGift from ".$giv_first_name;
				$from = "Info@iftgift.com";
				$headers = 'From: '.$from. "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				$activationlink = ru .'register/'.$new_userId;
				$message = '<div style="background-color:#f6f0fa;text-align:center;width: 630px;border:#c5c4c4 2px solid; margin:0px auto; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#726f6f;">
  <div style="border:#ede2f5 thin solid;">
    <div style="background-image:url(images/jester-email-confirmation.jpg); font-size:15px !important; line-height:0.95"><img src="http://preview.iftgift.com/images/header-email-new.png" alt="iftgift" />
      <div style="padding-left: 13px; padding-top: 15px;">
      <div class="box" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;background: #fff; margin-top: 20px; border: 1px solid #cccccc; width: 602px;padding-top: 15px;padding-bottom: 20px;">
        <p><a href="'.$activationlink.'" target="_blank"><img src="http://preview.iftgift.com/images/btn-email-receiver.png"  /></a></p>
        <img src="http://preview.iftgift.com/images/jester-email-receiver.png"  />
      </div>
      </div>
    </div>
  </div>
  <div>
    <center>
      <p>&nbsp;</p>
      <table style="color:#726f6f;">
      <tr>
      <td><a href="#" style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Home</a></td>
      <td>|</td>
      <td><a href="whatisiftgift.php"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">What is <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Gift?</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Schedule of <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Points</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">FAQ</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Contact</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Terms</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Privacy</a></td>
     </tr>
      </table>
      <p style="color:#726f6f;">Protected by one or more the following US Patents and Patents Pending: 8,280,825 and 8,589,314.<br />
        Copyright � 2011, 2012, 2013 Morris Fritz Friedman � All Rights Reserved � iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';
				//echo '<pre>';print_r($message);
				$mailsent = mail($to,$subject,$message,$headers);	
				//$update_dev = mysql_query("update ".tbl_delivery." set deliverd_status = 'deliverd' where delivery_id = '".$delivery_id."'");									
			}
			////////////////////////////////////////CHECK USER EXIST OR NOT? IF EXIST////////////////////////////////////////////////////
			else {  
				$to = $recp_email;
				$subject="Hooray! Your iftGift to ".$recp_first_name." is on its way";
				$from = "Info@iftgift.com";
				$headers = 'From: '.$from. "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				$message  = '<div style="background-color:#f6f0fa;text-align:center;width: 630px;border:#c5c4c4 2px solid; margin:0px auto; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; ">
  <div style="border:#ede2f5 thin solid;">
    <div style="background-image:url(images/jester-email-confirmation.jpg); font-size:15px !important; line-height:0.95"><img src="http://preview.iftgift.com/images/header-email-new.png" alt="iftgift" />
      <div style="padding-left: 13px; padding-top: 15px;">
      <div style="-moz-border-radius:6px; -webkit-border-radius:6px;border-radius:6px;background: #fff;margin-top: 20px;border: 1px solid #cccccc;width: 602px;padding-top: 15px;padding-bottom: 20px;" >
        <p>Hooray! Your iftGift to <strong>'.$recp_first_name.'</strong> is on its way.



</p> 

        
        <img src="http://preview.iftgift.com/images/jester-giver-confirmation.png"  />
        <p class="orange" style="color: #ff9900;text-align: center;	font-weight: bold;">Delivery details:</p>
        <table style="color: #666666;margin: 0px auto; width: 500px;" >
        <tr>
                <td><strong>Total Amount Sent</strong></td>
              	<td><span class="input_false" id="total" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">$'.$cash_amount.'</span></td>
              </tr>
              <tr>
                <td><strong>Notification email date and time</strong></td>
              	<td><span class="input_false" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">'.$notify_date.' @ '.$notify_time.'</span></td>
              </tr>
              <tr>
                <td><strong>Unlock date and time</strong></td>
              	<td><span class="input_false" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">'.$unblock_date.' @ '.$notify_time.'</span></td>
              </tr>
        </table>
        <p class="orange" style="color: #ff9900;text-align: center;	font-weight: bold;">Your suggestions:</p>
       <div style="clear:both; margin: 10px auto; width: 550px"><table align="center">';
	   $proid = json_decode($proId,true);
			foreach($proid as $pro )
			{
				$product_id = $pro['proid'];
				$get_pro = "select * from ".tbl_product." where proid = '".$product_id."'";
				$view_pro = $db->get_results($get_pro,ARRAY_A);
				foreach($view_pro as $product)
				{
	   $message .='<tr><td valign="top" align="center" width="180"><div class="box_suggest" style="width: 107px;float: left;display: inline-block;margin-right: 10px;margin-top: 10px;margin-bottom: 15px;position: relative;text-align: center;"> 
                <div class="img_suggest" style="background: #FFF;width: 107px;height: 110px;border: 1px solid #ced1d1;position: relative;overflow: hidden;display: table-cell;vertical-align: middle;">';
		$message .='<img src='.get_images($product['image_code']).'  width="97" height="100"/></div>
                <p>'.$product['pro_name'].'</p>
                <p>$'.$product['price'].'</p>
            </div></td>';
			}			
			}	
		$message .=	'</table><div style="clear:both"></div></div>
        <p><a href="http://zs-dev.com/iftgift/" target="_blank"><img src="http://preview.iftgift.com/images/btn-jester-giver-confirmation.png"  /></a></p>
      </div>
      </div>
    </div>
  </div>
  <div>
    <center>
      <p>&nbsp;</p>
      <table style="color:#726f6f;">
      <tr>
      <td><a href="#" style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Home</a></td>
      <td>|</td>
      <td><a href="whatisiftgift.php"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">What is <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Gift?</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Schedule of <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Points</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">FAQ</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Contact</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Terms</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Privacy</a></td>
     </tr>
      </table>
      <p style="color:#726f6f;">Protected by one or more the following US Patents and Patents Pending: 8,280,825<br />
        Copyright � 2011, 2012, 2013 Morris Fritz Friedman � All Rights Reserved � iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';

			
		//echo '<pre>';print_r($message);
		$mailsent = mail($to,$subject,$message,$headers);
		//$update_dev = mysql_query("update ".tbl_delivery." set deliverd_status = 'deliverd' where delivery_id = '".$delivery_id."'");
			}
		}
	}
	else if($future == '2')
	{
		$cdate = date('Y-m-d h:i:s');
	    $delivery_datetime = DATE("Y-m-d h:i:s",$delivery_date);
	
		if($deliverd_status == 'pending' && $cdate > $delivery_datetime) {
		
			$chk_email = mysql_query("select email from ".tbl_user." where email = '".$recp_email."'");
			////////////////////////////////////////CHECK USER EXIST OR NOT? IF NOT EXIST////////////////////////////////////////////////////
			if(mysql_num_rows($chk_email) == 0)
			{
				$insert = mysql_query("insert into ".tbl_user." set first_name		= '$recp_first_name',
			 									last_name 		= '$recp_first_name',
												email 		= '$recp_email',
												status		= '0',
												available_cash = '500',
												dated		= now()");
				$new_userId = mysql_insert_id();																
				$to = $recp_email;
				$subject=$recp_first_name.", you have received a iftGift from ".$giv_first_name;
				$from = "Info@iftgift.com";
				$headers = 'From: '.$from. "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				$activationlink = ru .'register/'.$new_userId;
				$message = '<div style="background-color:#f6f0fa;text-align:center;width: 630px;border:#c5c4c4 2px solid; margin:0px auto; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#726f6f;">
  <div style="border:#ede2f5 thin solid;">
    <div style="background-image:url(images/jester-email-confirmation.jpg); font-size:15px !important; line-height:0.95"><img src="http://preview.iftgift.com/images/header-email-new.png" alt="iftgift" />
      <div style="padding-left: 13px; padding-top: 15px;">
      <div class="box" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;background: #fff; margin-top: 20px; border: 1px solid #cccccc; width: 602px;padding-top: 15px;padding-bottom: 20px;">
        <p><a href="'.$activationlink.'" target="_blank"><img src="http://preview.iftgift.com/images/btn-email-receiver.png"  /></a></p>
        <img src="http://preview.iftgift.com/images/jester-email-receiver.png"  />
      </div>
      </div>
    </div>
  </div>
  <div>
    <center>
      <p>&nbsp;</p>
      <table style="color:#726f6f;">
      <tr>
      <td><a href="#" style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Home</a></td>
      <td>|</td>
      <td><a href="whatisiftgift.php"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">What is <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Gift?</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Schedule of <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Points</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">FAQ</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Contact</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Terms</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Privacy</a></td>
     </tr>
      </table>
      <p style="color:#726f6f;">Protected by one or more the following US Patents and Patents Pending: 8,280,825 and 8,589,314.<br />
        Copyright � 2011, 2012, 2013 Morris Fritz Friedman � All Rights Reserved � iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';
				//echo '<pre>';print_r($message);
				$mailsent = mail($to,$subject,$message,$headers);	
				//$update_devs = mysql_query("update ".tbl_delivery." set deliverd_status = 'deliverd' where delivery_id = '".$delivery_id."'");									
			} 
			////////////////////////////////////////CHECK USER EXIST OR NOT? IF EXIST////////////////////////////////////////////////////
			else 
			{
			 
				$to = $recp_email;
				$subject="Hooray! Your iftGift to ".$recp_first_name." is on its way";
				$from = "Info@iftgift.com";
				$headers = 'From: '.$from. "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				$message  = '<div style="background-color:#f6f0fa;text-align:center;width: 630px;border:#c5c4c4 2px solid; margin:0px auto; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; ">
  <div style="border:#ede2f5 thin solid;">
    <div style="background-image:url(images/jester-email-confirmation.jpg); font-size:15px !important; line-height:0.95"><img src="http://preview.iftgift.com/images/header-email-new.png" alt="iftgift" />
      <div style="padding-left: 13px; padding-top: 15px;">
      <div style="-moz-border-radius:6px; -webkit-border-radius:6px;border-radius:6px;background: #fff;margin-top: 20px;border: 1px solid #cccccc;width: 602px;padding-top: 15px;padding-bottom: 20px;" >
        <p>Hooray! Your iftGift to <strong>'.$recp_first_name.'</strong> is on its way.



</p> 

        
        <img src="http://preview.iftgift.com/images/jester-giver-confirmation.png"  />
        <p class="orange" style="color: #ff9900;text-align: center;	font-weight: bold;">Delivery details:</p>
        <table style="color: #666666;margin: 0px auto; width: 500px;" >
        <tr>
                <td><strong>Total Amount Sent</strong></td>
              	<td><span class="input_false" id="total" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">$'.$cash_amount.'</span></td>
              </tr>
              <tr>
                <td><strong>Notification email date and time</strong></td>
              	<td><span class="input_false" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">'.$notify_date.' @ '.$notify_time.'</span></td>
              </tr>
              <tr>
                <td><strong>Unlock date and time</strong></td>
              	<td><span class="input_false" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">'.$unblock_date.' @ '.$notify_time.'</span></td>
              </tr>
        </table>
        <p class="orange" style="color: #ff9900;text-align: center;	font-weight: bold;">Your suggestions:</p>
       <div style="clear:both; margin: 10px auto; width: 550px"><table align="center">';
	   $proid = json_decode($proId,true);
			foreach($proid as $pro )
			{
				$product_id = $pro['proid'];
				$get_pro = "select * from ".tbl_product." where proid = '".$product_id."'";
				$view_pro = $db->get_results($get_pro,ARRAY_A);
				foreach($view_pro as $product)
				{
	   $message .='<tr><td valign="top" align="center" width="180"><div class="box_suggest" style="width: 107px;float: left;display: inline-block;margin-right: 10px;margin-top: 10px;margin-bottom: 15px;position: relative;text-align: center;"> 
                <div class="img_suggest" style="background: #FFF;width: 107px;height: 110px;border: 1px solid #ced1d1;position: relative;overflow: hidden;display: table-cell;vertical-align: middle;">';
		$message .='<img src='.get_images($product['image_code']).'  width="97" height="100"/></div>
                <p>'.$product['pro_name'].'</p>
                <p>$'.$product['price'].'</p>
            </div></td>';
			}			
			}	
		$message .=	'</table><div style="clear:both"></div></div>
        <p><a href="http://zs-dev.com/iftgift/" target="_blank"><img src="http://preview.iftgift.com/images/btn-jester-giver-confirmation.png"  /></a></p>
      </div>
      </div>
    </div>
  </div>
  <div>
    <center>
      <p>&nbsp;</p>
      <table style="color:#726f6f;">
      <tr>
      <td><a href="#" style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Home</a></td>
      <td>|</td>
      <td><a href="whatisiftgift.php"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">What is <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Gift?</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Schedule of <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Points</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">FAQ</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Contact</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Terms</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Privacy</a></td>
     </tr>
      </table>
      <p style="color:#726f6f;">Protected by one or more the following US Patents and Patents Pending: 8,280,825<br />
        Copyright � 2011, 2012, 2013 Morris Fritz Friedman � All Rights Reserved � iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';
			
		//echo '<pre>';print_r($message);
		$mailsent = mail($to,$subject,$message,$headers);
 		//$update_devs = mysql_query("update ".tbl_delivery." set deliverd_status = 'deliverd' where delivery_id = '".$delivery_id."'");
		  }
		} 
	}
  }
  
  //////////////////////////////////////RECEIVER MAIL CRONJOB/////////////////////////////////////////////////////
  
  //////////////////////////////////////SENDER MAIL CRONJOB/////////////////////////////////////////////////////
   if($giv_email)
  { 
  	if($immediately == '1')
	{
		$cdate = date('Y-m-d h:i:s');
	    $delivery_datetime = DATE("Y-m-d h:i:s",$delivery_date);
	
		if($deliverd_status == 'pending') {
				
				$to = $giv_email;
				$subject="Hooray! Your iftGift to ".$recp_first_name." is on its way";
				$from = "Info@iftgift.com";
				$headers = 'From: '.$from. "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				$message  = '<div style="background-color:#f6f0fa;text-align:center;width: 630px;border:#c5c4c4 2px solid; margin:0px auto; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; ">
  <div style="border:#ede2f5 thin solid;">
    <div style="background-image:url(images/jester-email-confirmation.jpg); font-size:15px !important; line-height:0.95"><img src="http://preview.iftgift.com/images/header-email-new.png" alt="iftgift" />
      <div style="padding-left: 13px; padding-top: 15px;">
      <div style="-moz-border-radius:6px; -webkit-border-radius:6px;border-radius:6px;background: #fff;margin-top: 20px;border: 1px solid #cccccc;width: 602px;padding-top: 15px;padding-bottom: 20px;" >
        <p>Hooray! Your iftGift to <strong>'.$recp_first_name.'</strong> is on its way.



</p> 

        
        <img src="http://preview.iftgift.com/images/jester-giver-confirmation.png"  />
        <p class="orange" style="color: #ff9900;text-align: center;	font-weight: bold;">Delivery details:</p>
        <table style="color: #666666;margin: 0px auto; width: 500px;" >
        <tr>
                <td><strong>Total Amount Sent</strong></td>
              	<td><span class="input_false" id="total" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">$'.$cash_amount.'</span></td>
              </tr>
              <tr>
                <td><strong>Notification email date and time</strong></td>
              	<td><span class="input_false" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">'.$notify_date.' @ '.$notify_time.'</span></td>
              </tr>
              <tr>
                <td><strong>Unlock date and time</strong></td>
              	<td><span class="input_false" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">'.$unblock_date.' @ '.$notify_time.'</span></td>
              </tr>
        </table>
        <p class="orange" style="color: #ff9900;text-align: center;	font-weight: bold;">Your suggestions:</p>
       <div style="clear:both; margin: 10px auto; width: 550px"><table align="center">';
	   $proid = json_decode($proId,true);
			foreach($proid as $pro )
			{
				$product_id = $pro['proid'];
				$get_pro = "select * from ".tbl_product." where proid = '".$product_id."'";
				$view_pro = $db->get_results($get_pro,ARRAY_A);
				foreach($view_pro as $product)
				{
	   $message .='<tr><td valign="top" align="center" width="180"><div class="box_suggest" style="width: 107px;float: left;display: inline-block;margin-right: 10px;margin-top: 10px;margin-bottom: 15px;position: relative;text-align: center;"> 
                <div class="img_suggest" style="background: #FFF;width: 107px;height: 110px;border: 1px solid #ced1d1;position: relative;overflow: hidden;display: table-cell;vertical-align: middle;">';
		$message .='<img src='.get_images($product['image_code']).'  width="97" height="100"/></div>
                <p>'.$product['pro_name'].'</p>
                <p>$'.$product['price'].'</p>
            </div></td>';
			}			
			}	
		$message .=	'</table><div style="clear:both"></div></div>
        <p><a href="http://zs-dev.com/iftgift/" target="_blank"><img src="http://preview.iftgift.com/images/btn-jester-giver-confirmation.png"  /></a></p>
      </div>
      </div>
    </div>
  </div>
  <div>
    <center>
      <p>&nbsp;</p>
      <table style="color:#726f6f;">
      <tr>
      <td><a href="#" style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Home</a></td>
      <td>|</td>
      <td><a href="whatisiftgift.php"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">What is <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Gift?</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Schedule of <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Points</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">FAQ</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Contact</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Terms</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Privacy</a></td>
     </tr>
      </table>
      <p style="color:#726f6f;">Protected by one or more the following US Patents and Patents Pending: 8,280,825<br />
        Copyright � 2011, 2012, 2013 Morris Fritz Friedman � All Rights Reserved � iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';
			
		//echo '<pre>';print_r($message);
		$mailsent = mail($to,$subject,$message,$headers);
		//$givupdate_devs = mysql_query("update ".tbl_delivery." set deliverd_status = 'deliverd' where delivery_id = '".$delivery_id."'");
		}
		
	} 
	else if($future == '2') {
		$cdate = date('Y-m-d h:i:s');
	    $delivery_datetime = DATE("Y-m-d h:i:s",$delivery_date);
	
		if($deliverd_status == 'pending' && $cdate > $delivery_datetime) {
				
				$to = $giv_email;
				$subject="Hooray! Your iftGift to ".$recp_first_name." is on its way";
				$from = "Info@iftgift.com";
				$headers = 'From: '.$from. "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				$message  = '<div style="background-color:#f6f0fa;text-align:center;width: 630px;border:#c5c4c4 2px solid; margin:0px auto; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; ">
  <div style="border:#ede2f5 thin solid;">
    <div style="background-image:url(images/jester-email-confirmation.jpg); font-size:15px !important; line-height:0.95"><img src="http://preview.iftgift.com/images/header-email-new.png" alt="iftgift" />
      <div style="padding-left: 13px; padding-top: 15px;">
      <div style="-moz-border-radius:6px; -webkit-border-radius:6px;border-radius:6px;background: #fff;margin-top: 20px;border: 1px solid #cccccc;width: 602px;padding-top: 15px;padding-bottom: 20px;" >
        <p>Hooray! Your iftGift to <strong>'.$recp_first_name.'</strong> is on its way.



</p> 

        
        <img src="http://preview.iftgift.com/images/jester-giver-confirmation.png"  />

        <p class="orange" style="color: #ff9900;text-align: center;	font-weight: bold;">Delivery details:</p>
        <table style="color: #666666;margin: 0px auto; width: 500px;" >
        <tr>
                <td><strong>Total Amount Sent</strong></td>
              	<td><span class="input_false" id="total" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">$'.$cash_amount.'</span></td>
              </tr>
              <tr>
                <td><strong>Notification email date and time</strong></td>
              	<td><span class="input_false" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">'.$notify_date.' @ '.$notify_time.'</span></td>
              </tr>
              <tr>
                <td><strong>Unlock date and time</strong></td>
              	<td><span class="input_false" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;color: #666666;font-family: Arial,Helvetica,sans-serif; height: 20px;padding: 5px 5px 5px 10px;text-align: left;width: 195px;display: block;">'.$unblock_date.' @ '.$notify_time.'</span></td>
              </tr>
        </table>
        <p class="orange" style="color: #ff9900;text-align: center;	font-weight: bold;">Your suggestions:</p>
       <div style="clear:both; margin: 10px auto; width: 550px"><table align="center">';
	   $proid = json_decode($proId,true);
			foreach($proid as $pro )
			{
				$product_id = $pro['proid'];
				$get_pro = "select * from ".tbl_product." where proid = '".$product_id."'";
				$view_pro = $db->get_results($get_pro,ARRAY_A);
				foreach($view_pro as $product)
				{
	   $message .='<tr><td valign="top" align="center" width="180"><div class="box_suggest" style="width: 107px;float: left;display: inline-block;margin-right: 10px;margin-top: 10px;margin-bottom: 15px;position: relative;text-align: center;"> 
                <div class="img_suggest" style="background: #FFF;width: 107px;height: 110px;border: 1px solid #ced1d1;position: relative;overflow: hidden;display: table-cell;vertical-align: middle;">';
		$message .='<img src='.get_images($product['image_code']).'  width="97" height="100"/></div>
                <p>'.$product['pro_name'].'</p>
                <p>$'.$product['price'].'</p>
            </div></td>';
			}			
			}	
		$message .=	'</table><div style="clear:both"></div></div>
        <p><a href="http://zs-dev.com/iftgift/" target="_blank"><img src="http://preview.iftgift.com/images/btn-jester-giver-confirmation.png"  /></a></p>
      </div>
      </div>
    </div>
  </div>
  <div>
    <center>
      <p>&nbsp;</p>
      <table style="color:#726f6f;">
      <tr>
      <td><a href="#" style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Home</a></td>
      <td>|</td>
      <td><a href="whatisiftgift.php"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">What is <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Gift?</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Schedule of <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Points</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">FAQ</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Contact</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Terms</a></td>
      <td>|</td>
      <td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Privacy</a></td>
     </tr>
      </table>
      <p style="color:#726f6f;">Protected by one or more the following US Patents and Patents Pending: 8,280,825<br />
        Copyright � 2011, 2012, 2013 Morris Fritz Friedman � All Rights Reserved � iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';
			
		//echo '<pre>';print_r($message);
		$mailsent = mail($to,$subject,$message,$headers);
		//$givupdate_dev = mysql_query("update ".tbl_delivery." set deliverd_status = 'deliverd' where delivery_id = '".$delivery_id."'");
		}
	}
  } 
  
  if($deliverd_status == 'pending') {
  $update_devs = mysql_query("update ".tbl_delivery." set deliverd_status = 'deliverd' where delivery_id = '".$delivery_id."'");
  }
   //////////////////////////////////////SENDER MAIL CRONJOB/////////////////////////////////////////////////////
   
   
   
    //////////////////////////////////////UNLOCK GIFT CRONJOB/////////////////////////////////////////////////////
  if($delivery_id) {
	
		$cdate = date('Y-m-d h:i:s');
	    $fdelivery_datetime = DATE("Y-m-d h:i:s",$fdelivery_date);
	
		if($unlock_status == '1' && $cdate > $fdelivery_datetime) {
		
			$update_iftgift = "update ".tbl_delivery." set unlock_status = '0', open_status = '2' where delivery_id = '".$delivery_id."'";
			mysql_query($update_iftgift);
			$chk_email = mysql_query("select userId,email,available_cash from ".tbl_user." where email = '".$recp_email."'");
				if(mysql_num_rows($chk_email) > 0)
				{ 
					$user_info = mysql_fetch_array($chk_email);
					$userId = $user_info['userId'];
					$available_cash = $user_info['available_cash'];
					$new_available_cash = $available_cash + $cash_amount;
					$update_cashstash = mysql_query("update ".tbl_user." set available_cash = '".$new_available_cash."' where userId = '".$userId."'");
				}
		}
  }
  //////////////////////////////////////UNLOCK GIFT CRONJOB/////////////////////////////////////////////////////
}

	
?>