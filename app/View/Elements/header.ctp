<?php /* * ?>
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
<?php /* */ ?>
<!--header start-->

<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
        <a href="<?php echo DEFAULT_URL ?>users/dashboard" class="logo" style="">Dropshipping Management Application</a>
    </div>
    <!--logo end-->
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="<?php //echo IMAGE_URL.$admin_image ?>">
                <span class="username"></span>
                <b class="caret"></b> </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="<?php echo DEFAULT_URL.'users/editprofile' ?>"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="<?php echo DEFAULT_URL.'users/change_password' ?>"><i class=" fa fa-suitcase"></i>Change Password</a></li>
                    <!--<li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>-->
                    <li><a href="<?php echo DEFAULT_URL.'users/logout' ?>"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
        <!--search & user info end-->
    </div>
</header>
<!--header end-->