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
                    ?>
                    <h1>Ebay User Token</h1>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="position-center">
                                <form action="" method="post" name="frm_ebay_setting" id="frm_ebay_setting">
                                    <div class="form-group col-md-12 padding-left-o">
                                        <label>Please enter your user token</label>
                                        <div class="form-group col-md-12 padding-left-o">
                                            <textarea rows="20" cols="100" class="form-control" name="data[EbayTokens][token]"><?=$token_data['EbayTokens']['token']?></textarea>
                                        </div>

                                    </div>
                                    <div class="clear"></div>
                                    
                                    <input class="btn btn-info" type="submit" name="btn_ebay_settings" id="btn_ebay_settings" value="Save Token" />
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