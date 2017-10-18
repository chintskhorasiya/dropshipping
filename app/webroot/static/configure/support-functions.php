<?php 
/****************************************
	Messages Functions
*****************************************/
function get_messages()
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select * from adminsupport where adminsupport_to = ".$user_id." and adminsupport_parent=0 order by adminsupport_id desc";
	$results = get_results($sql);
	return $results;
}
function get_messages_by_type($id)
{
	$sql = "select * from adminsupport where support_for = '".$id."' ORDER BY adminsupport_date desc";
	$results = get_results($sql);
	return $results;
}
function get_messages_by_user($user_id)
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select * from adminsupport where (adminsupport_to = ".$user_id." or adminsupport_from = ".$user_id.") and adminsupport_parent=0 order by adminsupport_id desc";
	$results = get_results($sql);
	return $results;
}
function get_messages_by_users($id)
{
	$user_id  = $_SESSION['ADMIN_ID']; 
	$sql = "select * from adminsupport where (adminsupport_to = ".$user_id." or adminsupport_from = ".$user_id.") and (adminsupport_parent =" .$id ." or adminsupport_id =" .$id .") order by adminsupport_date asc";
  	//$sql = "select * from adminsupport where adminsupport_parent =".$id ." order by adminsupport_id asc";
	$results = get_results($sql);
	return $results;
}
function check_message_id_is_parent($id)
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select *,count(*) as total from adminsupport where (adminsupport_from = ".$user_id." or adminsupport_to = ".$user_id.") and  adminsupport_id = ".$id." and support_for = 1 order by adminsupport_id asc";
	$results = get_row($sql);
	return $results['total'];
}
function get_messages_users()
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select distinct(msg_to) as user_id from adminsupport where adminsupport_from = ".$user_id." order by adminsupport_id desc";
	$results = get_results($sql);
	return $results;
}
function get_unread_messages_count($store_id)
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select count(*) as total from adminsupport where adminsupport_to = ".$user_id." and adminsupport_from = ".$store_id." and adminsupport_status=0 order by adminsupport_id desc";
	$results = get_row($sql);
	return $results['total'];
}
function get_user_unread_messages_count()
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select count(*) as total from adminsupport where adminsupport_to = ".$user_id." and adminsupport_status=0 and support_for = '".$support_for."' order by adminsupport_id desc";
	$results = get_row($sql);
	return $results['total'];
}
function update_user_unread_message()
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "update adminsupport set adminsupport_read_status=1 where adminsupport_to = ".$user_id;
	$results = get_row($sql);
	return $results['total'];
}
function get_messages_by_alluser($user_id)
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select * from adminsupport where adminsupport_parent=0 order by adminsupport_id desc";
	$results = get_results($sql);
	return $results;
}
function get_parent_subject($id)
{
	//$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select * from adminsupport where adminsupport_parent = ".$id;
	$results = get_results($sql);
	return $results; 
}
function get_support_info($id)
{
	//$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select * from user_feedback where f_id = ".$id;
	$results = get_row($sql);
	return $results; 
}
function get_distributor_unread_messages_count()
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select count(*) as total from adminsupport where adminsupport_to = 0 and adminsupport_status=0 and support_for = 4  and adminsupport_read_status= 0 order by adminsupport_id desc";
	$results = get_row($sql);
	return $results['total'];
}
function get_all_unread_messages()
{
	$user_id  = $_SESSION['ADMIN_ID'];
	$sql = "select * from adminsupport where adminsupport_to = 0 and adminsupport_status=0 and adminsupport_read_status= 0 and support_for!=0 order by adminsupport_id desc";
	$results = get_results($sql);
	return $results;
}
function get_store_by_support_id($id)
{
	$sql = "select * from adminsupport where adminsupport_id = ".$id." and adminsupport_parent=0 order by adminsupport_id desc";
	$results = get_row($sql);
	return $results;
}

function new_support_notification()
{
	$sql = "SELECT * FROM adminsupport WHERE adminsupport_from != 0 AND adminsupport_read_status != 1";
	$results= get_results($sql);
	return $results;
}

?>