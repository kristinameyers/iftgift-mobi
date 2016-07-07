<?php
	//error_reporting(E_ALL ^ E_NOTICE);
	/*	
	
	if (substr(getenv('HTTP_HOST'),0,3) != 'www')
	{
		  header('HTTP/1.1 301 Moved Permanently');
		  header('Location:http://www.'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	}	
	// header('Content-Type: text/html; charset=utf-8');
	
	*/
			
	
	ob_start();
	session_start();
	
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache'); 
	
	
	define("DOMAIN", $_SERVER['HTTP_HOST']);
	define ('SiteFolder' , 'mobi/');
	
	define("ruadmin","http://".$_SERVER['HTTP_HOST']."/". SiteFolder ."iftgift_cpanel/");
	

	define("ru", "http://".DOMAIN."/" . SiteFolder);
	define("ru_resource", 	ru .'resource/');
	define("ru_css", 	ru .'css/');
	define("ru_js", 	ru .'js/');
	define("ru_img", 	ru .'images/');
	define("ru_fancybox", 	ru .'fancybox/');

	define("ru_media",		ru .'media/');
	
	
	define("ru_dir", 	$_SERVER['DOCUMENT_ROOT'] ."/" . SiteFolder);	

	define("ru_inc",  	ru_dir .'inc/');
	define("ru_common",	ru_dir .'common/');	
	define("RU_PROCESS",	ru .'process/');	
	define("dir_media",	ru_dir .'media/');
	
/****************Local********************/
	define("ACSQL_DB_USER", 'flashbag_iftgift');			// <-- mysql db user
	define("ACSQL_DB_PASSWORD", 'mx;k-}&%xf5O');		// <-- mysql db password
	define("ACSQL_DB_NAME", 'flashbag_iftgift');			// <-- mysql db name
	define("ACSQL_DB_HOST", 'localhost');				// <-- mysql server host	
	

	// ==================================================================
	//	ACSQL Constants
	define("ACSQL_VERSION","1");
	define("OBJECT","OBJECT",true);
	define("ARRAY_A","ARRAY_A",true);
	define("ARRAY_N","ARRAY_N",true);
	define("distance","50");

	//==================================================================
	
	define("WEBSITE_TITLE","OnlineSafe.co");
	define("WEBSITE_Meta_Keywords","OnlineSafe,OnlineSafe,OnlineSafe");
	define("WEBSITE_Meta_Description", "This is OnlineSafe.co ");
	define("LOGO","images/Original_512.png");
