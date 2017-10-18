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
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="profileEdit">
                            <div class="panel-body">
                                <div class="position-center">
                                    <div class="prf-contacts sttng">
                                        <h2>Your Information</h2>
                                    </div>
                                    <?php
                                    //print_r($this->data);
                                    if(empty($errorarray) && isset($this->params['pass'][0]) && $this->params['pass'][0]==SUCUPDATE)
                                    {
                                        echo '<div class="sign-up suc-message">'.SUC_CHANGE_PROFILE.'</div>';
                                    }
                                    ?>
                                    <input type="hidden" name="data[User][id]" id="id" value="<?php echo (isset($_SESSION[md5(SITE_TITLE) . 'USERID']))?$_SESSION[md5(SITE_TITLE) . 'USERID']:'';?>">
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Name</label>
                                        <div class="col-lg-6">
                                            <?php echo ($this->Form->text('User.name', array('id' => 'name', 'placeholder' => 'Name','class' => 'form-control'))); ?>
                                            <?php if (isset($errorarray['enter_name'])) echo "<span class='error-message server'>" . $errorarray['enter_name'] . "</span>"; ?>
                                            <?php if (isset($errorarray['name_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['name_not_numeric'] . "</span>"; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Email</label>
                                        <div class="col-lg-6">
                                            <?php echo ($this->Form->text('User.email', array('id' => 'email', 'placeholder' => 'Email','class' => 'form-control'))); ?>
                                            <?php if (isset($errorarray['enter_email'])) echo "<span class='error-message'>" . $errorarray['enter_email'] . "</span>"; ?>
                                            <?php if (isset($errorarray['valid_email'])) echo "<span class='error-message'>" . $errorarray['valid_email'] . "</span>"; ?>
                                            <?php if (isset($errorarray['email_exists'])) echo "<br><span class='error-message server'>" . $errorarray['email_exists'] . "</span>"; ?>
                                        </div>
                                    </div>
                                    <?php /* * ?>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Old Password</label>
                                        <div class="col-lg-6">
                                            <?php echo ($this->Form->text('User.password', array('id' => 'password','type'=>'password', 'placeholder' => 'Password','class' => 'form-control'))); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">New Password</label>
                                        <div class="col-lg-6">
                                            <?php echo ($this->Form->text('User.new_password', array('id' => 'new_password','type'=>'password', 'placeholder' => '','class' => 'form-control'))); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Confirm Password</label>
                                        <div class="col-lg-6">
                                            <?php echo ($this->Form->text('User.confirm_password', array('id' => 'confirm_password','type'=>'password', 'placeholder' => '','class' => 'form-control'))); ?>
                                        </div>
                                    </div>
                                    <?php /* */?>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Profile Image</label>
                                        <div class="col-lg-6">
                                            <input type="file" class="file-pos" name="imagename">
                                            <p class="help-block">[ (100 X 100) or bigger than this according to resolutions ]</p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="data[User][oldimagename]" id="oldimagename" value="<?php echo (isset($this->data['User']['image_name']) && $this->data['User']['image_name']!='')?$this->data['User']['image_name']:''; ?>">
                                    <?php //echo DISPLAY_URL_IMAGE.'user_images/' . $this->data['image_name']; ?>
                                    <?php if(isset($this->data['User']['image_name']) && $this->data['User']['image_name']!='' && file_exists(UPLOAD_FOLDER.'user_images/' . $this->data['User']['image_name'])){?>
                                    <div class="form-group">
                                        <div class="col-lg-8 text-center">
                                            <span><img src="<?php echo DISPLAY_URL_IMAGE.'user_images/' . $this->data['User']['image_name']; ?>" width="100"></span>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                            <header class="panel-heading position-center" style="position:fixed;bottom:0px;opacity:0.9;">
                                <div class="form-group">
                                    <div class="col-lg-offset-7 col-lg-12">
                                        <button type="submit" class="btn btn-info" name="btnsubmit" id="btnsubmit">Submit</button>
                                        <button type="submit" class="btn btn-default">Cancel</button>
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
