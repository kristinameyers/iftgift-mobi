<?php
include('../connect/connect.php');
include('../config/config.php');
//mail("atif@zamsol.com","HELLO","How Are You!");exit;
$uri = $_SERVER['HTTP_REFERER'];
if(isset($_POST['ReleaseRequest'])) { 
	
	$giv_name = $_POST['giv_name'];
	$recp_name = $_POST['recp_name'];
	$unlock_date = $_POST['unlock_date'];
	$unlock_time = $_POST['unlock_time'];
	$msg = mysql_real_escape_string(stripslashes(trim($_POST['message'])));
	
	$get_Uimg = $db->get_row("select user_image,userId from ".tbl_user." where email = '".$_POST['recp_email']."'",ARRAY_A);
	if($get_Uimg['user_image']) {
		$user_image = ru."media/user_image/".$get_Uimg['userId'].'/thumb/'.$get_Uimg['user_image'];
	} else {
		$user_image = ru_resource."images/list_img.jpg";
	}
	$releaselink = ru .'release_request/'.$get_Uimg['userId'].'/'.$_POST['delivery_id'];
	$to = $_POST['giv_email'];
	$subject = mysql_real_escape_string(stripslashes(trim($_POST['subject'])));
	$from = "Info@iftgift.com";
	$headers  = 'From: '.$from. "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$message = '<div style="text-align:center;width:630px;border:#c5c4c4 2px solid;  margin:0 auto;background-color:#f6f0fa; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#494848;">
  <div>
    <div style="font-size:15px !important; line-height:0.95">
    <img src="'.ru_resource.'images/header-email-new.png" alt="iftgift" />
      <div style="padding-left: 13px; padding-top: 15px;">
      <div class="box" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;background: #fff;margin-top: 20px;border: 1px solid #cccccc;width: 602px;padding-top: 15px;padding-bottom: 20px;" >
      <div>
        <table width="100%" border="0">
          <tr>
            <td><div style="float:left;">
                <div style="font-size:16px; font-weight:normal; padding-left:10px; padding-bottom:10px; text-align:left">Hi <strong>'.$giv_name.'</strong>,</div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px; text-align:left">You sent <strong>'.$recp_name.'</strong> an iftGift,</div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px; text-align:left">which unlocks: <strong>'.$unlock_date.'</strong>. at <strong>'.$unlock_time.'.</strong></div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px; text-align:left; padding-top: 20px">They sent you this Release Request:</div>
              </div></td>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>
      </div>
      <center>
        <div class="box1" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;width: 580px; margin: 20px auto;color: #494848; background:#fff; border: 1px solid #cccccc;">
          <table width="100%">
            <tr>
              <td width="100"><img src="'.$user_image.'" /></td>
              <td style="font-style:italic; padding: 10px; text-align: justify">'.$msg.'</td>
            </tr>
          </table>
        </div>
        <br />
        <a href="'.$releaselink.'" target="_blank"><img src="'.ru_resource.'images/btn-email-release.png" border="0" /></a>
      </center>
	  <br /><br /><br /><br /><br /><br /><br /><br />
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
        Copyright © 2011, 2012, 2013 Morris Fritz Friedman · All Rights Reserved · iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';
	//echo $message;exit;
	$mailsent = mail($to,$subject,$message,$headers);
	if($mailsent) {
		$query = mysql_query("update ".tbl_delivery." set release_request = '1' where delivery_id = '".$_POST['delivery_id']."'");
		$get_givId = $db->get_row("select userId from ".tbl_user." where email = '".$_POST['giv_email']."'",ARRAY_A);
		request_release_points($get_Uimg['userId'],$get_givId['userId']);
	}
	if($uri == ru.'unwrap') {
	?>
	<script type="text/javascript">
	window.parent.location = '<?php echo ru?>unwrap';
	</script>
<?php	
	} else if($uri == ru.'outbox') {
?>
	<script type="text/javascript">
	window.parent.location = '<?php echo ru?>outbox';
	</script>
<?php	
	}
}

