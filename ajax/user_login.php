<?php
include "../includes/settings.php";
include "../includes/class_call_one_file.php";

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
/* special ajax here */
 	if($_POST)
  	{

		$email = $_REQUEST['email'];
		$password = $_REQUEST['password'];

		if($_REQUEST['remember_me']==1)
		{
			setcookie("user_email", $email, time() + COOKIE_EXPIRE, "/"); 
			setcookie("user_pass", $password, time() + COOKIE_EXPIRE, "/");
			setcookie("user_remember", '1', time() + COOKIE_EXPIRE, "/");
		}
		else
		{
			setcookie("user_email", null, -1, "/");
			setcookie("user_pass", null, -1, "/");
			setcookie("user_remember", null, -1, "/");
		}

		$name_value = array('email' => rep($email), 'password' => $password);
		$message = $user->user_login($name_value, "Login successfull, You will be redirect to your profile page soon..", "Sorry, your account is inactive, please contact site administrator.", "Sorry, email or password may be wrong");
		echo json_encode($message);

	}
}
?>