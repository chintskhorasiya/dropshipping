<div class="dfkgjnfkdg"></div>
<div class="dfkgjnfkdg"></div>
<section id="container">
    <!--header start-->
    <?php echo $this->element('header'); ?>
    <!--header end-->

    <!--sidebar start-->
    <?php echo $this->element('sidebar'); ?>
    <!--sidebar end-->
    <script type="text/javascript">
        function add_repricing()
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

            var sourceId = $('#source_id').val();
            if(sourceId == "2"){
                var curSymbol = "£";
            } else {
                var curSymbol = "$";
            }

            var add_row =  '<div class="repricing remove'+cnt_repricing+'" style="width: 100%;">\
                                <div class="clear"></div>\
                                <div class="form-group col-md-3 padding-left-o">\
                                    <div class="input-group">\
                                        <span class="input-group-addon">'+curSymbol+'</span>\
                                        <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_min_price][]" id="reprice_min_price">\
                                    </div>\
                                </div>\
                                <div class="form-group col-md-3">\
                                    <div class="input-group">\
                                        <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_margin_percentage][]" id="reprice_margin_percentage">\
                                        <span class="input-group-addon">%</span>\
                                    </div>\
                                </div>\
                                <div class="form-group col-md-3">\
                                    <div class="input-group">\
                                        <span class="input-group-addon">'+curSymbol+'</span>\
                                        <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_margin_fixed][]" id="reprice_margin_fixed">\
                                    </div>\
                                </div>\
                                <div class="form-group col-md-2">\
                                    <a class="btn btn-sm btn-white" id="minusimage" alt="Remove" onclick="removebox('+cnt_repricing+')">\
                                        <i class="icon-minus text"></i>\
                                        <span class="text">Remove</span>\
                                    </a>\
                                </div>\
                            </div>';
            $('#repricing_data').append(add_row);
        }

        function removebox(divid)
        {
            $('.remove'+divid).remove();
        }
    </script>
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $this->Session->flash('source_setting_save'); ?>
                    <h1>Amazon US Settings</h1>
                    <section class="panel">
                        <header class="panel-heading btn-primary"> Repricing Settings <br/>
                            <a href="<?php echo DEFAULT_URL.'cmspages/repricing_work';?>">How repricing works</a>
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <?php
                                $sourceId = $this->data['SourceSetting']['source_id'];
                                if($sourceId == "2"){
                                    $curSymbol = "£";
                                } else {
                                    $curSymbol = "$";
                                }
                                ?>
                                <form action="" method="post" name="frm_reprice_setting" id="frm_reprice_setting">
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Quantity in stock</label>
                                        <div class="input-group">
                                            <?php echo ($this->Form->text('SourceSetting.quantity', array('type'=>'number', 'id' => 'quantity', 'placeholder' => 'Quantity in stock','class' => 'form-control','style'=>'width:95%;'))); ?><span class="h-tooltip" aria-hidden="true">?</span>
                                        </div>
                                        <div class="tooltip">
                                            <span>When an listing is in stock on Amazon or Walmart, PriceYak will set the quantity on eBay to this number.</span>
                                        </div>

                                        <?php /* * ?>
                                          <input type="checkbox" name="donotshow" id="donotshow" value=""> Do not show
                                        <?php /* */ ?>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Margin Percent</label> <!-- [[CUSTOM]] -->
                                        <div class="input-group">
                                            <?php echo ($this->Form->text('SourceSetting.marginpercent', array('type'=>'number', 'step' => "0.01", 'min' => "0.01", 'max'=> "100.00" ,'id' => 'marginpercent', 'placeholder' => 'Margin in Percent','class' => 'form-control','style'=>'width:95%;'))); ?><span class="h-tooltip" aria-hidden="true">?</span>
                                        </div>
                                        <div class="tooltip">
                                            <span>Tell us what percentage of margin do you want.</span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>SKU Prefix</label> <!-- [[CUSTOM]] -->
                                        <div class="input-group">
                                            <?php echo ($this->Form->text('SourceSetting.skupattern', array('type'=>'text', 'maxlength'=> "3" ,'rule' => 'alphaNumeric', 'id' => 'skupattern', 'placeholder' => 'SKU Prefix Pattern','class' => 'form-control','style'=>'width:95%;'))); ?><span class="h-tooltip" aria-hidden="true">?</span>
                                        </div>
                                        <div class="tooltip">
                                            <span>Tell us what sku pre pattern do you want.</span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-md-6 padding-left-o" style="display:none;">
                                        <label>Minimum Margin</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo $curSymbol; ?></span>
                                            <?php echo ($this->Form->text('SourceSetting.min_margin', array('id' => 'min_margin', 'type'=>'number', 'placeholder' => 'Minimum Margin','class' => 'form-control','style'=>'width:95%;'))); ?><span class="h-tooltip" aria-hidden="true">?</span>
                                        </div>
                                        <?php echo ($this->Form->hidden('SourceSetting.source_id', array('id' => 'source_id', 'type'=>'number', 'placeholder' => 'Source Id','class' => 'form-control','style'=>'width:95%;'))); ?>

                                        <div class="tooltip">
                                            <span>PriceYak will reprice listings to ensure that you receive at least this much profit from each sale.</span>
                                        </div>
                                    </div>
                                    <div class="ranges_hidden" style="display:none;"> <!-- [[CUSTOM]] -->
                                    <div class="clear"></div>
                                    <p>Repricing Ranges</p>
                                    <?php
                                    if(!empty($this->data['SourceSetting']['reprice_range']))
                                    {
//                                        echo count($this->data['SourceSetting']['reprice_range']);
//                                        exit;
                                        for($i=0;$i<count($this->data['SourceSetting']['reprice_range']['reprice_min_price']);$i++)
                                        {
                                            if($i==0)
                                            {?>
                                    <div class="form-group col-md-3 padding-left-o">
                                        <label>Min Price </label> <span class="h-tooltip" aria-hidden="true">?</span>
                                        <div class="tooltip">
                                            <span>The percentage of the Amazon or Walmart source item you wish to make in profit after fees. PriceYak will reprice listings so you receive (margin_percent * amazon_price + margin_fixed) in profit from each sale.</span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo $curSymbol; ?></span>
                                            <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_min_price][]" id="reprice_min_price" value="<?php echo (isset($this->data['SourceSetting']['reprice_range']['reprice_min_price'][$i]) && $this->data['SourceSetting']['reprice_range']['reprice_min_price'][$i]!='')?$this->data['SourceSetting']['reprice_range']['reprice_min_price'][$i]:'' ?>">
                                            <?php //echo ($this->Form->text('SourceSetting.reprice_min_price', array('id' => 'reprice_min_price', 'type'=>'number','class' => 'form-control'))); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Margin Percent </label>
                                        <span class="h-tooltip" aria-hidden="true">?</span>
                                        <div class="tooltip">
                                            <span>The fixed amount you wish to make in profit after fees. PriceYak will reprice listings so you receive (margin_percent * amazon_price + margin_fixed) in profit from each sale.</span>
                                        </div>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_margin_percentage][]" id="reprice_margin_percentage" value="<?php echo (isset($this->data['SourceSetting']['reprice_range']['reprice_margin_percentage'][$i]) && $this->data['SourceSetting']['reprice_range']['reprice_margin_percentage'][$i]!='')?$this->data['SourceSetting']['reprice_range']['reprice_margin_percentage'][$i]:'' ?>">
                                            <?php //echo ($this->Form->text('SourceSetting.reprice_margin_percentage', array('id' => 'reprice_margin_percentage', 'type'=>'number','class' => 'form-control'))); ?>
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Margin Fixed</label>
                                        <span class="h-tooltip" aria-hidden="true">?</span>
                                        <div class="tooltip">
                                            <span>The fixed amount you wish to make in profit after fees. PriceYak will reprice listings so you receive (margin_percent * amazon_price + margin_fixed) in profit from each sale.</span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo $curSymbol; ?></span>
                                            <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_margin_fixed][]" id="reprice_margin_fixed" value="<?php echo (isset($this->data['SourceSetting']['reprice_range']['reprice_margin_fixed'][$i]) && $this->data['SourceSetting']['reprice_range']['reprice_margin_fixed'][$i]!='')?$this->data['SourceSetting']['reprice_range']['reprice_margin_fixed'][$i]:'' ?>">
                                            <?php //echo ($this->Form->text('SourceSetting.reprice_margin_fixed', array('id' => 'reprice_margin_fixed', 'type'=>'number','class' => 'form-control'))); ?>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div id="repricing_data">
                                            <?php
                                            }
                                            else
                                            {
//                                                if($i==1)
//                                                {
//                                                    echo '<div class="clear"></div>
//                                    <div id="repricing_data">';
//                                                }
                                                ?>


                                        <div class="repricing remove<?php echo ($i-1);?>" style="width: 100%;">
                                            <div class="clear"></div>
                                            <div class="form-group col-md-3 padding-left-o">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><?php echo $curSymbol; ?></span>
                                                    <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_min_price][]" id="reprice_min_price" value="<?php echo (isset($this->data['SourceSetting']['reprice_range']['reprice_min_price'][$i]) && $this->data['SourceSetting']['reprice_range']['reprice_min_price'][$i]!='')?$this->data['SourceSetting']['reprice_range']['reprice_min_price'][$i]:'' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_margin_percentage][]" id="reprice_margin_percentage" value="<?php echo (isset($this->data['SourceSetting']['reprice_range']['reprice_margin_percentage'][$i]) && $this->data['SourceSetting']['reprice_range']['reprice_margin_percentage'][$i]!='')?$this->data['SourceSetting']['reprice_range']['reprice_margin_percentage'][$i]:'' ?>">
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><?php echo $curSymbol; ?></span>
                                                    <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_margin_fixed][]" id="reprice_margin_fixed" value="<?php echo (isset($this->data['SourceSetting']['reprice_range']['reprice_margin_fixed'][$i]) && $this->data['SourceSetting']['reprice_range']['reprice_margin_fixed'][$i]!='')?$this->data['SourceSetting']['reprice_range']['reprice_margin_fixed'][$i]:'' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <a class="btn btn-sm btn-white" id="minusimage" alt="Remove" onclick="removebox('<?php echo ($i-1);?>')">
                                                    <i class="icon-minus text"></i>
                                                    <span class="text">Remove</span>
                                                </a>
                                            </div>
                                        </div>

                                            <?php
                                            }
                                            if(($i+1)==count($this->data['SourceSetting']['reprice_range']['reprice_min_price']))
                                            {
                                                echo '</div>';
                                            }

                                        }
                                    }
                                    else
                                    {?>

                                    <div class="form-group col-md-3 padding-left-o">
                                        <label>Min Price </label> <span class="h-tooltip" aria-hidden="true">?</span>
                                        <div class="tooltip">
                                            <span>The percentage of the Amazon or Walmart source item you wish to make in profit after fees. PriceYak will reprice listings so you receive (margin_percent * amazon_price + margin_fixed) in profit from each sale.</span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">£</span>
                                            <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_min_price][]" id="reprice_min_price">
                                            <?php //echo ($this->Form->text('SourceSetting.reprice_min_price', array('id' => 'reprice_min_price', 'type'=>'number','class' => 'form-control'))); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Margin Percent </label>
                                        <span class="h-tooltip" aria-hidden="true">?</span>
                                        <div class="tooltip">
                                            <span>The fixed amount you wish to make in profit after fees. PriceYak will reprice listings so you receive (margin_percent * amazon_price + margin_fixed) in profit from each sale.</span>
                                        </div>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_margin_percentage][]" id="reprice_margin_percentage">
                                            <?php //echo ($this->Form->text('SourceSetting.reprice_margin_percentage', array('id' => 'reprice_margin_percentage', 'type'=>'number','class' => 'form-control'))); ?>
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Margin Fixed</label>
                                        <span class="h-tooltip" aria-hidden="true">?</span>
                                        <div class="tooltip">
                                            <span>The fixed amount you wish to make in profit after fees. PriceYak will reprice listings so you receive (margin_percent * amazon_price + margin_fixed) in profit from each sale.</span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">£</span>
                                            <input type="number" class="form-control" name="data[SourceSetting][reprice_range][reprice_margin_fixed][]" id="reprice_margin_fixed">
                                            <?php //echo ($this->Form->text('SourceSetting.reprice_margin_fixed', array('id' => 'reprice_margin_fixed', 'type'=>'number','class' => 'form-control'))); ?>
                                        </div>
                                    </div>

                                    <div class="clear"></div>
                                    <div id="repricing_data">

                                    </div>
                                    <?php
                                    }?>


                                    <div class="form-group col-md-12">
                                        <a class="btn btn-sm btn-white" id="plusimage" alt="Add New Product" onclick="add_repricing();">
                                            <i class="icon-plus text"></i>
                                            <span class="text">Add More Product</span>
                                        </a>
                                    </div>
                                    <div class="clear"></div>
                                </div> <!-- [[CUSTOM]] -->
                                    <input class="btn btn-info" type="submit" name="btn_repricing" id="btn_repricing" value="Save Repricing Settings" />
                                </form>
                            </div>
                        </div>
                    </section>



                    <?php
                    $ao_fee = (isset($this->data['SourceSetting']['ao_fee']) && $this->data['SourceSetting']['ao_fee']==1)?'checked="checked"':'';
                    $lower_quantity = (isset($this->data['SourceSetting']['lower_quantity']) && $this->data['SourceSetting']['lower_quantity']==1)?'checked="checked"':'';

                    $sold_by_amazon = (isset($this->data['SourceSetting']['sold_by_amazon']) && $this->data['SourceSetting']['sold_by_amazon']==1)?'checked="checked"':'';
                    $fba_offers = (isset($this->data['SourceSetting']['fba_offers']) && $this->data['SourceSetting']['fba_offers']==1)?'checked="checked"':'';
                    $merchant_orders = (isset($this->data['SourceSetting']['merchant_orders']) && $this->data['SourceSetting']['merchant_orders']==1)?'checked="checked"':'';
                    $international_offer = (isset($this->data['SourceSetting']['international_offer']) && $this->data['SourceSetting']['international_offer']==1)?'checked="checked"':'';
                    $prime_offer = (isset($this->data['SourceSetting']['prime_offer']) && $this->data['SourceSetting']['prime_offer']==1)?'checked="checked"':'';
                    $addon_offer = (isset($this->data['SourceSetting']['addon_offer']) && $this->data['SourceSetting']['addon_offer']==1)?'checked="checked"':'';

                    ?>
                    <script>
                        function toggle_visibility(id)
                        {
                            var e = document.getElementById(id);
                            if (e.style.display == 'block')
                                e.style.display = 'none';
                            else
                                e.style.display = 'block';
                        }
                    </script>
                    <style>#panel-body {display:none;}</style>
                    <section class="panel" style="display:none;">
                        <header class="panel-heading btn-primary">
                            <a href="javascript:void(0)" onclick="toggle_visibility('panel-body');"> Show Advanced Repricing Settings </a>
                        </header>
                        <div class="panel-body" id="panel-body">
                            <div class="position-center">
                                <form action="" method="post" name="frm_advance_setting" id="frm_advance_setting">
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Round up prices to end in $0.XX?</label>
                                        <?php echo ($this->Form->text('SourceSetting.round_price', array('id' => 'round_price', 'type'=>'number', 'placeholder' => 'e.g. 99','class' => 'form-control'))); ?>

                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('SourceSetting.ao_fee', array('id'=>'ao_fee', 'type'=>'checkbox','value'=>'1', $ao_fee))); ?>
                                                Include 0.40 AO Fee</label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Fixed Payment fee (usually $0.30 for PayPal)</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">£</span>
                                            <?php echo ($this->Form->text('SourceSetting.fixed_payment_fee', array('id' => 'fixed_payment_fee', 'type'=>'number','class' => 'form-control'))); ?>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Percentage payment fee (usually ~2.9% for PayPal)</label>
                                        <div class="input-group">
                                            <?php echo ($this->Form->text('SourceSetting.percentage_payment_fee', array('id' => 'percentage_payment_fee', 'type'=>'number','class' => 'form-control'))); ?>
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Percentage Marketplace (usually 10% for eBay FVF) </label>
                                        <div class="input-group">
                                            <?php echo ($this->Form->text('SourceSetting.percentage_market_place', array('id' => 'percentage_market_place', 'type'=>'number','class' => 'form-control'))); ?>
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('SourceSetting.lower_quantity', array('id'=>'lower_quantity', 'type'=>'checkbox', 'value'=>'1',$lower_quantity))); ?>
                                                Lower quantity to match source market?
                                            </label>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip">
                                                <span>If the market reports a quantity lower than your "Quantity in stock" value and this is checked, we will use the lower quantity reported by the marketplace."</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <input class="btn btn-info" type="submit" name="btn_advance_setting" id="btn_advance_setting" value="Save Repricing Settings" />
                                </form>
                            </div>
                        </div>
                    </section>

                    <section class="panel" style="display:none;">
                        <header class="panel-heading btn-primary">Offer Selection Settings
                            <span class="h-tooltip" aria-hidden="true">?</span>
                            <div class="tooltip">
                                <span>These settings specify which offers should be considered acceptable. Both repricing and automatic ordering will use the lowest price offer that is considered acceptable under these settings.</span>
                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="" method="post" id="frmoffer_selection" name="frmoffer_selection">
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Maximum handling days</label>
                                        <div class="input-group">
                                            <?php echo ($this->Form->text('SourceSetting.min_handling_day', array('id'=>'min_handling_day', 'type'=>'number', 'class'=>'form-control', 'style'=>'width:95%;'))); ?><span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip"><span>The maximum amount of time it can take for an item to ship.</span></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>

                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Shipping method</label>
                                        <div class="input-group">
                                            <?php if(isset($this->data['SourceSetting']['shipping_method']) && $this->data['SourceSetting']['shipping_method']!=''){$shipping_method = $this->data['SourceSetting']['shipping_method'];}else{$shipping_method='';}?>
                                            <select class="form-control input-lg m-bot15" name="data[SourceSetting][shipping_method]" id="shipping_method" style="width: 95%;">
                                                <option value="0" >(Select One)</option>
                                                <option value="1" <?php if($shipping_method!='' && $shipping_method==1){echo "selected='selected'";}?> >cheapest</option>
                                                <option value="2" <?php if($shipping_method!='' && $shipping_method==2){echo "selected='selected'";}?> >free</option>
                                                <option value="3" <?php if($shipping_method!='' && $shipping_method==3){echo "selected='selected'";}?> >no_rush</option>
                                                <option value="4" <?php if($shipping_method!='' && $shipping_method==4){echo "selected='selected'";}?> >free_standard</option>
                                                <option value="5" <?php if($shipping_method!='' && $shipping_method==5){echo "selected='selected'";}?> >fastest</option>
                                            </select>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip"><span>Shipping method to use for products fulfilled from Amazon</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clear"></div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('SourceSetting.sold_by_amazon', array('id'=>'sold_by_amazon', 'type'=>'checkbox', 'value'=>'1', $sold_by_amazon))); ?>
                                                Allow offers sold by Amazon
                                            </label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('SourceSetting.fba_offers', array('id'=>'fba_offers', 'type'=>'checkbox', 'value'=>'1', $fba_offers))); ?>
                                                Allow third party FBA offers
                                            </label>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip">
                                                <span>Allow 3rd party offers fulfilled by amazon to be considered.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('SourceSetting.merchant_orders', array('id'=>'merchant_orders', 'type'=>'checkbox', 'value'=>'1',$merchant_orders))); ?>
                                                Allow third party merchant-fulfilled offers
                                            </label>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip">
                                                <span>Allow 3rd party offers fulfilled by the 3rd party to be considered.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Minimum number of feedbacks </label>
                                        <div class="input-group">
                                            <?php echo ($this->Form->text('SourceSetting.min_number_feedback', array('id'=>'min_number_feedback', 'type'=>'number', 'class'=>'form-control'))); ?>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Minimum positive feedback percentage </label>
                                        <div class="input-group">
                                            <?php echo ($this->Form->text('SourceSetting.min_positive_feedback', array('id'=>'min_positive_feedback', 'type'=>'number', 'class'=>'form-control'))); ?>
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <?php
                                                echo ($this->Form->text('SourceSetting.international_offer', array('id'=>'international_offer', 'type'=>'checkbox', 'value'=>'1', $international_offer)));
                                                ?>
                                                Allow international offers</label>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip">
                                                <span>If the market reports a quantity lower than your "Quantity in stock" value and this is checked, we will use the lower quantity reported by the marketplace."</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('SourceSetting.prime_offer', array('id'=>'prime_offer', 'type'=>'checkbox', 'value'=>'1', $prime_offer))); ?>
                                                Allow "Prime Only" offers
                                            </label>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip">
                                                <span>If the market reports a quantity lower than your "Quantity in stock" value and this is checked, we will use the lower quantity reported by the marketplace."</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('SourceSetting.addon_offer', array('id'=>'addon_offer', 'type'=>'checkbox', 'value'=>'1',$addon_offer))); ?>
                                                Allow "Add-on" offers</label>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip">
                                                <span>If the market reports a quantity lower than your "Quantity in stock" value and this is checked, we will use the lower quantity reported by the marketplace."</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php //  min_handling_day, shipping_method, sold_by_amazon, fba_offers, merchant_orders, min_number_feedback, min_positive_feedback, international_offer, prime_offer, addon_offer ?>
                                    <input class="btn btn-info" type="submit" name="btn_save_setting" id="btn_save_setting" value="Save Settings" />
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
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