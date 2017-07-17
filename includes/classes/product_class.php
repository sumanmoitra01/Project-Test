<?php

class helper_product {

	var $recperpage;

	var $url;

	var $product_status;

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

	function product_add($product_array, $product_success_message, $product_unsuccess_message, $product_duplicate_message) {

		$product_duplicate_check_num = $this->product_check('',$product_array['product_name']);

		if ($product_duplicate_check_num == 0) {

			$product_add=$this->db->insert('product_tbl', $product_array);

			if ($product_add['affectedRow'] > 0) {

				$product_id = $product_add['insertedId'];



				// Upload Product Image1 //

		        if ($_FILES['product_image1']['size'] > 0) {

		            $original = Site_Path."/uploads/";

		            $rand = rand();

		            $product_image1_name = $_FILES['product_image1']['name'];

		            $product_image1_tmp = $_FILES['product_image1']['tmp_name'];

		            $product_image1_size = $_FILES['product_image1']['size'];

		            $product_image1_type = $_FILES['product_image1']['type'];



		            $product_image1_name_saved = str_replace("&", "and", $rand . "_" . $product_image1_name);

		            $product_image1_name_saved = str_replace(" ", "_", $rand . "_" . $product_image1_name);

		            $product_image1_img = $original . "" . $product_image1_name_saved;

		            move_uploaded_file($product_image1_tmp, $product_image1_img);

		            //image upload

		            $this->db->update("product_tbl", array('product_image1' => ($product_image1_name_saved)), "id='" . $product_id . "'");

		        }



		        // Upload Product Image2 //

		        if ($_FILES['product_image2']['size'] > 0) {

		            $original = Site_Path."/uploads/";

		            $rand = rand();

		            $product_image2_name = $_FILES['product_image2']['name'];

		            $product_image2_tmp = $_FILES['product_image2']['tmp_name'];

		            $product_image2_size = $_FILES['product_image2']['size'];

		            $product_image2_type = $_FILES['product_image2']['type'];



		            $product_image2_name_saved = str_replace("&", "and", $rand . "_" . $product_image2_name);

		            $product_image2_name_saved = str_replace(" ", "_", $rand . "_" . $product_image2_name);

		            $product_image2_img = $original . "" . $product_image2_name_saved;

		            move_uploaded_file($product_image2_tmp, $product_image2_img);

		            //image upload

		            $this->db->update("product_tbl", array('product_image2' => ($product_image2_name_saved)), "id='" . $product_id . "'");

		        }



		        // Insert Quantitywise Price //

		        $quantitywise_price_count=count($_REQUEST['quantity_from']);

		        for($ac=0; $ac < $quantitywise_price_count; $ac++){

		          if($_REQUEST['quantity_from'][$ac]!=''){

		            $quantitywise_price_array = array('product_id' => rep($product_id), 'quantity_from' => rep($_REQUEST['quantity_from'][$ac]), 'quantity_to' => rep($_REQUEST['quantity_to'][$ac]), 'price' => rep($_REQUEST['price'][$ac]));

		            $this->db->insert('quantitywise_price_tbl', $quantitywise_price_array);

		          }

		        }

				

				// Success Message For Insert a New Special Feature //

				$_SESSION['product_msg'] = messagedisplay($product_success_message, 1);

				header('Location: add_product.php');

				exit();

			} else {

				// Message For Nothing Insert //

				$_SESSION['product_msg'] = messagedisplay($product_unsuccess_message, 3);

			}

		} else {

			$_SESSION['product_msg'] = messagedisplay($product_duplicate_message, 2);

		}

	}

	// Special Feature Duplicate Check Function //

	function product_check($product_id = '',$product_name) {

		// Check Duplicate Special Feature Name //

		$product_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "product_tbl where product_name='" . rep($product_name) . "' and id!='" . $product_id . "'");