/******************************************Release Response Open Immediately**************************************************/
if(isset($_POST['open_immediately'])) { 
	
	$giv_name = $_POST['giv_name'];
	$recp_name = $_POST['recp_name'];
	$msg = mysql_real_escape_string(stripslashes(trim($_POST['messages'])));
	$dated = date('d-m-Y');
	$t=time();
	$time = (date("h:i A",$t));
	
	$get_Uimg = $db->get_row("select user_image,userId from ".tbl_user." where email = '".$_POST['giv_email']."'",ARRAY_A);
	if($get_Uimg['user_image']) {
		$user_image = ru."media/user_image/".$get_Uimg['userId'].'/thumb/'.$get_Uimg['user_image'];
	} else {
		$user_image = ru_resource."images/list_img.jpg";
	}
	$releaselink = ru .'locked/'.$_POST['delivery_id'];
	$to = $_POST['recp_email'];
	$subject = mysql_real_escape_string(stripslashes(trim($_POST['subject'])));
	$from = "Info@iftgift.com";
	$headers  = 'From: '.$from. "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$message ='<div style="text-align:center;width:630px;border:#c5c4c4 2px solid;  margin:0 auto;background-color:#f6f0fa; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#000;">

  <div style="width:100%;font-size:15px !important; margin: 0px auto; line-height:0.95;">
    <img src="'.ru_resource.'images/header-email-new.png" alt="iftgift" />
      <div class="box1" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;width: 580px; margin-top: 20px auto;padding-left: 13px; padding-top: 15px;">
      <div class="box" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;background: #fff; margin-top: 20px; border: 1px solid #cccccc; width: 602px;padding-top: 15px;padding-bottom: 20px;" >
        <table width="100%" border="0">
          <tr>
            <td><div style="float:left;">
                <div style="font-size:16px; font-weight:normal; padding-left:10px; padding-bottom:10px; text-align:left">Hi  <strong>'.$recp_name.'</strong>,</div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px; text-align:left">Here’s how <strong>'.$giv_name.'</strong> responded to your Release Request:</div>
                <br />
              </div></td>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>
    <center>
        <br />
        <img src="'.ru_resource.'images/text_email_released.png" border="0" />
        <div style="margin: 20px 15px 15px 15px;color: #494848; background:#fff; border: 1px solid #cccccc;">
          <table width="100%">
            <tr>
              <td width="100"><img src="'.$user_image.'" /></td>
              <td style="font-style:italic; padding: 10px; text-align: justify">'.$msg.'</td>
            </tr>
          </table>
        </div>
            <a href="'.$releaselink.'"><img src="'.ru_resource.'images/btn-email-revised.png" border="0" /></a>
			<br />

        </center>
  
  <div style="text-align:center">
    <img src="http://preview.iftgift.com/images/jester-emails-revised.png" border="0" /><br />
    <br />
    <br />
    <br />
    <br />
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
        Copyright © 2011, 2012, 2013 Morris Fritz Friedman · All Rights Reserved · iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';
	//echo $message;exit;
	$mailsent = mail($to,$subject,$message,$headers);
	if($mailsent) {
		$query = mysql_query("update ".tbl_delivery." set unlock_date = '".$dated."', unlock_time = '".$time."', deliverd_status = 'deliverd', unlock_status = '0', open_status = '2', release_request_respond = 'open_immediately' where delivery_id = '".$_POST['delivery_id']."'");
	}
	?>
	<script type="text/javascript">
	window.parent.location = '<?php echo ru?>outbox';
	</script>
<?php	
}

/******************************************Release Response Open Immediately**************************************************/


/******************************************Release Response Revised**************************************************/
if(isset($_POST['change_release'])) { 
	
	$giv_name = $_POST['giv_name'];
	$recp_name = $_POST['recp_name'];
	$timestamps = strtotime($_POST['dated']);
	$dated = date('d-m-Y', $timestamps);
	$time = $_POST['time'];
	
	$msg = mysql_real_escape_string(stripslashes(trim($_POST['message'])));
	
	$get_Uimg = $db->get_row("select user_image,userId from ".tbl_user." where email = '".$_POST['giv_email']."'",ARRAY_A);
	if($get_Uimg['user_image']) {
		$user_image = ru."media/user_image/".$get_Uimg['userId'].'/thumb/'.$get_Uimg['user_image'];
	} else {
		$user_image = ru_resource."images/list_img.jpg";
	}
	$releaselink = ru .'locked/'.$_POST['delivery_id'];
	$to = $_POST['recp_email'];
	$subject = mysql_real_escape_string(stripslashes(trim($_POST['subject'])));
	$from = "Info@iftgift.com";
	$headers  = 'From: '.$from. "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$message ='<div style="text-align:center;width:630px;border:#c5c4c4 2px solid;  margin:0 auto;background-color:#f6f0fa; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#000;">

  <div style="width:100%;font-size:15px !important; margin: 0px auto; line-height:0.95;">
    <img src="'.ru_resource.'images/header-email-new.png" alt="iftgift" />
      <div class="box1" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;width: 580px; margin-top: 20px auto;padding-left: 13px; padding-top: 15px;">
      <div class="box" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;background: #fff; margin-top: 20px; border: 1px solid #cccccc; width: 602px;padding-top: 15px;padding-bottom: 20px;" >
        <table width="100%" border="0">
          <tr>
            <td><div style="float:left;">
                <div style="font-size:16px; font-weight:normal; padding-left:10px; padding-bottom:10px; text-align:left">Hi  <strong>'.$recp_name.'</strong>,</div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px; text-align:left">Here’s how <strong>'.$giv_name.'</strong> responded to your Release Request:</div>
                <br />
              </div></td>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>
    <center>
        <br />
        <img src="'.ru_resource.'images/text_email_revised.png" border="0" />
        <div style="margin: 20px 15px 15px 15px;color: #494848; background:#fff; border: 1px solid #cccccc;">
          <table width="100%">
            <tr>
              <td width="100"><img src="'.$user_image.'" /></td>
              <td style="font-style:italic; padding: 10px; text-align: justify">'.$msg.'</td>
            </tr>
          </table>
        </div>
            <a href="'.$releaselink.'"><img src="'.ru_resource.'images/btn-email-revised.png" border="0" /></a>
			<br />

        </center>
  
  <div style="text-align:center">
    <img src="http://preview.iftgift.com/images/jester-emails-revised.png" border="0" /><br />
    <br />
    <br />
    <br />
    <br />
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
        Copyright © 2011, 2012, 2013 Morris Fritz Friedman · All Rights Reserved · iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';
	
	$mailsent = mail($to,$subject,$message,$headers);
	if($mailsent) {
		$query = mysql_query("update ".tbl_delivery." set unlock_date = '".$dated."', unlock_time = '".$time."', release_request_respond = 'change_release' where delivery_id = '".$_POST['delivery_id']."'");
	}
	//echo $message;exit;
	?>
	<script type="text/javascript">
	window.parent.location = '<?php echo ru?>outbox';
	</script>
<?php	
}

