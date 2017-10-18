<?php 
/****************************************
	Coupon Functions
*****************************************/
function get_coupons()
{
	$sql = "select * from coupons where coupon_status != 3";
	$results = get_results($sql);
	return $results;
}
function get_coupon_detail($id)
{
	$sql = "select * from coupons where coupon_id=".$id;
	$results = get_row($sql);
	return $results;
}
?>