<?php 
/****************************************
	advertisement related Functions
*****************************************/
function get_footer_data()
{
	$sql = "select * from footer_data";
	$results = get_row($sql);
	return $results;
}

?>