// ==================================================================

	class db {

		var $debug_called;
		var $vardump_called;
		var $show_errors = true;

		// ==================================================================
		//	DB Constructor - connects to the server and selects a database

		function db()
		{

			$this->dbh = @mysql_connect(ACSQL_DB_HOST,ACSQL_DB_USER,ACSQL_DB_PASSWORD);

			if ( ! $this->dbh )
			{
				$this->print_error("<ol><b>Error establishing a database connection!</b><li>Are you sure you have the correct user/password?<li>Are you sure that you have typed the correct hostname?<li>Are you sure that the database server is running?</ol>");
			}


			$this->select(ACSQL_DB_NAME);
            return $this->dbh;
		}

		// ==================================================================
		//	Select a DB (if another one needs to be selected)

		function select($db)
		{
			if ( !@mysql_select_db($db,$this->dbh))
			{
				$this->print_error("<ol><b>Error selecting database <u>$db</u>!</b><li>Are you sure it exists?<li>Are you sure there is a valid database connection?</ol>");
			}
		}

		// ====================================================================
		//	Format a string correctly for safe insert under all PHP conditions

		function escape($str)
		{
			return mysql_escape_string(stripslashes($str));
		}

		// ==================================================================
		//	Print SQL/DB error.

		function print_error($str = "")
		{

			// All erros go to the global error array $ACSQL_ERROR..
			global $ACSQL_ERROR;

			// If no special error string then use mysql default..
			if ( !$str ) $str = mysql_error();

			// Log this error to the global array..
			$ACSQL_ERROR[] = array
							(
								"query" => $this->last_query,
								"error_str"  => $str
							);

			// Is error output turned on or not..
			if ( $this->show_errors )
			{
				// If there is an error then take note of it
				print "<blockquote><font face=arial size=2 color=ff0000>";
				print "<b>SQL/DB Error --</b> ";
				print "[<font color=000077>$str</font>]";
				print "</font></blockquote>";
			}
			else
			{
				return false;
			}

		}

		// ==================================================================
		//	Turn error handling on or off..

		function show_errors()
		{
			$this->show_errors = true;
		}

		function hide_errors()
		{
			$this->show_errors = false;
		}

		// ==================================================================
		//	Kill cached query results

		function flush()
		{

			// Get rid of these
			$this->last_result = null;
			$this->col_info = null;
			$this->last_query = null;

		}

		// ==================================================================
		//	Basic Query	- see docs for more detail

		function query($query)
		{

			// Flush cached values..
			$this->flush();

			// Log how the function was called
			$this->func_call = "\$db->query(\"$query\")";

			// Keep track of the last query for debug..
			$this->last_query = $query;

			// Perform the query via std mysql_query function..
			$this->result = mysql_query($query,$this->dbh);

			// If there was an insert, delete or update see how many rows were affected
			// (Also, If there there was an insert take note of the insert_id
			$query_type = array("insert","delete","update");

			// loop through the above array
			foreach ( $query_type as $word )
			{

				// This is true if the query starts with insert, delete or update
				if ( preg_match("/$word /i",$query) )
				{
					$this->rows_affected = mysql_affected_rows();

					// This gets the insert ID
					if ( $word == "insert" )
					{
						$this->insert_id = mysql_insert_id($this->dbh);
					}

					$this->result = false;
				}

			}

			if ( mysql_error() )
			{

				// If there is an error then take note of it..
				$this->print_error();

			}
			else
			{

				// In other words if this was a select statement..
				if ( $this->result )
				{

					// =======================================================
					// Take note of column info

					$i=0;
					while ($i < @mysql_num_fields($this->result))
					{
						$this->col_info[$i] = @mysql_fetch_field($this->result);
						$i++;
					}

					// =======================================================
					// Store Query Results

					$i=0;
					while ( $row = @mysql_fetch_object($this->result) )
					{

						// Store relults as an objects within main array
						$this->last_result[$i] = $row;

						$i++;
					}

					// Log number of rows the query returned
					$this->num_rows = $i;

					@mysql_free_result($this->result);


					// If there were results then return true for $db->query
					if ( $i )
					{
						return true;
					}
					else
					{
						return false;
					}

				}
				else
				{
					// Update insert etc. was good..
					return true;
				}
			}
		}

		// ==================================================================
		//	Get one variable from the DB - see docs for more detail

		function get_var($query=null,$x=0,$y=0)
		{

			// Log how the function was called
			$this->func_call = "\$db->get_var(\"$query\",$x,$y)";

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// Extract var out of cached results based x,y vals
			if ( $this->last_result[$y] )
			{
				$values = array_values(get_object_vars($this->last_result[$y]));
			}

			// If there is a value return it else return null
			return (isset($values[$x]) && $values[$x]!=='')?$values[$x]:null;
		}

		// ==================================================================
		//	Get one row from the DB - see docs for more detail

		function get_row($query=null,$output=OBJECT,$y=0)
		{

			// Log how the function was called
			$this->func_call = "\$db->get_row(\"$query\",$output,$y)";

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// If the output is an object then return object using the row offset..
			if ( $output == OBJECT )
			{
				return $this->last_result[$y]?$this->last_result[$y]:null;
			}
			// If the output is an associative array then return row as such..
			elseif ( $output == ARRAY_A )
			{
				return $this->last_result[$y]?get_object_vars($this->last_result[$y]):null;
			}
			// If the output is an numerical array then return row as such..
			elseif ( $output == ARRAY_N )
			{
				return $this->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
			}
			// If invalid output type was specified..
			else
			{
				$this->print_error(" \$db->get_row(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N");
			}

		}

		// ==================================================================

		//	Function to get 1 column from the cached result set based in X index
		// se docs for usage and info

		function get_col($query=null,$x=0)
		{

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// Extract the column values
			for ( $i=0; $i < count($this->last_result); $i++ )
			{
				$new_array[$i] = $this->get_var(null,$x,$i);
			}

			return $new_array;
		}

		// ==================================================================
		// Return the the query as a result set - see docs for more details

		function get_results($query=null, $output = OBJECT)
		{

			// Log how the function was called
			$this->func_call = "\$db->get_results(\"$query\", $output)";

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// Send back array of objects. Each row is an object
			if ( $output == OBJECT )
			{
				return $this->last_result;
			}
			elseif ( $output == ARRAY_A || $output == ARRAY_N )
			{
				if ( $this->last_result )
				{
					$i=0;
					foreach( $this->last_result as $row )
					{

						$new_array[$i] = get_object_vars($row);

						if ( $output == ARRAY_N )
						{
							$new_array[$i] = array_values($new_array[$i]);
						}

						$i++;
					}

					return $new_array;
				}
				else
				{
					return null;
				}
			}
		}


		// ==================================================================
		// Function to get column meta data info pertaining to the last query
		// see docs for more info and usage

		function get_col_info($info_type="name",$col_offset=-1)
		{

			if ( $this->col_info )
			{
				if ( $col_offset == -1 )
				{
					$i=0;
					foreach($this->col_info as $col )
					{
						$new_array[$i] = $col->{$info_type};
						$i++;
					}
					return $new_array;
				}
				else
				{
					return $this->col_info[$col_offset]->{$info_type};
				}

			}

		}


		// ==================================================================
		// Dumps the contents of any input variable to screen in a nicely
		// formatted and easy to understand way - any type: Object, Var or Array

		function vardump($mixed)
		{

			echo "<blockquote><font color=000090>";
			echo "<pre><font face=arial>";

			if ( ! $this->vardump_called )
			{
				echo "<font color=800080><b>ACSQL</b> (v".ACSQL_VERSION.") <b>Variable Dump..</b></font>\n\n";
			}

			$var_type = gettype ($mixed);
			print_r(($mixed?$mixed:"<font color=red>No Value / False</font>"));
			echo "\n\n<b>Type:</b> " . ucfirst($var_type) . "\n";
			echo "<b>Last Query:</b> ".($this->last_query?$this->last_query:"NULL")."\n";
			echo "<b>Last Function Call:</b> " . ($this->func_call?$this->func_call:"None")."\n";
			echo "<b>Last Rows Returned:</b> ".count($this->last_result)."\n";
			echo "</font></pre></font></blockquote><font size=1 face=arial color=aaaaaa>www.armeniansingles.com</font>";
			echo "\n<hr size=1 noshade color=dddddd>";

			$this->vardump_called = true;

		}

		// Alias for the above function
		function dumpvar($mixed)
		{
			$this->vardump($mixed);
		}


		function get_rows_count($query=null, $output = OBJECT)
		{

			// Log how the function was called
			$this->func_call = "\$db->get_rows_count(\"$query\", $output)";

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// Send back array of objects. Each row is an object
			if ( $output == OBJECT )
			{
				return $this->count(last_result);
			}
			elseif ( $output == ARRAY_A || $output == ARRAY_N )
			{
				if ( $this->last_result )
				{
					$i=0;
					foreach( $this->last_result as $row )
					{

						$new_array[$i] = get_object_vars($row);

						if ( $output == ARRAY_N )
						{
							$new_array[$i] = array_values($new_array[$i]);
						}

						$i++;
					}

					return count($new_array);
				}
				else
				{
					return null;
				}
			}
		}

		// ==================================================================
		// Displays the last query string that was sent to the database & a
		// table listing results (if there were any).
		// (abstracted into a seperate file to save server overhead).

		function debug()
		{

			echo "<blockquote>";

			// Only show ACSQL credits once..
			if ( ! $this->debug_called )
			{
				echo "<font color=800080 face=arial size=2><b>ACSQL</b> (v".ACSQL_VERSION.") <b>Debug..</b></font><p>\n";
			}
			echo "<font face=arial size=2 color=000099><b>Query --</b> ";
			echo "[<font color=000000><b>$this->last_query</b></font>]</font><p>";

				echo "<font face=arial size=2 color=000099><b>Query Result..</b></font>";
				echo "<blockquote>";

			if ( $this->col_info )
			{

				// =====================================================
				// Results top rows

				echo "<table cellpadding=5 cellspacing=1 bgcolor=555555>";
				echo "<tr bgcolor=eeeeee><td nowrap valign=bottom><font color=555599 face=arial size=2><b>(row)</b></font></td>";


				for ( $i=0; $i < count($this->col_info); $i++ )
				{
					echo "<td nowrap align=left valign=top><font size=1 color=555599 face=arial>{$this->col_info[$i]->type} {$this->col_info[$i]->max_length}</font><br><font size=2><b>{$this->col_info[$i]->name}</b></font></td>";
				}

				echo "</tr>";

				// ======================================================
				// print main results

			if ( $this->last_result )
			{

				$i=0;
				foreach ( $this->get_results(null,ARRAY_N) as $one_row )
				{
					$i++;
					echo "<tr bgcolor=ffffff><td bgcolor=eeeeee nowrap align=middle><font size=2 color=555599 face=arial>$i</font></td>";

					foreach ( $one_row as $item )
					{
						echo "<td nowrap><font face=arial size=2>$item</font></td>";
					}

					echo "</tr>";
				}

			} // if last result
			else
			{
				echo "<tr bgcolor=ffffff><td colspan=".(count($this->col_info)+1)."><font face=arial size=2>No Results</font></td></tr>";
			}

			echo "</table>";

			} // if col_info
			else
			{
				echo "<font face=arial size=2>No Results</font>";
			}

			echo "</blockquote></blockquote><font size=1 face=arial color=aaaaaa>www.ratetome.com</font><hr noshade color=dddddd size=1>";


			$this->debug_called = true;
		}


	}
	$db = new db();



