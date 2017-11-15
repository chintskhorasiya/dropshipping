<?php
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
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
//session_start();
include('function.php');
include('constant.php');
//require_once ("config.php");

require_once "vendor/autoload.php";
//define('AWS_API_KEY', 'AKIAJOZTYYDTIWICCT2Q');
define('AWS_API_KEY', 'AKIAJL5OCKUJ5TXWF47Q');
//define('AWS_API_SECRET_KEY', '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');
define('AWS_API_SECRET_KEY', 'duy/xH0o6oLKbUxge7wO8fnCcPiDGqco9kmLaW5m');
//define('AWS_ASSOCIATE_TAG', 'shoes');
define('AWS_ASSOCIATE_TAG', 'dropshipping7-20');
define('AWS_ANOTHER_ASSOCIATE_TAG', '');

// [[CUSTOM]] FOR EBAY
require_once __DIR__.'/../../vendor/autoload.php';
use \DTS\eBaySDK\Sdk;
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;
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

//$awnid = explode(",", $_GET['awnid']);
$awnid = $_GET['awnid'];
//var_dump($awnid);
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
$lookup->setResponseGroup(array('Large', 'Offers', 'OfferFull', 'VariationMatrix', 'VariationSummary'
, 'VariationOffers')); // More detailed information
//$lookup->setItemId('B071FVJ9PJ');
//$lookup->setItemId('B06VW5QNBF');
$lookup->setItemId($awnid);
$lookup->setCondition('New');
$lookup->setMerchantId('Amazon');
$response = $apaiIo->runOperation($lookup);
$response = json_decode(json_encode(simplexml_load_string($response)), true);

//pre($_GET);
//pre($_POST);
//pre($response);
//exit;
//pre($response['Items']['Item']['BrowseNodes']['BrowseNode']);exit;

//string(196) "{{"id":1730879031,"name":Jeans,"parent":1730841031},{"id":1730841031,"name":Girls,"parent":83451031},{"id":83451031,"name":Categories,"parent":83450031},{"id":83450031,"name":Clothing,"parent":0}}"

