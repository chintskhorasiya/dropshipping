<?php
//App::import('Vendor', 'resize_img');
class SourcesController extends AppController {

    var $name = 'Sources';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator');
    public $helpers = array('Html', 'Form', 'Session', 'Time');
    var $uses = array('Source','SourceSetting');

    function source_settings($user_encryptid) {

        $this->layout = 'default';
        $this->checklogin();

        $combine_data =array();
        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);
        $this->Session->read(md5(SITE_TITLE) . 'USERID');

        if($userid != $this->Session->read(md5(SITE_TITLE) . 'USERID'))
        {
            $this->redirect(DEFAULT_URL . 'users/dashboard');
        }

        if(isset($this->params['named']['type']) && $this->params['named']['type']=='amazon-us')
            $combine_data['SourceSetting']['source_id'] = 1;
        else
            $combine_data['SourceSetting']['source_id'] = 2;

        //Check user record inserted or not
        $check_source = $this->SourceSetting->find('first', array('conditions' => array('user_id'=>$userid,'source_id'=>$combine_data['SourceSetting']['source_id'])));

//        $this->pre($check_source);
//        $this->pre($combine_data);
//        exit;

        if (!empty($this->data)) {

//            $this->pre($combine_data);
//            $this->pre($this->data);
//            exit;

            if(isset($this->data['btn_repricing']) && $this->data['btn_repricing']!='')
            {
                $this->request->data['SourceSetting']['reprice_range'] = json_encode($this->data['SourceSetting']['reprice_range']);
            }
            if(isset($this->data['btn_advance_setting']) && $this->data['btn_advance_setting']!='')
            {
                $this->request->data['SourceSetting']['ao_fee'] = (isset($this->data['SourceSetting']['ao_fee']) && $this->data['SourceSetting']['ao_fee']==1)?$this->data['SourceSetting']['ao_fee']:0;
                $this->request->data['SourceSetting']['lower_quantity'] = (isset($this->data['SourceSetting']['lower_quantity']) && $this->data['SourceSetting']['lower_quantity']==1)?$this->data['SourceSetting']['lower_quantity']:0;
            }
            if(isset($this->data['btn_save_setting']) && $this->data['btn_save_setting']!='')
            {
                $this->request->data['SourceSetting']['sold_by_amazon'] = (isset($this->data['SourceSetting']['sold_by_amazon']) && $this->data['SourceSetting']['sold_by_amazon']==1)?$this->data['SourceSetting']['sold_by_amazon']:0;
                $this->request->data['SourceSetting']['fba_offers'] = (isset($this->data['SourceSetting']['fba_offers']) && $this->data['SourceSetting']['fba_offers']==1)?$this->data['SourceSetting']['fba_offers']:0;
                $this->request->data['SourceSetting']['merchant_orders'] = (isset($this->data['SourceSetting']['merchant_orders']) && $this->data['SourceSetting']['merchant_orders']==1)?$this->data['SourceSetting']['merchant_orders']:0;
                $this->request->data['SourceSetting']['international_offer'] = (isset($this->data['SourceSetting']['international_offer']) && $this->data['SourceSetting']['international_offer']==1)?$this->data['SourceSetting']['international_offer']:0;
                $this->request->data['SourceSetting']['prime_offer'] = (isset($this->data['SourceSetting']['prime_offer']) && $this->data['SourceSetting']['prime_offer']==1)?$this->data['SourceSetting']['prime_offer']:0;
                $this->request->data['SourceSetting']['addon_offer'] = (isset($this->data['SourceSetting']['addon_offer']) && $this->data['SourceSetting']['addon_offer']==1)?$this->data['SourceSetting']['addon_offer']:0;
            }

            $this->request->data['SourceSetting']['user_id'] = $userid;
            $this->request->data['SourceSetting']['source_id'] = $combine_data['SourceSetting']['source_id'];

            if(!empty($check_source))
            {
                $this->request->data['SourceSetting']['id'] = $check_source['SourceSetting']['id'];
            }

            $SourceSettings = $this->data['SourceSetting'];

            //$this->pre($this->data);
            //$this->pre($SourceSettings);
            $this->loadmodel('SourceSettings');
            $this->SourceSettings->set($SourceSettings);
            if ($this->SourceSettings->validates()) {
                $saveSettings = $this->SourceSettings->save($SourceSettings);
                $this->Session->setFlash('Settings Updated!', 'default', array('class'=>'alert alert-success'), 'source_setting_save');
            } else {
                // didn't validate logic
                $saveerrors = $this->SourceSettings->validationErrors;
                //$this->pre($saveerrors);exit;
                foreach ($saveerrors as $saveerror)
                {
                    foreach ($saveerror as $saveerr) {
                        $this->Session->setFlash($saveerr, 'default', array('class'=>'alert alert-danger'), 'source_setting_save');   
                    }
                }
            }
            //exit;

            //$this->SourceSetting->save($this->data['SourceSetting']);

//            $this->pre($this->data);
//            exit;

            $this->redirect(DEFAULT_URL . 'sources/source_settings/type:'.$this->params['named']['type'].'/'.$this->params['pass'][0]);
        }
        if(isset($this->params['pass'][0]) && $this->params['pass'][0]!='')
        {
            $this->data = $this->SourceSetting->find('first', array('conditions' => array('user_id'=>$userid,'source_id'=>$combine_data['SourceSetting']['source_id'])));
            if(!empty($this->data) && $this->data['SourceSetting']['reprice_range']!='')
                $this->request->data['SourceSetting']['reprice_range'] = json_decode($this->data['SourceSetting']['reprice_range'],true);
            //$this->pre($this->data['SourceSetting']);
        }
    }

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

            if (isset($userdata['User']['fname']) && (trim($userdata['User']['fname']) == '' || trim($userdata['User']['fname']) == 'Name'))
                $errorarray['enter_fname'] = ENTER_NAME;
            else
            {
                if($this->check_hasnumber($userdata['User']['fname'])==1)
                {
                    $errorarray['fname_not_numeric'] = NAME_HAS_NUM;
                }
            }
            if (isset($userdata['User']['company_name']) && (trim($userdata['User']['company_name']) == '' || trim($userdata['User']['company_name']) == 'Company Name'))
                $errorarray['enter_company_name'] = ENTER_COMPANY_NAME;
            else
            {
                if($this->check_hasnumber($userdata['User']['company_name'])==1)
                {
                    $errorarray['numeric_company_name'] = ENTER_NUMERIC_COMPANY_NAME;
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
                $errorarray['enter_mobile'] = ENTER_MOBILE;
            }
            else
            {
    //            $this->check_int($userdata['User']['mobile']);
                 if($this->check_int($userdata['User']['mobile'])==1)
                     $errorarray['numeric_mobile'] = ENTER_NUMERIC_MOBILE;
                 else if(strlen($userdata['User']['mobile'])!=10)
                     $errorarray['mobile_length'] = MOBILE_LENGTH;
            }
        }


//        $this->pre($check_email_pass);
//        $this->pre($userdata);
//        $this->pre($errorarray);
//        exit;

        return $errorarray;
    }
}