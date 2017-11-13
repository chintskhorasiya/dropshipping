<?php
include('function.php');
require_once "vendor/autoload.php";
define('AWS_API_KEY', 'AKIAJL5OCKUJ5TXWF47Q');
define('AWS_API_SECRET_KEY', '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');
//define('AWS_ASSOCIATE_TAG', 'shoes');
define('AWS_ASSOCIATE_TAG', 'dropshipping7-20');
define('AWS_ANOTHER_ASSOCIATE_TAG', '');

$country_cod = 'com';
if(isset($_REQUEST['sourceid']) && $_REQUEST['sourceid']==2)
{
    $country_cod = 'co.uk';
}

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
//use ApaiIO\Operations\Search;

$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

$conf = new GenericConfiguration();
$conf
    ->setCountry($country_cod)
    ->setAccessKey(AWS_API_KEY)
    ->setSecretKey(AWS_API_SECRET_KEY)
    ->setAssociateTag(AWS_ASSOCIATE_TAG)
    ->setRequest($request);
    //->setResponseTransformer(new \ApaiIO\ResponseTransformer\XmlToDomDocument());

$apaiIo = new ApaiIO($conf);

$awnid = $_GET['awnid'];
//pre($_REQUEST);
//pre($apaiIo);
//exit;

//$search = new Search();
//$search->setCategory('All');
////$search->setActor('All');
//$search->setKeywords('shoes');
//$search->setResponseGroup(array('Large'));
//$response = $apaiIo->runOperation($search);

//VariationSummary', 'VariationMatrix', 'VariationMinimum', 'VariationImages', 'VariationOffers'

$lookup = new Lookup();
//$lookup->setIdType('ASIN');
$lookup->setResponseGroup(array('ItemAttributes', 'Offers')); // More detailed information
$lookup->setItemId($awnid);
//$lookup->setAvailability('Available');
$lookup->setOfferListingId('fEN2gU5e6EKZBPj3wRaIUfmkpBKd9CWsRWQjMs8PlDOLOm04fgTyVfG7uS8zNqsowGRgXQox7p%2BIoD6RTp2Di9sMQAVxrBxkfDMvKMjyfnAE4j6C2ImeuPF4kM3n8KGYvSiI991qiQInsLUaAupDDsfQcL8GqWrs');
$lookup->setCondition('All');
$response = $apaiIo->runOperation($lookup);

$response = json_decode (json_encode (simplexml_load_string ($response)), true);

pre($response);
exit;
//pre($response['Items']['Item']['BrowseNodes']['BrowseNode']);exit;

function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
?>