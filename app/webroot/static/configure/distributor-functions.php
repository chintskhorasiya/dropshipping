<?php 

/****************************************

	distributor Functions

*****************************************/

function get_distributor()

{

	 $sql = "select * from distributor order by user_id desc";

	$results = get_results($sql);

	return $results;

}

function get_distributor_by_pin_id($status,$pin)

{

	 $sql = "select * from distributor where user_status = ".$status." and created_by = ".$pin." order by user_id desc";

	$results = get_results($sql);

	return $results;

}



function get_distributor_detail($id)

{

	$sql = "select * from distributor where user_id=".$id;

	$results = get_row($sql);

	return $results;

}

function delete_distributor($id)

{

	$sql = "delete from distributor where user_id=".$id;

	$results = db_query($sql);

	return true;

}

function distributor_string($string=8)
{
     $random_string = rand_string($string);	
	 
	 $sql = "select count(*) as total from distributor where user_key = '".$random_string."'";
  	 $results = get_row($sql);
  	 
	 while($results['total'] > 0)
	 {
	 	$random_string = rand_string($string);
		$sql = "select count(*) as total from distributor where user_key = '".$random_string."'";
  	 	$results = get_row($sql);
	 }
	 return $random_string; 
}

function get_distributor_pins()
{
	$sql = "select * from distributor order by user_id desc";
	$results = get_results($sql);
	return $results;
}


function send_distributor_email_to_customer($distributor_id)

{

    	// Email to Customer

		$message = '<html>

						<head>

						  <title>New distributor on Purchasekaro</title>

						</head>

						<body>

						  <p>Here is link of distributor</p>

						  <table baffiliate="1" align="left" cellpadding="10" cellspacing="0">

							<tr>

							  <th align="left">Your Distributor id:</th><td>'.$distributor_id.'</td>

							</tr>

							<tr>

							  <th align="left">Link:</th><td><a href="'.SITEURL.'distributor-details.php?user_id='.$distributor_id.'">Click Here</a></td>

							</tr>

						  </table>

						</body>

						</html>

					';		

		$subject = 'New distributor on Purchasekaro';

		// To send HTML mail, the Content-type header must be set

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'Bcc: vtshukla.b4s@gmail.com' . "\r\n";

		/*foreach($stores as $key => $value)

		{

			$store_detail = get_store_detail($value['op_store_id']);

			$store_email  = $store_detail['U_EMAIL'];

			mail($store_email, $subject, $message, $headers);

		}*/

		

		$admin_detail = adminget_user_detail(1);

		$admin_email  = $admin_detail['A_EMAIL'];

		mail($admin_email, $subject, $message, $headers);

}

function get_distributor_payout_detail()

{

	$sql = "select * from distributor_billing order by dist_bill_id  desc";

	$results = get_results($sql);

	return $results;

}

function get_distributor_payout_detail_by_id($id)

{

	$sql = "select * from distributor_billing where dist_bill_dist_id = '".$id."' order by dist_bill_id  desc";

	$results = get_results($sql);

	return $results;

}

function get_distributor_detail_by_id($id)

{

	$sql = "select * from distributor where d_company_id = ".$id." order by user_id desc";

	$results = get_results($sql);

	return $results;

}

function get_company()

{

	 $sql = "select * from distributor_company order by d_company_id desc";

	$results = get_results($sql);

	return $results;

}

function check_company_duplicate($name)

{

	$sql = "select d_company_id from distributor_company where d_company_name='".$name."'";

	$results = get_row($sql);

	

	if($results['d_company_id'] != '')

	{

		return 1;

	}

	else

	{

		return 0;

	}

}

function search_companies($status)

{

	$sql = "select * from distributor_company where d_comapany_status=".$status;

	$results = get_results($sql);

	return $results;

}

function get_company_detail($id)

{

	$sql = "select * from distributor_company where d_company_id=".$id;

	$results = get_row($sql);

	return $results;

}

function get_tags()

{

	 $sql = "select * from distributor_tags order by d_tag_id desc";

	$results = get_results($sql);

	return $results;

}

function distributor_payout_detail($id)

{

	 $sql = "select sum(dist_bill_pay_amt) as total from distributor_billing where dist_bill_dist_id = ".$id;

	$results = get_results($sql);

	return $results;

}



?>