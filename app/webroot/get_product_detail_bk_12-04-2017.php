<?php
/*
 * Copyright 2016 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
session_start();
include('function.php');

//require_once ("config.php");

require_once "vendor/autoload.php";

define('AWS_API_KEY', 'AKIAJOZTYYDTIWICCT2Q');
define('AWS_API_SECRET_KEY', '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');
define('AWS_ASSOCIATE_TAG', 'shoes');
define('AWS_ANOTHER_ASSOCIATE_TAG', '');



use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
//use ApaiIO\Operations\Search;

$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

$conf = new GenericConfiguration();
$conf
    ->setCountry('com')
    ->setAccessKey(AWS_API_KEY)
    ->setSecretKey(AWS_API_SECRET_KEY)
    ->setAssociateTag(AWS_ASSOCIATE_TAG)
    ->setRequest($request);
    //->setResponseTransformer(new \ApaiIO\ResponseTransformer\XmlToDomDocument());

$apaiIo = new ApaiIO($conf);

$awnid = $_GET['awnid'];
//pre($_REQUEST);
//pre($apaiIo);
//exit;

//$search = new Search();
//$search->setCategory('All');
////$search->setActor('All');
//$search->setKeywords('shoes');
//$search->setResponseGroup(array('Large'));
//$response = $apaiIo->runOperation($search);


$lookup = new Lookup();
//$lookup->setItemId('B01GELDQX6');
$lookup->setItemId($awnid);
$lookup->setResponseGroup(array('Large')); // More detailed information
$response = $apaiIo->runOperation($lookup);

$response = json_decode (json_encode (simplexml_load_string ($response)), true);

//pre($_GET);
//pre($_POST);
//pre($response);
//exit;

//var_dump($response);
if(!empty($response))
{
    if(isset($response['Items']['Request']['Errors']['Error']['Message']))
    {
        $error = $response['Items']['Request']['Errors']['Error']['Message'];
        $page_url = DEFAULT_URL.'listings/listing_requests/msg:'.$error;
        header('Location: '.$page_url);
        exit;
    }
    else
    {
        $add_product_array = array();

    //     pre($_GET);
    //    pre($_POST);

        $get_product_attribute = $response['Items']['Item']['ItemAttributes'];
        $offer_summary = $response['Items']['Item']['OfferSummary'];

    //    pre($offer_summary);
    //    pre($get_product_attribute);
    //    pre($response);
    //    exit;

        //Set variable into product data
        $add_product_array['user_id'] = $_GET['userid'];
        $add_product_array['source_id'] = $_GET['sourceid'];
        $add_product_array['asin_no'] = $_GET['awnid'];
        $add_product_array['pageurl'] = urldecode($response['Items']['Item']['DetailPageURL']);
        $add_product_array['title'] = addslashes($get_product_attribute['Title']);
        $add_product_array['main_image'] = $response['Items']['Item']['LargeImage']['URL'];
        $add_product_array['image_set'] = json_encode($response['Items']['Item']['ImageSets']['ImageSet']);

        $add_product_array['binding'] = $get_product_attribute['Binding'];
        $add_product_array['brand'] = $get_product_attribute['Brand'];
        $add_product_array['color'] = (isset($get_product_attribute['Color']))?$get_product_attribute['Color']:'';
        $add_product_array['features'] = (isset($get_product_attribute['Feature']))?addslashes(json_encode($get_product_attribute['Feature'])):'';
        //echo stripslashes ($add_product_array['features']);
        $add_product_array['item_dimension'] = (isset($get_product_attribute['ItemDimensions']))?json_encode($get_product_attribute['ItemDimensions']):'';
        $add_product_array['currency_code'] = $get_product_attribute['ListPrice']['CurrencyCode'];
        $add_product_array['list_amount'] = $get_product_attribute['ListPrice']['Amount'];
        //check price and sales prices

        $add_product_array['new_amount'] = (isset($offer_summary['LowestNewPrice']['Amount']))?$offer_summary['LowestNewPrice']['Amount']:'';
        $add_product_array['used_amount'] = (isset($offer_summary['LowestUsedPrice']['Amount']))?$offer_summary['LowestUsedPrice']['Amount']:'';
        $add_product_array['model'] = (isset($get_product_attribute['Model']))?$get_product_attribute['Model']:'';
        $add_product_array['mpn'] = (isset($get_product_attribute['MPN']))?$get_product_attribute['MPN']:'';
        $add_product_array['upc'] = (isset($get_product_attribute['UPC']))?$get_product_attribute['UPC']:'';
        $add_product_array['product_group'] = (isset($get_product_attribute['ProductGroup']))?$get_product_attribute['ProductGroup']:'';

        $add_item_specification = array();
        if(isset($get_product_attribute['Brand']))
            $add_item_specification['Brand'] = $get_product_attribute['Brand'];
        if(isset($get_product_attribute['Model']))
            $add_item_specification['Model'] = $get_product_attribute['Model'];
        if(isset($get_product_attribute['MPN']))
            $add_item_specification['MPN'] = $get_product_attribute['MPN'];
        if(isset($get_product_attribute['UPC']))
            $add_item_specification['UPC'] = $get_product_attribute['UPC'];

        $add_product_array['item_specification'] = (isset($add_item_specification))?(json_encode($add_item_specification)):'';
        //`warranty`, `description`, `submit_status`, `status`, `created_date`
        $add_product_array['warranty'] = isset($get_product_attribute['Warranty'])?$get_product_attribute['Warranty']:'';
        $add_product_array['description'] = (!empty($response['Items']['Item']['EditorialReviews']['EditorialReview']['Content']))?addslashes($response['Items']['Item']['EditorialReviews']['EditorialReview']['Content']):'';
        $add_product_array['page_content'] = addslashes(json_encode($response['Items']));
        $add_product_array['submit_status'] = ($_GET['form_submit']==1)?'List Now':'Review and List';
        $add_product_array['status'] = 0;
        $add_product_array['created_date'] = date('Y-m-d H:i:s');
        $add_product_array['modified_date'] = date('Y-m-d H:i:s');

    //    echo 'decrypt_id '.$decrypt_id = encrypt_data($add_product_array['user_id'],ID_LENGTH);
    //    exit;
        //$sql_insert_product = insert_data('products', $add_product_array);

//        pre($add_item_specification);
//        pre($add_product_array);
//        pre($response);
//        exit;

        //insert into product
        $sql_insert_product = insert_data('products', $add_product_array);
        //$sql_insert_product = '';
//        pre($add_product_array);
//        exit;
        if($sql_insert_product!='')
        {
            $page_url = DEFAULT_URL.'listings/listing_requests/';
        }
        else
        {
            $error = "Some problem when upload product";
            $page_url = DEFAULT_URL.'listings/listing_requests/msg:'.$error;
        }
        header('Location: '.$page_url);
        exit;


    //    pre($add_product_array);
    //    pre($_SESSION);
    //    pre($response);
    //    exit;
    }
}

/*
use ApaiIO\Operations\Lookup;

$conf = new GenericConfiguration();
$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

//$conf
//    ->setCountry('com')
//    ->setAccessKey(AWS_API_KEY)
//    ->setSecretKey(AWS_API_SECRET_KEY)
//    ->setAssociateTag(AWS_ASSOCIATE_TAG)
//    ->setRequest($request);

//$apaiIo = new ApaiIO($conf);


//echo "<pre>";
//print_r($apaiIo);
//echo "</pre>";

try {
    $conf
        ->setCountry('com')
        ->setAccessKey(AWS_API_KEY)
        ->setSecretKey(AWS_API_SECRET_KEY)
        ->setAssociateTag(AWS_ASSOCIATE_TAG)
        ->setRequest($request);
//        ->setResponseTransformer(new \ApaiIO\ResponseTransformer\XmlToDomDocument());
} catch (\Exception $e) {
    echo $e->getMessage();
}
$apaiIO = new ApaiIO($conf);

//$lookup = new Lookup();
//$lookup->setItemId('B00D6BN9NK');
//$lookup->setResponseGroup(array('Large')); // More detailed information

//$response = $apaiIo->runOperation($lookup);

$lookup = new Lookup();
$lookup->setItemId('B01DFKC2SO');
$lookup->setResponseGroup(array('Large', 'Small'));

$response = $apaiIO->runOperation($lookup);

pre($response);
pre($apaiIO);
exit;

$lookup = new Lookup();
$lookup->setItemId('B0040PBK32,B00MEKHLLA');
$lookup->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($lookup);

var_dump($formattedResponse);
/* */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
?>