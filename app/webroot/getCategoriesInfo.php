<?php

session_start();
include('function.php');
require_once('constant.php');

//require_once ("config.php");

require_once "vendor/autoload.php";

//define('EBAY_SANDBOX_APPID', 'ChintanS-SeawindS-SBX-b8e35c535-d9f84471');

$responseEncoding = 'XML';   // Format of the response
$categoryID = $_GET['catId'];
$siteId = (int) $_GET['siteId'];
//var_dump($siteId);
$siteLive = (int) $_GET['siteLive'];
//var_dump($siteLive);
if($siteLive){
    $ebay_app_id = EBAY_LIVE_APPID;
    $endpoint = 'http://open.api.ebay.com/Shopping';  // URL to call
} else {
    $ebay_app_id = EBAY_SANDBOX_APPID;
    $endpoint = 'http://open.api.sandbox.ebay.com/Shopping';  // URL to call
}
//$siteID  = 0; //0-US,77-DE

// Construct the FindItems call
$apicall = "$endpoint?callname=GetCategoryInfo"
     . "&appid=$ebay_app_id"
     . "&siteid=$siteId"
     . "&CategoryID=$categoryID"
     . "&version=677"
     . "&responseencoding=$responseEncoding"
     . "&IncludeSelector=ChildCategories";

// Load the call and capture the document returned by the GetCategoryInfo API

$xml = simplexml_load_file($apicall);

$errors = $xml->Errors;
$browse = "";
$i = isset($_GET['counter']) ? $_GET['counter'] + 1 : 0;
//echo $i;

//if there are error nodes
if($errors->count() > 0)
{
    echo '<p><b>eBay returned the following error(s):</b>';
    //display each error
    //Get error code, ShortMesaage and LongMessage
    $code = $errors->ErrorCode;
    $shortMsg = $errors->ShortMessage;
    $longMsg = $errors->LongMessage;
    //Display code and shortmessage
    echo '<p>', $code, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg));
    //if there is a long message (ie ErrorLevel=1), display it
    if(count($longMsg) > 0)
        echo '<br>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg));

}
else //no errors
{
    //if sub-categories found
    if($xml->CategoryArray->Category->LeafCategory=='false'):

        foreach($xml->CategoryArray->Category as $cat){
            if($cat->CategoryID!=$categoryID):
                if($cat->CategoryLevel!=0):
                    $browse.='<option value="'.$cat->CategoryID.'">'.$cat->CategoryName.'</option>';
                endif;
            endif;
        }

        echo '<div class="subcat_'.$i.'">';
        echo '<select size="15" class="columns" id="subcat_'.$i.'">'.$browse.'</select>';
        echo '<script>$("#btn_approve").attr("disabled","disabled"); </script>';
    else: // if no sub-categories found
        $categorypath = str_replace(':', ' > ', $xml->CategoryArray->Category->CategoryNamePath);
        $name =  $xml->CategoryArray->Category->CategoryName;
        $id   = $xml->CategoryArray->Category->CategoryID;
        ?>
        <input type="hidden" name="category" value="<?php echo $id; ?>-<?php echo $name; ?>" />
        <input type="hidden" name="primaryCategory" id="primaryCategory" value="<?php echo $id; ?>" />
        <br>
        <span class="nocategories"><img src="http://pics.ebaystatic.com/aw/pics/icon/iconSuccess_32x32.gif" alt=" ">
              You have selected a category. Click <b>Continue</b>.</span>
        <script type="text/javascript">if($('#primaryCategoryA').val() !== '' && $('#primaryCategoryA').val() !== undefined){$("#btnSaveMapping").removeAttr("disabled","disabled");$("#btnSaveMapping").removeClass("disabled");}</script>
        <script type="text/javascript">$("#btn_approve").removeAttr("disabled","disabled");$("#btn_approve").removeClass("disabled"); $(".ionise").html("<b>Category you have selected:</b><ul><li><?php echo $categorypath ?></li></ul><input type='button' id='remove' value='Remove Selected Category' />")</script>
    <?php
    endif;
}

?>
<script>
$(document).ready(function(){
    <?php $i = isset($_GET['counter']) ? $_GET['counter'] + 1 : 0; ?>
    var counter = <?php echo $i; ?>;
    $('#subcat_'+counter).change(function(){
        var catId = $('#subcat_'+counter).val();
        var siteId = $('#fcat_siteid').val();
        var siteLive = $('#fcat_live').val();
        $.get('<?php echo DEFAULT_URL ?>getCategoriesInfo.php?counter='+counter+'&catId='+catId+'&siteId='+siteId+'&siteLive='+siteLive, function(response,status){
            if(status =='success'){
                //alert(response);
                //$('span.subcat_'+counter).html(response);
                $('div.subcat_'+counter).hide();
                $('div.subcat_'+counter).after(response);
            }
        });
    }); //select onchange
    $('#remove').click(function(){ //alert('response cleared');
        $('.div-scrollbar > span,.ionise').html('');
        $('#ebayCatArea').show();
        $("#btnSaveMapping").attr("disabled","disabled");
        $("#btnSaveMapping").addClass("disabled");
    })
});
</script>

<?php
    if($errors->count() <= 0 && $xml->CategoryArray->Category->LeafCategory=='false') echo '</div>';
?>