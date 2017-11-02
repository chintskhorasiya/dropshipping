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

        $user_id = (int) $_SESSION[md5(SITE_TITLE) . 'USERID'];
        
        if(empty($productId))
        {
            //echo "Feature coming soon...";
            //$_SESSION['success_msg'] = "Feature coming soon...!";
            //return $this->redirect(DEFAULT_URL.'listings/listing_requests/');

            $us_products_data = $this->Product->find('all', array('conditions' => array('status IN'=> array('0','1'), 'source_id'=>'1', 'user_id' => $user_id)));

            //$this->pre($us_products_data);exit;

            if(count($us_products_data) > 0)
            {
                $uspdIds = array();
                $us_out_of_stock_items = array();

                //array_push($uspdIds, 'B0745532Y9');
                
                foreach ($us_products_data as $uspdkey => $uspdvalue)
                {    
                    array_push($uspdIds, $uspdvalue['Product']['asin_no']);
                }

                $uspdIds = array_chunk($uspdIds, 10);

                foreach ($uspdIds as $uspd_slotkey => $uspd_slot)
                {
                    $country_cod = 'com';
                    $siteId = Constants\SiteIds::US;
                    /*if(isset($product_source_id) && $product_source_id==2)
                    {
                        $country_cod = 'co.uk';
                        $siteId = Constants\SiteIds::GB;
                    }*/

                    $client = new \GuzzleHttp\Client();
                    $request = new \ApaiIO\Request\GuzzleRequest($client);

                    $conf = new GenericConfiguration();
                    $conf
                        ->setCountry($country_cod)
                        ->setAccessKey(AWS_API_KEY)
                        ->setSecretKey(AWS_API_SECRET_KEY)
                        ->setAssociateTag(AWS_ASSOCIATE_TAG)
                        ->setRequest($request);

                    $apaiIo = new ApaiIO($conf);

                    //$awnid = $product_asin_no;

                    $lookup = new Lookup();
                    $lookup->setResponseGroup(array('Offers')); // More detailed information
                    $lookup->setItemId($uspd_slot);
                    $lookup->setCondition('All');
                    $lookup->setMerchantId('All');
                    $response = $apaiIo->runOperation($lookup);
                    $response = json_decode (json_encode (simplexml_load_string ($response)), true);

                    $this->pre($response);

                    if(isset($response['Items']['Request']['Errors']['Error']['Message']))
                    {
                        $response['Items']['Request']['Errors']['Error']['Message'];
                    }
                    else
                    {
                        if(isset($response['Items']['Item'][0])){
                            $us_items = $response['Items']['Item'];
                            foreach ($us_items as $us_items_key => $us_item)
                            {
                                $us_item_totaloffers = (int) $us_item['Offers']['TotalOffers'];
                                if($us_item_totaloffers <= 0){
                                    array_push($us_out_of_stock_items, $us_item['ASIN']);
                                }
                            }
                        }
                        else
                        {
                            $us_item = $response['Items']['Item'];
                            $us_item_totaloffers = (int) $us_item['Offers']['TotalOffers'];
                            if($us_item_totaloffers <= 0){
                                array_push($us_out_of_stock_items, $us_item['ASIN']);
                            }
                        }
                    }

                    //$this->pre($response);

                    //echo "<br>";
                    //echo "________________________________________________________________";   
                    //echo "<br>";

                }

                $this->pre($us_out_of_stock_items);
            }

            $uk_products_data = $this->Product->find('all', array('conditions' => array('status IN'=> array('0','1'), 'source_id'=>'2', 'user_id' => $user_id)));

            //$this->pre($uk_products_data);exit;

            if(count($uk_products_data) > 0)
            {
                $ukpdIds = array();
                
                $uk_out_of_stock_items = array();

                foreach ($uk_products_data as $ukpdkey => $ukpdvalue)
                {    
                    array_push($ukpdIds, $ukpdvalue['Product']['asin_no']);
                }

                $ukpdIds = array_chunk($ukpdIds, 10);

                foreach ($ukpdIds as $ukpd_slotkey => $ukpd_slot)
                {
                    $country_cod = 'co.uk';
                    $siteId = Constants\SiteIds::GB;

                    $client = new \GuzzleHttp\Client();
                    $request = new \ApaiIO\Request\GuzzleRequest($client);

                    $conf = new GenericConfiguration();
                    $conf
                        ->setCountry($country_cod)
                        ->setAccessKey(AWS_API_KEY)
                        ->setSecretKey(AWS_API_SECRET_KEY)
                        ->setAssociateTag(AWS_ASSOCIATE_TAG)
                        ->setRequest($request);

                    $apaiIo = new ApaiIO($conf);

                    //$awnid = $product_asin_no;

                    $lookup = new Lookup();
                    $lookup->setResponseGroup(array('Offers')); // More detailed information
                    $lookup->setItemId($ukpd_slot);
                    $lookup->setCondition('All');
                    $response = $apaiIo->runOperation($lookup);
                    $response = json_decode (json_encode (simplexml_load_string ($response)), true);

                    $this->pre($response);

                    if(isset($response['Items']['Request']['Errors']['Error']['Message']))
                    {
                        $response['Items']['Request']['Errors']['Error']['Message'];
                    }
                    else
                    {
                        if(isset($response['Items']['Item'][0])){
                            $uk_items = $response['Items']['Item'];
                            foreach ($uk_items as $uk_items_key => $uk_item)
                            {
                                $uk_item_totaloffers = (int) $uk_item['Offers']['TotalOffers'];
                                if($uk_item_totaloffers <= 0){
                                    array_push($uk_out_of_stock_items, $uk_item['ASIN']);
                                }
                            }
                        }
                        else
                        {
                            $uk_item = $response['Items']['Item'];
                            $uk_item_totaloffers = (int) $uk_item['Offers']['TotalOffers'];
                            if($uk_item_totaloffers <= 0){
                                array_push($uk_out_of_stock_items, $uk_item['ASIN']);
                            }
                        }
                    }

                    //echo "<br>";
                    //echo "________________________________________________________________";   
                    //echo "<br>";
                    
                }

                $this->pre($uk_out_of_stock_items);
            }

            exit;

            //echo "Feature coming soon...";
            $_SESSION['success_msg'] = "Feature coming soon...!";
            return $this->redirect(DEFAULT_URL.'listings/listing_requests/');
        }
        else
        {
            $product_data = $this->Product->find('first', array('conditions' => array('id'=>$productId)));

            //$this->pre($product_data);exit;

            $product_source_id = $product_data['Product']['source_id'];
            $product_asin_no = $product_data['Product']['asin_no'];
            $product_ebay_price = (float) $product_data['Product']['ebay_price'];
            $product_ebay_price_with_hundred = (float) $product_data['Product']['ebay_price']*100;
            $product_ebay_id = $product_data['Product']['ebay_id'];
            $product_ebay_sku = $product_data['Product']['sku'];
            $product_a_cat_id = $product_data['Product']['a_cat_id'];
            $product_ebay_cat_id = $product_data['Product']['ebay_cat_id'];
            $product_ebay_qty = (int) $product_data['Product']['qty'];
            $product_ebay_live = (int) $product_data['Product']['ebay_live'];
            $product_ebay_with_variations = (int) $product_data['Product']['with_variations'];
            $product_variations_dimentions = $product_data['Product']['variations_dimentions'];

            if(!empty($product_ebay_id))
            {
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

                //var_dump($totalOffers);exit;
            
                if($totalOffers > 0)
                {

                    $_SESSION['success_msg'] = "Item is still available !";
                    return $this->redirect(DEFAULT_URL.'listings/listing_requests/');
                }
                else
                {
                    if($product_ebay_qty === 0)
                    {
                        $_SESSION['success_msg'] = "Item is already out of stock !";
                        return $this->redirect(DEFAULT_URL.'listings/listing_requests/');
                    }

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

                    // code for enabling out of stock feature

                    /*$requestS = new Types\SetUserPreferencesRequestType();
                    $requestS->RequesterCredentials = new Types\CustomSecurityHeaderType();
                    $requestS->RequesterCredentials->eBayAuthToken = EBAY_SANDBOX_AUTHTOKEN;
                    $requestS->OutOfStockControlPreference = true;
                    $responseS = $service->SetUserPreferences($requestS);*/
                    
                    // code to get out of stock feature value (enabled or not)
                    /*$requestG = new Types\GetUserPreferencesRequestType();
                    $requestG->RequesterCredentials = new Types\CustomSecurityHeaderType();
                    $requestG->RequesterCredentials->eBayAuthToken = EBAY_SANDBOX_AUTHTOKEN;
                    $requestG->ShowOutOfStockControlPreference = true;
                    $response = $service->GetUserPreferences($requestG);*/

                    /**
                     * Create the request object.
                     */
                    $request = new Types\ReviseInventoryStatusRequestType();

                    $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
                    $request->RequesterCredentials->eBayAuthToken = $ebay_auth_token;
                    
                    $inventory = new Types\InventoryStatusType();
                    $inventory->ItemID = $product_ebay_id;
                    //$inventory->SKU = $product_ebay_sku;
                    $inventory->Quantity = 0;
                    //$inventory->StartPrice = new Types\AmountType(array('value' => (float)4.95));
                    $request->InventoryStatus[] = $inventory;
                    $response = $service->ReviseInventoryStatus($request);
                    //$response = $service->reviseFixedPriceItem($request);
                    //$this->pre($response);exit;

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
                        }
                    }
                    if ($response->Ack !== 'Failure') {

                        $_SESSION['success_msg'] = "Item is out of stock now ! And The item was successfully revised on the eBay Sandbox.";

                        $this->Product->id = $this->Product->field('id', array('id' => $productId));

                        if ($this->Product->id) {

                            $this->Product->saveField('qty', 0);
                        }
                    
                    }

                    return $this->redirect(DEFAULT_URL.'listings/listing_requests/');
                }
            }
            else
            {
                return $this->redirect(DEFAULT_URL.'listings/listing_requests/');
            }
            
        }

    }

    function reviseitems(){

        // first entry for cron

        $this->loadmodel('ReviseItems');
        $crondata['ReviseItems']['start_date'] = date('Y-m-d H:i:s');
        $this->ReviseItems->set($crondata);
        $revisedResult = $this->ReviseItems->save($crondata);
        $revisedID = $revisedResult['ReviseItems']['id'];
        
        // first entry for cron

        $us_products_data = $this->Product->find('all', array('conditions' => array('status IN'=> array('0','1'), 'source_id'=>'1', 'ebay_id <>' => 'NULL')));

        //$this->pre($us_products_data);exit;

        if(count($us_products_data) > 0)
        {
            $uspdIds = array();
            $us_out_of_stock_items = array();
            $us_priceupdated_items = array();

            //array_push($uspdIds, 'B0745532Y9');
            
            foreach ($us_products_data as $uspdkey => $uspdvalue)
            {    
                array_push($uspdIds, $uspdvalue['Product']['asin_no']);
            }

            $uspdIds = array_chunk($uspdIds, 10);

            foreach ($uspdIds as $uspd_slotkey => $uspd_slot)
            {
                $country_cod = 'com';
                $siteId = Constants\SiteIds::US;
                /*if(isset($product_source_id) && $product_source_id==2)
                {
                    $country_cod = 'co.uk';
                    $siteId = Constants\SiteIds::GB;
                }*/

                $client = new \GuzzleHttp\Client();
                $request = new \ApaiIO\Request\GuzzleRequest($client);

                $conf = new GenericConfiguration();
                $conf
                    ->setCountry($country_cod)
                    ->setAccessKey(AWS_API_KEY)
                    ->setSecretKey(AWS_API_SECRET_KEY)
                    ->setAssociateTag(AWS_ASSOCIATE_TAG)
                    ->setRequest($request);

                $apaiIo = new ApaiIO($conf);

                //$awnid = $product_asin_no;

                $lookup = new Lookup();
                $lookup->setResponseGroup(array('Offers')); // More detailed information
                $lookup->setItemId($uspd_slot);
                $lookup->setCondition('All');
                $lookup->setMerchantId('All');
                $response = $apaiIo->runOperation($lookup);
                $response = json_decode (json_encode (simplexml_load_string ($response)), true);

                //$this->pre($response);

                if(isset($response['Items']['Request']['Errors']['Error']['Message']))
                {
                    $response['Items']['Request']['Errors']['Error']['Message'];
                }
                else
                {
                    if(isset($response['Items']['Item'][0])){
                        $us_items = $response['Items']['Item'];
                        foreach ($us_items as $us_items_key => $us_item)
                        {
                            $us_item_totaloffers = (int) $us_item['Offers']['TotalOffers'];
                            $curr_ebay_price_data = $this->Product->find('first', array('fields'=>array('ebay_price', 'qty', 'user_id', 'source_id'),'conditions' => array('status IN'=> array('0','1'), 'asin_no'=>$us_item['ASIN'])));

                            $curr_ebay_qty = $curr_ebay_price_data['Product']['qty'];

                            $this->loadmodel('SourceSettings');

                            $curr_sourcesettings_data = $this->SourceSettings->find('first', array('fields'=>array('marginpercent',),'conditions' => array('source_id'=> $curr_ebay_price_data['Product']['source_id'], 'user_id'=>$curr_ebay_price_data['Product']['user_id'])));


                            if($us_item_totaloffers <= 0 && $curr_ebay_qty > 0){
                                array_push($us_out_of_stock_items, $us_item['ASIN']);
                            } else {
                                if(isset($us_item['Offers']['Offer'][0])){
                                    $us_offers_arr = $us_item['Offers']['Offer'];
                                    foreach ($us_offers_arr as $us_offers_arr_key => $us_offers_arr_value) {
                                        //$this->pre($us_offers_arr_value);
                                        $curr_offer_price = (float) ($us_offers_arr_value['OfferListing']['Price']['Amount']/100);
                                        //$this->pre($curr_offer_price);
                                        
                                        //$this->pre($curr_ebay_price_data);
                                        //$this->pre($curr_sourcesettings_data);
                                        $curr_ebay_price = (float) $curr_ebay_price_data['Product']['ebay_price'];
                                        $curr_marginpercent = (float) $curr_sourcesettings_data['SourceSettings']['marginpercent'];
                                        if(!empty($curr_marginpercent)){
                                            $curr_offer_price_marginadded = (float) round((($curr_offer_price*$curr_marginpercent)/100) + $curr_offer_price, 2);
                                        } else {
                                            $curr_offer_price_marginadded = $curr_offer_price;
                                        }
                                        //echo $us_item['ASIN']." => ".$curr_offer_price." => ".$curr_offer_price_marginadded." => ".$curr_ebay_price."<br>";

                                        if($curr_offer_price > $curr_ebay_price){
                                            if((!empty($us_priceupdated_items[$us_item['ASIN']]) && $us_priceupdated_items[$us_item['ASIN']] < $curr_offer_price_marginadded) || empty($us_priceupdated_items[$us_item['ASIN']])){
                                                //array_push($us_priceupdated_items, $us_item['ASIN']);
                                                $us_priceupdated_items[$us_item['ASIN']] = $curr_offer_price_marginadded;
                                            }
                                        }
                                    }
                                    
                                } else {
                                    $us_offers_arr_value = $us_item['Offers']['Offer'];
                                    //$this->pre($us_offers_arr_value);
                                    $curr_offer_price = (float) ($us_offers_arr_value['OfferListing']['Price']['Amount']/100);
                                    //$this->pre($curr_offer_price);

                                    $curr_ebay_price_data = $this->Product->find('first', array('fields'=>array('ebay_price', 'source_id', 'user_id'),'conditions' => array('status IN'=> array('0','1'), 'asin_no'=>$us_item['ASIN'])));
                                    $this->loadmodel('SourceSettings');

                                    $curr_sourcesettings_data = $this->SourceSettings->find('first', array('fields'=>array('marginpercent',),'conditions' => array('source_id'=> $curr_ebay_price_data['Product']['source_id'], 'user_id'=>$curr_ebay_price_data['Product']['user_id'])));

                                    //$this->pre($curr_ebay_price_data);
                                    //$this->pre($curr_sourcesettings_data);
                                    $curr_ebay_price = (float) $curr_ebay_price_data['Product']['ebay_price'];
                                    $curr_marginpercent = (float) $curr_sourcesettings_data['SourceSettings']['marginpercent'];
                                    if(!empty($curr_marginpercent)){
                                        $curr_offer_price_marginadded = (float) round((($curr_offer_price*$curr_marginpercent)/100) + $curr_offer_price, 2);
                                    } else {
                                        $curr_offer_price_marginadded = $curr_offer_price;
                                    }
                                    //echo $us_item['ASIN']." => ".$curr_offer_price." => ".$curr_offer_price_marginadded." => ".$curr_ebay_price."<br>";

                                    if($curr_offer_price > $curr_ebay_price){
                                        if((!empty($us_priceupdated_items[$us_item['ASIN']]) && $us_priceupdated_items[$us_item['ASIN']] < $curr_offer_price_marginadded) || empty($us_priceupdated_items[$us_item['ASIN']])){
                                            //array_push($us_priceupdated_items, $us_item['ASIN']);
                                            $us_priceupdated_items[$us_item['ASIN']] = $curr_offer_price_marginadded;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $us_item = $response['Items']['Item'];
                        $us_item_totaloffers = (int) $us_item['Offers']['TotalOffers'];

                        $curr_ebay_price_data = $this->Product->find('first', array('fields'=>array('ebay_price', 'qty', 'source_id', 'user_id'),'conditions' => array('status IN'=> array('0','1'), 'asin_no'=>$us_item['ASIN'])));

                        $curr_ebay_qty = $curr_ebay_price_data['Product']['qty'];
                        
                        $this->loadmodel('SourceSettings');

                        $curr_sourcesettings_data = $this->SourceSettings->find('first', array('fields'=>array('marginpercent',),'conditions' => array('source_id'=> $curr_ebay_price_data['Product']['source_id'], 'user_id'=>$curr_ebay_price_data['Product']['user_id'])));

                        if($us_item_totaloffers <= 0 && $curr_ebay_qty > 0){
                            array_push($us_out_of_stock_items, $us_item['ASIN']);
                        } else {
                            if(isset($us_item['Offers']['Offer'][0])){
                                $us_offers_arr = $us_item['Offers']['Offer'];
                                foreach ($us_offers_arr as $us_offers_arr_key => $us_offers_arr_value) {
                                    //$this->pre($us_offers_arr_value);
                                    $curr_offer_price = (float) ($us_offers_arr_value['OfferListing']['Price']['Amount']/100);
                                    //$this->pre($curr_offer_price);
                                    //$this->pre($curr_ebay_price_data);
                                    //$this->pre($curr_sourcesettings_data);
                                    $curr_ebay_price = (float) $curr_ebay_price_data['Product']['ebay_price'];
                                    $curr_marginpercent = (float) $curr_sourcesettings_data['SourceSettings']['marginpercent'];
                                    if(!empty($curr_marginpercent)){
                                        $curr_offer_price_marginadded = (float) round((($curr_offer_price*$curr_marginpercent)/100) + $curr_offer_price, 2);
                                    } else {
                                        $curr_offer_price_marginadded = $curr_offer_price;
                                    }
                                    //echo $curr_offer_price." => ".$curr_offer_price_marginadded." => ".$curr_ebay_price."<br>";

                                    if($curr_offer_price > $curr_ebay_price){
                                        if((!empty($us_priceupdated_items[$us_item['ASIN']]) && $us_priceupdated_items[$us_item['ASIN']] < $curr_offer_price_marginadded) || empty($us_priceupdated_items[$us_item['ASIN']])){
                                            //array_push($us_priceupdated_items, $us_item['ASIN']);
                                            $us_priceupdated_items[$us_item['ASIN']] = $curr_offer_price_marginadded;
                                        }
                                    }
                                }
                            } else {
                                $us_offers_arr_value = $us_item['Offers']['Offer'];
                                //$this->pre($us_offers_arr_value);
                                $curr_offer_price = (float) ($us_offers_arr_value['OfferListing']['Price']['Amount']/100);
                                //$this->pre($curr_offer_price);

                                $curr_ebay_price_data = $this->Product->find('first', array('fields'=>array('ebay_price', 'source_id', 'user_id'),'conditions' => array('status IN'=> array('0','1'), 'asin_no'=>$us_item['ASIN'])));
                                    $this->loadmodel('SourceSettings');

                                $curr_sourcesettings_data = $this->SourceSettings->find('first', array('fields'=>array('marginpercent',),'conditions' => array('source_id'=> $curr_ebay_price_data['Product']['source_id'], 'user_id'=>$curr_ebay_price_data['Product']['user_id'])));

                                //$this->pre($curr_ebay_price_data);
                                //$this->pre($curr_sourcesettings_data);
                                $curr_ebay_price = (float) $curr_ebay_price_data['Product']['ebay_price'];
                                $curr_marginpercent = (float) $curr_sourcesettings_data['SourceSettings']['marginpercent'];
                                if(!empty($curr_marginpercent)){
                                    $curr_offer_price_marginadded = (float) round((($curr_offer_price*$curr_marginpercent)/100) + $curr_offer_price, 2);
                                } else {
                                    $curr_offer_price_marginadded = $curr_offer_price;
                                }
                                //echo $curr_offer_price." => ".$curr_offer_price_marginadded." => ".$curr_ebay_price."<br>";

                                if($curr_offer_price > $curr_ebay_price){
                                    if((!empty($us_priceupdated_items[$us_item['ASIN']]) && $us_priceupdated_items[$us_item['ASIN']] < $curr_offer_price_marginadded) || empty($us_priceupdated_items[$us_item['ASIN']])){
                                        //array_push($us_priceupdated_items, $us_item['ASIN']);
                                        $us_priceupdated_items[$us_item['ASIN']] = $curr_offer_price_marginadded;
                                    }
                                }
                            }
                        }
                    }
                }

                //$this->pre($response);

                //echo "<br>";
                //echo "________________________________________________________________";   
                //echo "<br>";

            }

            echo "Out of stock items (US)";
            echo "<br>";
            $this->pre($us_out_of_stock_items);
            echo "________________________________________________________________";   
            echo "<br>";
            echo "Price updated items (US)";
            echo "<br>";
            $this->pre($us_priceupdated_items);
            echo "________________________________________________________________";   
            echo "<br>";
            //exit;
        }

        $uk_products_data = $this->Product->find('all', array('conditions' => array('status IN'=> array('0','1'), 'source_id'=>'2', 'ebay_id <>' => 'NULL')));

        //$this->pre($uk_products_data);exit;

        if(count($uk_products_data) > 0)
        {
            $ukpdIds = array();
            
            $uk_out_of_stock_items = array();
            $uk_priceupdated_items = array();

            foreach ($uk_products_data as $ukpdkey => $ukpdvalue)
            {    
                array_push($ukpdIds, $ukpdvalue['Product']['asin_no']);
            }

            $ukpdIds = array_chunk($ukpdIds, 10);

            foreach ($ukpdIds as $ukpd_slotkey => $ukpd_slot)
            {
                $country_cod = 'co.uk';
                $siteId = Constants\SiteIds::GB;

                $client = new \GuzzleHttp\Client();
                $request = new \ApaiIO\Request\GuzzleRequest($client);

                $conf = new GenericConfiguration();
                $conf
                    ->setCountry($country_cod)
                    ->setAccessKey(AWS_API_KEY)
                    ->setSecretKey(AWS_API_SECRET_KEY)
                    ->setAssociateTag(AWS_ASSOCIATE_TAG)
                    ->setRequest($request);

                $apaiIo = new ApaiIO($conf);

                //$awnid = $product_asin_no;

                $lookup = new Lookup();
                $lookup->setResponseGroup(array('Offers')); // More detailed information
                $lookup->setItemId($ukpd_slot);
                $lookup->setCondition('All');
                $response = $apaiIo->runOperation($lookup);
                $response = json_decode (json_encode (simplexml_load_string ($response)), true);

                //$this->pre($response);

                if(isset($response['Items']['Request']['Errors']['Error']['Message']))
                {
                    $response['Items']['Request']['Errors']['Error']['Message'];
                }
                else
                {
                    if(isset($response['Items']['Item'][0])){
                        $uk_items = $response['Items']['Item'];
                        foreach ($uk_items as $uk_items_key => $uk_item)
                        {
                            $uk_item_totaloffers = (int) $uk_item['Offers']['TotalOffers'];

                            $curr_ebay_price_data = $this->Product->find('first', array('fields'=>array('ebay_price', 'qty', 'user_id', 'source_id'),'conditions' => array('status IN'=> array('0','1'), 'asin_no'=>$uk_item['ASIN'])));

                            $curr_ebay_qty = $curr_ebay_price_data['Product']['qty'];
                            
                            $this->loadmodel('SourceSettings');

                            $curr_sourcesettings_data = $this->SourceSettings->find('first', array('fields'=>array('marginpercent',),'conditions' => array('source_id'=> $curr_ebay_price_data['Product']['source_id'], 'user_id'=>$curr_ebay_price_data['Product']['user_id'])));


                            if($uk_item_totaloffers <= 0 && $curr_ebay_qty > 0){
                                array_push($uk_out_of_stock_items, $uk_item['ASIN']);
                            } else {
                                if(isset($uk_item['Offers']['Offer'][0])){
                                    $uk_offers_arr = $uk_item['Offers']['Offer'];
                                    foreach ($uk_offers_arr as $uk_offers_arr_key => $uk_offers_arr_value) {
                                        //$this->pre($uk_offers_arr_value);
                                        $curr_offer_price = (float) ($uk_offers_arr_value['OfferListing']['Price']['Amount']/100);
                                        //$this->pre($curr_offer_price);

                                        //$this->pre($curr_ebay_price_data);
                                        //$this->pre($curr_sourcesettings_data);
                                        $curr_ebay_price = (float) $curr_ebay_price_data['Product']['ebay_price'];
                                        $curr_marginpercent = (float) $curr_sourcesettings_data['SourceSettings']['marginpercent'];
                                        if(!empty($curr_marginpercent)){
                                            $curr_offer_price_marginadded = (float) round((($curr_offer_price*$curr_marginpercent)/100) + $curr_offer_price, 2);
                                        } else {
                                            $curr_offer_price_marginadded = $curr_offer_price;
                                        }
                                        //echo $uk_item['ASIN']." => ".$curr_offer_price." => ".$curr_offer_price_marginadded." => ".$curr_ebay_price."<br>";

                                        if($curr_offer_price > $curr_ebay_price){
                                            if((!empty($uk_priceupdated_items[$uk_item['ASIN']]) && $uk_priceupdated_items[$uk_item['ASIN']] < $curr_offer_price_marginadded) || empty($uk_priceupdated_items[$uk_item['ASIN']])){
                                                //array_push($uk_priceupdated_items, $uk_item['ASIN']);
                                                $uk_priceupdated_items[$uk_item['ASIN']] = $curr_offer_price_marginadded;
                                            }
                                        }
                                    }
                                } else {
                                    $uk_offers_arr_value = $uk_item['Offers']['Offer'];
                                    //$this->pre($uk_offers_arr_value);
                                    $curr_offer_price = (float) ($uk_offers_arr_value['OfferListing']['Price']['Amount']/100);

                                    /*$curr_ebay_price_data = $this->Product->find('first', array('fields'=>array('ebay_price', 'user_id', 'source_id'),'conditions' => array('status IN'=> array('0','1'), 'asin_no'=>$uk_item['ASIN'])));
                                    
                                    $this->loadmodel('SourceSettings');

                                    $curr_sourcesettings_data = $this->SourceSettings->find('first', array('fields'=>array('marginpercent',),'conditions' => array('source_id'=> $curr_ebay_price_data['Product']['source_id'], 'user_id'=>$curr_ebay_price_data['Product']['user_id'])));*/

                                    //$this->pre($curr_ebay_price_data);
                                    //$this->pre($curr_sourcesettings_data);
                                    $curr_ebay_price = (float) $curr_ebay_price_data['Product']['ebay_price'];
                                    $curr_marginpercent = (float) $curr_sourcesettings_data['SourceSettings']['marginpercent'];
                                    if(!empty($curr_marginpercent)){
                                        $curr_offer_price_marginadded = (float) round((($curr_offer_price*$curr_marginpercent)/100) + $curr_offer_price, 2);
                                    } else {
                                        $curr_offer_price_marginadded = $curr_offer_price;
                                    }
                                    //echo $uk_item['ASIN']." => ".$curr_offer_price." => ".$curr_offer_price_marginadded." => ".$curr_ebay_price."<br>";

                                    if($curr_offer_price > $curr_ebay_price){
                                        if((!empty($uk_priceupdated_items[$uk_item['ASIN']]) && $uk_priceupdated_items[$uk_item['ASIN']] < $curr_offer_price_marginadded) || empty($uk_priceupdated_items[$uk_item['ASIN']])){
                                            //array_push($uk_priceupdated_items, $uk_item['ASIN']);
                                            $uk_priceupdated_items[$uk_item['ASIN']] = $curr_offer_price_marginadded;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $uk_item = $response['Items']['Item'];
                        $uk_item_totaloffers = (int) $uk_item['Offers']['TotalOffers'];

                        $curr_ebay_price_data = $this->Product->find('first', array('fields'=>array('ebay_price', 'user_id', 'source_id'),'conditions' => array('status IN'=> array('0','1'), 'asin_no'=>$uk_item['ASIN'])));
                                    
                        $this->loadmodel('SourceSettings');

                        $curr_ebay_qty = $curr_ebay_price_data['Product']['qty'];

                        $curr_sourcesettings_data = $this->SourceSettings->find('first', array('fields'=>array('marginpercent',),'conditions' => array('source_id'=> $curr_ebay_price_data['Product']['source_id'], 'user_id'=>$curr_ebay_price_data['Product']['user_id'])));

                        if($uk_item_totaloffers <= 0 && $curr_ebay_qty > 0){
                            array_push($uk_out_of_stock_items, $uk_item['ASIN']);
                        } else {
                            if(isset($uk_item['Offers']['Offer'][0])){
                                $uk_offers_arr = $uk_item['Offers']['Offer'];
                                foreach ($uk_offers_arr as $uk_offers_arr_key => $uk_offers_arr_value) {
                                    //$this->pre($uk_offers_arr_value);
                                    $curr_offer_price = (float) ($uk_offers_arr_value['OfferListing']['Price']['Amount']/100);

                                    //$this->pre($curr_ebay_price_data);
                                    //$this->pre($curr_sourcesettings_data);
                                    $curr_ebay_price = (float) $curr_ebay_price_data['Product']['ebay_price'];
                                    $curr_marginpercent = (float) $curr_sourcesettings_data['SourceSettings']['marginpercent'];
                                    if(!empty($curr_marginpercent)){
                                        $curr_offer_price_marginadded = (float) round((($curr_offer_price*$curr_marginpercent)/100) + $curr_offer_price, 2);
                                    } else {
                                        $curr_offer_price_marginadded = $curr_offer_price;
                                    }
                                    //echo $uk_item['ASIN']." => ".$curr_offer_price." => ".$curr_offer_price_marginadded." => ".$curr_ebay_price."<br>";

                                    if($curr_offer_price > $curr_ebay_price){
                                        if((!empty($uk_priceupdated_items[$uk_item['ASIN']]) && $uk_priceupdated_items[$uk_item['ASIN']] < $curr_offer_price_marginadded) || empty($uk_priceupdated_items[$uk_item['ASIN']])){
                                            //array_push($uk_priceupdated_items, $uk_item['ASIN']);
                                            $uk_priceupdated_items[$uk_item['ASIN']] = $curr_offer_price_marginadded;
                                        }
                                    }
                                }
                            } else {
                                $uk_offers_arr_value = $uk_item['Offers']['Offer'];
                                //$this->pre($uk_offers_arr_value);
                                $curr_offer_price = (float) ($uk_offers_arr_value['OfferListing']['Price']['Amount']/100);
                                
                                /*$curr_ebay_price_data = $this->Product->find('first', array('fields'=>array('ebay_price', 'user_id', 'source_id'),'conditions' => array('status IN'=> array('0','1'), 'asin_no'=>$uk_item['ASIN'])));
                                    
                                $this->loadmodel('SourceSettings');

                                $curr_sourcesettings_data = $this->SourceSettings->find('first', array('fields'=>array('marginpercent',),'conditions' => array('source_id'=> $curr_ebay_price_data['Product']['source_id'], 'user_id'=>$curr_ebay_price_data['Product']['user_id'])));*/

                                //$this->pre($curr_ebay_price_data);
                                //$this->pre($curr_sourcesettings_data);
                                $curr_ebay_price = (float) $curr_ebay_price_data['Product']['ebay_price'];
                                $curr_marginpercent = (float) $curr_sourcesettings_data['SourceSettings']['marginpercent'];
                                if(!empty($curr_marginpercent)){
                                    $curr_offer_price_marginadded = (float) round((($curr_offer_price*$curr_marginpercent)/100) + $curr_offer_price, 2);
                                } else {
                                    $curr_offer_price_marginadded = $curr_offer_price;
                                }
                                //echo $uk_item['ASIN']." => ".$curr_offer_price." => ".$curr_offer_price_marginadded." => ".$curr_ebay_price."<br>";

                                if($curr_offer_price > $curr_ebay_price){
                                    if((!empty($uk_priceupdated_items[$uk_item['ASIN']]) && $uk_priceupdated_items[$uk_item['ASIN']] < $curr_offer_price_marginadded) || empty($uk_priceupdated_items[$uk_item['ASIN']])){
                                        //array_push($uk_priceupdated_items, $uk_item['ASIN']);
                                        $uk_priceupdated_items[$uk_item['ASIN']] = $curr_offer_price_marginadded;
                                    }
                                }
                            }
                        }
                    }
                }

                //echo "<br>";
                //echo "________________________________________________________________";   
                //echo "<br>";
                
            }

            echo "Out of stock items (UK)";
            echo "<br>";
            $this->pre($uk_out_of_stock_items);
            echo "________________________________________________________________";   
            echo "<br>";
            echo "Price updated items (UK)";
            echo "<br>";
            $this->pre($uk_priceupdated_items);
            echo "________________________________________________________________";   
            echo "<br>";
        }

        //exit;

        if(count($us_out_of_stock_items) > 0){

            $us_out_of_stock_and_succeed_items = array();
            
            foreach ($us_out_of_stock_items as $us_asin_no) {
                $updated_result = $this->update_out_of_stock($us_asin_no);
                if($updated_result){
                    echo $us_asin_no." is updated to out of stock <br>";
                    $us_out_of_stock_and_succeed_items[] = $us_asin_no;
                }
            }

        }

        if(count($uk_out_of_stock_items) > 0){

            $uk_out_of_stock_and_succeed_items = array();
            
            foreach ($uk_out_of_stock_items as $uk_asin_no) {
                $updated_result = $this->update_out_of_stock($uk_asin_no);
                if($updated_result){
                    echo $uk_asin_no." is updated to out of stock <br>";
                    $uk_out_of_stock_and_succeed_items[] = $uk_asin_no;
                }
            }

        }

        if(count($us_priceupdated_items) > 0){

            $us_priceupdated_and_succeed_items = array();
            
            foreach ($us_priceupdated_items as $us_asin_no => $updated_price) {
                $updated_result = $this->update_price($us_asin_no, $updated_price);
                if($updated_result){
                    echo $us_asin_no." price updated to ".$updated_price."<br>";
                    $us_priceupdated_and_succeed_items[$us_asin_no] = $updated_price;
                }
            }

        }

        if(count($uk_priceupdated_items) > 0){

            $uk_priceupdated_and_succeed_items = array();

            foreach ($uk_priceupdated_items as $uk_asin_no => $updated_price) {
                $updated_result = $this->update_price($uk_asin_no, $updated_price);    
                if($updated_result){
                    echo $uk_asin_no." price updated to ".$updated_price."<br>";
                    $uk_priceupdated_and_succeed_items[$uk_asin_no] = $updated_price;
                }
            }
        }

        $this->ReviseItems->id = $this->ReviseItems->field('id', array('id' => $revisedID));

        //var_dump($this->Product->id);return true;

        if ($this->ReviseItems->id) {

            if(count($us_out_of_stock_and_succeed_items) > 0 || count($uk_out_of_stock_and_succeed_items) > 0){
                $out_of_stock_succeeded_items = json_encode(array_merge((array)$us_out_of_stock_and_succeed_items, (array)$uk_out_of_stock_and_succeed_items));
                //var_dump($out_of_stock_succeeded_items);
                $outofstockitems_saved = $this->ReviseItems->saveField('out_of_stock_items', $out_of_stock_succeeded_items);
            }

            if(count($us_priceupdated_and_succeed_items) > 0 || count($uk_priceupdated_and_succeed_items) > 0){
                $price_updated_succeeded_items = json_encode(array_merge((array)$us_priceupdated_and_succeed_items, (array)$uk_priceupdated_and_succeed_items));
                //var_dump($price_updated_succeeded_items);
                $priceupdateditems_saved = $this->ReviseItems->saveField('price_updated_items', $price_updated_succeeded_items);
            }
            
            //var_dump($price_saved);
            $end_date = date('Y-m-d H:i:s');
            $enddate_saved = $this->ReviseItems->saveField('end_date', $end_date);
            $status_saved = $this->ReviseItems->saveField('status', 1);
            //var_dump($date_modified);
            //print("The item was successfully revised on the eBay Sandbox.");
        }

        exit;

    }

    function update_price($asin_no, $new_price)
    {

        $product_data_from_asin = $this->Product->find('first', array('conditions' => array('asin_no'=>$asin_no)));

        $is_product_live = (int) $product_data_from_asin['Product']['ebay_live'];
        $product_ebay_id = $product_data_from_asin['Product']['ebay_id'];
        $siteId = $product_data_from_asin['Product']['source_id'];
        $productId = $product_data_from_asin['Product']['id'];

        //var_dump($productId);exit;
        
        if($is_product_live)
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

        $request = new Types\ReviseFixedPriceItemRequestType();

        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $ebay_auth_token;

        $item = new Types\ItemType();

        $item->ItemID = $product_ebay_id;

        //$this->pre($item);exit;

        $item->StartPrice = new Types\AmountType(['value' => (float)$new_price]);

        //$this->pre($item);exit;

        $request->Item = $item;
        
        $response = $service->reviseFixedPriceItem($request);

        //$this->pre($response);

        //return true;

        /*if (isset($response->Errors)) {
            return false;
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
            }
        }*/
        if ($response->Ack !== 'Failure') {

            //$_SESSION['success_msg'] = "The item was successfully revised on the eBay.";
            //var_dump($productId);return true;

            $this->Product->id = $this->Product->field('id', array('id' => $productId));

            //var_dump($this->Product->id);return true;

            if ($this->Product->id) {

                $price_saved = $this->Product->saveField('ebay_price', $new_price);
                //var_dump($price_saved);
                $modified_date = date('Y-m-d H:i:s');
                $date_modified = $this->Product->saveField('modified_date', $modified_date);
                //var_dump($date_modified);
                //print("The item was successfully revised on the eBay Sandbox.");
            }

            return true;
        
        }
    }

    function update_out_of_stock($asin_no)
    {

        $product_data_from_asin = $this->Product->find('first', array('conditions' => array('asin_no'=>$asin_no)));

        $is_product_live = (int) $product_data_from_asin['Product']['ebay_live'];
        $product_ebay_id = $product_data_from_asin['Product']['ebay_id'];
        $siteId = $product_data_from_asin['Product']['source_id'];
        $productId = $product_data_from_asin['Product']['id'];

        //var_dump($productId);exit;
        
        if($is_product_live)
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

        /*$request = new Types\ReviseFixedPriceItemRequestType();
        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $ebay_auth_token;
        $item = new Types\ItemType();
        $item->ItemID = $product_ebay_id;
        $item->StartPrice = new Types\AmountType(['value' => (float)$new_price]);
        $request->Item = $item;
        $response = $service->reviseFixedPriceItem($request);*/

        $request = new Types\ReviseInventoryStatusRequestType();
        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $ebay_auth_token;
        $inventory = new Types\InventoryStatusType();
        $inventory->ItemID = $product_ebay_id;
        $inventory->Quantity = 0;
        $request->InventoryStatus[] = $inventory;
        $response = $service->ReviseInventoryStatus($request);

        //$this->pre($response);

        //return true;

        /*if (isset($response->Errors)) {
            return false;
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
            }
        }*/
        if ($response->Ack !== 'Failure') {

            //$_SESSION['success_msg'] = "The item was successfully revised on the eBay.";
            //var_dump($productId);return true;

            $this->Product->id = $this->Product->field('id', array('id' => $productId));

            //var_dump($this->Product->id);return true;

            if ($this->Product->id) {

                $qty_saved = $this->Product->saveField('qty', 0);
                $modified_date = date('Y-m-d H:i:s');
                $date_modified = $this->Product->saveField('modified_date', $modified_date);
            }

            return true;
        
        }
    }
}
?>