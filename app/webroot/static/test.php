<?php
$AWS_ACCESS_KEY_ID = "AKIAIVCCJKIVWX3TVPQA";
$AWS_SECRET_ACCESS_KEY = "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";

$base_url = "http://ecs.amazonaws.com/onca/xml?";
$url_params = array('Operation'=>"ItemSearch",'Service'=>"AWSECommerceService",
 'AWSAccessKeyId'=>$AWS_ACCESS_KEY_ID,'AssociateTag'=>"yourtag-10",
 'Version'=>"2006-09-11",'Availability'=>"Available",'Condition'=>"All",
 'ItemPage'=>"1",'ResponseGroup'=>"Images,ItemAttributes,EditorialReview",
 'Keywords'=>"Amazon");

// Add the Timestamp
$url_params['Timestamp'] = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time());

// Sort the URL parameters
$url_parts = array();
foreach(array_keys($url_params) as $key)
    $url_parts[] = $key."=".$url_params[$key];
sort($url_parts);

// Construct the string to sign
$string_to_sign = "GET\necs.amazonaws.com\n/onca/xml\n".implode("&",$url_parts);
$string_to_sign = str_replace('+','%20',$string_to_sign);
$string_to_sign = str_replace(':','%3A',$string_to_sign);
$string_to_sign = str_replace(';',urlencode(';'),$string_to_sign);

// Sign the request
$signature = hash_hmac("sha256",$string_to_sign,$AWS_SECRET_ACCESS_KEY,TRUE);

// Base64 encode the signature and make it URL safe
$signature = base64_encode($signature);
$signature = str_replace('+','%2B',$signature);
$signature = str_replace('=','%3D',$signature);

$url_string = implode("&",$url_parts);
$url = $base_url.$url_string."&Signature=".$signature;
print $url;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$xml_response = curl_exec($ch);
echo $xml_response;

echo $xml_response;
exit;
?>

<?php
//$url = $pass_url = "https://www.amazon.co.uk/dp/B01DFKBL68/ref=fs_bis";

//echo readfile($pass_url);   //needs "Allow_url_include" enabled
//OR
//echo include($pass_url);    //needs "Allow_url_include" enabled
//OR
//echo file_get_contents($pass_url);
//OR
//echo stream_get_contents(fopen($pass_url, "rb")); //you may use "r" instead of "rb"  //needs "Allow_url_fopen" enabled

/* */
function get_remote_data($url, $post_paramtrs=false, $return_full_array=false)    {

    $c = curl_init();curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    //if parameters were passed to this function, then transform into POST method.. (if you need GET request, then simply change the passed URL)
    if($post_paramtrs){curl_setopt($c, CURLOPT_POST,TRUE);  curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&".$post_paramtrs );}
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
    curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
                    //We'd better to use the above command, because the following command gave some weird STATUS results..
                    //$header[0]= $user_agent="User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0";  $header[]="Cookie:CookieName1=Value;"; $header[]="Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*\/* ;q=0.5";  $header[]="Cache-Control: max-age=0"; $header[]="Connection: keep-alive"; $header[]="Keep-Alive: 300"; $header[]="Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7"; $header[] = "Accept-Language: en-us,en;q=0.5"; $header[] = "Pragma: ";  curl_setopt($c, CURLOPT_HEADER, true);     curl_setopt($c, CURLOPT_HTTPHEADER, $header);

    curl_setopt($c, CURLOPT_MAXREDIRS, 10);
    //if SAFE_MODE or OPEN_BASEDIR is set,then FollowLocation cant be used.. so...
    $follow_allowed= ( ini_get('open_basedir') || ini_get('safe_mode')) ? false:true;  if ($follow_allowed){curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);}
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
    curl_setopt($c, CURLOPT_REFERER, $url);
    curl_setopt($c, CURLOPT_TIMEOUT, 60);
    curl_setopt($c, CURLOPT_AUTOREFERER, true);
    curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
    $data=curl_exec($c);$status=curl_getinfo($c);curl_close($c);

    preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si',  $status['url'],$link);
    //correct assets URLs(i.e. retrieved url is: http://example.com/DIR/SUBDIR/page.html... then href="./image.JPG" becomes href="http://example.com/DIR/SUBDIR/image.JPG", but  href="/image.JPG" needs to become href="http://example.com/image.JPG")

    //inside all links(except starting with HTTP,javascript:,HTTPS,//,/ ) insert that current DIRECTORY url (href="./image.JPG" becomes href="http://example.com/DIR/SUBDIR/image.JPG")
    $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si','$1=$2'.$link[0].'$3$4$5', $data);
    //inside all links(except starting with HTTP,javascript:,HTTPS,//)    insert that DOMAIN url (href="/image.JPG" becomes href="http://example.com/image.JPG")
    $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si','$1=$2'.$link[1].'://'.$link[3].'$3$4$5', $data);
    // if redirected, then get that redirected page
    if($status['http_code']==301 || $status['http_code']==302) {
        //if we FOLLOWLOCATION was not allowed, then re-get REDIRECTED URL
        //p.s. WE dont need "else", because if FOLLOWLOCATION was allowed, then we wouldnt have come to this place, because 301 could already auto-followed by curl  :)
        if (!$follow_allowed){
            //if REDIRECT URL is found in HEADER
            if(empty($redirURL)){if(!empty($status['redirect_url'])){$redirURL=$status['redirect_url'];}}
            //if REDIRECT URL is found in RESPONSE
            if(empty($redirURL)){preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);                 if (!empty($m[2])){ $redirURL=$m[2]; } }
            //if REDIRECT URL is found in OUTPUT
            if(empty($redirURL)){preg_match('/moved\s\<a(.*?)href\=\"(.*?)\"(.*?)here\<\/a\>/si',$data,$m); if (!empty($m[1])){ $redirURL=$m[1]; } }
            //if URL found, then re-use this function again, for the found url
            if(!empty($redirURL)){$t=debug_backtrace(); return call_user_func( $t[0]["function"], trim($redirURL), $post_paramtrs);}
        }
    }
    // if not redirected,and nor "status 200" page, then error..
    elseif ( $status['http_code'] != 200 ) { $data =  "ERRORCODE22 with $url<br/><br/>Last status codes:".json_encode($status)."<br/><br/>Last data got:$data";}
    return ( $return_full_array ? array('data'=>$data,'info'=>$status) : $data);
}
/* */
$content = get_remote_data($url);
/* */

