<?php echo $this->element('sidebar'); ?>
<!-- banner -->
<div class="page-head">
    <div class="container">
        <div class="grid_3 grid_5 wow fadeInLeft animated" data-wow-delay=".5s">
            <ol class="breadcrumb">
                <li><a href="<?php echo DEFAULT_URL;?>">Home</a></li>
                <li class="active">Login</li>
                <h1>Login</h1>
            </ol>
        </div>
    </div>
</div>
<!-- //banner -->
<div class="inner-page">
    <div class="container"> 
        <div class="login-grids">
            <div class="login">
                <div class="login-bottom">
                    <h3>Sign up for free</h3>
                    <form name="frmregistration" id="frmregistration" method="post">
                        <?php 
                        if(empty($errorarray) && isset($this->params['pass'][0]) && $this->params['pass'][0]==SUCADD)
                        {
                            echo '<div class="sign-up suc-message">'.SUC_REGISTRATION.'</div>';
                        }
                        ?>
                        <div class="sign-up">
                            <h4>Name :</h4>
                            <?php echo ($this->Form->text('User.fname', array('id' => 'fname', 'placeholder' => 'Name'))); ?>
                            <?php if (isset($errorarray['enter_fname'])) echo "<span class='error-message server'>" . $errorarray['enter_fname'] . "</span>"; ?>
                            <?php if (isset($errorarray['fname_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['fname_not_numeric'] . "</span>"; ?>
                        </div>
                        <div class="sign-up">
                            <h4>Company Name :</h4>
                            <?php echo ($this->Form->text('User.company_name', array('id' => 'company_name', 'placeholder' => 'Company Name'))); ?>
                            <?php if (isset($errorarray['enter_company_name'])) echo "<span class='error-message'>" . $errorarray['enter_company_name'] . "</span>"; ?>
                            <?php if (isset($errorarray['numeric_company_name'])) echo "<span class='error-message'>" . $errorarray['numeric_company_name'] . "</span>"; ?>
                        </div>
                        <div class="sign-up">
                            <h4>Email :</h4>
                            <?php echo ($this->Form->text('User.email', array('id' => 'email', 'placeholder' => 'Email'))); ?>
                            <?php if (isset($errorarray['enter_email'])) echo "<span class='error-message'>" . $errorarray['enter_email'] . "</span>"; ?>
                            <?php if (isset($errorarray['valid_email'])) echo "<span class='error-message'>" . $errorarray['valid_email'] . "</span>"; ?>
                            <?php if (isset($errorarray['email_exists'])) echo "<span class='error-message'>" . $errorarray['email_exists'] . "</span>"; ?>
                        </div>
                        <div class="sign-up">
                            <h4>Password :</h4>
                            <?php echo ($this->Form->text('User.newpwd', array('type'=>'password', 'id' => 'newpwd', 'placeholder' => 'Password'))); ?>
                            <?php if (isset($errorarray['newpass'])) echo "<span class='error-message'>" . $errorarray['newpass'] . "</span>"; ?>
                            <?php if (isset($errorarray['newpass_minlen'])) echo "<span class='error-message'>" . $errorarray['newpass_minlen'] . "</span>"; ?>
                            
                        </div>
                        <div class="sign-up">
                            <h4>Confirm Password :</h4>
                            <?php echo ($this->Form->text('User.confirmpwd', array('type'=>'password', 'id' => 'confirmpwd', 'placeholder' => 'Confirm Password'))); ?>
                            <?php if (isset($errorarray['confpass'])) echo "<span class='error-message'>" . $errorarray['confpass'] . "</span>"; ?>
                            <?php if (isset($errorarray['conflict'])) echo "<span class='error-message'>" . $errorarray['conflict'] . "</span>"; ?>
                            <?php if (isset($errorarray['confpass_minlen'])) echo "<span class='error-message'>" . $errorarray['confpass_minlen'] . "</span>"; ?>
                        </div>
                        <div class="sign-up">
                            <h4>Mobile :</h4>
                            <?php echo ($this->Form->text('User.mobile', array('id' => 'mobile', 'placeholder' => 'Mobile'))); ?>
                            <?php if (isset($errorarray['enter_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['enter_mobile'] . "</span>"; ?>
                            <?php if (isset($errorarray['numeric_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['numeric_mobile'] . "</span>"; ?>
                            <?php if (isset($errorarray['mobile_length'])) echo "<br><span class='error-message server'>" . $errorarray['mobile_length'] . "</span>"; ?>
                        </div>
                        <div class="sign-up">
                            <input type="submit" name="btnsubmit" id="btnsubmit" value="REGISTER NOW">
                        </div>
                    </form>
                </div>
                <div class="login-right">
                    <h3>Sign in with your account</h3>
                    <form name="frmlogin" id="frmlogin" method="post">
                        <?php if(isset($errorarray['notmatch'])){echo '<div class="sign-up error-message">'.$errorarray['notmatch'].'</div>';}?>
                        <div class="sign-in">
                            <h4>Email :</h4>
                            <input type="text" name="data[User][email]" id="email" value="<?php echo (isset($_COOKIE[md5(SITE_TITLE).'USEREMAIL']) && $_COOKIE[md5(SITE_TITLE).'USEREMAIL']!='')?$_COOKIE[md5(SITE_TITLE).'USEREMAIL']:'';?>" placeholder="Email">
                            <?php if (isset($errorarray['login_enter_email'])) echo "<span class='error-message'>" . $errorarray['login_enter_email'] . "</span>"; ?>
                            <?php if (isset($errorarray['login_valid_email'])) echo "<span class='error-message'>" . $errorarray['login_valid_email'] . "</span>"; ?>
                            <?php if (isset($errorarray['login_email_exists'])) echo "<span class='error-message'>" . $errorarray['login_email_exists'] . "</span>"; ?>
                        </div>
                        <div class="sign-in">
                            <h4>Password :</h4>
                            <input type="password" name="data[User][newpwd]" id="newpwd" value="<?php echo (isset($_COOKIE[md5(SITE_TITLE).'USERPASS']) && $_COOKIE[md5(SITE_TITLE).'USERPASS']!='')?$_COOKIE[md5(SITE_TITLE).'USERPASS']:'';?>" placeholder="Password" >
                            <?php if (isset($errorarray['login_newpass'])) echo "<span class='error-message'>" . $errorarray['login_newpass'] . "</span>"; ?>
                            <?php if (isset($errorarray['login_newpass_minlen'])) echo "<span class='error-message'>" . $errorarray['login_newpass_minlen'] . "</span>"; ?>
                            <br>
                            <a href="<?php echo DEFAULT_URL.'users/forgot_password'?>">Forgot password?</a>
                        </div>
                        <div class="single-bottom">
                            <input type="checkbox" name="data[User][rememberme]" id="brand" value="yes" <?php echo (isset($_COOKIE[md5(SITE_TITLE).'USEREMAIL']) && $_COOKIE[md5(SITE_TITLE).'USEREMAIL']!='')?'checked':'';?>>
                            <label for="brand"><span></span>Remember Me</label>
                        </div>
                        <input type="hidden" name="sendpage" id="sendpage" value="<?php echo $sendpage;?>"
                        <div class="sign-in">
                            <input type="submit" name="btnlogin" id="btnlogin" value="SIGNIN" >
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>