		return $this->db->total($product_duplicate_check_sql);

	}

	// Special Feature Edit Function //

	function product_edit($product_array, $product_id, $product_success_message, $product_unsuccess_message, $product_duplicate_message) {

		$product_duplicate_check_num = $this->product_check($product_id,$product_array['email']);

		if ($product_duplicate_check_num == 0) {



			$product_update=$this->db->update('product_tbl', $product_array, "id='" . $product_id . "'");



			// Update Product Image1 //

	        if ($_FILES['product_image1']['size'] > 0) {

	          $original = Site_Path."/uploads/";

	          $rand = rand();

	          $product_image1_name = $_FILES['product_image1']['name'];

	          $product_image1_tmp = $_FILES['product_image1']['tmp_name'];

	          $product_image1_size = $_FILES['product_image1']['size'];

	          $product_image1_type = $_FILES['product_image1']['type'];

	          $product_image1 = $this->product_display($this->db->tbl_pre . "product_tbl", array('product_image1'), "WHERE id='" . $product_id . "'");

	          unlink($original . '' . $product_image1[0]['product_image1']);

	          $product_image1_name_saved = str_replace("&", "and", $rand . "_" . $product_image1_name);

	          $product_image1_name_saved = str_replace(" ", "_", $rand . "_" . $product_image1_name);

	          $product_image1_img = $original . "" . $product_image1_name_saved;

	          move_uploaded_file($product_image1_tmp, $product_image1_img);

	          //image upload

	          $product_update = $this->db->update("product_tbl", array('product_image1' => ($product_image1_name_saved)), "id='" . $product_id . "'");

	        }



	        // Update Product Image2 //

	        if ($_FILES['product_image2']['size'] > 0) {

	          $original = Site_Path."/uploads/";

	          $rand = rand();

	          $product_image2_name = $_FILES['product_image2']['name'];

	          $product_image2_tmp = $_FILES['product_image2']['tmp_name'];

	          $product_image2_size = $_FILES['product_image2']['size'];

	          $product_image2_type = $_FILES['product_image2']['type'];

	          $product_image2 = $this->product_display($this->db->tbl_pre . "product_tbl", array('product_image2'), "WHERE id='" . $product_id . "'");

	          unlink($original . '' . $product_image2[0]['product_image2']);

	          $product_image2_name_saved = str_replace("&", "and", $rand . "_" . $product_image2_name);

	          $product_image2_name_saved = str_replace(" ", "_", $rand . "_" . $product_image2_name);

	          $product_image2_img = $original . "" . $product_image2_name_saved;

	          move_uploaded_file($product_image2_tmp, $product_image2_img);

	          //image upload

	          $product_update = $this->db->update("product_tbl", array('product_image2' => ($product_image2_name_saved)), "id='" . $product_id . "'");

	        }



	         $quantitywise_price_edit = 1;



		      $this->db->delete("quantitywise_price_tbl", "product_id='" . $product_id . "'");

		      $quantitywise_price_count=count($_REQUEST['quantity_from']);

		        for($ac=0; $ac < $quantitywise_price_count; $ac++){

		          if($_REQUEST['quantity_from'][$ac]!=''){

		            $quantitywise_price_array = array('product_id' => rep($product_id), 'quantity_from' => rep($_REQUEST['quantity_from'][$ac]), 'quantity_to' => rep($_REQUEST['quantity_to'][$ac]), 'price' => rep($_REQUEST['price'][$ac]));

		            $this->db->insert('quantitywise_price_tbl', $quantitywise_price_array);

		          }

		        }

			

			if ($product_update['affectedRow'] > 0 || $quantitywise_price_edit==1) {

				// Success Message For Update a Existing Special Feature //

				$_SESSION['product_msg'] = messagedisplay($product_success_message, 1);

				header('Location:' . $_SESSION['product_manage_url']);

				exit();

			} else {

				// Message For Nothing Update //

				$_SESSION['product_msg'] = messagedisplay($product_unsuccess_message, 3);

				header('Location:' . $_SESSION['product_manage_url']);

				exit();

			}

		} else {

			$_SESSION['product_msg'] = messagedisplay($product_duplicate_message, 2);

			header('Location:' . $_SESSION['product_manage_url']);

			exit();

		}

	}

	// Special Feature Display Function //

	function product_display($sTable='', $aColumns='', $sWhere='', $sLimit='', $sOrder='') {

		$product_query=array( 'tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);

		$product_sql = $this->db->select($product_query);

		$product_array = $this->db->result($product_sql);

		return $product_array;

	}

	// Special Feature Status Update Function //

	function product_status_update($product_page_url) {

		$product_id = $_REQUEST['cid'];

		if ($_REQUEST['current_status'] == 'Inactive'){

			$product_status = '1';

		} else{

			$product_status = '0';

		}

		$this->db->update('product_tbl', array('status' => ($product_status)), "id='" . $product_id . "'");

		$_SESSION['product_msg'] = messagedisplay('Product Status is updated successfully', 1);

		header('Location: ' . $product_page_url);

		exit();

	}

	// Special Feature Delete Function //

	function product_delete($product_page_url) {

		$product_id = $_REQUEST['cid'];

		$product_delete=$this->db->delete("product_tbl", "id='" . $product_id . "'");

		//$product_delete=$this->db->delete("productistrator_permission_tbl", "id='" . $product_id . "'");

		if($product_delete['affectedRow']>0){

			$_SESSION['product_msg'] = messagedisplay('Product details deleted successfully', 1);

		}

		else {

			$_SESSION['product_msg'] = messagedisplay('Nothing is deleted successfully', 2);

		}

		header('Location: ' . $product_page_url);

		exit();

	}

}

?>