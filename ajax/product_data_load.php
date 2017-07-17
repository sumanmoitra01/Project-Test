<?php
include "../includes/settings.php";
include "../includes/class_call_one_file.php";

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
/* special ajax here */
 	if($_POST)
  	{
		$product_id = $_POST['product_id'];
		$product_array = $product_module->product_display($db->tbl_pre . "product_tbl", array(), "WHERE id=" . $product_id . "");
		$product_json_array = array();
		$product_json_array['product_id'] = $product_array[0]['id'];
		$product_json_array['product_name'] = $product_array[0]['product_name'];
		if($product_array[0]['product_image2'] && file_exists(Site_Path."/uploads/".$product_array[0]['product_image2']))
		{
			$product_json_array['product_image2'] = SITE_URL."timthumb.php?src=".SITE_URL."uploads/".$product_array[0]['product_image2']."&w=138&h=64&zc=3";
		}
		else
		{
			$product_json_array['product_image2'] = "";
		}

		if($product_array[0]['product_image1'] && file_exists(Site_Path."/uploads/".$product_array[0]['product_image1']))
		{
			$product_json_array['product_image1'] = SITE_URL."timthumb.php?src=".SITE_URL."uploads/".$product_array[0]['product_image1']."&w=300&h=194&zc=3";
		}
		else
		{
			$product_json_array['product_image1'] = "";
		}

		$product_json_array['product_description'] = $product_array[0]['product_description'];

		$quantitywise_price_array = $product_module->product_display($db->tbl_pre . "quantitywise_price_tbl", array(), "WHERE product_id=" . $product_id . "");

		$product_json_array['price_range'] = $quantitywise_price_array;

		echo json_encode($product_json_array);
	}
}
?>