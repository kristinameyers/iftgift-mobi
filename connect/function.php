<?php 

$_ERR['register']['firstname'] = 'The first name must contain minimum 2 valid characters (a-z, A-Z).';
$_ERR['register']['lastname'] = 'The last name must contain minimum 2 valid characters (a-z, A-Z).';

$_ERR['register']['dob'] = 'Date of birth not valid.';
$_ERR['register']['sc'] = 'invalid Security Code';
$_ERR['register']['phone_number'] = 'Please enter a valid phone number.';
$_ERR['register']['fax_number'] = 'Please enter a valid fax number.';

$_ERR['register']['emaile'] = 'The email is already in use by someone else, please try another one.';
$_ERR['register']['emailg'] = 'The email syntax is not valid.';
$_ERR['register']['email'] = 'Please enter  email address';


$_ERR['register']['passc'] = 'The password confirmation is not the same as password.';
$_ERR['register']['passg'] = 'The password syntax must contain minimum 6 characters';
$_ERR['register']['passm'] = 'Invalid Current Password.';

$_ERR['register']['username'] = 	'must contain 4 to 20 characters in lowercase, uppercase or numeric.';
$_ERR['register']['userVerify'] = 'already exists, please try another one.';

$_ERR['register']['business_name'] = 'The business name  must contain minimum 2 valid characters (a-z, A-Z).';
$_ERR['register']['business_phone'] = 'Please enter a valid phone number.';

$_ERR['register']['name'] = 'The retail outlet name  must contain minimum 2 valid characters (a-z, A-Z).';
$_ERR['register']['address'] = 'The address must contain minimum 5 valid characters (a-z, A-Z).';
$_ERR['register']['parking'] = 'Please enter  parking.';
$_ERR['register']['payment_facility'] = 'Please enter  payment facility.';
$_ERR['register']['purchase_options'] = 'Please enter  purchase options.';


function check_Name($PROFILEULR) {
  $PROFILEULR = trim($PROFILEULR); // strip any white space
  $response = array(); // our response
  
  // if the PROFILEULR is blank 
  if ( in_array($PROFILEULR, array ('easysite' , 'easysitecreator','blog','partners','mysql'))   ){
	
	$response = array(
      'ok' => false, 
      'msg' => "<font color=#C51200>The selected Domain URL is not available</font>");
	
  }else if (!$PROFILEULR) {
    $response = array(
      'ok' => false, 
      'msg' => "Please specify sub-domain name");
	  // if the PROFILEULR does not match a-z or '.', '-', '_' then it's not valid
  } else if (!preg_match('/^[a-z0-9]+$/', $PROFILEULR) || strlen ($PROFILEULR) < 4 || strlen ($PROFILEULR) >30 ) {
    $response = array(
      'ok' => false, 
      'msg' => "<font color=#C51200>Domain URL can only contain  4-30 alphanumerics </font>");
      
  // this would live in an external library just to check if the PROFILEULR is taken
  } else if (domain_taken($PROFILEULR)) {
    $response = array(
      'ok' => false, 
      'msg' => "<font color=#C51200>The selected Domain URL is not available</font>");
      
  // it's all good
  } else {
    $response = array(
      'ok' => true, 
      'msg' => "<font color=#C51200>This Domain URL is free</font>");
  }

  return $response;        
}

function domain_taken($PROFILEULR){
	
	
	$rsVU =mysql_query("select count(*) as uc from business where 	subdomain  like '$PROFILEULR' ");
	$rowUV = mysql_fetch_array($rsVU);
	if ( $rowUV['uc'] > 0 ) return true; else return false;
}

function PROFILEULR_taken($PROFILEULR){

	$rsVU =mysql_query("select count(*) as uc from business where 	subdomain  like '$PROFILEULR' ");
	$rowUV = mysql_fetch_array($rsVU);
	if ( $rowUV['uc'] > 0 ) return true; else return false;
}



function pageTitle ($str)
{
	if (!preg_match("#^[a-zA-Z0-9 ]+$#", $str) )
	{
		return true;
	}
}


function verify_username2 ($valoare)
{
	
	if (!preg_match("#^[a-zA-Z0-9]+$#", $valoare)  )
	{
		return true;
	}
}

function verify_username ($valoare)
{
	if (!preg_match("#^[a-zA-Z0-9]+$#", $valoare) || strlen($valoare) < 4  ||  strlen($valoare) > 20 )
	{
		return true;
	}
}

function verifypassword ($valoare)
{
	// Parola
	if ( strlen($valoare) < 6)
	{
		return true;
	}
}