function encodeURL($string)
{
	
	$string = str_replace('  ',' ', $string);
	$string = str_replace(' ','_', $string);
	//$new_string = @ereg_replace("[^A-Za-z0-9_-]", "", $string );
	$new_string = preg_replace('/^[\-]+/', '-', $string);
	$new_string = preg_replace('/[\-]+$/', '-', $new_string);
	$new_string = preg_replace('/[\-]{2,}/', '-', $new_string);
	$new_string = str_replace('__','-', $new_string);
	$new_string = str_replace('__','-', $new_string);
	return $new_string;
}

$StateArray = array("Alabama"  => "AL", "Alaska"  => "AK", "Arizona"  => "AZ", "Arkansas"  => "AR", "California"  => "CA", "Colorado"  => "CO", "Columbia"  => "DC", "Connecticut"  => "CT", "Delaware"  => "DE", "Florida"  => "FL", "Georgia"  => "GA", "Hawaii"  => "HI", "Idaho"  => "ID", "Illinois"  => "IL", "Indiana"  => "IN", "Iowa"  => "IA", "Kansas"  => "KS", "Kentucky"  => "KY", "Louisiana"  => "LA", "Maine"  => "ME", "Maryland"  => "MD", "Massachusetts"  => "MA", "Michigan"  => "MI", "Minnesota"  => "MN", "Mississippi"  => "MS", "Missouri"  => "MO", "Montana"  => "MT", "Nebraska"  => "NE", "Nevada"  => "NV", "New Hampshire"  => "NH", "New Jersey"  => "NJ", "New Mexico"  => "NM", "New York"  => "NY", "North Carolina"  => "NC", "North Dakota"  => "ND", "Ohio"  => "OH", "Oklahoma"  => "OK", "Oregon"  => "OR", "Pennsylvania"  => "PA", "Rhode Island"  => "RI", "South Carolina"  => "SC", "South Dakota"  => "SD", "Tennessee"  => "TN", "Texas"  => "TX", "Utah"  => "UT", "Vermont"  => "VT", "Virginia"  => "VA", "Washington"  => "WA", "West Virginia"  => "WV", "Wisconsin"  => "WI", "Wyoming"  => "WY");
$StateAbArray = array("AL" => "Alabama", "AK" => "Alaska" , "AZ" => "Arizona" ,  "AR" => "Arkansas",  "CA" => "California", "CO" => "Colorado" ,  "DC" => "Columbia",  "CT" => "Connecticut",  "DE" => "Delaware",  "FL" => "Florida", "GA" => "Georgia" , "HI" => "Hawaii" , "ID" => "Idaho" , "IL" => "Illinois" ,"IN"  => "Indiana" ,  "IA" => "Iowa",  "KS" => "Kansas", "KY" => "Kentucky" ,  "LA" => "Louisiana", "ME" => "Maine" , "MD" => "Maryland" , "MA" => "Massachusetts" , "MI" => "Michigan" ,  "MN" => "Minnesota", "MS" => "Mississippi" , "MO" => "Missouri" , "MT" => "Montana" ,  "NE" => "Nebraska", "NV" => "Nevada" ,  "NH" => "New Hampshire", "NJ" => "New Jersey" , "NM" => "New Mexico" , "NY" => "New York" , "NC" => "North Carolina" ,  "ND" => "North Dakota", "OH" => "Ohio" , "OK" => "Oklahoma" , "OR" => "Oregon" , "PA" => "Pennsylvania" ,  "RI" => "Rhode Island",  "SC" => "South Carolina", "SD" => "South Dakota" , "TN" => "Tennessee" ,  "TX" => "Texas","UT"  => "Utah" ,  "VT" => "Vermont", "VA" => "Virginia" , "WA" => "Washington" , "WV" => "West Virginia" , "WI" => "Wisconsin" , "WY" => "Wyoming" );
$StateCityArray = array("AL" => "Montgomery", "AK" => "Juneau" , "AZ" => "Phoenix" ,  "AR" => "Little Rock",  "CA" => "Sacramento", "CO" => "Denver" ,  "DC" => "Bogota",  "CT" => "Hartford",  "DE" => "Dover",  "FL" => "Tallahassee", "GA" => "Atlanta" , "HI" => "Honolulu" , "ID" => "Boise" , "IL" => "Springfield" ,"IN"  => "Indianapolis" ,  "IA" => "Des Moines",  "KS" => "Topeka", "KY" => "Frankfort" ,  "LA" => "Baton Rouge", "ME" => "Augusta" , "MD" => "Annapolis" , "MA" => "Boston" , "MI" => "Lansing" ,  "MN" => "Saint Paul", "MS" => "Jackson" , "MO" => "Jefferson City" , "MT" => "Helena" ,  "NE" => "Lincoln", "NV" => "Carson City" ,  "NH" => "Concord", "NJ" => "Trenton" , "NM" => "Santa Fe" , "NY" => "Albany" , "NC" => "Raleigh" ,  "ND" => "Bismarck", "OH" => "Ohio" , "OK" => "Oklahoma City" , "OR" => "Salem" , "PA" => "Harrisburg" ,  "RI" => "Providence",  "SC" => "Columbia", "SD" => "Pierre" , "TN" => "Nashville" ,  "TX" => "Austin","UT"  => "Salt Lake City" ,  "VT" => "Montpelier", "VA" => "Richmond" , "WA" => "Olympia" , "WV" => "Charleston" , "WI" => "Madison" , "WY" => "Cheyenne" );
	
	
	
