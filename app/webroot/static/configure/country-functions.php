<?php 
/****************************************
	Category Functions
*****************************************/

function get_countries()
{
	$sql = "select * from country where country_status != 3";
	$results = get_results($sql);
	return $results;
}

function get_country_detail($id)
{
	$sql = "select * from country where country_id=".$id;
	$results = get_row($sql);
	return $results;
}

function get_country_name($id)
{
	$sql = "select country_name from country where country_id=".$id;
	$results = get_row($sql);
	return $results['country_name'];
}

function get_country_options()
{
	$sql = "select country_id,country_name from country where country_status = 1";
	$results = get_results($sql);
	return $results;
}


function check_country_duplicate($name)
{
	$sql = "select country_id from country where country_name='".$name."'";
	$results = get_row($sql);
	
	if($results['country_id'] != '')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function get_multicountry_options($parent='0')
{
	$sql = "select country_id,country_name from country where country_status != 3 AND country_parent_id=".$parent;
	$results = get_results($sql);
	return $results;
}

function search_countries($status)
{
	$sql = "select * from country where country_status=".$status;
	$results = get_results($sql);
	return $results;
}

?>