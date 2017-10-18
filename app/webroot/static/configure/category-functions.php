<?php 
    /****************************************
    Category Functions
    *****************************************/
    function get_categories()
    {
        $sql = "select * from category where category_status = 1";
        $results = get_results($sql);
        return $results;
    }
    function get_category_detail($id)
    {
        $sql = "select * from category where category_id=".$id;
        $results = get_row($sql);
        return $results;
    }
    function get_cat_name($id)
    {
        $sql = "select category_name from category where category_id=".$id;
        $results = get_row($sql);
        return $results['category_name'];
    }
    function get_cat_options()
    {
        $sql = "select category_id,category_name from category where category_status = 1";
        $results = get_results($sql);
        return $results;
    }
    function get_multicat_options($parent='0')
    {
        $sql = "select * from category where category_status = 1 AND category_parent_id=".$parent;
        $results = get_results($sql);
        return $results;
    }
    function check_cat_duplicate($name)
    {
        $sql = "select category_id from category where category_name='".$name."'";
        $results = get_row($sql);
        if($results['category_id'] != '')
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    function search_categories($params = array())
    {
        $where = '';
        if($params)
        {
            foreach($params as $param_key => $param_value)
            {
                if($param_value != '')
                    $where .= $param_key.'="'.$param_value.'" AND ';
            }
        }
        if($where != '')
        {
            $where = ' where '.$where;
            $where = trim($where,' AND ');
        }

        $sql = "select * from category ".$where;
        $results = get_results($sql);
        return $results;
    }
    function update_category_commision($id,$value)
    {
        $sql = 'UPDATE category SET category_commision = '.$value.' WHERE `category`.`category_id` ='.$id.'';
        $results = get_results($sql);
        return $results;
    }
    function get_cat_details($id)
    {
        $query = mysql_query("SELECT * FROM category where category_id=".$id);
        if(mysql_num_rows($query) > 0)
        {
            $i = 0;
            while($temp = mysql_fetch_array($query))
            {
                $data[$i] = $temp;
                $i++;
            }
            return $data;
        }
        else return 0;  
    }
    function get_category_by_id($id){
        /*$sql = "select category_id,category_name,category_parent_id from category where category_status = 1 && category_parent_id=".$cat_id;
        $results = get_results($sql);

        foreach($results as $result){
        $results1 .= '<option value="'.$result['category_id'].'" >&nbsp;&nbsp;&nbsp;&nbsp;'.$result['category_name'].'</option>';
        }

        return $results1;*/
        $query = mysql_query("SELECT * FROM category where category_parent_id=".$id);

        if(mysql_num_rows($query) > 0)
        {
            $i = 0;
            while($temp = mysql_fetch_array($query))
            {
                $data[$i] = $temp;
                $i++;
            }
            return $data;
        }
        else
        {
            return 0;
        }
    }
    function get_parent_id($cat_id){
        $sql = "select category_id,category_parent_id from category where category_status = 1 AND category_id=".$cat_id;
        $results = get_row($sql);
        return $results;
    }
    function category_sub_cat_dropdown_full($id,$current_cat_id){
        $get_parent_id = get_parent_id($id,$current_cat_id);
        $parent_id = 0;
        $main_cat_id = $get_cu_cat_id = $get_cat_id['category_id'];
        $main_parent_id = $get_cu_parent_id = $get_parent_id['category_parent_id'];
        $array_parent[] = $id;
        $array_parent[] = $main_parent_id;
        while($get_cu_parent_id !=0){
            $get_parent_id = get_parent_id($get_cu_parent_id,$current_cat_id);
            $get_cu_parent_id = $get_parent_id['category_parent_id'];
            $array_parent[] = $get_cu_parent_id;
        }
        //unset($array_parent[count($array_parent)-1]);
        $parent_cat_array = array_reverse($array_parent);
        unset($parent_cat_array[count($parent_cat_array)-1]);
        return $parent_cat_array;
    }
    function category_sub_cat_dropdown($id,$level,$current_cat_id){
        $details_arr = get_cat_details($id);
        //global $current_cat_id;
        if(($details_arr[0]['category_id']) == $current_cat_id){
            $selector = 'selected="selected"';
        }
        if($id != 0)
        { 
            echo "<option value='".$details_arr[0]['category_id']."' ".$selector.">" .show_level($level). $details_arr[0]["category_name"] . "</option>";
        }	
        $childarr = get_category_by_id($id);

        if($childarr != 0)
        {
            $level++;
            for($i=0;$i<count($childarr);$i++)
            {
                /*echo '<pre>';
                print_r($childarr);
                echo '</pre>';*/

                category_sub_cat_dropdown($childarr[$i]["category_id"],$level,$current_cat_id);
            }

        }
    }
    function show_level($level){
        $level_val = "";
        for($i=0;$i<$level;$i++)
        {

            $level_val .= "&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return $level_val;
    }
    global $jj;
    $jj = 0;
    $cat_count =  count(get_categories());
    $cat_count_all = $cat_count;
    function show_cat_subcat_box($id,$product_id,$all_cat){
        $details_arr = get_cat_details($id);

        //pre($all_cat);
        //global $current_cat_id;
        $idVal = 0;
        global $cat_count;
        global $cat_count_all;
        if(count($all_cat) > 0){
            if((in_array($details_arr[0]['category_id'],$all_cat))){
                $check = 'checked';
            }
        }

        if($id != 0)
        { 
            $idVal++;
            echo "<li><input type='checkbox' name='product_category[]' ".$check." value='".$details_arr[0]['category_id']."'><label>".$details_arr[0]["category_name"] . "</label>";
        }	
        $childarr = get_category_by_id($id);

        if($childarr != 0)
        {
            if($idVal == 0){
                $id_class = "id='tree1'";
            }
            echo "<ul ".$id_class.">";	
            for($i=0;$i<count($childarr);$i++)
            {
                $cat_count;
                /*echo '<pre>';
                print_r($childarr);
                echo '</pre>';*/
                $id_class = '';
                show_cat_subcat_box($childarr[$i]["category_id"],$idVal,$all_cat);
                $jj++;
                $cat_count--;
            }
            echo "</ul>";
        }
    }
    //SELECT *  FROM products p,`product_categories` pc WHERE pc.`pc_product_id` = p.product_id limit 0,30;
    //SELECT *  FROM category p,product_categories pc WHERE pc.pc_cat_id = p.category_id and pc.pc_product_id =524 limit 0,30
    function get_cat_details_by_id($id)
    {
        //$query = mysql_query("SELECT *  FROM products p,product_categories pc WHERE pc.pc_product_id = p.product_id and p.product_id =".$id." limit 0,30");
        $sql = "SELECT *  FROM category p,product_categories pc WHERE pc.pc_cat_id = p.category_id and pc.pc_product_id =".$id;
        $results = get_results($sql);
        return $results;
    }
    function check_parent_level($category_id,$parent_id){
        $parent_id;
    }
    function get_product_categorys($product_id){
        $sql = "select group_concat(pc_cat_id) as cat_ids from product_categories where pc_product_id=".$product_id." group by pc_product_id";
        $results = get_results($sql);
        return $results;
    }
    function update_categories_variation($id,$pc_data=array())
    {
        $sql = "delete from category_variation where cv_category_id=".$id;
        $results = db_query($sql);
        foreach($pc_data as $key => $value)
        {
            $data = array();
            $data['cv_variation_id'] = $value;
            $data['cv_category_id'] = $id;
            insert_data('category_variation',$data);
        }	
    }
    /*function update_categories_box($cat_data=array())
    {
    foreach($cat_data as $key => $value)
    {
    $sql = "delete from category_assign where ca_category_id=".$key;
    $results = db_query($sql);
    foreach($value as $single){
    $data = array();
    $data['ca_category_assign_id'] = $single;
    $data['ca_category_id'] = $key;
    insert_data('category_assign',$data);
    }
    }	
    }*/
    function select_category_box()
    {
        $sql = "select * from category_assign";
        $results = get_results($sql);
        return $results;
    }
    function update_categories_box($cat_data=array(),$file)
    {

        foreach($cat_data as $key => $value)
        {
            $file_data['name'] =  $file['category_image']['name'][$key][0];
            $file_data['size'] =  $file['category_image']['size'][$key][0];
            $file_data['type'] =  $file['category_image']['type'][$key][0];
            $file_data['tmp_name'] =  $file['category_image']['tmp_name'][$key][0];
            $file_data['error'] =  $file['category_image']['error'][$key][0];
            $image_name = '';

            if($file_data['name']!='')
            {
                $image_name = upload_image($file_data,CATEGORYPATH,CATEGORY_THUMBPATH,273,400);
                if($image_name) 
                {

                    $data[]	= $image_name;

                    $sql_old = "select * from category_assign where ca_category_id=".$key;
                    $results_old = get_row($sql_old);
                    $old_img 	 = $results_old['category_image'];
                    if($old_img != '')
                    {
                        if(file_exists(CATEGORYPATH.$old_img))
                        {
                            unlink(CATEGORYPATH.$old_img);
                        }
                        if(file_exists(CATEGORY_THUMBPATH.$old_img))
                        {	
                            unlink(CATEGORY_THUMBPATH.$old_img);
                        }	
                    }		
                }
            }
            foreach($value as $single){
                $data = array();
                if($single == 0){
                    $sql_old = "select * from category_assign where ca_category_id=".$key;
                    $results_old = get_row($sql_old);
                    $old_img 	 = $results_old['category_image'];
                    if($old_img != '')
                    {
                        if(file_exists(CATEGORYPATH.$old_img))
                        {
                            unlink(CATEGORYPATH.$old_img);
                            $data['category_image'] = '';
                        }
                        if(file_exists(CATEGORY_THUMBPATH.$old_img))
                        {	
                            unlink(CATEGORY_THUMBPATH.$old_img);
                            $data['category_image'] = '';
                        }	
                    }		
                }
                $data['ca_category_assign_id'] = $single;

                if($image_name!='')
                    $data['category_image']	= $image_name;
                update_data('category_assign',$data,'ca_category_id='.$key);
            }
        }	
    }
    function get_selected($cat_id,$cur_val){
        $sql ="select count(*) as total from category_assign where ca_category_id = ".$cat_id." and ca_category_assign_id = '".$cur_val."'";
        $results = get_row($sql);
        //return $results['total'];

        if($results['total'] > 0)
        {
            return $selected = 'selected=selected';
        }
        return "";
    }
    function get_sub_cat($parent='0')
    {
        $sql = "select * from category where CAT_STATUS = 1 AND CAT_PARENT_ID=".$parent;
        $results = get_results($sql);
        return $results;
    }
    function get_cat_items($id){
        $sql = "select * from category_assign where ca_category_id = ".$id."";
        $result_cat = get_results($sql);
        $results;
        foreach($result_cat as $result_single){
            $cat_id = $result_single['ca_category_assign_id'];
            $get_sub_cat = get_sub_cat($cat_id);
            //pre($result_cat);
            $cat_details = get_category_detail($cat_id);
            $results .= '<li><a href="#">'.$cat_details['category_name'].'</a>';
            if(count($get_sub_cat)>0){
                $results .= '<ul class="children">';
                foreach($get_sub_cat as $sub_cat){
                    $results .= '<li><a href="#">'.$sub_cat['category_name'].'</a></li>';	
                }
                $results .= '</ul>';
            }
            $results .= '</li>';
        }
        return $results;
    }
    function get_sidebar_categories()
    {
        $sql = "select * from category where category_status = 1 and category_sidebar_status = 1";
        $results = get_results($sql);
        return $results;
    }
    function get_menubar_categories()
    {
        $sql = "select * from category where category_status = 1 and category_menu_status = 1";
        $results = get_results($sql);
        return $results;
    }
    function category_sub_cat_by_id($id){
        $details_arr = get_cat_details_by_id($id);
        //return $details_arr;
        //pre($details_arr);
        //exit;
        $count = count($details_arr);
        sort($details_arr);
        for($i=0;$i<$count;$i++)
        {
            if($details_arr[$i]['category_id'] != 0)
            {

            }
            //echo check_parent_level($details_arr[$i]['category_id'],$details_arr[$i]['category_parent_id']);
            echo $details_arr[$i]['category_name'];

            $cat_array = explode(',',$details_arr[$i]['category_name']);
            //sort($cat_array);
            if($count-1!=$i)
                echo ",<br />";
        }

    }



    //redspark fun
    function get_bulk_categories()
    {
        $sql = "select * from category_bulk_upload where status=1";
        $results = get_results($sql);
        return $results;
    }
    function get_bulk_category_detail($id)
    {
        $sql = "select * from category_bulk_upload where status=1 and id=$id";
        $results = get_row($sql);
        return $results;
    }
    function get_cat_id_from_name($name)
    {
        $sql = "select category_id from category where category_name='".$name."'";
        $results = get_row($sql);
        return $results;
    }
?>