function isValidURL($url)
{
return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

function testurl ($url)
{
	// Parola
	if (eregi('^([[:alnum:]\-\.])+(\.)([[:alnum:]]){2,4}([[:alnum:]/+=%&_\.~?\-]*)$', $url))
	{
		return false;
	}
	elseif (!eregi('^([[:alnum:]\-\.])+(\.)([[:alnum:]]){2,4}([[:alnum:]/+=%&_\.~?\-]*)$',$url)){return true;}
}


$_ERR['register']['userValidate'] = 'The user name must contain minimum 4 valid characters (a-z, A-Z, 0-9, _).';


function ValidateUsername ($username)
{

	if(!preg_match("#^[a-zA-Z0-9\_]+$#", $username) || strlen($username) < 4)
	{
		return true;
	}	
}

function Validatedes($des)
{

	if(!preg_match("#^[a-zA-Z0-9\_]+$#", $des))
	{
		return true;
	}	
}


function VerifyDBUsername ($username)
{

	$rsVU =mysql_query("select count(*) as uc from user where username like '$username' ");
	if (isset($_SESSION['LOGINDATA_tmp']['USERID_tmp']))		
				$rsVU =mysql_query("select count(*) as uc from user where username like '$username' and userId <> ". $_SESSION['LOGINDATA_tmp']['USERID_tmp'] );
	$rowUV = mysql_fetch_array($rsVU);	
	if ( $rowUV['uc'] > 0 ) return true; else return false;
}

$_ERR['register']['cpname'] = 'The company name must contain minimum 2 valid characters (a-z, A-Z).';


function verifyName ($str)
{
	
	if (!preg_match("#^[a-zA-Z\s.-]+$#", $str) || strlen($str) < 2)
	{
		return true;
	}
}

function verifyName2 ($str)
{
	
	if (!preg_match("#^[a-zA-Z\s.-]+$#", $str) || strlen($str) < 2)
	{
		return true;
	}
}

function verifyDomain ($str)
{
	
	if (!preg_match("#^[a-zA-Z\s.-]+$#", $str) || strlen($str) < 2)
	{
		return true;
	}
}
function VerifyDB_Domain($str)
{
	$rsVU =mysql_query("select count(*) as uc from ms_business where domain like '$str' ");
	$rowUV = mysql_fetch_array($rsVU);
	if ( $rowUV['uc'] > 0 ) return true; else return false;
	
}




function vpemail ($email)
{
	// Email
	if(!preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9\-])*(\.[a-z0-9]{2,3})*$/i', $email) || empty($email)){

		return true;
	}
}



function reducere($text)
{
	$a = array("\r", "\t", "\n");
	$r = str_replace($a, '', $text);
	return $r;
}

// Functii pregmatch de verificare

function vState ($valoare)
{
	// Parola
	if (!preg_match("#^[0-9]+$#", $valoare) || strlen($valoare) < 5)
	{
		return true;
	}
}

function vpphone ($valoare)
{
	// Parola
	if (!preg_match("#^[0-9]+$#", $valoare)/* || strlen($valoare) < 6*/)
	{
		return true;
	}
}

function vpparolac ($valoare, $valoarec)
{
	// Parola confirmare
	if (!($valoare == $valoarec))
	{
		return true;
	}
}
function vpparolav ($tb, $valoare)
{
	// Utilizator existent
	$parolav	=	selectaren("*", $tb, "and parola = '".md5($valoare)."' and id = ".$_SESSION['sesID']);
	if ($parolav != 1)
	{
		return true;
	}
}



function vpemailc ($valoare, $valoarec)
{
	// Email confirmare
	if (!($valoare == $valoarec))
	{
		return true;
	}
}

function wordLimit($string, $length = 50, $ellipsis = '...')
{
   return count($words = preg_split('/\s+/', ltrim($string), $length + 1)) > $length ?
       rtrim(substr($string, 0, strlen($string) - strlen(end($words)))) . $ellipsis :
       $string;
}

function stringLimit($string, $length = 50, $ellipsis = '...')
{
   return strlen($fragment = substr($string, 0, $length + 1 - strlen($ellipsis))) < strlen($string) + 1 ?
       preg_replace('/\s*\S*$/', '', $fragment) . $ellipsis : $string;
}
function splitlimit($string, $length = 50, $ellipsis = '...')
{
   if (strlen($string) > $length)return substr($string, 0, $length) . ' ' . $ellipsis;
   else return $string;
}



/////////////////////////// Create File Path Function////////////////////////// 
function createpath($path)
{
		$exp=explode("/",$path);
				$way='';
				foreach($exp as $n)
				{
					
					$way.=$n;
						@mkdir($way, 0777);
						@chmod($way, 0777);
					$way.='/';
						
				}
}/// end of create path($path)
//////////////////////////////////// check image type ////////////////////////////////////
function checkimagetype($imagetype){

		$filetype = array(
		   'image/bmp', 
		   'image/gif', 
		   'image/icon', 
		   'image/jpeg',
		   'image/jpg', 
		   'image/png', 
		   'image/tiff', 
		 );
        if( in_array($imagetype,$filetype))
			return true;
		else 
			return 0;

}// end function
///////////////////////////////////////////////////////////////////////////////////////////



