<?php 
/****************************************
	City related Functions
*****************************************/
function get_cities()
{
	$sql = "select * from city where city_status != 3 order by city_id";
	$results = get_results($sql);
	return $results;
}
function get_city_detail($id)
{
	$sql = "select * from city where city_id=".$id;
	$results = get_row($sql);
	return $results;
}
function get_city_name($id)
{
	$sql = "select city_name from city where city_id=".$id;
	$results = get_row($sql);
	return $results['city_name'];
}
function check_city_duplicate($name)
{
	$sql = "select city_id from city where city_name='".$name."'";
	$results = get_row($sql);
	
	if($results['city_id'] != '')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function get_city_options()
{
	$sql = "select city_id,city_name from city where city_status = 1";
	$results = get_results($sql);
	return $results;
}
function get_city_bystate($store_country,$store_state)
{
	$sql = "select city_id,city_name from city where country_id='".$store_country."' and state_id='".$store_state."' and city_status = 1";
	$results = get_results($sql);
	return $results;
}
function get_multicity_options($state='0',$country='0')
{
	$sql = "select city_id,city_name from city where city_status != 3 and state_id = ".$state." and country_id=".$country." order by city_name";
	$results = get_results($sql);
	return $results;
}
function search_cities($status)
{
	$sql = "select * from city where city_status=".$status;
	$results = get_results($sql);
	return $results;
}
?>