//Create DOM
$doc = new DOMDocument;
@$doc->loadHTML($content);
$doc->preserveWhiteSpace = false;
$xpath = new DOMXpath($doc);

//$html = $doc->saveHTML();
//$html = preg_replace("/<script.*?\/script>/s", "", $html) ? : $html;
//$html = preg_replace("/<style.*?\/style>/s", "", $html) ? : $html;

//echo '<pre>';
//print_r($html);
//echo '</pre>';
//exit;


/* *
$nodetitle = $xpath->query("//div[@id='title_feature_div']/div");
foreach ($nodetitle as $title) {

    //echo '<pre>';
    echo "Title ".trim($title->nodeValue);
    //echo '</pre>';
    //exit;
}
/* */
//exit;

/* *
$featurelist = $xpath->query("//div[@id='featurebullets_feature_div']"); // I would recommend trying to find an element that contains the currency elements, but has an attribute that will most likely not be changed. IDs work well, sometime div classes also work. Check out http://www.exampledepot.com/egs/org.w3c.dom/xpath_GetElemByText.html
echo "feature List:";echo '<br>';
$cnt = 1;
foreach ($featurelist as $feature_data) {

    echo '<br>'.$cnt.' - '.(($feature_data->nodeValue));
    $cnt++;
}
/* */

$centerlist = $xpath->query("//div[@id='altImages']");

foreach ($centerlist as $centerlist) {

    echo '<pre>';
    print_r($centerlist);
    echo '</pre>';
}

exit;

/* *
function curl_download($Url) {

    // is cURL installed yet?
    if (!function_exists('curl_init')) {
        die('Sorry cURL is not installed!');
    }

    // OK cool - then let's create a new cURL resource handle
    $ch = curl_init();

    // Now set some options (most are optional)
    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, $Url);

    // User agent
    curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

    // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // Should cURL return or print out the data? (true = retu	rn, false = print)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    // Download the given URL, and return output
    $output = curl_exec($ch);

    // Close the cURL resource, and free system resources
    curl_close($ch);

    return $output;
}
/* */
echo curl_download($url);
exit;
?>

<?php
$keywords = array();
$domain = array($pass_url);
$doc = new DOMDocument;
$doc->preserveWhiteSpace = FALSE;
foreach ($domain as $key => $value) {
    @$doc->loadHTMLFile($value);
    $anchor_tags = $doc->getElementsByTagName('a');
    foreach ($anchor_tags as $tag) {
        $keywords[] = strtolower($tag->nodeValue);
    }
}

echo '<pre>';
echo "vivek";
print_r($keywords);
echo '</pre>';
exit;
?>