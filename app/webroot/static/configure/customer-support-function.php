<?php 
/****************************************
	Messages Functions
*****************************************/
function get_customer_feedbck()
{
	$sql = "select * from user_feedback order by created_date desc";
	$results = get_results($sql);
	return $results;
}
function get_customer_feedbck_by_id($id)
{
	$sql = "select * from user_feedback  where f_id = ".$id." order by created_date desc";
	$results = get_results($sql);
	return $results;
}
function get_count_feedbck()
{
	$sql = "select count(read_status) total from user_feedback where read_status=0";
	$results = get_row($sql);
	return $results;
}
function get_customer_feedbck_notification()
{
	$sql = "select * from user_feedback where read_status=0 ";
	$results = get_results($sql);
	return $results;
}
?>