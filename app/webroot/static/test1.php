<?php
include('amazon/AmazonAPI.php');

$keyId 		= 'AKIAJ3MBW5ZRZYDE25TA';
$secretKey 	= '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';
$associateId	= '';

$amazonAPI = new AmazonAPI( $keyId, $secretKey, $associateId );

$amazonAPI->SetLocale( 'us' );

$amazonAPI->SetSSL( true );

// Search for Harry Potter items in all categories
$items = $amazonAPI->ItemSearch( 'harry potter' );

// Search for Harry Potter items in Books category only
$items = $amazonAPI->ItemSearch( 'harry potter', 'Books' );

pre($items);



function pre($result)
{
    echo "<pre>";
    print_r($result);
    echo "</pre>";
}
?>