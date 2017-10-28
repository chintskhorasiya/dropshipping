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
                    <?php
                    echo $this->Session->flash('ebay_setting_save');
                    //var_dump($this->data);
                    $sourceId = $this->data['EbaySetting']['source_id'];
                    $account_type = (isset($this->data['EbaySetting']['account_type']) ? $this->data['EbaySetting']['account_type'] : 0 );
                    ?>
                    <h1>Ebay <?php if($sourceId == "2"){ echo "UK"; } else { echo "US"; } ?> Settings</h1>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="position-center">
                                <form action="" method="post" name="frm_ebay_setting" id="frm_ebay_setting">
                                    <div class="form-group col-md-6 padding-left-o">
                                        <label>Account Type</label>
                                        <div class="input-group">
                                            <?php
                                            $options = array(0 => 'Sandbox', 1 => 'Live');
                                            $attributes = array('value'=> $account_type, 'separator'=> "&nbsp;&nbsp;", 'legend' => false);
                                            echo $this->Form->radio('EbaySetting.account_type', $options, $attributes);
                                            ?>
                                            <?php /*echo ($this->Form->text('SourceSetting.quantity', array('type'=>'number', 'id' => 'quantity', 'placeholder' => 'Quantity in stock','class' => 'form-control','style'=>'width:95%;'))); */ ?>
                                        </div>
                                        <div class="tooltip">
                                            <span>When an listing is in stock on Amazon or Walmart, PriceYak will set the quantity on eBay to this number.</span>
                                        </div>

                                    </div>
                                    <div class="clear"></div>
                                    
                                    <input class="btn btn-info" type="submit" name="btn_ebay_settings" id="btn_ebay_settings" value="Save Ebay Settings" />
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