function stateToAb($stFullname){

	global $StateAbArray;
	return $StateAbArray[$stFullname];
}

function abToState($stAbv){

	global $StateArray;
	return $StateArray[$stAbv];
}

function formatPhone($number)
{
    $number = preg_replace('/[^\d]/', '', $number);
	/*if(strpos($number,'0')===0){
		$number = substr($number, 1, strlen($number));
	}
	if(strpos($number,'62')===0){
		$number = substr($number, 2, strlen($number));
	}

	if(strpos($number,'1800')===0){
	    return substr($number, 0, 4) . '-' . substr($number, 4, 3) . '-' . substr($number, 7,3);
	}
	elseif(strpos($number,'1300')===0){
	    return substr($number, 0, 4) . '-' . substr($number, 4, 3) . '-' . substr($number, 7,3);
	}
	elseif(strpos($number,'13')===0){
	    return substr($number, 0, 3) . '-' . substr($number, 3, 3);
	}
	elseif(strpos($number,'4')===0){
		return '';
	}
	else{*/
		if(strlen($number)==10){
		    return "(".substr($number, 0, 3) . ')' . substr($number, 3, 3) . '-' . substr($number, 6,4);
		}
	//}
	return '';
}

function formatMobile($number)
{
    $number = preg_replace('/[^\d]/', '', $number);
	if(strpos($number,'0')===0){
		$number = substr($number, 1, strlen($number));
	}
	if(strpos($number,'62')===0){
		$number = substr($number, 2, strlen($number));
	}

	if(strpos($number,'4')===0){
	    return '0'.substr($number, 0, 3) . '-' . substr($number, 3, 3) . '-' . substr($number, 6,3);
	}
	return '';
}

