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
                                <form role="form" method="post" action="" name="frmstore_setting" id="frmstore_setting">
                                    <?php
                                    if(isset($this->params['named']['msg']) && $this->params['named']['msg']==SUCUPDATE)
                                    {
                                        echo '<div class="suc-message">'.SUC_SAVE_SETTINGS.'</div>';
                                    }
                                    ?>
                                    <div class="col-md-6 padding-left-o">
                                        <table class="table table-condensed table-hover">
                                            <tr>
                                                <th>Source Market</th>
                                                <th>Active listings</th>
                                                <th>OOS listings</th>
                                            </tr>
                                            <tr>
                                                <td><Strong>Total</strong></td>
                                                <td>0</td>
                                                <td>0</td>
                                            </tr>
                                        </table>
                                    </div>
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