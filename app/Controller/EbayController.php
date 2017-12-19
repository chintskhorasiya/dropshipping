<?php
class EbayController extends AppController {

    var $name = 'Ebay';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator');
    public $helpers = array('Html', 'Form', 'Session', 'Time');
    var $uses = array('Ebay','EbaySetting');

    function ebay_settings($user_encryptid) {

        $this->layout = 'default';
        $this->checklogin();

        $combine_data =array();
        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);
        $this->Session->read(md5(SITE_TITLE) . 'USERID');

        if($userid != $this->Session->read(md5(SITE_TITLE) . 'USERID'))
        {
            $this->redirect(DEFAULT_URL . 'users/dashboard');
        }

        if(isset($this->params['named']['type']) && $this->params['named']['type']=='us')
            $combine_data['EbaySetting']['source_id'] = 1;
        else
            $combine_data['EbaySetting']['source_id'] = 2;

        //Check user record inserted or not
        $check_source = $this->EbaySetting->find('first', array('conditions' => array('user_id'=>$userid,'source_id'=>$combine_data['EbaySetting']['source_id'])));

        //$this->pre($check_source);
        //$this->pre($combine_data);
        //$this->pre($this->data);
        //exit;

        if (!empty($this->data)) {
            
            //$this->pre($this->data);
            //exit;

            if(isset($this->data['btn_ebay_settings']) && $this->data['btn_ebay_settings']!='')
            {
                $this->request->data['EbaySetting']['account_type'] = $this->data['EbaySetting']['account_type'];
                $this->request->data['EbaySetting']['user_id'] = $userid;
                $this->request->data['EbaySetting']['source_id'] = $combine_data['EbaySetting']['source_id'];
            }
            
            if(!empty($check_source))
            {
                $this->request->data['EbaySetting']['id'] = $check_source['EbaySetting']['id'];
            }

            $EbaySettings = $this->data['EbaySetting'];

            $this->loadmodel('EbaySettings');
            $this->EbaySettings->set($EbaySettings);
            //$this->pre($EbaySettings);exit;
            
            $saveSettings = $this->EbaySettings->save($EbaySettings);
            $this->Session->setFlash('Settings Updated!', 'default', array('class'=>'alert alert-success'), 'ebay_setting_save');

            $this->redirect(DEFAULT_URL . 'ebay/ebay_settings/type:'.$this->params['named']['type'].'/'.$this->params['pass'][0]);
        }
        else
        {
            if(!empty($check_source))
            {
                $this->data = $check_source;
            }
            else
            {
                $this->data = $combine_data;
            }
        }
        
    }

    function ebay_user_token($user_encryptid)
    {
        $this->layout = 'default';
        $this->checklogin();

        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);
        
        $this->Session->read(md5(SITE_TITLE) . 'USERID');

        if($userid != $this->Session->read(md5(SITE_TITLE) . 'USERID'))
        {
            $this->redirect(DEFAULT_URL . 'users/dashboard');
        }

        $this->loadmodel('EbayTokens');

        $check_token_exist = $this->EbayTokens->find('first', array('conditions' => array('user_id'=>$userid)));

        //var_dump($check_token_exist);exit;
        if(!empty($check_token_exist))
        {
            $this->set('token_data', $check_token_exist);
        }
        else {
            $this->set('token_data', '');
        }

        if (!empty($this->data)) {
            //print_r($this->data);exit;

            //$this->loadmodel('EbayTokens');

            //$check_token_exist = $this->EbayTokens->find('first', array('conditions' => array('user_id'=>$userid)));

            if(!empty($check_token_exist))
            {
                $this->request->data['EbayTokens']['id'] = $check_token_exist['EbayTokens']['id'];
                $this->request->data['EbayTokens']['user_id'] = $userid;
            }

            $this->request->data['EbayTokens']['user_id'] = $userid;
            $EbayToken = $this->data['EbayTokens'];

            //var_dump($EbayToken);exit;

            $this->EbayTokens->set($EbayToken);
            //$this->pre($EbaySettings);exit;
            
            $saveSettings = $this->EbayTokens->save($EbayToken);
            $this->Session->setFlash('Token Saved!', 'default', array('class'=>'alert alert-success'), 'ebay_setting_save');

            $this->redirect(DEFAULT_URL . 'ebay/ebay_user_token/'.$this->params['pass'][0]);
        }

        //echo "in user token";exit;
    }

}