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
//define('AWS_API_KEY', 'AKIAJOZTYYDTIWICCT2Q');
define('AWS_API_KEY', 'AKIAJL5OCKUJ5TXWF47Q');
//define('AWS_API_SECRET_KEY', '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');
define('AWS_API_SECRET_KEY', 'duy/xH0o6oLKbUxge7wO8fnCcPiDGqco9kmLaW5m');
//define('AWS_ASSOCIATE_TAG', 'shoes');
define('AWS_ASSOCIATE_TAG', 'dropshipping7-20');
define('AWS_ANOTHER_ASSOCIATE_TAG', '');

$country_cod = 'com';
if(isset($_REQUEST['sourceid']) && $_REQUEST['sourceid']==2)
{
    $country_cod = 'co.uk';
}

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
//use ApaiIO\Operations\Search;

$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

$conf = new GenericConfiguration();
$conf
    ->setCountry($country_cod)
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

//VariationSummary', 'VariationMatrix', 'VariationMinimum', 'VariationImages', 'VariationOffers'

$lookup = new Lookup();
//$lookup->setIdType('ASIN');
$lookup->setResponseGroup(array('Large', 'VariationMatrix', 'VariationSummary'
, 'VariationOffers')); // More detailed information
//$lookup->setItemId('B071FVJ9PJ');
//$lookup->setItemId('B06VW5QNBF');
$lookup->setItemId($awnid);
$lookup->setCondition('All');
$response = $apaiIo->runOperation($lookup);

$response = json_decode (json_encode (simplexml_load_string ($response)), true);

//pre($_GET);
//pre($_POST);
//pre($response);
//exit;
//pre($response['Items']['Item']['BrowseNodes']['BrowseNode']);exit;
$browseNodes = $response['Items']['Item']['BrowseNodes']['BrowseNode'];
if(is_array($browseNodes) && isset($browseNodes[0])){

    foreach ($browseNodes as $browseNode) {
        //pre($browseNode);
        $nodeJsonString = "[";
        $nodeJsonString .= '{"id":'.$browseNode['BrowseNodeId'].',"name":"'.$browseNode['Name'].'"';
        //echo $nodeJsonString;
        $awsCategories[] = json_decode(getAncestors($browseNode['Ancestors'], $nodeJsonString));
    }

} else {

    $browseNode = $browseNodes;
    //pre($browseNode);exit;
    $nodeJsonString = "[";
    $nodeJsonString .= '{"id":'.$browseNode['BrowseNodeId'].',"name":"'.$browseNode['Name'].'"';
    $finalResult = getAncestors($browseNode['Ancestors'], $nodeJsonString);
    $awsCategories = json_decode($finalResult);

}

function getAncestors($nodeId , $nodeJsonString){
    //var_dump($nodeJsonString);
    //echo "<br>";
    $nodeJsonString .= ',"parent":'.$nodeId['BrowseNode']['BrowseNodeId'].'},';
    $nodeJsonString .= '{"id":'.$nodeId['BrowseNode']['BrowseNodeId'].',"name":"'.$nodeId['BrowseNode']['Name'].'"';
    if(!empty($nodeId['BrowseNode']['Ancestors']) && is_array($nodeId['BrowseNode']['Ancestors']) && count($nodeId['BrowseNode']['Ancestors']) > 0){
        return getAncestors($nodeId['BrowseNode']['Ancestors'], $nodeJsonString);
    } else {
        $nodeJsonString .= ',"parent":0}]';
        return $nodeJsonString;
    }     
}

