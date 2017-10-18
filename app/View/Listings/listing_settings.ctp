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
                    <section class="panel">
                        <header class="panel-heading btn-primary"> General Listing Settings </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" method="post" action="" name="frmlisting_setting" id="frmlisting_setting">
                                    <?php
                                    if(isset($this->params['named']['msg']) && $this->params['named']['msg']==SUCUPDATE)
                                    {
                                        echo '<div class="suc-message">'.SUC_SAVE_SETTINGS.'</div>';
                                    }
                                    ?>
                                    <div class="form-group">
                                        <?php
                                        //store_settings
                                        $allow_cross_store = (isset($this->data['ListingSettings']['allow_cross_store']) && $this->data['ListingSettings']['allow_cross_store']==1)?'checked="checked"':'';
                                        $listing_watcher = (isset($this->data['ListingSettings']['listing_watcher']) && $this->data['ListingSettings']['listing_watcher']==1)?'checked="checked"':'';
                                        ?>
                                        <div class="form-group col-md-12 padding-left-o">
                                            <label>Additional title keywords</label>
                                            <div class="input-group col-md-6">
                                                <?php echo ($this->Form->text('ListingSettings.keywords', array('id' => 'keywords', 'type'=>'text', 'placeholder' => 'Additional title keywords','class' => 'form-control','style'=>'width:55%;'))); ?>
                                            </div>
                                            <div class="tooltip">
                                                <span>PriceYak will reprice listings to ensure that you receive at least this much profit from each sale.</span>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('ListingSettings.allow_cross_store', array('id'=>'allow_cross_store', 'type'=>'checkbox','value'=>'1', $allow_cross_store))); ?>
                                                Allow cross-store duplicates
                                            </label>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip"><span>Enables automatic updating of your price and quantity based on source availability. You are only charged for this service when this box is checked. If you turn this off, you may sell items that are out-of-stock or priced too expensively at the source.</span></div>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('ListingSettings.listing_watcher', array('id'=>'listing_watcher', 'type'=>'checkbox','value'=>'1', $listing_watcher))); ?>
                                                Dropshipping Listing Watcher </label>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip"><span>AutoOrdering automatically places orders at the source retailer within minutes of receiving a sale on your listing. You must also add fulfillment account(s) for AutoOrdering to work.</span></div>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-info" value="Save Settings" name="btnsave_settings" id="btnsave_settings">
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