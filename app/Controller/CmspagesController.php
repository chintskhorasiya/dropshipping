<?php
class CmspagesController extends AppController {

    var $name = 'Cmspages';
    public $components = array('Paginator');
    var $uses = array('');

    function repricing_work()
    {
        $this->layout = 'default';
        $this->checklogin();

//        echo "vivek";
//        exit;
    }

    function pages($passlug) {

        $this->layout = 'default';



        $cmsdata = $this->Cmspage->find('first', array('conditions' => array('slug Like' => $passlug, 'status Like' => 'Active')));
        $this->set('cmsdata', $cmsdata);
        $this->set('passlug', $passlug);

        if (!empty($this->data)) {
            $error = 0;

            if(isset($this->data['btncontact']) && $this->data['btncontact']=='Submit')
            {
                $errorarray = array();

                $errorarray = $this->form_validate($this->data,'contact');
                $this->set('errorarray',$errorarray);

                if(empty($errorarray))
                {
                    $this->request->data['User']['name'] = trim($this->data['User']['fname']);
                    $this->request->data['User']['created_date'] = date("Y-m-d H:i:s");

                    //Save data in to Inquiry table
                    $this->Inquiry->save($this->data['User']);

                    //Send email to admin
                    $this->email_contact($this->data);

//                    $this->pre($this->data);
//                    exit;

                    $this->redirect(DEFAULT_URL . 'pages/contact-us/sucsend');
                }
            }
            else if(isset($this->data['btncareer']) && $this->data['btncareer']=='Submit')
            {
                $errorarray = array();

                $errorarray = $this->form_validate($this->data,'career');


                if (isset($_FILES['resume']['name']) && trim($_FILES['resume']['name']) =='')
                    $errorarray['select_resume'] = UPLOAD_RESUME;
                else
                {
                    if($_FILES['resume']['error']!=0)
                    {
                        $errorarray['filecorrupt'] = FILECORRUPT;
                    }
                    else
                    {
                        $uploaddir = SITE_ROOT_IMAGE.'uploads/resume/';
                        $time = time();
                        $new_file_name = preg_replace('/[^a-zA-Z0-9.]/','',basename($_FILES['resume']['name']));
                        $orignal_scanned_name = basename($_FILES['resume']['name']);
                        $remote_file_name = strtolower($time.$new_file_name);

                        $this->request->data['User']['old_name_resume']=$_FILES['resume']['name'];
                        $this->request->data['User']['new_name_resume']=$remote_file_name;

                        //for get file extension
                        $fileext = pathinfo($remote_file_name, PATHINFO_EXTENSION);
                        $allow_valid_file = array('pdf');    //allowed valid images

                        if(!in_array($fileext,$allow_valid_file))
                        {
                            $errorarray['validfile'] = VALID_FILETYPE;
                        }
                        else
                        {
                            $uploadfile = $uploaddir .$remote_file_name;

                            if(move_uploaded_file($_FILES['resume']['tmp_name'], $uploadfile))
                            {
                                chmod($uploadfile,0777);
                            }
                        }
                    }
                }

                $this->set('errorarray',$errorarray);


//                $this->pre($errorarray);
//                exit;

                if(empty($errorarray))
                {
                    //$this->requst->data['User']['message'] = nl2br($this->data['User']['message']);
                    //$this->pre($this->data);

                    //Send email to admin
                    $this->email_career($this->data);

                    $this->redirect(DEFAULT_URL . 'pages/career/sucsend');
                }
            }
        }
    }

