<?php
/****************************************
	Reports Functions
*****************************************/

function get_chart_order()
{
	$store_id = $_SESSION['ADMIN_STORE_ID'];
	$sql = "select * from orders o,order_products op,products where op.op_store_id=".$store_id." and op.op_order_status != 0 and op.op_order_status <=3 group by op.op_order_id order by op.op_id  desc";
	$results = get_results($sql);
	return $results;
}

function order_by_datewise()
{
	$store_id = $_SESSION['ADMIN_STORE_ID'];
	$sql = "select count(*) as order_date,sum(order_amount) as total,order_date from orders group by order_date";
	$results = get_results($sql);
	return $results;
}

function order_by_product()
{
	$store_id = $_SESSION['ADMIN_STORE_ID'];
	$sql = "select count(*) as order_date,sum(order_amount) as total,order_date from orders group by order_date";
	$results = get_results($sql);
	return $results;
}

function view_by_product()
{
	$store_id = $_SESSION['ADMIN_STORE_ID'];
	$sql = "select * from products p,order_products ops where ops.op_store_id=".$store_id." group by ops.op_store_id";
	$results = get_results($sql);
	return $results;
}

function get_top_selling_products()
{
	$sql = "SELECT * FROM `products` ORDER BY `products`.`product_sold` DESC LIMIT 10";
	$results = get_results($sql);
	return $results;	
}
function get_top_seller()
{
//	$store_id = $_SESSION['ADMIN_STORE_ID'];
	$sql = "select * from store_review GROUP BY sr_store_id ORDER BY `sr_rate` DESC LIMIT 10";
	$results = get_results($sql);
	return $results;	
}

function get_total_products_sold()
{
	$store_id = $_SESSION['ADMIN_STORE_ID'];
	$sql = "select count(product_sell_count) as total_sold from products where product_store=".$store_id;
	$results = get_results($sql);
	return $results;	
}
function get_vendor_report_data()
{
	$store_id = $_SESSION['ADMIN_STORE_ID'];
	$sql = "select * from order_products where op_store_id=".$store_id;
	$results = get_results($sql);
	return $results;	
	
}
function get_top_products_sold_day_by_day()
{
	$date = date('Y-m-d');
	$sql = "select * from orders o, order_products op, products p where o.order_date = '2014-9-18' order by o.order_date";
	//echo $sql = "select * from orders o, order_products op, products p where o.order_date = '2014-09-18' order by o.order_date";
	//$sql = "select * from orders o, order_products op, products p where o.order_date = '".$date."' order by o.order_date";
	//echo $sql = "select * from orders o, order_products op where o.order_date LIKE '".$date."' order by o.order_date";
	$results = get_results($sql);
	return $results;	
}
function vendor_payout()
{
	$sql = "select *, sum(act_bill_netpayout) as total from acct_billing where act_bill_pay_status = 2 group by act_bill_storeid order by act_bill_generatedate";
	$results = get_results($sql);
	return $results;		
}
function egift_report_data()
{
	$sql = "select *, sum(act_bill_netpayout) as total from acct_billing where act_bill_pay_status = 2 group by act_bill_storeid order by act_bill_generatedate";
	$results = get_results($sql);
	return $results;		
	
}
function total_egifts_data()
{
	$sql = "select sum(egift_price) as total from egifts_data where egift_status != 3";
	$results = get_row($sql);
	return $results;
}

?>