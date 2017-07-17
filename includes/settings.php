<?php

session_start();

//error_reporting(E_ALL & ~E_NOTICE);

error_reporting(0);

include "functions.php";

include "functions_ext.php";

include "formatting.php";

include "classes/form.class.php";

include "classes/class.phpmailer.php";

include "classes/PaginationClass.php";

include "classes/class.query.extended.php";



include "classes/user_class.php";

include "classes/product_class.php";

include "classes/order_class.php";

include "classes/admin_class.php";

include "database_initial.php";

$db = new DB();

$db->connect($config);

$qryArray = array('tbl_name' => $db->tbl_pre . 'site_configuration_tbl', 'method' => PDO::FETCH_ASSOC);

$config = $db->select($qryArray);

$config_array = $db->result($config);

for ($row = 0; $row <= count($config_array); $row++) {

	define("" . str_replace(" ", "_", $config_array[$row]['site_configuration_name']) . "", $config_array[$row]['site_configuration_value']);

}



$site_url = Site_Url;

define("Site_Path", dirname(__DIR__) );

//$site_url="http://localhost:8888/TakeEvents/";

define("SITE_URL", $site_url);

define("COOKIE_EXPIRE", 60 * 60 * 24 * 100); //100 days by default

define("COOKIE_PATH", Site_Path); //Avaible in whole domain

if (Image_Resize_Crop == 'Yes') {

	$image_crop_zc = 1;

} else {

	$image_crop_zc = 2;

}





function get_email_layout($body)

{

	$email_layout = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

	<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>Crowd influencing</title>

	</head>

	<body style="padding: 0px; margin: 0px;">

	<table style="table-layout:fixed;" width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ebf3f6">
        
		<tr>
		  <td colspan="4" height="3" valign="top" style="height:3px;"><hr style="background-color: #1596ed; width: 100%; height: 3px; margin:0;"></td>
		</tr>
	  	<tr>

	        <td colspan="4" height="84" align="center" valign="middle" bgcolor="#f3fcff"><a href="'.Site_Url.'" target="_blank"><img src="'.Site_Url.'images/CrowdSync-Logo-Main.png" width="292" height="39" alt="logo" /></a></td>

	    </tr>'.

	    $body

	    .'<tr>

	        <td width="300" height="60" colspan="2" valign="middle" align="left" bgcolor="#1596ed" style="padding-left:12px;">

	            <a href="https://www.facebook.com/crowdsynctechnology" target="_blank"><img style="float:left;margin-right:4px;" src="'.Site_Url.'images/e_fb_icon.png" alt="Facebook"/></a>

	            <a href="https://twitter.com/crowdsyncled" target="_blank"><img style="float:left;margin-right:4px;" src="'.Site_Url.'images/e_twitter_icon.png" alt="Twitter"/></a>
	        </td>

	        <td width="300" height="60" colspan="2" valign="middle" align="right" bgcolor="#1596ed" style="padding-right:12px; color:#ffffff;">

	            <a style="font-size:14px;color:#ffffff;text-decoration:none;margin-right:12px;" href="'.Site_Url.'privacy-policy.php" target="_blank">Privacy Policy</a>   |   <a style="font-size:14px;color:#ffffff;text-decoration:none;margin-left:12px;" href="'.Site_Url.'terms-of-use.php" target="_blank">Terms of Use</a>

	        </td>

	    </tr>

	    <tr>

	    	<td width="600" height="44" colspan="4" valign="middle" align="center" bgcolor="#01395f">

	    	<span style="color:#d1d1d1;font-size:14px;">&copy; 2017 Crowdsync All Rights Reserved.</span>

	    	</td>

	    </tr>

	</table>



	</body>

	</html>';



	return $email_layout;



}

