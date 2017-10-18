<?php

/*

All accounting and shipping update functions

*/



function cron_check(){

	// Get all the active orders with order_status = 2

	$active_orders = get_active_orders();

	$curr_date = date('Y-m-d H:i:s', time());

	$shippedby = array();

	foreach($active_orders as $val)

	{

		if($val['awn_ship_by'] == 1) //DELHIVERY

		{

			$shippedby[] = $val['awn_no'];

			$delhivery_ship = true;

		}

		elseif ($val['awn_ship_by'] == 2) {

			# $shippedby[] =

			# $other_ship = true;

		}

	} // FOREACH ends

	$awn_string  = implode(',', $shippedby);



	if($delhivery_ship){

		$get_api_result = delhivery_package($awn_string);

// pre($get_api_result);

		if(is_array($get_api_result) && !empty($get_api_result)){

			foreach ($get_api_result['ShipmentData'] as $key => $value) {

			  	

			#  	$op_id = $value['Shipment']['ReferenceNo'];

			#  	$newrefcode = str_replace(SHIP_ORDERID_SERIAL, '', $op_id);

			  	/*

			  	// Delhivery send these response in status and instuction with exact

			  	// detailed location. And StatusType responses as code

			  		DL if package has been delivered

					UD if package is In Transit, Dispatched or in Pending state 

					RT if package has been returned 

					RTO if package has been RTO

			  	*/

				$order_prod['op_product_status'] = '';

				$awnid = $value['Shipment']['AWB'];

				// $order_id = $value['Shipment']['ReferenceNo'];

				$order_id = str_replace(SHIP_ORDERID_SERIAL, '', $value['Shipment']['ReferenceNo']);

				$awn_next_on = date('Y-m-d H:i:s', strtotime($curr_date . '+ 1 days'));

			  	if($value['Shipment']['Status']['StatusType'] = 'DL'){

			  		$order_prod['op_product_status'] = 7;



			  		//Product has been delivered successfully, payment to processed

			  		// for Vendors and Distributor (if any)

			  		//Calculate days after delivery

			  		$payout_on = date('Y-m-d H:i:s', strtotime($curr_date . '+ '.DAYSOFPAYMENT.' days'));

			  		$acct_data['act_bill_type'] 		= 1; // Regular Billing

			  		$acct_data['act_bill_pay_status'] 	= 1; //Approved for payment

			  		$acct_data['act_bill_generatedate'] = $payout_on;

			  		$update_accts = update_data('acct_billing',$acct_data,'act_bill_orderid = '.$order_id);



			  		//Delete the awn QUEUE

			  		delete_data('awn_queue','awn_no = '.$awnid);



			  		//If found Distributor ID in this order

			  		$check_dist = get_distributor_exists($order_id);

			  		if(($check_dist)!= '' && (!empty($check_dist ))){

			  			$dist_data['dist_bill_pay_type'] = 1; // Regular Billing

			  			$dist_data['dist_bill_pay_status'] = 1; // Approved

			  			$dist_data['dist_bill_pay_date'] = $payout_on;

			  			$update_dist = update_data('distributor_billing',$dist_data, 'dist_bill_order_id = '.$order_id);

			  		}



			  	}elseif ($value['Shipment']['Status']['StatusType'] = 'UD') {

			  		if($value['Shipment']['Status']['Status'] == 'In Transit'){

			  			$order_prod['op_product_status'] = 5;

			  		}else {

			  			$order_prod['op_product_status'] = 4;	

			  		}

			  		//UPDATE THE QUEUE FOR NEXT RUN			  		

			  		$awn_queue_data['awn_next_run'] = $awn_next_on;

			  		$sql = "UPDATE awn_queue SET awn_count = awn_count + 1, awn_next_run = $next_on WHERE awn_no = $awnid";

					$results_up = get_results($sql);

			  		

			  	}elseif ($value['Shipment']['Status']['StatusType'] = 'RT') {

			  		$order_prod['op_product_status'] = 6;

			  	}elseif ($value['Shipment']['Status']['StatusType'] = 'RTO') {

			  		$order_prod['op_product_status'] = 8;

			  		// Product Returned to vendor Again

			  		$get_RTO = calculate_RTO($order_id);



			  		$acct_data['act_bill_price'] 		= 0; 

			  		$acct_data['act_bill_venshipcost'] 	= 0; 			  		

			  		$acct_data['act_bill_shipcost'] 	= 0; 			  		

			  		$acct_data['act_bill_shiptax'] 		= 0; 			  		

			  		$acct_data['act_bill_catcost'] 		= 0; 			  		

			  		$acct_data['act_bill_cattax'] 		= 0; 			  		

			  		$total_return_value					= ($get_RTO['act_bill_shipcost'] + $get_RTO['act_bill_shiptax'] + $get_RTO['act_bill_catcost'] + $get_RTO['act_bill_cattax']); 

			  		$acct_data['act_bill_charges'] 		= 0 - $total_return_value;

			  		$acct_data['act_bill_netpayout']	= $total_return_value;

			  		$acct_data['act_bill_type'] 		= 3; // RETURN Billing

			  		$acct_data['act_bill_pay_status'] 	= 1; //Approved for payment

			  		$acct_data['act_bill_generatedate'] = $curr_date;

			  		$update_accts = update_data('acct_billing',$acct_data,'act_bill_orderid = '.$order_id);



			  		//Delete the awn QUEUE

			  		delete_data('awn_queue','awn_no = '.$awnid);



			  		//If found Distributor ID in this order

			  		$check_dist = get_distributor_exists($order_id);

			  		if(($check_dist)!= '' && (!empty($check_dist ))){

			  			$dist_data['dist_bill_pay_type'] = 3; // Product Returned

			  			$dist_data['dist_bill_pay_status'] = 3; // No payment

			  			$dist_data['dist_bill_pay_date'] = $curr_date;

			  			$update_dist = update_data('distributor_billing',$dist_data, 'dist_bill_order_id = '.$order_id);

			  		}

			  	}else{

			  		//If none of the conditions are satisfied.

			  		$err_instructions = $value['Shipment']['Status']['Instructions'];

			  		error_log($dt.":Delhivery API "."$awnid : $err_instructions".PHP_EOL,3,'/var/www/purchasekaro/cron.log');

			  	}

				$update_table = update_data('order_products',$order_prod,'op_awnid='.$awnid);

			    $results_up = get_results($update_table);

			  	// echo '<br/>'.$value['Shipment']['Status']['StatusType'];

			  	// echo '<br/>'.$value['Shipment']['AWB'];

			  }

		}else{

			$err_instructions = $value['Shipment']['Status']['Instructions'];

			error_log($curr_date.":Delhivery API returned NULL".PHP_EOL,3,'/var/www/purchasekaro/cron.log');

		}

	}

	if($other_ship){

		# Code if other shipper

	}

	return $results_up;

}



