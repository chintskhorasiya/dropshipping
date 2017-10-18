<?php 

/****************************************

	Reviews Functions

*****************************************/

function get_reviews()

{

	

	$sql = "select * from products,product_reviews where product_id = pr_product_id order by pr_created_date desc";

	$results = get_results($sql);

	return $results;

}

function get_product_reviews($id)
{
	$sql = "select * from products,product_reviews where pr_product_id = ".$id." and product_id = pr_product_id order by pr_created_date desc";
	$results = get_results($sql);
	return $results;
}

function get_product_reviews_by_customer($id)
{
	$sql = "select * from product_reviews where pr_id = ".$id." order by pr_created_date desc";
	$results = get_row($sql);
	return $results;
}

function get_store_reviews()
{

	$sql = "select * from store_review order by sr_created_date desc";

	$results = get_results($sql);

	return $results;

}

function get_store_reviews_by_customer($id)
{
	$sql = "select * from store_review where sr_id = ".$id." order by sr_created_date desc";
	$results = get_row($sql);
	return $results;
}

function search_store_reviews($status)

{

	$sql = "select * from store_review where sr_status =".$status;

	$results = get_results($sql);

	return $results;

}

function get_rating_html($rate)
{
	$html = '';
	for($i=1;$i<=5;$i++)
	{
		if($i <= $rate)
		{
			$html .= '<div class="star star_on"></div>';
		}
		else
		{
			$html .= '<div class="star"></div>';
		}
	}
	return $html;
}

?>