//string(196) "{{"id":1730879031,"name":Jeans,"parent":1730841031},{"id":1730841031,"name":Girls,"parent":83451031},{"id":83451031,"name":Categories,"parent":83450031},{"id":83450031,"name":Clothing,"parent":0}}"

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
        $get_product_attribute = $response['Items']['Item']['ItemAttributes'];
        $offer_summary = $response['Items']['Item']['OfferSummary'];

        
        $image_counter =  count($response['Items']['Item']['ImageSets']['ImageSet']);
        $image_arr = $response['Items']['Item']['ImageSets']['ImageSet'];
        //pre($image_arr);

        $new_image_array = array();
        $picturexmldata = '';
        for($i=0;$i<count($image_arr);$i++)
        {
            $new_image_array[$i] = $image_arr[$i]['LargeImage']['URL'];
        }

        $def_qty = (int) getDefaultQuantity($_GET['userid'], $_GET['sourceid']);
        $def_sku_prefix = getDefaultSkuPrefix($_GET['userid'], $_GET['sourceid']);

        // for QTY [[CUSTOM]]
        
        $totalOffers = (int) $response['Items']['Item']['Offers']['TotalOffers'];
        
        if($totalOffers > 0){
            if(!empty($def_qty))
            {
                $add_product_array['qty'] = $def_qty;
            }
            else
            {
                $add_product_array['qty'] = "";
            }
        } else {
            $add_product_array['qty'] = 0;
        }

        //var_dump($add_product_array['qty']);exit;

        // for QTY [[CUSTOM]]

        if(isset($response['Items']['Item']['Offers']['Offer']) && isset($response['Items']['Item']['Offers']['Offer'][0]))
        {
            $price = (isset($response['Items']['Item']['Offers']['Offer'][0]['OfferListing']['Price']['Amount']))?$response['Items']['Item']['Offers']['Offer'][0]['OfferListing']['Price']['Amount']:'';
            //var_dump($price);
            $amount_save = (isset($response['Items']['Item']['Offers']['Offer'][0]['OfferListing']['AmountSaved']['Amount']))?$response['Items']['Item']['Offers']['Offer'][0]['OfferListing']['AmountSaved']['Amount']:'';
            $sale_price = (isset($response['Items']['Item']['Offers']['Offer'][0]['OfferListing']['SalePrice']['Amount']))?$response['Items']['Item']['Offers']['Offer'][0]['OfferListing']['SalePrice']['Amount']:'';
            $percentage_save = (isset($response['Items']['Item']['Offers']['Offer'][0]['OfferListing']['PercentageSaved']))?$response['Items']['Item']['Offers']['Offer'][0]['OfferListing']['PercentageSaved']:'';
        }
        else
        {
            
            $price = (isset($response['Items']['Item']['Offers']['Offer']['OfferListing']['Price']['Amount']))?$response['Items']['Item']['Offers']['Offer']['OfferListing']['Price']['Amount']:'';
            //var_dump($price);
            $amount_save = (isset($response['Items']['Item']['Offers']['Offer']['OfferListing']['AmountSaved']['Amount']))?$response['Items']['Item']['Offers']['Offer']['OfferListing']['AmountSaved']['Amount']:'';
            $sale_price = (isset($response['Items']['Item']['Offers']['Offer']['OfferListing']['SalePrice']['Amount']))?$response['Items']['Item']['Offers']['Offer']['OfferListing']['SalePrice']['Amount']:'';
            $percentage_save = (isset($response['Items']['Item']['Offers']['Offer']['OfferListing']['PercentageSaved']))?$response['Items']['Item']['Offers']['Offer']['OfferListing']['PercentageSaved']:'';
        }

        $new_price = '';
        if($sale_price=='' && $amount_save!='')
        {
            $new_price = $price + $amount_save;
        }
        else if($sale_price!='' && $amount_save!='')
        {
            $price = $sale_price;
            $new_price = $sale_price + $amount_save;
        }

        //var_dump($price);

        $feature_array = $newfeature_array = array();

        //Set variable into product data
        $add_product_array['user_id'] = $_GET['userid'];
        $add_product_array['source_id'] = $_GET['sourceid'];
        $add_product_array['asin_no'] = $_GET['awnid'];
        $add_product_array['pageurl'] = urldecode($response['Items']['Item']['DetailPageURL']);
        $add_product_array['title'] = addslashes($get_product_attribute['Title']);
        $add_product_array['main_image'] = (isset($response['Items']['Item']['LargeImage']['URL']))?$response['Items']['Item']['LargeImage']['URL']:'';
        $add_product_array['image_set'] = (isset($response['Items']['Item']['ImageSets']['ImageSet']))?json_encode($response['Items']['Item']['ImageSets']['ImageSet']):'';

        $add_product_array['binding'] = (isset($get_product_attribute['Binding']))?$get_product_attribute['Binding']:'';
        $add_product_array['brand'] = $get_product_attribute['Brand'];
        $add_product_array['color'] = (isset($get_product_attribute['Color']))?$get_product_attribute['Color']:'';
        $add_product_array['features'] = (isset($get_product_attribute['Feature']))?addslashes(json_encode($get_product_attribute['Feature'])):'';
        //echo stripslashes ($add_product_array['features']);
        $add_product_array['item_dimension'] = (isset($get_product_attribute['ItemDimensions']))?json_encode($get_product_attribute['ItemDimensions']):'';
        $add_product_array['currency_code'] = (isset($get_product_attribute['ListPrice']['CurrencyCode']))?$get_product_attribute['ListPrice']['CurrencyCode']:'';
