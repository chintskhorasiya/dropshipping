<?php
/****************************************
	Notification Functions
*****************************************/
function get_notification()
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select * from notification where notification_read = 0 and notification_user = 1 and notification_user_id=".$user_id;
	$results = get_results($sql);
	return $results;
}
function get_notification_detail($id)
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select * from notification where notification_user = 1 and notification_id =".$id." and notification_user_id =".$user_id;
	$results = get_row($sql);
	return $results;
}
function get_count_notification($id)
{
//	$user_id  = $_SESSION['ADMIN_ID'];
	// take by default $user_id == 0
	$sql = "select COUNT(*) as total from notification WHERE notification_read = 0 AND  notification_user = 1 AND notification_type = ".$id;
	$results = get_row($sql);
	return $results['total'];
}
function get_count_order_notification($id,$type='COD')
{
//	$user_id  = $_SESSION['ADMIN_ID'];
	// take by default $user_id == 0
	
	if($type == 'COD')
	{
		$type = 'order_pay_by = 501';
	}
	else
	{
		$type = 'order_pay_by != 501';
	}
	
	$sql = "select COUNT(*) as total from notification,orders WHERE order_id = notification_order_id and ".$type." and notification_read = 0 AND  notification_user = 1 AND notification_type = ".$id;
	$results = get_row($sql);
	return $results['total'];
}
function get_count_store_support_notification($id)
{
	$sql = "select COUNT(*) as total from notification WHERE notification_read = 0 AND  notification_user = 1 AND notification_type = ".$id;
	$results = get_row($sql);
	return $results['total'];
}
function get_task_not($id)
{
	//$user_id  = $_SESSION['ADMIN_ID'];
	//$sql = "select * from notification where notification_read = 0 and notification_user = 1 and notification_type = ".$id." and notification_user_id = 0";
	$sql = "select * from notification where notification_read = 0 and notification_user = 1 and notification_type = ".$id;
	$results = get_results($sql);
	return $results;
}
function get_task_store_support_not($id)
{
	//$user_id  = $_SESSION['ADMIN_ID'];
	//$sql = "select * from notification where notification_read = 0 and notification_user = 1 and notification_type = ".$id." and notification_user_id = 0";
	$sql = "select * from notification where notification_read = 0 and notification_user = 1 and notification_type = ".$id;
	$results = get_results($sql);
	return $results;
}
function get_task_not_order($id)
{
	$sql = "select * from notification where notification_read = 0 and notification_user = 1 and notification_type = ".$id;
	$results = get_results($sql);
	return $results;
}
function get_review_not($id)
{
	$sql = "select * from product_reviews where pr_id = ".$id;
	$results = get_results($sql);
	return $results;
}
function get_reviewer_name($id)
{
	$sql = "select store_username from store WHERE store_id = ".$id;
	
	$results = get_row($sql);
	return $results['store_username'];
}
function get_destrireviewer_name($id)
{
	$sql = "select user_full_name from distributor WHERE user_id = ".$id;
	
	$results = get_row($sql);
	return $results['user_full_name'];
}
function get_proreviewer_name($id)
{
	$sql = "select user_name from users WHERE user_id = ".$id;
	
	$results = get_row($sql);
	return $results['user_name'];
}
function get_stock_not($limit=5)
{
	$user_id  = $_SESSION['ADMIN_ID'];
		
 	$sql = "select product_id,product_name,product_qty from products where product_qty <= 5 limit ".$limit;
	$results = get_results($sql);
	return $results;
}
function get_stock_notif()
{
	$user_id  = $_SESSION['ADMIN_ID'];
		
 	$sql = "select * from products where product_qty <= 5 and product_store=".$user_id;
	$results = get_results($sql);
	return $results;
}
function get_allstock_notif()
{
//	$user_id  = $_SESSION['ADMIN_ID'];
		
 	$sql = "select * from products where product_qty <= 5 ";
	$results = get_results($sql);
	return $results;
}
function get_count_stocknot()
{
	$user_id  = $_SESSION['ADMIN_ID'];
		
	$sql = "select COUNT(*) as total from products WHERE product_qty <= 5 AND product_store=".$user_id;
	
	$results = get_row($sql);
	return $results['total'];
}
function get_count_stocknotif()
{
	$user_id  = $_SESSION['ADMIN_ID'];
		
	$sql = "select COUNT(*) as total from products WHERE product_qty <= 5 ";
	
	$results = get_row($sql);
	return $results['total'];
}
function get_message_not($id)
{
	$user_id  = $_SESSION['ADMIN_ID'];
	
	$sql = "select * from adminsupport where adminsupport_from =".$user_id." and adminsupport_id=".$id;
	$results = get_results($sql);
	return $results;
}
function get_message_notif($id)
{
	//$user_id  = $_SESSION['ADMIN_ID'];
	
	$sql = "select * from adminsupport where adminsupport_to = 0 and adminsupport_id=".$id;
	$results = get_results($sql);
	return $results;
}
/*
function get_parent_subject_not($id)
{
	$sql = "select * from notification where notification_read = 0 and notification_product_id =".$id;
	$results = get_results($sql);
	return $results;
}
*/
function get_parent_subject_not($id)
{
	$sql = "select COUNT(*) as totals from notification where notification_read = 0 and notification_product_id =".$id;
	$results = get_row($sql);
	return $results['totals'];
}
function get_inquery_notif($id)
{
//	$user_id  = $_SESSION['ADMIN_ID'];
	
	 $sql = "select * from product_enquiries_meta where en_meta_id =".$id." order by pr_en_meta_created_date desc limit 5";
		$results = get_results($sql);
	return $results;
}
function get_product_notif($id)
{
	 $sql = "select * from products where product_id =".$id." order by product_created_date desc limit 5";
		$results = get_results($sql);
	return $results;
}
function get_products_not($id)
{
		 $sql = "select * from products where product_id =".$id;
		$results = get_results($sql);
	return $results;
	
}
function get_destribute_notif($id)
{
	 $sql = "select * from distributor where user_id =".$id." order by user_created_date desc limit 5";
		$results = get_results($sql);
	return $results;
}
function get_distributor_notify($id)
{
		$sql = "select * from distributor where user_id =".$id;
		$results = get_results($sql);
	return $results;
}

?>