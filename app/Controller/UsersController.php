<?php
App::import('Vendor', 'resize_img');

class UsersController extends AppController {

    var $name = 'Users';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator');
    public $helpers = array('Html', 'Form', 'Session', 'Time');
    var $uses = array('User');

    //function for display dashboard
    function dashboard() {

        $this->layout = 'default';
        $this->checklogin();
    }

    //function for user login page
    function index() {

        $this->layout = 'default';

        if ($this->Session->check(md5(SITE_TITLE) . 'USERID') == true) {
            //$this->Session->setFlash('The URL you\'ve followed requires you login.');
            //$this->redirect(DEFAULT_URL);
            $this->redirect(DEFAULT_URL . 'users/dashboard');
            exit();
        }

        if (!empty($this->data)) {

            //$this->pre($this->params);
//            $this->pre($this->data);
//            exit;

            $error_array = array();
            if (isset($this->data['User']['username']) && $this->data['User']['username'] == '') {
                $error_array['err_username'] = ENTER_USERNAME;
            }

            if (isset($this->data['User']['password']) && $this->data['User']['password'] == '') {
                $error_array['err_password'] = NEWPASS;
            }

            if (empty($error_array)) {


                $dbuser = $this->User->find('first', array('conditions' => array('User.username like' => $this->data['User']['username'], 'User.password like' => md5(trim($this->data['User']['password'])), 'User.status' => 0)));


                if (!empty($dbuser)) {
                    $this->Session->write(md5(SITE_TITLE) . 'USERID', $dbuser['User']['id']);
                    $this->Session->write(md5(SITE_TITLE) . 'USERNAME', $dbuser['User']['username']);
                    $this->Session->write(md5(SITE_TITLE) . 'USEREMAIL', $dbuser['User']['email']);
                    $this->Session->write(md5(SITE_TITLE) . 'USERTYPE', $dbuser['User']['user_type']);

                    $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                }
                else
                {
                    $error_array['err_nomatch'] = CORRECT_INFO;
                }
            }
            $this->set('error_array', $error_array);
        }
    }

    //function for registration page
    function registration() {

        $this->layout = 'default';
        if ($this->Session->check(md5(SITE_TITLE) . 'USERID') == true) {
            //$this->Session->setFlash('The URL you\'ve followed requires you login.');
            //$this->redirect(DEFAULT_URL);
            $this->redirect(DEFAULT_URL . 'users/dashboard');
            exit();
        }

         if (!empty($this->data)) {

            $errorarray = array();
            $errorarray = $this->register_validate($this->data,'registration');
            $this->set('errorarray',$errorarray);

//            $this->pre($errorarray);
//            exit;

            if(empty($errorarray))
            {

                $this->request->data['User']['user_type'] = 'user';
                $this->request->data['User']['password'] = md5($this->data['User']['newpwd']);
                $this->request->data['User']['encrypt_password'] = $this->encrypt_pass($this->data['User']['newpwd']);
                $this->request->data['User']['status'] = '0';
                $this->request->data['User']['created_date'] = date('Y-m-d H:i:s', time());
                $this->request->data['User']['modified_date'] = date('Y-m-d H:i:s', time());

                unset($this->request->data['User']['newpwd']);
                unset($this->request->data['User']['confirmpwd']);
                $this->User->save($this->data['User']);

                $this->redirect(DEFAULT_URL . 'users/registration/'.SUCADD);

//                $this->pre($this->data);
//                exit;
            }

         }
    }

    //function for logout and clear session value
    function logout() {

        $this->Session->delete(md5(SITE_TITLE) . 'USERID');
        $this->Session->delete(md5(SITE_TITLE) . 'USERNAME');
        $this->Session->delete(md5(SITE_TITLE) . 'USEREMAIL');
        $this->Session->delete(md5(SITE_TITLE) . 'USERTYPE');
        $this->redirect(DEFAULT_URL);
    }

