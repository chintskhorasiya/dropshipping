<div class="container">
    <div class="admin-logo"><img src="<?php echo IMAGE_URL;?>logo.png" /></div>

    <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Welcome to Login</h2>
        <?php
        //For display error
        if(isset($error_array['err_username'])){echo '<div class="alert alert-block alert-danger fade in"><span>'.$error_array['err_username'].'</span></div>';}
        else if(isset($error_array['err_password'])){echo '<div class="alert alert-block alert-danger fade in"><span>'.$error_array['err_password'].'</span></div>';}
        else if(isset($error_array['err_nomatch'])){echo '<div class="alert alert-block alert-danger fade in"><span>'.$error_array['err_nomatch'].'</span></div>';}
        ?>
        <div class="login-wrap">
            <div class="user-login-info">
                <input type="text" class="form-control" placeholder="Username" autofocus name="data[User][username]" id='username' value="<?php if (isset($this->data['User']['username'])){echo $this->data['User']['username'];}?>">
                <input type="password" class="form-control" placeholder="Password" name="data[User][password]" id="password" value="<?php if (isset($this->data['User']['password'])){echo $this->data['User']['password'];}?>">
            </div>

            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

            <label class="checkbox">
                <a href="<?php echo DEFAULT_URL.'users/forgot_password'?>">Forgot Password?</a>
                <span class="pull-right">
                    <a href="<?php echo DEFAULT_URL.'users/registration'?>"> Create Account</a>
                </span>
            </label>
        </div>
    </form>
    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Forgot Password ?</h4>
                </div>
                <div class="modal-body">
                    <p>Enter your e-mail address below to reset your password.</p>
                    <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                    <button class="btn btn-success" type="button">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
</div>