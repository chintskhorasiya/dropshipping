<?php 
/****************************************
	State related Functions
*****************************************/
function get_states()
{
	$sql = "select * from state where state_status != 3 order by state_id desc";
	$results = get_results($sql);
	return $results;
}
function get_state_name($id)
{
	$sql = "select state_name from state where state_id=".$id;
	$results = get_row($sql);
	return $results['state_name'];
}
function get_state_detail($id)
{
	$sql = "select * from state where state_id=".$id;
	$results = get_row($sql);
	return $results;
}	
function get_state_options()
{
	$sql = "select state_id,state_name from state where state_status = 1";
	$results = get_results($sql);
	return $results;
}

function get_state_bycountry($state_country)
{
	$sql = "select state_id,state_name from state where country_id='".$state_country."' and state_status = 1";
	$results = get_results($sql);
	return $results;
}

function check_state_duplicate($name)
{
	$sql = "select state_id from state where state_name='".$name."'";
	$results = get_row($sql);
	
	if($results['state_id'] != '')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function get_multistate_options($parent='0')
{
	$sql = "select state_id,state_name from state where state_status != 3 AND country_id=".$parent;
	$results = get_results($sql);
	return $results;
}

function search_states($status)
{
	$sql = "select * from state where state_status=".$status;
	$results = get_results($sql);
	return $results;
}
?>