function specialCharStr($str)
{
	$str = str_replace('’',"'",$str);
	$str = str_replace('“','"',$str);
	$str = str_replace('”','"',$str);
	return $str;
}

function getMeta($name,$id)
{
	$wp_posts_qry = mysql_query("select * from wp_usermeta where meta_key = '".$name."' and user_id = '".$id."'");
	$wp_posts_row = mysql_fetch_array($wp_posts_qry);
	return $wp_posts_row['meta_value'];
}
function getProfilePic($authorID,$ru)
{
	$extensions_array = array('png','jpg','gif');
	foreach ($extensions_array as $image_extension) {
		$path_fragment = $ru.'blog/wp-content/profile-pics/' . $authorID . '.' . $image_extension;
		$path_to_check = 'blog/wp-content/profile-pics/' . $authorID . '.' . $image_extension;
		$flg = true;
		if ( file_exists($path_to_check) ) { 
			$path = $path_fragment;
			$flg = false;
			break;
		}
	}
	if($flg)
		$path = $ru.'blog/wp-content/plugins/profile-pic/default.jpg';
	return $path;
}
function dateFormat($date)
{
	return date('M j, Y' , $date);
}
function pa($arr)
{
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}
//echo "<pre>";print_r($_SERVER);exit;
function businessLogo($Company_row,$ru)
{
	if(empty($Company_row['logo']))
	{
		$logo = $ru.'images/no-image-available.gif';
	}
	else
	{
		$logo = $ru.'media/'.$Company_row['locationid'].'/logo/thumb/'.$Company_row['logo'];
	}
	return $logo;
}

