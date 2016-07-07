<?php
//include("connect/connect.php");
// ALLWED UPLOAD FILE FORMATES //
$arrallowed_ext = array("gif","jpg","jpeg","png","pdf","txt","doc","rtf","zip","flv","7z");
if(!HOSTED_LOCAL){
	//Mysql Database Time Zone Settings //
	define("DB_TIMEZONE", '+05:00');
	//PHP Time Zone Settings //
	date_default_timezone_set('Asia/Karachi');
}

define("TBL_PREFIX", 'gift_');

//-------------- DATABASE Tables ----------------//
define("tbl_user", TBL_PREFIX."users");
define("tbl_category", TBL_PREFIX."category");
define("tbl_product", TBL_PREFIX."product");
define("tbl_recipient", TBL_PREFIX."recipient");
define("tbl_occasion", TBL_PREFIX."occasion");
define("tbl_order", TBL_PREFIX."order");
define("tbl_own", TBL_PREFIX."own_it");
define("tbl_love", TBL_PREFIX."love_it");
define("tbl_hide", TBL_PREFIX."hide_it");
define("tbl_delivery", TBL_PREFIX."delivery_detail");
define("tbl_checkout", TBL_PREFIX."checkout");
define("tbl_userpoints", TBL_PREFIX."user_points");
define("tbl_reminder", TBL_PREFIX."reminder");
define("tbl_payment", TBL_PREFIX."payment");
define("tbl_member_card", TBL_PREFIX."member_card");
define("tbl_depositcash", TBL_PREFIX."depositcash");
define("tbl_payment_setting", TBL_PREFIX."payment_setting");
define("tbl_withdrawcash", TBL_PREFIX."withdrawcash");
define("tbl_order", TBL_PREFIX."order");
define("tbl_order_detail", TBL_PREFIX."order_detail");
define("tbl_shipping_address", TBL_PREFIX."shipping_address");
define("tbl_achnumber", TBL_PREFIX."member_baccount");





//----------------------Start Data Encryption/Descryption-------------------------------//
/*function encrypt($string) {
	$key = 'bcb04b7e103a0cd8b54763051cef08bc';
    $crypted_text = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB);
    return $crypted_text;
}
function decrypt($encrypted_string) {
	$key = 'bcb04b7e103a0cd8b54763051cef08bc';
    $decrypted_text = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encrypted_string, MCRYPT_MODE_ECB);
    return trim($decrypted_text);
}*/

function encrypt($string) {
	$output = false;
	$key = md5('bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3');
	$iv = md5(md5($key));
		
	$output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
	$output = base64_encode($output);

	return $output;
}
	
function decrypt($string) {
	$output = false;
	$key = md5('bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3');
	$iv = md5(md5($key));
	
	$output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
	$output = rtrim($output);	

	return $output;
}


//----------------------End Data Encryption/Descryption-------------------------------//	

//-----------------------------------------------------//
 
 setlocale(LC_ALL, 'en_US.UTF8');
 function toAscii($str) 
 {
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
	return $clean;
}
/*========================Date Format=================================*/
function db_date_to_usformat_in($date)
{
	if($date==NULL || $date=='' || $date=='0000-00-00'){
		return 0;	
	}
	else
	{
		return date('Y-m-d',strtotime($date));   //mm/dd/yy
	}
}

/*========================Mail Function==============================*/

	function sendmail($from,$to,$subject,$message){
		$headers  	= 	'MIME-Version: 1.0' . "\r\n";
		$headers   .= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers   .= 	'From: '.$from. "\r\n";
	    mail($to,$subject,$message,$headers);
		unset($headers); 	
	}
	
/*===============================File ext==========================*/
	
function findexts ($filename) 
{ 
 	$filename = strtolower($filename) ; 
 	$exts = split("[/\\.]", $filename) ; 
 	$n = count($exts)-1; 
 	$exts = $exts[$n]; 
 	return $exts; 
 } 

/*===============================Date Function==========================*/

function in_date_format_to_db($date)
{
	if($date==NULL || $date=='' || $date=='0000-00-00'){
		return 0;	
	}
	else
	{
		return date('Y-m-d',strtotime($date));   //YY-mm-dd
	}
}

/*===========================Image Function====================================*/
function get_image($image)
{
		$img =  preg_replace("/<a[^>]+\>/i", "", $image);
		preg_match("/src=([^>\\']+)/", $img, $result);
		$view_image = array_pop($result);
		echo $view_image;
}