function getBussId()
{
	if(isset($_COOKIE['bussVarInc']))
	{
		$bussId = $_COOKIE['bussVarInc'];
		$bussId = base64_decode($bussId);
		$res = mysql_query("select count(bussId) from tbl_buss_tmp where bussId = '".$bussId."'");
		$row = mysql_fetch_array($res);
		if($row[0] == 0)
		{
			$bussId = 0;
		}
	}
	else
	{
		$bussId = 0;
	}
	return $bussId;
}

function pageTitleTop ($str)
{
	if (!preg_match("#^[a-zA-Z0-9 ]+$#", $str) )
	{
		return true;
	}
}


function fullname_validation($fname){
	$array = explode(" ",$fname);
	if(count($array) < 3 && count($array) > 0 && $fname != "")
	{
		return 'valid';
	}else{
		return 'invalid';
	}
}

function email_validation($email,$userId = 0){
	 
	 if(!preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])*(\.([a-z0-9])([-a-z0-9_-])([a-z0-9])+)*$/i', $email)){

		return 'inavlid';
	}else{
		if($userId == 0){
			$qry_count_email = mysql_query("select count(id) from tblusers where email = '".$email."'");
		}else{
			$qry_count_email = mysql_query("select count(id) from tblusers where email = '".$email."' and id != '".$userId."'");
		}
		
		$row_count_email = mysql_fetch_array($qry_count_email);
		if($row_count_email[0] == 0)
			return 'valid';
		else
			return 'exist';
	}
}

function validate_password( $password ) {
  if(preg_match('/^[a-zA-Z0-9_]{4,50}$/', $password)) {
    return true;
  }
  return false;
}

function phone_number($Phone){

	if (!preg_match('/^[(0-9)]{5} [0-9]{3}-[0-9]{4}$/', $Phone)) return false;
	return true;
}
function phone_numberTxt($Phone){
	// Parola

	if (!preg_match('/^[(0-9)]{5} [a-zA-Z0-9]{3}-[a-zA-Z0-9]{4}$/', $Phone)) return false;
	return true;
}


function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "\"".addslashes($key)."\"";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "\"".addslashes($value)."\"";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}
	
	function showColorOption ($divId , $sel , $colorDemoURL,   $OrignalImage)
	{ ?>
		
		Select Color: 
                        <select name="colorOpt_<?php echo $divId ?>" id="colorOpt_<?php echo $divId ?>"  onchange="reloadImag('<?php echo $colorDemoURL ?>'+  this.value ,'img_<?php echo $divId ?>' ,'<?php echo $OrignalImage ?>' ,this.value)"   >
                        	<option <?php if ( $sel == 0 ) echo ' selected="selected" ' ?>  value="0" >Original</option>
                            <option <?php if ( $sel == 1 ) echo ' selected="selected" ' ?> value="1" >Bold</option>
                            <option <?php if ( $sel == 2 ) echo ' selected="selected" ' ?> value="2" >Clean</option>
                            <option <?php if ( $sel == 3 ) echo ' selected="selected" ' ?> value="3" >Forest</option>
                            <option <?php if ( $sel == 4 ) echo ' selected="selected" ' ?> value="4" >Desert</option>
                            <option <?php if ( $sel ==  $_SESSION['biz_reg']['locationid'] ) echo ' selected="selected" ' ?> value="<?php echo $_SESSION['biz_reg']['locationid'] ?>" >Custom</option>
                        </select>
	<?php
    }
	
	
		function xml2array($xml) {
        $xmlary = array();
               
        $reels = '/<(\w+)\s*([^\/>]*)\s*(?:\/>|>(.*)<\/\s*\\1\s*>)/s';
        $reattrs = '/(\w+)=(?:"|\')([^"\']*)(:?"|\')/';

        preg_match_all($reels, $xml, $elements);

        foreach ($elements[1] as $ie => $xx) {
                $xmlary[$ie]["name"] = $elements[1][$ie];
               
                if ($attributes = trim($elements[2][$ie])) {
                        preg_match_all($reattrs, $attributes, $att);
                        foreach ($att[1] as $ia => $xx)
                                $xmlary[$ie]["attributes"][$att[1][$ia]] = $att[2][$ia];
                }

                $cdend = strpos($elements[3][$ie], "<");
                if ($cdend > 0) {
                        $xmlary[$ie]["text"] = substr($elements[3][$ie], 0, $cdend - 1);
                }

                if (preg_match($reels, $elements[3][$ie]))
                        $xmlary[$ie]["elements"] = xml2array($elements[3][$ie]);
                else if ($elements[3][$ie]) {
                        $xmlary[$ie]["text"] = $elements[3][$ie];
                }
        }

        return $xmlary;}
	
	
?>