function companyRating($companyId)
{
	$StarRating = mysql_query("SELECT COUNT(rating) as totalRating, sum(rating) as SumRating FROM `business_reviews` where status = 1 and locationid = ".$companyId);
	if ( mysql_num_rows($StarRating) >0 ){
		$starRatingRow= mysql_fetch_array($StarRating);
		$totalRating =$starRatingRow['totalRating'];
		$SumRating =$starRatingRow['SumRating'];
		if ($totalRating)
		{
			$AvgRating = ceil( $SumRating/$totalRating);
			$ratingDetail['avg'] = $AvgRating;
			$ratingDetail['total'] = $totalRating;
        }else{
        	$ratingDetail['avg'] = 0;
			$ratingDetail['total'] = 0;
        }
	}else{
		$ratingDetail['avg'] = 0;
		$ratingDetail['total'] = 0;
	}
	return $ratingDetail;
}



define('timeZone' ,'Asia/Kuwait');

mysql_query (" SET time_zone =". timeZone);
date_default_timezone_set(timeZone);
ini_set('date.timezone',timeZone);

/********************************Check Authorized Domain********************************************/

function check_wildcard($card)
{
	$chk_domain = mysql_query("select * from ols_authdomain where domain = '".$card."' AND type='a'");
	if(mysql_num_rows($chk_domain) >0)
	{
		$view_domain = mysql_fetch_array($chk_domain);
		$domain = $view_domain['domain'];
		return true;
	} else {
		$chk_domains = mysql_query("select * from ols_authdomain where type='w'");
		while($wildcard=mysql_fetch_array($chk_domains))
		{
			$domains = $wildcard['domain'];
			$domains = str_replace("@","",$domains);
			$domains = str_replace(".","\.",$domains);
			$body = str_replace("*","[a-zA-Z0-9-]+",$domains);
			$regularexpression = "/(\@".$body.")/";
			if (preg_match($regularexpression,$card)){
			 return true;
			} else {
				return false;
			}
		}
		
	}
}

/********************************Check Authorized Domain********************************************/
?>