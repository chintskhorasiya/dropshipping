<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    // ,'DebugKit'
    var $helpers = array('Html', 'Form', 'Time', 'Session');
    //var $components = array('Email','Session','Cookie','RequestHandler','DebugKit.Toolbar' => array(/* array of settings */));
    var $components = array('Email', 'Session', 'Cookie', 'RequestHandler');
    var $uses = array('User');

    function beforeFilter() {

        date_default_timezone_set('Asia/Kolkata');
        //echo $today = date("Y-m-d H:i:s");

//        $sendpage = $this->referer();
//        $this->set("sendpage",$sendpage);

//        $this->pre($this->params);
//        exit;

        $this->set_title($this->params['action']);

        $encrypt_id = $this->encrypt_data($this->Session->read(md5(SITE_TITLE) . 'USERID'),ID_LENGTH);
        $this->set('encrypt_id',$encrypt_id);
    }

    function set_title($pagenames) {
        //echo $pagenames;
        $title_arr = array(
            'index'=>'Login',
            'dashboard'=>'Dashboard',
            'editprofile'=>'Edit Profile',
            'change_password'=>'Change Password',
            'source_settings'=>'Source Setting',
            'categories_mapping'=>'Categories Mapping',
            'list_amazon_categories'=>'List Amazon Categories',
            'ebay_settings'=>'Ebay Setting',
            'registration'=>'Registration',
            'forgot_password'=>'Forgot Password',
            'store_setting'=>'Store Setting',
            'store_stat'=>'Store Stat',
            'store_add'=>'Add Store',
            'create_listing'=>'Create Listing',
            'listing_requests'=>'Listing Request',
            'listing_settings'=>'Listing Settings',
            'listing_review'=>'Listing Review',
            'repricing_work'=>'repricing_work',
            'ebay_user_token'=>'Ebay User Token'
        );
//
        //echo $title_arr[$pagenames];
        $this->set('page_title_tag',(isset($title_arr[$pagenames]) && $title_arr[$pagenames]!='')?$title_arr[$pagenames]:'');
    }

    //Function for check admin session
    function checklogin() {
        // if the admin session hasn't been set  3
        if ($this->Session->check(md5(SITE_TITLE) . 'USERID') == false) {
            //$this->Session->setFlash('The URL you\'ve followed requires you login.');
            //$this->redirect(DEFAULT_URL);
            $this->redirect(DEFAULT_URL);
            exit();
        }
    }

    //Function for check admin session
    function checkadminlogin() {
        // if the admin session hasn't been set  3
        if ($this->Session->check(md5(SITE_TITLE) . 'AUSERID') == false) {
            //$this->Session->setFlash('The URL you\'ve followed requires you login.');
            //$this->redirect(DEFAULT_URL);
            $this->redirect(DEFAULT_URL . 'users/index');
            exit();
        }
    }

    //function for add slug for seo friendly
    function _toSlug($string) {
        return strtolower(Inflector::slug($string, '-'));
    }

    //function for add slashed to string
    function addslashes($string) {
        return addslashes(trim($string));
    }

    //function for remove slashed to string
    function stripslashes($string) {
        return stripslashes(trim($string));
    }

    //Function for set date format
    function setdateformat($date, $format) {
        $return_date = date($format, strtotime($date));
        return $return_date;
    }
    //For remove space
    function remove_space($str, $charlist = " \t\n\r\0\x0B") {
        return str_replace(str_split($charlist), '', $str);
    }

    //For compare date
    function greaterdate($start_date, $end_date) {
        $start = strtotime($start_date);
        $end = strtotime($end_date);
        if ($start - $end > 0)
            return 1;
        else
            return 0;
    }

    //For check email validation
    function IsEmail($value, $msg = '') {
        //echo $value = "vivek.acharya@digi-corp.co";
        //$result = ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $value);
        //Changes by vivek for check valid email (1 for valid and 0 for Invalid)
        //Reference site http://www.plus2net.com/php_tutorial/php_email_validation.php
        $result = ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", strtolower(strip_tags($value)));
        if ($result) {
            return 1;
            //For Valid
        } else {
            //For Invalid
            return 0;
        }
    }

    //for generate password
    function generatePassword($length = PASSWORD_LIMIT) {
        // initialize variables
        $password = "";
        $i = 0;
        //$possible = "0123456789bcdfghjkmnpqrstvwxyz";
        $possible = md5(rand(1, 26));
        // add random characters to $password until $length is reached
        while ($i < $length) {
            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            // we don't want this character if it's already in the password
            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }
        return $password;
    }

    //check valid url
    function isValidURL($value, $msg = '') {
        //CHECK All URL FOR TESTING
        //echo $url = "192.168.0.9"; //Not valid
        //echo $url = "ftp://192.168.0.9"; //Not valid
        //echo $url = "192.168.0.9/caps/event.php?action=edit&ids=4&start=1&nstart=1";  //valid
        //echo $url = "www.google.com";
        //echo $url = "http://www.a.a.s/a.zxa";
        //echo $url = "http://sogame.awardspace.com/dummylipsum/"; //valid
        //echo $url = "http://192.168.0.9"; //valid
        //echo $url = "http://test/qq"; //valid
        //echo $url = "http://192.168.0.9/caps/event.php?action=edit&ids=2&start=1&nstart=1"; //valid
        //echo $url = "http://aps/event.php?action=edit&ids=2&start=1&nstart=1"; //valid

        $url = trim($value);

        // SCHEME
        $urlregex = "^(https?|ftp)\:\/\/";

        // USER AND PASS (optional)
        $urlregex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";

        // HOSTNAME OR IP
        //$urlregex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*";  // http://x = allowed (ex. http://localhost, http://routerlogin)
        //$urlregex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)+";  // http://x.x = minimum
        $urlregex .= "([a-z0-9+\$_-]+\.)*[a-z0-9+\$_-]{2,3}";  // http://x.xx(x) = minimum
        //use only one of the above
        // PORT (optional)
        //$urlregex .= "(\:[0-9]{2,5})?";
        // PATH  (optional)
        //$urlregex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
        // GET Query (optional)
        //$urlregex .= "(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?";
        // ANCHOR (optional)
        //$urlregex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
        // check
        if (!eregi($urlregex, $url)) {
            //echo " false";
            return 0;
        } else {
            //echo " true";
            return 1;
        }
    }

    // For remove all files and that directory
    function rrmdir($dir) {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file))
                rrmdir($file);
            else
                unlink($file);
        }
        rmdir($dir);
    }

    //Function for encrypt data
    function encrypt_data($id,$length) {
        return substr(md5($id), 0, $length) . dechex($id);
    }

    //Function for decrypt data
    function decrypt_data($id,$length) {
        $md5_8 = substr($id, 0, $length);
        $real_id = hexdec(substr($id, $length));
        return ($md5_8 == substr(md5($real_id), 0, $length)) ? $real_id : 0;
    }

    //Function for encrypt password
    function encrypt_pass($password) {
        return base64_encode($password);
    }

    //Function for decrypt password
    function decrypt_pass($password) {
        return base64_decode($password);
    }

    // function for set usertype combo
    function set_usertype() {
        $utype = array('superadmin'=> 'Super Admin','admin'=>'Admin','manufacturer'=>'Manufacturer','image-management'=>'Image Management','office-order-management'=>'Office order Management');
        $this->set('user_type',$utype);
        return $utype;
    }

    function pre($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //exit;
    }

    // Function for check only interger value
    function check_int($var) {
        if(preg_match("/^[0-9]+$/",$var))
            return 0;   //Only number
        else
            return 1;   //Not Number
    }

    //function for check string
    function check_hasnumber($str) {
        if (preg_match('#[0-9]#',$str)){
            return 1;   //echo 'has number';
        }else{
            return 0;   //echo 'no number';
        }
    }

    //For delete shopping cart details
    function deletesession() {
        $this->Session->delete("cartarraydata");
    }

    // For send notes email with multiple file attachment
    function mailAttachments($to, $from, $subject, $message, $attachments = array(), $headers = array(), $additional_parameters = '') {
        $headers['From'] = $from;

        // Define the boundray we're going to use to separate our data with.
        $mime_boundary = '==MIME_BOUNDARY_' . md5(time());

        // Define attachment-specific headers
        $headers['MIME-Version'] = '1.0';
        $headers['Content-Type'] = 'multipart/mixed; boundary="' . $mime_boundary . '"';

        // Convert the array of header data into a single string.
        $headers_string = '';
        foreach ($headers as $header_name => $header_value) {
            if (!empty($headers_string)) {
                $headers_string .= "\r\n";
            }
            $headers_string .= $header_name . ': ' . $header_value;
        }

        // Message Body
        $message_string = '--' . $mime_boundary;
        $message_string .= "\r\n";
        $message_string .= 'Content-Type: text/html; charset="iso-8859-1"';
        $message_string .= "\r\n";
        $message_string .= 'Content-Transfer-Encoding: 7bit';
        $message_string .= "\r\n";
        $message_string .= "\r\n";
        $message_string .= $message;
        $message_string .= "\r\n";
        $message_string .= "\r\n";

        // Add attachments to message body
        foreach ($attachments as $local_filename => $attachment_filename) {
            if (is_file($local_filename)) {
                $message_string .= '--' . $mime_boundary;
                $message_string .= "\r\n";
                $message_string .= 'Content-Type: application/octet-stream; name="' . $attachment_filename . '"';
                $message_string .= "\r\n";
                $message_string .= 'Content-Description: ' . $attachment_filename;
                $message_string .= "\r\n";

                $fp = @fopen($local_filename, 'rb'); // Create pointer to file
                $file_size = filesize($local_filename); // Read size of file
                $data = @fread($fp, $file_size); // Read file contents
                $data = chunk_split(base64_encode($data)); // Encode file contents for plain text sending

                $message_string .= 'Content-Disposition: attachment; filename="' . $attachment_filename . '"; size=' . $file_size . ';';
                $message_string .= "\r\n";
                $message_string .= 'Content-Transfer-Encoding: base64';
                $message_string .= "\r\n\r\n";
                $message_string .= $data;
                $message_string .= "\r\n\r\n";
            }
        }

        // Signal end of message
        $message_string .= '--' . $mime_boundary . '--';

        // Send the e-mail.
        return mail($to, $subject, $message_string, $headers_string, $additional_parameters);
    }

    function emailheader() {
        $content = '
                <table width="100%" cellspacing="10" cellpadding="10" style="background:#f8f8f8;" style="font-family:Arial, Helvetica, sans-serif;border:2px solid #ccc;">
                <tr style="background:#fff;border-radius:10px;">
                    <td valign="center"><img src="'.IMAGE_URL.'email_header_part.jpg" alt="'.SITE_TITLE.'" style="margin:0px auto;display:block;width:100%;"/></td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">';
        return $content;
    }

    function emailfooter() {
        $content = '    <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif;color:#333;font-size:12px;">
                                Thanks & Regards,
                                <br/>
                                Mobile No: +91 8488872493
                                <br/>
                                Website :
                                <a href="#" style="color:#01a0e4;text-decoration:none;">www.bhagyagold.com</a>
                                <br/>
                                <br/>
                                Facebook : <a href="#" style="color:#01a0e4;text-decoration:none;" target="_blank">https://www.facebook.com/bhagyagold</a>
                                <br/>
                                Twitter : <a href="#" style="color:#01a0e4;text-decoration:none;" target="_blank">https://twitter.com/bhagyagold</a>
                                <br/>
                                Google Plus : <a href="#" style="color:#01a0e4;text-decoration:none;" target="_blank">https://plus.google.com/bhagyagold</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px; padding-bottom:15px; padding-top:15px; border-top:1px solid #ccc;text-align:center;background:#02a0e7;color:#fff;"> &copy; 2016 <a href="#" style="color:#fff;text-decoration:none;">www.bhagyagold.com</a></td>
                </tr>
            </table>
        </table>';
        return $content;
    }

    //Function for send email to admin when registration
    function email_admin_registration($userpassword) {
        $this->Email->from = trim($this->data['User']['email']);
        $this->Email->to = ADMIN_EMAIL_TO;
        $this->Email->subject = REGISTRATION_ADMIN;
        $this->Email->sendAs = 'html';

//        $this->pre($this->data);
//        exit;

        $content = $this->emailheader();
        $content .= '
                        <tr>
                            <td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear '.trim(ADMIN_EMAIL_NAME).',</p></td>
                        </tr>
                        <tr>
                            <td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:10px; margin:0;">New customer signing up with '.SITE_NAME.'!</p></td>
                        </tr>
                        <tr>
                            <td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;" >Below are customer details.</p></td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>Name:</b> '.trim($this->data['User']['fname']).'</td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>Company Name:</b> '.trim($this->data['User']['company_name']).'</td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>Email:</b> '.trim($this->data['User']['email']).'</td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;padding-bottom:5px; margin:0;"><b>Password:</b> '.trim($userpassword).'</td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;padding-bottom:5px; margin:0;"><b>Mobile:</b> '.trim($this->data['User']['mobile']).'</td>
                        </tr>';

        $content .= $this->emailfooter();

//        echo $content;
//        exit;

        $sendmail = $this->Email->send($content); // if $sendmail=1 then send successfully
        return $sendmail;
    }

    //Function for send email to client when registration
    function email_client_registration($userpassword) {

        $this->Email->from = ADMIN_EMAIL_FROM;
        $this->Email->to = trim($this->data['User']['email']);
        $this->Email->subject = REGISTRATION_CLIENT;
        $this->Email->sendAs = 'html';

        $content = $this->emailheader();
        $content .= '    <tr>
                            <th style="color:#12AFE3; text-align:left; font-size:17px; font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif; padding:10px 0;">Welcome To '.SITE_NAME.'</th>
                        </tr>
                        <tr>
                            <td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear '.trim($this->data['User']['fname']).',</p></td>
                        </tr>
                        <tr>
                            <td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:10px; margin:0;">Thank you for signing up with '.SITE_NAME.'!</p></td>
                        </tr>
                        <tr>
                            <td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;" >Below are your credentials. Please keep this email for future use.</p></td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>Email:</b> '.trim($this->data['User']['email']).'</td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;"><b>Password:</b> '.trim($userpassword).'</td>
                        </tr>';

        $content .= $this->emailfooter();

//        echo $content;
//        exit;

        $sendmail = $this->Email->send($content); // if $sendmail=1 then send successfully
        return $sendmail;
    }

    //Function for forget password
    function email_client_forgetpass($name,$email,$new_pass) {

        $this->Email->from = ADMIN_EMAIL_FROM;
        $this->Email->to = trim($email);
        $this->Email->subject = FORGET_PASSWORD_CLIENT;
        $this->Email->sendAs = 'html';

        $content = $this->emailheader();
        $content .= '
                        <tr>
                            <td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear '.$name.',</p></td>
                        </tr>
                        <tr>
                            <td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:10px; margin:0;">Below are your credentials. Please keep this email for future use.</p></td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>Email:</b> '.trim($email).'</td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;"><b>Password:</b> '.trim($new_pass).'</td>
                        </tr>';

        $content .= $this->emailfooter();

//        echo $content;
//        exit;

        $sendmail = $this->Email->send($content); // if $sendmail=1 then send successfully
        return $sendmail;
    }

    //Function for forget password
    function email_admin_forgetpass($to, $newpass, $name) {

        $this->Email->from = ADMIN_EMAIL_FROM;
        $this->Email->to = trim($to);
        $this->Email->subject = FORGET_PASSWORD_CLIENT;
        $this->Email->sendAs = 'html';

        $content = $this->emailheader();
        $content .= '
                        <tr>
                            <td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear '.$name.',</p></td>
                        </tr>
                        <tr>
                            <td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:10px; margin:0;">Below are your credentials. Please keep this email for future use.</p></td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>Email:</b> '.trim($to).'</td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;"><b>Password:</b> '.trim($newpass).'</td>
                        </tr>';

        $content .= $this->emailfooter();

//        echo $content;
//        exit;

        $sendmail = $this->Email->send($content); // if $sendmail=1 then send successfully
        return $sendmail;
    }

    //Function for change password
    function email_client_changepassword($name,$email,$new_pass) {

        $this->Email->from = ADMIN_EMAIL_FROM;
        $this->Email->to = trim($email);
        $this->Email->subject = PASSWORD_CHANGE_CLIENT;
        $this->Email->sendAs = 'html';

        //echo 'Name'.$name.' Email '.$email.' new pass '.$new_pass;

        $content = $this->emailheader();
        $content .= '    <tr>
                            <th style="color:#12AFE3; text-align:left; font-size:17px; font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif; padding:10px 0;">Welcome To '.SITE_NAME.'</th>
                        </tr>
                        <tr>
                            <td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear '.trim($name).',</p></td>
                        </tr>
                        <tr>
                            <td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;" >Below are your credentials after change password</p></td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>Email:</b> '.trim($email).'</td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;"><b>Password:</b> '.trim($new_pass).'</td>
                        </tr>';

        $content .= $this->emailfooter();

//        echo $content;
//        exit;

        $sendmail = $this->Email->send($content); // if $sendmail=1 then send successfully
        return $sendmail;
    }
    function check_login_user($userid)
    {
        $session_user_id = $this->Session->read(md5(SITE_TITLE) . 'USERID');
        //echo $userid.' '.$session_user_id;

        if($userid != $session_user_id)
        {
            $this->redirect(DEFAULT_URL . 'users/dashboard');
        }
    }
    function check_url($content)
    {
        $check_url = explode('://',$content);
        if(count($check_url)>1)
        {
            //echo 'Url';
            return 1;
        }
        else
        {
            //echo 'No Url';
            return 0;
        }
    }
    function get_awnid($content)
    {
        $explode_content = explode('dp/',$content);
        $explode_ncontent = explode('/',$explode_content[1]);
        return $awnid = $explode_ncontent[0];
//        echo
//        $this->pre($explode_content);

    }
    
    //function

    function getAncestors($nodeId , $nodeJsonString){
        //var_dump($nodeJsonString);
        //echo "<br>";
        $nodeJsonString .= ',"parent":'.$nodeId['BrowseNode']['BrowseNodeId'].'},';
        $nodeJsonString .= '{"id":'.$nodeId['BrowseNode']['BrowseNodeId'].',"name":"'.$nodeId['BrowseNode']['Name'].'"';
        if(!empty($nodeId['BrowseNode']['Ancestors']) && is_array($nodeId['BrowseNode']['Ancestors']) && count($nodeId['BrowseNode']['Ancestors']) > 0){
            return $this->getAncestors($nodeId['BrowseNode']['Ancestors'], $nodeJsonString);
        } else {
            $nodeJsonString .= ',"parent":0}]';
            return $nodeJsonString;
        }     
    }


    function import_categories($awsCategories, $sourceid){
        //
        if(is_object($awsCategories[0])){
            $categoriesBunch = $awsCategories;
            //echo '<pre>';
            //print_r($categoriesBunch);
            //echo '</pre>';
            $import_final_result = $this->importCategoriesObjects($categoriesBunch, $sourceid);
        } else {
            foreach ($awsCategories as $categoriesBunch) {
                //echo '<pre>';
                //print_r($categoriesBunch);
                //echo '</pre>';
                $import_final_result = $this->importCategoriesObjects($categoriesBunch, $sourceid);
            }
        }

        if($import_final_result){
            return true;
        } else {
            return false;
        }
    }

    function importCategoriesObjects($objArr, $sourceid){
        
        //$q = "INSERT INTO `categories` ";
        //$fi = '(`id`, `sourceid`, `aid`, `parent`, `name`, `active`, `added`, `modified`) ';
        //$va = 'VALUES ';
        $objCounter = 1;
        $updatedableRecords = array();
        $insertableRecords = 0;
        $catData = array();
        foreach ($objArr as $objArrKey => $objArrValue) {
            if($this->checkIfCategoryExist($objArrValue->id)){
                $updatedableRecords[] = $objArrValue;
            } else {
                
                $catData[$insertableRecords]['Categories']['sourceid'] = $sourceid;
                $catData[$insertableRecords]['Categories']['aid'] = $objArrValue->id;
                $catData[$insertableRecords]['Categories']['parent'] = $objArrValue->parent;
                $catData[$insertableRecords]['Categories']['name'] = $objArrValue->name;
                $catData[$insertableRecords]['Categories']['active'] = 1;
                $catData[$insertableRecords]['Categories']['added'] = time();
                $catData[$insertableRecords]['Categories']['modified'] = "";
                
                $insertableRecords++;
                //if($insertableRecords > 1) $va .= ',';
                //$va .= '("", '.$sourceid.', '.$objArrValue->id.','.$objArrValue->parent.',"'.$objArrValue->name.'", 1, '.time().', "")';
                //if($objCounter < count($objArr)) $va .= ',';
            }
            $objCounter++;
        }

        if($insertableRecords > 0){
            $this->pre($catData);
            $this->loadmodel('Categories');
            if ($this->Categories->saveMany($catData))
            {
                return true;
            }
            else
            {
                return false;
            }
        } else {
            return false;
        }
    }

    function checkIfCategoryExist($awsCateId)
    {
        $this->loadmodel('Categories');
        $numCateData = $this->Categories->find('count',array('conditions' => array('aid' => $awsCateId)));
        if($numCateData > 0){
            return true;
        } else {
            return false;
        }
    }

    function get_asin($amazon_url){
        
        //$reg = '~(?:www\.)?ama?zo?n\.(?:com|ca|co\.uk|co\.jp|de|fr)/(?:exec/obidos/ASIN/|o/|gp/product/|(?:(?:[^"\'/]*)/)?dp/|)([A-Z0-9]{10})(?:(?:/|\?|\#)(?:[^"\'\s]*))?~isx';

        $reg = '~(?:www\.)?ama?zo?n\.(?:com|ca|co\.uk|co\.jp|de|fr)/(?:exec/obidos/ASIN/|o/|gp/product/|gp/offer-listing/|(?:(?:[^"\'/]*)/)?dp/|)([A-Z0-9]{10})(?:(?:/|\?|\#)(?:[^"\'\s]*))?~isx';
        
        $matches = array();
        
        preg_match($reg, $amazon_url, $matches);

        //var_dump($matches);exit;

        if(!empty($matches[1]))
        {
            return $matches[1];
        }
        else
        {
            return false;
        }
    }

    function get_user_token($user_id)
    {
        $this->loadmodel('EbayTokens');

        $check_token_exist = $this->EbayTokens->find('first', array('conditions' => array('user_id'=>$user_id)));

        if(!empty($check_token_exist))
        {
            return $check_token_exist['EbayTokens']['token'];
        }
        else {
            return false;
        }
    }
}
?>