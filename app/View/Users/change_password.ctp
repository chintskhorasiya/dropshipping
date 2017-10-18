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
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="frmchange_pass" name="frmchange_pass">
                            <div class="panel-body">
                                <div class="position-center">
                                    <div class="prf-contacts sttng">
                                        <h2>Change Password</h2>
                                    </div>
                                    <?php
                                    if(empty($errorarray) && isset($this->params['pass'][0]) && $this->params['pass'][0]=='succhange')
                                    {
                                        echo '<div class="sign-up suc-message">'.PASS_CHANGE_CLIENT.'</div>';
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Old Password</label>
                                        <div class="col-lg-6">
                                            <input class="form-control" type="password" name="data[User][oldpwd]" id="oldpwd" value="">
                                            <?php if (isset($errorarray['enter_oldpwd'])) echo "<span class='error-message'>" . $errorarray['enter_oldpwd'] . "</span>"; ?>
                                            <?php if (isset($errorarray['oldpwd_minlen'])) echo "<span class='error-message'>" . $errorarray['oldpwd_minlen'] . "</span>"; ?>
                                            <?php if (isset($errorarray['pass_not_match'])) echo "<span class='error-message'>" . $errorarray['pass_not_match'] . "</span>"; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">New Password</label>
                                        <div class="col-lg-6">
                                            <input class="form-control" type="password" name="data[User][newpwd]" id="newpwd" value="">
                                            <?php if (isset($errorarray['newpass'])) echo "<span class='error-message'>" . $errorarray['newpass'] . "</span>"; ?>
                                            <?php if (isset($errorarray['newpass_minlen'])) echo "<span class='error-message'>" . $errorarray['newpass_minlen'] . "</span>"; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Confirm Password</label>
                                        <div class="col-lg-6">
                                            <input class="form-control" type="password" name="data[User][confirmpwd]" id="confirmpwd" value="">
                                            <?php if (isset($errorarray['confpass'])) echo "<span class='error-message'>" . $errorarray['confpass'] . "</span>"; ?>
                                            <?php if (isset($errorarray['confpass_minlen'])) echo "<span class='error-message'>" . $errorarray['confpass_minlen'] . "</span>"; ?>
                                            <?php if (isset($errorarray['conflict'])) echo "<span class='error-message'>" . $errorarray['conflict'] . "</span>"; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <header class="panel-heading position-center" style="position:fixed;bottom:0px;opacity:0.9;">
                                <div class="form-group">
                                    <div class="col-lg-offset-7 col-lg-12">
                                        <input type="submit" class="btn btn-info" name="btnchange_pass" id="btnchange_pass" value="Submit">
                                    </div>
                                </div>
                            </header>
                        </form>
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