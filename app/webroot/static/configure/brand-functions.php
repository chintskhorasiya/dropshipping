<?php 
/****************************************
	brand related Functions
*****************************************/
function get_brands()
{
	$sql = "select * from brand where brand_status != 3 order by brand_id desc";
	$results = get_results($sql);
	return $results;
}
function get_brand_name($id)
{
	$sql = "select brand_name from brand where brand_id=".$id;
	$results = get_row($sql);
	return $results['brand_name'];
}
function get_brand_detail($id)
{
	$sql = "select * from brand where brand_id=".$id;
	$results = get_row($sql);
	return $results;
}	
function get_brand_options()
{
	$sql = "select brand_id,brand_name from brand where brand_status = 1";
	$results = get_results($sql);
	return $results;
}
function get_brand_bycountry($brand_country)
{
	$sql = "select brand_id,brand_name from brand where country_id='".$brand_country."' and brand_status = 1";
	$results = get_results($sql);
	return $results;
}
function check_brand_duplicate($name)
{
	$sql = "select brand_id from brand where brand_name='".$name."'";
	$results = get_row($sql);
	
	if($results['brand_id'] != '')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function get_multibrand_options($parent='0')
{
	$sql = "select brand_id,brand_name from brand where brand_status != 3 AND country_id=".$parent;
	$results = get_results($sql);
	return $results;
}
function search_brands($status)
{
	$sql = "select * from brand where brand_status=".$status;
	$results = get_results($sql);
	return $results;
}
function get_brand_search_result($queryString){
	$sql = 	"SELECT brand_name,brand_id FROM brand WHERE brand_name LIKE '%$queryString%'";
	$results= get_results($sql);
	return $results;
}
function check_products_brand_name($name)
{
	
	$sql = "select brand_id,brand_name from brand where brand_name like '$name'";
	$results = get_row($sql);
//	echo $name;
	//echo count($results);
	if(count($results['brand_name'])>0)
	{
		return $results['brand_id'];
	}
	else
	{
        $current_date = date('Y-m-d H:i:s');
		$add_brand['brand_name']		= ucfirst($name);
		$add_brand['brand_status']		= 1;
		$add_brand['brand_created_date']=	$current_date;
		$add_brand['brand_created_by']	=	$_SESSION['ADMIN_STORE_ID'];
		
		$insert_id = insert_data('brand',$add_brand);
		return $insert_id;		
	}
}
function new_brand_notification()
{
	$sql = 	"SELECT * FROM brand WHERE brand_created_by != 0 AND brand_view_by_admin != 0";
	$results= get_results($sql);
	return $results;
}
?>