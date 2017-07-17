<?php
include "../includes/settings.php";
include "../includes/class_call_one_file.php";

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
/* special ajax here */
 	if($_POST)
  	{
		$email = $_REQUEST['email'];

  		 // Username Check //
	    $user_login_username_sql = $db->query("select * from " . $db->tbl_pre . "users_tbl where email='" . $email . "' and user_type='2'", PDO::FETCH_BOTH);  //email is used as username, '3'=>'influencer', '4'=>'business'
	    $user_login_username_num = $db->total($user_login_username_sql);

	    if ($user_login_username_num != 0)
	    {
	      $user_login_row = $db->result($user_login_username_sql);

	      $db->delete("password_reset_code_tbl", "user_id='" . $user_login_row[0]['id'] . "'");
	      $code = md5(rand());
	      $password_reset_array = array('user_id'=>$user_login_row[0]['id'], 'code'=>$code);

	      $db->insert('password_reset_code_tbl', $password_reset_array);

	      $password_reset_link = Site_Url.'password_reset_link.php?code='.$code;

	      $body = '<tr>
	                    <td colspan="4" style="padding: 30px 21px 0">
	                        <h3 style="font-size:30px;font-weight:700;color:#1596ed;margin:10px 0;">Dear '.Site_Title.' User,</h3>
	                        <p>Please <a href="'.$password_reset_link.'">click here</a> to reset your password. or directly open the below link.</p><p>'.$password_reset_link.'<br><br></p><p>Thank you,<br>'.Site_Title.' Team</p>
	                    </td>
	                </tr>';

	      

		  $mail_body = get_email_layout($body);

	      $to = $email;
	      $subject=Site_Title.": Password Reset Link";
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
	         
	      $user_msg = messagedisplay("A password reset link has been sent to your email.", 1);
	      $message_array = array('message' => $user_msg, 'type' => '1');

	    }
	    else
	    {
	      $user_msg = messagedisplay("This email id is not registerd with this site. Please enter correct email id.", 2);
	      $message_array = array('message' => $user_msg, 'type' => '2');
	    }

		$message = $message_array;
		echo json_encode($message);
	}
}
?>