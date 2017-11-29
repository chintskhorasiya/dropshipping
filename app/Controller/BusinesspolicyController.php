<?php

App::import('Vendor', 'resize_img');


// [[CUSTOM]] FOR EBAY
require __DIR__.'/../../vendor/autoload.php';

// [[CUSTOM]] FOR EBAY
use \DTS\eBaySDK\Constants;

use \DTS\eBaySDK\BusinessPoliciesManagement\Services;
use \DTS\eBaySDK\BusinessPoliciesManagement\Types;


class BusinesspolicyController extends AppController {


    var $name = 'Businesspolicy';

    public $components = array('Cookie', 'Session', 'Email', 'Paginator');

    public $helpers = array('Html', 'Form', 'Session', 'Time');

    var $uses = array('ListingSettings','Product','Blacklist','ListingTemplate');


    function test_ebay_business_policies($live, $siteId)
    {
        if($live == "1"){
            $service = new Services\BusinessPoliciesManagementService([
                'credentials' => [

                            'devId' => EBAY_LIVE_DEVID,

                            'appId' => EBAY_LIVE_APPID,

                            'certId' => EBAY_LIVE_CERTID,

                        ],
                'authToken' => EBAY_LIVE_AUTHTOKEN,
                'globalId'      => Constants\GlobalIds::GB
            ]);
        } else {
            $service = new Services\BusinessPoliciesManagementService([
                'credentials' => [

                            'devId' => EBAY_SANDBOX_DEVID,

                            'appId' => EBAY_SANDBOX_APPID,

                            'certId' => EBAY_SANDBOX_CERTID,

                        ],

                'sandbox' => true,
                'authToken' => EBAY_SANDBOX_AUTHTOKEN,
                'globalId' => Constants\GlobalIds::US
            ]);
        }


        /**
         * Create the request object.
         */
        $request = new Types\GetSellerProfilesRequest();
        /**
         * Send the request.
         */

        //$this->pre($service);exit;

        $response = $service->getSellerProfiles($request);

        $this->pre($response);exit;

    }

}