//var_dump($response);
if(!empty($response))
{
    if(isset($response['Items']['Request']['Errors']['Error']))
    {
        if(isset($response['Items']['Request']['Errors']['Error'][0])){
            $errors = '';
            foreach ($response['Items']['Request']['Errors']['Error'] as $msgkey => $msgvalue) {
                $errors .= $msgvalue['Message'].'<br>';
            }
            $page_url = DEFAULT_URL.'listings/listing_requests/msg:'.$errors;
        } else {
            $error = $response['Items']['Request']['Errors']['Error']['Message'];
            $page_url = DEFAULT_URL.'listings/listing_requests/msg:'.$error;
        }
        header('Location: '.$page_url);
        exit;
    }/*
    elseif (isset($response['Items']['Item']['Offers']['TotalOffers']) && $response['Items']['Item']['Offers']['TotalOffers'] <= 0)
    {
        $error = "This product does not sell by Amazon Seller";
        $page_url = DEFAULT_URL.'listings/listing_requests/msg:'.$error;
        header('Location: '.$page_url);
        exit;
    }*/
    else
    {
        //B01E3XO44W
        
        if(!isset($response['Items']['Item'][0])){
            $tempFirstItem = $response['Items']['Item'];
            unset($response['Items']['Item']);
            $response['Items']['Item'][0] = $tempFirstItem;
        }

        //pre($response['Items']['Item']);

        $add_product_array = array();
        $succeed_product_array = array();
        $failed_product_array = array();

        $def_qty = (int) getDefaultQuantity($_GET['userid'], $_GET['sourceid']);
        $def_sku_prefix = getDefaultSkuPrefix($_GET['userid'], $_GET['sourceid']);

        foreach ($response['Items']['Item'] as $responseNum => $responseItem)
        {
            //var_dump($responseNum);
            //pre($responseItem);
            //exit;
            
            // categories
            $browseNodes = $responseItem['BrowseNodes']['BrowseNode'];
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
            // categories  if total offer is zero than directly failed // temp commented because we will fetching only amazon offers first
            /*if((int)$responseItem['Offers']['TotalOffers'] == 0){
                $failed_product_array[] = $responseItem['ASIN'];
                continue;
            }*/

            $gotOffer = false;

            //var_dump($doc->getElementById('olpOfferList')->nodeValue);exit;
            //var_dump($doc->getElementById('olpOfferList')->childNodes->item(2));exit;
            //var_dump(explode("Add to Basket", trim(strip_tags($doc->getElementById('olpOfferList')->nodeValue." Add to Basket"))));
            //echo "The element whose id is 'olpOfferList' is: " . $doc->getElementById('olpOfferList')->tagName . "\n";

            if(isset($responseItem['Offers']['Offer']) && isset($responseItem['Offers']['Offer'][0]))
            {
                foreach ($responseItem['Offers']['Offer'] as $offerNum => $offerData)
                {
                    $itemavailable = false;
                    $itemAvailability = $offerData['OfferListing']['Availability'];
                    $itemAvailabilityAttributes = $offerData['OfferListing']['AvailabilityAttributes'];
                    $itemAvailabilityMinHours = (int) $itemAvailabilityAttributes['MinimumHours'];
                    //var_dump($itemAvailability);
                    //var_dump(strpos($itemAvailability, 'Usually dispatched'));
                    //var_dump(strpos($itemAvailability, 'Temporary out of stock'));
                    /*if (strpos($itemAvailability, 'Usually dispatched') === FALSE && strpos($itemAvailability, 'Temporary out of stock') === FALSE) {
                       $itemavailable = true;
                    }*/
                    if($itemAvailabilityMinHours < 96){
                        $itemavailable = true;                        
                    }
                    //var_dump($itemavailable);
                    //exit;
                    //pre($offerData);
                    if($offerData['OfferListing']['IsEligibleForPrime'] == "1" && $itemavailable)
                    {
                        $price = (isset($offerData['OfferListing']['Price']['Amount']))?$offerData['OfferListing']['Price']['Amount']:'';
                        //var_dump($price);
                        $amount_save = (isset($offerData['OfferListing']['AmountSaved']['Amount']))?$offerData['OfferListing']['AmountSaved']['Amount']:'';
                        $sale_price = (isset($offerData['OfferListing']['SalePrice']['Amount']))?$offerData['OfferListing']['SalePrice']['Amount']:'';
                        $percentage_save = (isset($offerData['OfferListing']['PercentageSaved']))?$offerData['OfferListing']['PercentageSaved']:'';
                        $gotOffer = true;
                        break;
                    }  
                }
            }
            else
            {
                $itemavailable = false;
                $itemAvailability = $responseItem['Offers']['Offer']['OfferListing']['Availability'];
                $itemAvailabilityAttributes = $responseItem['Offers']['Offer']['OfferListing']['AvailabilityAttributes'];
                $itemAvailabilityMinHours = (int) $itemAvailabilityAttributes['MinimumHours'];
                //var_dump($itemAvailability);
                //var_dump(strpos($itemAvailability, 'Usually dispatched'));
                //var_dump(strpos($itemAvailability, 'Temporary out of stock'));
                /*if (strpos($itemAvailability, 'Usually dispatched') === FALSE && strpos($itemAvailability, 'Temporary out of stock') === FALSE) {
                   $itemavailable = true;
                }*/
                if($itemAvailabilityMinHours < 96){
                    $itemavailable = true;
                }
                //var_dump($itemavailable);
                //exit;

                if($responseItem['Offers']['Offer']['OfferListing']['IsEligibleForPrime'] == "1" && $itemavailable)
                {
                    $price = (isset($responseItem['Offers']['Offer']['OfferListing']['Price']['Amount']))?$responseItem['Offers']['Offer']['OfferListing']['Price']['Amount']:'';
                    //var_dump($price);
                    $amount_save = (isset($responseItem['Offers']['Offer']['OfferListing']['AmountSaved']['Amount']))?$responseItem['Offers']['Offer']['OfferListing']['AmountSaved']['Amount']:'';
                    $sale_price = (isset($responseItem['Offers']['Offer']['OfferListing']['SalePrice']['Amount']))?$responseItem['Offers']['Offer']['OfferListing']['SalePrice']['Amount']:'';
                    $percentage_save = (isset($responseItem['Offers']['Offer']['OfferListing']['PercentageSaved']))?$responseItem['Offers']['Offer']['OfferListing']['PercentageSaved']:'';
                    $gotOffer = true;
                }

                $get_product_attribute = $responseItem['ItemAttributes'];
                $offer_summary = $responseItem['OfferSummary'];

                // for QTY [[CUSTOM]]
            
                $totalOffers = (int) $responseItem['Offers']['TotalOffers'];
                
                //if($totalOffers > 0){
                //    if(!empty($def_qty))
                //    {
                        $add_product_array[$responseNum]['qty'] = $def_qty;
                //    }
                //    else
                //    {
                //        $add_product_array[$responseNum]['qty'] = "";
                //    }
                //} else {
                //    $add_product_array[$responseNum]['qty'] = 0;
                //}
            }

            //var_dump($gotOffer);exit;

            if(!$gotOffer){
                //var_dump($responseItem['ASIN']);exit;
                //$MoreOffersUrl = $responseItem['Offers']['MoreOffersUrl'];
                if(!empty($responseItem['Offers']['MoreOffersUrl']) || $responseItem['Offers']['MoreOffersUrl'] == "0"){
                    if(isset($_REQUEST['sourceid']) && $_REQUEST['sourceid']==2)
                    {
                        $urlbef = "https://www.amazon.co.uk/gp/offer-listing/".$responseItem['ASIN']."?";
                    } else {
                        $urlbef = "https://www.amazon.com/gp/offer-listing/".$responseItem['ASIN']."?";                        
                    }
                } else {
                    $urlbef = $responseItem['Offers']['MoreOffersUrl'];
                }
                $MoreOffersUrl = $urlbef.'&f_new=true&f_primeEligible=true';
                //echo $MoreOffersUrl;exit;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL,$MoreOffersUrl);
                $result=curl_exec($ch);
                //echo $result;exit;
                curl_close($ch);
                

                libxml_use_internal_errors(true);
                $doc = new DomDocument;
                //$doc->validateOnParse = true;
                $doc->loadHTML($result);
                //$doc->saveHTML();

                $xpath = new DOMXPath($doc);
                $classname="olpOffer";
                $elements = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
                //var_dump($elements);exit;
                if (!is_null($elements)) {
                  $curlGotPrice = false;
                  $gotPrime = false;
                  foreach ($elements as $element) {
                    //echo "First Child ### <br/>[". $element->nodeName. "]<br/>";
                    $elem = $element->getAttribute('class');
                    //var_dump($elem);

                    $nodes = $element->childNodes;
                    foreach ($nodes as $node) {
                        //echo '<pre>';print_r($node);echo '</pre>';
                        //echo $node->nodeValue. "<br>";
                        //echo "Second Child ###### <br/>[". $node->nodeName. "]<br/>";
                        $childNodes = $node->childNodes;
                        //echo count($childNodes);echo "<br>";exit;
                        foreach ($childNodes as $child) {
                            if($child->hasAttributes()){
                               $childElemClasses = $child->getAttribute('class');
                               //echo "<br>".$childElemClasses."<br>";
                               if(strpos($childElemClasses, 'olpOfferPrice'))
                               {
                                    $curlGotPrice = substr(trim(strip_tags($child->nodeValue)), 2);
                                    $curlGotPrice = ((float) $curlGotPrice) * 100;
                                    $gotOffer = true;
                                    //var_dump($curlGotPrice);
                               }
                               elseif(strpos($childElemClasses, 'olpFastTrack'))
                               {
                                  //echo 'hahahahah';var_dump($child->nodeValue);
                                  if(strpos($child->nodeValue, 'In stock') === FALSE){
                                    $curlGotPrice = false;
                                    $gotOffer = false;
                                    //var_dump($gotOffer);
                                  }
                               }
                               elseif(strpos($childElemClasses, 'supersaver') !== FALSE)
                               {
                                  //echo "<br>here gotPrime true<br>";
                                  $gotPrime = true;
                               }

                               /*if($gotOffer && $curlGotPrice){
                                    echo '<br>it will continue1<br>';
                                    break;
                               }*/
                            }
                            //echo '<pre>';print_r($child->attributes);echo '</pre>';
                            //echo "Third Child ######### <br>";
                            //echo $child->nodeValue. "<br>";
                        }

                        if($gotOffer && $curlGotPrice && $gotPrime){
                            //echo '<br>it will continue2<br>';
                            break;
                        }
                    }

                    if($gotOffer && $curlGotPrice && $gotPrime){
                        //echo '<br>it will continue3<br>';
                        break;
                    }

                  }

                  //var_dump($curlGotPrice);
                  //var_dump($gotOffer);
                  //var_dump($gotPrime);
                  //exit;

                  if($curlGotPrice && $gotOffer && $gotPrime){
                    
                    //var_dump($curlGotPrice);exit;
                    $price = $curlGotPrice;  //[[CUSTOM]] GET PRICE FROM CURL CALL IF NOT GET FROM AMAZON SELLER
                    //var_dump($price);exit;
                    $add_product_array[$responseNum]['qty'] = $def_qty;

                  } else {
                    
                    $failed_product_array[] = $responseItem['ASIN'];
                    continue;
                  
                  }

                }
                else
                {
                    $failed_product_array[] = $responseItem['ASIN'];
                    continue;
                }
            }

            $image_counter =  count($responseItem['ImageSets']['ImageSet']);
            $image_arr = $responseItem['ImageSets']['ImageSet'];
            //pre($image_arr);

            $new_image_array = array();
            $picturexmldata = '';
            for($i=0;$i<count($image_arr);$i++)
            {
                $new_image_array[$i] = $image_arr[$i]['LargeImage']['URL'];
            }

            //pre($add_product_array);

            // for QTY [[CUSTOM]]

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
            $add_product_array[$responseNum]['user_id'] = $_GET['userid'];
            $add_product_array[$responseNum]['source_id'] = $_GET['sourceid'];
            $add_product_array[$responseNum]['asin_no'] = $responseItem['ASIN'];
            $add_product_array[$responseNum]['pageurl'] = urldecode($responseItem['DetailPageURL']);
            $add_product_array[$responseNum]['title'] = addslashes($get_product_attribute['Title']);
            $add_product_array[$responseNum]['main_image'] = (isset($responseItem['LargeImage']['URL']))?$responseItem['LargeImage']['URL']:'';

            //pre($add_product_array);
            
            // [[CUSTOM]] changed image sequece
            $newImageSetArr = array();
            $newImagesArr = array();
            if(isset($responseItem['ImageSets']['ImageSet'][0]))
            {
                $totalImgs = count($responseItem['ImageSets']['ImageSet']);
                foreach ($responseItem['ImageSets']['ImageSet'] as $imgsetId => $imgsetImg) {
                    if($imgsetId == ($totalImgs - 1) && !in_array($imgsetImg['LargeImage']['URL'], $newImagesArr)){
                        array_push($newImageSetArr, $imgsetImg);
                        array_push($newImagesArr, $imgsetImg['LargeImage']['URL']);
                    }
                }
                foreach ($responseItem['ImageSets']['ImageSet'] as $imgsetId => $imgsetImg) {
                    if($imgsetId < ($totalImgs - 1) && !in_array($imgsetImg['LargeImage']['URL'], $newImagesArr)){
                        array_push($newImageSetArr, $imgsetImg);
                        array_push($newImagesArr, $imgsetImg['LargeImage']['URL']);
                    }
                }
                
            } else {
                $newImageSetArr = $responseItem['ImageSets']['ImageSet'];
            }
            // [[CUSTOM]] changed image sequece

            //pre($newImageSetArr);
            //pre($newImagesArr);exit;
            //$add_product_array[$responseNum]['image_set'] = (isset($responseItem['ImageSets']['ImageSet']))?json_encode($responseItem['ImageSets']['ImageSet']):'';
            $add_product_array[$responseNum]['image_set'] = (isset($newImageSetArr)?json_encode($newImageSetArr):'');

            $add_product_array[$responseNum]['binding'] = (isset($get_product_attribute['Binding']))?$get_product_attribute['Binding']:'';
            $add_product_array[$responseNum]['brand'] = $get_product_attribute['Brand'];
            $add_product_array[$responseNum]['color'] = (isset($get_product_attribute['Color']))?$get_product_attribute['Color']:'';
            $add_product_array[$responseNum]['features'] = (isset($get_product_attribute['Feature']))?addslashes(json_encode($get_product_attribute['Feature'])):'';
            //echo stripslashes ($add_product_array['features']);
            $add_product_array[$responseNum]['item_dimension'] = (isset($get_product_attribute['ItemDimensions']))?json_encode($get_product_attribute['ItemDimensions']):'';
            $add_product_array[$responseNum]['currency_code'] = (isset($get_product_attribute['ListPrice']['CurrencyCode']))?$get_product_attribute['ListPrice']['CurrencyCode']:'';
    //        $add_product_array[$responseNum]['list_amount'] = $get_product_attribute['ListPrice']['Amount'];
            $add_product_array[$responseNum]['list_amount'] = $price;
            //check price and sales prices

            $add_product_array[$responseNum]['new_amount'] = $new_price;
            $add_product_array[$responseNum]['sale_amount'] = $sale_price;
            $add_product_array[$responseNum]['save_amount'] = (isset($amount_save) && $amount_save!='')?$amount_save:'';
            $add_product_array[$responseNum]['model'] = (isset($get_product_attribute['Model']))?$get_product_attribute['Model']:'';
            $add_product_array[$responseNum]['mpn'] = (isset($get_product_attribute['MPN']))?$get_product_attribute['MPN']:'';
            $add_product_array[$responseNum]['upc'] = (isset($get_product_attribute['UPC']))?$get_product_attribute['UPC']:'';
            $add_product_array[$responseNum]['product_group'] = (isset($get_product_attribute['ProductGroup']))?$get_product_attribute['ProductGroup']:'';

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

            $add_product_array[$responseNum]['item_specification'] = (isset($add_item_specification))?addslashes(json_encode($add_item_specification)):'';
            //`warranty`, `description`, `submit_status`, `status`, `created_date`
            $add_product_array[$responseNum]['warranty'] = isset($get_product_attribute['Warranty'])?$get_product_attribute['Warranty']:'';
            //pre($responseItem);exit;
            $add_product_array[$responseNum]['description'] = (!empty($responseItem['EditorialReviews']['EditorialReview']['Content']))?addslashes($responseItem['EditorialReviews']['EditorialReview']['Content']):'';
            //$add_product_array[$responseNum]['page_content'] = addslashes(json_encode(($response['Items'])));
            $add_product_array[$responseNum]['submit_status'] = ($_GET['form_submit']==1)?'List Now':'Review and List';
            $add_product_array[$responseNum]['status'] = 0;

            // [[CUSTOM]]
            if(is_array($awsCategories[0]))
            {
                $add_product_array[$responseNum]['a_cat_id'] = $awsCategories[0][0]->id;
            }
            else
            {
                $add_product_array[$responseNum]['a_cat_id'] = $awsCategories[0]->id;
            }

            //pre($add_product_array);exit;

            // [[CUSTOM]] // for ebay Suggested Category Id
            if(isset($_REQUEST['sourceid']) && $_REQUEST['sourceid']==2)
            {
                $conSiteId = Constants\SiteIds::GB;
            }
            else {
                $conSiteId = Constants\SiteIds::US;
            }
            
            $serviceSug = new Services\TradingService([
                'credentials' => [

                            'devId' => EBAY_LIVE_DEVID,

                            'appId' => EBAY_LIVE_APPID,

                            'certId' => EBAY_LIVE_CERTID,

                        ],
                'siteId'      => $conSiteId
            ]);
            
            $requestSug = new Types\GetSuggestedCategoriesRequestType();
            
            $requestSug->RequesterCredentials = new Types\CustomSecurityHeaderType();
            $requestSug->RequesterCredentials->eBayAuthToken = EBAY_LIVE_AUTHTOKEN;
            
            $requestSug->Query = $add_product_array[$responseNum]['title'];

            $responseSug = $serviceSug->getSuggestedCategories($requestSug);

            if(!empty($responseSug) && isset($responseSug->SuggestedCategoryArray->SuggestedCategory))
            {

                foreach ($responseSug->SuggestedCategoryArray->SuggestedCategory as $category) {
                    
                    $add_product_array[$responseNum]['ebay_cat_id'] = $category->Category->CategoryID;
                    break;
                    /*printf(
                        "%s (%s) : Parent ID %s<br>",
                        $category->CategoryName,
                        $category->CategoryID,
                        $category->CategoryParentID[0]
                    );*/
                }
            }
            // [[CUSTOM]] // for ebay Suggested Category Id


            // for SKU [[CUSTOM]]
            if(!empty($def_sku_prefix))
            {
                $add_product_array[$responseNum]['sku'] = $def_sku_prefix.$add_product_array[$responseNum]['asin_no'];
            }
            else
            {
                $add_product_array[$responseNum]['sku'] = $add_product_array[$responseNum]['asin_no'];
            }
            // for SKU [[CUSTOM]]

            //pre($response);
            //pre($add_product_array);


            if(isset($responseItem['Variations']))
            {
                $TotalVariations = (int)$responseItem['Variations']['TotalVariations'];
                
                if($TotalVariations > 0)
                {
                    $ProductVariations = $responseItem['Variations'];
                } else {
                    $ProductVariations = "";
                }
            }
            elseif(!empty($responseItem['ParentASIN']))
            {
                $ParentASIN = $responseItem['ParentASIN'];
                $lookup = new Lookup();
                $lookup->setIdType('ASIN');
                $lookup->setResponseGroup(array('Variations', 'VariationMatrix', 'VariationSummary', 
    'VariationOffers')); // More detailed information
                $lookup->setItemId($ParentASIN);
                //$lookup->setMerchantId('Amazon');
                $lookup->setCondition('New');
                $var_response = $apaiIo->runOperation($lookup);
                $var_response = json_decode (json_encode (simplexml_load_string ($var_response)), true);
                //pre($var_response);
                //exit;
                $TotalVariations = (int)$var_response['Items']['Item']['Variations']['TotalVariations'];

                if(isset($var_response['Items']['Item']['Variations']) && $TotalVariations > 0)
                {
                    $ProductVariations = $var_response['Items']['Item']['Variations'];
                }
                else
                {
                    $ProductVariations = "";
                }
            } else {
                $ProductVariations = "";
            }
            //pre($ProductVariations);
            if(!empty($ProductVariations))
            {
                // [[CUSTOM]] FOR CHECKING VARIATION ENABLED IN EBAY

                $sdkVarEnabled = new Sdk([
                    'credentials' => [
                                'devId' => EBAY_LIVE_DEVID,
                                'appId' => EBAY_LIVE_APPID,
                                'certId' => EBAY_LIVE_CERTID,
                            ],
                    'authToken'   => EBAY_LIVE_AUTHTOKEN,
                    'siteId'      => $conSiteId
                ]);

                //var_dump($add_product_array[$responseNum]['ebay_cat_id']);
                $gotEbayCategory = (string) $add_product_array[$responseNum]['ebay_cat_id'];
                $serviceVarEnabled = $sdkVarEnabled->createTrading();
                /*$requestVarEnabled = new Trading\Types\GetCategoryFeaturesRequestType();
                $requestVarEnabled->CategoryID = (string) $add_product_array[$responseNum]['ebay_cat_id'];
                $requestVarEnabled->DetailLevel = array('ReturnAll');
                $requestVarEnabled->ViewAllNodes = true;
                $responseVarEnabled = $serviceVarEnabled->getCategoryFeatures($requestVarEnabled);
                //pre($responseVarEnabled);*/

                $requestCatSpecis = new Trading\Types\GetCategorySpecificsRequestType();
                $requestCatSpecis->CategoryID = array($gotEbayCategory); // "53159" //"20668"; 
                //"170092";
                //var_dump($requestCatSpecis);
                $requestCatSpecis->CategorySpecific->CategoryID = $gotEbayCategory;
                $responseCatSpecis = $serviceVarEnabled->getCategorySpecifics($requestCatSpecis);

                $catHaveSpecifics = $responseCatSpecis->Recommendations[0]->NameRecommendation;
                //echo count($response->Recommendations[0]->NameRecommendation);
                $varEnaSpecifics = array();
                foreach ($catHaveSpecifics as $chs_key => $chs_data) {
                    if($chs_data->ValidationRules->VariationSpecifics == "Disabled"){

                    } else {
                        //echo '<pre>';print_r($chs_data->Name);echo '</pre>';
                        //echo '<pre>';print_r($chs_data->ValueRecommendation);echo '</pre>';
                        $variationValues = array();
                        foreach ($chs_data->ValueRecommendation as $vvkey => $vvvalue) {
                            //echo '<pre>';print_r($vvvalue->Value);echo '</pre>';
                            $variationValues[] = $vvvalue->Value;
                        }
                        //$fullvariation = $chs_data->Name;
                        $varEnaSpecifics[$chs_data->Name] = $variationValues;
                    }
                }

                //pre($varEnaSpecifics);

               // [[CUSTOM]] FOR CHECKING VARIATION ENABLED IN EBAY


               // for product variations_dimensions
               $add_product_array[$responseNum]['variations_dimentions'] = array();
               $add_product_array[$responseNum]['variations_items'] = array();
               $add_product_array[$responseNum]['variations_images'] = array();
               //pre($add_product_array[$responseNum]['variations_dimentions']);exit;
               // for product variations_dimensions

               if(!isset($ProductVariations['Item'][0]))
               {
                $tempFirstVariation = $ProductVariations['Item'];
                unset($ProductVariations['Item']);
                $ProductVariations['Item'][0] = $tempFirstVariation;
               }

               //for product varions_dimentions values
               foreach ($ProductVariations['Item'] as $pvItemKey => $pvItemValue)
               {
                    //pre($pvItemValue);
                    //var_dump($pvItemValue['VariationAttributes']['VariationAttribute']);exit;

                    // [[CUSTOM]] FOR CHECKING VARIATION OFFERS

                    $vgotOffer = false;

                    if(!isset($pvItemValue['Offers']['Offer']) || empty($pvItemValue['Offers']['Offer'])){
                        continue;
                    }

                    if(!isset($pvItemValue['Offers']['Offer'][0])){
                        $tempVarOfferData = $pvItemValue['Offers']['Offer'];
                        unset($pvItemValue['Offers']['Offer']);
                        $pvItemValue['Offers']['Offer'][0] = $tempVarOfferData;
                    }

                    foreach ($pvItemValue['Offers']['Offer'] as $vofferNum => $vofferData)
                    {
                        $vitemavailable = false;
                        $vitemAvailability = $vofferData['OfferListing']['Availability'];
                        $vitemAvailabilityAttributes = $vofferData['OfferListing']['AvailabilityAttributes'];
                        $vitemAvailabilityMinHours = (int) $vitemAvailabilityAttributes['MinimumHours'];
                        if($vitemAvailabilityMinHours < 96){
                            $vitemavailable = true;                        
                        }
                        //var_dump($vitemavailable);
                        //exit;
                        //pre($vofferData);
                        if($vofferData['OfferListing']['IsEligibleForPrime'] == "1" && $vitemavailable)
                        {
                            $pvItemValue['vprice'] = (isset($vofferData['OfferListing']['Price']['Amount']))?$vofferData['OfferListing']['Price']['Amount']:'';
                            //var_dump($price);
                            $pvItemValue['vamount_save'] = (isset($vofferData['OfferListing']['AmountSaved']['Amount']))?$vofferData['OfferListing']['AmountSaved']['Amount']:'';
                            $pvItemValue['vsale_price'] = (isset($vofferData['OfferListing']['SalePrice']['Amount']))?$vofferData['OfferListing']['SalePrice']['Amount']:'';
                            $pvItemValue['vpercentage_save'] = (isset($vofferData['OfferListing']['PercentageSaved']))?$vofferData['OfferListing']['PercentageSaved']:'';
                            $vgotOffer = true;
                            break;
                        }  
                    }

                    if(!$vgotOffer){
                        continue;
                    } else {
                        //var_dump($pvItemValue['vprice']);
                        //var_dump($pvItemValue['vsale_price']);
                        if(!empty($pvItemValue['vsale_price'])){
                            $variation_amount = $pvItemValue['vsale_price'];
                        } else {
                            $variation_amount = $pvItemValue['vprice'];
                        }
                    }

                    // VARIATIONS OFFERS END

                    if(isset($pvItemValue['VariationAttributes']['VariationAttribute'][0]) && is_array($pvItemValue['VariationAttributes']['VariationAttribute'][0]))
                    {

                    } else {
                        $tmpArr = $pvItemValue['VariationAttributes']['VariationAttribute'];
                        $pvItemValue['VariationAttributes']['VariationAttribute'] = array();
                        $pvItemValue['VariationAttributes']['VariationAttribute'][0] = $tmpArr;
                    }

                    //var_dump($pvItemValue['VariationAttributes']['VariationAttribute']);exit;

                    $modiVariationAttributes = array();

                    foreach ($pvItemValue['VariationAttributes']['VariationAttribute'] as $pvItemVAKey => $pvItemVAValue)
                    {

                       if($add_product_array[$responseNum]['ebay_cat_id'] == "38229")
                       {
                           if($pvItemVAValue['Name'] == "Size") $pvItemVAValue['Name'] = "Number of Lights";
                           if($pvItemVAValue['Name'] == "Color") $pvItemVAValue['Name'] = "Main Colour";
                           if($pvItemVAValue['Value'] == "180 LED") $pvItemVAValue['Value'] = "151-200";
                           if($pvItemVAValue['Value'] == "300 LED") $pvItemVAValue['Value'] = "250-300";
                           if($pvItemVAValue['Value'] == "400 LED") $pvItemVAValue['Value'] = "301-400";
                       }

                       $modiVariationAttributes[] = array('Name' => $pvItemVAValue['Name'], 'Value' => $pvItemVAValue['Value']);

                       if(is_array($add_product_array[$responseNum]['variations_dimentions'][$pvItemVAValue['Name']]))
                       {
                        if(!in_array($pvItemVAValue['Value'], $add_product_array[$responseNum]['variations_dimentions'][$pvItemVAValue['Name']])){
                            array_push($add_product_array[$responseNum]['variations_dimentions'][$pvItemVAValue['Name']], $pvItemVAValue['Value']);
                        }
                       }
                       else
                       {
                        $add_product_array[$responseNum]['variations_dimentions'][$pvItemVAValue['Name']] = array();
                        if(!in_array($pvItemVAValue['Value'], $add_product_array[$responseNum]['variations_dimentions'][$pvItemVAValue['Name']])){
                            array_push($add_product_array[$responseNum]['variations_dimentions'][$pvItemVAValue['Name']], $pvItemVAValue['Value']);
                        }
                       }

                       // [[VARIATIONS IMAGES]]

                       //pre($pvItemValue['ImageSets']['ImageSet']);
                       if(!isset($pvItemValue['ImageSets']['ImageSet'][0]))
                       {
                            $tempVarImagesetData = $pvItemValue['ImageSets']['ImageSet'];
                            unset($pvItemValue['ImageSets']['ImageSet']);
                            $pvItemValue['ImageSets']['ImageSet'][0] = $tempVarImagesetData;
                       }

                       foreach ($pvItemValue['ImageSets']['ImageSet'] as $img_set_key => $img_set_val) {
                           
                           if(is_array($add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']]))
                           {
                               if(!in_array($img_set_val['LargeImage']['URL'], $add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']])){
                                    array_push($add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']], $img_set_val['LargeImage']['URL']);
                               }
                           }
                           else
                           {
                               $add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']] = array();
                               if(!in_array($img_set_val['LargeImage']['URL'], $add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']])){
                                    array_push($add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']], $img_set_val['LargeImage']['URL']);
                               }
                           }
                       }

                       // [[VARIATIONS IMAGES]]


                       // [[OLD VARIATIONS IMAGES CODE]]

                       /*if(is_array($add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']]))
                       {
                           if(!in_array($pvItemValue['LargeImage']['URL'], $add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']])){
                                array_push($add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']], $pvItemValue['LargeImage']['URL']);
                           }
                       }
                       else
                       {
                           $add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']] = array();
                           if(!in_array($pvItemValue['LargeImage']['URL'], $add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']])){
                                array_push($add_product_array[$responseNum]['variations_images'][$pvItemVAValue['Name']][$pvItemVAValue['Value']], $pvItemValue['LargeImage']['URL']);
                           }
                       }*/

                       // [[OLD VARIATIONS IMAGES CODE]]
                   }

                   $add_product_array[$responseNum]['variations_items'][$pvItemKey]['sku'] = $def_sku_prefix.$pvItemValue['ASIN'];
                   $add_product_array[$responseNum]['variations_items'][$pvItemKey]['qty'] = $def_qty;
                   
                   $variation_list_amount = $pvItemValue['ItemAttributes']['ListPrice']['Amount'];
                   $variation_offer_amount = $pvItemValue['Offers']['Offer']['OfferListing']['Price']['Amount'];

                   /*if(empty($variation_offer_amount)){
                        $variation_amount = $variation_list_amount;
                   } else {
                        $variation_amount = $variation_offer_amount;                
                   }*/

                   //var_dump($pvItemKey);
                   //var_dump($add_product_array['list_amount']);
                   if($pvItemKey == 0 && empty($add_product_array[$responseNum]['list_amount']))
                   {
                    $add_product_array[$responseNum]['list_amount'] = $variation_amount;
                   }

                   $add_product_array[$responseNum]['variations_items'][$pvItemKey]['price'] = $variation_amount;
                   //$add_product_array[$responseNum]['variations_items'][$pvItemKey]['attrs'] = $pvItemValue['VariationAttributes']['VariationAttribute'];

                   $add_product_array[$responseNum]['variations_items'][$pvItemKey]['attrs'] = $modiVariationAttributes;
                   //$add_product_array[$responseNum]['variations_items'][$pvItemKey]['price'] = 
               }

               if(!empty($add_product_array[$responseNum]['variations_dimentions'])){
                //pre($add_product_array[$responseNum]['variations_dimentions']);
                $add_product_array[$responseNum]['variations_dimentions'] = json_encode($add_product_array[$responseNum]['variations_dimentions']);
               }

               if(!empty($add_product_array[$responseNum]['variations_items'])){
                //pre($add_product_array[$responseNum]['variations_items']);
                $add_product_array[$responseNum]['variations_items'] = json_encode($add_product_array[$responseNum]['variations_items']);
               }

               if(!empty($add_product_array[$responseNum]['variations_images'])){
                //pre($add_product_array[$responseNum]['variations_images']);exit;
                $add_product_array[$responseNum]['variations_images'] = json_encode($add_product_array[$responseNum]['variations_images']);
               }


               //echo json_encode($add_product_array['variations_dimentions']);
               //echo '<br>';
               //echo json_encode($add_product_array['variations_items']);
               //exit;
            }

            $add_product_array[$responseNum]['created_date'] = date('Y-m-d H:i:s');
            $add_product_array[$responseNum]['modified_date'] = date('Y-m-d H:i:s');

            //pre($response);
            //pre($ProductVariations);
            //pre($add_product_array);
            //exit;
            // [[CUSTOM]]
            //import_categories($awsCategories, $_GET['sourceid']);
            $sql_insert_product = insert_data('products', $add_product_array[$responseNum]);
            //var_dump($sql_insert_product);exit;
            if($sql_insert_product!=''){
                $succeed_product_array[] = $responseItem['ASIN'];
            }
        }

        //pre($add_product_array);
        //pre($succeed_product_array);
        //pre($failed_product_array);
        //exit;

        //$sql_insert_product = insert_data('products', $add_product_array);exit;

        /*if($sql_insert_product!='')
        {
            $page_url = DEFAULT_URL.'listings/listing_requests/';
        }
        else
        {
            $error = "Some problem when upload product";
            $page_url = DEFAULT_URL.'listings/listing_requests/msg:'.$error;
        }
        header('Location: '.$page_url);
        exit;*/

        if(count($failed_product_array) > 0)
        {
          $failed_products = implode(',', $failed_product_array);
          //$failed_param = "failed_products:".$failed_products;
          if(count($failed_product_array) > 1)
          {
            $failed_products_msg = "These ".count($failed_product_array)." products are not available for listing : ".$failed_products;
          }
          else
          {
            $failed_products_msg = "This product is not available for listing : ".$failed_products;
          }
          //$_SESSION['error_msg'] = $failed_products_msg;
          $failed_products_msg_encoded = base64_encode($failed_products_msg);
          $failed_param = "/failed:".$failed_products_msg_encoded;
        }
        else
        {
          $failed_param = "";
        }

        if(count($succeed_product_array) > 0)
        {
          $succeed_products = implode(',', $succeed_product_array);
          //$succeed_param = "succeed_products:".$succeed_products;
          if(count($succeed_product_array) > 1)
          {
            $succeed_products_msg = "These ".count($succeed_product_array)." products are successfully listed : ".$succeed_products;
          }
          else
          {
            $succeed_products_msg = "This product is successfully listed : ".$succeed_products;
          }
          //$_SESSION['success_msg'] = $succeed_products_msg;
          $succeed_products_msg_encoded = base64_encode($succeed_products_msg);
          $succeed_param = "/succeed:".$succeed_products_msg_encoded;
        }
        else
        {
          $succeed_param = "";
        }

        if(isset($_GET['aeid']))
        {
            $existed_product_array = explode(',', $_GET['aeid']);
            if(count($existed_product_array) > 0)
            {
              $existed_products = implode(',', $existed_product_array);
              //$succeed_param = "succeed_products:".$succeed_products;
              if(count($existed_product_array) > 1)
              {
                $existed_products_msg = "These ".count($existed_product_array)." products are already existed : ".$existed_products;
              }
              else
              {
                $existed_products_msg = "This product is already existed : ".$existed_products;
              }
              //$_SESSION['error_msg'] = $existed_products_msg;
              $existed_products_msg_encoded = base64_encode($existed_products_msg);
              $existed_param = "/existed:".$existed_products_msg_encoded;
            }
            else
            {
              $existed_param = "";
            }
        }

        //print_r($_SESSION);
        //exit;


        $page_url = DEFAULT_URL.'listings/listing_requests'.$succeed_param.$failed_param.$existed_param;
        //$page_url = DEFAULT_URL.'listings/listing_requests';
        header('Location: '.$page_url);
        exit;
    }
}
?>