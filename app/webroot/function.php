<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = 'root';
$db_name = 'dropshipping';

define("ID_LENGTH",'20');
define("DEFAULT_URL","http://".$_SERVER["HTTP_HOST"]."/dropshipping/");

$link_id = mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name, $link_id);

function check_url($content)
{
    $check_url = explode('://',$content);
    if(count($check_url)>1)
    {
        //echo 'Url';
        return 1;
    }
    else
    {
        //echo 'No Url';
        return 0;
    }
}
function get_awnid($content)
{
    $explode_content = explode('dp/',$content);
    $explode_ncontent = explode('/',$explode_content[1]);
    return $awnid = $explode_ncontent[0];
//        echo
//        $this->pre($explode_content);

}

function db_query($sql, $type = "") {
    $result_id = mysql_query($sql);
    if ($type != "ins")
        return $result_id;
    else
        return mysql_insert_id();
}

function insert_data($table, $data) {
//    echo "vivek12";
//    pre($data);
//    exit;

    $q = "INSERT INTO `" . $table . "` ";
    $v = '';
    $n = '';
    foreach ($data as $key => $val) {
        if (strtolower($val) != '')
        {
            $n.="`$key`, ";
            if (strtolower($val) == 'now()')
                $v.="NOW(), ";
            else
                $v.= "'" . ($val) . "', ";
        }
    }

    $q .= "(" . rtrim($n, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";
//    echo $q;
//    exit;

    if (db_query($q)) {
        //$this->free_result();
        return mysql_insert_id();
    }
    return false;
}

function import_categories($awsCategories, $sourceid){
    //
    if(is_object($awsCategories[0])){
        $categoriesBunch = $awsCategories;
        //echo '<pre>';
        //print_r($categoriesBunch);
        //echo '</pre>';
        importCategoriesObjects($categoriesBunch, $sourceid);
    } else {
        foreach ($awsCategories as $categoriesBunch) {
            //echo '<pre>';
            //print_r($categoriesBunch);
            //echo '</pre>';
            importCategoriesObjects($categoriesBunch, $sourceid);
        }
    }
}

function importCategoriesObjects($objArr, $sourceid){
    
    $q = "INSERT INTO `categories` ";
    $fi = '(`sourceid`, `aid`, `parent`, `name`, `active`, `added`) ';
    $va = 'VALUES ';
    $objCounter = 1;
    $updatedableRecords = array();
    $insertableRecords = 0;
    foreach ($objArr as $objArrKey => $objArrValue) {
        if(checkIfCategoryExist($objArrValue->id)){
            $updatedableRecords[] = $objArrValue;
        } else {
            $insertableRecords++;
            if($insertableRecords > 1) $va .= ',';
            $va .= '('.$sourceid.', '.$objArrValue->id.','.$objArrValue->parent.',"'.$objArrValue->name.'", 1, '.time().')';
            //if($objCounter < count($objArr)) $va .= ',';
        }
        $objCounter++;
    }

    //print_r($insertableRecords);exit;
    if($insertableRecords > 0){
        //echo $q.$fi.$va;exit;
        mysql_query($q.$fi.$va) or die(mysql_error());
        //mysql_query($q.$fi.$va) or die(mysql_error());exit;
    }
}

function checkIfCategoryExist($awsCateId){
    $selectCateData = "Select id from `categories` WHERE aid = ".$awsCateId;
    $resultCateData =  mysql_query($selectCateData);
    $numCateData = mysql_num_rows($resultCateData);
    if($numCateData > 0){
        return true;
    } else {
        return false;
    }
}

function getDefaultQuantity($userId, $sourceId){
    $selectDefaultQuantity = "Select quantity from `source_settings` WHERE user_id = ".$userId." AND source_id = ".$sourceId;
    $resultDefaultQuantity =  mysql_query($selectDefaultQuantity);
    $numDefaultQuantity = mysql_num_rows($resultDefaultQuantity);
    if($numDefaultQuantity > 0)
    {
        $fetchDefaultQuantity = mysql_fetch_object($resultDefaultQuantity);
        return $fetchDefaultQuantity->quantity;   
    }
    else
    {
        return false;
    }
}

function getDefaultSkuPrefix($userId, $sourceId){
    $selectDefaultSkuPrefix = "Select skupattern from `source_settings` WHERE user_id = ".$userId." AND source_id = ".$sourceId;
    $resultDefaultSkuPrefix =  mysql_query($selectDefaultSkuPrefix);
    $numDefaultSkuPrefix = mysql_num_rows($resultDefaultSkuPrefix);
    if($numDefaultSkuPrefix > 0)
    {
        $fetchDefaultSkuPrefix = mysql_fetch_object($resultDefaultSkuPrefix);
        return $fetchDefaultSkuPrefix->skupattern;   
    }
    else
    {
        return false;
    }
}

function insert_data1($table, $data) {
//    echo "vivek12";
//    pre($data);
//    exit;

    $q = "INSERT INTO `" . $table . "` ";
    $v = '';
    $n = '';
    foreach ($data as $key => $val) {
        if (strtolower($val) != '')
        {
            $n.="`$key`, ";
            if (strtolower($val) == 'now()')
                $v.="NOW(), ";
            else
                $v.= "'" . ($val) . "', ";
        }
    }

    $q .= "(" . rtrim($n, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";
    echo $q;
    exit;

    if (db_query($q)) {
        //$this->free_result();
        return mysql_insert_id();
    }
    return false;
}


function update_data($table, $data, $where = '1') {
    $q = "UPDATE `" . $table . "` SET ";
    foreach ($data as $key => $val) {
        if (strtolower($val) != '')
        {
            if (strtolower($val) == 'now()')
                $q.= "`$key` = NOW(), ";
            else
                $q.= "`$key`='" . escape($val) . "', ";
        }
    }
     $q = rtrim($q, ', ') . ' WHERE ' . $where . ';';

    return db_query($q);
}

function escape($string) {
    if (get_magic_quotes_gpc())
        $string = stripslashes($string);
    return mysql_real_escape_string($string);
}
//Function for encrypt data
function encrypt_data($id,$length) {
    return substr(md5($id), 0, $length) . dechex($id);
}

//Function for decrypt data
function decrypt_data($id,$length) {
    //echo $id.' '.$length;

    $md5_8 = substr($id, 0, $length);
    $real_id = hexdec(substr($id, $length));
    return ($md5_8 == substr(md5($real_id), 0, $length)) ? $real_id : 0;
}
?>