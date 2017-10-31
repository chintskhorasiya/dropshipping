<?php

App::import('Vendor', 'resize_img');


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


class ListingsController extends AppController {



    var $name = 'Listings';

    public $components = array('Cookie', 'Session', 'Email', 'Paginator');

    public $helpers = array('Html', 'Form', 'Session', 'Time');

    var $uses = array('ListingSettings','Product','Blacklist','ListingTemplate');



    function listing_template(){

        $this->layout = 'default';
        $this->checklogin();

//        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);
//        $this->check_login_user($userid);

        //$userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

//        $this->pre($this->data);
//        exit;

        if(isset($this->data['btn_save_changes']) && $this->data['btn_save_changes'])
        {
            $this->ListingTemplate->updateAll(
                array('ListingTemplate.flag' => 0)
            );

            $this->ListingTemplate->updateAll(
                array('ListingTemplate.flag' => 1),
                array('ListingTemplate.id =' => $this->data['save_template'])
            );
        }

        $template_data = $this->ListingTemplate->find('all', array('conditions' => array('flag'=>1)));
        $this->set('template_data',$template_data);



//        $product_data = $this->Product->find('first', array('conditions' => array('id'=>1)));
//        $this->set('product_data',$product_data);
//
//        $tmp = json_decode($product_data['Product']['features']);
//
//        $this->pre($product_data['Product']['features']);
//        $this->pre($tmp);
//        $this->pre($product_data);
//        $this->pre($template_data);
//        exit;
    }

    function ajax_list_template()
    {
        //$this->pre($_POST['passid']);
        $template_data = $this->ListingTemplate->find('all', array('conditions' => array('id'=>$_POST['passid'])));
        $this->set('template_data',$template_data);
    }

    function manage_blacklists($user_encryptid)

    {

        $this->layout = 'default';

        $this->checklogin();



        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);

        $this->check_login_user($userid);



        $userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');



        $check_blacklist = $this->Blacklist->find('first', array('conditions' => array('user_id'=>$userid)));

        //$this->pre($check_blacklist);

        if(!empty($this->data['btn_blackklist']) && $this->data['btn_blackklist']!='')

        {

            $add_blackklist_data['Blacklist'] = $this->data['Blacklist'];



            $add_blackklist_data['Blacklist']['created_date'] = date('Y-m-d H:i:s');

            $add_blackklist_data['Blacklist']['modified_date'] = date('Y-m-d H:i:s');

            $add_blackklist_data['Blacklist']['user_id'] = $userid;

            if(!empty($check_blacklist))

                $add_blackklist_data['Blacklist']['id'] = $check_blacklist['Blacklist']['id'];



            $this->Blacklist->save($add_blackklist_data['Blacklist']);

            $this->redirect(DEFAULT_URL . 'listings/manage_blacklists/'.$user_encryptid.'/'.SUCADD);

            exit;

        }



        $set_blacklist_data = $this->Blacklist->find('first', array('conditions' => array('user_id'=>$userid)));

