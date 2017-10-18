<?php 
/****************************************
	Page Functions
*****************************************/
function get_pages()
{
	$sql = "select * from pages where page_status!=3";
	$results = get_results($sql);
	return $results;
}
function get_page_detail($id)
{
	$sql = "select * from pages where page_id=".$id;
	$results = get_row($sql);
	return $results;
}
function get_page_id($id)
{
		$sql	= 	"select * from pages where page_id=".$id;
		$results = get_count($sql);
		return $results;
}
function search_pages($status)
{
	$sql = "select * from pages where page_status=".$status;
	$results = get_results($sql);
	return $results;
}
function get_index_viewer()
{
	$sql = "select setting_value from settings where setting_field ='elala_total_visits'";
	$results = get_row($sql);
	return $results['setting_value'];
}
function setpage_slug($pagename,$page_id=0)
{
	 $pagename=$oldpagename = create_slug($pagename);
	 $i=1;
	 while(comparepage_slug($pagename,$page_id)>0)
		 {
		 	$pagename = $oldpagename.'-'.$i;
			$i++;
		 }
	 return $pagename;	 
}
function comparepage_slug($pagename,$page_id=0)
{
	$and_c = '';
	if($page_id!=0)
	{
		$and_c = " and page_id !=".$page_id;	
	}
	$sql = "select count(*) as total from pages where page_title='".$pagename."'".$and_c;
	$results = get_row($sql);
	return $results['total'];
}
?>