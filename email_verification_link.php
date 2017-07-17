<?php
include("header.php");

$code = $_REQUEST['code'];
$email_verification_sql = $db->query("select * from " . $db->tbl_pre . "users_tbl where email_verification_code='" . $code . "'");
$total = $db->total($email_verification_sql);
if($total==1)
{
	$email_verification_result = $db->result($email_verification_sql);
	$user_array = array('email_verification_status'=>'1', 'email_verification_code'=>'', 'status'=>'1');
	$db->update('users_tbl', $user_array, "id='" . $email_verification_result[0]['id'] . "'");

	$_SESSION['user_msg'] = messagedisplay("Email verification successful. Please log in",1);
}
else
{
	$_SESSION['user_msg'] = messagedisplay("This code is expired.",2);
}

echo "<script>window.location.href='".Site_Url."'</script>";
?>