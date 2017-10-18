<?php
App::import('Vendor', 'resize_img');

require __DIR__.'/../../vendor/autoload.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;


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
                $awnid = $this->get_awnid($this->data['Listing']['content']);
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

        $product_data = $this->Product->find('all', array('conditions' => array('user_id'=>$userid)));
        $this->set('product_data',$product_data);

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

    function listing_review_approve()
    {
        //$config = require __DIR__.'/configuration.php';
        $siteId = Constants\SiteIds::US;
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

        /*echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        exit;*/
        
        if(isset($_POST['btn_approve']) && $_POST['btn_approve'] == "Approve")
        {
            ini_set('magic_quotes_gpc', false);    // magic quotes will only confuse things like escaping apostrophe
            //Get the item entered
            $listingType     = $_POST['listingType'];
            $primaryCategory = $_POST['primaryCategory'];
            $itemTitle       = $_POST['title'];
            $startPrice      = $_POST['product_price'];
            //$buyItNowPrice   = $_POST['buyItNowPrice'];
            $listingDuration = $_POST['listingDuration'];
            //$safequery       = $_POST['searched_keyword'];

            $return_url = $_POST['return_url'];
            $asin_no = $_POST['asin_no'];

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
            $request->RequesterCredentials->eBayAuthToken = EBAY_SANDBOX_AUTHTOKEN;
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
            $item->PrimaryCategory->CategoryID = $primaryCategory;
            //Item specifics
            $item->ItemSpecifics = new Types\NameValueListArrayType();

            $itemSpecificationsKeysArr = $_POST['item_key'];
            $itemSpecificationsValsArr = $_POST['item_val'];
            
            if(count($itemSpecificationsKeysArr) > 0){

                foreach ($itemSpecificationsKeysArr as $iscKey => $item_key) {
                    
                    $specific = new Types\NameValueListType();
                    $specific->Name = $item_key;
                    $specific->Value[] = $itemSpecificationsValsArr[$iscKey];
                    $item->ItemSpecifics->NameValueList[] = $specific;

                }
            
            }
            
            // item images
            if(count($img_name) > 0){

                $item->PictureDetails = new Types\PictureDetailsType();
                $item->PictureDetails->GalleryType = Enums\GalleryTypeCodeType::C_GALLERY;
                $item->PictureDetails->PictureURL = $img_name;
            
            }
            
            /**
             * Provide enough information so that the item is listed.
             * It is beyond the scope of this example to go into any detail.
             */
            //$item->ListingType = Enums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;
            $item->ListingType = $listingType;
            $item->Quantity = 1;   
            $item->ListingDuration = Enums\ListingDurationCodeType::C_GTC;
            $item->StartPrice = new Types\AmountType(['value' => (float)$startPrice]);
            //var_dump($item);exit;
            $item->Country = 'US';
            $item->Location = 'Beverly Hills';
            $item->Currency = 'USD';
            $item->ConditionID = (int)$itemCondition;
            $item->PaymentMethods[] = 'PayPal';
            $item->PayPalEmailAddress = 'projectdesk-facilitator@seawindsolution.com';
            $item->DispatchTimeMax = 1;
            $item->ShipToLocations[] = 'None';
            $item->ReturnPolicy = new Types\ReturnPolicyType();
            $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsNotAccepted';
            /**
             * Finish the request object.
             */
            $request->Item = $item;

            /**
             * Send the request.
             */
            $response = $service->addFixedPriceItem($request);

            //var_dump($response);exit;

            /**
             * Output the result of calling the service operation.
             */
            if (isset($response->Errors)) {
                
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
                $_SESSION['success_msg'] = sprintf(
                    "The item was listed to the eBay Sandbox with the Item number %s\n",
                    $response->ItemID
                );

                //var_dump($this);exit;

                $this->Product->id = $this->Product->field('id', array('asin_no' => $asin_no));
                if ($this->Product->id) {
                    $this->Product->saveField('status', 1);
                    $this->Product->saveField('ebay_id', $response->ItemID);
                }
                //echo '<br><a href="index.php" class="alert-link">Add more</a>';
                //echo '</div>';
            }

            var_dump($return_url);

            return $this->redirect($return_url);
            //exit;
            //exit;



        }
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