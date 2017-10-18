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
                    <section class="panel  border-o">
                        <header class="panel-heading btn-primary">Manage Listing Blacklists</header>
                        <form  role="form" action="" method="post">
                            <?php if(isset($this->params['pass'][1]) && $this->params['pass'][1]==SUCADD){echo '<div class="suc-message" style="padding:0px 15px;">'.RECORDUPDATE.'</div>';}?>

                            <div class="panel-body">
                                <div class="col-md-4 padding-left-o">
                                    <h3>Brand Blacklist
                                        <span class="h-tooltip" aria-hidden="true">?</span>
                                        <div class="tooltip"><span>Shipping method to use for products fulfilled from Amazon</span>
                                        </div>
                                    </h3>
                                    <div class="backlist-editor-box">
                                        <textarea rows="25" class="zn-blacklist-textarea form-control" name="data[Blacklist][brand_list]" id="brand_list"><?php echo (isset($set_blacklist_data['Blacklist']['brand_list']) && $set_blacklist_data['Blacklist']['brand_list']!='')?$set_blacklist_data['Blacklist']['brand_list']:'';?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h3>Keyword Blacklist
                                        <span class="h-tooltip" aria-hidden="true">?</span>
                                        <div class="tooltip"><span>Shipping method to use for products fulfilled from Amazon</span>
                                        </div>
                                    </h3>
                                    <div class="backlist-editor-box">
                                        <textarea rows="25" class="zn-blacklist-textarea form-control" name="data[Blacklist][keyword_list]" id="keyword_list"><?php echo (isset($set_blacklist_data['Blacklist']['keyword_list']) && $set_blacklist_data['Blacklist']['keyword_list']!='')?$set_blacklist_data['Blacklist']['keyword_list']:'';?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h3>ASIN/Product Id Blacklist
                                        <span class="h-tooltip" aria-hidden="true">?</span>
                                        <div class="tooltip"><span>Shipping method to use for products fulfilled from Amazon</span>
                                        </div>
                                    </h3>
                                    <div class="backlist-editor-box">
                                        <textarea rows="25" class="zn-blacklist-textarea form-control" name="data[Blacklist][product_list]" id="product_list" ><?php echo (isset($set_blacklist_data['Blacklist']['product_list']) && $set_blacklist_data['Blacklist']['product_list']!='')?$set_blacklist_data['Blacklist']['product_list']:'';?></textarea>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <br/>
                                <div class="position-center">
                                    <input type="submit" class="btn btn-info" name="btn_blackklist" id="btn_blackklist" value="Save Blacklists">
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    </section>
    <!--main content end-->
    <?php echo $this->element('footer'); ?>
</section>