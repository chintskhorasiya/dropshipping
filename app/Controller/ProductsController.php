<?php

// [[CUSTOM]] FOR EBAY
require __DIR__.'/../../vendor/autoload.php';

// [[CUSTOM]] FOR AMAZON
require __DIR__.'/../webroot/vendor/autoload.php';


// [[CUSTOM]] FOR EBAY
use \DTS\eBaySDK\Constants;

use \DTS\eBaySDK\Trading\Services;

use \DTS\eBaySDK\Trading\Types;

use \DTS\eBaySDK\Trading\Enums;


// [[CUSTOM]] FOR AMAZON
use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;

//App::import('Vendor', 'resize_img');
class ProductsController extends AppController {

    var $name = 'Products';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator');
    public $helpers = array('Html', 'Form', 'Session', 'Time');
    var $uses = array('Product');

    function product_add($user_encryptid)
    {
        $this->layout = 'default';
        $this->checklogin();

        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);
        $this->check_login_user($userid);

        //$this->pre($this->params);

        if (!empty($this->data)) {

            //Check user record inserted or not in store setting
            $check_store_settings = $this->StoreSetting->find('first', array('conditions' => array('user_id'=>$userid)));
            //$this->pre($check_store_settings);

            $this->request->data['StoreSetting']['enable_repricing'] = (isset($this->data['StoreSetting']['enable_repricing']) && $this->data['StoreSetting']['enable_repricing']==1)?$this->data['StoreSetting']['enable_repricing']:0;
            $this->request->data['StoreSetting']['enable_auto_ordering'] = (isset($this->data['StoreSetting']['enable_auto_ordering']) && $this->data['StoreSetting']['enable_auto_ordering']==1)?$this->data['StoreSetting']['enable_auto_ordering']:0;
            $this->request->data['StoreSetting']['user_id'] = $userid;
            $this->request->data['StoreSetting']['modified_date'] = date('Y-m-d H:i:s');

            if(!empty($check_store_settings))
                $this->request->data['StoreSetting']['id'] = $check_store_settings['StoreSetting']['id'];
            else
                $this->request->data['StoreSetting']['created_date'] = date('Y-m-d H:i:s');

//            $this->pre($this->data);
//            exit;

            $this->StoreSetting->save($this->data['StoreSetting']);
            $this->redirect(DEFAULT_URL . 'stores/store_setting/'.$user_encryptid.'/msg:'.SUCUPDATE);
            exit;

//            $this->pre($this->data);
//            exit;
         }

