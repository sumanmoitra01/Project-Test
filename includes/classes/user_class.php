<?php
class helper_user{
	var $recperpage;
	var $url;
	var $user_status;
	var $user_name;
	var $db;
	var $mailsend;
	function __construct() {
		global $recperpage;
		global $url;
		global $db;
		global $mailsend;
		$this->recperpage = $recperpage;
		$this->url = $url;
		$this->db = $db;
		$this->mailsend = $mailsend;
	}
	// User Add Function //
	function user_add($user_array, $user_success_message, $user_unsuccess_message, $user_duplicate_message, $user_duplicate_phone_message) {

		$user_duplicate_check_num = $this->user_check('', $user_array['email']);
		if ($user_duplicate_check_num == 0) {

			$user_duplicate_phone_check_num = $this->user_phone_check('', $user_array['phone']);
			if ($user_duplicate_phone_check_num == 0) {

				$user_add=$this->db->insert('users_tbl', $user_array);
				if ($user_add['affectedRow'] > 0) {
					$user_id = $user_add['insertedId'];

					$email_verification_link = Site_Url.'email_verification_link.php?code='.$user_array['email_verification_code'];

					$body = '<tr>
				                    <td colspan="4" style="padding: 30px 21px 0">
				                        <h3 style="font-size:30px;font-weight:700;color:#1596ed;margin:10px 0;">Dear '.$_REQUEST['name'].',</h3>
				                        <p>Your account has been successfully created as user.</p>
									    <p>Please <a href="'.$email_verification_link.'">click here</a> to verify your email or directly open the below link.</p>
									    <p>'.$email_verification_link.'</p>
									    <p>Login details has been given below.</p>
									    <p>Website Url: '.Site_Url.'</p>
									    <p>Username: '.$_REQUEST['email'].'</p>
									    <p>Password: '.$_REQUEST['password'].'</p>
									    <p><br><br>Thank you,<br>'.Site_Title.' Team</p>
				                    </td>
				                </tr>';

				      
					$mail_body = get_email_layout($body);

				    $to = $user_array['email'];
				    $subject = Site_Title.": Profile Creation Confirmation";
				    $this->mailsend->FromName =Site_Title;
				    $this->mailsend->From    =Admin_Sending_Email_Id;
				    $this->mailsend->Subject = $subject;    
				    $this->mailsend->IsHTML(true);
				    $this->mailsend->Body = $mail_body;
				    $this->mailsend->AltBody = "Alternate text";
				    $this->mailsend->AddAddress($to,'Admin');
				    $this->mailsend->Send();
				    $this->mailsend->ClearAddresses();
				    $this->mailsend->ClearAttachments();
					
					// Success Message For add User //
					$_SESSION['user_msg'] = messagedisplay($user_success_message, 1);
					echo "<script>window.location.href='".$_SESSION['user_manage_url']."'</script>";
					exit();
				} else {
					// Message For Nothing Insert //
					$_SESSION['user_msg'] = messagedisplay($user_unsuccess_message, 3);
					echo "<script>window.location.href='".$_SESSION['user_manage_url']."'</script>";
				}
			}
			else 
			{
				$_SESSION['user_msg'] = messagedisplay($user_duplicate_phone_message, 2);
				echo "<script>window.location.href='".$_SESSION['user_manage_url']."'</script>";
			}
		} else {
			$_SESSION['user_msg'] = messagedisplay($user_duplicate_message, 2);
			echo "<script>window.location.href='".$_SESSION['user_manage_url']."'</script>";
		}
	}