    //Function for editprofile
    function editprofile() {

        $this->layout = 'default';
        $this->checklogin();

        $id = $this->Session->read(md5(SITE_TITLE) . 'USERID');

        /* */
        if (!empty($this->data)) {

            $errorarray = array();
            $errorarray = $this->user_validate($this->data,'profile');

            /* */
            if(isset($_FILES['imagename']['name']) && $_FILES['imagename']['name']!='') {

                if($_FILES['imagename']['error']!=0)
                {
                    $errorarray['filecorrupt'] = IMAGECORRUPT;
                }
                else
                {
                    $uploaddir = SITE_ROOT_IMAGE.'uploads/user_images/';
                    $time = time();
                    $new_file_name = preg_replace('/[^a-zA-Z0-9.]/','',basename($_FILES['imagename']['name']));
                    $orignal_scanned_name = basename($_FILES['imagename']['name']);
                    $remote_file_name = strtolower($time.$new_file_name);

                    //for get file extension
                    $fileext = pathinfo($remote_file_name, PATHINFO_EXTENSION);
                    $allow_valid_file = array('jpg','jpeg','png');    //allowed valid images

                    if(!in_array($fileext,$allow_valid_file))
                    {
                        $errorarray['validfile'] = VALIDIMAGETYPE;
                    }
                    else
                    {
                        $uploadfile = $uploaddir .$remote_file_name;
                        $file_size = filesize($_FILES['imagename']['tmp_name']);

                        if($file_size > IMAGE_SIZE_2)
                        {
                            $errorarray['invalidsize'] = INVALIDSIZEIMAGE_2MB;
                        }
                        else
                        {
                            //remove old image
                            if(isset($this->data['User']['oldimagename']) && $this->data['User']['oldimagename']!='')
                            {

                                if(file_exists(UPLOAD_FOLDER.'user_images/'.$this->data['User']['oldimagename']))
                                    unlink(UPLOAD_FOLDER.'user_images/'.$this->data['User']['oldimagename']);
                                if(file_exists(UPLOAD_FOLDER.'user_images/100x100/'.$this->data['User']['oldimagename']))
                                    unlink(UPLOAD_FOLDER.'user_images/100x100/'.$this->data['User']['oldimagename']);
                            }

                            if(move_uploaded_file($_FILES['imagename']['tmp_name'], $uploadfile))
                            {
                                chmod($uploadfile,0777);
                                $resizeObj = new resize_image();

                                //For create image thumb of 100x100
                                $resizedir1 = SITE_ROOT_IMAGE.'uploads/user_images/100x100/';
                                $resizedir1 = $resizedir1 .$remote_file_name;
                                $resizeObj->resize($uploadfile, $resizedir1, '100', '100','100');
                                chmod($resizedir1,0777);

                                $this->request->data['User']['image_name'] = $remote_file_name;
                            }
                        }
                    }
                }
            }
            /* */
//            $this->pre($errorarray);
//            $this->pre($this->data);
//            exit;

            $this->set('errorarray',$errorarray);

            //$this->pre($_FILES);
//            $this->pre($this->data);
//            $this->pre($errorarray);
//            exit;

            if (empty($errorarray)) {

                //Update Session variable
                $this->Session->write(md5(SITE_TITLE) . 'USERNAME', (isset($this->data['User']['name']) && $this->data['User']['name']!='')?$this->data['User']['name']:$this->data['User']['name']);
                $this->Session->write(md5(SITE_TITLE) . 'USEREMAIL', $this->data['User']['email']);

//                $this->pre($this->data);
//                exit;

                $this->request->data['User']['modified_date'] = date('Y-m-d H:i:s', time());
                $this->User->save($this->data['User']);

                $this->redirect(DEFAULT_URL . 'users/editprofile/'.SUCUPDATE);
            }
        }
        /* */
        $this->data = $this->User->find('first', array('conditions' => array('id' => $id)));

//        $this->pre($this->data);
//        exit;
    }

