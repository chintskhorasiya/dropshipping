<section id="container">
    <!--header start-->
    <?php echo $this->element('header'); ?>
    <!--header end-->

    <!--sidebar start-->
    <?php echo $this->element('sidebar'); ?>
    <!--sidebar end-->

    <style>
        #panel-body {
            display: none;
        }
        .images img {
            max-height: 520px;
            max-width: 380px;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function(){
            var description = '';
            description += '<p>'+$('#product_description p').html()+'</p>';
            description += '<ul>'+$('#product_description ul').html()+'</ul>';

            $('#itemDescription').val(description);
        });

        function add_moredata()
        {
            //var last_id = 0;
            var last_div = '';
            var result = '';
            var cnt_repricing = 0;

            if($('#repricing_data').html().trim()!='')
            {
                //alert('if');
                last_div = $('#repricing_data .repricing:last').attr('class');
                result =  last_div.split('repricing remove');
                cnt_repricing = (parseInt(result[1])+1);
            }

            //alert('vivek '+cnt_repricing);

//            alert(cnt_repricing);
            //alert(parseInt(($('.newrepricing').length)-1))
            //$('#plusimage').remove();

            var add_row =  '<div class="repricing remove'+cnt_repricing+'">\
                                <div class="form-group col-md-4 padding-left-o">\
                                    <div class="input-group pull-left" style="width:72%;">\
                                        <input type="text" class="form-control validate required" name="image_name[]" value="<?php //echo $image_set[$i]['LargeImage']['URL'];?>" />\
                                    </div>\
                                    <button type="button" class="btn btn-info pull-left" style="margin:0px 3px" onclick="removebox('+cnt_repricing+')" ><i class="fa fa-times"></i></button>\
                                    <a target="_blank" href="<?php //echo $image_set[$i]['LargeImage']['URL'];?>">View</a>\
                                </div>\
                            </div>';
            $('#repricing_data').append(add_row);
        }

        function removebox(divid)
        {
            $('.remove'+divid).remove();
        }

        $('#title').keyup(updateCount);

        function updateCount()
        {
            var cs = $('#title').val().length;
            $('#titlecnt').text(cs);
        }
    </script>
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    //print_r($_SESSION);
                    if(!empty($_SESSION['error_msg'])){
                        ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error_msg'];unset($_SESSION['error_msg']); ?>
                        </div>
                        <?php
                    }

                    if(!empty($_SESSION['warning_msg'])){
                        ?>
                        <div class="alert alert-warning" style="display: none;">
                            <?php
                            echo $_SESSION['warning_msg'];
                            unset($_SESSION['warning_msg']);
                            ?>
                        </div>
                        <?php
                    }

                    if(!empty($_SESSION['success_msg'])){
                        ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['success_msg'];unset($_SESSION['success_msg']); ?>
                        </div>
                        <?php
                    }
                    ?>
                    <section class="panel">
                        <div class="panel-body" style="height: 420px;overflow: auto;">
                            <h1><?php echo stripslashes($product_data['Product']['title']); ?></h1>

                            <div class="col-md-5">
                                <div class="images"><img src="<?php echo $product_data['Product']['main_image']; ?>" /></div>
                            </div>
                            <div class="col-md-7" id="product_description">
                                <h3>Product Details</h3>
                                <p>
                                    <strong>
                                        <!--                        Capacity: QHD - 128 GB <br/>
                                                                CPU: i5 Processor<br/>-->
                                        <?php
                                        if (isset($product_data['Product']['brand']) && $product_data['Product']['brand'] != '')
                                            echo 'Brand: ' . $product_data['Product']['brand'] . '<br>';
                                        if (isset($product_data['Product']['mpn']) && $product_data['Product']['mpn'] != '')
                                            echo 'MPN: ' . $product_data['Product']['mpn'] . '<br>';
                                        if (isset($product_data['Product']['upc']) && $product_data['Product']['upc'] != '')
                                            echo 'UPC: ' . $product_data['Product']['upc'] . '<br>';
                                        ?>
                                    </strong>
                                </p>
                                <ul>
                                    <?php
                                    $feature_list = json_decode($product_data['Product']['features'], true);


                                    //echo $product_data['Product']['features'];
                                    if (isset($product_data['Product']['features']) && $product_data['Product']['features'] != '') {


                                        if (count($feature_list) > 0) {
                                            for ($i = 0; $i < count($feature_list); $i++) {
                                                echo "<li>" . $feature_list[$i] . "</li>";
                                            }
                                        }
//                                        echo '<pre>';
//                                        print_r($feature_list);
//                                        echo '</pre>';
//                                        exit;
                                    }
                                    ?>
                                    <?php /* * ?>
                                      <li>Screen Size: 12.5 inches</li>
                                      <li>Max Screen Resolution: 2560x1440 pixels</li>
                                      <li>Processor: 2.5 GHz Intel Core i5</li>
                                      <li>RAM: 8 GB</li>
                                      <?php /* */ ?>
                                </ul>
                                <?php /* * ?>
                                  <p>CPU:i5 Processor  |  Capacity:QHD - 128 GB Razer Blade Stealth 12.5"
                                  QHD Ultrabook (7th Generation Intel Core i5, 8GB RAM, 128GB SSD, Windows 10)</p>
                                  <?php /* */ ?>
                            </div>
                        </div>
                    </section>

                    <section class="panel">
                        <div class="panel-body">
                            <div class="position-center">
                                <?php
                                $product_source_id = $product_data['Product']['source_id'];
                                if($product_source_id == "2"){
                                    $curSymbol = "£";
                                } else {
                                    $curSymbol = "$";                                
                                }
                                ?>
                                <form action="<?php echo DEFAULT_URL.'listings/listing_review_approve/' ?>" method="post" enctype="multipart/form-data" id="frmlisting_review" name="frmlisting_review">
                                    <input type="hidden" name="itemDescription" id="itemDescription" value="" />
                                    <div class="clear"></div>
                                    <div class="form-group col-md-12 padding-left-o">
                                        <label>Title</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control validate required" maxlength="80" name="title" id="title" value="<?php echo stripslashes(substr($product_data['Product']['title'],0,80)); ?>" onkeyup="updateCount();" />
                                        </div>
                                        <div class="text-right" ><span id="titlecnt"><?php echo strlen(($product_data['Product']['title']))?> </span> characters of 80 max</div>
                                    </div>
                                    <div class="clear"></div>

                                    <div class="form-group col-md-4 padding-left-o">
                                        <label>Original Price</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo $curSymbol; ?></span><input type="number" disabled class="form-control validate required" name="coupon_name" value="<?php echo ($product_data['Product']['list_amount']/100);?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 padding-left-o">
                                        <label>Margin Added Price</label>
                                        <?php
                                        // [[CUSTOM]]
                                        $min_margin = (float)$source_settings_data['min_margin'];
                                        $marginpercent = (float)$source_settings_data['marginpercent'];
                                        $original_price = $product_data['Product']['list_amount']/100;
                                        //echo '<pre>'; 
                                        //var_dump(json_decode($source_settings_data['reprice_range']));
                                        //echo '</pre>';
                                        /*$repricing_obj = json_decode($source_settings_data['reprice_range']);
                                        $ranges = $repricing_obj->reprice_min_price;

                                        $prev_key = '';
                                        $next_key = '';
                                        foreach($ranges as $range_key => $range_val){

                                            if($original_price > $range_val){
                                                $prev_key = $next_key;
                                                $next_key = $range_key;
                                                
                                                if(!empty($prev_key) && $repricing_obj->reprice_min_price[$prev_key] > $repricing_obj->reprice_min_price[$next_key]){
                                                    $final_range_number = $prev_key;
                                                } else {
                                                    $final_range_number = $next_key;
                                                }
                                                //var_dump($prev_key);
                                                //var_dump($next_key);
                                            }

                                        }

                                        if(!empty($final_range_number)){
                                            //var_dump($final_range_number);
                                            //var_dump($original_price * $repricing_obj->reprice_margin_percentage[$final_range_number]);
                                            $calculated_margin = (( $original_price * $repricing_obj->reprice_margin_percentage[$final_range_number] )/100) + $repricing_obj->reprice_margin_fixed[$final_range_number];
                                            //var_dump($calculated_margin);
                                            //var_dump($min_margin);
                                        }

                                        if(!empty($calculated_margin) || !empty($min_margin)){

                                            if(!empty($calculated_margin) && $calculated_margin > $min_margin){
                                                $final_margin = $calculated_margin;
                                            } else {
                                                $final_margin = $min_margin;
                                            }
                                            //var_dump($final_margin);
                                        
                                        }*/

                                        if(!empty($marginpercent)){
                                            $final_margin = ($original_price * $marginpercent)/100;
                                        }

                                        if(!empty($final_margin)){
                                            $margin_added_price = round($original_price + $final_margin, 2);
                                        } else {
                                            $margin_added_price = round($original_price, 2);
                                        }

                                        //var_dump($margin_added_price);
                                        // [[CUSTOM]]
                                        ?>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo $curSymbol; ?></span><input type="number" disabled class="form-control validate required" name="coupon_name" value="<?php echo $margin_added_price;?>">
                                            <input type="hidden" class="" name="product_price" value="<?php echo $margin_added_price;?>">
                                            <?php
                                            if($product_source_id == "2"){
                                            ?>
                                                
                                                <input type="hidden" name="store_id" id="store_id" value="2" />
                                                <input type="hidden" name="store_country" id="store_country" value="UK" />
                                                <input type="hidden" name="store_currency" id="store_currency" value="EUR" />
                                            <?php
                                            } else {
                                            ?>
                                                <input type="hidden" name="store_id" id="store_id" value="1" />
                                                <input type="hidden" name="store_country" id="store_country" value="US" />
                                                <input type="hidden" name="store_currency" id="store_currency" value="USD" />
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 padding-left-o">
                                        <label>Quantity</label>
                                        <div class="input-group">
                                            <input type="number" disabled class="form-control validate required" name="coupon_name" value="<?php echo $source_settings_data['quantity']; ?>">
                                        </div>
                                        <div class="text-right">Price and quantity are determined by your repricing settings</div>
                                    </div>

                                    <?php /* */ ?>

                                    <script type="text/javascript">
                                    function add_item_specification()
                                    {
                                        //var last_id = 0;
                                        var last_div1 = '';
                                        var result1 = '';
                                        var cnt_speci = 0;

                                        if($('#item_data').html().trim()!='')
                                        {
                                            //alert('if');
                                            last_div1 = $('#item_data .specification:last').attr('class');
                                            result1 =  last_div1.split('specification removespec');
                                            cnt_speci = (parseInt(result1[1])+1);
                                        }

                                        //alert('vivek '+cnt_repricing);

                            //            alert(cnt_repricing);
                                        //alert(parseInt(($('.newrepricing').length)-1))
                                        //$('#plusimage').remove();

                                         var add_spe =  '<div class="specification removespec'+cnt_speci+'">\
                                                    <div class="form-group col-md-6 padding-left-o">\
                                                        <div class="input-group">\
                                                            <input type="text" class="form-control validate required" name="item_key[]" value="">\
                                                        </div>\
                                                    </div>\
                                                    <div class="form-group col-md-6 padding-left-o">\
                                                        <div class="input-group pull-left" style="width: 91%;">\
                                                            <input type="text" class="form-control validate required" name="item_val[]" value="">\
                                                        </div>\
                                                        <button type="button" class="btn btn-info pull-right" onclick="removespec('+cnt_speci+')"><i class="fa fa-times"></i></button>\
                                                    </div>\
                                                </div>';
                                        $('#item_data').append(add_spe);
                                    }

                                    function removespec(divid)
                                    {
                                        $('.removespec'+divid).remove();
                                    }
                                </script>

                                    <div class="col-md-6 padding-left-o">
                                        <label>Item Specifics</label>
                                        <p>Key</p>
                                    </div>
                                    <div class="col-md-6 padding-left-o">
                                        <label> &nbsp;</label>
                                        <p>Value</p>
                                    </div>
                                    <?php
                                    //$image_set = json_decode($product_data['Product']['image_set'],true);
//                                    echo '<pre>';
//                                    print_r($image_set);
//                                    echo '</pre>';
//                                    exit;

                                    if (isset($product_data['Product']['item_specification']) && $product_data['Product']['item_specification'] != '') {

                                        $item_specification = json_decode($product_data['Product']['item_specification'],true);

                                        //var_dump($item_specification);

                                        $cnt=0;
                                        if (count($item_specification) > 0) {

                                            echo '<div id="item_data">';
//                                            for ($i = 0; $i < count($item_specification); $i++) {
                                            foreach ($item_specification as $key=>$value) {

                                                ?>
                                                <div class="specification removespec<?php echo ($cnt);?>">
                                                    <div class="form-group col-md-6 padding-left-o">
                                                        <?php if($key == "Features") $key = "Style"; ?>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control validate required" name="item_key[]" value="<?php echo $key;?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 padding-left-o">
                                                        <div class="input-group pull-left" style="width: 91%;">
                                                            <?php if($key == "Style") {
                                                                $valueArr = explode(" ", $value);
                                                                $value = "";
                                                                foreach($valueArr as $vAkey => $vAvalue){
                                                                    if($vAkey < 4){
                                                                        $value .= $vAvalue." ";
                                                                    }   
                                                                }
                                                            } ?>
                                                            <input type="text" class="form-control validate required" name="item_val[]" value="<?php echo $value;?>">
                                                        </div>
                                                        <button type="button" class="btn btn-info pull-right" onclick="removespec('<?php echo ($cnt);?>')"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <?php
                                                //echo "<li>" . $image_set[$i]['LargeImage'] . "</li>";
                                                $cnt++;
                                            }
                                            echo '</div>';
                                        }
//                                        echo '<pre>';
//                                        print_r($image_set);
//                                        echo '</pre>';
//                                        exit;
                                    }
                                    ?>
                                    <div class="clear"></div>
                                    <div class="form-group col-md-12 padding-left-o">
                                        <button type="button" class="btn btn-info pull-right" onclick="add_item_specification();"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="clear"></div>
                                    <?php /* */ ?>

                                    <?php
                                    $image_set = json_decode($product_data['Product']['image_set'],true);
//                                    echo '<pre>';
//                                    print_r($image_set);
//                                    echo '</pre>';
//                                    exit;

                                    if (isset($product_data['Product']['image_set']) && $product_data['Product']['image_set'] != '') {

                                        $image_set = json_decode($product_data['Product']['image_set'],true);

                                        if (count($image_set) > 0) {

                                            echo '<div id="repricing_data">';
                                            for ($i = 0; $i < count($image_set); $i++) {

                                                if(isset($image_set[$i]['LargeImage']['URL']))
                                                    $image = $image_set[$i]['LargeImage']['URL'];
                                                else
                                                    $image = $image_set[$i]['MediumImage']['URL'];
                                                ?>
                                                <div class="repricing remove<?php echo ($i);?>">
                                                    <div class="form-group col-md-4 padding-left-o">
                                                        <div class="input-group pull-left" style="width:72%;">
                                                            <input type="text" class="form-control validate required" name="image_name[]" value="<?php echo $image_set[$i]['LargeImage']['URL'];?>" />
                                                        </div>
                                                        <button type="button" class="btn btn-info pull-left" style="margin:0px 3px" onclick="removebox('<?php echo ($i);?>')" ><i class="fa fa-times"></i></button>
                                                        <a target="_blank" href="<?php echo $image_set[$i]['LargeImage']['URL'];?>">View</a>
                                                    </div>
                                                </div>
                                                <?php
                                                //echo "<li>" . $image_set[$i]['LargeImage'] . "</li>";
                                            }
                                            echo '</div>';
                                        }
//                                        echo '<pre>';
//                                        print_r($image_set);
//                                        echo '</pre>';
//                                        exit;
                                    }
                                    ?>

                                    <?php /* * ?>

                                    <div class="form-group col-md-4 padding-left-o">
                                        <div class="input-group pull-left" style="width:72%;">
                                            <input type="number" placeholder="https://images-na.ssl-images-amazon.com/images/I/514cS2WNBVL.jpg" class="form-control validate required" name="coupon_name" value="" />
                                        </div>
                                        <button type="button" onClick="return false" class="btn btn-info pull-left" style="margin:0px 3px" data-autoform-field="destination_attributes.variant_specifics"><i class="fa fa-window-close" aria-hidden="true">X</i></button>
                                        <a href="#">View</a>
                                    </div>

                                    <div class="form-group col-md-4 padding-left-o">
                                        <div class="input-group pull-left" style="width:72%;">
                                            <input type="number" placeholder="https://images-na.ssl-images-amazon.com/images/I/514cS2WNBVL.jpg" class="form-control validate required" name="coupon_name" value="" />
                                        </div>
                                        <button type="button" onClick="return false" class="btn btn-info pull-left" style="margin:0px 3px" data-autoform-field="destination_attributes.variant_specifics"><i class="fa fa-window-close" aria-hidden="true">X</i></button>
                                        <a href="#">View</a>
                                    </div>

                                    <div class="form-group col-md-4 padding-left-o">
                                        <div class="input-group pull-left" style="width:72%;">
                                            <input type="number" placeholder="https://images-na.ssl-images-amazon.com/images/I/514cS2WNBVL.jpg" class="form-control validate required" name="coupon_name" value="" />
                                        </div>
                                        <button type="button" onClick="return false" class="btn btn-info pull-left" style="margin:0px 3px" data-autoform-field="destination_attributes.variant_specifics"><i class="fa fa-window-close" aria-hidden="true">X</i></button>
                                        <a href="#">View</a>
                                    </div>

                                    <div class="form-group col-md-4 padding-left-o">
                                        <div class="input-group pull-left" style="width:72%;">
                                            <input type="number" placeholder="https://images-na.ssl-images-amazon.com/images/I/514cS2WNBVL.jpg" class="form-control validate required" name="coupon_name" value="" />
                                        </div>
                                        <button type="button" onClick="return false" class="btn btn-info pull-left" style="margin:0px 3px" data-autoform-field="destination_attributes.variant_specifics"><i class="fa fa-window-close" aria-hidden="true">X</i></button>
                                        <a href="#">View</a>
                                    </div>

                                    <div class="form-group col-md-4 padding-left-o">
                                        <div class="input-group pull-left" style="width:72%;">
                                            <input type="number" placeholder="https://images-na.ssl-images-amazon.com/images/I/514cS2WNBVL.jpg" class="form-control validate required" name="coupon_name" value="" />
                                        </div>
                                        <button type="button" onClick="return false" class="btn btn-info pull-left" style="margin:0px 3px" data-autoform-field="destination_attributes.variant_specifics"><i class="fa fa-window-close" aria-hidden="true">X</i></button>
                                        <a href="#">View</a>
                                    </div>

                                    <div class="form-group col-md-4 padding-left-o">
                                        <div class="input-group pull-left" style="width:72%;">
                                            <input type="number" placeholder="https://images-na.ssl-images-amazon.com/images/I/514cS2WNBVL.jpg" class="form-control validate required" name="coupon_name" value="" />
                                        </div>
                                        <button type="button" onClick="return false" class="btn btn-info pull-left" style="margin:0px 3px" data-autoform-field="destination_attributes.variant_specifics"><i class="fa fa-window-close" aria-hidden="true">X</i></button>
                                        <a href="#">View</a>
                                    </div>
                                    <?php /* */ ?>


                                    <div class="clear"></div>
                                    <div class="form-group col-md-12 padding-left-o">
                                        <button type="button" class="btn btn-info pull-right" onclick="add_moredata();"><i class="fa fa-plus" aria-hidden="true"></i> <b>Image</b></button>
                                    </div>
                                    <br/>
                                    <?php
                                    if( $product_data['Product']['status'] == '1' && !empty($product_data['Product']['ebay_id'])){

                                    } else {
                                        //var_dump($mapped_category);
                                    if(!empty($product_data['Product']['a_cat_id']) && !empty($mapped_category)){
                                        ?>

                                        <br>
                                        <div class="row" style="display: none;">
                                            <div class="col-md-6">Condition</div>
                                            <div class="col-md-6">
                                                <select class="form-control" id="itemCondition" name="itemCondition" title="Condition">
                                                    <option value="1000">New</option>
                                                    <option value="3000">Used</option>
                                                </select>
                                            </div>
                                        </div>

                                        <br><div class="row" style="display: none;">
                                            <div class="col-md-6">Listing Type</div>
                                            <div class="col-md-6">
                                          <select class="form-control" name="listingType">
                                            <option value="FixedPriceItem">Fixed Price Item</option>
                                          </select>
                                        </div>
                                        </div>

                                        <br><div class="row" style="display: none;">
                                          <div class="col-md-6">Listing Duration</div>
                                            <div class="col-md-6">
                                                  <select class="form-control" name="listingDuration">
                                                     <option value="Days_30">30 days</option>
                                                  </select>
                                                </div>

                                        </div>

                                        <div class="form-group col-md-12 padding-left-o">
                                            <input type="hidden" name="asin_no" id="asin_no" value="<?php echo $product_data['Product']['asin_no']; ?>">
                                            <input type="hidden" name="productId" id="productId" value="<?php echo $product_data['Product']['id']; ?>">
                                            <input type="hidden" name="sku" id="sku" value="<?php echo $product_data['Product']['sku']; ?>">
                                            <input type="hidden" name="primaryACategory" id="primaryACategory" value="<?php echo $product_data['Product']['a_cat_id'] ?>">
                                            <input type="hidden" name="return_url" id="return_url" value="<?php echo DEFAULT_URL.'listings/listing_review/'.$product_data['Product']['asin_no']; ?>">
                                            <input class="btn btn-info pull-left" type="submit" name="btn_reject" id="btn_reject" value="Reject" />
                                            <input class="btn btn-info pull-right" type="submit" name="btn_approve" id="btn_approve" value="Approve" />
                                            <?php
                                            if(!empty($product_data['Product']['variations_dimentions']))
                                            {
                                            ?>
                                                <div class="pull-right col-md-3">
                                                    <input type="checkbox" name="withvariation" id="withvariation" value="1">With Variations
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    } else {
                                            //define('EBAY_SANDBOX_APPID', 'ChintanS-SeawindS-SBX-b8e35c535-d9f84471');
                                        
                                            $browse = '';
                                            $endpoint = 'http://open.api.sandbox.ebay.com/Shopping';  // URL to call
                                            $responseEncoding = 'XML';   // Format of the response

                                            $siteID  = 0; //0-US,77-DE

                                            // Construct the FindItems call
                                            $apicall = "$endpoint?callname=GetCategoryInfo"
                                                 . "&appid=".EBAY_SANDBOX_APPID
                                                 . "&siteid=$siteID"
                                                 . "&CategoryID=-1"
                                                 . "&version=677"
                                                 . "&IncludeSelector=ChildCategories";

                                            // Load the call and capture the document returned by the GetCategoryInfo API
                                            $xml = simplexml_load_file($apicall);

                                            $errors = $xml->Errors;

                                            //if there are error nodes
                                            if($errors->count() > 0)
                                            {
                                                echo '<p><b>eBay returned the following error(s):</b></p>';
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
                                                foreach($xml->CategoryArray->Category as $cat){
                                                    if($cat->CategoryLevel!=0):
                                                        $browse.='<option value="'.$cat->CategoryID.'">'.$cat->CategoryName.'</option>';
                                                    endif;
                                                }

                                            }

                                            ?>
                                            <div class="div-scrollbar">
                                                <select size="15" id="fcat"><?php echo $browse ?></select>
                                                <span></span>
                                                <br/>
                                                <div class="row-fluid ionise"></div>
                                            </div>

                                            <br><div class="row" style="display: none;">
                                                <div class="col-md-6">Condition</div>
                                                <div class="col-md-6">
                                                    <select class="form-control" id="itemCondition" name="itemCondition" title="Condition">
                                                        <option value="1000">New</option>
                                                        <option value="3000">Used</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <br><div class="row" style="display: none;">
                                                <div class="col-md-6">Listing Type</div>
                                                <div class="col-md-6">
                                              <select class="form-control" name="listingType">
                                                <option value="FixedPriceItem">Fixed Price Item</option>
                                              </select>
                                            </div>
                                            </div>

                                            <br><div class="row" style="display: none;">
                                              <div class="col-md-6">Listing Duration</div>
                                                <div class="col-md-6">
                                                      <select class="form-control" name="listingDuration">
                                                         <option value="Days_30">30 days</option>
                                                      </select>
                                                    </div>

                                            </div>
                                            <script>
                                            $(document).ready(function(){
                                                $('#fcat').change(function(){
                                                    //alert($('#fcat').val());
                                                    var catId = $('#fcat').val();
                                                    $.get('<?php echo DEFAULT_URL ?>getCategoriesInfo.php?catId='+catId, function(response,status){
                                                        console.log(response);
                                                        if(status=='success'){
                                                            //console.log(response);
                                                            $('.div-scrollbar > span').html(response);
                                                        }
                                                    });
                                                }); //select onchange
                                            });
                                            </script>

                                            <div class="form-group col-md-12 padding-left-o">
                                                <input type="hidden" name="asin_no" id="asin_no" value="<?php echo $product_data['Product']['asin_no']; ?>">
                                                <input type="hidden" name="sku" id="sku" value="<?php echo $product_data['Product']['sku']; ?>">
                                                 <input type="hidden" name="productId" id="productId" value="<?php echo $product_data['Product']['id']; ?>">
                                                <input type="hidden" name="return_url" id="return_url" value="<?php echo DEFAULT_URL.'listings/listing_review/'.$product_data['Product']['asin_no']; ?>">
                                                <input class="btn btn-info pull-left" type="submit" name="btn_reject" id="btn_reject" value="Reject" />
                                                <input class="btn btn-info pull-right disabled" type="submit" name="btn_approve" id="btn_approve" value="Approve" />
                                                <?php
                                                if(!empty($product_data['Product']['variations_dimentions']))
                                                {
                                                ?>
                                                    <div class="pull-right col-md-3">
                                                        <input type="checkbox" name="withvariation" id="withvariation" value="1">With Variations
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        
                                        <?php
                                    }
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
    <!--main content end-->
    <?php echo $this->element('footer'); ?>
</section>