//        $add_product_array['list_amount'] = $get_product_attribute['ListPrice']['Amount'];
        $add_product_array['list_amount'] = $price;
        //check price and sales prices

        $add_product_array['new_amount'] = $new_price;
        $add_product_array['sale_amount'] = $sale_price;
        $add_product_array['save_amount'] = (isset($amount_save) && $amount_save!='')?$amount_save:'';
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
        if(isset($get_product_attribute['Feature']))
            $add_item_specification['Features'] = (is_array($get_product_attribute['Feature']) ? implode(",", $get_product_attribute['Feature']): $get_product_attribute['Feature']);

        $add_product_array['item_specification'] = (isset($add_item_specification))?addslashes(json_encode($add_item_specification)):'';
        //`warranty`, `description`, `submit_status`, `status`, `created_date`
        $add_product_array['warranty'] = isset($get_product_attribute['Warranty'])?$get_product_attribute['Warranty']:'';
        $add_product_array['description'] = (!empty($response['Items']['Item']['EditorialReviews']['EditorialReview']['Content']))?addslashes($response['Items']['Item']['EditorialReviews']['EditorialReview']['Content']):'';
        //$add_product_array['page_content'] = addslashes(json_encode(($response['Items'])));
        $add_product_array['submit_status'] = ($_GET['form_submit']==1)?'List Now':'Review and List';
        $add_product_array['status'] = 0;

        // [[CUSTOM]]
        if(is_array($awsCategories[0]))
        {
            $add_product_array['a_cat_id'] = $awsCategories[0][0]->id;
        }
        else
        {
            $add_product_array['a_cat_id'] = $awsCategories[0]->id;
        }

        // for SKU [[CUSTOM]]
        if(!empty($def_sku_prefix))
        {
            $add_product_array['sku'] = $def_sku_prefix.$add_product_array['asin_no'];
        }
        else
        {
            $add_product_array['sku'] = $add_product_array['asin_no'];
        }
        // for SKU [[CUSTOM]]

        //pre($add_product_array);exit;


        $TotalVariations = (int)$response['Items']['Item']['Variations']['TotalVariations'];

        if(isset($response['Items']['Item']['Variations']) && $TotalVariations > 0)
        {
            $ProductVariations = $response['Items']['Item']['Variations'];
        }
        else
        {
            $ParentASIN = $response['Items']['Item']['ParentASIN'];
            $lookup = new Lookup();
            $lookup->setIdType('ASIN');
            $lookup->setResponseGroup(array('Variations', 'VariationMatrix', 'VariationSummary', 
'VariationOffers')); // More detailed information
            $lookup->setItemId($ParentASIN);
            $lookup->setCondition('All');
            $var_response = $apaiIo->runOperation($lookup);
            $var_response = json_decode (json_encode (simplexml_load_string ($var_response)), true);

            $TotalVariations = (int)$var_response['Items']['Item']['Variations']['TotalVariations'];

            if(isset($var_response['Items']['Item']['Variations']) && $TotalVariations > 0)
            {
                $ProductVariations = $var_response['Items']['Item']['Variations'];
            }
            else
            {
                $ProductVariations = "";
            }
        }
        //pre($ProductVariations);exit;
        if(!empty($ProductVariations))
        {
           // for product variations_dimensions
           $add_product_array['variations_dimentions'] = array();
           $add_product_array['variations_items'] = array();
           $add_product_array['variations_images'] = array();
           //pre($add_product_array['variations_dimentions']);exit;
           // for product variations_dimensions

           //for product varions_dimentions values
           foreach ($ProductVariations['Item'] as $pvItemKey => $pvItemValue)
           {
                //var_dump($pvItemValue['VariationAttributes']['VariationAttribute']);exit;
                if(isset($pvItemValue['VariationAttributes']['VariationAttribute'][0]) && is_array($pvItemValue['VariationAttributes']['VariationAttribute'][0]))
                {

                } else {
                    $tmpArr = $pvItemValue['VariationAttributes']['VariationAttribute'];
                    $pvItemValue['VariationAttributes']['VariationAttribute'] = array();
                    $pvItemValue['VariationAttributes']['VariationAttribute'][0] = $tmpArr;
                }

                //var_dump($pvItemValue['VariationAttributes']['VariationAttribute']);exit;

                foreach ($pvItemValue['VariationAttributes']['VariationAttribute'] as $pvItemVAKey => $pvItemVAValue)
                {

                   if(is_array($add_product_array['variations_dimentions'][$pvItemVAValue['Name']]))
                   {
                    if(!in_array($pvItemVAValue['Value'], $add_product_array['variations_dimentions'][$pvItemVAValue['Name']])){
                        array_push($add_product_array['variations_dimentions'][$pvItemVAValue['Name']], $pvItemVAValue['Value']);
                    }
                   }
                   else
                   {
                    $add_product_array['variations_dimentions'][$pvItemVAValue['Name']] = array();
                    if(!in_array($pvItemVAValue['Value'], $add_product_array['variations_dimentions'][$pvItemVAValue['Name']])){
                        array_push($add_product_array['variations_dimentions'][$pvItemVAValue['Name']], $pvItemVAValue['Value']);
                    }
                   }


                   if(is_array($add_product_array['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']]))
                   {
                       if(!in_array($pvItemValue['LargeImage']['URL'], $add_product_array['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']])){
                            array_push($add_product_array['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']], $pvItemValue['LargeImage']['URL']);
                       }
                   }
                   else
                   {
                       $add_product_array['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']] = array();
                       if(!in_array($pvItemValue['LargeImage']['URL'], $add_product_array['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']])){
                            array_push($add_product_array['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']], $pvItemValue['LargeImage']['URL']);
                       }
                   }
               }

               $add_product_array['variations_items'][$pvItemKey]['sku'] = $def_sku_prefix.$pvItemValue['ASIN'];
               $add_product_array['variations_items'][$pvItemKey]['qty'] = $def_qty;
               
               $variation_list_amount = $pvItemValue['ItemAttributes']['ListPrice']['Amount'];
               $variation_offer_amount = $pvItemValue['Offers']['Offer']['OfferListing']['Price']['Amount'];

               if(empty($variation_offer_amount)){
                    $variation_amount = $variation_list_amount;
               } else {
                    $variation_amount = $variation_offer_amount;                
               }

               //var_dump($pvItemKey);
               //var_dump($add_product_array['list_amount']);
               if($pvItemKey == 0 && empty($add_product_array['list_amount']))
               {
                $add_product_array['list_amount'] = $variation_amount;
               }

               $add_product_array['variations_items'][$pvItemKey]['price'] = $variation_amount;
               $add_product_array['variations_items'][$pvItemKey]['attrs'] = $pvItemValue['VariationAttributes']['VariationAttribute'];
               //$add_product_array['variations_items'][$pvItemKey]['price'] = 
           }

           if(!empty($add_product_array['variations_dimentions'])){
            //pre($add_product_array['variations_dimentions']);
            $add_product_array['variations_dimentions'] = json_encode($add_product_array['variations_dimentions']);
           }

           if(!empty($add_product_array['variations_items'])){
            //pre($add_product_array['variations_items']);
            $add_product_array['variations_items'] = json_encode($add_product_array['variations_items']);
           }

           if(!empty($add_product_array['variations_images'])){
            //pre($add_product_array['variations_images']);exit;
            $add_product_array['variations_images'] = json_encode($add_product_array['variations_images']);
           }

           //echo json_encode($add_product_array['variations_dimentions']);
           //echo '<br>';
           //echo json_encode($add_product_array['variations_items']);
           //exit;
        }

        //pre($response);
        //pre($ProductVariations);
        //pre($add_product_array);
        //exit;
        // [[CUSTOM]]

        $add_product_array['created_date'] = date('Y-m-d H:i:s');
        $add_product_array['modified_date'] = date('Y-m-d H:i:s');

        import_categories($awsCategories, $_GET['sourceid']);
        $sql_insert_product = insert_data('products', $add_product_array);

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
    }
}

function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
?>