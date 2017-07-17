<?php
include "../includes/settings.php";
include "../includes/class_call_one_file.php";

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
/* special ajax here */
 	if($_POST)
  	{
  		if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
  		{  
  			$user_msg = messagedisplay("The Validation code does not match!", 2);
			$type = 2;
			$message = array('message' => $user_msg, 'type' => $type);	
		}
		else
		{
			/*$user_msg = messagedisplay("Registration Successfull.", 1);
			$type = 1;
			$message = array('message' => $user_msg, 'type' => $type);*/

	  		$name = $_REQUEST['name'];
			$email = $_REQUEST['email'];
			$country_code = $_REQUEST['country_code'];
			$phone = $_REQUEST['phone'];
			$password = $_REQUEST['password'];
			$user_type = '2';  //for user

	  		$name_value = array('name' => rep($name), 'email' => rep($email), 'country_code' => $country_code, 'phone' => rep($phone), 'password' => md5($password), 'user_type' => $user_type );

	  		$email_verification_code = md5(rand());
			$name_value['email_verification_code'] = $email_verification_code;

			$message = $user->user_add_using_ajax($name_value, "Registration successful. Please check your email for a verification link. Email may take up to 30 minutes. Still haven't received it? Please check the junk mailbox.", "Sorry, nothing is added.", "Sorry, email is already added. Please use another email.", "Sorry, Phone number is already added. Please use another phone number.");

			if($message['type']==1)
			{

				$email_verification_link = Site_Url.'email_verification_link.php?code='.$email_verification_code;

				$user_type_array = array('2' => 'User');

				$body = '<tr>
			                    <td colspan="4" style="padding: 30px 21px 0">
			                        <h3 style="font-size:30px;font-weight:700;color:#1596ed;margin:10px 0;">Dear '.$name.',</h3>
			                        <p>Your account has been successfully created as '.$user_type_array[$user_type].'.</p>
								    <p>Please <a href="'.$email_verification_link.'">click here</a> to verify your email or directly open the below link.</p>
								    <p>'.$email_verification_link.'</p>
								    <p>Login details has been given below.</p>
								    <p>Website Url: '.Site_Url.'</p>
								    <p>Username: '.$email.'</p>
								    <p>Password: '.$password.'</p>
								    <p><br><br>Thank you,<br>'.Site_Title.' Team</p>
			                    </td>
			                </tr>';

			      
				$mail_body = get_email_layout($body);

			    $to = $email;
			    $subject = Site_Title.": Profile Creation Confirmation";
			    $mail = new PHPMailer;
			    $mail->FromName =Site_Title;
			    $mail->From    =Admin_Sending_Email_Id;
			    $mail->Subject = $subject;    
			    $mail->IsHTML(true);
			    $mail->Body = $mail_body;
			    $mail->AltBody = "Alternate text";
			    $mail->AddAddress($to,'Admin');
			    $mail->Send();
			    $mail->ClearAddresses();
			    $mail->ClearAttachments();
			}

		}
		echo json_encode($message);
	}
}
?>