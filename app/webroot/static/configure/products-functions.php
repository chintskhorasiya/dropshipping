<?php 
/****************************************
	Products Functions
*****************************************/
function get_products()
{
	$sql = "select * from products where product_status !=3 order by product_created_date desc";
	$results = get_results($sql);
	return $results;
}

function get_products_published()
{
	$sql = "select * from products where product_status =1 order by product_created_date desc";
	$results = get_results($sql);
	return $results;
}

function get_live_products()
{
	$sql = "select * from products where product_status = 1 and product_admin_status =1 order by product_created_date desc";
	$results = get_results($sql);
	return $results;
}
function get_pending_products()
{
	$sql = "select * from products where product_status !=3  and product_admin_status = 0 order by product_created_date desc";
	$results = get_results($sql);
	return $results;
}
function get_products_detail($id)
{
	$sql = "select * from products where product_id=".$id;
	$results = get_row($sql);
	return $results;
}
function update_product_categories($id,$pc_data=array())
{
	$sql = "delete from product_categories where pc_product_id=".$id;
	$results = db_query($sql);
	foreach($pc_data as $key => $value)
	{
		if($value != ''){
		$data = array();
		$data['pc_cat_id'] = $value;
		$data['pc_product_id'] = $id;
		insert_data('product_categories',$data);
		}
	}	
}
function search_products($params = array())
{
	$where = '';
	if($params)
	{
		foreach($params as $param_key => $param_value)
		{
			if($param_value != '')
			{
				if($param_key == 'product_name')
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
	
	$sql = "select * from products ".$where;
	$results = get_results($sql);
	return $results;
}
function search_products_latest_offer($params = array())
{
	//pre($params);
	$where = '';
	$flag = 0;
	if($params)
	{
		foreach($params as $param_key => $param_value)
		{
			if($param_value != '')
			{
				if($param_key == 'product_name')
				{
					$where .= $param_key.' like "%'.$param_value.'%" AND ';
				}
				else
				{
					$where .= $param_key.'="'.$param_value.'" AND ';
					$flag = 1;
				}
				
			}	
		}
	}
	if($flag == 1)
		$where .= " pc_product_id = product_id";
	
	//echo $where;
	if($where != '')
	{
		$where = ' where '.$where;
		$where = trim($where,' AND ');
	}
	$where .= " product_status = 1 and product_admin_status =1 and group by product_id";
	$sql = "select * from products p,product_categories pc ".$where."";
	$results = get_results($sql);
	return $results;
}
function get_latest_offer_products(){
	$sql = "select * from latest_offer_products";
	$results = get_results($sql);
	return $results;
}
function setproduct_slug($productname)
{
	 $productname=$oldproductname = create_slug($productname);
	 $i=1;
	 while(compareproduct_slug($productname)>0)
		 {
		 	$productname = $oldproductname.'-'.$i;
			$i++;
		 }
	 return $productname;	 
}
function compareproduct_slug($productname)
{
	$sql = "select count(*) as total from products where product_slug='".$productname."'";
	$results = get_row($sql);
	return $results['total'];
}
function create_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(stripslashes($string)));
   $slug=preg_replace('/[-]+/', '-', $slug);
   $slug=trim($slug,'-');
   return $slug;
}
// Emails
function send_product_approved_email($product_ids = array())
{
	foreach($product_ids as $key => $product_id)
	{
		$product_detail = get_product_detail($product_id);
		$product_name   = $product_detail['product_name'];
		$product_store  = $product_detail['product_store'];
		$store_detail   = get_store_detail($product_store);
		$store_email    = $store_detail['store_email'];
		
		include('email/approved-email.php');
		
		$subject = 'Product Approval Status from E-lala!';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		
		// Mail it
		mail($store_email, $subject, $html, $headers);
	}	
}
function send_product_rejected_email($product_ids = array())
{
	foreach($product_ids as $key => $product_id)
	{
		$product_detail = get_product_detail($product_id);
		$product_name   = $product_detail['product_name'];
		$product_store  = $product_detail['product_store'];
		$store_detail   = get_store_detail($product_store);
		$store_email    = $store_detail['store_email'];
		$store_fullname    = $store_detail['store_fullname'];
		
		include('email/rejected-email.php');
		
		$subject = 'Product Approval Status from Purchasekaro!';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		
		// Mail it
		mail($store_email, $subject, $html, $headers);
	}	
}
function discount_percentage($product_selling_price=1, $product_price=0){
	$disc_perc = 0;
	if($product_selling_price > 0 && $product_price > 0){
		$disc_perc = ceil(($product_price - $product_selling_price)*100 / $product_price);
	}
	return $disc_perc;
}
function update_product_price($id,$value)
{
	$sql = 'UPDATE products SET product_selling_price = '.$value.' WHERE `product_id` ='.$id.' and product_price >'.$value.' ';
	$results = get_results($sql);
	return $results;
}
function subtrac_product_qty($id,$qty)
{
	//Quantity is Subtract from current quantity
	$sql = 'UPDATE products SET product_qty = product_qty - '.$qty.' WHERE `product_id` ='.$id.' and product_qty > 0';
	$results = mysql_query($sql);
}
?>