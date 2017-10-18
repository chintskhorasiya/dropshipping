<?php
session_start();
include('configure/configure.php');

include('auth.php');

accessPermission('1,7','page');

$error_message = '';

$error = 0;

if(count($_POST) > 0)

{

	if(trim($_POST['coupon_name']) == '')

	{

		$coupon_code_error = '<span class="notification-input ni-error">Enter Coupon Name.</span>';

		$error = 1;

	}

	if(trim($_POST['coupon_code']) == '')

	{

		$coupon_code_error = '<span class="notification-input ni-error">Enter Coupon Code.</span>';

		$error = 1;

	}

	if(trim($_POST['coupon_type']) == '')

	{

		$coupon_type_error = '<span class="notification-input ni-error">Select Coupon Type.</span>';

		$error = 1;

	}

	/*if(!is_numeric($_POST['coupon_discount']))

	{

		echo $coupon_discount_error = '<span class="notification-input ni-error">This field is required.</span>';

		$error = 1;

	}*/

	if($_POST['coupon_for_type'] == 1)

	{

		$_POST['coupon_for'] = 0;

	}



	if($error == 1)

	{

		$error_message = ' <div>

                                <span class="notification n-error">Please fillup all required information.</span>

                            </div>';

	}



	else

	{



			if($_POST['coupon_limit'] == 0)

			{

				$_POST['coupon_valid_from'] = '';

				$_POST['coupon_valid_to'] = '';

			}

			else if($_POST['coupon_limit'] == 1)

			{

				if($_POST['coupon_valid_from'] == '')

				{

					$_POST['coupon_limit'] = 0;

				}

				else if($_POST['coupon_valid_to'] == '')

				{

					$_POST['coupon_valid_from']	=	date("Y-m-d", strtotime($_POST['coupon_valid_from']));

					$_POST['coupon_valid_to']	=	date("Y-m-d", strtotime($_POST['coupon_valid_to']));

					$_POST['coupon_valid_to']	= $_POST['coupon_valid_from'];

				}

			}

			$_POST['coupon_date'] = $current_date;

			$insert_id = insert_data('coupons',$_POST);

			if($insert_id)

			{

				header('location:coupons.php');

				exit;

			}

	}

}

$styles 	 = include_styles('bootstrap.min.css,assets/jquery-ui/jquery-ui-1.10.1.custom.min.css,bootstrap-reset.css,font-awesome.css,DT_bootstrap.css,demo_page.css,demo_table.css,bootstrap-datepicker/css/datepicker.css,bootstrap-datetimepicker/css/datetimepicker.css,validationEngine.jquery.css,style.css,style-responsive.css');

$javascripts = include_js('lib/jquery.js,lib/jquery-1.8.3.min.js,bootstrap.min.js,accordion-menu/jquery.dcjqaccordion.2.7.js,scrollTo/jquery.scrollTo.min.js,nicescroll/jquery.nicescroll.js,scripts.js,gritter/gritter.js,jquery-1.10.2.js,jquery-ui-1.10.4.custom.js,bootstrap-datepicker/js/bootstrap-datepicker.js,bootstrap-datetimepicker/js/bootstrap-datetimepicker.js,jquery.validationEngine-en.js,jquery.validationEngine.js,acco-nav.js');

?>
<?=DOCTYPE;?>
<?=XMLNS;?>
<head>
<?=CONTENTTYPE;?>
<title>Amazon US Settings</title>
<?=$styles?>
<?=$javascripts?>
<script type="text/javascript">