//Get all Order which are active to make API call to Shipper

function get_active_orders(){ //DELHIVERY

	 $sql = 'SELECT awn_no, awn_ship_by, awn_order_id

			FROM order_products 

			WHERE awn_next_run = CURDATE()

			LIMIT 150';

    $results = get_results($sql);

    return $results;

}



//Delhivery API

function delhivery_package($waybill){

	

	$url = "http://test.delhivery.com/api/packages/json/?token=".DELHIVERY_TOKEN."&verbose=0&waybill=".$waybill;



  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  // curl_setopt($ch, CURLOPT_POST, true);

  // curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));

  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

  $result = curl_exec($ch);

  // curl_close($ch);

  return json_decode($result, true);

  // return $result;

}



/*

  Get distributor details in order details

*/



  function get_distributor_billing(){

	$sql = "SELECT d.*, dist.user_full_name 

			FROM distributor_billing d, distributor dist

			WHERE d.dist_bill_dist_id = dist.user_id ORDER BY d.dist_bill_pay_date desc";

	$results = get_results($sql);

	return $results;

}



  function get_distributor_exists($order_id){

  	$sql = "SELECT distributor_id 

			FROM order_products 

			WHERE op_id = $order_id 

			LIMIT 1";

    $result = get_row($sql);

    return $result;

  }



 //  /*

	// Prepare the Payout

 //  */

	// function prepare_payout(){

	// 	$sql = 'SELECT dist_bill_dist_id

	// 			FROM distributor_billing

	// 			WHERE dist_bill_pay_status = 1';

	// 	$result = $get_results($sql);



	// 	if(is_array($result) && !empty($result)){

	// 		foreach ($result as $value) {

	// 			#query pending

	// 		}

	// 	}

	// }