function convert_unixdatetime($ndate,$ntime)
{
	$formated_datetime = $ndate.' '.$ntime;
	$unix_timestamp = STRTOTIME($formated_datetime);
	return $unix_timestamp;
}


function get_category($gender,$age)
{
		switch ($gender) {
	  case "male":
	  	if($age >= '20') {
			$where_clause = "AND FIND_IN_SET('Man',gender)";
		} else if($age >= '13' && $age <= '19'){
			$where_clause = "AND FIND_IN_SET('Teen Boy',gender)";
		} else if($age >= '4' && $age <= '12'){
			$where_clause = "AND FIND_IN_SET('Boy',gender)";
		} else if($age >= '0' && $age <= '3'){
			$where_clause = "AND FIND_IN_SET('Boy',gender)";
		}
		break;
	  case "female":
		if($age >= '20') {
			$where_clause = "AND FIND_IN_SET('Woman',gender)";
		} else if($age >= '13' && $age <= '19'){
			$where_clause = "AND FIND_IN_SET('Teen Girl',gender)";
		} else if($age >= '4' && $age <= '12'){
			$where_clause = "AND FIND_IN_SET('Girl',gender)";
		} else if($age >= '0' && $age <= '3'){
			$where_clause = "AND FIND_IN_SET('Girl',gender)";
		}
		break;
	}
	return $where_clause;
}

function get_price($price)
{
	$price_less = $price - ($price * 10/100);
 	$price_add =  $price + ($price * 10/100);
	$price_clause = "AND (price >= '".$price_less."' AND price <= '".$price_add."')";
	return $price_clause;
}

function get_ocassion($ocassion)
{
	 $get_occ = mysql_query("select occasionid,occasion_name,status,p_occasionid,occasion_type,cat_id,method from ".tbl_occasion." where occasion_type = 0 and occasionid = '".$ocassion."'");
	 $get_occ_info = @mysql_fetch_array($get_occ);
	 $occ_name = $get_occ_info['occasion_name'];
	 
	 $cat_id = explode(',',$get_occ_info['cat_id']);
	 foreach($cat_id as $Id) {
	 	$cat .= "'".mysql_real_escape_string(stripslashes(trim($Id)))."',";
	 }
	 $categories = rtrim($cat,",");
	 if($get_occ_info['method'] ==  1) {
	 	$cat_clause = "AND category NOT IN($categories)";
	 } else if($get_occ_info['method'] ==  2) {
	 	$cat_clause = "AND category IN($categories)";
	 }
	 return $cat_clause;
}

