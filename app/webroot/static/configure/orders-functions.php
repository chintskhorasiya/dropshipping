<?php 

/****************************************

	Orders Functions

*****************************************/

function get_orders()

{

	$sql = "select * from order_products order by op_id  desc";

	$results = get_results($sql);

	return $results;

}

function get_orders_cod($status = '')
{
	$where = '';
	if($status != '' )
	{
		$where = ' and op_order_status='.$status;
	}
	$sql = "select * from order_products where op_order_pay_by = 501 ".$where." order by op_id  desc";
	$results = get_results($sql);
	return $results;
}

function get_orders_online($status = '')

{

	$where = '';
	if($status != '' )
	{
		$where = ' and op_order_status='.$status;
	}

	$sql = "select * from order_products where op_order_pay_by != 501 ".$where." order by op_id  desc";

	$results = get_results($sql);

	return $results;

}

function get_orders_detail($id)

{

	$sql = "select * from orders where order_id=".$id;

	$results = get_row($sql);

	return $results;

}

function delete_order($id)

{

	$sql = "delete from orders where order_id=".$id;

	$results = db_query($sql);

	return true;

}

function get_orders_products($order_id)

{

	$sql = "select * from order_products where op_order_id = ".$order_id." order by op_id asc";

	$results = get_results($sql);

	return $results;

}

function get_orders_products_single($order_id)
{
	$sql = "select * from order_products where op_id = ".$order_id." order by op_id asc";
	$results = get_row($sql);
	return $results;
}

function get_orders_products_remarks($order_id)
{
	$sql = "select * from order_product_remarks where order_op_order_id = ".$order_id." order by order_remarks_id asc";
	$results = get_results($sql);
	return $results;
}

function get_unique_store_from_order($order_id)

{

	$sql = "select distinct(op_store_id) from order_products where op_order_id = ".$order_id." order by op_id asc";

	$results = get_results($sql);

	return $results;

}

function send_order_email_confirm_cod($op_id)
{

    	// Email to Stores

		$orders_products_detail = get_orders_products_single($op_id);
		 
		$order_id = $orders_products_detail['op_order_id'];
		$op_order_status = $orders_products_detail['op_order_status'];
		$order_detail = get_orders_detail($order_id);
		if($order_detail) 
		{
			$order_date   		  = $order_detail['order_date'];
			$order_date_sr		  = preg_replace('/-|:/', null, $order_date);
			
			$order_details 		  = $order_detail['order_details'];
			$order_status    	  = $order_detail['order_status'];
			$order_pay_by_id      = $order_detail['order_pay_by'];
			$order_details        = unserialize($order_details);
			$cart_details 		  = get_orders_products($order_id);
			$order_deposit_image  = $order_detail['order_deposit_image'];
			$order_pay_status     = $order_detail['order_pay_status'];
			
			
			
			$cart_detail 			= $orders_products_detail;
			$product_id 			= $cart_detail['op_product_id'];
			$product_detail 		= get_products_detail($product_id);
			$product_name 	 		= $product_detail['product_name'];
			$op_price				= $cart_detail['op_price'];
			$products_qty			= $cart_detail['op_qty'];
			$products_subtotal		= $cart_detail['op_sub_total'];
			$single_product_img		= explode(',',$product_detail['product_image']);
			$product_image   		= PRODUCTURL.$single_product_img[0];
			$productthumb_image 	= PRODUCT_THUMBURL.$single_product_img[0];
			
			$option_html = '<img src="'.$productthumb_image.'" alt="'.$product_name.'" width="100">';
			
			$product_store			= $product_detail['product_store'];
			$store_detail 			= get_store_detail($product_store);
			$store_processing_days  = $store_detail['U_STORE_PROCESSING_DAYS'];
			$store_delivery_days    = $store_detail['U_STORE_DELIVERY_DAYS'];
			
			$op_id = $cart_detail['op_id'];
			$op_store_discount = $cart_detail['op_store_discount'];
			$order_amount += $products_subtotal;
			
			$user_details   = get_user_detail($order_detail['order_customer']);
			
		}
		include('../email/cod_order_seller.php');
		 
		$subject = 'New order on Purchasekaro';

		// To send HTML mail, the Content-type header must be set

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'Bcc: vtshukla.b4s@gmail.com' . "\r\n";
 
		$store_email  = $store_detail['store_email'];
		mail($store_email, $subject, $html, $headers);
}
function send_order_email_confirm($op_id)
{

    	// Email to Stores

		$orders_products_detail = get_orders_products_single($op_id);
		 
		$order_id = $orders_products_detail['op_order_id'];
		$op_order_status = $orders_products_detail['op_order_status'];
		$order_detail = get_orders_detail($order_id);
		if($order_detail) 
		{
			$order_date   		  = $order_detail['order_date'];
			$order_date_sr		  = preg_replace('/-|:/', null, $order_date);
			
			$order_details 		  = $order_detail['order_details'];
			$order_status    	  = $order_detail['order_status'];
			$order_pay_by_id      = $order_detail['order_pay_by'];
			$order_details        = unserialize($order_details);
			$cart_details 		  = get_orders_products($order_id);
			$order_deposit_image  = $order_detail['order_deposit_image'];
			$order_pay_status     = $order_detail['order_pay_status'];
			
			
			
			$cart_detail 			= $orders_products_detail;
			$product_id 			= $cart_detail['op_product_id'];
			$product_detail 		= get_products_detail($product_id);
			$product_name 	 		= $product_detail['product_name'];
			$op_price				= $cart_detail['op_price'];
			$products_qty			= $cart_detail['op_qty'];
			$products_subtotal		= $cart_detail['op_sub_total'];
			$single_product_img		= explode(',',$product_detail['product_image']);
			$product_image   		= PRODUCTURL.$single_product_img[0];
			$productthumb_image 	= PRODUCT_THUMBURL.$single_product_img[0];
			
			$option_html = '<img src="'.$productthumb_image.'" alt="'.$product_name.'" width="100">';
			
			$product_store			= $product_detail['product_store'];
			$store_detail 			= get_store_detail($product_store);
			$store_processing_days  = $store_detail['U_STORE_PROCESSING_DAYS'];
			$store_delivery_days    = $store_detail['U_STORE_DELIVERY_DAYS'];
			
			$op_id = $cart_detail['op_id'];
			$op_store_discount = $cart_detail['op_store_discount'];
			$order_amount += $products_subtotal;
			
			$user_details   = get_user_detail($order_detail['order_customer']);
			
		}
		if($order_pay_by_id == 501){
			include('../email/cod_order_seller.php');
		}
		else
		{
			include('email/send_order_confirm.php');
		}
		
		 
		$subject = 'New order on Purchasekaro';

		// To send HTML mail, the Content-type header must be set

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'Bcc: vtshukla.b4s@gmail.com' . "\r\n";
 
		$store_email  = $store_detail['store_email'];
		mail($store_email, $subject, $html, $headers);
}

function get_cancelled_orders()
{
	$sql = "select * from order_products where op_product_status=9 order by op_id  desc";
	$results = get_results($sql);
	return $results;
}
function get_order_statuscount($order_status)
{
	 
	$sql = "select count(*) as total from order_products where op_product_status =".$order_status;
	$result = get_row($sql);
	return $result['total'];
}
function get_order_status($order_status)
{	
	$sql = "select * from order_products where op_product_status =".$order_status;
	$result = get_results($sql);
	return $result;
}

?>