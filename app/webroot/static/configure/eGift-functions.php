<?php 
/****************************************
	E-Gift related Functions
*****************************************/
function get_egifts_data()
{
	$sql = "select * from egifts_data where egift_status != 3 order by egift_id";
	$results = get_results($sql);
	return $results;
}
function get_egifts_data_detail($id)
{
	$sql = "select * from egifts_data where egift_id=".$id;
	$results = get_row($sql);
	return $results;
}
function check_egifts_data_duplicate($name)
{
	$sql = "select egift_id from egifts_data where city_name='".$name."'";
	$results = get_row($sql);
	
	if($results['egift_id'] != '')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function search_gift_data_by_id($gift_id)
{
	$sql= "select * from egifts_data where egift_id =".$gift_id;
	$result = get_row($sql);
	
	return $result;	
}

?>