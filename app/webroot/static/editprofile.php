<?php
include('configure/configure.php');
include('auth.php');

$error_message = '';
$error = 0;

$user_detail = adminget_user_detail($_SESSION['ADMIN_ID']);

$admin_name = $user_detail['admin_name'];
$admin_email = $user_detail['admin_email'];
$admin_image = $user_detail['admin_image'];
if (count($_POST) > 0) {
    if (trim($_POST['admin_name']) == '') {
        $admin_name_error = '<label class="col-md-8 alert-danger">First name is required.</label>';
        $error = 1;
    }
    if ($_POST['adminoldpassword'] != '' && $_POST['admin_password'] != '' && $_POST['admin_confirm_password'] != '') {
        if (!checkoldpassword($_SESSION['ADMIN_ID'], trim($_POST['adminoldpassword']))) {
            $oldpassword_error = '<p class="help-block text-danger">Old password does not match.</p>';
            $error = 1;
        }
        if ($_POST['admin_password'] == '') {
            $admin_password_error = '<p class="help-block text-danger">Enter New Password.</p>';
            $error = 1;
        }
        if ($_POST['admin_confirm_password'] == '') {
            $confirm_password_error = '<p class="help-block text-danger">Enter New Password.</p>';
            $error = 1;
        }
        if ($_POST['admin_password'] != $_POST['admin_confirm_password']) {
            $confirm_password_error = '<p class="help-block text-danger">Confirm password does not match.</p>';
            $error = 1;
        }
    }

    if ($error == 1) {
        $error_message = ' <div>
                                <label class="alert alert-block alert-danger fade in col-lg-12 col-sm-6">Please fillup all required information.</label>
                            </div>';
        //echo mysql_error();
    } else {
        if ($_FILES['admin_image']['name'] != '') {

            $image_name = upload_image($_FILES['admin_image'], IMAGEPATH, IMAGE_THUMB_PATH, '100', '100');
            if (file_exists(IMAGEPATH . $admin_image)) {
                unlink(IMAGEPATH . $admin_image);
                if (file_exists(IMAGE_THUMB_PATH . $admin_image)) {
                    unlink(IMAGE_THUMB_PATH . $admin_image);
                }
            }
            if ($image_name) {
                $_POST['admin_image'] = $image_name;
            }
        }

        $user_data['admin_name'] = trim($_POST['admin_name']);
        $user_data['admin_email'] = trim($_POST['admin_email']);

        //pre($_POST);
        if ($_POST['admin_confirm_password'] != '' && $_POST['admin_password'] != '') {
            $user_data['admin_pwd'] = set_password(trim($_POST['admin_confirm_password']));
            $user_data['admin_password'] = encrypt_password(trim($_POST['admin_confirm_password']));
        }
        if ($_FILES['admin_image']['name'] != '') {
            $user_data['admin_image'] = trim($_POST['admin_image']);
        }

//		pre($user_data);
//		exit;


        $user_data['admin_modified_date'] = $current_date;



        $update_id = update_data('admin', $user_data, 'admin_id=' . $_SESSION['ADMIN_ID']);
        if ($update_id) {
            $_SESSION['profile_updated'] = '<span class="alert alert-success">Your profile has been updated successfully!</span>';
            $successfulupdate = $_SESSION['profile_updated'];
            header('location:' . ADMINURL . 'editprofile.php');
            exit;
        } else {
            echo mysql_error();
            $error = 1;
        }
    }
}
if ($error == 1) {
    $error_message = '<div class="alert alert-warning text-danger">There is some error while processing. Please try after sometime</div>';
}
if ($_SESSION['profile_updated'] != '') {

    $success_message = '<div class="col-md-12">' . $_SESSION['profile_updated'] . '</div>';
    unset($_SESSION['profile_updated']);
}
//pre($_SESSION);



$useremail_error = '<div class="col-sm-8 col-md-8 alert-danger">Email can not be changed.</div>';
$username_error = '<div class="col-sm-9 col-md-9 alert-danger">Username can not be changed.</div>';
$styles = include_styles('style.css,style-responsive.css,bootstrap.min.css,assets/jquery-ui/jquery-ui-1.10.1.custom.min.css,bootstrap-reset.css,font-awesome.css,validationEngine.jquery.css,bootstrap-datepicker/css/datepicker.css,bootstrap-datetimepicker/css/datetimepicker.css');
$javascripts = include_js('lib/jquery.js,lib/jquery-1.8.3.min.js,bootstrap.min.js,accordion-menu/jquery.dcjqaccordion.2.7.js,scrollTo/jquery.scrollTo.min.js,nicescroll/jquery.nicescroll.js,scripts.js,gritter/gritter.js,jquery.validationEngine-en.js,jquery.validationEngine.js,bootstrap-datepicker/js/bootstrap-datepicker.js,bootstrap-datetimepicker/js/bootstrap-datetimepicker.js,acco-nav.js');
?>
<?= DOCTYPE; ?>
<?= XMLNS; ?>
<head>
    <?= CONTENTTYPE; ?>
    <title>Edit Profile</title>
    <?= $styles ?>
    <?= $javascripts ?>
    <script>
        jQuery(document).ready(function () {
            // binds form submission and fields to the validation engine
            jQuery("#profileEdit").validationEngine();
        });
    </script>
    <script>
        $(".form_datetime").datepicker({format: 'yyyy-mm-dd'});
    </script>
</head>
<body>
    <section id="container">
        <!--header start-->
        <?php include('header.php'); ?>
        <!--header end-->
        <!--sidebar start-->
        <?php include('sidebar.php'); ?>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="profileEdit">
                                <?= $success_message ?>
                                <?= $error_message; ?>

                                <div class="panel-body">
                                    <div class="position-center">
                                        <div class="prf-contacts sttng">
                                            <h2>Your Information</h2>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Admin Name</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control"  name="admin_name" value="<?= $admin_name; ?>" id="firstname">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Email</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control"  id="email" name="admin_email" value="<?= $admin_email ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Old Password</label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control"  id="adminoldpassword" name="adminoldpassword" value="" />
                                            </div>
                                            <?= $oldpassword_error ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">New Password</label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control"  id="password" name="admin_password" value="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label " style="text-align:left">Confirm Password</label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control"  id="confirm_password" name="admin_confirm_password" value="" />
                                            </div>
                                            <?= $confirm_password_error ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Profile Image</label>
                                            <div class="col-lg-6">
                                                <input type="file" maxlength="1" class="file-pos" name="admin_image">
                                                <p class="help-block">[ (29 X 29) or bigger than this according to resolution ]</p>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-8 text-center">
                                                <span><img src="<?= IMAGEURL . $admin_image ?>" width="100"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <header class="panel-heading position-center" style="position:fixed;bottom:0px;opacity:0.9;">
                                    <div class="form-group">
                                        <div class="col-lg-offset-7 col-lg-12">
                                            <button type="submit" class="btn btn-info">Submit</button>
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
                <input type="text" placeholder="Search" class="form-control">
            </div>
        </div>
        <!--right sidebar end-->
    </section>
    <style>.alert-success{    margin-top: 25px;    display: block;    width: auto;}</style>
    <div style="clear:both;"></div>
    <?php include('footer.php'); ?>
</body>
</html>