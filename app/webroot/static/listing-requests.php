<?php
session_start();
include('configure/configure.php');

include('auth.php');

accessPermission('1,2,3', 'page');



if ($_REQUEST['newbnid'] == 'newbrand') {

    $brand_notification = new_brand_notification();



    foreach ($brand_notification as $new_brand) {

        $brand_id = $new_brand['brand_id'];

        $notification['brand_view_by_admin'] = 0;

        $update_id = update_data('brand', $notification, 'brand_id =' . $brand_id);
    }
}



/* Filter */

$status = '';

if ($_REQUEST['brand_status'] != '' && is_numeric($_REQUEST['brand_status'])) {

    $status = $_REQUEST['brand_status'];

    $get_brands = search_brands($status);
} else {

    $get_brands = get_brands();
}

$styles = include_styles('bootstrap.min.css,assets/jquery-ui/jquery-ui-1.10.1.custom.min.css,bootstrap-reset.css,font-awesome.css,jquery-jvectormap-1.2.2.css,css3clock/css/style.css,morris-chart/morris.css,DT_bootstrap.css,demo_page.css,demo_table.css,style.css,style-responsive.css');

$javascripts = include_js('lib/jquery.js,lib/jquery-1.8.3.min.js,bootstrap.min.js,accordion-menu/jquery.dcjqaccordion.2.7.js,scrollTo/jquery.scrollTo.min.js,nicescroll/jquery.nicescroll.js,scripts.js,gritter/gritter.js,easypiechart/jquery.easypiechart.js,sparkline/jquery.sparkline.js,flot-chart/jquery.flot.js,flot-chart/jquery.flot.tooltip.min.js,flot-chart/jquery.flot.resize.js,flot-chart/jquery.flot.pie.resize.js,jquery.dataTables.js,jquery.MultiFile.js,acco-nav.js');
?>
<?= DOCTYPE; ?>
<?= XMLNS; ?>
<head>
    <?= CONTENTTYPE; ?>
    <title>listing Requests</title>
    <?= $styles ?>
    <?= $javascripts ?>
    <script language="javascript" type="text/javascript">

        function apply_actions(action)

        {

            if (action == '')

            {

                alert('Please select action');

                return false;

            }

            if (confirm('Do you really want to take this action?'))

            {

                var val = '';

                var total_checked = $('#dynamic-table input[type=checkbox]:checked').length;

                var i = 1;

                if (total_checked > 0)

                {

                    $('#dynamic-table input[type=checkbox]:checked').each(function () {

                        if (i != total_checked)

                        {

                            val += $(this).val() + ',';

                        } else

                        {

                            val += $(this).val();

                        }

                        i++;

                    });



                    $.post('action.php', {action_type: action, action_module: 'brand', actions_ids: val}, function (data) {

                        window.location = location.href;

                    });

                } else

                {

                    alert('Please select atleast one record');

                    return false;

                }

            } else

            {

                return false;

            }

        }

    </script>
    <script type="text/javascript">

        $(document).ready(function () {



            $('#dynamic-table').dataTable({
                "paging": false,
                "ordering": false,
                "info": false

            });

        });

    </script>
</head>

<body>
    <section id="container">

        <?php include('header.php'); ?>

        <?php include('sidebar.php'); ?>

        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading btn-primary">listing Requests </header>
                            <div class="panel-body">
                                <h4>Recent listing requests</h4>
                                <p>This page will automatically refresh. Listing requests usually take less than 45 minutes.</p>
                                <div class="adv-table">
                                    <input type="submit" class="btn btn-info" value="Retry Failed Listings">
                                    <span class="export-b">
                                        <input type="submit" class="btn btn-info" value="Export CSV">
                                        <span class="caret" data-toggle="dropdown" aria-expanded="false"></span>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Export CSV</a></li>
                                            <li><a href="#">Export raw CSV</a></li>
                                            <li><a href="#">Bulk raw CSV</a></li>
                                        </ul>
                                    </span>
                                    <table class="display table table-bordered table-striped" id="dynamic-table">
                                        <thead>
                                            <tr>
                                                <th width="15%">Time Requested</th>
                                                <th width="20%">Source Product</th>
                                                <th width="5%">Success?</th>
                                                <th width="60%">Listing</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="gradeA">
                                                <td class="align-center">1/21/2017, 5:37:22 PM</td>
                                                <td>
                                                    <div class="btn-group zn-listing-link">
                                                        <a href="#" class="btn btn-default">1094615803</a>
                                                        <button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
                                                            <img src="images/amazon-logo.svg" /><img src="images/gb.png" />
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="#">Copy</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><i class="fa fa-trash-o delete-center"></i> </td>
                                                <td>An internal error occurred - please retry later.</td>
                                            </tr>

                                            <tr class="gradeA">
                                                <td class="align-center">1/21/2017, 5:37:22 PM</td>
                                                <td>
                                                    <div class="btn-group zn-listing-link">
                                                        <a href="#" class="btn btn-default">B01EYJVY8O</a>
                                                        <button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
                                                            <img src="images/amazon-logo.svg" /><img src="images/gb.png" />
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="#">Copy</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><i class="fa fa-trash-o delete-center"></i> </td>
                                                <td>eBay Error [21829] : Ineligible immediate payment Email Address. (You must have a valid PayPal Account in good standing to require immediate payment.). Messages from eBay: {}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <?php include('footer.php'); ?>
                    </div>
                </div>
            </section>
        </section>

        <!--main content end-->

        <!--right sidebar start-->

        <div class="right-sidebar">
            <div class="search-row">
                <input type="text" placeholder="Search" class="form-control">
            </div>
        </div>

        <!--right sidebar end-->
        <style>
            .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {

                vertical-align:middle;
            }
        </style>
    </section>
</body>
</html>