    function form_validate($userdata,$pagename)
    {
        $errorarray = array();

        if (isset($userdata['User']['fname']) && (trim($userdata['User']['fname']) == '' || trim($userdata['User']['fname']) == 'Name'))
            $errorarray['enter_fname'] = ENTER_NAME;
        else
        {
            if($this->check_hasnumber($userdata['User']['fname'])==1)
            {
                $errorarray['fname_not_numeric'] = NAME_HAS_NUM;
            }
        }

        if (isset($userdata['User']['email']) && (trim($userdata['User']['email']) == '' || trim($userdata['User']['email']) == 'Email')) {
            $errorarray['enter_email'] = ENTER_EMAIL;
        }
        else
        {
            // For check valid email or not
            if($this->IsEmail($userdata['User']['email'])==0)
                $errorarray['valid_email'] = ENTER_VALIDEMAIL;

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
        if (isset($userdata['User']['message']) && (trim($userdata['User']['message']) == '' || trim($userdata['User']['message']) == 'Message')) {
            $errorarray['enter_message'] = ENTER_MESSAGE;
        }

        if($pagename=='career')
        {
            if (isset($userdata['User']['job_title']) && trim($userdata['User']['job_title']) =='')
                $errorarray['enter_job_title'] = ENTER_JOB_TITLE;
            else
            {
                if($this->check_hasnumber($userdata['User']['job_title'])==1)
                {
                    $errorarray['job_title_not_numeric'] = JOB_TITLE_HAS_NUM;
                }
            }
        }
//        $this->pre($errorarray);
//        exit;
        return $errorarray;

    }

    //function for cms grid
    function cmspagesgrid() {

        $this->checkadminlogin();
        $this->layout = 'admin_default';

        $urlpara = '';
        $paramcond = "";

        if (isset($this->data['searchtext']) && trim($this->data['searchtext']) != '') {
            $paramcond .= "name LIKE '%" . $this->DGaddslashes($this->data['searchtext']) . "%'";
            $urlpara .= "searchtext:" . $this->DGstripslashes($this->data['searchtext']) . "/";

            $this->redirect('cmspagesgrid/' . $urlpara);
        } else if (isset($this->params['named']['searchtext']) && trim($this->params['named']['searchtext']) != '') {
            $paramcond .= "name LIKE '%" . $this->DGaddslashes($this->params['named']['searchtext']) . "%'";
            $urlpara .= "searchtext:" . $this->DGstripslashes($this->params['named']['searchtext']) . "/";

            //$this->redirect('cmspagesgrid/' . $urlpara);
        }
        if (isset($this->params['named']['page']) && trim($this->params['named']['page']) != '') {
            $urlpara .= "page:" . trim($this->params['named']['page']);
        }


//        echo $urlpara;
//        echo '<br>'.$paramcond;

        /*         *
          echo "<pre>";
          print_r($this->data);
          print_r($this->params);
          echo "</pre>";
          exit;
          /* */

        if (isset($this->data['eventvalue']) && $this->data['action'] == 'Active') {
            foreach ($this->data['checkbox'] as $k => $v) {
                $this->request->data['Cmspage']['id'] = $k; //For set id
                $this->request->data['Cmspage']['status'] = 'Active';
                $this->Cmspage->save($this->request->data['Cmspage']);
            }
            $this->redirect('cmspagesgrid/' . $urlpara);
        }
        if (isset($this->data['eventvalue']) && $this->data['action'] == 'Inactive') {
            foreach ($this->data['checkbox'] as $k => $v) {
                $this->request->data['Cmspage']['id'] = $k; //For set id
                $this->request->data['Cmspage']['status'] = 'Inactive';
                $this->Cmspage->save($this->request->data['Cmspage']);
            }
            $this->redirect('cmspagesgrid/' . SUCINACTIVE . '/' . $urlpara);
        }
        if (isset($this->data['eventvalue']) && $this->data['eventvalue'] == 'delete') {
            foreach ($this->data['checkbox'] as $k => $v) {
                $this->Cmspage->delete($k);
            }
            $this->redirect('cmspagesgrid/' . SUCDELETE);
        }

        if ((isset($this->data['eventvalue']) && $this->data['eventvalue'] == 'all') || (isset($this->data['searchtext']) && trim($this->data['searchtext']) == "")) {
            $this->redirect('cmspagesgrid');
        }

        $this->paginate = array('conditions' => array($paramcond), 'order' => 'id desc', 'limit' => ADMINCMS_LIMIT);

        $this->Cmspage->recursive = 1;
        $this->set('cmsdata', $this->paginate('Cmspage'));
    }

    //function add cms
    function addcmspage() {

        $this->checkadminlogin();
        $this->layout = 'admin_default';

        if (!empty($this->data)) {

            $error = 0;
            if (isset($this->data['Cmspage']['name']) && trim($this->data['Cmspage']['name']) == '') {
                $error = 1;
                $this->set("entername", "entername");
            }
            if (isset($this->data['Cmspage']['description']) && trim(str_replace('&nbsp;', '', strip_tags($this->data['Cmspage']['description']))) == '') {
                $error = 1;
                $this->set("enterdesc", "enterdesc");
            }
//            $this->pre($this->data);
            if ($error == 0) {
                $this->request->data['Cmspage']['slug'] = $this->_toSlug($this->data['Cmspage']['name']);
                $this->request->data['Cmspage']['status'] = 'Active';
                $this->request->data['Cmspage']['created_date'] = date('Y-m-d H:i:s', time());
                $this->request->data['Cmspage']['modified_date'] = date('Y-m-d H:i:s', time());

                if ($this->Cmspage->save($this->data['Cmspage'])) {
                    $this->redirect('cmspagesgrid/' . SUCADD);
                }
            }
        }
    }

    //function edit cms
    function editcmspage($id = NULL) {

        $this->checkadminlogin();
        $this->layout = 'admin_default';

        if (!empty($this->data)) {

            $error = 0;

            if (isset($this->data['Cmspage']['name']) && trim($this->data['Cmspage']['name']) == '') {
                $error = 1;
                $this->set("entername", "entername");
            }

            //$this->pre($this->data);
            //$this->pre(htmlentities(trim(str_replace('&nbsp;', '', strip_tags($this->data['Cmspage']['description'])))));

            if (isset($this->data['Cmspage']['description']) && trim(str_replace('&nbsp;', '', strip_tags($this->data['Cmspage']['description']))) == '') {
                $error = 1;
                $this->set("enterdesc", "enterdesc");
            }
            if ($error == 0) {
                $this->request->data['Cmspage']['id'] = $id;
                $this->request->data['Cmspage']['slug'] = $this->_toSlug($this->data['Cmspage']['name']);
                $this->request->data['Cmspage']['modified_date'] = date('Y-m-d H:i:s', time());

                if ($this->Cmspage->save($this->data['Cmspage'])) {
                    $this->redirect('cmspagesgrid/' . SUCUPDATE);
                }
            }
        } else {
            $paramcond = "id='" . $id . "'";
            $this->data = $this->Cmspage->find('first', array('conditions' => array($paramcond)));
        }
    }

    function footermenu() {
        $this->checkadminlogin();
        $this->layout = 'admin_default';

        if (!empty($this->data)) {

            $error_array = array();
            for ($i = 0; $i < count($this->data['Footer']['name']); $i++) {
                if (isset($this->data['Footer']['name'][$i]) && trim($this->data['Footer']['name'][$i]) == '') {
                    $error_array['box' . ($i + 1)] = ENTER_FOOTERNAME . ($i + 1) . ' title';
                }
                if (empty($error_array)) {
                    $update_footer_pageinfo = array();
                    for ($j = 0; $j < count($this->data['FooterLink']['box' . ($i + 1)]); $j++) {
                        if ($this->data['FooterLink']['box' . ($i + 1)][$j]['name'] == '' && $this->data['FooterLink']['box' . ($i + 1)][$j]['link'] == '') {

                        } else {
                            $update_footer_pageinfo[] = $this->data['FooterLink']['box' . ($i + 1)][$j];
                        }
                    }

                    $update_footer_info = array();

                    //Checkin database for record available or not
                    $footerdata = $this->FooterLink->find('all', array('conditions' => array()));

                    if (isset($footerdata) && count($footerdata) > 0) {
                        $update_footer_info['FooterLink'][$i]['id'] = ($i + 1);
                    }

                    $update_footer_info['FooterLink'][$i]['boxname'] = $this->data['Footer']['name'][$i];
                    $update_footer_info['FooterLink'][$i]['pageinfo'] = json_encode($update_footer_pageinfo);
                    $this->FooterLink->saveAll($update_footer_info['FooterLink'][$i]);
                    //$this->pre($update_footer_info);
                    //exit;
                }
            }
            $this->set('error_array', $error_array);
            if (empty($error_array)) {
                $this->redirect('footermenu/' . SUCUPDATE);
            }

            //$this->pre($error_array);
        }
        $footerdata = $this->FooterLink->find('all', array('conditions' => array()));
        $this->set('footerdata', $footerdata);
    }

    //Function for create webpage to anroid application
    function pages_web($passlug) {

        $this->layout = 'web_default';



        $cmsdata = $this->Cmspage->find('first', array('conditions' => array('slug Like' => $passlug, 'status Like' => 'Active')));
        $this->set('cmsdata', $cmsdata);
        $this->set('passlug', $passlug);

        if (!empty($this->data)) {
            $error = 0;

            if(isset($this->data['btncontact']) && $this->data['btncontact']=='Submit')
            {
                $errorarray = array();

                $errorarray = $this->form_validate($this->data,'contact');
                $this->set('errorarray',$errorarray);

                if(empty($errorarray))
                {
                    $this->request->data['User']['name'] = trim($this->data['User']['fname']);
                    $this->request->data['User']['created_date'] = date("Y-m-d H:i:s");

                    //Save data in to Inquiry table
                    $this->Inquiry->save($this->data['User']);

                    //Send email to admin
                    $this->email_contact($this->data);

//                    $this->pre($this->data);
//                    exit;

                    $this->redirect(DEFAULT_URL . 'cmspages/pages_web/contact-us/sucsend');
                }
            }
        }
    }

}
?>