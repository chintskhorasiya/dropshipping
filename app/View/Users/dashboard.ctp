<section id="container">
    <?php echo $this->Html->css(array('style_clock')); ?>
    <?php echo $this->Html->script(array('css3clock')); ?>
    <!--header start-->
    <?php echo $this->element('header');?>

    <!--header end-->
    <!--sidebar start-->

    <?php echo $this->element('sidebar'); ?>
    <!--sidebar end-->
    <!--main content start-->

    <?php /* */ ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <!--Box-->
                <div class="col-sm-8">
                    <section class="panel">
                        <header class="panel-heading border-o">
                            <div align="center"><b><font size="+1">Welcome to Dropshipping Management Application</font></b></div>
                        </header>
                    </section>
                </div>
                <div class="col-md-4">
                    <div class="profile-nav alt">
                        <section class="panel">
                            <?php
                            $date = date('d-m-Y');
                            $today = date('d', strtotime($date));
                            $dayname = date('l', strtotime($date));
                            $year = date('Y', strtotime($date));
                            $month = date('F', strtotime($date));
                            ?>
                            <div class="user-heading alt clock-row terques-bg">
                                <h1>
                                    <?php echo $month ?>
                                    <?php echo $today ?>
                                </h1>
                                <p class="text-left">
                                    <?php echo $year ?>
                                    ,
                                    <?php echo $dayname ?>
                                </p>
                            </div>
                            <ul id="clock">
                                <li id="sec"></li>
                                <li id="hour"></li>
                                <li id="min"></li>
                            </ul>
                        </section>
                    </div>
                </div>
                <!--Box-->
            </div>

        </section>
    </section>
    <?php /* */ ?>

    <!--main content end-->
    <?php echo $this->element('footer'); ?>
</section>