$(document).ready(function(){

	$("#coupon_validate").validationEngine();

	 $( "#from" ).datepicker({

	 	minDate:0,

		changeMonth: true,

		dateFormat:'yy-mm-dd',

		numberOfMonths: 1,

		onClose: function( selectedDate ) {

			$( "#to" ).datepicker( "option", "minDate", selectedDate );

		}

	});

	$( "#to" ).datepicker({

	 	minDate:0,

		changeMonth: true,

		dateFormat:'yy-mm-dd',

		numberOfMonths: 1,

		onClose: function( selectedDate ) {

			$( "#from" ).datepicker( "option", "maxDate", selectedDate );

		}

	});

	$(".show_dates").hide();

	$("#coupon_limit").change(function(){

		$(".show_dates").toggle();

	});



	$(".show_category").hide();

	$("#coupon_for_type").change(function(){

		$(".show_category").toggle();

	});

	$(".amount").hide();

	//$(".discount").hide();

	$(".apply_on").change(function(){

		var val = $(this).val();



		if(val==1)

		{

			$(".discount").show();

			$(".amount").hide();

			$(".percentage").show();

		}

		else

		{

			$(".amount").show();

			//$(".discount").hide();

			$(".percentage").hide();

		}

	});

});

</script>
<script>

$(".form_datetime").datepicker({format: 'yyyy-mm-dd hh:ii'});

$(".form_datetime-component").datetimepicker({

    format: "dd MM yyyy - hh:ii"

});

</script> <script>        function toggle_visibility(id) {            var e = document.getElementById(id);            if (e.style.display == 'block')                e.style.display = 'none';            else                e.style.display = 'block';        }    </script><style>#panel-body {display:none;}</style>
</head>

