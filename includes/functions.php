<?php
// Mysql Filter //
function filter($var) {
	if (get_magic_quotes_gpc()) $var = stripslashes($var);
	return trim($var);
}
// Function To Replace Illegal Characters //
function rep($ab) {
	$ab = str_replace("'", "''", $ab);
	$ab = str_replace("\'", "'", $ab);
	return $ab;
}
function rep_excel($ab) {
	$ab = str_replace("\u0000", "", $ab);
	$ab = str_replace("\'", "'", $ab);
	return $ab;
}
function rep_b($ab) {
	$ab = str_replace("''", "'", $ab);
	$ab = str_replace("\'", "'", $ab);
	return $ab;
}
function repc($ab) {
	$ab = stripslashes($ab);
	$ab = str_replace("''", "'", $ab);
	return $ab;
}
function rep_title($ab) {
	$ab = str_replace("''", "&quot;", $ab);
	return $ab;
}
// Date Time Function //
function date_time_format($date_time, $flag= 1) {
	global $db;
	$unx_stamp = strtotime($date_time);
	$date_str  = "";
	$date_format=$db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=4", PDO::FETCH_BOTH));
	switch ($date_format[0][0]) {
						//2004-06-29
		case 1:
		$date_str  = (date("Y-m-d", $unx_stamp));
		break;
		case 2:
		$date_str = (date("m-d-Y", $unx_stamp));
		break;
						//06-29-2004
		case 3:
		$date_str = (date("d-m-Y", $unx_stamp));
		break;
						//29-06-2004
		case 4:
		$date_str = (date("d", $unx_stamp) . ' ' . date("M", $unx_stamp) . ' ' . date("Y", $unx_stamp));
		break;
						//29 Jun 2004
		case 5:
		$date_str = (date("d", $unx_stamp) . ' ' . date("F", $unx_stamp) . ' ' . date("Y", $unx_stamp));
		break;
						//29 June 2004
		case 6:
		$date_str = (date("M", $unx_stamp) . ' ' . date("d", $unx_stamp) . ' ' . date("Y", $unx_stamp));
		break;
						//Jun 29,2004
		case 7:
		$date_str = (date("D M dS, Y", $unx_stamp));
		break;
						//Tue Jun 29th,2004
		case 8:
		$date_str = (date("l M jS, Y", $unx_stamp));
		break;
						//Tuesday Jun 29th,2004
		case 9:
		$date_str = (date("l F jS, Y", $unx_stamp));
		break;
						//Tuesday June 29th,2004
		case 10:
		$date_str = (date("d F Y l", $unx_stamp));
		break;
						//29 June 2004 Tuesday
		case 11:
		$date_str = (date("m/d/Y", $unx_stamp));
		break;
						//29 June 2004 Tuesday
	}
	$time_str = "";
	$time_format=$db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=5", PDO::FETCH_BOTH));
	switch ($time_format[0][0]) {
		case 1:
		$time_str = (date("h:i a", $unx_stamp));
		break;
						//06:20 pm
		case 2:
		$time_str = (date("h:i A", $unx_stamp));
		break;
						//06:20 PM
		case 3:
		$time_str = (date("H:i", $unx_stamp));
		break;
						//18:20
	}

	switch ($flag) {
		case 1:
		return ($date_str);
		break;
		case 2:
		return ($time_str);
		break;
		case 3:
		return ($date_str . " " . $time_str);
		break;
		default:
		return ($date_str);
		break;
	}
}
function date_time_difference($time1, $time2, $start     = 4, $end       = 6) {
		// If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
		$time1     = strtotime($time1);
	}
	if (!is_int($time2)) {
		$time2     = strtotime($time2);
	}
		// If time1 is bigger than time2
		// Then swap time1 and time2
	if ($time1 > $time2) {
		$ttime     = $time1;
		$time1     = $time2;
		$time2     = $ttime;
	}
		// Set up intervals and diffs arrays
	$intervals = array(
		'year',
		'month',
		'day',
		'hour',
		'minute',
		'second'
		);
	$diffs     = array();
		// Loop thru all intervals
	foreach ($intervals as $interval) {
				// Create temp time from time1 and interval
		$ttime     = strtotime('+1 ' . $interval, $time1);
				// Set initial values
		$add       = 1;
		$looped    = 0;
				// Loop until temp time is smaller than time2
		while ($time2 >= $ttime) {
						// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime("+" . $add . " " . $interval, $time1);
			$looped++;
		}
		$time1 = strtotime("+" . $looped . " " . $interval, $time1);
		$diffs[$interval]       = $looped;
	}
	$count = 0;
	$times = array();
		// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
		$count++;
				// Add value and interval
				// if value is bigger than 0
		if ($value > 0 && $count >= $start && $count <= $end) {
						// Add value and interval to times array
			if ($interval == 'hour') {
				$timeh    = $value * 60 * 60;
			}
			if ($interval == 'minute') {
				$timem    = $value * 60;
			}
			if ($interval == 'second') {
				$times    = $value;
			}
		}
	}
	$times    = $timeh + $timem + $times;
		// Return string with times
	return $times;
}
function dateDiff($dformat, $endDate, $beginDate) {
	$date_parts1 = explode($dformat, $beginDate);
	$date_parts2 = explode($dformat, $endDate);
	$start_date  = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
	$end_date    = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
	return $end_date - $start_date;
}
// Password Encription //
function random_number($len  = 8) {
	$temp = mt_rand(1, 15500);
	$temp = md5($temp);
	$temp = substr($temp, 0, $len);
	$temp = strtoupper($temp);
	return $temp;
}
function encode($text) {
	$text = random_number(3) . base64_encode($text);
	$text = base64_encode($text);
	return $text;
}
function decode($text) {
	$text = base64_decode($text);
	$text = substr($text, 3);
	$text = base64_decode($text);
	return $text;
}
// Generate Guid
function NewGuid($len      = 8) {
	$s        = strtoupper(md5(uniqid(rand() , true)));
	$guidText = substr($s, 0, $len);
	return $guidText;
}
// Auto Generate Password //
function generatePassword($l     = 8, $c     = 0, $n     = 0, $s     = 0) {
		// get count of all required minimum special chars
	$count = $c + $n + $s;
		// sanitize inputs; should be self-explanatory
	if (!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
		trigger_error('Argument(s) not an integer', E_USER_WARNING);
		return false;
	} 
	elseif ($l < 0 || $l > 20 || $c < 0 || $n < 0 || $s < 0) {
		trigger_error('Argument(s) out of range', E_USER_WARNING);
		return false;
	} 
	elseif ($c > $l) {
		trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
		return false;
	} 
	elseif ($n > $l) {
		trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
		return false;
	} 
	elseif ($s > $l) {
		trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
		return false;
	} 
	elseif ($count > $l) {
		trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
		return false;
	}
		// all inputs clean, proceed to build password
		// change these strings if you want to include or exclude possible password characters
	$chars = "abcdefghijklmnopqrstuvwxyz";
	$caps  = strtoupper($chars);
	$nums  = "123456789";
	$syms  = "!@#$%^&*?";
		// build the base password of all lower-case letters
	for ($i     = 0;$i < $l;$i++) {
		$out.= substr($chars, mt_rand(0, strlen($chars) - 1) , 1);
	}
		// create arrays if special character(s) required
	if ($count) {
				// split base password to array; create special chars array
		$tmp1 = str_split($out);
		$tmp2 = array();
				// add required special character(s) to second array
		for ($i    = 0;$i < $c;$i++) {
			array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1) , 1));
		}
		for ($i = 0;$i < $n;$i++) {
			array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1) , 1));
		}
		for ($i = 0;$i < $s;$i++) {
			array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1) , 1));
		}
				// hack off a chunk of the base password array that's as big as the special chars array
		$tmp1 = array_slice($tmp1, 0, $l - $count);
				// merge special character(s) array with base password array
		$tmp1 = array_merge($tmp1, $tmp2);
				// mix the characters up
		shuffle($tmp1);
				// convert to string for output
		$out = implode('', $tmp1);
	}
	return $out;
}
// Message Display//
function messagedisplay($var  = "", $mode = 3) {
	switch ($mode) {
		case 1:
		$var  = " <div class='alert alert-success alert-dismissable'>".
		"<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>".
		"<h4><i class='icon fa fa-check'></i> Alert!</h4>" . $var . "</div> ";
						//Success
		break;
		case 2:
		$var = " <div class='alert alert-danger alert-dismissable'>".
		"<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>".
		"<h4><i class='icon fa fa-ban'></i> Alert!</h4>" . $var . "</div> ";
						//Error
		break;
		case 3:
		$var = " <div class='alert alert-warning alert-dismissable'>".
		"<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>".
		"<h4><i class='icon fa fa-warning'></i> Alert!</h4>" . $var . "</div> ";
						//Message
		break;
		case 4:
		$var = " <div class='alert alert-danger alert-dismissable'>".
		"<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>".
		"<h4><i class='icon fa fa-ban'></i> Alert!</h4>" . $var . "</div> ";
						//Critical
		break;
		default:
		$var = " <div class='alert alert-warning alert-dismissable'>".
		"<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>".
		"<h4><i class='icon fa fa-warning'></i> Alert!</h4>" . $var . "</div> ";
						//Message
		break;
	}
	return $var;
}
// General Function //
function array_push_assoc($array, $key, $value) {
	$array[$key] = $value;
	return $array;
}
function string_limit_words($string, $word_limit) {
	$string  = strip_tags(str_replace("&nbsp;", " ", repc($string)));
	if (!empty($string)) {
		$words   = @explode(' ', $string);
		$sho_wor = @implode(' ', @array_slice($words, 0, $word_limit));
		if (strlen($sho_wor) <= $word_limit) {
			return $sho_wor;
		} 
		else {
			$sho_wor1 = substr($sho_wor, 0, $word_limit);
			return $sho_wor1;
		}
	}
}
function check_login($redirect) {
	if ($_SESSION['user_login'] != "success" && $_SESSION['user_login'] == "") {
		$_SESSION['frontend_msg'] = messagedisplay("Error: Please login to access this page!", 2);
		echo "<script>window.location.href='".Site_Url."?redirect_url=".$redirect."'</script>";
		exit();
	}
}
function get_string_between($string, $start, $end) {
	$string = " " . $string;
	$ini    = strpos($string, $start);
	if ($ini == 0) return "";
	$ini+= strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}