//Display on dist page

function display_payouts($status, $user){

	// User 1: Store, 2: Distributor

	if($user == 1){

		$username = 's.store_name';
		
		$payout_table = 'account_payout';
		
		$tablename = 'store s';

		$condition = 's.store_id';

	}else {

		$username = 'd.user_full_name';
		
		$payout_table = 'dist_account_payout';

		$tablename = 'distributor d';

		$condition = 'd.user_id';

	}

	$sql = "SELECT a.*, $username AS name FROM $payout_table a, $tablename

			WHERE acct_po_paid_status = $status  AND acct_po_for = $user AND a.acct_po_acctid = $condition

			ORDER BY acct_po_date DESC";

	$results = get_results($sql);

	return $results;

}
function display_payouts_store($status, $user , $store){

	// User 1: Store, 2: Distributor
	if($user == 1){
		$username = 's.store_name';
		$tablename = 'store s';
		$condition = 's.store_id';
		$payout_table = 'account_payout';
	} else {
		$username = 'd.user_full_name';
		$payout_table = 'dist_account_payout';
		$tablename = 'distributor d';
		$condition = 'd.user_id';
	}
	$sql = "SELECT a.*, $username AS name FROM $payout_table a, $tablename

			WHERE acct_po_paid_status = $status  AND acct_po_for = $user AND a.acct_po_acctid = $condition and a.acct_po_acctid = ".$store."

			ORDER BY acct_po_date DESC";

	$results = get_results($sql);

	return $results;

}


// Get details of Entry of DIstributor and Vendor ID if its present in db or not

function check_distributor_data($id, $user){

	$sql = "SELECT * FROM dist_account_payout 

			WHERE acct_po_acctid = $id  AND acct_po_for = $user ORDER BY acct_po_date DESC LIMIT 1";

	$results = get_row($sql);

	return $results;

}