<body>
<section id="container">

  <?php  	include('header.php');?>


  <?php include('sidebar.php');?>


  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">		  <h1>Amazon US Settings</h1>
          <section class="panel">
            <header class="panel-heading btn-primary"> Repricing Settings <br/><a href="http://support.priceyak.com/hc/en-us/articles/209253366">How repricing works</a></header>
            <div class="panel-body">
              <div class="position-center">
                <form  role="form" action="#" method="post" enctype="multipart/form-data" id="coupon_validate">
                  <div class="form-group col-md-6 padding-left-o">
                    <label>Quantity in stock</label>
                    <div class="input-group"><input type="number" class="form-control validate required" name="coupon_name" value="" style="width:95%;" />
                    <span class="h-tooltip" aria-hidden="true">?</span></div>						  <div class="tooltip"><span>When an listing is in stock on Amazon or Walmart, PriceYak will set the quantity on eBay to this number.</span></div>
                  </div>				  <div class="clear"></div>
                  <div class="form-group col-md-6 padding-left-o">
                    <label>Minimum Margin</label>
                    <div class="input-group">					<span class="input-group-addon">£</span>					<input type="number" class="form-control validate required" name="coupon_name" value=" " style="width:95%;" />                   				   <span class="h-tooltip" aria-hidden="true">?</span> </div>						  <div class="tooltip"><span>PriceYak will reprice listings to ensure that you receive at least this much profit from each sale.</span></div>
                  </div>				  <div class="clear"></div>
                   				   <p>Repricing Ranges</p>				   				     <div class="form-group col-md-3 padding-left-o">                    <label>Min Price </label> <span class="h-tooltip" aria-hidden="true">?</span>						  <div class="tooltip"><span>The percentage of the Amazon or Walmart source item you wish to make in profit after fees. PriceYak will reprice listings so you receive (margin_percent * amazon_price + margin_fixed) in profit from each sale.</span></div>                                      <div class="input-group">					<span class="input-group-addon">£</span>					<input type="number" class="form-control validate required" name="coupon_name" value="<?=$_POST['coupon_name']?>" />                    </div>				  </div>				                    <div class="form-group col-md-3">                    <label>Margin Percent </label>					<span class="h-tooltip" aria-hidden="true">?</span>  						  <div class="tooltip"><span>The fixed amount you wish to make in profit after fees. PriceYak will reprice listings so you receive (margin_percent * amazon_price + margin_fixed) in profit from each sale.</span></div>                                      <div class="input-group"> 					<input type="number" class="form-control validate required" name="coupon_name" value="<?=$_POST['coupon_name']?>" />                    <span class="input-group-addon">%</span>					</div>				    </div>									   <div class="form-group col-md-3">						<label>Margin Fixed</label>						<span class="h-tooltip" aria-hidden="true">?</span>  							  <div class="tooltip"><span>The fixed amount you wish to make in profit after fees. PriceYak will reprice listings so you receive (margin_percent * amazon_price + margin_fixed) in profit from each sale.</span></div>					  						<div class="input-group">						<span class="input-group-addon">£</span>						<input type="number" class="form-control validate required" name="coupon_name" value="<?=$_POST['coupon_name']?>" />					   </div>				   </div>				   <div class="clear"></div>

                  <input class="btn btn-info" type="submit" value="Save Repricing Settings" />
                </form>
              </div>
            </div>
          </section>		  		  <section class="panel">             <header class="panel-heading btn-primary"><a href="#" onclick="toggle_visibility('panel-body');"> Show Advanced Repricing Settings </a></header>            <div class="panel-body" id="panel-body">               <div class="position-center">                <form  role="form" action="#" method="post" enctype="multipart/form-data" id="coupon_validate">                  <div class="form-group col-md-6 padding-left-o">                    <label>Round up prices to end in $0.XX?</label>                     <input type="number" class="form-control validate required" name="coupon_name" value="" placeholder="e.g. 99" />                  </div>				  <div class="clear"></div>				  <div class="form-group">                        <div class="checkbox">                        <label>                          <input type="checkbox" name="enable-repricing" value="1" >                          Include 0.40 AO Fee</label>						 </div>                   </div>				  				  <div class="clear"></div>                  <div class="form-group col-md-6 padding-left-o">                    <label>Fixed Payment fee (usually $0.30 for PayPal)</label>                    <div class="input-group">					<span class="input-group-addon">£</span>					<input type="number" class="form-control validate required" name="coupon_name" value=" " />                    </div>				  </div>				  <div class="clear"></div>                   				   <div class="form-group col-md-6 padding-left-o">                    <label>Percentage payment fee (usually ~2.9% for PayPal)                      <div class="input-group"> 					<input type="number" class="form-control validate required" name="coupon_name" value="<?=$_POST['coupon_name']?>" />                    <span class="input-group-addon">%</span>					</div>				  </div>				   				   <div class="clear"></div>                  <div class="form-group col-md-6 padding-left-o">                    <label>Percentage Marketplace (usually 10% for eBay FVF) </label>					                      <div class="input-group"> 					<input type="number" class="form-control validate required" name="coupon_name" value="<?=$_POST['coupon_name']?>" />                    <span class="input-group-addon">%</span>					</div>				  </div>									  <div class="clear"></div>	                  <div class="form-group">                        <div class="checkbox">                        <label>                          <input type="checkbox" name="enable-repricing" value="1" >                         Lower quantity to match source market?</label>						 <span class="h-tooltip" aria-hidden="true">?</span>  						  <div class="tooltip"><span>If the market reports a quantity lower than your "Quantity in stock" value and this is checked, we will use the lower quantity reported by the marketplace."</span></div>                  					  </div>                   </div> 				   <div class="clear"></div>                                    <input class="btn btn-info" type="submit" value="Save Repricing Settings" />                 </form>              </div>            </div>          </section>				   <section class="panel">             <header class="panel-heading btn-primary">Offer Selection Settings              <span class="h-tooltip" aria-hidden="true">?</span>  						  <div class="tooltip"><span>These settings specify which offers should be considered acceptable. Both repricing and automatic ordering will use the lowest price offer						  that is considered acceptable under these settings.</span>						  </div>			</header>            <div class="panel-body">               <div class="position-center">                <form  role="form" action="#" method="post" enctype="multipart/form-data" id="coupon_validate">                  <div class="form-group col-md-6 padding-left-o">
                    <label>Maximum handling days</label>
                    <div class="input-group"><input type="number" class="form-control validate required" name="coupon_name" value="" style="width:95%;" />
                    <span class="h-tooltip" aria-hidden="true">?</span>
						  <div class="tooltip"><span>The maximum amount of time it can take for an item to ship.</span>
						  </div>
                    </div>
				   </div>
				  <div class="clear"></div>



                  <div class="form-group col-md-6 padding-left-o">
                    <label>Shipping method</label>
                    <div class="input-group">
					<select class="form-control input-lg m-bot15" name="Shippingmethod" id="Shippingmethod" style="width: 95%;">
                      <option value="0">Select One</option>
					  <option value="1">free</option>
					  <option value="2">cheapest</option>
                    </select>
					   <span class="h-tooltip" aria-hidden="true">?</span>
						  <div class="tooltip"><span>Shipping method to use for products fulfilled from Amazon</span>
						  </div>
                    </div>
				  </div>				   <div class="clear"></div>				    <div class="form-group">                        <div class="checkbox">                        <label>                          <input type="checkbox" name="enable-repricing" checked value="1" disabled>                          Allow offers sold by Amazon</label>						 </div>                     </div> 				    <div class="clear"></div>                   				    <div class="form-group">                        <div class="checkbox">                        <label>                          <input type="checkbox" name="enable-repricing"  checked value="1">                         Allow third party FBA offers</label>						 <span class="h-tooltip" aria-hidden="true">?</span>  						  <div class="tooltip"><span>Allow 3rd party offers fulfilled by amazon to be considered.</span>						  </div>						 </div>                     </div> 				    <div class="clear"></div>										<div class="form-group">                        <div class="checkbox">                        <label>                          <input type="checkbox" name="enable-repricing" value="1">                          Allow third party merchant-fulfilled offers</label>						  <span class="h-tooltip" aria-hidden="true">?</span>  						  <div class="tooltip"><span>Allow 3rd party offers fulfilled by the 3rd party to be considered.</span>						  </div>						 </div>                     </div> 				    <div class="clear"></div>				   				   <div class="form-group col-md-6 padding-left-o">                    <label>Minimum number of feedbacks </label>                    <div class="input-group"> 					<input type="number" class="form-control validate required" name="coupon_name" value="" /> 					      					</div>				  </div>				   				   <div class="clear"></div>                  <div class="form-group col-md-6 padding-left-o">                    <label>Minimum positive feedback percentage </label>					                      <div class="input-group"> 					<input type="number" class="form-control validate required" name="coupon_name" value="" />                    <span class="input-group-addon">%</span>					     					</div>				  </div>									  <div class="clear"></div>	                  <div class="form-group">                        <div class="checkbox">                        <label>                          <input type="checkbox" name="enable-repricing" value="1" >                         Allow international offers</label>						 <span class="h-tooltip" aria-hidden="true">?</span>  						  <div class="tooltip"><span>If the market reports a quantity lower than your "Quantity in stock" value and this is checked, we will use the lower quantity reported by the marketplace."</span></div>                  					  </div>                   </div> 				   <div class="clear"></div>	                  <div class="form-group">                        <div class="checkbox">                        <label>                          <input type="checkbox" name="enable-repricing" value="1" >                         Allow "Prime Only" offers</label>						 <span class="h-tooltip" aria-hidden="true">?</span>  						  <div class="tooltip"><span>If the market reports a quantity lower than your "Quantity in stock" value and this is checked, we will use the lower quantity reported by the marketplace."</span></div>                  					  </div>                   </div>				  				  <div class="clear"></div>	                  <div class="form-group">                        <div class="checkbox">                        <label>                          <input type="checkbox" name="enable-repricing" value="1" >                         Allow "Add-on" offers</label>						 <span class="h-tooltip" aria-hidden="true">?</span>  						  <div class="tooltip"><span>If the market reports a quantity lower than your "Quantity in stock" value and this is checked, we will use the lower quantity reported by the marketplace."</span></div>                  					  </div>                   </div>                                    <input class="btn btn-info" type="submit" value="Save Settings" />                 </form>              </div>            </div>          </section>
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