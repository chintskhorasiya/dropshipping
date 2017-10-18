<?php
/****************************************
	Reports Functions
*****************************************/
function get_top_selling_products($from,$to,$limit)
{
	$from	=	date("Y-m-d", strtotime($from));
	$to		=	date("Y-m-d", strtotime($to));
	$sql = "SELECT *,sum(op.op_qty) as total_sold FROM order_products op,orders o where op_order_id = order_id and op.op_order_status = 2 and o.order_date between '".$from."' AND '".$to."' group by op.op_product_id order by total_sold desc LIMIT 10";

	$results = get_results($sql);
	return $results;	
}
function get_top_seller($from,$to,$order_by='total_sold')
{
	$where = "where op.op_order_status = 2";
	$between = '';
	if($from!='' && $to!='')
	{
		$from	=	date("Y-m-d", strtotime($from));
		$to		=	date("Y-m-d", strtotime($to));
		$between	=	"sr.sr_created_date between ".$from." AND ".$to."";
	}
	if($between != '')
	{
		$where = " and ".$between;
	}
	$sql = "SELECT op.op_store_id,count(op.op_qty) as total_sold,avg(sr.sr_rate) as avg_sr_rate,sum(op.op_sub_total) as turnover_price,sum(op_pk_commision) as total_commision FROM order_products op LEFT JOIN store_review sr on  op.op_store_id=sr.sr_store_id   ".$where."  group by op.op_store_id order by ".$order_by." DESC";
	$results = get_results($sql);
	return $results;	
}
function get_payment_gateway_reports($from,$to)
{
	$between	='';
	if($from!='' && $to!='')
	{
		$from	=	date("Y-m-d", strtotime($from));
		$to		=	date("Y-m-d", strtotime($to));
		$between=	'and order_date between "'.$from .'" and "'.$to.'"';	
	}
	$sql = "select * from orders  where order_status = 2 and order_pay_by != 501 ".$between." order by order_date";
	$results = get_results($sql);
	return $results;
}

function get_total_product_today($limit)
{
	$sql = "SELECT `order_type`,`order_id`,`order_net_amount`,`order_date`,count(`order_id`) as total_id,sum(`order_net_amount`) as `total_amt` 
				FROM `orders` 
				WHERE order_date = '".date('Y-m-d')."'
				group by `order_date` order by total_id DESC";
	$results = get_results($sql);
	return $results;	
}
function get_vendor_sale($store_id,$from,$to)
{
	$sql = "SELECT *
			FROM orders o,order_products op 
			WHERE op.op_store_id = '".$store_id."' AND o.order_date BETWEEN '".$from."' AND '".$to."' AND o.order_id = op.op_order_id
			group by op.op_store_id";
	$results = get_results($sql);
	return $results;
}
function get_orders_by_product_id($id)
{
	$sql = "select * from order_products op,orders o where op.op_product_id=".$id." AND o.order_id = op.op_order_id and op.op_order_status = 2";
	$results = get_results($sql);
	return $results;
}

function get_distributor_billing_data($from,$to)
{
	//$sql = "select * from distributor_billing dsb,store_kyc sk where dist_bill_generate_date BETWEEN '".$from."' AND '".$to."' AND sk.kyc_for=2 group by dsb.dist_bill_dist_id";
	$sql = "select * from distributor_billing dsb,store_kyc sk where dist_bill_generate_date BETWEEN '".$from."' AND '".$to."' group by dsb.dist_bill_dist_id";
	$results = get_results($sql);
	return $results;
}
function get_orders_by_distributor_id($id)
{
	$sql = "select * from order_products op,orders o,store_kyc sk where op.distributor_id=".$id." AND o.order_id = op.op_order_id group by op.op_order_id";
	$results = get_results($sql);
	return $results;
}

function get_eGift_data($from,$to)
{
	$between	='';
	if($from!='' && $to!='')
	{
		$from	=	date("Y-m-d", strtotime($from));
		$to		=	date("Y-m-d", strtotime($to));
		$between=	'ed.egift_used_date between "'.$from .'" and "'.$to.'" AND';	
	}
	 
	$sql = "select * from egifts_data ed where ".$between." ed.egift_payment = 1 and egift_status = 1 group by ed.egift_id";
	$results = get_results($sql);
	return $results;
}