	// User Add Function Using Ajax//
	function user_add_using_ajax($user_array, $user_success_message, $user_unsuccess_message, $user_duplicate_message, $user_duplicate_phone_message) {

		$user_duplicate_check_num = $this->user_check('', $user_array['email']);
		if ($user_duplicate_check_num == 0) {

			$user_duplicate_phone_check_num = $this->user_phone_check('', $user_array['phone']);
			if ($user_duplicate_phone_check_num == 0) {

				$user_add=$this->db->insert('users_tbl', $user_array);
				if ($user_add['affectedRow'] > 0) {
					$user_id = $user_add['insertedId'];
					
					$user_msg = messagedisplay($user_success_message, 1);
					$type = 1;
				} else {
					// Message For Nothing Insert //
					$user_msg = messagedisplay($user_unsuccess_message, 3);
					$type = 3;
				}
			}
			else 
			{
				$user_msg = messagedisplay($user_duplicate_phone_message, 2);
				$type = 2;
			}
		} else {
			$user_msg = messagedisplay($user_duplicate_message, 2);
			$type = 2;
		}

		$message_array = array('message' => $user_msg, 'type' => $type);

		return $message_array;
	}

	// User Duplicate Email Check Function //
	function user_check($user_id = '', $user_email) {
		// Check Duplicate User Name //
		$user_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "users_tbl where email='" . $user_email . "' and id!='" . $user_id . "'");
		return $this->db->total ($user_duplicate_check_sql);
	}

	// User Duplicate Phone Check Function //
	function user_phone_check($user_id = '', $phone) {
		// Check Duplicate User Name //
		$user_duplicate_phone_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "users_tbl where phone='" . $phone . "' and id!='" . $user_id . "'");
		return $this->db->total ($user_duplicate_phone_check_sql);
	}

	// User Edit Function //
	function user_edit($user_array, $user_id, $user_success_message, $user_unsuccess_message, $user_duplicate_message,$user_duplicate_phone_message) {
		$user_duplicate_check_num = $this->user_check($user_id, $user_array['email']);
		if ($user_duplicate_check_num == 0) {

			$user_duplicate_phone_check_num = $this->user_phone_check($user_id, $user_array['phone']);
			if ($user_duplicate_phone_check_num == 0) {

				if(is_array($user_array) && count($user_array) >0 )
		        {
		          $user_update=$this->db->update('users_tbl', $user_array, "id='" . $user_id . "'");
		        }

					if($_REQUEST['password'])
					{
						$body = '<tr>
				                    <td colspan="4" style="padding: 30px 21px 0">
				                        <h3 style="font-size:30px;font-weight:700;color:#1596ed;margin:10px 0;">Dear '.$_REQUEST['name'].',</h3>
				                        <p>Your login password has been changed successfully.</p>
									    <p>Login details has been given below.</p>
									    <p>Website Url: '.Site_Url.'</p>
									    <p>Username: '.$_REQUEST['email'].'</p>
									    <p>Password: '.$_REQUEST['password'].'</p>
									    <p><br><br>Thank you,<br>'.Site_Title.' Team</p>
				                    </td>
				                </tr>';

				        $mail_body = get_email_layout($body);

					    $to = $user_array['email'];
					    $subject = Site_Title.": Password change confirmation";
					    $this->mailsend->FromName =Site_Title;
					    $this->mailsend->From    =Admin_Sending_Email_Id;
					    $this->mailsend->Subject = $subject;    
					    $this->mailsend->IsHTML(true);
					    $this->mailsend->Body = $mail_body;
					    $this->mailsend->AltBody = "Alternate text";
					    $this->mailsend->AddAddress($to,'Admin');
					    $this->mailsend->Send();
					    $this->mailsend->ClearAddresses();
					    $this->mailsend->ClearAttachments();
					}

				// Update Profile Picture File //
		        /*if ($_FILES['profile_picture']['size'] > 0) {
		          $original = Site_Path."/uploads/";
		          $rand = rand();
		          $profile_picture_name = $_FILES['profile_picture']['name'];
		          $profile_picture_tmp = $_FILES['profile_picture']['tmp_name'];
		          $profile_picture_size = $_FILES['profile_picture']['size'];
		          $profile_picture_type = $_FILES['profile_picture']['type'];
		          $profile_picture = $this->user_display($this->db->tbl_pre . "users_tbl", array('profile_picture'), "WHERE id='" . $user_id . "'");
		          unlink($original . '' . $profile_picture[0]['profile_picture']);
		          $profile_picture_name_saved = str_replace("&", "and", $rand . "_" . $profile_picture_name);
		          $profile_picture_name_saved = str_replace(" ", "_", $rand . "_" . $profile_picture_name);
		          $profile_picture_img = $original . "" . $profile_picture_name_saved;
		          move_uploaded_file($profile_picture_tmp, $profile_picture_img);
		          //image upload
		          $user_update = $this->db->update("users_tbl", array('profile_picture' => ($profile_picture_name_saved)), "id='" . $user_id . "'");
		        }*/

				if ($user_update['affectedRow'] > 0) {
					// Success Message For Update a Existing User //
					$_SESSION['user_msg'] = messagedisplay($user_success_message, 1);
					//header('location:' . $_SESSION['user_manage_url']);
					echo "<script>window.location.href='".$_SESSION['user_manage_url']."'</script>";
					exit();
				} else {
					// Message For Nothing Update //
					$_SESSION['user_msg'] = messagedisplay($user_unsuccess_message, 3);
					//header('location:' . $_SESSION['user_manage_url']);
					echo "<script>window.location.href='".$_SESSION['user_manage_url']."'</script>";
					exit();
				}
			}
			else 
			{
				$_SESSION['user_msg'] = messagedisplay($user_duplicate_phone_message, 2);
				//header('location:' . $_SESSION['user_manage_url']);
				echo "<script>window.location.href='".$_SESSION['user_manage_url']."'</script>";
			}
		} else {
			$_SESSION['user_msg'] = messagedisplay($user_duplicate_message, 2);
			//header('location:' . $_SESSION['user_manage_url']);
			echo "<script>window.location.href='".$_SESSION['user_manage_url']."'</script>";
			exit();
		}
	}
	// User Display Function //
	function user_display($sTable, $aColumns, $sWhere, $sLimit, $sOrder) {
		$user_query=array( 'tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$user_sql = $this->db->select($user_query);
		$user_array = $this->db->result($user_sql);
		return $user_array;
	}

	function user_login($user_array, $user_login_success_message, $user_inactive_message, $user_login_error_message) {
		$user_login_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "users_tbl where email='" . $user_array['email'] . "' and password='" . md5($user_array['password']) . "' and user_type=2");
		$total_user = $this->db->total($user_login_check_sql);
		if($total_user==1)
		{
			$user_details = $this->db->result($user_login_check_sql);
			if($user_details[0]['status']==1)
			{
				$_SESSION['user_full_name'] = $user_details[0]['name'];
			    $_SESSION['user_id'] = $user_details[0]['id'];
			    $_SESSION['user_type'] = $user_details[0]['user_type'];
			    $_SESSION['user_login'] = "success";
				$user_msg = messagedisplay($user_login_success_message, 1);
				$type = 1;
			}
			else
			{
				$user_msg = messagedisplay($user_inactive_message, 3);
				$type = 3;
			}
		}
		else
		{
			$user_msg = messagedisplay($user_login_error_message, 2);
			$type = 2;
		}

		$message_array = array('message' => $user_msg, 'type' => $type);
		return $message_array;
	}

	// Special Feature Status Update Function //
	function user_status_update($user_page_url) {
		$user_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive'){
			$user_status = '1';
		} else{
			$user_status = '0';
		}
		$this->db->update('users_tbl', array('status' => ($user_status)), "id='" . $user_id . "'");
		$_SESSION['user_msg'] = messagedisplay('User Status is updated successfully', 1);
		header('Location: ' . $user_page_url);
		exit();
	}
	// Special Feature Delete Function //
	function user_delete($user_page_url) {
		$user_id = $_REQUEST['cid'];
		$user_delete=$this->db->delete("users_tbl", "id='" . $user_id . "'");
		//$user_delete=$this->db->delete("useristrator_permission_tbl", "id='" . $user_id . "'");
		if($user_delete['affectedRow']>0){
			$_SESSION['user_msg'] = messagedisplay('User details deleted successfully', 1);
		}
		else {
			$_SESSION['user_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('Location: ' . $user_page_url);
		exit();
	}

}
?>