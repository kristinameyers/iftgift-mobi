     </form> <?php
	  if(isset($_REQUEST['sendemail']))
	  {
	
	  $getadminemail=mysql_query("SELECT option_value FROM  wp_options WHERE option_name='admin_email'") or die(mysql_error());
	  $rec_adminemail=mysql_fetch_array($getadminemail);
	  $admin_email=$rec_adminemail['option_value'];
	   //email send to admin
	   
	   
	   
            $headers = "From: Daily Best Online Deals <".$admin_email."> \r\n";
            $headers .= "Reply-To:" . $admin_email . "\r\n";
            //$headers .= "Cc: tonypodosky@bigpond.com";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = $_REQUEST['subject'];
            $message = '<html><body style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">';
            //$message .= "Dear Admin,<br><br>";
            $message .= "Here is new message for you:<br><br>";
            $message .= '<table rules="all" style="border-color: #666;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;" cellpadding="10">';
            $message .= "<tr style='background: #eee;'><td colspan='2'><strong>Name:</strong></td></tr>";
            $message .= '<tr><td><strong>Deal Title</strong> </td><td>'.ucfirst($_REQUEST['name']).'</td></tr>';
            $message .= '<tr><td><strong>Email</strong> </td><td>'.$_REQUEST['email'].'</td></tr>';
            $message .= '<tr><td><strong>Message</strong> </td><td>'.$_REQUEST['msg'].'</td></tr>';
			$message .= "</table>";
            $message .= "<br><br>Thank you.";
            $message .= "</body></html>";
		
			mail($admin_email, $subject, $message, $headers);
			}
			?>
	   <h3 class="inner-page-hdng">Contact Us</h3>
       
       <div data-role="main" class="ui-content">
            <div class="contact-us">
                <form action="" method="post" id="contactmail" name="contactmail">
                	<ul class="cntct-form">
                    	<li>
                        	<label>Your Name (required)</label>
                            <input type="text" placeholder="Name"  id="name" name="name"  required>
                        </li>
                        
                        <li>
                        	<label>Email (required)</label>
                            <input type="text" placeholder="Email"  id="email" name="email"  required>
                        </li>
                        
                        <li>
                        	<label>Subject (required)</label>
                            <input type="text" placeholder="Subject" id="subject" name="subject" required>
                        </li>
                        
                        <li>
                        	<label>Message</label>
                            <textarea id="msg" name="msg"></textarea>
                        </li>
                        
                        <li>
                        	<input type="submit" class="ui-btn ui-input-btn ui-corner-all ui-shadow" id="sendemail" name="sendemail" value="Send">
                        </li>
                    </ul>
                </form>
            </div> 
        </div>
	<div class="adress">	
		<p> Muvao, Inc. <br>
Phone: (561) 459-8368	<br>
Fax: (561) 370-7037 <br>
Address: P. O Box 223112 <br>
West Palm Beach, FL 33422 USA </p>
</div>
        
<script language="javascript">
	function formsubmit(){
		document.getElementById("searchForm").submit()	
	}
</script>

<script type="text/javascript">
$(document).ready(function(){
	$(function() {
		$("#keyword").autocomplete({
			source: "<?php  echo ru;?>process/autosearch.php",
			minLength:1
		});
	});
	});
	
</script>
        
       
