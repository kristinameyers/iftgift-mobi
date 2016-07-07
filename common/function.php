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

$_ERR['register']['passg'] = 'The password syntax must contain minimum 6 characters in lowercase, uppercase or numeric.';



$_ERR['register']['username'] = 	'must contain 4 to 20 characters in lowercase, uppercase or numeric.';

$_ERR['register']['userVerify'] = 'already exists, please try another one.';







function pageTitle ($str)

{

	if (!preg_match("#^[a-zA-Z0-9 ]+$#", $str) )

	{

		return true;

	}

}




function numeric ($number)
{
	
	if (!preg_match("#^[0-9]+$#", $number))
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

	if (!preg_match("#^[a-zA-Z0-9]+$#", $valoare) || strlen($valoare) < 6)

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





function VerifyDBUsername ($username)

{



	$rsVU =mysql_query("select count(*) as uc from user where username like '$username' ");

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
	// Email
	if(!preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9\-])*(\.[a-z0-9]{2,3})*$/i', $email) || empty($email)){

		return true;
	}
}




function validate_password( $password ) {

  if(preg_match('/^[a-zA-Z0-9_]{4,50}$/', $password)) {

    return true;

  }

  return false;

}



function phone_number($Phone){

	// Parola

	

	if(!ereg("^[(0-9)]{5} [0-9]{3}-[0-9]{4}$", $Phone) ) 		return false;

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

?>