        $this->data = $this->StoreSetting->find('first', array('conditions' => array('user_id'=>$userid)));

//        echo "vivek123";
//        exit;
    }

    function checkavail($productId = ''){

        $this->checklogin();

        if(empty($productId))
        {
            echo "Feature coming soon...";
        }
        else
        {
            //var_dump($productId);

            $product_data = $this->Product->find('first', array('conditions' => array('id'=>$productId)));

            //$this->pre($product_data);exit;

            //var_dump(AWS_API_KEY);

            // GET AMAZON DATA FIRST

            $product_source_id = $product_data['Product']['source_id'];
            $product_asin_no = $product_data['Product']['asin_no'];
            $product_ebay_price = (float) $product_data['Product']['ebay_price'];
            $product_ebay_price_with_hundred = (float) $product_data['Product']['ebay_price']*100;
            $product_ebay_id = $product_data['Product']['ebay_id'];
            $product_a_cat_id = $product_data['Product']['a_cat_id'];
            $product_variations_dimentions = $product_data['Product']['variations_dimentions'];

            $country_cod = 'com';
            $siteId = Constants\SiteIds::US;
            if(isset($product_source_id) && $product_source_id==2)
            {
                $country_cod = 'co.uk';
                $siteId = Constants\SiteIds::GB;
            }

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

            $awnid = $product_asin_no;

            $lookup = new Lookup();
            $lookup->setResponseGroup(array('Offers')); // More detailed information
            $lookup->setItemId($awnid);
            $lookup->setCondition('All');
            $response = $apaiIo->runOperation($lookup);
            $response = json_decode (json_encode (simplexml_load_string ($response)), true);

            //$this->pre($response);exit;

            $totalOffers = (int) $response['Items']['Item']['Offers']['TotalOffers'];
        
            if($totalOffers > 0)
            {

                $_SESSION['success_msg'] = "Item is still available !";
                return $this->redirect(DEFAULT_URL.'listings/listing_requests/');
            }
            else
            {
                $_SESSION['error_msg'] = "Item is out of stock now !";
                return $this->redirect(DEFAULT_URL.'listings/listing_requests/');
            }

            $price = (isset($response['Items']['Item']['Offers']['Offer']['OfferListing']['Price']['Amount']))?$response['Items']['Item']['Offers']['Offer']['OfferListing']['Price']['Amount']:'';
            $amount_save = (isset($response['Items']['Item']['Offers']['Offer']['OfferListing']['AmountSaved']['Amount']))?$response['Items']['Item']['Offers']['Offer']['OfferListing']['AmountSaved']['Amount']:'';
            $sale_price = (isset($response['Items']['Item']['Offers']['Offer']['OfferListing']['SalePrice']['Amount']))?$response['Items']['Item']['Offers']['Offer']['OfferListing']['SalePrice']['Amount']:'';
            $percentage_save = (isset($response['Items']['Item']['Offers']['Offer']['OfferListing']['PercentageSaved']))?$response['Items']['Item']['Offers']['Offer']['OfferListing']['PercentageSaved']:'';

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

            $this->loadmodel('SourceSettings');
            $source_settings_data = $this->SourceSettings->find('first',array('conditions' => array('source_id' => $product_source_id, 'user_id' => $userid)));

            $this->loadmodel('CategoriesMappings');
            $categories_mappings_data = $this->CategoriesMappings->find('first',array('conditions' => array('source_id' => $product_source_id, 'user_id' => $userid, 'a_cat_id' => $product_a_cat_id)));

            $primaryCategory = $categories_mappings_data['CategoriesMappings']['e_cat_id'];
            
            $def_qty = (int) (!empty($source_settings_data['SourceSettings']['quantity']) ? $source_settings_data['SourceSettings']['quantity'] : 1);

            $def_sku_prefix = (!empty($source_settings_data['SourceSettings']['skupattern']) ? $source_settings_data['SourceSettings']['skupattern'] : "");

            $marginpercent = (float)$source_settings_data['SourceSettings']['marginpercent'];
            if(!empty($marginpercent)){
                $final_margin = ($price * $marginpercent)/100;
            }
            if(!empty($final_margin)){
                $margin_added_price = round($price + $final_margin, 2);
            } else {
                $margin_added_price = round($price, 2);
            }

            $price = (float) round($margin_added_price/100, 2);
            //var_dump($product_ebay_price);
            //var_dump($price);exit;

            $product_variations_need_revise = false;

            if(!empty($product_variations_dimentions))
            {
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
                    $lookup->setResponseGroup(array('VariationOffers', 'VariationMatrix')); // More detailed information
                    $lookup->setItemId($ParentASIN);
                    $lookup->setCondition('All');
                    $var_response = $apaiIo->runOperation($lookup);
                    $var_response = json_decode (json_encode (simplexml_load_string ($var_response)), true);

                    //$this->pre($var_response);exit;

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

                //$this->pre($ProductVariations);exit;

                if(!empty($ProductVariations))
                {
                   $add_product_array['variations_items'] = array();
                   
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

                       $add_product_array['variations_items'][$pvItemKey]['sku'] = $def_sku_prefix.$pvItemValue['ASIN'];
                       $add_product_array['variations_items'][$pvItemKey]['qty'] = $def_qty;
                       
                       $variation_list_amount = $pvItemValue['ItemAttributes']['ListPrice']['Amount'];
                       $variation_offer_amount = $pvItemValue['Offers']['Offer']['OfferListing']['Price']['Amount'];

                       if(empty($variation_offer_amount)){
                            $variation_amount = $variation_list_amount;
                       } else {
                            $variation_amount = $variation_offer_amount;                
                       }

                       $add_product_array['variations_items'][$pvItemKey]['price'] = $variation_amount;
                       $add_product_array['variations_items'][$pvItemKey]['attrs'] = $pvItemValue['VariationAttributes']['VariationAttribute'];
                   }

                   if(!empty($add_product_array['variations_items']))
                   {
                        $add_product_array['variations_items'] = json_encode($add_product_array['variations_items']);

                        $this->Product->id = $this->Product->field('id', array('id' => $productId));

                        if ($this->Product->id) {

                            $this->Product->saveField('variations_items', $add_product_array['variations_items']);

                            $product_variations_need_revise = true;
                            //print("The item was successfully revised on the eBay Sandbox.");
                        }    
                   }
                }

            }

            if($product_ebay_price < $price)
            {
                $service = new Services\TradingService([
                    'credentials' => [
                        'devId' => EBAY_SANDBOX_DEVID,
                        'appId' => EBAY_SANDBOX_APPID,
                        'certId' => EBAY_SANDBOX_CERTID,
                    ],
                    'sandbox'     => true,
                    'siteId'      => $siteId
                ]);

                /**
                 * Create the request object.
                 */
                $request = new Types\ReviseFixedPriceItemRequestType();

                /**
                 * An user token is required when using the Trading service.
                 */
                $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
                $request->RequesterCredentials->eBayAuthToken = EBAY_SANDBOX_AUTHTOKEN;

                /**
                 * Begin creating the fixed price item.
                 */
                $item = new Types\ItemType();

                /**
                 * Tell eBay which item we are revising.
                 */
                $item->ItemID = $product_ebay_id;

                //$this->pre($item);exit;

                $item->StartPrice = new Types\AmountType(['value' => (float)$price]);

                //$this->pre($item);exit;

                if($product_variations_need_revise){

                    $variations_dimentions = json_decode($product_data['Product']['variations_dimentions']);
                    $variations_items = json_decode($product_data['Product']['variations_items']);
                    $variations_images = json_decode($product_data['Product']['variations_images']);
                    
                    $size_mens_categories = array('11483','15687', '11484', '57990');
                    $mens_bottom_size_categories = array('57989');
                    $mens_us_shoe_size_categories = array('24087');

                    $item->Variations = new Types\VariationsType();
                    /**
                     * Before we specify the variations we need to inform eBay all the possible
                     * names and values that the listing could use over its life time.
                     */
                    $variationSpecificsSet = new Types\NameValueListArrayType();
                    
                    foreach ($variations_dimentions as $variations_dimentions_key => $variations_dimentions_values) {
                        $nameValue = new Types\NameValueListType();
                        if($variations_dimentions_key == "Size" && in_array($primaryCategory, $size_mens_categories)){
                            $variations_dimentions_key = "Size (Men's)";
                        }elseif($variations_dimentions_key == "Size" && in_array($primaryCategory, $mens_bottom_size_categories)){
                            $variations_dimentions_key = "Bottoms Size (Men's)";
                        }elseif($variations_dimentions_key == "Size" && in_array($primaryCategory, $mens_us_shoe_size_categories)){
                            $variations_dimentions_key = "US Shoe Size (Men's)";
                        }
                        $nameValue->Name = $variations_dimentions_key;
                        $nameValue->Value = $variations_dimentions_values;
                        $variationSpecificsSet->NameValueList[] = $nameValue;
                    }
                    
                    $item->Variations->VariationSpecificsSet = $variationSpecificsSet;
                    
                    //$this->pre($item);exit;

                    if(!empty($variations_items))
                    {
                        foreach ($variations_items as $variations_items_key => $variations_items_value)
                        {
                            $variation = new Types\VariationType();
                            $variation->SKU = $variations_items_value->sku; //'TS-'.$variations_items_key
                            $variation->Quantity = $variations_items_value->qty;

                            $variationPrice = (float)($variations_items_value->price/100);

                            //var_dump($variationPrice);

                            if(!empty($marginpercent)){
                                $final_margin = ($variationPrice * $marginpercent)/100;
                            }
                            if(!empty($final_margin)){
                                $variationPrice = round($variationPrice + $final_margin, 2);
                            } else {
                                $variationPrice = round($variationPrice, 2);
                            }

                            //var_dump($variationPrice);
                            //echo '<br>';

                            $variation->StartPrice = new Types\AmountType(['value' => $variationPrice]);

                            $variationSpecifics = new Types\NameValueListArrayType();

                            foreach ($variations_items_value->attrs as $var_items_value_key => $var_items_value_value) {
                                $nameValue = new Types\NameValueListType();
                                if($var_items_value_value->Name == "Size" && in_array($primaryCategory, $size_mens_categories)){
                                    $var_items_value_value->Name = "Size (Men's)";
                                } elseif($var_items_value_value->Name == "Size" && in_array($primaryCategory, $mens_bottom_size_categories)){
                                    $var_items_value_value->Name = "Bottoms Size (Men's)";
                                } elseif($var_items_value_value->Name == "Size" && in_array($primaryCategory, $mens_us_shoe_size_categories)){
                                    $var_items_value_value->Name = "US Shoe Size (Men's)";
                                }
                                //var_dump($var_items_value_value->Name);
                                $nameValue->Name = $var_items_value_value->Name;
                                $nameValue->Value = [$var_items_value_value->Value];
                                $variationSpecifics->NameValueList[] = $nameValue;
                            }

                            $variation->VariationSpecifics[] = $variationSpecifics;
                            $item->Variations->Variation[] = $variation;
                        }
                    }

                    //exit;

                    if(!empty($variations_images))
                    {
                        $pictures = new Types\PicturesType();
                        foreach ($variations_images as $variations_images_key => $variations_images_value)
                        {
                            if($variations_images_key == "Size"){
                                continue;
                            }

                            $pictures->VariationSpecificName = $variations_images_key;
                            foreach ($variations_images_value as $variations_attrimages_key => $variations_attrimages_value)
                            {
                                $pictureSet = new Types\VariationSpecificPictureSetType();
                                $pictureSet->VariationSpecificValue = $variations_attrimages_key;
                                if(is_array($variations_attrimages_value)){
                                    foreach ($variations_attrimages_value as $pic_url_key => $pic_url) {
                                        if(!empty($pic_url)) $pictureSet->PictureURL[] = $pic_url;   
                                    }
                                }
                                $pictures->VariationSpecificPictureSet[] = $pictureSet;
                            }
                        }
                        $item->Variations->Pictures[] = $pictures;
                    }

                    //$this->pre($item);exit;
                
                    //Item specifics
                    $item->ItemSpecifics = new Types\NameValueListArrayType();
                    $itemSpecificationsKeysArr = $_POST['item_key'];
                    $itemSpecificationsValsArr = $_POST['item_val'];
                    if(count($itemSpecificationsKeysArr) > 0){

                        foreach ($itemSpecificationsKeysArr as $iscKey => $item_key) {

                            $specific = new Types\NameValueListType();
                            //if($item_key == "Features" && in_array($primaryCategory, $size_mens_categories)){
                            if($item_key == "Features"){
                                $item_key = "Style";

                                $styleSpecArr = explode(",", $itemSpecificationsValsArr[$iscKey]);
                                $itemSpecificationsValsArr[$iscKey] = $styleSpecArr[0];
                            }
                            $specific->Name = $item_key;

                            $specific->Value[] = $itemSpecificationsValsArr[$iscKey];

                            $item->ItemSpecifics->NameValueList[] = $specific;

                        }

                        if(in_array($primaryCategory, $size_mens_categories) || in_array($primaryCategory, $mens_bottom_size_categories) || in_array($primaryCategory, $mens_us_shoe_size_categories)){
                            $specific = new Types\NameValueListType();
                            $specific->Name = 'Size Type';
                            $specific->Value[] = 'Regular';
                            $item->ItemSpecifics->NameValueList[] = $specific;
                        }

                    }
                }


                //$this->pre($item);exit;


                /**
                 * Finish the request object.
                 */
                $request->Item = $item;
                /**
                 * Send the request.
                 */
                $response = $service->reviseFixedPriceItem($request);


                /**
                 * Output the result of calling the service operation.
                 */
                if (isset($response->Errors)) {
                    foreach ($response->Errors as $error) {
                        
                        if($error->SeverityCode === 'Warning'){

                            $_SESSION['warning_msg'] = sprintf(

                                "%s: %s\n%s\n\n",
                                $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                                $error->ShortMessage,
                                $error->LongMessage
                            );


                        } else {

                            $_SESSION['error_msg'] = sprintf(
                                "%s: %s\n%s\n\n",
                                $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                                $error->ShortMessage,
                                $error->LongMessage
                            );

                        }

                        /*printf(
                            "%s: %s\n%s\n\n",
                            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                            $error->ShortMessage,
                            $error->LongMessage
                        );*/
                    }
                }
                if ($response->Ack !== 'Failure') {

                    $_SESSION['success_msg'] = "The item was successfully revised on the eBay Sandbox.";

                    $this->Product->id = $this->Product->field('id', array('id' => $productId));

                    if ($this->Product->id) {

                        $this->Product->saveField('ebay_price', $price);
                        //print("The item was successfully revised on the eBay Sandbox.");
                    }
                
                }

            }
            else
            {
                $_SESSION['success_msg'] = "Item price is same now";            
                //return false;
            }

            return $this->redirect(DEFAULT_URL.'listings/listing_requests/');
        }

        exit;

    }
}
?>