/*function get_ocassion($ocassion)
{
	 $get_occ = mysql_query("select occasionid,occasion_name,status,p_occasionid,occasion_type,cat_id from ".tbl_occasion." where occasion_type = 0 and occasionid = '".$ocassion."'");
	 $get_occ_info = @mysql_fetch_array($get_occ);
	 $occ_name = $get_occ_info['occasion_name'];
	 
	 switch($occ_name) {
	 	case "Expecting":
			$cat_clause = "AND (category = 'Expecting Store' OR category = 'Baby')";
	 	break;
	 	case "Newly Born":
			$cat_clause = "AND category = 'Baby'";
		break;
	 	case "Birthday":
			$cat_clause = "";
		break;
		case "*Bar Mitzvah":
			$cat_clause = "AND (category = 'Athletics' OR category = 'Books' OR category = 'Clothes' OR category = 'Electronics' OR category = 'Food' OR category = 'Wacky Gift Ideas' OR category = 'Accessories' OR category = 'Musical Instruments' OR category = 'Toys' OR category = 'Video Games')";
		break;
		case "*The Bat Mitzvah Store":
			$cat_clause = "AND (category = 'Athletics' OR category = 'Books' OR category = 'Clothes' OR category = 'Electronics' OR category = 'Food' OR category = 'Accessories' OR category = 'Musical Instruments' OR category = 'Health and beauty' OR category = 'Toys' OR category = 'Video Games')";
		break;
		case "*50+":
			$cat_clause = "AND category != 'Baby'";
		break;
		case "*Sweet 16":
			$cat_clause = "AND category != 'Baby'";
		break;
		case "21":
			$cat_clause = "AND category != 'Baby'";
		break;
		case "Retirement":
			$cat_clause = "AND category != 'Baby'";
		break;
		case "Commitment":
			$cat_clause = "AND (category = 'Art' OR category = 'Health and beauty' OR category = 'Food' OR category = 'Accessories' OR category = 'Wine' OR category = 'Home')";
		break;	
		case "Engagement":
			$cat_clause = "AND (category = 'Art' OR category = 'Health and beauty' OR category = 'Food' OR category = 'Accessories' OR category = 'Wine' OR category = 'Home')";
		break;	
		case "Wedding":
			$cat_clause = "AND (category = 'Art' OR category = 'Electronics' OR category = 'Food' OR category = 'Wine' OR category = 'Home')";
		break;	
		case "Anniversary":
			$cat_clause = "AND (category = 'Art' OR category = 'Health and beauty' OR category = 'Food' OR category = 'Wine' OR category = 'Home' OR category = 'Electronics' OR category = 'Jewelry')";
		break;
		case "Separation/Divorce":
			$cat_clause = "AND (category = 'Food' OR category = 'Wine' OR category = 'Home' OR category = 'Wacky Gift Ideas')";
		break;
		case "Graduation":
			$cat_clause = "AND (category = 'Art' OR category = 'Bags' OR category = 'Wacky Gift Ideas' OR category = 'Food' OR category = 'Electronics' OR category = 'Musical Instruments' OR category = 'Books' OR category = 'Video Games' OR category = 'Movies' OR category = 'Music')";
		break;	
		case "Promotion":
			$cat_clause = "AND (category = 'Art' OR category = 'Wine' OR category = 'Wacky Gift Ideas' OR category = 'Food' OR category = 'Electronics' OR category = 'Books' OR category = 'Movies' OR category = 'Music')";
		break;	
		case "Honor/Award":
			$cat_clause = "AND (category = 'Accessories' OR category = 'Art' OR category = 'Wine' OR category = 'Wacky Gift Ideas' OR category = 'Food' OR category = 'Electronics' OR category = 'Books' OR category = 'Movies' OR category = 'Music')";
		break;
		case "Housewarming":
			$cat_clause = "AND (category = 'Health and beauty' OR category = 'Art' OR category = 'Wine' OR category = 'Musical Instruments' OR category = 'Food' OR category = 'Home' OR category = 'Books' OR category = 'Movies' OR category = 'Music')";
		break;
		case "Recovery":
			$cat_clause = "AND (category = 'Health and beauty' OR category = 'Art' OR category = 'Video Games' OR category = 'Musical Instruments' OR category = 'Food' OR category = 'Books' OR category = 'Movies' OR category = 'Music')";
		break;
		case "Thank You":
			$cat_clause = "";
		break;
		case "I Love You":
			$cat_clause = "AND (category = 'Accessories' OR category = 'Art' OR category = 'Wine' OR category = 'Food' OR category = 'Health and beauty')";
		break;
		case "Well Done":
			$cat_clause = "AND (category = 'Accessories' OR category = 'Art' OR category = 'Bags' OR category = 'Food' OR category = 'Health and beauty' OR category = 'Books' OR category = 'Electronics' OR category = 'Gift Ideas' OR category = 'Music' OR category = 'Movies' OR category = 'Wine' OR category = 'Musical Instruments')";
		break;
		case "You're Special":
			$cat_clause = "AND (category = 'Accessories' OR category = 'Art' OR category = 'Bags' OR category = 'Food' OR category = 'Health and beauty' OR category = 'Books' OR category = 'Electronics' OR category = 'Gift Ideas' OR category = 'Music' OR category = 'Movies' OR category = 'Wine')";
		break;
		case "I'm Sorry":
			$cat_clause = "AND (category = 'Accessories' OR category = 'Art' OR category = 'Bags' OR category = 'Food' OR category = 'Health and beauty' OR category = 'Books' OR category = 'Electronics' OR category = 'Gift Ideas' OR category = 'Music' OR category = 'Movies' OR category = 'Wine')";
		break;
		case "Christmas":
			$cat_clause = "";
		break;
		case "Easter":
			$cat_clause = "AND (category = 'Food' OR category = 'Wine' OR category = 'Easter')";
		break;
		case "Father's Day":
			$cat_clause = "AND (category = 'Accessories' OR category = 'Athletics' OR category = 'Bags' OR category = 'Books' OR category = 'Electronics' OR category = 'Food' OR category = 'Gift Ideas' OR category = 'Health and beauty' OR category = 'Musical Instruments' OR category = 'Wine' OR category = 'Video Games')";
		break;
		case "Hanukkah":
			$cat_clause = "";
		break;
		case "New Year's Day":
			$cat_clause = "AND (category = 'Food' OR category = 'Wine' OR category = 'Gift Ideas')";
		break;
		case "Chinese New Year":
			$cat_clause = "";
		break;
		case "Kwanzaa":
			$cat_clause = "";
		break;
		case "Mother's Day":
			$cat_clause = "AND (category = 'Accessories' OR category = 'Art' OR category = 'Bags' OR category = 'Books' OR category = 'Food' OR category = 'Health and beauty' OR category = 'Jewelry' OR category = 'Music' OR category = 'Movies' OR category = 'Wine')";
		break;
		case "Halloween":
			$cat_clause = "AND (category = 'Food' OR category = 'Movies' OR category = 'Wine')";
		break;
		case "Thanksgiving":
			$cat_clause = "AND (category = 'Food' OR category = 'Wine')";
		break;
		case "Valentine's Day":
			$cat_clause = "AND (category = 'Accessories' OR category = 'Art' OR category = 'Food' OR category = 'Health and beauty' OR category = 'Home' OR category = 'Wine' OR category = 'Valentine')";
		break;
	 }
	 return $cat_clause;
}*/


