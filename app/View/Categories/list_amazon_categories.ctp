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
                            <?php echo $this->Session->flash('list_amazon_categories'); ?>
                            <header class="panel-heading btn-primary">  Categories Listings </header>

                            <div class="panel-body">
                                <div class="position-center">
                                    <?php if(isset($error_array['dup_product'])){echo '<span class="error-message">'.PRODUCT_EXISTS.'</span>';}?>
                                    <h4>
                                        <ol style="padding: 5px 17px;">
                                            <li>Select the source market you're listing from.</li>
                                            <li>Paste in the product IDs / urls of what you want to list.</li>
                                            <li>We'll list categories of those products.</li>
                                            <li>View those categories in Categories mapping page according to store.</li>
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
                                        <input class="btn btn-info" name="btn_list_now" id="btn_list_now" type="submit" value="List Categories" />
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