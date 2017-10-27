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
            $product_ebay_qty = (int) $product_data['Product']['qty'];
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
                if($product_ebay_qty === 0)
                {
                    $_SESSION['success_msg'] = "Item is already out of stock !";
                    return $this->redirect(DEFAULT_URL.'listings/listing_requests/');
                }

                $service = new Services\TradingService([
                    'credentials' => [
                        'devId' => EBAY_SANDBOX_DEVID,
                        'appId' => EBAY_SANDBOX_APPID,
                        'certId' => EBAY_SANDBOX_CERTID,
                    ],
                    'sandbox'     => true,
                    'siteId'      => $siteId
                ]);

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
                $request->RequesterCredentials->eBayAuthToken = EBAY_SANDBOX_AUTHTOKEN;
                
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

    }
}
?>