/**********************Function Match User*****************************/

function match_user($age,$gender,$ocassion) {
	$get_sperson = mysql_query("select distinct email,age,ocassion from ".tbl_recipient." where age = '".$age."' and gender = '".$gender."' and ocassion = '".$ocassion."'");
	while($view_sperson = mysql_fetch_array($get_sperson)) {
		$query = mysql_query("select userId,recp_email,proid,delivery_id from ".tbl_delivery." where occassionid = '".$view_sperson['ocassion']."' and recp_email = '".$view_sperson['email']."'");
		while($users_info = mysql_fetch_array($query)) {
	 	$array[] = $users_info;
	 	}
	}
	return $array;
}
/**********************Function Match User*****************************/

/**********************Function Get Recp User*****************************/
function get_recp_info($recption_id) {
	$query = "select recipit_id,cash_gift,gender,age,ocassion,email from ".tbl_recipient." where recipit_id = '".$recption_id."'";
	$get_info = mysql_fetch_array(mysql_query($query));
	return $get_info;
}

/**********************Function Get Recp User*****************************/


/*--------------Function Used For Gift Suggestion Points-------------------*/
function user_suggest_points($userId) {
		$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$userId."'");
		$view_points = mysql_fetch_array($check_points);
		$points = $view_points['points'];
		$new_points = $points + 10;
		if($view_points) {
			$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$userId."'");
		} else {
			$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '25',userId = '".$userId."'");
		}
		
		$recp_id = $_SESSION['recipit_id']['New'];
		$query = mysql_fetch_array(mysql_query("select email,recp_points from ".tbl_recipient." where recipit_id = '".$recp_id."'"));
		$email = $query['email'];
		$chk_useremail = mysql_query("select userId,email from ".tbl_user." where email = '".$email."'");
		if(mysql_num_rows($chk_useremail) > 0) {
		$view_useremail = mysql_fetch_array($chk_useremail);
		$uId = $view_useremail['userId'];
			$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$uId."'");
			$view_points = mysql_fetch_array($check_points);
			$points = $view_points['points'];
			$new_points = $points + 2;
			if($view_points) {
				$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$uId."'");
			} else {
				$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '2',userId = '".$uId."'");
			}
		} else {
			if($query) {
			$points = $query['recp_points'];
			$new_points = $points + 2;
			$update_points = mysql_query("update ".tbl_recipient." set recp_points = '".$new_points."' where recipit_id = '".$recp_id."'");
			}
		}
}
/*--------------Function Used For Gift Suggestion Points-------------------*/

/*--------------Function Used For Gift Own It Points-------------------*/
function user_own_points($userId) {
		$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$userId."'");
		$view_points = mysql_fetch_array($check_points);
		$points = $view_points['points'];
		$new_points = $points + 6;
		if($view_points) {
			$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$userId."'");
		} else {
			$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '6',userId = '".$userId."'");
		}
		
		$recp_id = $_SESSION['recipit_id']['New'];
		$query = mysql_fetch_array(mysql_query("select email,recp_points from ".tbl_recipient." where recipit_id = '".$recp_id."'"));
		$email = $query['email'];
		$chk_useremail = mysql_query("select userId,email from ".tbl_user." where email = '".$email."'");
		if(mysql_num_rows($chk_useremail) > 0) {
		$view_useremail = mysql_fetch_array($chk_useremail);
		$uId = $view_useremail['userId'];
			$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$uId."'");
			$view_points = mysql_fetch_array($check_points);
			$points = $view_points['points'];
			$new_points = $points + 1;
			if($view_points) {
				$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$uId."'");
			} else {
				$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '1',userId = '".$uId."'");
			}
		} else {
			if($query) {
			$points = $query['recp_points'];
			$new_points = $points + 1;
			$update_points = mysql_query("update ".tbl_recipient." set recp_points = '".$new_points."' where recipit_id = '".$recp_id."'");
			}
		}
}
/*--------------Function Used For Gift Own It Points-------------------*/

