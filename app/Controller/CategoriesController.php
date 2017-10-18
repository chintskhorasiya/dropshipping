<?php
require_once "../webroot/vendor/autoload.php";

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\Operations\Search;

//App::import('Vendor', 'resize_img');
class CategoriesController extends AppController {

    var $name = 'Categories';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator', 'Flash');
    public $helpers = array('Html', 'Form', 'Session', 'Time');
    //var $uses = array('Source','SourceSetting');

    function categories_mapping($user_encryptid) {

        $this->layout = 'default';
        $this->checklogin();

        $combine_data =array();
        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);
        $this->Session->read(md5(SITE_TITLE) . 'USERID');

        if($userid != $this->Session->read(md5(SITE_TITLE) . 'USERID'))
        {
            $this->redirect(DEFAULT_URL . 'users/dashboard');
        }

        //echo "flgkmdfgklmdfgklmdlfgmlfhm";exit;

        if(isset($this->params['named']['type']) && $this->params['named']['type']=='amazon-us')
            $combine_data['SourceSetting']['source_id'] = 1;
        else
            $combine_data['SourceSetting']['source_id'] = 2;

        //print_r($combine_data);

        if (!empty($this->data)) {

            if($this->data['primaryCategoryA'] && $this->data['primaryCategory'])
            {
                $this->loadmodel('Categories');
                //var_dump($this->Categories);exit;
                $amazon_category_data = $this->Categories->find('first',array('conditions' => array('id' => $this->data['primaryCategoryA'])));

                $mapData = array();
                $mapData['CategoriesMappings']['a_cat_id'] = $amazon_category_data['Categories']['aid'];
                $mapData['CategoriesMappings']['e_cat_id'] = $this->data['primaryCategory'];
                $mapData['CategoriesMappings']['source_id'] = $combine_data['SourceSetting']['source_id'];
                $mapData['CategoriesMappings']['user_id'] = $userid;
                
                //print_r($this->data);exit;
                $this->loadmodel('CategoriesMappings');

                $already_map_data = $this->CategoriesMappings->find('first',array('conditions' => array('a_cat_id' => $mapData['CategoriesMappings']['a_cat_id'], 'user_id' => $userid, 'source_id' => $mapData['CategoriesMappings']['source_id'])));

                //var_dump($already_map_data);exit;
                if(count($already_map_data) > 0)
                {
                    //$already_map_data['CategoriesMappings']['id'];
                    $mapData['CategoriesMappings']['id'] = $already_map_data['CategoriesMappings']['id'];
                    if ($this->CategoriesMappings->save($mapData, array('fieldList' => array('e_cat_id')))) {
                        // Set a session flash message and redirect.
                        $this->Session->setFlash('Mapping Updated!', 'default', array('class'=>'alert alert-success'), 'mapping');
                        return $this->redirect('/categories/categories_mapping/'.$user_encryptid);
                    }
                    else
                    {
                        $this->Session->setFlash('Something went wrong', 'default', array('class'=>'alert alert-danger'), 'mapping');
                        return $this->redirect('/categories/categories_mapping/'.$user_encryptid);
                    } 
                }
                else
                {
                    if ($this->CategoriesMappings->save($mapData)) {
                        // Set a session flash message and redirect.
                        $this->Session->setFlash('Mapping Saved!', 'default', array('class'=>'alert alert-success'), 'mapping');
                        return $this->redirect('/categories/categories_mapping/'.$user_encryptid);
                    }
                    else
                    {
                        $this->Session->setFlash('Something went wrong', 'default', array('class'=>'alert alert-danger'), 'mapping');
                        return $this->redirect('/categories/categories_mapping/'.$user_encryptid);
                    }
                }

            }
            else
            {
                $this->Session->setFlash('Something went wrong', 'default', array('class'=>'alert alert-danger'), 'mapping');
                return $this->redirect('/categories/categories_mapping/'.$user_encryptid);
            }

        }
        else
        {
            $this->loadmodel('Categories');
            //var_dump($this->Categories);exit;
            $root_categories_data = $this->Categories->find('list',array('fields'=>array('Categories.id', 'Categories.name'),'conditions' => array('parent' => 0, 'sourceid' => $combine_data['SourceSetting']['source_id']), 'order' => array('Categories.name' => 'ASC')));
            $this->set('root_categories_data',$root_categories_data);

            $this->render('categories_mapping');
        }
    }

    function list_amazon_categories($user_encryptid) {

        $this->layout = 'default';
        $this->checklogin();

        $combine_data =array();
        $userid = $this->decrypt_data($user_encryptid,ID_LENGTH);
        $this->Session->read(md5(SITE_TITLE) . 'USERID');

        if($userid != $this->Session->read(md5(SITE_TITLE) . 'USERID'))
        {
            $this->redirect(DEFAULT_URL . 'users/dashboard');
        }

        //echo "flgkmdfgklmdfgklmdlfgmlfhm";exit;

        if (!empty($this->data))
        {
            $form_submit = 2;
            $awnidStr = $this->data['Listing']['content'];
            
            $awnidArr = explode(PHP_EOL, $awnidStr);

            foreach($awnidArr as $awnid)
            {
                $check_content = $this->check_url($awnid);
                if($check_content==1)
                {
                    //$awnid = $this->get_awnid($this->data['Listing']['content']);
                    $awnid = $this->get_asin($awnid);
                }
                if(!empty($awnid))
                {
                    //$this->redirect(DEFAULT_URL .'get_product_detail.php?userid='.$userid.'&sourceid=2&awnid='.$awnid.'&form_submit='.$form_submit );
                    //exit;
                    $country_cod = 'com';
                    $sourceid = 1;
                    $ACC_KEY = AWS_API_KEY; //'AKIAJL5OCKUJ5TXWF47Q'; //'AKIAJOK6ESBXHHPLM23A';
                    $SEC_KEY = AWS_API_SECRET_KEY; //'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'; //'5IULj01av/7DZrLNG5/exNCQxfZOIV9LbfejFGdq';
                    if(isset($this->data['Listing']['source_id']) && $this->data['Listing']['source_id']==2)
                    {
                        $country_cod = 'co.uk';
                        $sourceid = 2;
                        //$ACC_KEY = 'AKIAJL5OCKUJ5TXWF47Q';
                        //$SEC_KEY = 'duy/xH0o6oLKbUxge7wO8fnCcPiDGqco9kmLaW5m';
                        $ACC_KEY = AWS_API_KEY;
                        $SEC_KEY = AWS_API_SECRET_KEY;
                    }

                    //var_dump($AWS_API_SECRET_KEY);exit;

                    $client = new \GuzzleHttp\Client();
                    $request = new \ApaiIO\Request\GuzzleRequest($client);

                    $conf = new GenericConfiguration();
                    $conf
                        ->setCountry($country_cod)
                        ->setAccessKey($ACC_KEY) //AWS_API_KEY
                        ->setSecretKey($SEC_KEY) //AWS_API_SECRET_KEY
                        //->setAssociateId('testing04fb-20')
                        ->setAssociateTag('shoes') //AWS_ASSOCIATE_TAG
                        ->setRequest($request);
                        //->setResponseTransformer(new \ApaiIO\ResponseTransformer\XmlToDomDocument());

                    $apaiIo = new ApaiIO($conf);
                    //$this->pre($apaiIo);exit;

                    $lookup = new Lookup();
                    $lookup->setItemId($awnid);
                    $lookup->setResponseGroup(array('Large')); // More detailed information
                    $response = $apaiIo->runOperation($lookup);
                    $response = json_decode (json_encode (simplexml_load_string ($response)), true);
                    if(isset($response['Items']['Request']['Errors']['Error']['Message']))
                    {
                        $error = $response['Items']['Request']['Errors']['Error']['Message'];
                        $this->pre($error);
                        exit;
                    }
                    //$this->pre($response);exit;

                    $browseNodes = $response['Items']['Item']['BrowseNodes']['BrowseNode'];
                    //$this->pre($browseNodes);exit;
                    if(is_array($browseNodes) && isset($browseNodes[0])){
                        foreach ($browseNodes as $browseNode) {
                            //pre($browseNode);
                            $nodeJsonString = "[";
                            $nodeJsonString .= '{"id":'.$browseNode['BrowseNodeId'].',"name":"'.$browseNode['Name'].'"';
                            //echo $nodeJsonString;
                            $awsCategories[] = json_decode($this->getAncestors($browseNode['Ancestors'], $nodeJsonString));
                        }

                    } else {
                        $browseNode = $browseNodes;
                        //pre($browseNode);exit;
                        $nodeJsonString = "[";
                        $nodeJsonString .= '{"id":'.$browseNode['BrowseNodeId'].',"name":"'.$browseNode['Name'].'"';
                        $finalResult = $this->getAncestors($browseNode['Ancestors'], $nodeJsonString);
                        $awsCategories = json_decode($finalResult);

                    }
                    //$this->pre($awsCategories);exit;
                    if(count($awsCategories) > 0)
                    {
                        $imported = $this->import_categories($awsCategories, $sourceid);
                    }    
                }

            }

            if($imported)
            {
                 $this->Session->setFlash('Imported Some Categories Successfully', 'default', array('class'=>'alert alert-success'), 'list_amazon_categories');
                return $this->redirect('/categories/list_amazon_categories/'.$user_encryptid);
            }
            else
            {
                 $this->Session->setFlash('These categories are already uploaded', 'default', array('class'=>'alert alert-warning'), 'list_amazon_categories');
                return $this->redirect('/categories/list_amazon_categories/'.$user_encryptid);
            }
            exit;
        }
        else
        {
            $this->render('list_amazon_categories');   
        }

    }

}