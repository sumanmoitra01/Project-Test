<?php
class helper_admin {
	var $recperpage;
	var $url;
	var $admin_status;
	var $db;
	function __construct() {
		global $recperpage;
		global $url;
		global $db;
		$this->recperpage = $recperpage;
		$this->url = $url;
		$this->db = $db;
	}
	// Special Feature Add Function //
	function admin_add($admin_array, $admin_success_message, $admin_unsuccess_message, $admin_duplicate_message) {
		$admin_duplicate_check_num = $this->admin_check('',$admin_array['email']);
		if ($admin_duplicate_check_num == 0) {
			$admin_add=$this->db->insert('users_tbl', $admin_array);
			if ($admin_add['affectedRow'] > 0) {
				$admin_id = $admin_add['insertedId'];
				// Insert Permission //
				/*$permission_count=count($_REQUEST['permission']);
				for($ac=0;$ac<$permission_count;$ac++){
					if($_REQUEST['permission'][$ac]!=''){
						$permission_array = array('id' => rep($admin_id), 'permission_id' => rep($_REQUEST['permission'][$ac]));
						$this->db->insert('administrator_permission_tbl', $permission_array);
					}
				}*/
				// Success Message For Insert a New Special Feature //
				$_SESSION['admin_msg'] = messagedisplay($admin_success_message, 1);
				header('Location: add_sub_admin.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['admin_msg'] = messagedisplay($admin_unsuccess_message, 3);
			}
		} else {
			$_SESSION['admin_msg'] = messagedisplay($admin_duplicate_message, 2);
		}
	}
	// Special Feature Duplicate Check Function //
	function admin_check($admin_id = '',$admin_email_address) {
		// Check Duplicate Special Feature Name //
		$admin_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "users_tbl where email='" . rep($admin_email_address) . "' and id!='" . $admin_id . "'");
		return $this->db->total($admin_duplicate_check_sql);
	}
	// Special Feature Edit Function //
	function admin_edit($admin_array, $admin_id, $admin_success_message, $admin_unsuccess_message, $admin_duplicate_message) {
		$admin_duplicate_check_num = $this->admin_check($admin_id,$admin_array['email']);
		if ($admin_duplicate_check_num == 0) {
			$admin_update=$this->db->update('users_tbl', $admin_array, "id='" . $admin_id . "'");
			/*$this->db->delete("administrator_permission_tbl", "id='" . $admin_id . "'");
			$permission_count=count($_REQUEST['permission']);
			for($ac=0;$ac<$permission_count;$ac++){
				if($_REQUEST['permission'][$ac]!=''){
					$permission_array = array('id' => rep($admin_id), 'permission_id' => rep($_REQUEST['permission'][$ac]));
					$this->db->insert('administrator_permission_tbl', $permission_array);
				}
			}*/
			if ($admin_update['affectedRow'] > 0 || $admin_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Special Feature //
				$_SESSION['admin_msg'] = messagedisplay($admin_success_message, 1);
				header('Location:' . $_SESSION['admin_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['admin_msg'] = messagedisplay($admin_unsuccess_message, 3);
				header('Location:' . $_SESSION['admin_manage_url']);
				exit();
			}
		} else {
			$_SESSION['admin_msg'] = messagedisplay($admin_duplicate_message, 2);
			header('Location:' . $_SESSION['admin_manage_url']);
			exit();
		}
	}
	// Special Feature Display Function //
	function admin_display($sTable='', $aColumns='', $sWhere='', $sLimit='', $sOrder='') {
		$admin_query=array( 'tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$admin_sql = $this->db->select($admin_query);
		$admin_array = $this->db->result($admin_sql);
		return $admin_array;
	}
	// Special Feature Status Update Function //
	function admin_status_update($admin_page_url) {
		$admin_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive'){
			$admin_status = '1';
		} else{
			$admin_status = '0';
		}
		$this->db->update('users_tbl', array('status' => ($admin_status)), "id='" . $admin_id . "'");
		$_SESSION['admin_msg'] = messagedisplay('Sub admin Status is updated successfully', 1);
		header('Location: ' . $admin_page_url);
		exit();
	}
	// Special Feature Delete Function //
	function admin_delete($admin_page_url) {
		$admin_id = $_REQUEST['cid'];
		$admin_delete=$this->db->delete("users_tbl", "id='" . $admin_id . "'");
		//$admin_delete=$this->db->delete("administrator_permission_tbl", "id='" . $admin_id . "'");
		if($admin_delete['affectedRow']>0){
			$_SESSION['admin_msg'] = messagedisplay('Sub admin details deleted successfully', 1);
		}
		else {
			$_SESSION['admin_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('Location: ' . $admin_page_url);
		exit();
	}
}
?>