function get_dist_payout(){

	// $sql = "SELECT SUM(d.dist_bill_pay_amt) AS AMT , dist.user_full_name , GROUP_CONCAT(d.dist_bill_order_id SEPARATOR ',') AS order_id,

	// 		FROM distributor_billing d, distributor dist

	// 		WHERE d.dist_bill_pay_type = $credit AND d.dist_bill_pay_status = 10 AND d.dist_bill_dist_id = dist.user_id

	// 		GROUP BY d.dist_bill_dist_id";



			$sql = "SELECT dist.user_full_name ,d.dist_bill_dist_id AS po_acctid, GROUP_CONCAT(d.dist_bill_order_id SEPARATOR ',') AS po_order_id,

			SUM(COALESCE(CASE WHEN d.dist_bill_pay_type = '1' THEN d.dist_bill_pay_tds END,0)) total_tds

		  , SUM(COALESCE(CASE WHEN d.dist_bill_pay_type = '2' THEN d.dist_bill_pay_amt END,0)) total_debits

    	  , SUM(COALESCE(CASE WHEN d.dist_bill_pay_type = '1' THEN d.dist_bill_pay_amt END,0)) total_credits

      	  , SUM(COALESCE(CASE WHEN d.dist_bill_pay_type = '1' THEN d.dist_bill_pay_amt END,0)) 

    	  - SUM(COALESCE(CASE WHEN d.dist_bill_pay_type = '2' THEN d.dist_bill_pay_amt END,0)) balance 

			FROM distributor_billing d, distributor dist

			WHERE d.dist_bill_pay_status = 1 AND d.dist_bill_dist_id = dist.user_id

			GROUP BY d.dist_bill_dist_id";

	$results = get_results($sql);

	$count = count($results);

	if($results){

		foreach($results as $val){

			$acct_payout['acct_po_acctid'] 		= $val['po_acctid'];

			$acct_payout['acct_po_order_id'] 	= $val['po_order_id'];

			$acct_payout['acct_po_debits'] 		= $val['total_debits'];

			$acct_payout['acct_po_credits'] 	= $val['total_credits'];
			
			$acct_payout['acct_po_tds'] 		= $val['total_tds'];

			$acct_payout['acct_po_amt'] 		= $val['balance'];

/*			if(($val['balance'] > 0) && ($val['balance']) > DISTRIBUTOR_TDS_LIMIT){*/

				//$acct_payout['acct_po_tds']  	= $val['balance'] * 0.10 ;

			$acct_payout['acct_po_net_amt'] 	= $val['balance'] - $acct_payout['acct_po_tds'];

			/*}else{

				//$acct_payout['acct_po_tds'] 	= 0;

				$acct_payout['acct_po_net_amt'] = $val['balance'];

			}*/

			

			$acct_payout['acct_po_date'] 		= date('Y-m-d H:i:s');

			$acct_payout['acct_po_for'] 		= 2; // For distributor

// echo $val['po_acctid'];

			$get_dist_data = check_distributor_data($val['po_acctid'], 2); // 2:Distributor

			if($get_dist_data){

				// DIST Acct is started,means entry exists in payout

				// So, we need to calculate the balance of this amount.

				// echo 'data found';

				$opening_bal = $get_dist_data['acct_po_open'];

				$closing_bal = $get_dist_data['acct_po_close'];

				// Closing balance will be the opening balance

				$acct_payout['acct_po_open'] = $closing_bal;



				// pre($get_dist_data);

				if($val['balance'] < 0){

					$acct_payout['acct_po_close'] = $val['balance'] + $closing_bal;

					$net_pay = $closing_bal + $val['balance'];

					$acct_payout['acct_po_net_amt'] = $net_pay;

				}else{

					

					$net_pay = $closing_bal + $acct_payout['acct_po_net_amt'];

					$acct_payout['acct_po_net_amt'] = $net_pay;

					// echo "Net Pay is $net_pay for User ID $d_id";

					if($net_pay < 0){

						$acct_payout['acct_po_close'] = $net_pay;	

					}else{

					$acct_payout['acct_po_close'] = '0';

					}

				}



			}else {

				// echo 'data not found, new insert';

				$acct_payout['acct_po_open'] = '0';  // New account opened with Zero opening Balance

				if($val['balance'] < 0){

					$acct_payout['acct_po_close'] = $val['balance'];	

				}else{

					$acct_payout['acct_po_close'] = '0'; // Full payment made

				}

				

				// pre($get_dist_data);

			}
			$acct_payout['acct_po_net_amt'] = ceil($acct_payout['acct_po_net_amt']);
			$insert = insert_data('dist_account_payout', $acct_payout);

			if($insert){

				$od_id 	= $val['po_order_id'];

				$d_id 	= $val['po_acctid'];

				$dis_val['dist_bill_pay_status'] = 2;

				update_data('distributor_billing',$dis_val,"dist_bill_order_id IN ($od_id) AND dist_bill_dist_id = $d_id");

			}

		}

	}

return $count;

}



// Processing payment for Vendors

