<?php 
/****************************************
	Category Functions
*****************************************/
$attribute_types = array(
					'select'=> 'Drop-down list',
					'radio' => 'Radio button',
					'color' => 'Color'
);
function get_variation()
{
	$sql = "select * from variation_group where variation_status != 3";
	$results = get_results($sql);
	return $results;
}
function get_variation_detail($id)
{
	$sql = "select * from variation where variation_id=".$id;
	$results = get_row($sql);
	return $results;
}
function get_variation_group_detail($id)
{
	$sql = "select * from variation_group where variation_id=".$id;
	$results = get_row($sql);
	return $results;
}
function get_variation_name($id)
{
	$sql = "select variation_name from variation_group where variation_id=".$id;
	$results = get_row($sql);
	return $results['variation_name'];
}
function get_variation_options()
{
	$sql = "select from variation where variation_status = 1";
	$results = get_results($sql);
	return $results;
}
function get_variation_group_options()
{
	$sql = "select * from variation_group where variation_status = 1";
	$results = get_results($sql);
	return $results;
}
function get_variation_category_detail($id)
{
	$sql = "select * from variation_categories where vc_variation_id=".$id;
	$results = get_results($sql);
	return $results;
}
function get_group_variation_detail($id)
{
	$sql = "select * from variation where id_attribute_group=".$id;
	$results = get_results($sql);
	return $results;
}
function variation_values_count($id){
	$sql = "select count(id_attribute_group)as total from variation where id_attribute_group=".$id." GROUP BY `id_attribute_group`";
	$results = get_row($sql);
	return ($results['total']>0)?$results['total']:0;
}
function check_variation_duplicate($name,$variation_id=0)
{
	$sql = "select variation_id from variation where id_variation_name='".$name."'";
	$results = get_row($sql);
	
	if($results['variation_id'] != '' && $variation_id != $results['variation_id'])
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function check_variation_group_duplicate($name)
{
	$sql = "select variation_id from variation_group where variation_name='".$name."'";
	$results = get_row($sql);
	
	if($results['variation_id'] != '')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function get_multivariation_options($parent='0')
{
	$sql = "select variation_id,variation_name from variation where variation_status != 3 AND variation_parent_id=".$parent;
	$results = get_results($sql);
	return $results;
}
function search_variations($status)
{
	$sql = "select * from variation where variation_status=".$status;
	$results = get_results($sql);
	return $results;
}
function variation_selected($cat_id,$variation_id){
	$sql = "SELECT cv_id FROM `category_variation` WHERE cv_category_id=".$cat_id." AND cv_variation_id = ".$variation_id."";
	$results = get_row($sql);
	
	if($results['cv_id'] != '')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function get_variation_by_cat_id($cat_id)
{
	//$sql = "select variation_id,variation_name from variation where variation_status = 1 and cv_category_id = ".$cat_id."";
	$sql = "SELECT * FROM `category_variation` cv, variation v where cv.`cv_variation_id`=v.variation_id and variation_status = 1 and cv.`cv_category_id` = ".$cat_id."";
	//op variation_name,variation_id,cv_id
	$results = get_results($sql);
	return $results;
}
function get_variation_groupby_cat_id($cat_id)
{
	$group_list = array();
	$variations = array();
	//$sql = "select variation_id,variation_name from variation where variation_status = 1 and cv_category_id = ".$cat_id."";
	$sql = "SELECT v.variation_id as id_attribute_group FROM `variation_categories` vc, variation_group v where vc.`vc_variation_id`=v.variation_id and variation_status = 1 and vc.`vc_main_category_id` = ".$cat_id."";
	//op variation_name,variation_id,cv_id
	$results = get_results($sql);
	
	if($results)
	{
		foreach($results as $key=> $value)
		{
			if(!in_array($value['id_attribute_group'],$group_list))
				$group_list[] = $value['id_attribute_group'];
		}
	}
	 
	if(count($group_list) > 0)
	{
		$group_list = implode(',',$group_list);
		$sql = "select * from variation_group where variation_status != 3 and variation_id in(".$group_list.")";
		$variations = get_results($sql);
		//pre($variations);
		return $variations;
	}
	return $variations;
}
function array_cartesian_product($arrays)
{
    $result = array();
    $arrays = array_values($arrays);
    $sizeIn = sizeof($arrays);
    $size = $sizeIn > 0 ? 1 : 0;
    foreach ($arrays as $array)
        $size = $size * sizeof($array);
    for ($i = 0; $i < $size; $i ++)
    {
        $result[$i] = array();
        for ($j = 0; $j < $sizeIn; $j ++)
            array_push($result[$i], current($arrays[$j]));
        for ($j = ($sizeIn -1); $j >= 0; $j --)
        {
            if (next($arrays[$j]))
                break;
            elseif (isset ($arrays[$j]))
                reset($arrays[$j]);
        }
    }
    return $result;
}
/*function update_single_product_variation($id,$vari_data){
	$get_product_variation = get_product_variation($id);
	$vari_data = array_cartesian_product($vari_data['attributes']);
	$product_detail = get_products_detail($id);
	//pre($product_detail);
	//exit;
	//$vari_data = array_cartesian_product($vari_data['options']);
	$data = array();
	$combi_data = array();
	foreach($vari_data as $key_vai_id =>$innerArray){
		$data['pv_product_id'] = $id;
		$data['price'] = $product_detail['product_selling_price'];
		$data['quantity'] = 1;
		$data['discount_price'] = $product_detail['product_discount'];
		$pv_id = insert_data('product_variation',$data);
	   foreach($innerArray as $key => $value){
			//echo $key_vai_id.'->'.$key.'--'.$value;
			$combi_data['pv_id'] = $pv_id;
			$combi_data['variation_id'] = $value;
			insert_data('product_variation_combination',$combi_data);
			$values[$pv_id][] = $value;
		}
		
	}
	foreach($values as $pv_id => $val){
		sort($val);
		$vals = implode(",", $val);
		$combi_new_data['pv_id'] = $pv_id;
		$combi_new_data['product_variations_com'] = $vals;
		update_data('product_variation',$combi_new_data,'pv_id='.$pv_id);//$_POST,'product_id='.$product_id)
	}
	//pre($values);
	
		
}*/
function update_product_variation($id,$vari_data,$new){
	if($new==''){
		$get_product_variation = get_product_variation($id);
		foreach($get_product_variation as $product_variation){
			$pv_id_del = $product_variation['pv_id'];
			$sql = "delete from  product_variation_combination where pv_id=".$pv_id_del;
			$results = db_query($sql);
		}
		$sql = "delete from product_variation where pv_product_id=".$id;
		$results = db_query($sql);
	}
	$vari_data = array_cartesian_product($vari_data['attributes']);
	$product_detail = get_products_detail($id);
	$data = array();
	$combi_data = array();
	foreach($vari_data as $key_vai_id =>$innerArray){
		$data['pv_product_id'] = $id;
		//$data['price'] = $product_detail['product_selling_price'];
		//$data['quantity'] = $product_detail['product_qty'];
		//$data['discount_price'] = $product_detail['product_discount'];
		$data['price'] = $product_detail['product_price'];
		$data['quantity'] = $product_detail['product_qty'];
		$data['discount_price'] = $product_detail['product_selling_price'];
		$available_variation = get_product_variation_data($id,$innerArray);
		/*if($available_variation){
			return false;
		}*/
		$pv_id = insert_data('product_variation',$data);
	   foreach($innerArray as $key => $value){
			$combi_data['pv_id'] = $pv_id;
			$combi_data['variation_id'] = $value;
			insert_data('product_variation_combination',$combi_data);
			$values[$pv_id][] = $value;
		}
		
	}
	foreach($values as $pv_id => $val){
		sort($val);
		$vals = implode(",", $val);
		$combi_new_data['pv_id'] = $pv_id;
		$combi_new_data['product_variations_com'] = $vals;
		update_data('product_variation',$combi_new_data,'pv_id='.$pv_id);//$_POST,'product_id='.$product_id)
	}
	return true;
}
function get_product_variation($id){
	$sql = "SELECT * FROM `product_variation` where pv_product_id = ".$id."";
	$results = get_results($sql);
	return $results;
}
function get_product_variation_distinct($id){
	$sql = "SELECT DISTINCT pv_variation_id FROM `product_variation` where pv_product_id = ".$id."";
	$results = get_results($sql);
	return $results;
}
function get_variation_product_name($id)
{
	$sql = "select * from products where product_id=".$id;
	$results = get_row($sql);
	return $results['product_name'];
}
function get_variation_group_id($id){
	$sql = "select * from products where product_id=".$id;
	$results = get_row($sql);
	return $results['product_name'];
}
function variation_group_data($id){
	$sql = "select * from product_variation_combination where pv_id=".$id;
	$variation_data = get_results($sql);
	$counter = 0;
	foreach($variation_data as $vari_data){
		$variation_id = $vari_data['variation_id'];
		$variatio_group = get_variation_detail($variation_id);
		$variatio_group_id = $variatio_group['id_attribute_group'];
		$id_variation_name = $variatio_group['id_variation_name'];
		($counter > 0)?$get_variation_name .= ', ':'';
		$get_variation_name .= get_variation_name($variatio_group_id).' - '.$id_variation_name;
		$counter++;
	}
	return $get_variation_name;
}
function get_product_variation_combination($id){
	$sql = "select * from product_variation_combination where pv_id=".$id;
	$results = get_row($sql);
	return $results;
	
}
function get_all_variation_by_category_id($cat_id){
	$sql = "select * from variation_categories where vc_category_id=".$cat_id;
	$results = get_results($sql);
	return $results;
}
function get_variation_group_name($id)
{
	$sql = "select variation_name from variation_group where variation_id=".$id;
	$results = get_row($sql);
	return $results['variation_name'];
}
function get_group_variation_id($id)
{
	//$sql = "SELECT * FROM `product_variation` pv,variation v, product_variation_combination pvc where pv_product_id = ".$id." and pv.pv_id = pvc.pv_id group by id_attribute_group ORDER BY `v`.`id_variation_name` DESC ";
	$sql = "SELECT *,v.variation_id as v_id FROM product_variation pv, product_variation_combination pvc, variation v, variation_group vg WHERE pv.`pv_product_id` = ".$id." and pv.pv_id = pvc.pv_id and v.variation_id = pvc.variation_id and vg.variation_id = v.id_attribute_group group by vg.variation_name";
	$results = get_results($sql);
	return $results;
}
function get_product_variation_detail($p_id,$v_id,$g_id){
	$sql="SELECT *,v.variation_id as v_id FROM product_variation pv, product_variation_combination pvc, variation v, variation_group vg WHERE pv.`pv_product_id` = ".$p_id." and v.id_attribute_group = ".$g_id." and v.variation_id = ".$v_id." group by v.variation_id";
	$results = get_row($sql);
	return $results;
}
function get_product_variation_data($id,$v_data){
	sort($v_data);
	$v_data = implode(",", $v_data);
	
	$sql = "select * from product_variation where pv_product_id=".$id." and product_variations_com = '".$v_data."'";
	$results = get_row($sql);
	return $results;
}
function identical_values( $arrayA , $arrayB ) {
    sort( $arrayA );
    sort( $arrayB );
    return $arrayA == $arrayB;
}


//redspark functions
function check_variation_duplicate_by_id($name,$id)
{
    $sql = "select variation_id from variation where id_variation_name='".$name."' and id_attribute_group=".$id;
    $results = get_row($sql);

    if($results['variation_id'] != '')
    {
        return 1;
    }
    else
    {
        return 0;
    }
}
?>