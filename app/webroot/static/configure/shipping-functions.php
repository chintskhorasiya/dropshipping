<?php 
/****************************************
	shipping Functions
*****************************************/
function get_shipping()
{
	$sql = "select * from shipping_rates where shipping_status!=3";
	$results = get_results($sql);
	return $results;
}
function get_shipping_detail($id)
{
	$sql = "select * from shipping_rates where shipping_id=".$id;
	$results = get_row($sql);
	return $results;
}
function get_shipping_id($id)
{
		$sql	= 	"select * from shipping_rates where shipping_id=".$id;
		$results = get_count($sql);
		return $results;
}
function search_shipping($params = array())
{
	$where = '';
	if($params)
	{
		foreach($params as $param_key => $param_value)
		{
			if($param_value != '')
			{
				//pre($param_value);
				//exit;
				if($param_key == 'country_id')
				{
					$where .= $param_key.' like "%'.$param_value.'%" AND ';
				}
				if($param_key == 'courier_type')
				{
					$where .= $param_key.' like "%' .$param_value.'%" AND ';
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
	
	$sql = "select * from shipping_rates ".$where;
	$results = get_results($sql);
	return $results;
}
function cal_shipping($total_weight)
{
	$sql = "SELECT * FROM `shipping_rates` WHERE shipping_weight <= ".$total_weight." order by shipping_weight desc limit 1";
	$results = get_results($sql);
	return $results;
}
function get_previous_weight($id='')
{
	$condition = '';
	if($id != ''){
		$condition = " and shipping_weight < ".$id ;
	}
	$sql = "select * from shipping_rates where shipping_status!=3 $condition ORDER BY shipping_weight DESC LIMIT 1";
	$results = get_row($sql);
	return $results['shipping_weight'];
}
function weight_duplicate($weight='')
{
	$condition = '';
	if($user_id != '')
	{
		$condition = 'AND user_id != '.$user_id;
	}
	$sql = "select count(*) as total from shipping_rates where shipping_status!=3 shipping_weight >= ".$weight;
	$results = get_row($sql);
	return $results['total'];

}
function get_product_weight_options(){
	$sql = "select shipping_id,shipping_weight from shipping_rates where shipping_status != 3";
	$results = get_results($sql);
	return $results;	
}

?>