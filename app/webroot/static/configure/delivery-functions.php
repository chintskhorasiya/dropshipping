<?php 
/****************************************
	Delivery Functions
*****************************************/
function get_delivery_days()
{
	$sql = "select * from delivery_days where deli_status != 3";
	$results = get_results($sql);
	return $results;
}
function get_active_delivery_days()
{
	$sql = "select * from delivery_days where deli_status = 1";
	$results = get_results($sql);
	return $results;
}

function get_delivery_days_detail($id)
{
	$sql = "select * from delivery_days where deli_id=".$id;
	$results = get_row($sql);
	return $results;
}
?>