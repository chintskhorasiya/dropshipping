<div class="container">
    <div class="admin-logo"><img src="<?php echo IMAGE_URL;?>logo.png" /></div>

    <form class="form-signin" method="post" name="frmregistration" id="frmregistration">
        <h2 class="form-signin-heading">Welcome to Registration</h2>
        <?php
        //For display error
        if(isset($this->params['pass'][0]) && $this->params['pass'][0] == SUCADD){echo '<div class="alert alert-block suc-message fade in" style="text-align: center;"><span>'.SUC_REGISTRATION.'</span></div>';}
        ?>
        <div class="login-wrap">
            <div class="user-login-info">
                <input type="text" class="form-control" placeholder="Email" autofocus name="data[User][email]" id='email' value="<?php if (isset($this->data['User']['email'])){echo $this->data['User']['email'];}?>">
                <?php if (isset($errorarray['enter_email'])) echo "<span class='error-message server'>" . $errorarray['enter_email'] . "</span>"; ?>
                <?php if (isset($errorarray['valid_email'])) echo "<span class='error-message server'>" . $errorarray['valid_email'] . "</span>"; ?>
                <?php if (isset($errorarray['email_exists'])) echo "<span class='error-message server'>" . $errorarray['email_exists'] . "</span>"; ?>

                <input type="text" class="form-control" placeholder="Username" autofocus name="data[User][username]" id='username' value="<?php if (isset($this->data['User']['username'])){echo $this->data['User']['username'];}?>">
                <?php if (isset($errorarray['enter_uname'])) echo "<span class='error-message server'>" . $errorarray['enter_uname'] . "</span>"; ?>
                <?php if (isset($errorarray['uname_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['uname_not_numeric'] . "</span>"; ?>

                <input type="password" class="form-control" placeholder="Password" name="data[User][newpwd]" id="newpwd" value="">
                <?php if (isset($errorarray['newpass'])) echo "<span class='error-message server'>" . $errorarray['newpass'] . "</span>"; ?>
                <?php if (isset($errorarray['newpass_minlen'])) echo "<span class='error-message server'>" . $errorarray['newpass_minlen'] . "</span>"; ?>

                <input type="password" class="form-control" placeholder="Confirm Password" name="data[User][confirmpwd]" id="confirmpwd" value="">
                <?php if (isset($errorarray['confpass'])) echo "<span class='error-message server'>" . $errorarray['confpass'] . "</span>"; ?>
                <?php if (isset($errorarray['conflict'])) echo "<span class='error-message server'>" . $errorarray['conflict'] . "</span>"; ?>
                <?php if (isset($errorarray['confpass_minlen'])) echo "<span class='error-message server'>" . $errorarray['confpass_minlen'] . "</span>"; ?>

                <input type="text" class="form-control" placeholder="Full Name" autofocus name="data[User][name]" id='username' value="<?php if (isset($this->data['User']['name'])){echo $this->data['User']['name'];}?>">
                <?php if (isset($errorarray['enter_name'])) echo "<span class='error-message server'>" . $errorarray['enter_name'] . "</span>"; ?>
                <?php if (isset($errorarray['name_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['name_not_numeric'] . "</span>"; ?>

                <input type="text" class="form-control" placeholder="Phone" autofocus name="data[User][mobile]" id='username' value="<?php if (isset($this->data['User']['mobile'])){echo $this->data['User']['mobile'];}?>">
                <?php if (isset($errorarray['enter_mobile'])) echo "<span class='error-message server'>" . $errorarray['enter_mobile'] . "</span>"; ?>
            </div>

            <button class="btn btn-lg btn-login btn-block" type="submit">Create Account</button>
            <label class="checkbox">
                <a href="<?php echo DEFAULT_URL.'users/forgot_password'?>">Forgot Password?</a>
                <span class="pull-right">
                    <a href="<?php echo DEFAULT_URL.'users/index'?>"> Login</a>
                </span>
            </label>
        </div>
    </form>
</div>