/******************************************Release Response Revised**************************************************/


/******************************************Release Response Keep**************************************************/
if(isset($_POST['keep_release'])) { 
	
	$giv_name = $_POST['giv_name'];
	$recp_name = $_POST['recp_name'];
	$msg = mysql_real_escape_string(stripslashes(trim($_POST['message'])));
	
	$get_Uimg = $db->get_row("select user_image,userId from ".tbl_user." where email = '".$_POST['giv_email']."'",ARRAY_A);
	if($get_Uimg['user_image']) {
		$user_image = ru."media/user_image/".$get_Uimg['userId'].'/thumb/'.$get_Uimg['user_image'];
	} else {
		$user_image = ru_resource."images/list_img.jpg";
	}
	$releaselink = ru .'locked/'.$_POST['delivery_id'];
	$to = $_POST['recp_email'];
	$subject = mysql_real_escape_string(stripslashes(trim($_POST['subject'])));
	$from = "Info@iftgift.com";
	$headers  = 'From: '.$from. "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$message ='<div style="text-align:center;width:630px;border:#c5c4c4 2px solid;  margin:0 auto;background-color:#f6f0fa; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#000;">

  <div style="width:100%;font-size:15px !important; margin: 0px auto; line-height:0.95;">
    <img src="'.ru_resource.'images/header-email-new.png" alt="iftgift" />
      <div class="box1" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;width: 580px; margin-top: 20px auto;padding-left: 13px; padding-top: 15px;">
      <div class="box" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;background: #fff; margin-top: 20px; border: 1px solid #cccccc; width: 602px;padding-top: 15px;padding-bottom: 20px;" >
        <table width="100%" border="0">
          <tr>
            <td><div style="float:left;">
                <div style="font-size:16px; font-weight:normal; padding-left:10px; padding-bottom:10px; text-align:left">Hi  <strong>'.$recp_name.'</strong>,</div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px; text-align:left">Here’s how <strong>'.$giv_name.'</strong> responded to your Release Request:</div>
                <br />
              </div></td>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>
    <center>
        <br />
        <img src="'.ru_resource.'images/text_email_reinstated.png" border="0" />
        <div style="margin: 20px 15px 15px 15px;color: #494848; background:#fff; border: 1px solid #cccccc;">
          <table width="100%">
            <tr>
              <td width="100"><img src="'.$user_image.'" /></td>
              <td style="font-style:italic; padding: 10px; text-align: justify">'.$msg.'</td>
            </tr>
          </table>
        </div>
            <a href="'.$releaselink.'"><img src="'.ru_resource.'images/btn-email-revised.png" border="0" /></a>
			<br />

        </center>
  
  <div style="text-align:center">
    <img src="http://preview.iftgift.com/images/jester-emails-revised.png" border="0" /><br />
    <br />
    <br />
    <br />
    <br />
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
        Copyright © 2011, 2012, 2013 Morris Fritz Friedman · All Rights Reserved · iftGift</p>
      <p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        Please do not reply to this message.</p>
      <p><a style="font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
    </center>
    <div style=" height:250px;"></div>
  </div>
</div>';
	
	$mailsent = mail($to,$subject,$message,$headers);
	//echo $message;exit;
	if($mailsent) {
		$query = mysql_query("update ".tbl_delivery." set release_request_respond = 'keep_release' where delivery_id = '".$_POST['delivery_id']."'");
	}
	?>
	<script type="text/javascript">
	window.parent.location = '<?php echo ru?>outbox';
	</script>
<?php	
}

/******************************************Release Response Keep**************************************************/
?>