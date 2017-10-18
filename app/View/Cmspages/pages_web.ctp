<?php //echo $this->element('sidebar'); ?>
<?php
if ($passlug == 'contact-us') {?>

    <?php /* *?>
    <div class="page-head">
        <div class="container">
            <div class="grid_3 grid_5 wow fadeInLeft animated" data-wow-delay=".5s">	 
                <ol class="breadcrumb">
                    <li><a href="<?php echo DEFAULT_URL; ?>">Home</a></li>
                    <li class="active">Contact Us</li>
                    <h1>Contact Us</h1>
                </ol>	 
            </div>
        </div>
    </div>
    <?php /* */?>
    <!-- //banner -->
    <!-- contact -->
    <div class="inner-page web-page">
        <div class="container">
            <div class="login-grids">
                <div class="login">
                    <div class="contact-address">
                        <?php echo $cmsdata['Cmspage']['description'];?> 
                    <?php /* *?>
                    <div class="map wow fadeInDown animated" data-wow-delay=".5s">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1836.0419282584396!2d72.58995910993539!3d23.020693062195377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf3559da77e5fd449!2sBhagya+Gold+Ltd.!5e0!3m2!1sen!2s!4v1464435328656" frameborder="0" style="border:0"></iframe>
                    </div>	
                    <?php /* */?>
                    </div>
                    <div class="login-right">
                        <h3>Contact Us</h3>
                        <form name="frmcontactus" id="frmcontactus" method="post">
                            <?php if(empty($errorarray) && isset($this->params['pass'][1]) && $this->params['pass'][1]=='sucsend'){echo '<div class="sign-up suc-message">'.SUC_SEND_CONTACT.'</div>';}?>
                            <div class="sign-up">
                                <h4>Name<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.fname', array('id' => 'fname', 'placeholder' => 'Name'))); ?>
                                <?php if (isset($errorarray['enter_fname'])) echo "<span class='error-message server'>" . $errorarray['enter_fname'] . "</span>"; ?>
                                <?php if (isset($errorarray['fname_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['fname_not_numeric'] . "</span>"; ?>
                            </div>
                            
                            <div class="sign-in">
                                <h4>Email<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.email', array('id' => 'email', 'placeholder' => 'Email'))); ?>
                                <?php if (isset($errorarray['enter_email'])) echo "<span class='error-message'>" . $errorarray['enter_email'] . "</span>"; ?>
                                <?php if (isset($errorarray['valid_email'])) echo "<span class='error-message'>" . $errorarray['valid_email'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Mobile<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.mobile', array('id' => 'mobile', 'placeholder' => 'Mobile'))); ?>
                                <?php if (isset($errorarray['enter_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['enter_mobile'] . "</span>"; ?>
                                <?php if (isset($errorarray['numeric_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['numeric_mobile'] . "</span>"; ?>
                                <?php if (isset($errorarray['mobile_length'])) echo "<br><span class='error-message server'>" . $errorarray['mobile_length'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Message<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->textarea('User.message', array('id' => 'message', 'class' => 'bg-focus form-control','placeholder' => 'Message'))); ?>
                                <?php if (isset($errorarray['enter_message'])) echo "<span class='error-message server'>" . $errorarray['enter_message'] . "</span>"; ?>
                            </div>
                            <div class="sign-in padd15" >
                                <input type="submit" name="btncontact" id="btncontact" value="Submit" >
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            

        </div>
    </div>
    <?php
}
/* *
else if ($passlug == 'career') {?>
    
    <div class="page-head">
        <div class="container">
            <div class="grid_3 grid_5 wow fadeInLeft animated" data-wow-delay=".5s">	 
                <ol class="breadcrumb">
                    <li><a href="<?php echo DEFAULT_URL; ?>">Home</a></li>
                    <li class="active">Career</li>
                    <h1>Career</h1>
                </ol>	 
            </div>
        </div>
    </div>
    <!-- //banner -->
    <div class="inner-page">
        <div class="container">
            <div class="login-grids">
                <div class="login">
                    <div class="login-bottom center-form">
                        <form name="frmcareer" id="frmcareer" method="post" enctype="multipart/form-data">
                            <?php if(empty($errorarray) && isset($this->params['pass'][1]) && $this->params['pass'][1]=='sucsend'){echo '<div class="sign-up suc-message">'.ALLPIED_JOB_SUCCESS.'</div>';}?>
                            
                            <div class="sign-up">
                                <h4>Job Title<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.job_title', array('id' => 'job_title', 'placeholder' => 'Job Title'))); ?>
                                <?php if (isset($errorarray['enter_job_title'])) echo "<span class='error-message server'>" . $errorarray['enter_job_title'] . "</span>"; ?>
                                <?php if (isset($errorarray['job_title_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['job_title_not_numeric'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Name<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.fname', array('id' => 'fname', 'placeholder' => 'Name'))); ?>
                                <?php if (isset($errorarray['enter_fname'])) echo "<span class='error-message server'>" . $errorarray['enter_fname'] . "</span>"; ?>
                                <?php if (isset($errorarray['fname_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['fname_not_numeric'] . "</span>"; ?>
                            </div>
                            
                            <div class="sign-in">
                                <h4>Email<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.email', array('id' => 'email', 'placeholder' => 'Email'))); ?>
                                <?php if (isset($errorarray['enter_email'])) echo "<span class='error-message'>" . $errorarray['enter_email'] . "</span>"; ?>
                                <?php if (isset($errorarray['valid_email'])) echo "<span class='error-message'>" . $errorarray['valid_email'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Mobile<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.mobile', array('id' => 'mobile', 'placeholder' => 'Mobile'))); ?>
                                <?php if (isset($errorarray['enter_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['enter_mobile'] . "</span>"; ?>
                                <?php if (isset($errorarray['numeric_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['numeric_mobile'] . "</span>"; ?>
                                <?php if (isset($errorarray['mobile_length'])) echo "<br><span class='error-message server'>" . $errorarray['mobile_length'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Message<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->textarea('User.message', array('id' => 'message', 'class' => 'bg-focus form-control','placeholder' => 'Message'))); ?>
                                <?php if (isset($errorarray['enter_message'])) echo "<span class='error-message server'>" . $errorarray['enter_message'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Upload Resume<span class="error-message">*</span> :</h4>
                                <input type="file" name="resume" id="resume" >
                                <?php if (isset($errorarray['select_resume'])) echo "<span class='error-message server'>" . $errorarray['select_resume'] . "</span>"; ?>
                                <?php if (isset($errorarray['filecorrupt'])) echo "<span class='error-message server'>" . $errorarray['filecorrupt'] . "</span>"; ?>
                                <?php if (isset($errorarray['validfile'])) echo "<span class='error-message server'>" . $errorarray['validfile'] . "</span>"; ?>
                                <?php if (isset($errorarray['enter_message'])) echo "<span class='error-message server'>" . $errorarray['enter_message'] . "</span>"; ?>
                            </div>
                            
                            <div class="sign-in padd15" >
                                <input type="submit" name="btncareer" id="btncareer" value="Submit" >
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
<?php
}
/* */
else 
{?>
    <?php /* *?>
    <div class="page-head">
        <div class="container">
            <div class="grid_3 grid_5 wow fadeInLeft animated" data-wow-delay=".5s">	 
                <ol class="breadcrumb">
                    <li><a href="<?php echo DEFAULT_URL; ?>">Home</a></li>
                    <li class="active"><?php echo $cmsdata['Cmspage']['name']; ?></li>
                    <h1><?php echo $cmsdata['Cmspage']['name']; ?></h1>
                </ol>	 
            </div>

        </div>
    </div>
    <?php /* */?>
    <!-- //banner --> 
    <div class="inner-page">
        <div class="container">	
            <div class="content">
                <?php echo $cmsdata['Cmspage']['description']; ?>
            </div> 
            <div class="clearfix"></div>
        </div>
    </div>
    <?php
}
?>