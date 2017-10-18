<?php 
/****************************************
	Users Functions
*****************************************/
function get_users()
{
	$sql = "select * from users where user_status!=3 order by user_created_date desc";
	$results = get_results($sql);
	return $results;
}
function get_user_detail($user_id)
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
function get_username($user_id)
{
	$sql = "select * from users where user_id = ".$user_id;
	$results = get_row($sql);
	return $results['user_full_name'];
}
function search_users($status)
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
	$headers  = "From:Purchasekaro <no-reply@purchasekaro.com>"."\r\n";
	$headers  .= 'MIME-Version: 1.0' . "\r\n";
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
function send_support_mail($suport_data)
{
	include('email/customersupport.php');

	$subject = 'Purchasekaro customer support!';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$email = $suport_data['f_email'];
	
	// Mail it
	mail($email, $subject, $html, $headers);
	//include('email/send_admin_user_info.php');
}
function send_seller_register($user_data)
{
	include('email/sellerregister.php');
	$subject = 'Store Confirmed with Purchasekaro!';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = "From:Purchasekaro <no-reply@purchasekaro.com>"."\r\n";
	$headers  .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 $email = $user_data['store_email'];
	// Mail it
	mail($email, $subject, $html, $headers);
	//include('email/send_admin_seller_info.php');
}
function send_seller_reject($user_data)
{
	include('email/store-reject.php');
	$subject = 'Store Not confirmed with purchasekaro!';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = "From:Purchasekaro <no-reply@purchasekaro.com>"."\r\n";
	$headers  .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 $email = $user_data['store_email'];
	// Mail it
	mail($email, $subject, $html, $headers);
	//include('email/send_admin_seller_info.php');
}
function send_gift_mail($gift_data)
{
	include('email/sendegift.php');

	$subject = 'Gift voucher for you from purchasekaro!';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$email = $gift_data['egift_email'];
	
	// Mail it
	mail($email, $subject, $html, $headers);
	//include('email/send_admin_user_info.php');
}

function set_store_stage($stage,$user_id)
{
	$store_data = get_store_detail($user_id);
	$var = explode(",",$store_data['store_stage']);
	 foreach($var as $key => $value)
	 {
		$updates[$key] = $value;
	 	if($value!=$stage)
		{
				$value1 = mysql_real_escape_string($stage);
                $updates[$value1-1] = $value1;
		}
		else
		{
		
		}
	 }
	 //pre($updates);
	 $update_data['store_stage'] = implode(',',$updates);
	 $sql = update_data('store',$update_data,'store_id ='.$user_id);
	 //echo mysql_error();
}
function checkoldpassword($user_id,$oldpassword)
{
	$sql = "select count(*) as total from admin where admin_id = ".$user_id." and admin_password='".md5($oldpassword)."'";
	$results = get_row($sql);
	if($results['total'] > 0)
	{
		return 1;
	}
	return 0;
}

?>