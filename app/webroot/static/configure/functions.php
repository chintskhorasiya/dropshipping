<?php 
    /****************************************
    Database Connection
    *****************************************/
    $link_id = mysql_connect($db_host,$db_user,$db_password);
    mysql_select_db($db_name,$link_id);
    /****************************************
    Common Database Functions
    *****************************************/
    function db_query($sql,$type="") {
        $result_id = mysql_query($sql);
        if($type!="ins")
            return $result_id;
        else
            return mysql_insert_id();
    }
    function get_array($result_id) {
        $records = @mysql_fetch_assoc($result_id);
        if($records){
            $records=array_map("stripslashes",$records);
        }
        return $records;
    }
    function get_results($sql) {
        $result_id = db_query($sql);
        $out = array();
        while ($row = get_array($result_id)){
            $out[] = $row;
        }
        return $out;
    }
    function get_row($query_string) {
        $result_id = db_query($query_string);
        $out =  get_array($result_id);
        return $out;
    }
    function escape($string) {
        if(get_magic_quotes_gpc()) $string = stripslashes($string);
        return mysql_real_escape_string($string);
    }
    function update_data($table, $data, $where='1') {
        $q="UPDATE `".$table."` SET ";
        foreach($data as $key=>$val) {
            if(strtolower($val)=='null') $q.= "`$key` = NULL, ";
            elseif(strtolower($val)=='now()') $q.= "`$key` = NOW(), ";
            else $q.= "`$key`='".escape($val)."', ";
        }
        $q = rtrim($q, ', ') . ' WHERE '.$where.';';
        return db_query($q);
    }#-#query_update()
    function insert_data($table, $data) {
        $q="INSERT INTO `".$table."` ";
        $v=''; $n='';
        foreach($data as $key=>$val) {
            $n.="`$key`, ";
            if(strtolower($val)=='null') $v.="NULL, ";
            elseif(strtolower($val)=='now()') $v.="NOW(), ";
            else $v.= "'".escape($val)."', ";
        }
        $q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

        if(db_query($q)){
            //$this->free_result();
            return mysql_insert_id();
        }
        return false;
    }
    function delete_data($table,$condition,$fields=""){
        if(empty($fields))
            $q = "DELETE From $table WHERE $condition";
        else
            $q = "DELETE $fields From $table WHERE $condition";

        $r= db_query($q);
        if($r){
            $rows = mysql_affected_rows();
            if ($rows == 0)
                return true;  // no rows were deleted
            else
                return $rows;
        }
        return false;
    }
    /****************************************
    Common Functions
    *****************************************/
    function include_styles($comma_vals) {
        $css_array = explode(',',$comma_vals);
        $styles = '';
        foreach($css_array as $css)
        {
            $csspath = CSSPATH.$css;
            $cssurl = CSSURL.$css;
            if(file_exists($csspath))
            {
                $styles .= '<link rel="stylesheet" type="text/css" href="'.$cssurl.'" media="all" />'."\r\n";
            }
        }
        return $styles;
    }
    function include_js($comma_vals) {
        $js_array = explode(',',$comma_vals);
        $javascripts = '';
        foreach($js_array as $js)
        {
            $jspath = JSPATH.$js;
            $jsurl = JSURL.$js;
            if(file_exists($jspath))
            {
                $javascripts .= '<script type="text/javascript" src="'.$jsurl.'"></script>'."\r\n";
            }
        }
        return $javascripts;
    }
    function include_assets($comma_vals) {
        $assets_array = explode(',',$comma_vals);
        $asset = '';
        foreach($assets_array as $assets)
        {
            $assetspath = ASSETSPATH.$assets;
            $assetsurl = ASSETSURL.$assets;
            if(file_exists($assetspath))
            {
                $asset .= '<script type="text/javascript" src="'.$assetsurl.'"></script>'."\r\n";
            }
        }
        return $asset;
    }
    function pre($arr)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
    function upload_image($files,$new_path,$thumb_path='',$thumb_width='200',$thumb_height='auto')
    {
        $image = $files['name'];

        $uploadedfile = $files['tmp_name'];

        if ($image) 
        {
            $filename = str_replace(' ','-',strtolower(stripslashes($image)));
            $extension = getExtension($files['name']);
            $extension = strtolower($extension);

            $i = 1;
            $old_filename = $filename;
            while(file_exists($new_path.$filename))
            {
                $new_file = rtrim($old_filename,'.'.$extension);
                $new_filename = $new_file.$i;
                $filename = $new_filename.'.'.$extension;
                $i++;

            }
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
            {
                return false;
            }
            else
            {
                $size=filesize($uploadedfile);

                if($extension=="jpg" || $extension=="jpeg" )
                {
                    $src = imagecreatefromjpeg($uploadedfile);
                }
                else if($extension=="png")
                    {
                        $src = imagecreatefrompng($uploadedfile);
                    }
                    else 
                    {
                        $src = imagecreatefromgif($uploadedfile);
                }
                list($width,$height)=getimagesize($uploadedfile);

                if($thumb_height == 'auto')
                {
                    $newwidth=$width;
                    $newheight=($height/$width)*$newwidth;
                    $tmp=imagecreatetruecolor($newwidth,$newheight);

                    $newwidth1=$thumb_width;
                    $newheight1=($height/$width)*$newwidth1;
                    $tmp1=imagecreatetruecolor($newwidth1,$newheight1);
                }
                else
                {
                    $newwidth=$width;
                    $newheight=($height/$width)*$newwidth;
                    $tmp=imagecreatetruecolor($newwidth,$newheight);

                    $newwidth1=$thumb_width;
                    $newheight1=$thumb_height;
                    $tmp1=imagecreatetruecolor($newwidth1,$newheight1);
                }	

                // Create Watermark Start
                $stamp = imagecreatefrompng(IMAGEPATH.'watermark.png');
                $sx = imagesx($stamp);
                $sy = imagesy($stamp);
                $imgx = imagesx($src);
                $imgy = imagesy($src);
                $centerX=round($imgx) - $sx - 10;
                $centerY=round($imgy) - $sy - 10;


                // Create Thumb
                $orig_w = imagesx($src);
                $orig_h = imagesy($src);

                $w_ratio = $orig_w / $newwidth1;
                $h_ratio = $orig_h / $newheight1;

                $ratio = $w_ratio > $h_ratio ? $w_ratio : $h_ratio;

                $dst_w = $orig_w / $ratio;
                $dst_h = $orig_h / $ratio;
                $dst_x = ($newwidth1 - $dst_w) / 2;
                $dst_y = ($newheight1 - $dst_h) / 2;

                $color = imagecolorallocate($tmp1, 255,255,255);  //The three parameters are R,G,B
                imagefilledrectangle ($tmp1, 0, 0, $newwidth1,  $newheight1,$color);

                imagecopyresampled($tmp1,$src,$dst_x,$dst_y,0,0,$dst_w,$dst_h,$orig_w,$orig_h);

                imagecopy($src, $stamp, $centerX, $centerY, 0, 0, $sx, $sy);
                // Create Watermark End

                /*$center_X = ($width - $newwidth1) / 2;
                $center_Y = ($height - $newheight1) / 2;
                $src_width = $center_X + $newwidth1;
                $src_height = $center_Y + $newheight1; */

                imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);



                $file_uploaded = $new_path.$filename;
                $file_uploaded1 = $thumb_path.$filename;

                imagejpeg($tmp,$file_uploaded,100);
                imagejpeg($tmp1,$file_uploaded1,100);

                imagedestroy($src);
                imagedestroy($tmp);
                imagedestroy($tmp1);
                return $filename;
            }
        }	
        else
        {
            return false;
        }

    }
    function upload_image_only($files,$new_path,$img_width=0,$img_height=0)
    {
        $image = $files['name'];

        $uploadedfile = $files['tmp_name'];

        if ($image) 
        {
            $filename = str_replace(' ','-',strtolower(stripslashes($image)));
            $extension = getExtension($files['name']);
            $extension = strtolower($extension);

            $i = 1;
            $old_filename = $filename;
            while(file_exists($new_path.$filename))
            {
                $new_file = rtrim($old_filename,'.'.$extension);
                $new_filename = $new_file.$i;
                $filename = $new_filename.'.'.$extension;
                $i++;

            }
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
            {
                return false;
            }
            else
            {
                $size=filesize($uploadedfile);

                if($extension=="jpg" || $extension=="jpeg" )
                {
                    $src = imagecreatefromjpeg($uploadedfile);
                }
                else if($extension=="png")
                    {
                        $src = imagecreatefrompng($uploadedfile);
                    }
                    else 
                    {
                        $src = imagecreatefromgif($uploadedfile);
                }
                list($width,$height)=getimagesize($uploadedfile);

                if($img_height == 0 && $img_width == 0)
                {
                    $newwidth=$width;
                    $newheight=$height;
                    $tmp=imagecreatetruecolor($newwidth,$newheight);

                }
                else
                {
                    $newwidth=$img_width;
                    $newheight=$img_height;
                    $tmp=imagecreatetruecolor($newwidth,$newheight);

                }	



                imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

                $file_uploaded = $new_path.$filename;


                imagejpeg($tmp,$file_uploaded,100);

                imagedestroy($src);
                imagedestroy($tmp);
                imagedestroy($tmp1);
                return $filename;
            }
        }	
        else
        {
            return false;
        }

    }
    function store_uploads($files,$new_path)
    {
        $image = $files['name'];

        $uploadedfile = $files['tmp_name'];

        if ($image) 
        {
            $filename = str_replace(' ','-',strtolower(stripslashes($image)));
            $extension = getExtension($files['name']);
            $extension = strtolower($extension);

            $i = 1;
            $old_filename = $filename;
            while(file_exists($new_path.$filename))
            {
                $new_file = rtrim($old_filename,'.'.$extension);
                $new_filename = $new_file.$i;
                $filename = $new_filename.'.'.$extension;
                $i++;

            }
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
            {
                return false;
            }
            else
            {
                $size=filesize($uploadedfile);

                if($extension=="jpg" || $extension=="jpeg" )
                {
                    $src = imagecreatefromjpeg($uploadedfile);
                }
                else if($extension=="png")
                    {
                        $src = imagecreatefrompng($uploadedfile);
                    }
                    else 
                    {
                        $src = imagecreatefromgif($uploadedfile);
                }
                list($width,$height)=getimagesize($uploadedfile);





                $file_uploaded = move_uploaded_file($uploadedfile,$new_path.$filename);

                imagejpeg($tmp1,$file_uploaded1,100);

                imagedestroy($src);
                return $filename;
            }
        }	
        else
        {
            return false;
        }

    }
    function getExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; } 
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
    function parse_username($uname)
    {
        $newString = preg_replace('/[^a-z0-9]/i', '', $uname);
        return $newString;
    }
    function valid_username_string($uname)
    {
        $newString = parse_username($uname);
        if($newString == $uname)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function store_valid_url($url)
    {
        $newString = preg_replace('/[^-a-z0-9]/i', '', $url);

        if($newString == $url)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
        $size = strlen( $chars );
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }
    function rand_coupon_string( $length ) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
        $size = strlen( $chars );
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }

    function validate_email($email)
    {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
        if (!preg_match($regex, $email)) {
            return 0;	
        } else { 
            return 1;
        }
    }
    function truncate($str,$len)
    {
        $str = strip_tags($str);
        if(strlen($str) > $len)
        {
            $str = substr($str,0,$len).'...';
        }
        return $str;
    }	
    function set_password($pwd)
    {
        return base64_encode($pwd);
    }
    function encrypt_password($pwd)
    {
        return md5($pwd);
    }
    function get_file_size($file)
    {
        $filesize = ($file * .0009765625) * .0009765625; // bytes to MB
        return $filesize;
    }
    function accessPermission($users,$page=''){
        $users = explode(',',$users);
        foreach($users as $user){
            if($_SESSION['ADMIN_ROLE'] == $user){
                return true;
            }
        }
        if($page == 'page')
            header('Location:'.ADMINURL);
        return false;
    }
    function strip_trim($var)
    {
        return strip_tags(trim($var));    
    }
    function get_advanced_setting_data(){
        $sql = "select * from settings";
        $results = get_results($sql);
        return $results;
    }
    /*function formatbytes($file, $type)
    {
    switch($type){
    case "KB":
    $filesize = filesize($file) * .0009765625; // bytes to KB
    break;
    case "MB":
    $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
    break;
    case "GB":
    $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
    break;
    }
    return round($filesize, 2);

    if($filesize <= 0){
    return $filesize = 'unknown file size';}
    else{return round($filesize, 2).' '.$type;}
    }*/



    //redspark functions
    function upload_image_from_live($files,$new_path,$thumb_path='',$thumb_width='200',$thumb_height='auto')
    {
        $image= basename($files);
        $uploadedfile = $files;

        if ($image) 
        {
            $filename = str_replace(' ','-',strtolower(stripslashes($image)));
            $extension = getExtension($image);
            $extension = strtolower($extension);

            $i = 1;
            $old_filename = $filename;
            while(file_exists($new_path.$filename))
            {
                $new_file = rtrim($old_filename,'.'.$extension);
                $new_filename = $new_file.$i;
                $filename = $new_filename.'.'.$extension;
                $i++;

            }
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
            {
                return false;
            }
            else
            {
                $size=filesize($uploadedfile);

                if($extension=="jpg" || $extension=="jpeg" )
                {
                    $src = imagecreatefromjpeg($uploadedfile);
                }
                else if($extension=="png")
                    {
                        $src = imagecreatefrompng($uploadedfile);
                    }
                    else 
                    {
                        $src = imagecreatefromgif($uploadedfile);
                }
                list($width,$height)=getimagesize($uploadedfile);

                if($thumb_height == 'auto')
                {
                    $newwidth=$width;
                    $newheight=($height/$width)*$newwidth;
                    $tmp=imagecreatetruecolor($newwidth,$newheight);

                    $newwidth1=$thumb_width;
                    $newheight1=($height/$width)*$newwidth1;
                    $tmp1=imagecreatetruecolor($newwidth1,$newheight1);
                }
                else
                {
                    $newwidth=$width;
                    $newheight=($height/$width)*$newwidth;
                    $tmp=imagecreatetruecolor($newwidth,$newheight);

                    $newwidth1=$thumb_width;
                    $newheight1=$thumb_height;
                    $tmp1=imagecreatetruecolor($newwidth1,$newheight1);
                }    

                // Create Watermark Start
                $stamp = imagecreatefrompng(IMAGEPATH.'watermark.png');
                $sx = imagesx($stamp);
                $sy = imagesy($stamp);
                $imgx = imagesx($src);
                $imgy = imagesy($src);
                $centerX=round($imgx) - $sx - 10;
                $centerY=round($imgy) - $sy - 10;


                // Create Thumb
                $orig_w = imagesx($src);
                $orig_h = imagesy($src);

                $w_ratio = $orig_w / $newwidth1;
                $h_ratio = $orig_h / $newheight1;

                $ratio = $w_ratio > $h_ratio ? $w_ratio : $h_ratio;

                $dst_w = $orig_w / $ratio;
                $dst_h = $orig_h / $ratio;
                $dst_x = ($newwidth1 - $dst_w) / 2;
                $dst_y = ($newheight1 - $dst_h) / 2;

                $color = imagecolorallocate($tmp1, 255,255,255);  //The three parameters are R,G,B
                imagefilledrectangle ($tmp1, 0, 0, $newwidth1,  $newheight1,$color);

                imagecopyresampled($tmp1,$src,$dst_x,$dst_y,0,0,$dst_w,$dst_h,$orig_w,$orig_h);

                imagecopy($src, $stamp, $centerX, $centerY, 0, 0, $sx, $sy);
                // Create Watermark End

                imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);


                $file_uploaded = $new_path.$filename;
                $file_uploaded1 = $thumb_path.$filename;

                imagejpeg($tmp,$file_uploaded,100);
                imagejpeg($tmp1,$file_uploaded1,100);

                imagedestroy($src);
                imagedestroy($tmp);
                imagedestroy($tmp1);
                return $filename;
            }
        }    
        else
        {
            return false;
        }
    }
?>