function word_wrap_pass($message) {
	$wrapAt     = 15;
	$tempText   = '';
	$finalText  = '';
	$curCount   = $tempCount  = 0;
	$longestAmp = 19;
	$inTag      = false;
	$ampText    = '';
	$len        = strlen($message);
	for ($num        = 0;$num < $len;$num++) {
		$curChar = $message{$num};
		if ($curChar == '<') {
			for ($snum    = 0;$snum < strlen($ampText);$snum++) {
				addWrap($ampText{$snum}, $ampText{$snum + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			}
			$ampText = '';
			$tempText.= '<';
			$inTag = true;
		} 
		elseif ($inTag && $curChar == '>') {
			$tempText.= '>';
			$inTag = false;
		} 
		elseif ($inTag) {
			$tempText.= $curChar;
		} 
		elseif ($curChar == '&') {
			for ($snum = 0;$snum < strlen($ampText);$snum++) {
				addWrap($ampText{$snum}, $ampText{$snum + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			}
			$ampText = '&';
		} 
		elseif (strlen($ampText) < $longestAmp && $curChar == ';' && function_exists('html_entity_decode') && (strlen(html_entity_decode("$ampText;")) == 1 || preg_match('/^&#[0-9]+$/', $ampText))) {
			addWrap($ampText . ';', $message{$num + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			$ampText = '';
		} 
		elseif (strlen($ampText) >= $longestAmp || $curChar == ';') {
			for ($snum    = 0;$snum < strlen($ampText);$snum++) {
				addWrap($ampText{$snum}, $ampText{$snum + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			}
			addWrap($curChar, $message{$num + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			$ampText = '';
		} 
		elseif (strlen($ampText) != 0 && strlen($ampText) < $longestAmp) {
			$ampText.= $curChar;
		} 
		else {
			addWrap($curChar, $message{$num + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
		}
	}
	return $finalText . $tempText;
}
function addWrap($curChar, $nextChar, $maxChars, &$finalText, &$tempText, &$curCount, &$tempCount) {
	$wrapProhibitedChars = "([{!;,\\/:?}])";
	if ($curChar == ' ' || $curChar == "\n") {
		$finalText.= $tempText . $curChar;
		$tempText = '';
		$curCount = 0;
		$curChar  = '';
	} 
	elseif ($curCount >= $maxChars) {
		$finalText.= $tempText . ' ';
		$tempText = '';
		$curCount = 1;
	} 
	else {
		$tempText.= $curChar;
		$curCount++;
	}
		// the following code takes care of (unicode) characters prohibiting non-mandatory breaks directly before them.
		// $curChar isn't a " " or "\n"
	if ($tempText != '' && $curChar != '') {
		$tempCount++;
	}
		// $curChar is " " or "\n", but $nextChar prohibits wrapping.
	elseif (($curCount == 1 && strstr($wrapProhibitedChars, $curChar) !== false) || ($curCount == 0 && $nextChar != '' && $nextChar != ' ' && $nextChar != "\n" && strstr($wrapProhibitedChars, $nextChar) !== false)) {
		$tempCount++;
	}
		// $curChar and $nextChar aren't both either " " or "\n"
	elseif (!($curCount == 0 && ($nextChar == ' ' || $nextChar == "\n"))) {
		$tempCount = 0;
	}
	if ($tempCount >= $maxChars && $tempText == '') {
		$finalText.= '&nbsp;';
		$tempCount = 1;
		$curCount  = 2;
	}
	if ($tempText == '' && $curCount > 0) {
		$finalText.= $curChar;
	}
}


function current_url()
{
	$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
	if ($_SERVER["SERVER_PORT"] != "80")
	{
	    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else 
	{
	    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function autop($str) {
    $arr=explode("\n",$str);
    $out='';

    for($i=0;$i<count($arr);$i++) {
        if(strlen(trim($arr[$i]))>0)
            $out.='<p>'.trim($arr[$i]).'</p>';
    }
    return $out;
}

function get_user_rating($user_id)
{
	global $db;
	$reviews_array = $db->result($db->query("select count(*) as total_count,sum(rating) as total_rating from " . $db->tbl_pre . "reviews_tbl rt," . $db->tbl_pre . "contract_tbl ct where rt.contract_id=ct.id and ct.influencer_id='".$user_id."'", PDO::FETCH_BOTH));

	$average_rating = $reviews_array[0]['total_rating']/$reviews_array[0]['total_count'];

	$rating_percentage = $average_rating*100/5;
	return $rating_percentage;
}

function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).' trillion';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' billion';
        elseif ($n > 1000000) return round(($n/1000000), 2).' million';
        elseif ($n > 1000) return round(($n/1000), 2).'k';

        return number_format($n);
}
?>