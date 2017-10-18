<?php
/****************************************
	Support Functions
*****************************************/
function get_support_categories()
{
	$sql = "select * from customer_support where sup_status = 1";
	$results = get_results($sql);
	return $results;
}

function get_support_cat_detail($id)
{
	$sql = "select * from customer_support where sup_id=".$id;
	$results = get_row($sql);
	return $results;
}
function get_support_multicat_options($parent='0')
{
	$sql = "select * from customer_support where sup_status = 1 AND sup_parent_id=".$parent;
	$results = get_results($sql);
	return $results;
}

function get_cus_support_cat_name($id)
{
	$sql = "select sup_name from customer_support where sup_id=".$id;
	$results = get_row($sql);
	return $results['sup_name'];
}
function get_cus_support_cat_options()
{
	$sql = "select sup_id,sup_name from category where sup_status = 1";
	$results = get_results($sql);
	return $results;
}
?>