<?php 
/****************************************
	Admin Users Functions
*****************************************/
function adminuser_exists($uname,$pwd)
{
	$username = parse_username($uname);
	$sql = "select * from admin where admin_username = '".$username."' AND admin_password = '".md5($pwd)."'";
	$results  = get_row($sql);
	return $results;
}
function adminget_users()
{
	$sql = "select * from admin";
	$results = get_results($sql);
	return $results;
}
function adminget_user_detail($user_id)
{
	$sql = "select * from admin where admin_id = ".$user_id;
	$results = get_row($sql);
	return $results;
}
function adminget_username($user_id)
{
	$sql = "select * from admin where admin_id = ".$user_id;
	$results = get_row($sql);
	return $results['admin_username'];
}
function check_admin_password($user_id,$old_password)
{
	$sql = "select count(*) as total from admin where admin_id = ".$user_id." and admin_password = '".md5($old_password)."'";
	$results = get_row($sql);
	return $results['total'];
}
function check_pk_user_duplicate($uname,$user_id='')
{
	$condition = '';
	if($user_id != '')
	{
		$condition = 'AND admin_id != '.$user_id;
	}
	$sql = "select count(*) as total from admin where admin_username = '".$uname."' ".$condition;
	$results = get_row($sql);
	return $results['total'];
}
function check_pk_user_duplicate_email($email,$user_id='')
{
	$condition = '';
	if($user_id != '')
	{
		$condition = 'AND admin_id != '.$user_id;
	}
	$sql = "select count(*) as total from admin where admin_email = '".$email."' ".$condition;
	$results = get_row($sql);
	return $results['total'];
}
function search_admin_users($status)
{
	$sql = "select * from admin where admin_status = ".$status;
	$results = get_results($sql);
	return $results;
}
function get_statistics($params = array())
{
	$where = '';
	
	$table 		  = $params['table'];
	$status_field = $params['check_status'];
	$sql = "select count(*) as total,".$status_field." from ".$table." group by ".$status_field;
	$results = get_results($sql);
	
	$state_array = array();
	if($results)
	{
		foreach($results as $key => $value)
		{
			$state_array[$value[$status_field]] = $value['total'];
		}
		for($i=0;$i<=3;$i++)
		{
			if(!array_key_exists($i,$state_array))
			{
				$state_array[$i] = 0;
			}
		}
	}
	return $state_array;
}
?>