/*--------------Function Used For Gift Love It Points-------------------*/
function user_love_points($userId) {
		$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$userId."'");
		$view_points = mysql_fetch_array($check_points);
		$points = $view_points['points'];
		$new_points = $points + 8;
		if($view_points) {
			$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$userId."'");
		} else {
			$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '8',userId = '".$userId."'");
		}
		
		$recp_id = $_SESSION['recipit_id']['New'];
		$query = mysql_fetch_array(mysql_query("select email,recp_points from ".tbl_recipient." where recipit_id = '".$recp_id."'"));
		$email = $query['email'];
		$chk_useremail = mysql_query("select userId,email from ".tbl_user." where email = '".$email."'");
		if(mysql_num_rows($chk_useremail) > 0) {
		$view_useremail = mysql_fetch_array($chk_useremail);
		$uId = $view_useremail['userId'];
			$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$uId."'");
			$view_points = mysql_fetch_array($check_points);
			$points = $view_points['points'];
			$new_points = $points + 1;
			if($view_points) {
				$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$uId."'");
			} else {
				$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '1',userId = '".$uId."'");
			}
		} else {
			if($query) {
			$points = $query['recp_points'];
			$new_points = $points + 1;
			$update_points = mysql_query("update ".tbl_recipient." set recp_points = '".$new_points."' where recipit_id = '".$recp_id."'");
			}
		}
}
/*--------------Function Used For Gift Love It Points-------------------*/

/*--------------Function Used For Gift Hide It Points-------------------*/
function user_hide_points($userId) {
		$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$userId."'");
		$view_points = mysql_fetch_array($check_points);
		$points = $view_points['points'];
		$new_points = $points + 6;
		if($view_points) {
			$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$userId."'");
		} else {
			$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '6',userId = '".$userId."'");
		}
		
		$recp_id = $_SESSION['recipit_id']['New'];
		$query = mysql_fetch_array(mysql_query("select email,recp_points from ".tbl_recipient." where recipit_id = '".$recp_id."'"));
		$email = $query['email'];
		$chk_useremail = mysql_query("select userId,email from ".tbl_user." where email = '".$email."'");
		if(mysql_num_rows($chk_useremail) > 0) {
		$view_useremail = mysql_fetch_array($chk_useremail);
		$uId = $view_useremail['userId'];
			$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$uId."'");
			$view_points = mysql_fetch_array($check_points);
			$points = $view_points['points'];
			$new_points = $points + 1;
			if($view_points) {
				$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$uId."'");
			} else {
				$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '1',userId = '".$uId."'");
			}
		} else {
			if($query) {
			$points = $query['recp_points'];
			$new_points = $points + 1;
			$update_points = mysql_query("update ".tbl_recipient." set recp_points = '".$new_points."' where recipit_id = '".$recp_id."'");
			}
		}
}
/*--------------Function Used For Gift Hide It Points-------------------*/

/*--------------Function Used For Request Release Points-------------------*/
function request_release_points($userId,$givId) {
		if($userId) {
			$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$userId."'");
			$view_points = mysql_fetch_array($check_points);
			$points = $view_points['points'];
			$new_points = $points + 2;
			if($view_points) {
				$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$userId."'");
			} else {
				$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '2',userId = '".$userId."'");
			} 
		}  
		
		if($givId) {
			$check_points = mysql_query("select * from ".tbl_userpoints." where userId = '".$givId."'");
			$view_points = mysql_fetch_array($check_points);
			$points = $view_points['points'];
			$new_points = $points + 10;
			if($view_points) {
				$update_points = mysql_query("update ".tbl_userpoints." set points = '".$new_points."' where userId = '".$givId."'");
			} else {
				$insrt_points = mysql_query("insert into ".tbl_userpoints." set points = '10',userId = '".$givId."'");
			} 
		}
}
/*--------------Function Used For Request Release Points-------------------*/
?>
