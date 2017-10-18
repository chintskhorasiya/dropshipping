<?php 
session_start();
include('configure/configure.php');
if($_SESSION['ADMIN_ID'] != '')
{
	header('location:dashboard.php');
	exit;
}
$error_message = '';
$error = 0;	
if(count($_POST) > 0)
{
	if(trim($_POST['admin_username']) != '' && trim($_POST['admin_password']) != '')
	{
		$res = adminuser_exists($_POST['admin_username'],$_POST['admin_password']);
		if(count($res) > 1)
		{
			//pre($res);
			//exit;
			$_SESSION['ADMIN_ID'] 	  	= $res['admin_id'];
			
			$_SESSION['ADMIN_ROLE'] 	= $res['admin_role'];
			$_SESSION['ADMIN_USERNAME'] = $res['admin_username'];
			$_SESSION['ADMIN_FULLNAME'] = $res['admin_name'];
			$_SESSION['ADMIN_EMAIL'] 	= $res['admin_email'];
			$_SESSION['ADMIN_VISIT'] 	= $res['admin_visit'];
			$_SESSION['ADMIN_IP'] 	  	= $_SERVER['REMOTE_ADDR'];
			
			$data['admin_visit'] = $current_date;
			$data['admin_ip'] 	 = $_SERVER['REMOTE_ADDR'];
			update_data('admin',$data,'admin_id='.$_SESSION['ADMIN_ID']);
			
			header('location:dashboard.php');
			exit;
		}	
		else
		{
			$error = 1;
		}
	}
	else
	{
		$error = 1;
	}
	 
	if($error == 1)
	{
		$error_message = ' <div class="alert alert-block alert-danger fade in">
                                <span>Please correct given information.</span>
                            </div>
							
							';
	}
}

$styles  = include_styles('bs3/css/bootstrap.min.css,bootstrap-reset.css,assets/font-awesome/css/font-awesome.css,style.css,style-responsive.css');
//exit;
 
?>
<?=DOCTYPE;?>
<?=XMLNS;?>
<head>
<?=CONTENTTYPE;?>
<title><?=SITETITLE?> | Login</title>
<?=$styles;?>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
</head>
  <body class="login-body">
    <div class="container">
       <div class="admin-logo"><img src="images/elala-logo.png" /></div>
    
      <form class="form-signin" method="post">
	  
        <h2 class="form-signin-heading">Welcome to Admin Login</h2>
		<?=$error_message;?>
        <div class="login-wrap">
            <div class="user-login-info">
                <input type="text" class="form-control" placeholder="Username" autofocus  name="admin_username">
                <input type="password" class="form-control" placeholder="Password" name="admin_password">
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
        </div>
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
      </form>
    </div>
    <!-- Placed js at the end of the document so the pages load faster -->
    <!--Core js-->
    <script src="js/lib/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
  </body>
</html>