    //function for change password functionality
    function change_password() {

        $this->layout = 'default';

        $this->checklogin();

//        echo '    e10adc39491e240';
//        echo "<br>".$new = $this->encrypt_data(123456);
//        echo "<br>old  ".$old = $this->decrypt_data($new);

        if(!empty($this->data))
        {
            //$this->pre($this->data);
            //exit;

            $errorarray = array();

            if (isset($this->data['User']['oldpwd']) && (trim($this->data['User']['oldpwd']) == '' || trim($this->data['User']['oldpwd']=='Password'))) {
                $errorarray['enter_oldpwd'] = ENTER_OLD_PASSWORD;
            }
            else
            {
                $check_len_pass = strlen(trim($this->data['User']['oldpwd']));

                if($check_len_pass<5)
                    $errorarray['oldpwd_minlen'] = PASSWORD_LENGTH;
                else
                {
                    $check_user = $this->User->find('first', array('conditions' => array('status' => 0, 'password'=>md5($this->data['User']['oldpwd']) ,'id'=>$this->Session->read(md5(SITE_TITLE).'USERID'))));

//                    $this->pre($check_user);
//                    exit;
                    if(empty($check_user))
                    {
                        $errorarray['pass_not_match'] = OLDNOTMATCH;
                    }
                }
            }

            if (isset($this->data['User']['newpwd']) && (trim($this->data['User']['newpwd']) == '' || trim($this->data['User']['newpwd']=='Password'))) {
                $errorarray['newpass'] = ENTER_NEW_PASSWORD;
            }
            else
            {
                $check_len_pass = strlen(trim($this->data['User']['newpwd']));

                if($check_len_pass<5)
                    $errorarray['newpass_minlen'] = NEW_PASSWORD_LENGTH;
            }
            if (isset($this->data['User']['confirmpwd']) && (trim($this->data['User']['confirmpwd']) == '' || trim($this->data['User']['confirmpwd']) == 'Password')) {
                $errorarray['confpass'] = ENTER_CONFPASS;
            }
            else
            {
                $check_len_confpass = strlen(trim($this->data['User']['confirmpwd']));

                if($check_len_confpass<5)
                    $errorarray['confpass_minlen'] = CONF_PASSWORD_LENGTH;
            }

            if (trim($this->data['User']['newpwd']) != '' && trim($this->data['User']['confirmpwd']) != '' && strlen(trim($this->data['User']['newpwd']))>=5 && strlen(trim($this->data['User']['confirmpwd']))>=5 && trim($this->data['User']['newpwd']) != trim($this->data['User']['confirmpwd'])) {
                $errorarray['conflict'] = NEWCONFPASS;
            }


            $this->set('errorarray',$errorarray);

            if(empty($errorarray))
            {
//                $this->pre($errorarray);
//                exit;

                $update_user_dtl['User']['id'] = $this->Session->read(md5(SITE_TITLE).'USERID');
                $update_user_dtl['User']['password'] = md5($this->data['User']['newpwd']);
                $update_user_dtl['User']['encrypt_password'] = $this->encrypt_pass($this->data['User']['newpwd']);

                //$this->pre($this->Session->read());

                $name = $this->Session->read(md5(SITE_TITLE).'USERNAME');
                $email = $this->Session->read(md5(SITE_TITLE).'USEREMAIL');
                $new_pass = $this->data['User']['newpwd'];

                //$this->email_client_changepassword($name,$email,$new_pass);
//                $this->pre($update_user_dtl);
//                exit;

                $this->User->save($update_user_dtl);
                $this->redirect(DEFAULT_URL . 'users/change_password/succhange');
            }
//            $this->pre($errorarray);
//            exit;
        }
    }

    //function for forgot password functionality
    function forgot_password() {

        $this->layout = 'default';

        if(!empty($this->data))
        {


            $errorarray = array();
            if (isset($this->data['User']['email']) && (trim($this->data['User']['email']) == '' || trim($this->data['User']['email'])=='Type here')) {
                $errorarray['enter_email'] = ENTER_EMAIL;
            }
            else
            {
                // For check valid email or not
                if($this->IsEmail($this->data['User']['email'])==0)
                    $errorarray['valid_email'] = ENTER_VALIDEMAIL;
                else
                {
                    $check_email = $this->User->find('all', array('conditions' => array('email like'=>$this->data['User']['email'],'user_type like'=>'user','status LIKE'=>0)));

                    if(empty($check_email))
                    {
                        $errorarray['email_not_match'] = EMAIL_NOTFOUND;
                    }
                }
            }

            $this->set('errorarray',$errorarray);

            if(empty($errorarray))
            {
                $new_pass = $this->generatePassword(PASSWORD_LIMIT);

                $name = trim($check_email[0]['User']['name']);
                $email = trim($check_email[0]['User']['email']);

                //$this->email_client_forgetpass($name,$email,$new_pass);

                $update_user['User']['password'] = md5($new_pass);
                $update_user['User']['encrypt_password'] = $this->encrypt_pass($new_pass);
                $update_user['User']['id'] = $check_email[0]['User']['id'];

//                $this->pre($update_user);
//                $this->pre($this->data);
//                exit;

                $this->User->save($update_user);
                //$this->redirect(DEFAULT_URL . 'users/forgot_password/succhange');
            }
        }
    }

    //function for check validation for registration page
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

    //function for check validation for edit profile page
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

