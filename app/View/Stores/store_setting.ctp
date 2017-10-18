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
                        <header class="panel-heading btn-primary"> Enable/Disable PriceYak features </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" method="post" action="" name="frmstore_setting" id="frmstore_setting">
                                    <?php


                                    if(isset($this->params['named']['msg']) && $this->params['named']['msg']==SUCUPDATE)
                                    {
                                        echo '<div class="suc-message">'.SUC_SAVE_SETTINGS.'</div>';
                                    }
                                    ?>
                                    <div class="form-group">
                                        <?php
                                        //store_settings
                                        $enable_repricing = (isset($this->data['StoreSetting']['enable_repricing']) && $this->data['StoreSetting']['enable_repricing']==1)?'checked="checked"':'';
                                        $enable_auto_ordering = (isset($this->data['StoreSetting']['enable_auto_ordering']) && $this->data['StoreSetting']['enable_auto_ordering']==1)?'checked="checked"':'';
                                        ?>
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('StoreSetting.enable_repricing', array('id'=>'enable_repricing', 'type'=>'checkbox','value'=>'1', $enable_repricing))); ?>
                                                Enable Repricing </label>
                                            <span class="h-tooltip" aria-hidden="true">?</span>
                                            <div class="tooltip"><span>Enables automatic updating of your price and quantity based on source availability. You are only charged for this service when this box is checked. If you turn this off, you may sell items that are out-of-stock or priced too expensively at the source.</span></div>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <?php echo ($this->Form->text('StoreSetting.enable_auto_ordering', array('id'=>'enable_auto_ordering', 'type'=>'checkbox','value'=>'1', $enable_auto_ordering))); ?>
                                                Enable AutoOrdering </label>
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