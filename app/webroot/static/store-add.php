<?php
session_start();
include('configure/configure.php');

include('auth.php');

accessPermission('1,5','page');

$error_message = '';

$error = 0;

if(count($_POST) > 0)

{



	if(trim($_POST['store_fullname']) == '')

	{

		$store_fname_error = '<label class="alert-danger fade in">This field is required.</label>';

		$error = 1;

	}





	if(trim($_POST['store_password']) == '')

	{

		$store_password_error = '<label class="alert-danger fade in">This field is required.</label>';

		$error = 1;

	}

	if(strlen(trim($_POST['store_password'])) < 8)

	{

		$store_password_error = '<label class="alert-danger fade in">Password length should be greater than 7.</label>';

		$error = 1;

	}





	if(!validate_email($_POST['store_email']))

	{

		$store_email_error = '<label class="alert-danger fade in">Email address is not valid.</label>';

		$error = 1;

	}



	if(store_duplicate_email(trim($_POST['store_email'])) > 0)

	{

		$store_email_error = '<label class="alert-danger fade in">Email Already Exists.</label>';

		$error = 1;

	}



	if(trim($_POST['store_name']) == '')

	{

		$store_name_error = '<label class="alert-danger fade in">This field is required.</label>';

		$error = 1;

	}

	if(store_duplicate_name(trim($_POST['store_name'])) > 0)

	{

		$store_name_error = '<label class="alert-danger fade in">Store Name already exists.</label>';

		$error = 1;

	}



	if(trim($_POST['store_url']) == '')

	{

		$store_url_error = '<label class="alert-danger fade in">This field is required.</label>';

		$error = 1;

	}

	else if(store_duplicate_url(trim($_POST['store_url'])) > 0)

	{

		$store_url_error = '<label class="alert-danger fade in">Store Url already exists.</label>';

		$error = 1;

	}

	if(!store_valid_url(trim($_POST['store_url'])))

	{

		$store_url_error = '<label class="alert-danger fade in">Store Url not valid.</label>';

		$error = 1;

	}



	if($_FILES['store_icon']['name'] == '')

	{

		$store_icon_error = '<label class="alert-danger fade in">This field is required.</label>';

		$error = 1;

	}



	if(trim($_POST['store_address']) == '')

	{

		$store_address_error = '<label class="alert-danger fade in">This field is required.</label>';

		$error = 1;

	}

	if(trim($_POST['store_phone']) == '')

	{

		$store_phone_error = '<label class="alert-danger fade in">This field is required.</label>';

		$error = 1;

	}

	if(trim($_POST['store_country']) == '' || trim($_POST['store_country']) == '0')

	{

		$store_country_error = '<label class="alert-danger fade in">This field is required  for country. </label>';

		$error = 1;

	}

	if(trim($_POST['store_state']) == '' || trim($_POST['store_state']) == '0')

	{

		$store_state_error = '<label class="alert-danger fade in">This field is required  for state. </label>';

		$error = 1;

	}

	if(trim($_POST['store_city']) == '' || trim($_POST['store_city']) == '0')

	{

		$store_city_error = '<label class="alert-danger fade in">This field is required  for City. </label>';

		$error = 1;

	}



	if($error == 1)

	{

		$error_message = ' <div>

                                <label class="alert alert-block alert-danger fade in col-lg-11 col-sm-6">Please fillup all required information.</label>

                            </div>';

	}

	else

	{



		if($_FILES['store_icon']['name'] != '')

		{

			$image_name = upload_image($_FILES['store_icon'],STOREICONPATH,STOREICON_THUMBPATH,'156','106');

			if($image_name)

			{

				$_POST['store_icon'] = $image_name;

			}

		}



		$_POST['store_created_date']  = $current_date;

		$_POST['store_modified_date'] = $current_date;

		$_POST['store_pwd'] 		  = set_password($_POST['store_password']);

		$_POST['store_password'] 	  = encrypt_password($_POST['store_password']);







		$insert_id = insert_data('store',$_POST);

		if($insert_id)

		{

			send_store_registration_email($insert_id);

			header('location:stores.php');

			exit;

		}

		else

		{

			echo mysql_error();

		}

	}

}

$styles 	 = include_styles('bootstrap.min.css,assets/jquery-ui/jquery-ui-1.10.1.custom.min.css,bootstrap-reset.css,font-awesome.css,jquery-jvectormap-1.2.2.css,css3clock/css/style.css,morris-chart/morris.css,DT_bootstrap.css,demo_page.css,demo_table.css,jquery.wysiwyg.css,style.css,style-responsive.css');

$javascripts = include_js('lib/jquery.js,lib/jquery-1.8.3.min.js,bootstrap.min.js,accordion-menu/jquery.dcjqaccordion.2.7.js,scrollTo/jquery.scrollTo.min.js,nicescroll/jquery.nicescroll.js,scripts.js,gritter/gritter.js,jquery.MultiFile.js,acco-nav.js');

?>
<?=DOCTYPE;?>
<?=XMLNS;?>
<head>
<?=CONTENTTYPE;?>
<title>Store Add</title>
<?=$styles?>
<?=$javascripts?>
<script language="javascript" type="text/javascript">

$(document).ready(function(){

		var ajax_state_url = 'ajax-state-dropdown.php';

		$('.store_country').change(function(){



				var state = $(this).val();

				$.post(ajax_state_url,{state:state}, function(data) {

					  if(data != '')

						  $('.store_state').html(data);



					  $('.store_state').trigger('change');

				});

		});

		var ajax_city_url = 'ajax-city-dropdown.php';

		$('.store_state').change(function(){



				var state = $(this).val();

				var country = $('.store_country').val();



				$.post(ajax_city_url,{state:state,country:country}, function(data) {

					  if(data != '')

						  $('.store_city').html(data);

				});

		});



});

</script>
<style>
.form-control {
	width: 59%;
	font-size: 13px;
}
select.input-lg, .input-lg {
	height: auto;
	padding: 6px 8px;
}
</style>

<!-- Initiate tablesorter script -->

</head>

<body>
<section id="container">

  <!--header start-->

  <?php  	include('header.php');?>

  <!--header end-->

  <!--sidebar start-->

  <?php include('sidebar.php');?>

  <!--sidebar end-->

  <!--main content start-->

  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading btn-primary"> Select a destination market (store) you'd like to add: </header>
            <div class="panel-body">
              <div class="position-center">
                  <p>Note: We DO support using one eBay account to list to multiple countries				(e.g. eBay.com and eBay.co.uk), <a href="#">but you need to contact us first.</a></p>
                <form role="form" enctype="multipart/form-data" method="post" action="#">

                  <div class="form-group">
                    <label>Destination market</label>
                    <select class="form-control input-lg m-bot15" name="destinationMarket" id="destinationMarket">
                      <option value="0">Select One</option>					  <option value="1">Amazon US</option>					  <option value="2">Amazon UK</option>
                    </select>

                  </div>

                  <input type="submit" class="btn btn-info" value="Submit">
                </form>
              </div>
            </div>
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
</body>
</html>