        $this->set('set_blacklist_data',$set_blacklist_data);

    }



    //function for create listing

    function create_listing($user_encryptid) {



        $this->layout = 'default';

        $this->checklogin();



        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);

        $this->check_login_user($userid);



        $error_array = array();



        if(!empty($this->data['btn_list_now']) && $this->data['btn_list_now']=='List Now')

        {

            $form_submit = 1;

            $awnid = $this->data['Listing']['content'];

            $check_content = $this->check_url($this->data['Listing']['content']);

            if($check_content==1)

            {

                $awnid = $this->get_awnid($this->data['Listing']['content']);

            }

        }

        if(!empty($this->data['btn_review_list']) && $this->data['btn_review_list']=='Review and List')

        {

            $form_submit = 2;

            $awnid = $this->data['Listing']['content'];

            //echo "Review and List";

            $check_content = $this->check_url($this->data['Listing']['content']);

            if($check_content==1)

            {

                //$awnid = $this->get_awnid($this->data['Listing']['content']);
                $awnid = $this->get_asin($awnid); // [[CUSTOM]] // to get correct ASIN number for amazon product

            }

        }



        if(!empty($this->data))

        {

//            $this->pre($this->data);

//            echo $awnid;

//            exit;



            $userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

            $sourceid = $this->data['Listing']['source_id'];



            //check awnid

            $check_product = $this->Product->find('all', array('conditions' => array('user_id'=>$userid,'source_id'=> $sourceid,'asin_no'=>$awnid)));



//            $this->pre($check_product);

//            $this->pre($this->data);

//            exit;

            $error_array = array();

            if(!empty($check_product))

            {

                $error_array['dup_product'] = PRODUCT_EXISTS;

            }

            else

            {

                $this->redirect(DEFAULT_URL .'get_product_detail.php?userid='.$userid.'&sourceid='.$sourceid.'&awnid='.$awnid.'&form_submit='.$form_submit );

                exit;

            }

            $this->set('error_array',$error_array);





//            $this->pre($this->data);

//            exit;

        }



        //$data = file_get_contents('https://www.amazon.co.uk/dp/B01DFKBL68/ref=fs_bis');

    }



    //function for display listing request page

    function listing_requests() {

        //$user_encryptid

        $this->layout = 'default';

        $this->checklogin();

        $userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

//        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);

//        $this->check_login_user($userid);



        $product_data = $this->Product->find('all', array('conditions' => array('user_id'=>$userid, 'status IN'=> array(0,1))));

        $this->set('product_data',$product_data);
        //$this->set('user_encryptid',$user_encryptid);



//        $this->pre($product_data);

//        exit;

    }



    function listing_review($asin_no)

    {

        $this->layout = 'default';

        $this->checklogin();



        $userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

//        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);

//        $this->check_login_user($userid);



        $product_data = $this->Product->find('first', array('conditions' => array('user_id'=>$userid,'asin_no'=>$asin_no)));

        $this->set('product_data',$product_data);

        $product_source_id = $product_data['Product']['source_id'];

        $this->loadmodel('EbaySettings');
        $ebay_settings_data = $this->EbaySettings->find('first', array('conditions' => array('user_id'=>$userid,'source_id'=>$product_source_id)));
        $this->set('ebay_settings_data',$ebay_settings_data);
        
        // [[CUSTOM]]
        $this->loadmodel('SourceSettings');
        $source_settings_data = $this->SourceSettings->find('first',array('conditions' => array('source_id' => $product_source_id)));
        $this->set('source_settings_data',$source_settings_data['SourceSettings']);

        $this->loadmodel('CategoriesMappings');
        $cat_mappings_data = $this->CategoriesMappings->find('first',array('conditions' => array('source_id' => $product_source_id, 'user_id' => $userid, 'a_cat_id' => $product_data['Product']['a_cat_id'])));
        if(!empty($cat_mappings_data)){
            $primaryCategory = $cat_mappings_data['CategoriesMappings']['e_cat_id'];
        } else {
            $primaryCategory = "";
        }
        $this->set('mapped_category',$primaryCategory);
        // [[CUSTOM]]

//        $this->pre($this->data);

//                exit;



            if (!empty($this->data)) {



                $update_data_array = array();

                if(count($this->data['item_key'])>0)

                {

                     $item_spe_array = array();



                     $this->request->data['item_key'] = array_filter($this->data['item_key']);

                     $this->request->data['item_val'] = array_filter($this->data['item_val']);



                     for($i=0;$i<count($this->data['item_key']);$i++)

                     {

                         $item_spe_array[$this->data['item_key'][$i]] = $this->data['item_val'][$i];

                         if($this->data['item_key'][$i]=='Brand')

                             $update_data_array['brand'] = $this->data['item_val'][$i];

                         if($this->data['item_key'][$i]=='Model')

                             $update_data_array['model'] = $this->data['item_val'][$i];

                         if($this->data['item_key'][$i]=='MPN')

                             $update_data_array['mpn'] = $this->data['item_val'][$i];

                         if($this->data['item_key'][$i]=='UPC')

                             $update_data_array['upc'] = $this->data['item_val'][$i];

                     }

                     $update_data_array['item_specification'] = json_encode($item_spe_array);

                }



                if(count($this->data['image_name'])>0)

                {

                     $image_array = array();

                     $this->request->data['image_name'] = array_filter($this->data['image_name']);

                     for($i=0;$i<count($this->data['image_name']);$i++)

                     {

                         $image_array[$i]['LargeImage']['URL'] = $this->data['image_name'][$i];

                     }

                     $update_data_array['image_set'] = json_encode($image_array);

                }



                if (!empty($this->data['btn_approve']) && $this->data['btn_approve']=='Approve') {



                }

                if (!empty($this->data['btn_reject']) && $this->data['btn_reject']=='Reject') {



                }



                $update_data_array['title'] = addslashes($this->data['title']);

                $update_data_array['modified_date'] = date('Y-m-d H:i:s');

                $update_data_array['id'] = $product_data['Product']['id'];



                $this->Product->save($update_data_array);

                $this->redirect(DEFAULT_URL . 'listings/listing_requests/');

                exit;



//                $this->pre($image_array);

//                $this->pre($item_spe_array);

//                $this->pre($update_data_array);

//                $this->pre($this->data);

//                exit;

        }

//        $this->pre($product_data);

//        exit;

    }

    function test_ebay_live_account()
    {
        $service = new Services\TradingService([
            'credentials' => [

                        'devId' => EBAY_LIVE_DEVID,

                        'appId' => EBAY_LIVE_APPID,

                        'certId' => EBAY_LIVE_CERTID,

                    ],
            'siteId'      => Constants\SiteIds::GB
        ]);


        /**
         * Create the request object.
         */
        $request = new Types\GetStoreRequestType();
        /**
         * An user token is required when using the Trading service.
         *
         * NOTE: eBay will use the token to determine which store to return.
         */
        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = EBAY_LIVE_AUTHTOKEN;
        /**
         * Send the request.
         */

        //$this->pre($service);exit;

        $response = $service->getStore($request);

        $this->pre($response);exit;

    }



    function listing_review_approve()

    {

        if(isset($_POST['btn_approve']) && $_POST['btn_approve'] == "Approve")

        {

            $storeId = $_POST['store_id'];
            $userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

            //$config = require __DIR__.'/configuration.php';
            if($storeId == "2"){
                $siteId = Constants\SiteIds::GB;
            } else {
                $siteId = Constants\SiteIds::US;
            }

            $this->loadmodel('EbaySettings');
            $ebay_settings_data = $this->EbaySettings->find('first', array('conditions' => array('user_id'=>$userid,'source_id'=>$storeId)));
            
            //$this->pre($ebay_settings_data);exit;

            $ebay_live = (int) (isset($ebay_settings_data['EbaySettings']['account_type']) ? $ebay_settings_data['EbaySettings']['account_type'] : 0 );
            //var_dump($siteId);exit;
            
            if($ebay_live)
            {
                $service = new Services\TradingService([

                    'credentials' => [

                        'devId' => EBAY_LIVE_DEVID,

                        'appId' => EBAY_LIVE_APPID,

                        'certId' => EBAY_LIVE_CERTID,

                    ],

                    'sandbox'     => false,

                    'siteId'      => $siteId

                ]);

                $ebay_auth_token = EBAY_LIVE_AUTHTOKEN;

                //$this->pre($service);exit;
            }
            else
            {
                $service = new Services\TradingService([

                    //'credentials' => $config['sandbox']['credentials'],
                    'credentials' => [

                        'devId' => EBAY_SANDBOX_DEVID,

                        'appId' => EBAY_SANDBOX_APPID,

                        'certId' => EBAY_SANDBOX_CERTID,

                    ],

                    'sandbox'     => true,

                    'siteId'      => $siteId

                ]);

                $ebay_auth_token = EBAY_SANDBOX_AUTHTOKEN;
            }

            //var_dump($ebay_auth_token);exit;

            ini_set('magic_quotes_gpc', false);    // magic quotes will only confuse things like escaping apostrophe

            //Get the item entered

            $this->loadmodel('SourceSettings');
            $source_settings_data = $this->SourceSettings->find('first',array('conditions' => array('source_id' => $storeId, 'user_id' => $userid)));
            $marginpercent = (float)$source_settings_data['SourceSettings']['marginpercent'];

            $listingType     = $_POST['listingType'];
            //$this->pre($_POST);exit;
            $primaryACategory = $_POST['primaryACategory'];
            
            if(isset($_POST['primaryCategory'])) $primaryCategory = $_POST['primaryCategory'];

            $itemTitle       = $_POST['title'];

            $startPrice      = (float) $_POST['product_price'];

            /*if(!empty($marginpercent)){
                $final_margin = ($startPrice * $marginpercent)/100;
            }
            if(!empty($final_margin)){
                $startPrice = round($startPrice + $final_margin, 2);
            } else {
                $startPrice = round($startPrice, 2);
            }*/

            //$buyItNowPrice   = $_POST['buyItNowPrice'];

            $listingDuration = $_POST['listingDuration'];

            //$safequery       = $_POST['searched_keyword'];



            $return_url = $_POST['return_url'];

            $asin_no = $_POST['asin_no'];

            $storeCountry = $_POST['store_country'];
            $storeCurrency = $_POST['store_currency'];

            if(isset($_POST['withvariation']) && !empty($_POST['withvariation'])){
                $withVariations = true;
            } else {
                $withVariations = false;
            }

            // [[CUSTOM]]
            $userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');
            $this->loadmodel('SourceSettings');
            $source_settings_data = $this->SourceSettings->find('first',array('conditions' => array('source_id' => $storeId, 'user_id' => $userid)));

            //var_dump($_POST['qty_number']);exit;
            
            $def_qty = (int) ($_POST['qty_number'] != "" ? $_POST['qty_number'] : (!empty($source_settings_data['SourceSettings']['quantity']) ? $source_settings_data['SourceSettings']['quantity'] : 1));

            //var_dump($def_qty);exit;

            $def_sku_prefix = (!empty($source_settings_data['SourceSettings']['skupattern']) ? $source_settings_data['SourceSettings']['skupattern'] : "");
            // [[CUSTOM]]


            // [[CUSTOM]]
            $this->loadmodel('Product');
            $products_data = $this->Product->find('first',array('conditions' => array('id' => $_POST['productId'])));
            
            $variations_dimentions = json_decode(!empty($products_data['Product']['variations_dimentions']) ? $products_data['Product']['variations_dimentions'] : "");

            $variations_items = json_decode(!empty($products_data['Product']['variations_items']) ? $products_data['Product']['variations_items'] : "");


            $variations_images = json_decode(!empty($products_data['Product']['variations_images']) ? $products_data['Product']['variations_images'] : "");            //$this->pre($variations_dimentions);exit;
            // [[CUSTOM]]

            //print_r($_POST);exit;

            if(get_magic_quotes_gpc()) {

                // print "stripslashes!!! <br>\n";

                $itemDescription = stripslashes($_POST['itemDescription']);

            } else {

                $itemDescription = $_POST['itemDescription'];

            }

            $itemCondition   = $_POST['itemCondition'];



            // product images

            $img_name = $_POST['image_name'];



            /**

             * Create the request object.

             */

            $request = new Types\AddFixedPriceItemRequestType();

            /**

             * An user token is required when using the Trading service.

             */

            $request->RequesterCredentials = new Types\CustomSecurityHeaderType();

            $request->RequesterCredentials->eBayAuthToken = $ebay_auth_token;

            /**

             * Begin creating the fixed price item.

             */

            $item = new Types\ItemType();

            /**

             * The item that will be listed is the audiobook of a well known novel.

             */

            $item->Title = $itemTitle;

            $item->Description = $itemDescription;



            /**

             * Since the item is an audio book list in the Books > Audiobooks (29792) category.

             */

            $item->PrimaryCategory = new Types\CategoryType();

            if(!empty($primaryCategory)){
                $primaryCategory = $_POST['primaryCategory'];
                $item->PrimaryCategory->CategoryID = $_POST['primaryCategory'];
            } else {
                $this->loadmodel('CategoriesMappings');
                $cat_mappings_data = $this->CategoriesMappings->find('first',array('conditions' => array('source_id' => $storeId, 'user_id' => $userid, 'a_cat_id' => $primaryACategory)));
                $primaryCategory = $cat_mappings_data['CategoriesMappings']['e_cat_id'];
                $item->PrimaryCategory->CategoryID = $primaryCategory;
            }

            //var_dump($primaryCategory);exit;

            $size_mens_categories = array('11483','15687', '11484', '57990');
            $mens_bottom_size_categories = array('57989');
            $womens_bottom_size_categories = array('11554');
            $mens_us_shoe_size_categories = array('24087');

            //Item Variations (if available)
            if(!empty($variations_dimentions) && $withVariations)
            {
                $item->Variations = new Types\VariationsType();
                /**
                 * Before we specify the variations we need to inform eBay all the possible
                 * names and values that the listing could use over its life time.
                 */
                $variationSpecificsSet = new Types\NameValueListArrayType();
                
                foreach ($variations_dimentions as $variations_dimentions_key => $variations_dimentions_values) {
                    $nameValue = new Types\NameValueListType();
                    //var_dump($variations_dimentions_key);exit;
                    if($variations_dimentions_key == "Size" && in_array($primaryCategory, $size_mens_categories)){
                        $variations_dimentions_key = "Size (Men's)";
                    }elseif($variations_dimentions_key == "Size" && in_array($primaryCategory, $mens_bottom_size_categories)){
                        $variations_dimentions_key = "Bottoms Size (Men's)";
                    }elseif($variations_dimentions_key == "Size" && in_array($primaryCategory, $womens_bottom_size_categories)){
                        $variations_dimentions_key = "Bottoms Size (Women's)";
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
                            } elseif($var_items_value_value->Name == "Size" && in_array($primaryCategory, $womens_bottom_size_categories)){
                                $var_items_value_value->Name = "Bottoms Size (Women's)";
                            } elseif($var_items_value_value->Name == "Size" && in_array($primaryCategory, $mens_us_shoe_size_categories)){
                                $var_items_value_value->Name = "US Shoe Size (Men's)";
                            }
                            //var_dump($var_items_value_value->Name);
                            $nameValue->Name = $var_items_value_value->Name;
                            $nameValue->Value = [$var_items_value_value->Value];
                            $variationSpecifics->NameValueList[] = $nameValue;
                        }

                        if($storeId == "2")
                        {
                            $productDetails = new Types\VariationProductListingDetailsType();
                            $productDetails->EAN = 'NA';
                            $variation->VariationProductListingDetails = $productDetails;
                        } else {
                            $productDetails = new Types\VariationProductListingDetailsType();
                            $productDetails->UPC = 'NA';
                            $variation->VariationProductListingDetails = $productDetails;                            
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

                    if(in_array($primaryCategory, $size_mens_categories) || in_array($primaryCategory, $mens_bottom_size_categories) || in_array($primaryCategory, $womens_bottom_size_categories) || in_array($primaryCategory, $mens_us_shoe_size_categories)){
                        $specific = new Types\NameValueListType();
                        $specific->Name = 'Size Type';
                        $specific->Value[] = 'Regular';
                        $item->ItemSpecifics->NameValueList[] = $specific;
                    }

                }

                /*if(count($img_name) > 0){

                    $item->PictureDetails = new Types\PictureDetailsType();

                    $item->PictureDetails->GalleryType = Enums\GalleryTypeCodeType::C_GALLERY;

                    $item->PictureDetails->PictureURL = $img_name;

                }*/

                //$this->pre($item);
                //exit;
                //Item Variations
            }
            else
            {
                $item->SKU = $_POST['sku'];

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

                        if($item_key == "UPC" && !empty($itemSpecificationsValsArr[$iscKey]) && $storeId == "1"){
                            $item_upc_value = $itemSpecificationsValsArr[$iscKey];
                        }

                        $specific->Name = $item_key;

                        $specific->Value[] = $itemSpecificationsValsArr[$iscKey];

                        $item->ItemSpecifics->NameValueList[] = $specific;

                    }

                    if(!empty($variations_items)) // [[CUSTOM]] // added variation specification for single product
                    {
                        foreach ($variations_items as $variations_items_key => $variations_items_value)
                        {

                            if(!empty($variations_items_value->sku))
                            {
                                $org_sku = substr($variations_items_value->sku, 3);
                                $this_sku = $variations_items_value->sku;
                                
                                if($_POST['sku'] == $this_sku)
                                {
                                    foreach ($variations_items_value->attrs as $var_items_value_key => $var_items_value_value) {

                                        $specific = new Types\NameValueListType();
                                        //$specific->Name = 'Size Type';
                                        //$specific->Value[] = 'Regular';
                                
                                        if($var_items_value_value->Name == "Size" && in_array($primaryCategory, $size_mens_categories)){
                                            $specific->Name = "Size (Men's)";
                                        } elseif($var_items_value_value->Name == "Size" && in_array($primaryCategory, $mens_bottom_size_categories)){
                                            $specific->Name = "Bottoms Size (Men's)";
                                        } elseif($var_items_value_value->Name == "Size" && in_array($primaryCategory, $womens_bottom_size_categories)){
                                            $specific->Name = "Bottoms Size (Women's)";
                                        } elseif($var_items_value_value->Name == "Size" && in_array($primaryCategory, $mens_us_shoe_size_categories)){
                                            $specific->Name = "US Shoe Size (Men's)";
                                        }
                                        $specific->Value[] = $var_items_value_value->Value;
                                        $item->ItemSpecifics->NameValueList[] = $specific;
                                    }
                                }

                            }

                        }

                    }

                    if(in_array($primaryCategory, $size_mens_categories) || in_array($primaryCategory, $mens_bottom_size_categories) || in_array($primaryCategory, $womens_bottom_size_categories) || in_array($primaryCategory, $mens_us_shoe_size_categories)){
                        $specific = new Types\NameValueListType();
                        $specific->Name = 'Size Type';
                        $specific->Value[] = 'Regular';
                        $item->ItemSpecifics->NameValueList[] = $specific;
                    }

                }

                // item images
                if(count($img_name) > 0){

                    
                    $item->PictureDetails = new Types\PictureDetailsType();

                    $item->PictureDetails->GalleryType = Enums\GalleryTypeCodeType::C_GALLERY;

                    foreach ($img_name as $singleimg_key => $singleimg_value) {
                        $item->PictureDetails->PictureURL[] = $singleimg_value;   
                    }

                }

                //$this->pre($item);exit;
            }

            /**

             * Provide enough information so that the item is listed.

             * It is beyond the scope of this example to go into any detail.

             */

            //$item->ListingType = Enums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;

            $item->ListingType = $listingType;

            $item->Quantity = $def_qty;

            $item->ListingDuration = Enums\ListingDurationCodeType::C_GTC;

            $item->StartPrice = new Types\AmountType(['value' => (float)$startPrice]);

            //var_dump($item);exit;

            if($storeId == "2"){
                $item->Country = 'GB';
                $item->Location = 'London';
                $item->Currency = 'GBP';
                //$item->EAN = "4009803041186";
                $productDetails = new Types\ProductListingDetailsType();
                $productDetails->EAN = 'NA';
                $item->ProductListingDetails = $productDetails;
            } else {
                $item->Country = 'US';
                $item->Location = 'Beverly Hills';
                $item->Currency = 'USD';

                $productDetails = new Types\ProductListingDetailsType();
                if(!empty($item_upc_value)) { $productDetails->UPC = $item_upc_value; } else { $productDetails->UPC = 'NA'; }
                $item->ProductListingDetails = $productDetails;
            }

            $item->ConditionID = (int)$itemCondition;

            $item->PaymentMethods[] = 'PayPal';

            $item->PayPalEmailAddress = 'projectdesk-facilitator@seawindsolution.com';

            $item->DispatchTimeMax = 1;

            $item->ShipToLocations[] = 'None';

            $item->ReturnPolicy = new Types\ReturnPolicyType();

            //$item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsNotAccepted';
            $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';

            //$this->pre($item);exit;

            /**

             * Finish the request object.

             */

            $request->Item = $item;

            //$this->pre($service);exit;

            /**

             * Send the request.

             */

            $response = $service->addFixedPriceItem($request);
            /**

             * Output the result of calling the service operation.

             */

            if (isset($response->Errors)) {

                //$this->pre($response->Errors);exit;



                foreach ($response->Errors as $error) {



                    if($error->SeverityCode === 'Warning'){



                        //echo '<div class="alert alert-warning">';

                        $_SESSION['warning_msg'] = sprintf(

                            "%s: %s\n%s\n\n",

                            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',

                            $error->ShortMessage,

                            $error->LongMessage

                        );

                        //echo '</div>';



                    } else {



                        //echo '<div class="alert alert-danger">';

                        $_SESSION['error_msg'] = sprintf(

                            "%s: %s\n%s\n\n",

                            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',

                            $error->ShortMessage,

                            $error->LongMessage

                        );

                        //echo '<br><a href="index.php" class="alert-link">Try again</a>';

                        //echo '</div>';



                    }

                }

            }



            if ($response->Ack !== 'Failure') {

                //echo '<div class="alert alert-success">';

                if($ebay_live) {
                    
                    if($storeId == "2")
                    {
                        $_SESSION['success_msg'] = sprintf(

                            "The item was listed to the eBay with the Item number %s\n",

                            "<a target=\"_blank\" href=\"http://www.ebay.co.uk/itm/".$response->ItemID."\">".$response->ItemID."</a>"

                        );
                    }
                    else
                    {
                        $_SESSION['success_msg'] = sprintf(

                            "The item was listed to the eBay with the Item number %s\n",

                            "<a target=\"_blank\" href=\"http://www.ebay.com/itm/".$response->ItemID."\">".$response->ItemID."</a>"

                        );
                    }

                } else {
                    $_SESSION['success_msg'] = sprintf(

                        "The item was listed to the eBay Sandbox with the Item number %s\n",

                        "<a target=\"_blank\" href=\"http://cgi.sandbox.ebay.com/".$response->ItemID."\">".$response->ItemID."</a>"

                    );
                }



                //var_dump($this);exit;



                $this->Product->id = $this->Product->field('id', array('asin_no' => $asin_no));

                if ($this->Product->id) {

                    $this->Product->saveField('status', 1);

                    $this->Product->saveField('ebay_id', $response->ItemID);
                    $this->Product->saveField('ebay_price', $startPrice);
                    $this->Product->saveField('ebay_cat_id', $item->PrimaryCategory->CategoryID);
                    if(!empty($variations_dimentions) && $withVariations)
                    {
                        $this->Product->saveField('with_variations', 1);
                    }
                    if($ebay_live)
                    {
                        $this->Product->saveField('ebay_live', 1);
                    }

                }

                //echo '<br><a href="index.php" class="alert-link">Add more</a>';

                //echo '</div>';

            }



            //var_dump($return_url);



            return $this->redirect($return_url);

            //exit;

            //exit;







        }

    }

    function listing_revise($productId)

    {
        $this->layout = 'default';

        $this->checklogin();

        $userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

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
        $product_ebay_live = $product_data['Product']['ebay_live'];
        $product_ebay_cat_id = $product_data['Product']['ebay_cat_id'];
        $product_ebay_with_variations = $product_data['Product']['with_variations'];

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
        //$lookup->setResponseGroup(array('Offers,VariationMatrix,VariationOffers')); // More detailed information
        $lookup->setResponseGroup(array('Offers')); // More detailed information
        $lookup->setItemId($awnid);
        //$lookup->setItemId('B00UG7WDQ6');
        $lookup->setCondition('All');
        $response = $apaiIo->runOperation($lookup);
        $response = json_decode (json_encode (simplexml_load_string ($response)), true);

        //$this->pre($response);exit;

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

        if(!empty($product_ebay_cat_id)){
            $primaryCategory = $product_ebay_cat_id;
        }else{
            $primaryCategory = $categories_mappings_data['CategoriesMappings']['e_cat_id'];
        }
        
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
            if(isset($response['Items']['Item']['Variations']))
            {
                $TotalVariations = (int)$response['Items']['Item']['Variations']['TotalVariations'];
                if($TotalVariations > 0){
                    $ProductVariations = $response['Items']['Item']['Variations'];
                }
            }
            else
            {
                $ParentASIN = $response['Items']['Item']['ParentASIN'];
                $lookup = new Lookup();
                $lookup->setIdType('ASIN');
                $lookup->setResponseGroup(array('Variations', 'VariationOffers', 'VariationMatrix')); // More detailed information
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
                    //$this->pre($pvItemValue);

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
                   
                   $variation_list_amount = (isset($pvItemValue['ItemAttributes']['ListPrice']['Amount']) ? $pvItemValue['ItemAttributes']['ListPrice']['Amount'] : 0 );
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

                        if($product_ebay_with_variations) $product_variations_need_revise = true;
                        //print("The item was successfully revised on the eBay Sandbox.");
                    }    
               }
            }

        }

        //$price = (float) 15;

        //var_dump($product_ebay_price);
        //var_dump($price);exit;
        
        if($product_ebay_price < $price)
        {
            if($product_ebay_live)
            {
                $service = new Services\TradingService([
                    'credentials' => [
                        'devId' => EBAY_LIVE_DEVID,
                        'appId' => EBAY_LIVE_APPID,
                        'certId' => EBAY_LIVE_CERTID,
                    ],
                    'sandbox'     => false,
                    'siteId'      => $siteId
                ]);

                $ebay_auth_token = EBAY_LIVE_AUTHTOKEN;
            }
            else
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

                $ebay_auth_token = EBAY_SANDBOX_AUTHTOKEN;
            }

            /**
             * Create the request object.
             */
            $request = new Types\ReviseFixedPriceItemRequestType();

            /**
             * An user token is required when using the Trading service.
             */
            $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
            $request->RequesterCredentials->eBayAuthToken = $ebay_auth_token;

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
                $womens_bottom_size_categories = array('11554');
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



    //function for display listing request page

    function listing_settings($user_encryptid) {



        $this->layout = 'default';

        $this->checklogin();



        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);

        $this->check_login_user($userid);



        //$this->pre($this->params);



        if (!empty($this->data)) {



//            $this->pre($this->data);

//            exit;



            //Check user record inserted or not in store setting

            $check_listing_settings = $this->ListingSettings->find('first', array('conditions' => array('user_id'=>$userid)));



            $this->request->data['ListingSettings']['allow_cross_store'] = (isset($this->data['ListingSettings']['allow_cross_store']) && $this->data['ListingSettings']['allow_cross_store']==1)?$this->data['ListingSettings']['allow_cross_store']:0;

            $this->request->data['ListingSettings']['listing_watcher'] = (isset($this->data['ListingSettings']['listing_watcher']) && $this->data['ListingSettings']['listing_watcher']==1)?$this->data['ListingSettings']['listing_watcher']:0;

            $this->request->data['ListingSettings']['user_id'] = $userid;

            $this->request->data['ListingSettings']['modified_date'] = date('Y-m-d H:i:s');



            if(!empty($check_listing_settings))

                $this->request->data['ListingSettings']['id'] = $check_listing_settings['ListingSettings']['id'];

            else

                $this->request->data['ListingSettings']['created_date'] = date('Y-m-d H:i:s');



//            $this->pre($this->data);

//            exit;



            $this->ListingSettings->save($this->data['ListingSettings']);

            $this->redirect(DEFAULT_URL . 'listings/listing_settings/'.$user_encryptid.'/msg:'.SUCUPDATE);

            exit;

         }



        $this->data = $this->ListingSettings->find('first', array('conditions' => array('user_id'=>$userid)));

    }



    //function for register_validate

    function register_validate($userdata,$pageaction) {

        $errorarray = array();



        if($pageaction=='login'){$pass = 'login_';}else{$pass ='';}



        if (isset($userdata['User']['email']) && (trim($userdata['User']['email']) == '' || trim($userdata['User']['email']) == 'Email')) {

            $errorarray[$pass.'enter_email'] = ENTER_EMAIL;

        }

        else

        {

            // For check valid email or not

            if($this->IsEmail($userdata['User']['email'])==0)

                $errorarray[$pass.'valid_email'] = ENTER_VALIDEMAIL;



            if($pageaction=='registration')

                $check_email = $this->User->find('all', array('conditions' => array('email like'=>$userdata['User']['email'],'user_type like'=>'user')));





            if(isset($check_email) && count($check_email)>0)

            {

                $errorarray[$pass.'email_exists'] = DUPLICATE_EMAIL;

            }

        }



        if (isset($userdata['User']['newpwd']) && (trim($userdata['User']['newpwd']) == '' || trim($userdata['User']['newpwd']=='Password'))) {

            $errorarray[$pass.'newpass'] = ENTER_PASSWORD;

        }

        else

        {

            $check_len_pass = strlen(trim($userdata['User']['newpwd']));



            if($check_len_pass<5)

                $errorarray[$pass.'newpass_minlen'] = PASSWORD_LENGTH;

        }

        if($pageaction=='registration'){



            if (isset($userdata['User']['username']) && (trim($userdata['User']['username']) == '' || trim($userdata['User']['username']) == 'Username'))

                $errorarray['enter_uname'] = ENTER_USERNAME;

            else

            {

                if($this->check_hasnumber($userdata['User']['username'])==1)

                {

                    $errorarray['uname_not_numeric'] = NAME_HAS_NUM;

                }

            }

            if (isset($userdata['User']['name']) && (trim($userdata['User']['name']) == '' || trim($userdata['User']['name']) == 'Name'))

                $errorarray['enter_name'] = ENTER_NAME;

            else

            {

                if($this->check_hasnumber($userdata['User']['name'])==1)

                {

                    $errorarray['name_not_numeric'] = NAME_HAS_NUM;

                }

            }



            if (isset($userdata['User']['confirmpwd']) && (trim($userdata['User']['confirmpwd']) == '' || trim($userdata['User']['confirmpwd']) == 'Password')) {

                $errorarray['confpass'] = ENTER_CONFPASS;

            }

            else

            {

                $check_len_confpass = strlen(trim($userdata['User']['confirmpwd']));



                if($check_len_confpass<5)

                    $errorarray['confpass_minlen'] = CONF_PASSWORD_LENGTH;

            }

            if (trim($userdata['User']['newpwd']) != '' && trim($userdata['User']['confirmpwd']) != '' && trim($userdata['User']['newpwd']) != trim($userdata['User']['confirmpwd']) && strlen(trim($userdata['User']['newpwd']))>5 && strlen(trim($userdata['User']['confirmpwd']))>5) {

                $errorarray['conflict'] = NEWCONFPASS;

            }

            if (isset($userdata['User']['mobile']) && (trim($userdata['User']['mobile']) == '' || trim($userdata['User']['mobile']) == 'Mobile')) {

                $errorarray['enter_mobile'] = ENTER_PHONE;

            }

            else

            {

    //            $this->check_int($userdata['User']['mobile']);

//                 if($this->check_int($userdata['User']['mobile'])==1)

//                     $errorarray['numeric_mobile'] = ENTER_NUMERIC_MOBILE;

//                 else if(strlen($userdata['User']['mobile'])!=10)

//                     $errorarray['mobile_length'] = MOBILE_LENGTH;

            }

        }





//        $this->pre($check_email_pass);

//        $this->pre($userdata);

//        $this->pre($errorarray);

//        exit;



        return $errorarray;

    }



    //Function for user validate

    function user_validate($userdata,$pageaction) {



        //$this->pre($userdata);

        //exit;



        $errorarray = array();

        if (isset($userdata['User']['name']) && trim($userdata['User']['name']) == '')

            $errorarray['enter_name'] = ENTER_NAME;

        else

        {

            if($this->check_hasnumber($userdata['User']['name'])==1)

            {

                $errorarray['name_not_numeric'] = NAME_HAS_NUM;

            }

        }



        if (isset($userdata['User']['email']) && trim($userdata['User']['email']) == '') {

            $errorarray['enter_email'] = ENTER_EMAIL;

        }

        else

        {

            // For check valid email or not

            if($this->IsEmail($userdata['User']['email'])==0)

                $errorarray['valid_email'] = ENTER_VALIDEMAIL;



            if($pageaction=='add')

                $check_email = $this->User->find('all', array('conditions' => array('email like'=>$userdata['User']['email'])));

            else

                $check_email = $this->User->find('all', array('conditions' => array('NOT'=>array('id' => $userdata['User']['id']),'email like'=>$userdata['User']['email'])));



            if(isset($check_email) && count($check_email)>0)

            {

                $errorarray['email_exists'] = DUPLICATE_EMAIL;

            }

        }



//        $this->pre($errorarray);

//        exit;



        return $errorarray;

    }



    function set_blacklist_data($blacklist_data)

    {

        $set_array = array();



//        $toal_brand_list =  mysql_real_escape_string(trim($this->data['Blacklist']['brand_list']));

//        $explode_brand = array_map('trim',explode('\r\n',$toal_brand_list));

//        $add_json_data['Blacklist']['brand_list'] = json_encode($explode_brand);

//

//        $toal_keyword_list =  mysql_real_escape_string(trim($this->data['Blacklist']['keyword_list']));

//        $explode_keyword = array_map('trim',explode('\r\n',$toal_keyword_list));

//        $add_json_data['Blacklist']['keyword_list'] = json_encode($explode_keyword);

//

//        $toal_product_list =  mysql_real_escape_string(trim($this->data['Blacklist']['product_list']));

//        $explode_product = array_map('trim',explode('\r\n',$toal_product_list));

//        $add_json_data['Blacklist']['product_list'] = json_encode($explode_product);

    }

}