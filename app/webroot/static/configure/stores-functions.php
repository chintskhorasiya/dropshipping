<?php 
/****************************************
	Stores Functions
*****************************************/
function store_exists($sname,$pwd)
{
	$sql = "select * from store where store_username = '".$sname."' AND store_password = '".$pwd."'";
	$results = get_row($sql);
	return $results;
}
function store_duplicate($sname,$store_id='')
{
	$condition = '';
	if($store_id != '')
	{
		$condition = 'AND store_id != '.$store_id;
	}
	$sql = "select count(*) as total from store where store_username = '".$sname."' ".$condition;
	$results = get_row($sql);
	return $results['total'];
}
function store_duplicate_email($email,$store_id='')
{
	$condition = '';
	if($store_id != '')
	{
		$condition = 'AND store_id != '.$store_id;
	}
	$sql = "select count(*) as total from store where store_email = '".$email."' ".$condition;
	$results = get_row($sql);
	return $results['total'];
}
function get_stores()
{
	$sql = "select * from store where store_status != 3";
	$results = get_results($sql);
	return $results;
}
function get_b2b_stores()
{
	$sql = "select * from store where store_status != 3";
	$results = get_results($sql);
	return $results;
}
function get_store_detail($store_id)
{
	$sql = "select * from store where store_id = ".$store_id;
	$results = get_row($sql);
	return $results;
}
function get_storename($store_id)
{
	$sql = "select * from store where store_id = ".$store_id;
	$results = get_row($sql);
	return $results['store_name'];
}
function store_duplicate_name($sname,$store_id='')
{
	$condition = '';
	if($store_id != '')
	{
		$condition = 'AND store_id != '.$store_id;
	}
	$sql = "select count(*) as total from store where store_name = '".$sname."' ".$condition;
	$results = get_row($sql);
	return $results['total'];
}
function store_duplicate_url($surl,$store_id='')
{
	$condition = '';
	if($store_id != '')
	{
		$condition = 'AND store_id != '.$store_id;
	}
	$sql = "select count(*) as total from store where store_url = '".$surl."' ".$condition;
	$results = get_row($sql);
	return $results['total'];
}
function search_stores($params=array())
{
	$where = '';
	if($params)
	{
		foreach($params as $param_key => $param_value)
		{
			if($param_value != '')
			{
				if($param_key == 'store_name')
				{
					$where .= $param_key.' like "%'.$param_value.'%" AND ';
				}
				else
					$where .= $param_key.'="'.$param_value.'" AND ';
				
			}	
		}
	}
	if($where != '')
	{
		$where = ' where '.$where;
		$where = trim($where,' AND ');
	}
	
	$sql = "select * from store ".$where;
	$results = get_results($sql);
	return $results;
}
// Store Enquiries
function get_stores_enquiry()
{
	$sql = "select * from store_enquiry order by store_en_date desc";
	$results = get_results($sql);
	return $results;
}
// Email of creation
function send_store_registration_email($store_id)
{
	$store_detail   = get_store_detail($store_id);
	$store_email    = $store_detail['store_email'];
	$store_fullname = $store_detail['store_fullname'];
	$store_username = $store_detail['store_username'];
	$store_password = base64_decode($store_detail['store_pwd']);
	
	include('email/store-register.php');
	
	$subject = 'Successful registration of your store on E-lala!';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Mail it
	mail($store_email, $subject, $html, $headers);
}
function send_store_confirm_email($user_data)
{
	$store_email = $user_data['store_email'];
	include('email/store-confirm.php');
	
	$subject = 'Store Confirmed with Purchasekaro!';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Mail it
	mail($store_email, $subject, $html, $headers);
}
function get_stores_detail()
{
	$sql = "select * from store where store_status = 1 and store_completion = 1";
	$results = get_results($sql);
	
	return $results;
}

function get_stores_detail_for_aprooval()
{
	$sql = "select * from store where store_status = 1 and store_completion = 1";
	$results = get_results($sql);
	return $results;
}

function get_store_all($store_id)
{
	$sql = "select * from store,store_kyc,store_accounts where store_id = ".$store_id." and kyc_store_id = store_id and ac_store_id = store_id and store_completion = 1";
	$results = get_row($sql);
	
	return $results;
}
function get_store_payout_detail()
{
	$sql = "select * from acct_billing order by act_bill_id  desc";
	$results = get_results($sql);
	return $results;
}
function get_store_payout_detail_by_id($id)
{
	$sql = "select * from acct_billing where act_bill_id = '".$id."' order by act_bill_id  desc";
	$results = get_results($sql);
	return $results;
}
function get_accounting_info($store_id)
{
	$sql = "select sum(act_bill_netpayout) as total from acct_billing where act_bill_storeid = ".$store_id;
	$results = get_results($sql);
	
	return $results;
}
function get_kyc_info($store_id)
{
	$sql = "select * from store_kyc where kyc_store_id=".$store_id;
	$results = get_row($sql);
	echo mysql_error();
	return $results;
}
function get_bank_info($store_id)
{
	$sql = "select * from store_accounts where ac_store_id=".$store_id;
	$results = get_row($sql);
	echo mysql_error();
	return $results;
}

function get_store_avg_rates($store_id)
{
	$sql = "select sum(sr_rate) as avg_rate,count(*) as total from store_review where sr_status = 1 and sr_store_id =".$store_id." order by sr_created_date desc";
	$results = get_row($sql);
	$avg_rate = 0;
	if($results['avg_rate'] > 0 && $results['total'] > 0)
	{
		$avg_rate = ceil($results['avg_rate']/$results['total']);
	}
	return $avg_rate;
}
function get_storeshipping_detail($store_id)
{
	$sql = "select * from store_shipping where ship_store_id = ".$store_id;
	$results = get_row($sql);
	return $results;
}



//redspark functions
function check_slug_url($store_url){
    $sql = "select * from store where store_url = '$store_url'";
    $results = get_row($sql);
    $res = count($results);
    return $res;
}
?>