function get_vendor_payout(){

	// $sql = "SELECT SUM(d.dist_bill_pay_amt) AS AMT , dist.user_full_name , GROUP_CONCAT(d.dist_bill_order_id SEPARATOR ',') AS order_id,

	// 		FROM distributor_billing d, distributor dist

	// 		WHERE d.dist_bill_pay_type = $credit AND d.dist_bill_pay_status = 10 AND d.dist_bill_dist_id = dist.user_id

	// 		GROUP BY d.dist_bill_dist_id";



			$sql = "SELECT GROUP_CONCAT(a.act_bill_id SEPARATOR ',') AS bill_id, s.store_name ,a.act_bill_storeid AS po_acctid, GROUP_CONCAT(a.act_bill_orderid SEPARATOR ',') AS po_order_id,

			SUM(COALESCE(CASE WHEN a.act_bill_type = '3' THEN a.act_bill_netpayout END,0)) total_returns

          ,	SUM(COALESCE(CASE WHEN a.act_bill_type = '2' THEN a.act_bill_netpayout END,0)) total_debits

    	  , SUM(COALESCE(CASE WHEN a.act_bill_type = '1' THEN a.act_bill_netpayout END,0)) total_credits

      	  , SUM(COALESCE(CASE WHEN a.act_bill_type = '1' THEN a.act_bill_netpayout END,0)) 

    	  - SUM(COALESCE(CASE WHEN a.act_bill_type = '2' THEN a.act_bill_netpayout END,0)) 

    	  - SUM(COALESCE(CASE WHEN a.act_bill_type = '3' THEN a.act_bill_netpayout END,0)) balance 

			FROM acct_billing a, store s

			WHERE a.act_bill_pay_status = 1 AND a.act_bill_storeid = s.store_id

			GROUP BY a.act_bill_storeid";

	//AND a.act_bill_generatedate >= NOW()   		

	$results = get_results($sql);
	//exit;
	

	$count = count($results);

	if($results){

		foreach($results as $val){

			$acct_payout['acct_po_acctid'] 		= $val['po_acctid'];

			$acct_payout['acct_po_order_id'] 	= $val['po_order_id'];

			$acct_payout['acct_po_debits'] 		= $val['total_debits'] + $val['total_returns'];

			$acct_payout['acct_po_credits'] 	= $val['total_credits'];

			$acct_payout['acct_po_amt'] 		= $val['balance'];

			$acct_payout['acct_po_net_amt'] 	= $val['balance'];

			

			$acct_payout['acct_po_date'] 		= date('Y-m-d H:i:s');

			$acct_payout['acct_po_for'] 		= 1; // For Vendor / Store

// echo $val['po_acctid'];

			$get_dist_data = check_distributor_data($val['po_acctid'], 1); // 1: Vendor

			if($get_dist_data){

				// DIST Acct is started,means entry exists in payout

				// So, we need to calculate the balance of this amount.

				// echo 'data found';

				$opening_bal = $get_dist_data['acct_po_open'];

				$closing_bal = $get_dist_data['acct_po_close'];

				// Closing balance will be the opening balance

				$acct_payout['acct_po_open'] = $closing_bal;



				// pre($get_dist_data);

				if($val['balance'] < 0){

					$acct_payout['acct_po_close'] = $val['balance'] + $closing_bal;

					$net_pay = $closing_bal + $val['balance'];

					$acct_payout['acct_po_net_amt'] = $net_pay;

				}else{

					

					$net_pay = $closing_bal + $acct_payout['acct_po_net_amt'];

					$acct_payout['acct_po_net_amt'] = $net_pay;

					// echo "Net Pay is $net_pay for User ID $d_id";

					if($net_pay < 0){

						$acct_payout['acct_po_close'] = $net_pay;	

					}else{

					$acct_payout['acct_po_close'] = '0';

					}

				}



			}else {

				// echo 'data not found, new insert';

				$acct_payout['acct_po_open'] = '0';  // New account opened with Zero opening Balance

				if($val['balance'] < 0){

					$acct_payout['acct_po_close'] = $val['balance'];	

				}else{

					$acct_payout['acct_po_close'] = '0'; // Full payment made

				}

				

				// pre($get_dist_data);

			}

			//pre($acct_payout);

			$insert = insert_data('account_payout',$acct_payout);
			//echo mysql_error();
			//exit;
			if($insert){

				$bill_id 	= $val['bill_id'];

				$d_id 		= $val['po_acctid'];

				$dis_val['act_bill_pay_status'] = 2;

				update_data('acct_billing',$dis_val,"act_bill_id IN ($bill_id) AND act_bill_storeid = $d_id");

			}

			}

	}

return $count;

}



// Get Price to be charged for RTO shippment.

function calculate_RTO($od_id){

	$sql = "SELECT * FROM acct_billing

			WHERE act_bill_orderid = $od_id LIMIT 1";

	$results = get_row($sql);

	return $results;

}