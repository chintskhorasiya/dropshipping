<section id="container">
    <!--header start-->
    <?php echo $this->element('header'); ?>
    <!--header end-->

    <!--sidebar start-->
    <?php echo $this->element('sidebar'); ?>
    <!--sidebar end-->
    
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $this->Session->flash('mapping'); ?>
                    <?php
                    $ebay_live = (int) (isset($ebay_settings_data['EbaySettings']['account_type']) ? $ebay_settings_data['EbaySettings']['account_type'] : 0 );
                    ?>
                    <h1>Categories Mapping</h1>
                    <section class="panel">
                        <header class="panel-heading btn-primary"></header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form action="" method="post" name="frm_reprice_setting" id="frm_reprice_setting">
                                    <div class="clear"></div>
                                    <div class="form-group col-md-6 padding-left-o">
                                        <span id="amazon_categories_label"><label>Amazon Categories</label></span>
                                        <?php
                                        $browseA = '';
                                        foreach($root_categories_data as $cateId => $cateName){
                                            $browseA .= '<option value="'.$cateId.'" data-name="'.$cateName.'">'.$cateName.'</option>';
                                        }
                                        ?>
                                        <span id="catePath" style="visibility:hidden;"></span>
                                        <div class="input-group div-scrollbarA" id="aCat">
                                            <div id="catArea">
                                                <select size="15" id="afcat"><?php echo $browseA ?></select>
                                            </div>
                                            <span></span>
                                            <br/>
                                            <div class="row-fluid ioniseA"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-6 padding-left-o">
                                    <span id="ebay_categories_label"><label>Ebay Categories</label></span>
                                    <?php
                                    
                                        $browse = '';
                                        if($ebay_live)
                                        {
                                            $endpoint = 'http://open.api.ebay.com/Shopping';  // URL to call
                                            $ebay_app_id = EBAY_LIVE_APPID;
                                        
                                        }
                                        else
                                        {
                                            $endpoint = 'http://open.api.sandbox.ebay.com/Shopping';  // URL to call
                                            $ebay_app_id = EBAY_SANDBOX_APPID;
                                        }
                                        //var_dump($endpoint);
                                        $responseEncoding = 'XML';   // Format of the response

                                        if(isset($this->params['named']['type']) && $this->params['named']['type']=='amazon-us'){
                                            $siteID  = 0; //0-US,77-DE
                                        } else {
                                            $siteID  = 3; //0-US,77-DE
                                        }

                                        echo '<input type="hidden" name="fcat_siteid" id="fcat_siteid" value="'.$siteID.'">';
                                        echo '<input type="hidden" name="fcat_live" id="fcat_live" value="'.$ebay_live.'">';

                                        // Construct the FindItems call
                                        $apicall = "$endpoint?callname=GetCategoryInfo"
                                             . "&appid=".$ebay_app_id
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
                                            <div id="ebayCatArea">
                                                <select size="15" id="fcat"><?php echo $browse ?></select>
                                            </div>
                                            <span></span>
                                            <br/>
                                            <div class="row-fluid ionise"></div>
                                        </div>

                                    </div>
                                    
                                    <div class="clear"></div>
                                    <input class="btn btn-info disabled" id="btnSaveMapping" type="submit" name="btn_repricing" disabled="disabled" id="btn_repricing" value="Save this mapping" />
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
    <script>
    $(document).ready(function(){
        $('#afcat').change(function(){
            console.log($(this));
            //alert($('#afcat').val());
            var catId = $('#afcat').val();
            var catName = $('option:selected', this).attr('data-name');
            $.get('<?php echo DEFAULT_URL ?>getAwsCategoriesInfo.php?catId='+catId, function(response,status){
                console.log(response);
                if(status=='success'){
                    //console.log(response);
                    $('#catArea').hide();
                    $('.div-scrollbarA > span').html(response);
                    //$('#catArea').html(response);
                    $('#catePath').html(catName);
                }
            });
        }); //select onchange
        $('#fcat').change(function(){
            console.log($(this));
            //alert($('#fcat').val());
            var catId = $('#fcat').val();
            var siteId = $('#fcat_siteid').val();
            var siteLive = $('#fcat_live').val();
            //var catName = $('option:selected', this).attr('data-name');
            $.get('<?php echo DEFAULT_URL ?>getCategoriesInfo.php?catId='+catId+'&siteId='+siteId+'&siteLive='+siteLive, function(response,status){
                console.log(response);
                if(status=='success'){
                    //console.log(response);
                    $('#ebayCatArea').hide();
                    $('.div-scrollbar > span').html(response);
                    //$('#catArea').html(response);
                    //$('#catePath').html(catName);
                }
            });
        }); //select onchange
    });
    </script>
    <!--main content end-->
    <!--right sidebar start-->
    <div class="right-sidebar">
        <div class="search-row">
            <input type="text" placeholder="Search" class="form-control" value="vivek">
        </div>
    </div>
    <!--right sidebar end-->
    <?php echo $this->element('footer'); ?>
</section>