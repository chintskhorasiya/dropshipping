<?php 
ob_start();
/*
Database Fields
*/

if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1'){
	$db_host 	 = 'localhost';
	$db_user 	 = 'root';
	$db_password     = '';
	$db_name 	 = 'dma';
	
	define('SITEURL','http://localhost/dma/');
	define('SITEPATH',$_SERVER['DOCUMENT_ROOT'].'/dma/');
	error_reporting(0);
	// error_reporting(E_ALL & ~E_NOTICE);
	// error_reporting(E_ERROR | E_WARNING | E_PARSE);
}
else
{
	$db_host 	 = 'localhost';
	$db_user 	 = 'projects_dma';
	$db_password     = '+xhL@0(NkJcD';
	$db_name 	 = 'projects_dma';
	
	define('SITEURL','http://projects.seawindsolution.com/dma/');
	define('SITEPATH',$_SERVER['DOCUMENT_ROOT'].'/dma/');
	error_reporting(0);
	// error_reporting(E_ALL & ~E_NOTICE);
}

date_default_timezone_set('Asia/Kolkata');
header('Cache-Control: max-age=900');
define('DOCTYPE','<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
define('XMLNS','<html xmlns="http://www.w3.org/1999/xhtml">');
define('CONTENTTYPE','<meta http-equiv="content-type" content="text/html; charset=utf-8" /><link rel="shortcut icon" href="images/favicon.png" type="image/png-icon">
<link rel="icon" href="images/favicon.png" type="image/x-icon">');
define('SITETITLE','DMA');

//define('ADMINURL','dma');
define('ADMINURL',SITEURL.'');
define('CSSURL',ADMINURL.'css/');
define('JSURL',ADMINURL.'js/');
define('ASSETSURL',ADMINURL.'assets/');
define('IMAGEURL',ADMINURL.'images/');
define('IMAGE_THUMB_URL',IMAGEURL.'thumbs/');
define('CATEGORYURL',SITEURL.'category/');
define('CATEGORY_THUMBURL',SITEURL.'category/thumbs/');
define('PRODUCT_THUMBURL',SITEURL.'products/thumbs/');
define('PRODUCTURL',SITEURL.'products/');
define('ADVT_THUMBURL',SITEURL.'advt/thumbs/');
define('ADVT_URL',SITEURL.'advt/');
define('STOREICON_THUMBURL',SITEURL.'store/thumbs/');
define('STOREICONURL',SITEURL.'store/');
define('STOREUPLOADURL',SITEURL.'store_uploads/');

define('ADMINPATH',SITEPATH.'/');
define('CSSPATH',ADMINPATH.'css/');
define('JSPATH',ADMINPATH.'js/');
define('ASSETSPATH',ADMINPATH.'assets/');
define('IMAGEPATH',ADMINPATH.'images/');
define('IMAGE_THUMB_PATH',ADMINPATH,'images/thumbs/');
define('ADVT_THUMBPATH',SITEPATH.'advt/thumbs/');
define('ADVT_PATH',SITEPATH.'advt/');
define('CATEGORYPATH',SITEPATH.'category/');
define('CATEGORY_THUMBPATH',SITEPATH.'category/thumbs/');
define('PRODUCT_THUMBPATH',SITEPATH.'products/thumbs/');
define('PRODUCTPATH',SITEPATH.'products/');
define('STOREICONPATH',SITEPATH.'store/');
define('STOREICON_THUMBPATH',SITEPATH.'store/thumbs/');
define('STOREUPLOADPATH',SITEPATH.'store_uploads/');
define('SHIPPINGTAX',12.5);
define('CATTAX',5);
/* Labeling */
define('PRODUCT_LABEL','ELALAP');
define('STORE_LABEL','ELALA');
define('ORDER_NUMBER','ELALAO');
define('CUSTOMER_NUMBER','ELALAO');
define('DISTRIBUTOR_NUMBER','ELALAO');
define('B2B_NUMBER','PB2B');

/* End of Labeling*/
$currency_code = "&#8377; ";
$current_date = date('Y-m-d H:i:s');
$date	=	$current_date;
$year	=	date('y', strtotime($date));
$month	=	date('m', strtotime($date));
$hour	=	date('H', strtotime($date));
$minute	=	date('i', strtotime($date));
$sec	=	date('s', strtotime($date));
define('DISTRIBUTOR_PIN','PKDIS'.$month.$year.$hour.$minute.$sec);
// Details for the payment process
define('DISTRIBUTOR_TDS_LIMIT', '5000');
define('DAYSOFPAYMENT', '10'); // No of days to make payment
define('DELHIVERY_TOKEN', '55128ec76703c17fc14a329588781e49c30df508'); // PK key
define('SHIP_ORDERID_SERIAL', 'ELALA');
define('SERVICE_TAX',12.36);
$config_acc_type = array (
 						'1' => 'Saving',
						'2' => 'Current'
				   );
$mfg_type = array (
 						'1' => 'UPC',
						'2' => 'ISBN'
				   );
$config_turnover = array (
                         '1' => 'Under 5 Lacs',
						 '2' => 'Between 5 Lacs and 25 Lacs',
						 '3' => 'Between 25 Lacs and 50 Lacs',
						 '4' => 'Between 50 Lacs and 1 Crore',
						 '5' => 'Above 1 Crore'
				  );
			   
$config_coupon_for = array(
					'1' => 'ALL',
					'2' => 'CATEGORY'
);
$config_coupon_apply_on = array(
					'1' => 'By Percentage of the Original Price',
					'2'	=> 'Fixed Amount Discount For Whole Cart'
);
$config_coupon_type = array(
					'1' => 'Single time use',
					'2' => 'Multiple time use'
);
$ROLES = array(
					'1' => 'Super Admin',
					'2' => 'Admin',
					'3' => 'Production',
					'4' => 'Accountant',
					'5' => 'Store',
					'6' => 'Orders',
					'7' => 'Offers',
					'8' => 'Marketing',
);
$days = array (
                         '1' => 'Sunday',
						 '2' => 'Monday',
						 '3' => 'Tuesday',
						 '4' => 'Wednesday',
						 '5' => 'Thursday',
						 '6' => 'Friday',
						 '7' => 'Saturday'
				  );
								  			
$time	=	array(
						'1' => '1:00',
						'2' => '2:00',
						'3' => '3:00',
						'4' => '4:00',
						'5' => '5:00',
						'6' => '6:00',
						'7' => '7:00',
						'8' => '8:00',
						'9' => '9:00',
						'10' => '10:00',
						'11' => '11:00',
						'12' => '12:00',
						'13' => '13:00',
						'14' => '14:00',
						'15' => '15:00',
						'16' => '16:00',
						'17' => '17:00',
						'18' => '18:00',
						'19' => '19:00',
						'20' => '20:00',
						'21' => '21:00',
						'22' => '22:00',
						'23' => '23:00',
						'24' => '24:00'
);
$config_trade = array (
                         '1' => 'Manufacturer',
						 '2' => 'Importer',
						 '3' => 'Trader',
						 '4' => 'Distributor',
						 '5' => 'Shopkeeper',
						 '6' => 'Others'
				  );		
				  
				  
//payment options
$credit_card_options = array(
							'101' => 'Mastercard Credit Card',
							'102' => 'VISA Credit Card',
							'103' => 'American Express',
							'104' => 'Diners Club Card',
							'105' => 'JCB card',
							'106' => 'Discover'
							);
$debit_card_options = array(
							'201' => 'Mastercard Debit Card issued in India(All Banks)',
							'202' => 'VISA Debit Card issued in India(All Banks)',
							'203' => 'Maestro Debit Card',
							'204' => 'RuPay Debit Card'
							);
$cash_card_options = array(
							'301' => 'ICash Card',
							'302' => 'Itz Cash',
							'303' => 'Pay Cash',
							'304' => 'Oxigen Wallet'
							);
$mobile_payment_options = array(
							'601' => 'State bank of india',
							'602' => 'Paymate'
							);
$emi_payment_option = array(
							'701' => 'Axis Bank',
							'702' => 'ICICI Bank',
							'703' => 'Kotak Mahindra Bank',
							'704' => 'IndusInd Bank'
							);
$emi_interest_option = array(
							'701' => array('3'=>'12','6'=>'12'),
							'702' => array('3'=>'13','6'=>'13','9'=>'13','12'=>'13'),
							'703' => array('3'=>'12','6'=>'12'),
							'704' => array('3'=>'13','6'=>'13','9'=>'13','12'=>'13')
							);
$net_banking_options = array(
							'401' =>'ICICI Bank',
							'402' =>'Bank of India',
							'403' =>'Central Bank of India',
							'404' =>'Federal Bank',
							'405' =>'Indian Overseas Bank',
							'406' =>'United Bank of India',
							'407' =>'Vijaya Bank',
							'408'=>'Deutsche Bank',
							'409'=>'Union Bank Of India',
							'410'=>'IDBI Bank',
							'411'=>'State Bank Of Hyderabad',
							'412'=>'State Bank Of Mysore',
							'413'=>'State Bank Of Bikaner and Jaipur',
							'414'=>'State Bank Of Travancore',
							'415'=>'HDFC Bank',
							'416'=>'Citibank',
							'417'=>'State Bank of India',
							'418'=>'Indian Bank',
							'419'=>'Bank of Maharashtra',
							'420'=>'Corporation Bank',
							'421'=>'Kotak Mahindra Bank',
							'422'=>'Karnataka Bank',
							'423'=>'State Bank of Patiala',
							'424'=>'Bank of Baroda',
							'425'=>'IndusInd Bank',
							'426'=>'ING Vysya Bank',
							'427'=>'Punjab National Bank',
							'428'=>'Andhra bank',
							'429'=>'Bank of Bahrain & Kuwait',
							'430'=>'Canara bank',
							'431'=>'Catholic Syrian Bank',
							'432'=>'City bank',
							'433'=>'Cosmos bank',
							'434'=>'DBS bank',
							'435'=>'Development Credit Bank',
							'436'=>'Dhanlaxmi bank',
							'437'=>'J & K bank',

							'438'=>'KarurVysya Bank Limited',
							'439'=>'Laxmi Vilas Bank',
							'440'=>'Oriental Bank of Commerce',
							'441'=>'Royal Bank of Scotland',
							'442'=>'The ShamraoVithal Co-op Bank Ltd.',
							'443'=>'South Indian Bank',
							'444'=>'Standard Chartered Bank',
							'445'=>'State Bank of Indore',
							'446'=>'Syndicate Bank',
							'447'=>'Tamilnad Mercantile Bank Ltd.',
							'448'=>'The Bank of Rajasthan',

							);						  
$op_product_status_arr = array(
					0=>'In Check Out',
					1=>'Placed',
					2=>'Confirmed',
					3=>'Manifested',
					4=>'Shipped',
					5=>'Transit',
					6=>'Address Not Found',
					7=>'Delivered',
					8=>'Mature',
					9=>'Return',
					10=>'Cancelled',
					11=>'Rejected',
					);
$op_order_status_arr = array(
					1=>'Placed',
					2=>'Confirmed',
					7=>'Delivered',
					8=>'Mature',
					9=>'Return',
					10=>'Cancelled',
					11=>'Rejected',
					);
$order_pay_status_arr = array(
					0=>'Not Process',
					1=>'Process',
					2=>'Order Payment Fail',
					3=>'Order Payment Done',
					);					  
include('functions.php');

$get_adv_setting_data = get_advanced_setting_data();
define('TDS',$get_adv_setting_data[0]['setting_value']);
define('DISTRIBUTOR_REG_DISCOUNT',$get_adv_setting_data[1]['setting_value']);
define('DISTRIBUTOR_REG_AMOUNT',$get_adv_setting_data[2]['setting_value']);

include('adminusers-functions.php');
include('category-functions.php');
include('brand-functions.php');
include('support-functions.php');
include('distributor-functions.php');
include('page-functions.php');
include('country-functions.php');
include('state-functions.php');
include('city-functions.php');
include('advertise-functions.php');
include('products-functions.php');
include('users-functions.php');
include('stores-functions.php');
include('inquiry-functions.php');
include('coupon-functions.php');
include('delivery-functions.php');
include('variation-functions.php');
include('faq-functions.php');
include('reviews-functions.php');
include('orders-functions.php');
include('eGift-functions.php');
include('eWallet-functions.php');
include('notification-functions.php');
include('accounting-shipping.php');
include('customer-support-function.php');
include('footer-functions.php');
include('support-cat-functions.php');
include('report-function.php');
include('shipping-functions.php');
?>