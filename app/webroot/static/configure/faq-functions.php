<?php
/****************************************
	FAQs AND FAQs Category Functions
*****************************************/
function get_faqs()
{
	$sql = "select * from faq where faq_status != 3";
	$results = get_results($sql);
	return $results;
}
function get_faqs_admin()
{
	$sql = "select * from faq where faq_status = 1 and faq_display = 2";
	$results = get_results($sql);
	return $results;
}
function get_faqs_front()
{
	$sql = "select * from faq where faq_status = 1 and faq_display = 1";
	$results = get_results($sql);
	return $results;
}
function get_faqs_detail($id)
{
	$sql = "select * from faq where faq_status != 3 AND faq_id=".$id;
	$results = get_row($sql);
	return $results;
}
function get_faq_cat()
{
	$sql = "select * from faq_category where faq_status != 3";
	$results = get_results($sql);
	return $results;
}
function get_faqcat_detail($id)
{
	$sql = "select * from faq_category where faq_status != 3 AND faq_cat_id=".$id;
	$results = get_row($sql);
	return $results;
}
function get_faqcat_name($id)
{
	$sql = "select faq_cat_name from faq_category where faq_status != 3 AND faq_cat_id=".$id;
	$results = get_row($sql);
	return $results['faq_cat_name'];
}
/*
function get_faqcat_options()
{
	$sql = "select faq_cat_id,faq_cat_name from faq_category where faq_status = 1";
	$results = get_results($sql);
	return $results;
}
function get_faqmulticat_options($parent='0')
{
	$sql = "select faq_cat_id,faq_cat_name from faq_category where faq_cat_status = 1 AND faq_cat_parent_id=".$parent;
	$results = get_results($sql);
	return $results;
}
*/
function get_faqmulticat_options($parent='0')
{
	$sql = "select faq_cat_id,faq_cat_name from faq_category where faq_status != 3 AND faq_cat_parent_id=".$parent;
	$results = get_results($sql);
	return $results;
}
function get_faqcat_options()
{
	$sql = "select faq_cat_id,faq_cat_name from faq_category where faq_status != 3";
	$results = get_results($sql);
	return $results;
}
function get_faq_categorys($id){
	$sql = "select * from faq_category where faq_status != 3 AND faq_cat_id=".$id;
	$results = get_results($sql);
	return $results;
}
function get_faq_cat_detail($id)
{
	$sql = "select * from faq_category where faq_status != 3 AND faq_cat_id =".$id;
	$results = get_row($sql);
	return $results;
}
function get_multifaqcat_options($parent='0')
{
	$sql = "select faq_cat_id,faq_cat_name from faq_category where faq_status != 3 AND faq_cat_parent_id!=".$parent;
	$results = get_results($sql);
	return $results;
}
/*
function get_sll_child_cat($parent_id)
{
	$sql = "select category_id,category_name from category where category_status != 3 AND category_parent_id=".$parent;
	$results = get_results($sql);
	return $results;
	}*/
	
function get_faq_by_parent()
{
	$sql = "select * from faq_category where faq_status != 3 AND faq_cat_parent_id = 0 ";
	$results = get_results($sql);
	return $results;
}
function get_faq_by_parentid($id)
{
	$sql = "select * from faq_category where faq_status != 3 AND faq_cat_parent_id =".$id;
	$results = get_results($sql);
	return $results;
}
function get_faq_all_det($id)
{
	$sql = "select * from faq where faq_status != 3 AND faq_cat_id =".$id;
	$results = get_results($sql);
	return $results;
}
function get_que_ans($id)
{
		$sql = "select faq_que,faq_ans from faq where faq_status != 3 AND  faq_display = 1 AND faq_cat_id=".$id;
	$results = get_results($sql);
	return $results;
}
?>