<div class="container">
    <div class="admin-logo"><img src="<?php echo IMAGE_URL;?>logo.png" /></div>

    <form class="form-signin" method="post" name="frmreset_password" id="frmreset_password">
        <h2 class="form-signin-heading">Reset Password</h2>

        <div class="login-wrap">
            <?php
            if(empty($errorarray) && isset($this->params['pass'][0]) && $this->params['pass'][0]=='succhange')
            {
                echo '<div class="sign-up suc-message" style="text-align: center; padding-bottom: 15px;">We will send you a password reset email within a few minutes.</div>';
            }
            ?>
            <div class="user-login-info">
                <input type="text" class="form-control" name="data[User][email]" id="email" placeholder="Email">
                <?php if (isset($errorarray['enter_email'])) echo "<span class='error-message'>" . $errorarray['enter_email'] . "</span>"; ?>
                <?php if (isset($errorarray['valid_email'])) echo "<span class='error-message'>" . $errorarray['valid_email'] . "</span>"; ?>
                <?php if (isset($errorarray['email_not_match'])) echo "<span class='error-message'>" . $errorarray['email_not_match'] . "</span>"; ?>
            </div>
            <button class="btn btn-lg btn-login btn-block" type="submit">Reset Password</button>
            <label class="checkbox">
                <a href="<?php echo DEFAULT_URL.'users/index'?>"> Login</a>
                <span class="pull-right">
                    <a href="<?php echo DEFAULT_URL.'users/registration'?>"> Create Account</a>
                </span>
            </label>
        </div>
    </form>
</div>