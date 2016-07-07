<?php
include('../connect/connect.php');
include('../config/config.php');
//mail("atif@zamsol.com","HELLO","How Are You!");exit;
$uri = $_SERVER['HTTP_REFERER'];
if(isset($_POST['ThankMail'])) { 
	
	$giv_name = $_POST['giv_name'];
	$recp_name = $_POST['recp_name'];
	$msg = mysql_real_escape_string(stripslashes(trim($_POST['message'])));
	
	$get_Uimg = $db->get_row("select user_image,userId from ".tbl_user." where email = '".$_POST['recp_email']."'",ARRAY_A);
	if($get_Uimg['user_image']) {
		$user_image = ru."media/user_image/".$get_Uimg['userId'].'/thumb/'.$get_Uimg['user_image'];
	} else {
		$user_image = ru_resource."images/list_img.jpg";
	}
	
	$to = $_POST['giv_email'];
	$subject = mysql_real_escape_string(stripslashes(trim($_POST['subject'])));
	$from = "Info@iftgift.com";
	$headers  = 'From: '.$from. "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$message = '<div style="text-align:center;width:630px;border:#c5c4c4 2px solid;  margin:0 auto;background-color:#f6f0fa; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#000;">
  <div>
    <div style="font-size:15px !important; line-height:0.95">
    <img src="'.ru_resource.'images/header-email-new.png"  alt="iftgift" />
        <div style="padding-left: 13px; padding-top: 15px;">
      <div class="box" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;background: #fff; margin-top: 20px; border: 1px solid #cccccc; width: 602px;padding-top: 15px;padding-bottom: 20px;" >
    <div>
        <table width="100%" border="0">
          <tr>
            <td><div style="float:left; width: 99%">
                <div style="font-size:20px; font-weight:700; padding-left:10px; padding-bottom: 10px; text-align:left">Subject: iftGift Thankyou</div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px; padding-bottom:20px; text-align:left">Hi iftGifter <strong>'.$giv_name.'</strong>,</div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px; ; text-align:left">You sent <strong>'.$recp_name.'</strong> an iftGift.</div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px;; text-align:left"></div>
                <br />
                <div style="font-size:16px; font-weight:normal; padding-left:10px; padding-top: 20px; text-align:left"></div>
              </div></td>
            <td valign="top"></td>
          </tr>
        </table>
      </div>
      <center>
        <div class="box1" style="-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;width: 580px; margin: 10px auto;color: #000; background:#fff; border: 1px solid #000;">
          <table width="100%">
            <tr>
              <td><img src="'.$user_image.'" border="0" /></td>
              <td style="font-style:italic">'.$msg.'</td>
            </tr>
          </table>
        </div>
        <p>&nbsp;</p>
      </center>
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
		$query = mysql_query("update ".tbl_delivery." set thank_mail = '1' where delivery_id = '".$_POST['delivery_id']."'");
	}
	if($uri == ru.'unwrap') {
	?>
	<script type="text/javascript">
	window.parent.location = '<?php echo ru?>unwrap';
	</script>
<?php	
	} else if($uri == ru.'inbox') {
?>
	<script type="text/javascript">
	window.parent.location = '<?php echo ru?>inbox';
	</script>
<?php	
	}
}
?>