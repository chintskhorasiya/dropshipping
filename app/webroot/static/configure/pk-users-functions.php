<?php 
/****************************************
	Users Functions
*****************************************/
function get_pk_users()
{
	$sql = "select * from users where user_status!=3 order by user_created_date desc";
	$results = get_results($sql);
	return $results;

}
function get_pk_user_detail($user_id)
{
	$sql = "select * from users where user_id = ".$user_id;
	$results = get_row($sql);
	return $results;
}


function user_exists($uname,$pwd)
{
	$sql = "select * from users where user_name = '".$uname."' AND user_password = '".$pwd."'";
	$results = get_row($sql);
	return $results;
}
function user_duplicate($uname,$user_id='')
{
	$condition = '';
	if($user_id != '')
	{
		$condition = 'AND user_id != '.$user_id;
	}
	$sql = "select count(*) as total from users where user_name = '".$uname."' ".$condition;
	$results = get_row($sql);
	return $results['total'];
}
function user_duplicate_email($email,$user_id='')
{
	$condition = '';
	if($user_id != '')
	{
		$condition = 'AND user_id != '.$user_id;
	}
	$sql = "select count(*) as total from users where user_email = '".$email."' ".$condition;
	$results = get_row($sql);
	return $results['total'];
}
function get_pk_username($user_id)
{
	$sql = "select * from users where user_id = ".$user_id;
	$results = get_row($sql);
	return $results['user_name'];
}
function search_pk_users($status)
{
	$sql = "select * from users where user_status = ".$status;
	$results = get_results($sql);
	return $results;

}
function send_register_email($user_data)
{
	include('email/register.php');

	$subject = 'Thank you for registration with Purchasekaro!';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$email = $user_data['user_email'];
	
	// Mail it
	mail($email, $subject, $html, $headers);
	//include('email/send_admin_user_info.php');
}


function get_supportuser_name($user_id)

{

	if($user_id == 0)

	{

		return "Admin";

	}

	else

	{

		$sql = "select * from store where store_id = ".$user_id;

		$results = get_row($sql);

		return $results['store_fullname'];

	}	

}

?>