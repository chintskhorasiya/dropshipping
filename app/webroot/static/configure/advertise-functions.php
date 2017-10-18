<?php 
/****************************************
	advertisement related Functions
*****************************************/
function get_advertisement()
{
	$sql = "select * from advertisement order by advt_id";
	$results = get_row($sql);
	return $results;
}
function get_advertisement_detail($id)
{
	$sql = "select * from advertisement where advt_id=".$id;
	$results = get_row($sql);
	return $results;
}

function get_advt_link($id)
{
	$sql = "select advt_link from advertisement where advt_id=".$id;
	$results = get_row($sql);
	return $results['advt_link'];
}

function check_advertisement_duplicate($name)
{
	$sql = "select advt_id from advertisement where advt_link='".$name."'";
	$results = get_row($sql);
	
	if($results['advt_id'] != '')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function get_advertisement_options()
{
	$sql = "select advt_id,advt_link from advertisement where advertisement_status = 1";
	$results = get_results($sql);
	return $results;
}

function get_advertisement_bystate($store_country,$store_state)
{
	$sql = "select advt_id,advt_link from advertisement where country_id='".$store_country."' and state_id='".$store_state."' and advertisement_status = 1";
	$results = get_results($sql);
	return $results;
}

function get_multiadvertisement_options($state='0',$country='0')
{
	$sql = "select advt_id,advt_link from advertisement where advertisement_status != 3 and state_id = ".$state." and country_id=".$country;
	$results = get_results($sql);
	return $results;
}
?>