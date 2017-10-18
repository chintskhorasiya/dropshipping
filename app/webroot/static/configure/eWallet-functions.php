<?php 
/****************************************
	E-Wallet related Functions
*****************************************/
function get_ewallet_data($user_id='')
{
	if($user_id != '')
	{
		$sql = "select * from ewallet_data where ewallet_userid=".$user_id." order by ewallet_id";
	}
	else
	{
		$sql = "select * from ewallet_data order by ewallet_id";
	}
	$results = get_results($sql);
	return $results;
}
function get_ewallet_data_detail($id)
{
	$sql = "select * from ewallet_data where ewallet_id=".$id;
	$results = get_row($sql);
	return $results;
}

?>