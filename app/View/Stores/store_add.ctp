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
                        <header class="panel-heading btn-primary">  </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <h1>Select a destination market (store) you'd like to add:</h1>
                                <p>Note: We DO support using one eBay account to list to multiple countries
                                    (e.g. eBay.com and eBay.co.uk), <a href="#">but you need to contact us first.</a></p>
                                <form role="form" method="post" action="#">
                                    <div class="form-group">
                                        <label>Destination market</label>
                                        <select class="form-control input-lg m-bot15" name="destination_market" id="destination_market">
                                            <option value="">(Select One)</option>
                                            <option value="ebay">eBay US</option>
                                            <option value="ebay_uk">eBay UK</option>
                                            <option value="ebay_ca">eBay CA</option>
                                        </select>
                                    </div>
                                    <input type="submit" class="btn btn-info" value="Submit">
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