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
                            <header class="panel-heading btn-primary">  Create Listings </header>

                            <div class="panel-body">
                                <div class="position-center">
                                    <?php if(isset($error_array['dup_product'])){echo '<span class="error-message">'.PRODUCT_EXISTS.'</span>';}?>
                                    <h4>
                                        <ol style="padding: 5px 17px;">
                                            <li>Select the source market you're listing from.</li>
                                            <li>Paste in the product IDs / urls of what you want to list.</li>
                                            <li>We'll show you products we found in green. Then, click list.</li>
                                            <li>View your <a href="<?php echo DEFAULT_URL.'listings/listing_requests';?>">Listings Requests</a> to monitor progress.</li>
                                        </ol>
                                    </h4>
                                    <form action="<?php //echo DEFAULT_URL.'get_product_detail.php'?>" method="post">
                                        <div class="form-group col-md-6 padding-left-o">
                                            <label>Source Market:</label>
                                            <select class="form-control input-lg m-bot15 store_city" name="data[Listing][source_id]" id="source_id">
                                                <option value="0">Select One</option>
                                                <option value="1">Amazon US</option>
                                                <option value="2">Amazon UK</option>
                                            </select>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="form-group col-md-12 padding-left-o">
                                            <textarea rows="20" cols="90" class="form-control" name="data[Listing][content]"></textarea>
                                        </div>
                                        <div class="clear"></div>
                                        <input class="btn btn-info" name="btn_list_now" id="btn_list_now" type="submit" style="display:none;" value="List Now" />
                                        <input class="btn btn-info" name="btn_review_list" id="btn_review_list" type="submit" value="Review and List" />
                                    </form>
                                </div>
                                <p>&nbsp;</p>
                                <p>
                                    <b>TIP :</b> Want to edit your eBay shipping settings, return settings, or payment policies? Edit your business policy profiles! (learn more)<br/>
                                    <b>NOTE :</b> if you experience issues listing (especially items with variants), try using YakPal.
                                </p>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    <!--main content end-->
    <?php echo $this->element('footer'); ?>
</section>