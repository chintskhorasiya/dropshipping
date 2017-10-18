<?php

session_start();
include('function.php');
//require_once('constant.php');

$categoryID = $_GET['catId'];
$siteID  = 0; //0-US,77-DE
$browse = "";
$i = isset($_GET['counter']) ? $_GET['counter'] + 1 : 0;

//var_dump($categoryID);
if($categoryID > 0){
    $subCategories = array();
    $thiscategory = false;
    //echo "Select * from `categories` where parent = (SELECT aid FROM `categories` WHERE `id` = ".$categoryID.")";
    $childResults = mysql_query("Select * from `categories` where parent = (SELECT aid FROM `categories` WHERE `id` = ".$categoryID.") ORDER BY name ASC");
    while($fetchResults = mysql_fetch_object($childResults)) {
        array_push($subCategories, $fetchResults);
    }

    //if(count($subCategories) == 0){
    $thisResults = mysql_query("Select * from `categories` where `id` = ".$categoryID);
    $thiscategory = mysql_fetch_object($thisResults);
    //}
    //var_dump($subCategories);exit;
}

//if sub-categories found
if(count($subCategories) >= 1):

    foreach($subCategories as $cat){
        if($cat->id!=$categoryID):
            $browse.='<option value="'.$cat->id.'" data-name="'.$cat->name.'">'.$cat->name.'</option>';
        endif;
    }
    //if($i > 0){
    //    $backToParentBtn = "<br><input type='button' id='backToParentBtn' value='Back' />";
    //} else {
        $backToParentBtn = "";
    //}

    echo '<div class="subcatA_'.$i.'">';
 
    echo '<select size="15" class="columns" id="subcatA_'.$i.'">'.$browse.'</select>'.$backToParentBtn.'<script>$("#btn_approve").attr("disabled","disabled"); </script>';
    //echo '';
else: // if no sub-categories found
    //$categorypath = str_replace(':', ' > ', $xml->CategoryArray->Category->CategoryNamePath);
    $name =  $thiscategory->name;
    $id   = $thiscategory->id;
    ?>
    <input type="hidden" name="categoryA" value="<?php echo $id; ?>-<?php echo $name; ?>" />
    <input type="hidden" name="primaryCategoryA" id="primaryCategoryA" value="<?php echo $id; ?>" />
    <br>
    <span class="nocategories"><img src="http://pics.ebaystatic.com/aw/pics/icon/iconSuccess_32x32.gif" alt=" ">
          You have selected a category. Click <b>Continue</b>.</span>
    <script type="text/javascript">if($('#primaryCategory').val() !== '' && $('#primaryCategory').val() !== undefined){$("#btnSaveMapping").removeAttr("disabled","disabled");$("#btnSaveMapping").removeClass("disabled");}</script>
    <script>$("#btn_approve").removeAttr("disabled","disabled");$("#btn_approve").removeClass("disabled"); $(".ioniseA").html("<b>Category you have selected:</b><ul><li>"+$("#catePath").html()+"</li></ul><input type='button' id='removeA' value='Remove Selected Category' />")</script>
<?php
endif;

?>
<script>
$(document).ready(function(){
    <?php $i = isset($_GET['counter']) ? $_GET['counter'] + 1 : 0; ?>
    var counter = <?php echo $i; ?>;
    $('#subcatA_'+counter).change(function(){
        var catId = $('#subcatA_'+counter).val();
        var catName = $('option:selected', this).attr('data-name');
        $.get('<?php echo DEFAULT_URL ?>getAwsCategoriesInfo.php?counter='+counter+'&catId='+catId, function(response,status){
            if(status =='success'){
                //alert(response);
                $('#catePath').append(' > '+catName);
                //$('span.subcatA_'+counter).html(response);
                var prevCounter = parseInt(counter)-1;
                $('div.subcatA_'+counter).hide();
                $('div.subcatA_'+counter).after(response);
                //$('#catArea').html(response);
            }
        });
    }); //select onchange
    $('#removeA').click(function(){ //alert('response cleared');
        $('.div-scrollbarA > span,.ioniseA').html('');
        $('#catePath').html('');
        $('#catArea').show();
        $("#btnSaveMapping").attr("disabled","disabled");
        $("#btnSaveMapping").addClass("disabled");
    })
});
</script>

<?php
    if(count($subCategories) >= 1) echo '</div>';
?>