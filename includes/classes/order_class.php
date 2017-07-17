<?php
class helper_order {
	var $recperpage;
	var $url;
	var $order_status;
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
	function order_add($order_array, $order_success_message, $order_unsuccess_message) {
		
			$order_add=$this->db->insert('order_tbl', $order_array);
			if ($order_add['affectedRow'] > 0) {
				$order_id = $order_add['insertedId'];
				
				// Upload Artwork File//
		        if ($_FILES['artwork_file_path']['size'] > 0) {
		            $original = Site_Path."/uploads/";
		            $rand = rand();
		            $artwork_file_path_name = $_FILES['artwork_file_path']['name'];
		            $artwork_file_path_tmp = $_FILES['artwork_file_path']['tmp_name'];
		            $artwork_file_path_size = $_FILES['artwork_file_path']['size'];
		            $artwork_file_path_type = $_FILES['artwork_file_path']['type'];

		            $artwork_file_path_name_saved = str_replace("&", "and", $rand . "_" . $artwork_file_path_name);
		            $artwork_file_path_name_saved = str_replace(" ", "_", $rand . "_" . $artwork_file_path_name);
		            $artwork_file_path_img = $original . "" . $artwork_file_path_name_saved;
		            move_uploaded_file($artwork_file_path_tmp, $artwork_file_path_img);
		            //image upload
		            $this->db->update("order_tbl", array('artwork_file_path' => ($artwork_file_path_name_saved)), "id='" . $order_id . "'");
		        }

		        return $order_id;
				// Success Message For Insert a New Special Feature //
				/*$_SESSION['order_msg'] = messagedisplay($order_success_message, 1);
				//header('Location: thankyou.php'); 
				echo "<script>window.location.href='payment.php'</script>";  */          //thankyou.php
				exit();
			} else {
				// Message For Nothing Insert //
				//$_SESSION['order_msg'] = messagedisplay($order_unsuccess_message, 3);
				return false;
				exit();
			}
	}
	// Special Feature Duplicate Check Function //
	function order_check($order_id = '',$order_email_address) {
		// Check Duplicate Special Feature Name //
		$order_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "order_tbl where email='" . rep($order_email_address) . "' and id!='" . $order_id . "'");
		return $this->db->total($order_duplicate_check_sql);
	}
	// Special Feature Edit Function //
	function order_edit($order_array, $order_id, $order_success_message, $order_unsuccess_message) {
			$order_update=$this->db->update('order_tbl', $order_array, "id='" . $order_id . "'");
			
			if ($order_update['affectedRow'] > 0 || $order_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Special Feature //
				$_SESSION['order_msg'] = messagedisplay($order_success_message, 1);
				header('Location:' . $_SESSION['order_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['order_msg'] = messagedisplay($order_unsuccess_message, 3);
				header('Location:' . $_SESSION['order_manage_url']);
				exit();
			}
	}
	// Special Feature Display Function //
	function order_display($sTable='', $aColumns='', $sWhere='', $sLimit='', $sOrder='') {
		$order_query=array( 'tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$order_sql = $this->db->select($order_query);
		$order_array = $this->db->result($order_sql);
		return $order_array;
	}
	// Special Feature Status Update Function //
	function order_status_update($order_page_url) {
		$order_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive'){
			$order_status = '1';
		} else{
			$order_status = '0';
		}
		$this->db->update('order_tbl', array('status' => ($order_status)), "id='" . $order_id . "'");
		$_SESSION['order_msg'] = messagedisplay('Sub order Status is updated successfully', 1);
		header('Location: ' . $order_page_url);
		exit();
	}
	// Special Feature Delete Function //
	function order_delete($order_page_url) {
		$order_id = $_REQUEST['cid'];
		$order_delete=$this->db->delete("order_tbl", "id='" . $order_id . "'");
		//$order_delete=$this->db->delete("orderistrator_permission_tbl", "id='" . $order_id . "'");
		if($order_delete['affectedRow']>0){
			$_SESSION['order_msg'] = messagedisplay('Sub order details deleted successfully', 1);
		}
		else {
			$_SESSION['order_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('Location: ' . $order_page_url);
		exit();
	}
}
?>