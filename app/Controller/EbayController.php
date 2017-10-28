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

}