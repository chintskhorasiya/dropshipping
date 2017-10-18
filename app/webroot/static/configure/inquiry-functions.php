<?php 
/****************************************
	Inquiry Functions
*****************************************/

function get_inquiries()
{
	
	//$sql = "select * from product_enquiries where en_product_id > 0 order by pr_en_created_date desc";
	//$sql = "select * from product_enquiries, product_enquiries_meta where en_enquiry_id = pr_en_id order by pr_en_created_date desc";
	$sql = "select * from product_enquiries group by pr_en_user_id,en_product_id order by pr_en_created_date asc";
	$results = get_results($sql);
	return $results;
}

/*
function get_inquiries()
{
	$store_id  = $_SESSION['ADMIN_STORE_ID'];
	//$sql = "select * from product_enquiries, product_enquiries_meta where en_store_id = ".$store_id." and en_enquiry_id = pr_en_id order by pr_en_created_date desc";
	
	$sql = "select * from product_enquiries where en_store_id = ".$store_id." order by pr_en_created_date desc";
	$results = get_results($sql);
	return $results;
}
*/
function get_myenquiries_meta_msg($enquiry_id,$product_id,$store_id)
{
  $sql = "select * from product_enquiries_meta where en_enquiry_id =".$enquiry_id." and en_product_id=".$product_id." and en_store_id=".$store_id." order by pr_en_meta_created_date desc ";
	$results = get_results($sql);
	return $results;
}
/*function get_myenquiries_msg($enquiry_id,$product_id,$store_id)
{
	$sql = "select * from product_enquiries where pr_en_id =".$enquiry_id." and en_product_id=".$product_id." and en_store_id=".$store_id." order by pr_en_created_date desc";
	$results = get_results($sql);
	return $results;
}*/
function get_myenquiries_msg($user_id,$product_id,$store_id)
{
	$sql = "select * from product_enquiries where pr_en_user_id =".$user_id." and en_product_id=".$product_id." and en_store_id=".$store_id." order by pr_en_created_date asc";
	$results = get_results($sql);
	return $results;
}
function get_myenquiries_details($enquiry_id)
{
	$sql = "select * from product_enquiries where pr_en_id =".$enquiry_id." order by pr_en_created_date desc";
	$results = get_row($sql);
	return $results;
}
?>