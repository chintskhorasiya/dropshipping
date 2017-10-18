<?php
session_start();
include('configure/configure.php');

include('auth.php');

$styles = include_styles('bootstrap.min.css,jquery-ui-1.10.1.custom.min.css,bootstrap-reset.css,font-awesome.css,jquery-jvectormap-1.2.2.css,clndr.css,css3clock/css/style.css,morris-chart/morris.css,jquery.gritter.css,style.css,style-responsive.css');

$javascripts = include_js('lib/jquery-1.8.3.min.js,bootstrap.min.js,accordion-menu/jquery.dcjqaccordion.2.7.js,jquery.scrollTo.min.js,nicescroll/jquery.nicescroll.js,easypiechart/jquery.easypiechart.js,jQuery-slimScroll-1.3.0/jquery.slimscroll.js,jquery.gritter.js,sparkline/jquery.sparkline.js,flot-chart/jquery.flot.js,flot-chart/jquery.flot.tooltip.min.js,flot-chart/jquery.flot.resize.js,flot-chart/jquery.flot.pie.resize.js,gritter/gritter.js,css3clock/js/css3clock.js,scripts.js,acco-nav.js');

?>
<?=DOCTYPE;?>
<?=XMLNS;?>
<head>
<?=CONTENTTYPE;?>
<title>Administrator Panel</title>
<?=$styles?>
<?=$javascripts?>
<?=$assets?>
</head>
<body>
<section id="container">
  <!--header start-->
  <?php include('header.php');?>
  <!--header end-->
  <!--sidebar start-->
  <?php include('sidebar.php');?>
  <!--sidebar end-->
  <!--main content start-->
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

						$today = date('d', strtotime($date));

						$dayname = date('l', strtotime($date));

						$year = date('Y', strtotime($date));

						$month = date('F', strtotime($date));

					?>
              <div class="user-heading alt clock-row terques-bg">
                <h1>
                  <?=$month?>
                  <?=$today?>
                </h1>
                <p class="text-left">
                  <?=$year?>
                  ,
                  <?=$dayname?>
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
  <!--main content end-->
  <?php include('footer.php');?>
</section>
</body>
</html>