function get_coupon_data($from,$to)
{
	$between	='';
	if($from!='' && $to!='')
	{
		$from	=	date("Y-m-d", strtotime($from));
		$to		=	date("Y-m-d", strtotime($to));
		$between=	' and o.order_date between "'.$from .'" and "'.$to.'"';	
	}
	
	$sql = "select * from orders o where order_status = 1 and order_coupon_code != '' and order_coupon_amount != '' ".$between."";
	$results = get_results($sql);
	return $results;
}
function get_turnover_data($from,$to)
{
	$between	='';
	if($from!='' && $to!='')
	{
		$from	=	date("Y-m-d", strtotime($from));
		$to		=	date("Y-m-d", strtotime($to));
		$between=	' o.order_date between "'.$from .'" and "'.$to.'" AND ';	
	}
	
	$sql		=	"select *,(order_net_amount + order_coupon_amount + order_ewallet_amount) as gross_value from orders o where ".$between." o.order_status between 2 and 8";
	$results	=	get_results($sql);
	return $results; 	
}

function get_stores_for_reports($from,$to)
{
	$between	='';
	if($from!='' && $to!='')
	{
		$from	=	date("Y-m-d", strtotime($from));
		$to		=	date("Y-m-d", strtotime($to));
		$between	=	'store_created_date between "'.$from .'" and "'.$to.'" AND';	
	}

	
	$sql = "select * from store where ".$between." store_status != 3 and store_completion = 2";
	$results = get_results($sql);
	return $results;
}
function get_merchant_payout_detail($from,$to,$type)
{
	/*$from	=	date("Y-m-d", strtotime($from));
	$to		=	date("Y-m-d", strtotime($to));
	$sql = "select * from account_payout acp , acct_billing ab where acp.acct_po_date between '".$from."' AND '".$to."' AND acp.acct_po_for =".$type;
	$results = get_results($sql);
	return $results;*/
	
	$between	='';
	if($from!='' && $to!='')
	{
		$from	=	date("Y-m-d", strtotime($from));
		$to		=	date("Y-m-d", strtotime($to));
		$between	=	' and act_bill_createddate between "'.$from .'" and "'.$to.'"';	
	}
	
	$sql = "select *,
				sum(act_bill_price) as turnover_amount,
				sum(act_bill_shipcost + act_bill_shiptax) as total_shipping_amount,
				sum(act_bill_catcost + act_bill_cattax) as total_commision_amount,
				sum(act_bill_netpayout) as total_net_amount
			from acct_billing ab where act_bill_pay_status = 1 ".$between."  group by act_bill_storeid";
	$results = get_results($sql);
	return $results;
}
function get_store_orders($store_id)
{
	$sql = "select * from order_products where op_store_id = ".$store_id." and op_order_status = 2 order by op_id desc";
	$results = get_results($sql);
	return $results;
}

function get_merchant_commision_detail($from,$to,$type)
{
	$between	='';
	if($from!='' && $to!='')
	{
		$from	=	date("Y-m-d", strtotime($from));
		$to		=	date("Y-m-d", strtotime($to));
		$between	=	' and act_bill_createddate between "'.$from .'" and "'.$to.'"';	
	}
	
	$sql = "select * from acct_billing ab where act_bill_pay_status = 1 ".$between;
	$results = get_results($sql);
	return $results;
	
}

function get_dist_payout_detail($from,$to,$type)
{
	$from	=	date("Y-m-d", strtotime($from));
	$to		=	date("Y-m-d", strtotime($to));
	$sql = "select * from account_payout acp , distributor_billing ab where acp.acct_po_date between '".$from."' AND '".$to."' AND acp.acct_po_for =".$type;
	$results = get_results($sql);
	return $results;
}

function get_shipp_detail($from,$to)
{
	$from	=	date("Y-m-d", strtotime($from));
	$to		=	date("Y-m-d", strtotime($to));
	$sql = "select op.op_order_id,op.op_invoice_created_date,op.op_product_id,op.op_store_id,op.op_price from order_products op where op.op_invoice_created_date between '".$from."' AND '".$to."' AND op.op_product_status = 7";
	$results = get_results($sql);
	return $results;
}
?>