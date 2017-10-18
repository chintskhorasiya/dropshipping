<?php

//Enter your IDs
define("Access_Key_ID", "AKIAIGB7JLIXT4LFE37A");
define("Associate_tag", "7IkMIkKSC2NA63O561hTBEBugLQNpb7ltLiBdFT6");


if(isset($_REQUEST['SearchIndex']))
{
    ItemSearch($_REQUEST['SearchIndex'], $_REQUEST['Keywords']);

    echo "<pre>";
    print_r($_REQUEST);
    echo "</pre>";
}
//




//Set up the operation in the request
function ItemSearch($SearchIndex, $Keywords) {


//Set the values for some of the parameters
    $Operation = "ItemSearch";
    $Version = "2013-08-01";
    $ResponseGroup = "ItemAttributes,Offers";
//User interface provides values
//for $SearchIndex and $Keywords
//Define the request
    $request = "http://webservices.amazon.com/onca/xml"
    . "?Service=AWSECommerceService"
    . "&AssociateTag=" . Associate_tag
    . "&AWSAccessKeyId=" . Access_Key_ID
    . "&Operation=" . $Operation
    . "&Version=" . $Version
    . "&SearchIndex=" . $SearchIndex
    . "&Keywords=" . $Keywords
    . "&Signature="
    . "&ResponseGroup=" . $ResponseGroup;

//    echo $request;
//    exit;

//Catch the response in the $response object
    $response = file_get_contents($request);
    $parsed_xml = simplexml_load_string($response);
    echo "<pre>";
    print_r($parsed_xml, $SearchIndex);
//    printSearchResults($parsed_xml, $SearchIndex);
    echo "</pre>";
}
?>
<table align='left'>
<?php
    print("
      <form name='SearchTerms' action=amazon_new.php method='GET'>
      <tr><td valign='top'>
        <b>Choose a Category</b><br>
          <select name='SearchIndex'>
            <option value='Books'>Books</option>
            <option value='DVD'>DVD</option>
            <option value='Music'>Music</option>
          </select>
      </td></tr>
      <tr><td><b>Enter Keywords</b><br><input type='text' name='Keywords' size='40'/></td></tr>
      <input type='hidden' name='Action' value='Search'>
      <input type='hidden' name='CartId' value=$CartId>
      <input type='hidden' name='HMAC' value=$HMAC>
      <tr align='center'><td><input type='submit'/></td></tr>
      </form> ");
?>
</table>

<?php
/* *
require '/amazon/aws-autoloader.php';

use Aws;

$aws = Aws::factory('/amazon/config.php');

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

$credentials = new Credentials('AKIAIVCCJKIVWX3TVPQA', '0/H2XJOyWJUkhlqdfplJlKCVgLG6noKnU2UG5VWx');

// Instantiate the S3 client with your AWS credentials
$s3Client = S3Client::factory(array(
    'credentials' => $credentials
));
/* */
?>