        /* *
        if (isset($userdata['User']['password']) && trim($userdata['User']['password']) != '') {

            //Check with old password
            $check_pass = $this->User->find('all', array('conditions' => array('id' => $userdata['User']['id'], 'encrypt_password like'=>$this->encrypt_pass($userdata['User']['password']))));

            pre($check_pass);
            exit;
            if(!empty($check_pass))
            {

            }
        }

        echo $this->element('sql_dump');

        echo 'encrypt '.$de = $this->encrypt_pass($userdata['User']['password']);
        echo '<br>';
        echo 'decrypt '.$this->decrypt_pass($de);

        echo $pageaction;
        $this->pre($errorarray);
        exit;
        /* */

        /* *
        if (isset($userdata['User']['mobile']) && trim($userdata['User']['mobile']) == '') {
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

        if (isset($userdata['User']['phone']) && trim($userdata['User']['phone']) != '') {
            if($this->check_int($userdata['User']['phone'])==1)
                $errorarray['numeric_phone'] = ENTER_NUMERIC_PHONE;
            else if(strlen($userdata['User']['phone'])<10)
                $errorarray['phone_length'] = PHONE_LENGTH;
        }
        /* */

        /* *
        if($pageaction!='profile')
        {
            if($pageaction=='add')
            {
                if (isset($userdata['User']['newpwd']) && trim($userdata['User']['newpwd']) == '') {
                    $errorarray['newpass'] = ENTER_PASSWORD;
                }
                else
                {
                    $check_len_pass = strlen(trim($userdata['User']['newpwd']));

                    if($check_len_pass<5)
                        $errorarray['newpass_minlen'] = PASSWORD_LENGTH;
                }
                if (isset($userdata['User']['confirmpwd']) && trim($userdata['User']['confirmpwd']) == '') {
                    $errorarray['confpass'] = ENTER_CONFPASS;
                }
                else
                {
                    $check_len_confpass = strlen(trim($userdata['User']['confirmpwd']));

                    if($check_len_confpass<5)
                        $errorarray['confpass_minlen'] = CONF_PASSWORD_LENGTH;
                }
            }
            else if($pageaction=='edit')
            {
                if (trim($userdata['User']['newpwd']) == '' && trim($userdata['User']['confirmpwd']) != '')
                {
                    $errorarray['newpass'] = ENTER_PASSWORD;
                }
                if (trim($userdata['User']['newpwd']) != '' && trim($userdata['User']['confirmpwd']) == '')
                {
                    $errorarray['confpass'] = ENTER_CONFPASS;
                }
                if (trim($userdata['User']['newpwd']) != '' && trim($userdata['User']['confirmpwd']) != '')
                {
                    $check_len_pass = strlen(trim($userdata['User']['newpwd']));

                    if($check_len_pass<5)
                        $errorarray['newpass_minlen'] = PASSWORD_LENGTH;

                    $check_len_confpass = strlen(trim($userdata['User']['confirmpwd']));

                    if($check_len_confpass<5)
                        $errorarray['confpass_minlen'] = CONF_PASSWORD_LENGTH;
                }
            }
            if (trim($userdata['User']['newpwd']) != '' && trim($userdata['User']['confirmpwd']) != ''  && strlen(trim($userdata['User']['newpwd']))>=5 && strlen(trim($userdata['User']['confirmpwd']))>=5 && trim($userdata['User']['newpwd']) != trim($userdata['User']['confirmpwd'])) {
                $errorarray['conflict'] = NEWCONFPASS;
            }
            if (isset($userdata['User']['company_name']) && trim($userdata['User']['company_name']) =='')
                $errorarray['enter_company_name'] = ENTER_COMPANY_NAME;
            else
            {
                if($this->check_hasnumber($userdata['User']['company_name'])==1)
                {
                    $errorarray['company_name_not_numeric'] = ENTER_NUMERIC_COMPANY_NAME;
                }
            }
        }
        /* */

        /* *
        if (trim($userdata['User']['new_password']) != '' && trim($userdata['User']['confirm_password']) != ''  && strlen(trim($userdata['User']['new_password']))>=5 && strlen(trim($userdata['User']['confirm_password']))>=5 && trim($userdata['User']['new_password']) != trim($userdata['User']['confirm_password'])) {
            $errorarray['conflict'] = NEWCONFPASS;
        }
        /* */

        /* *
        if (isset($userdata['User']['company_name']) && trim($userdata['User']['company_name']) =='')
            $errorarray['enter_company_name'] = ENTER_COMPANY_NAME;
        else
        {
            if($this->check_hasnumber($userdata['User']['company_name'])==1)
            {
                $errorarray['company_name_not_numeric'] = ENTER_NUMERIC_COMPANY_NAME;
            }
        }
        /* */

        //$this->pre($userdata);

    }
}