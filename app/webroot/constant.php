<?php
################################################################
# Define constant for Error message (ADMIN SIDE)
################################################################
//Folder Constant
define("SITE_NAME","Dropshipping");
define("SITE_FOLDER","dropshipping");

if(!defined("DEFAULT_URL")) define("DEFAULT_URL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER."/");
define("INCLUDE_SITE_ROOT",$_SERVER["DOCUMENT_ROOT"]."/".SITE_FOLDER."/app/webroot/");
define("SITE_ROOT_IMAGE",$_SERVER["DOCUMENT_ROOT"]."/".SITE_FOLDER."/app/webroot/img/");
define("SITE_URL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER);
define("IMAGE_URL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER."/img/");
define("STATIC_PAGE_URL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER."/static/");

define("UPLOAD_FOLDER",SITE_ROOT_IMAGE."uploads/");
define("DISPLAY_URL_IMAGE",IMAGE_URL."uploads/");

/* For Ckeditor*/
define("CKEDITOR_URL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER."/"."app/webroot/js/ckfinder/userfiles/");
define("CKEDITOR_FOLDER",$_SERVER["DOCUMENT_ROOT"].'/'.SITE_FOLDER."/app/webroot/js/ckfinder/userfiles/");

//Site constant
define("SITE_TITLE",'DMA');
define("SITE_EMAIL","projectdesk@seawindsolution.com");

//Email configuration
define("SITE_TEAM","Dropshipping Team ");

define("ADMIN_EMAIL_NAME","Admin");
define("ADMIN_EMAIL_FROM","admin@seawindsolution.com");
define("ADMIN_EMAIL_TO","projectdesk@seawindsolution.com");
define("SUPPORT_SITE_EMAIL","support@seawindsolution.com");

//Contact us message
define("SUC_SEND_CONTACT","your message send successfully we will contact you soon");

// Registration message
define("SUC_REGISTRATION","User Registration successfully");

/* login page messages */
define("ENTER_USERNAME","Please enter username.");
define("ENTER_EMAIL","Please enter email address.");
define("NOTLOGIN", "Invalid username or password.");
define("EMAIL_NOTFOUND", "Email does not found.");
define("ENTER_VALIDEMAIL", "Please enter valid email");

define("DUPLICATE_USERNAME","Username already exists.");
define("DUPLICATE_EMAIL","Email address already exists.");

/* change password page messages */
define("CURRPASS", "Please enter current password.");
define("NEWPASS", "Please enter password.");
define("CONFPASS", "Please enter confirm password.");
define("PASS_CHANGE", "Password has changed successfully.");
define("FORGOT_PASS_CHANGE", "Your passwrod is sent on your register email.");
define("PASS_CHANGE_CLIENT", "Thank you for your request to reset your password. We have sent you an email for that");

/*Error messages for login page */
define("ERROR_LOGIN","Username or password you entered is incorrect. Please try again.");
define("CORRECT_INFO","Please correct given information");

/* change password page messages */
define("ENTER_OLD_PASSWORD","Please enter old password");
define("ENTER_PASSWORD","Please enter password");
define("ENTER_NEW_PASSWORD","Please enter new password");
define("NEW_PASSWORD_LENGTH","Please new password length atleast 5 character");
define("PASSWORD_LENGTH","Please password length atleast 5 character");
define("OLD_PASSWORD_LENGTH","Please old password length atleast 5 character");
define("CONF_PASSWORD_LENGTH","Please confirm password length atleast 5 character");
define("ENTER_CONFPASS","Please enter confirm password");
define("SUC_CHANGE_PROFILE","Profile changed successfully");
define("EMAIL_OLDPASS_NOTMATCH","Email address and old password does not match");
define("SUC_SAVE_SETTINGS","Settings changed successfully");

/*Error messages for change password page */
define("NEWCONFPASS", "Password and Confirm Password does not match.");
define("OLDNOTMATCH", "Current password does not match with old password.");

//Change email validation
define("ENTER_NEW_EMAIL","Please enter new email address");
define("EMAIL_NOTMATCH","Email address does not match");
define("EMAIL_PASS_NOMATCH","Email address and password does not match");
define("EMAIL_SUC_CHANGE","Email address change successfully");

/* Common messages */
define("SUCCHANGE","succhange");
define("SUCADD","sucadd");
define("SUCUPDATE","sucup");
define("SUCACTIVE","sucactive");
define("SUCINACTIVE","sucinactive");
define("SUCDELETE","sucdel");
define("NOTDELETE","notdel");

define("ACTIVE","Active");
define("INACTIVE","Inactive");
define("EXISTS","exists");
define("ACTIVATE","Activate");
define("DEACTIVATE","Deactivate");

define("REQUIREFIELD","Mandatory fields are required");

//Common Message
define('RECORDADD',"Record added successfully.");
define('RECORDUPDATE',"Record updated successfully.");
define('RECORDDELETE',"Record deleted successfully.");
define('RECORDACTIVE',"Record activated successfully.");
define('RECORBLOCKED',"Record blocked successfully.");
define('RECORDINACTIVE',"Record inactivated successfully.");
define('RECORDDEACTIVE',"Record deactivated successfully.");
define('RECORDPROPERTY',"Property type changed successfully.");
define("RECOPENDING","Record pending successfully");
define("RECOINPROCESS","Record inprocess successfully");
define('RECORDAPPROVE',"Record approved successfully.");
define('RECORDUNAPPROVE',"Record unapproved successfully.");
define("RECORD_NOTFOUND","Record not found.");

// User page Messge
define('USERINFOUPDATE',"User information updated successfully.");
define("ENTER_FNAME","Please enter first name");
define("ENTER_LNAME","Please enter last name");
define("ENTER_PHONE","Please enter phone");
define("ENTER_ADDRESS","Please enter address");
define("ENTER_MOBILE","Please enter mobile number");
define("USER_TYPE","Please select user type");
define("ENTER_DESC","Please enter description");
define("ENTER_MESSAGE","Please enter message");
define("ENTER_CITY","Please enter city");

define("FNAME_HAS_NUM","Please enter only character in first name");
define("LNAME_HAS_NUM","Please enter only character in last name");
define("NAME_HAS_NUM","Please enter only character in name");
define("ENTER_NUMERIC_COMPANY_NAME","Please enter only character in company name");
define("MOBILE_LENGTH","Please enter 10 digit in mobile number");
define("PHONE_LENGTH","Please enter minimun 10 digit in contact number");
define("ENTER_NUMERIC_PHONE","Please enter numeric contact number");
define("ENTER_NUMERIC_MOBILE","Please enter numeric mobile number");
define("ENTER_NUMERIC_CITY","Please enter only character in city");

//User image message
define('SELECT_IMAGE','Please select image');
define("IMAGECORRUPT", "Image is corrupted. please upload again.");
define("INVALIDSIZEIMAGE", "Image size should be up to 1MB.");
define("INVALIDSIZEIMAGE_2MB", "Image size should be up to 1MB.");
define("VALIDIMAGETYPE", "Please upload jpg, jpeg file only.");
define("VALID_IMAGETYPE", "Please upload jpg, jpeg, png file only.");

//define("VALIDIMAGETYPE1", "Please upload jpg, jpeg, gif and png file only.");
define("SUGGEST_JPG","(Upload jpg, jpeg file only)");
define("SUGGEST_ALLIMAGE","(Upload jpg, jpeg, gif and png file)");

// Image Notes module
define("BANNER_IMAGE_NOTES","Image size should be 1366x319.");
define("USERADD","User added successfully.");
define("USERUPDATE","User updated successfully.");
define("USERDELETE","User deleted successfully.");

//Cmspage message
define("ENTER_NAME","Please enter name");
define("DUPLICATE_NAME","Name already exists");

//Product page message
define("ENTER_PCODE","Please enter product code");
define("ENTER_WEIGHT","Please enter weight");
define("SELECT_CATEGORY","Please select category");
define("SELECT_SUB_CATEGORY","Please select sub category");
define("CODE_EXISTS","Product code already exists");
define("PRODUCT_NOT_DEL","Product can not delete because Images already exists");
define("ARRIVAL_PRODUCT","Product added in to arrival list");
define("ARRIVAL_DELETE_PRODUCT","Product remove from arrival list");
define("CATALOGUE_PRODUCT","Product added in to catalogue list");
define("CATALOGUE_DELETE_PRODUCT","Product remove from catalogue list");
define("TRENDING_PRODUCT","Product added in to trending list");
define("TRENDING_DELETE_PRODUCT","Product remove from trending list");
define("EXCLUSIVE_PRODUCT","Product added in to exclusive list");
define("EXCLUSIVE_DELETE_PRODUCT","Product remove from exclusive list");
define("ENTER_LINK","Please enter page link");

// For Pagignation
define("PREVIOUS","Prev");
define("NEXT","Next");
define("FIRST","First");
define("LAST","Last");

//For format URL
define("FORMATURL","E.g:http://www.abc.com");


//Date format message
define("DATEFORMAT","%d-%m-%Y %h:%i");
define("DISPLAY_DATEFORMAT","d-M-Y H:i");
define("DATE_FORMAT","d-m-Y");

define("IMAGE_SIZE_2","2097152");       //1024*1024*2 = 2097152 For 2MB
define("IMAGE_SIZE_1","1048576");       //1024*1024*1 = 1048576 For 1MB

//Page limit constant
define("ADMINUSER_LIMIT","10");
define("ADMINCMS_LIMIT","10");

define("PASSWORD_LIMIT",'5');
if(!defined("ID_LENGTH")) define("ID_LENGTH",'20');   //For encryption data

//Footer constant
define('FOOTER_LEFT','&copy '.date('Y').' Dropshipping. All rights reserved');

//cart message
define('QTY_ERROR','Please enter more then zero(0) in Quantity');

//Mail subject
define('REGISTRATION_CLIENT','Thank you for registration with '.SITE_NAME);
define('REGISTRATION_ADMIN','New customer register with '.SITE_NAME);
define('FORGET_PASSWORD_CLIENT','Password Recovery with '.SITE_NAME);
define('PASSWORD_CHANGE_CLIENT','Password change with '.SITE_NAME);

//Product imaege size
define('PRO_HEIGHT','150');
define('PRO_WIDTH','150');
define('PRO_IMAGE_FOLDER','product_images');
define('PRODUCT_EXISTS','Product already exists');

//amazon sandbox details
if(!defined('AWS_API_KEY')) define('AWS_API_KEY', 'AKIAJL5OCKUJ5TXWF47Q');
if(!defined('AWS_API_SECRET_KEY')) define('AWS_API_SECRET_KEY', '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');
//if(!defined('AWS_ASSOCIATE_TAG')) define('AWS_ASSOCIATE_TAG', 'shoes');
if(!defined('AWS_ASSOCIATE_TAG')) define('AWS_ASSOCIATE_TAG', 'dropshipping7-20');
if(!defined('AWS_ANOTHER_ASSOCIATE_TAG')) define('AWS_ANOTHER_ASSOCIATE_TAG', '');

//ebay sandbox details
define('EBAY_SANDBOX_APPID', 'ChintanS-SeawindS-SBX-b8e35c535-d9f84471');
define('EBAY_SANDBOX_DEVID', '9bf14242-8230-46b5-94d6-0fe9753c9ae6');
define('EBAY_SANDBOX_CERTID', 'SBX-8e35c535c63f-fe2e-47f1-95f7-a42b');
define('EBAY_SANDBOX_AUTHTOKEN', 'AgAAAA**AQAAAA**aAAAAA**kO3FWQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GkAZKHpw+dj6x9nY+seQ**4k8EAA**AAMAAA**uOfM8bJjskwenoxAKa09bxp8OTg1rjxnsx18HfixPQB3ecvorvw7LAPYKjfEreSywQw1aEkDy/uMVAwhvp3MJqix5v0WSz+vyIzTkM8iEII6ca7Nb4LaY9z4wKTwo++gjBw0Q6hN3pATsZotSU8hntoHkhPgfrMNUYmMpX42rua+3BsaeQNuXNmDQgrjU7LlIQgK5PCJfHAxurg+UUcS+oioyaf51BwgCiTgLk9R+zN3L7gJoUjI3syJVl7AAz5yb8ZxttczsNwsIkfkrUaDsOi78YQVvTCZBR6FUiEbgRdu+EzFsb/TDu/OmCIZ7OmWSjGHifD5mqZ85ioPxEqGCQWyRCeR5WCUHCUb/NB9jzuPqYQUeVp5XX40owHYrSA/cXbw79s1D8uvEKB6lwNM8j4pkccsQ4+VkGHvD9/1YHee2xr9ySaJj96itwbJex6ELYDBwczyIdhmezAcbLJ1fbqRZrvMvLTyAHKUX/HYgNDB0hCzh07caR0e9dDnpzMJ5hN09OYq+rl/OxnaJqxxGID50kZWClk75AGBBOoHiKoj7pLF53HV+EsazicMxtxAc6lShy2+Smq6QGWNiUSq81EcKRsuU9M51zFR00rIy6CmUeFSBNuKinPOKu4NYN/MBVBk0DZxdXeZOnuUXijh8Qtv2ChU5k4O/7H/oydH4GPAMRNh0Z6nWWnUxCdHOo0FfFPNs8EcROGPbGq7XSnv52noB93pPPXzg/flxvXBPd60UpbvrBGrf3Y3Aa1CX45F');


define('EBAY_LIVE_APPID', 'seawind-SeawindS-PRD-e5d74fc8f-0ebf2af9');
define('EBAY_LIVE_DEVID', '9bf14242-8230-46b5-94d6-0fe9753c9ae6');
define('EBAY_LIVE_CERTID', 'PRD-5d74fc8f0fa7-a15b-47bd-905f-0975');
/*define('EBAY_LIVE_AUTHTOKEN', 'AgAAAA**AQAAAA**aAAAAA**TyD0WQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wHkIqhCJaLpw+dj6x9nY+seQ**0PcDAA**AAMAAA**2c+oj67H+/EsR8DmQtXlCIQXvRVXBqw/qQ3RiTj1+7He0fsJfQaDx3evyyulVU6VjDKWMTEeReYkrdrW1qDykrRlScktSWyUl6XRXbnXjOysrOE5XDBhnyEaCKfAXJOpcwFIAUOOls0zI4E8e2VGlhYlkJH1s/X1EAtiIFGuH7t4eFmLtsGxAV2hgADYp1BGBLlOF26ZChVRuJmVuUJSZYw57Rs2rqPgxGEk7GA8gA/7T+0iyBzX4SIae086aqPBFjGJesg38FH/HoosRcR7jaZx61KbOh/yGnU3dFUmpRUIJzO6K29JtLUx0trArMfaHFBprp2QCnlORb1jZBOMM38cUPgROZjrIpKQSqxW+bQSPRwaJ2PkiTtSoReAdb02lkEPWJ3KpcplogWK56F2BkR6RR4Dsp8ihA0AwX57zqqPQqTffWmPwyyAD2rMwn8l8ZU9Xgc45IUYrkhQN8jsdUY/uxnvUaHJhZwYS/peSGRBVBVZWhdgk88/yr54BPsoeIs3yh5r80+pCD0dz90Si7iYEii5GfRAFNMVJpMaDBRmXe1jCZDh1/uORCBcW6yUuG5MtTM3z0vM9+DZW5haEBaa6XTk7mPeNjLmVwj02GFo+bL/chS2d7FQwT4R8JVvFDZBqEja99FQYOSoDs7ofJOAsqGcKfARUNC3gSRT9HQ90ONtQTr73vqmhg3GktV5HGqjOkF7DckbC6/lYvvXmV6iDa/3RLhHxrVzHIE6cbviut1KU8DOFmZtzZgERrFY');*/
/*define('EBAY_LIVE_AUTHTOKEN', 'v^1.1#i^1#I^3#f^0#p^3#r^0#t^H4sIAAAAAAAAAOVXW2wUVRju9krFFTWiSKosgzWCmd1zZmZndka6sqUlVHtZu6URCNSzM2fakdmZzZyZlsUQSjWFhACBiC9GLWJIMMaASowaBELEBE3wirdABRNFXgR8UOJ1ZnthW0NLWx42cV8285//9n3/d87MAd2l5Qt6l/b+5veVFfZ1g+5Cnw9OB+WlJQ/eUlQ4u6QA5Dj4+rrv6y7uKTq/kKCUnpaaMUmbBsGBtSndIFLWWEU5liGZiGhEMlAKE8mWpUSsoV5igkBKW6ZtyqZOBepqqihG5BkIZU4U1LDKC7xrNYZytphVFM/JShgyioiTsgxY1V0nxMF1BrGRYbvxAAo0BDQTaYFQgpzEwmCYE1dQgVZsEc00XJcgoKLZdqVsrJXT69itIkKwZbtJqGhdbEmiKVZXU9vYsjCUkys6yEPCRrZDRj4tNhUcaEW6g8cuQ7LeUsKRZUwIFYoOVBiZVIoNNTOJ9rNUK1gQGBYqQImEEcPhG0LlEtNKIXvsPjyLptBq1lXChq3ZmfEYddlIPolle/Cp0U1RVxPw/h5zkK6pGraqqNrq2PJlidpmKpCIxy2zU1Ow4iFlQQQAXuRZKoqSDgQOGawwkGaQ31ElFpuGonlskUCjaVdjt108mhSQQ4rr1GQ0WTHV9lrJ9WOHyeNXeNMcGJ9jdxjeQHHKZSCQfRyf+iEtXJ3+jVIDlpHCKarAsQIvQx5eSw3eXp+IIqLeUGLxeMjrBSdRhk4haw220zqSMS279DopbGmKxIZVho2omFZ4UaU5UVXpZFjhaahiDDBOJmUx8r8Qhm1bWtKx8bA4Ri9k0VVRCdlM47ipa3KGGu2SPWUGpbCWVFEdtp2WQqGurq5gFxs0rfYQAwAMPd5Qn5A7cApRw77a+M60lhWF7J4Yrr9kZ9JuN2tdzbnFjXYqylpKHFl2JoF13TUMKXZEb9HR1muAJB7I/ILnxRM3AUprQU/QQdlMhUzkbmDP1JbtOHA9TiHiEhQc2A5u5qCFkWIaemYywROI0YxOV1SmlRm3oLfXx0owgaJIlk3HsCeDcTB0AhGqo6uarnt7ZzIFc8In0qaB9IytyWS45JSEH0un65T8Ej7BqEszFDox8J+g4801NA4rAqfKEZUGOKkySBWnBFvBnZqM27Q8g244uj4lXDW4M9/GKSZVyDEcQ0cYNvtepzg+GaZFzn3pAhWLQpiVRYT5KeFuaM+3UYo8ECEfEQAA7JSgLdY194RoyeTb+2mpSWysTA2a+2WYX6C8o2bopAEqEmgEw0maE5IKLYKwe/i4cr1eyKMMOd9Z//m2Do281UYLsj/Y4zsIenwH3IsxCIFKOA/MLS1aVlx082yi2TioITVItHbDvaxZOLgGZ9JIswpLfSsr9u9ry7lH960Cs4Zv0uVFcHrOtRpUXF0pgTPu8kMBAiYCIeRYuALMu7paDO8svqP6g/Mt6WfE3j3rfgz/smV+3yu7xOnAP+zk85UUFPf4Cs4crt9WLcU/e2TjIeH9t9a/t33bpq07nY+Ovrp53vkXD6bmFwoXxJf2TWt644BVc9MXc7v/+PifY7c2nhUu+/v6o8ftlc1HHn6tbcOiQ3PWJ+7du+orcctt4eDqQxuWls1ad/dDp/ybdned5P2r9zYfvfLyAxXH2drWY6e1Swn27LM/933/+cZdhy8KTRU7+t/1z55Wc/G02IwX/HXu5OvP9c880bxhx/1PfLLnyM5PS1bvT51KM9I7rU8XV6pXnt/01E9l3/6amIOPrurdOW2GsKzs3KJ+/3cn3iy/6KudWVh07IfNf1+o/H37n8tLOl64p56/VL5I3H2ZMHu+PPPo2xfMb/QPt6+sbGAZ8favA7UD4/sXKwTO+eEQAAA=');*/
define('EBAY_LIVE_AUTHTOKEN', 'AgAAAA**AQAAAA**aAAAAA**5Gz0WQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wHkIqhCJaLpw+dj6x9nY+seQ**0PcDAA**AAMAAA**2c+oj67H+/EsR8DmQtXlCIQXvRVXBqw/qQ3RiTj1+7He0fsJfQaDx3evyyulVU6VjDKWMTEeReYkrdrW1qDykrRlScktSWyUl6XRXbnXjOysrOE5XDBhnyEaCKfAXJOpcwFIAUOOls0zI4E8e2VGlhYlkJH1s/X1EAtiIFGuH7t4eFmLtsGxAV2hgADYp1BGBLlOF26ZChVRuJmVuUJSZYw57Rs2rqPgxGEk7GA8gA/7T+0iyBzX4SIae086aqPBFjGJesg38FH/HoosRcR7jaZx61KbOh/yGnU3dFUmpRUIJzO6K29JtLUx0trArMfaHFBprp2QCnlORb1jZBOMM38cUPgROZjrIpKQSqxW+bQSPRwaJ2PkiTtSoReAdb02lkEPWJ3KpcplogWK56F2BkR6RR4Dsp8ihA0AwX57zqqPQqTffWmPwyyAD2rMwn8l8ZU9Xgc45IUYrkhQN8jsdUY/uxnvUaHJhZwYS/peSGRBVBVZWhdgk88/yr54BPsoeIs3yh5r80+pCD0dz90Si7iYEii5GfRAFNMVJpMaDBRmXe1jCZDh1/uORCBcW6yUuG5MtTM3z0vM9+DZW5haEBaa6XTk7mPeNjLmVwj02GFo+bL/chS2d7FQwT4R8JVvFDZBqEja99FQYOSoDs7ofJOAsqGcKfARUNC3gSRT9HQ90ONtQTr73vqmhg3GktV5HGqjOkF7DckbC6/lYvvXmV6iDa/3RLhHxrVzHIE6cbviut1KU8DOFmZtzZgERrFY');
?>