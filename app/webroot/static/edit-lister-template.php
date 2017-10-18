<?php 
session_start();
include('configure/configure.php');

include('auth.php');

$error_message = '';

$error = 0;	

if(count($_POST) > 0)

{

	/*if(trim($_POST['faq_cat_id_main']) == '')

	{

		$faq_cat_error = '<label class="alert-danger fade in">Please Select Sub Category</label>';	

		$error = 1;

	} */

	if($_POST['faq_cat_id'] == 0){

		$_POST['faq_cat_id'] = $_POST['faq_cat_id_main'];

	}

	unset($_POST['faq_cat_id_main']);

	if(trim($_POST['faq_ans']) == '')

	{

		$faq_ans_error = '<label class="alert-danger fade in">This field is required answer.</label>';	

		$error = 1;

	}

	if(trim($_POST['faq_que']) == '')

	{

		$faq_que_error = '<label class="alert-danger fade in">This field is required question.</label>';	

		$error = 1;

	}

	if($error == 1)

	{

		$error_message = '<label class="alert alert-block alert-danger fade in col-lg-12 col-sm-6">Please fillup all required information.</label>';

	}

	else

	{

			$_POST['faq_created_date'] = $current_date;

			$_POST['faq_cat_id'] = $_POST['faq_cat_id'][0];

			$insert_id = insert_data('faq',$_POST);

			if($insert_id)

			{

				header('location:faq.php');

				exit;

			}

	}	

}

$styles 	 = include_styles('bootstrap.min.css,assets/jquery-ui/jquery-ui-1.10.1.custom.min.css,bootstrap-reset.css,font-awesome.css,jquery-jvectormap-1.2.2.css,css3clock/css/style.css,morris-chart/morris.css,jquery.wysiwyg.css,style.css,style-responsive.css');

$javascripts = include_js('lib/jquery.js,lib/jquery-1.8.3.min.js,bootstrap.min.js,accordion-menu/jquery.dcjqaccordion.2.7.js,scrollTo/jquery.scrollTo.min.js,nicescroll/jquery.nicescroll.js,scripts.js,gritter/gritter.js,easypiechart/jquery.easypiechart.js,sparkline/jquery.sparkline.js,flot-chart/jquery.flot.js,flot-chart/jquery.flot.tooltip.min.js,flot-chart/jquery.flot.resize.js,flot-chart/jquery.flot.pie.resize.js,jquery.wysiwyg.js,acco-nav.js');

?>
<?=DOCTYPE;?>
<?=XMLNS;?>
<head>
<?=CONTENTTYPE;?>
<title>Listing Template</title>
<?=$styles?>
<?=$javascripts?>

<!-- Initiate WYIWYG text area -->

<script type="text/javascript">

	$(function()

	{

		$('.wysiwyg1').wysiwyg(

		{

		controls : {

		separator01 : { visible : true },

		separator03 : { visible : true },

		separator04 : { visible : true },

		separator00 : { visible : true },

		separator07 : { visible : false },

		separator02 : { visible : false },

		separator08 : { visible : false },

		insertOrderedList : { visible : true },

		insertUnorderedList : { visible : true },

		undo: { visible : true },

		redo: { visible : true },

		justifyLeft: { visible : true },

		justifyCenter: { visible : true },

		justifyRight: { visible : true },

		justifyFull: { visible : true },

		subscript: { visible : true },

		superscript: { visible : true },

		underline: { visible : true },

		increaseFontSize : { visible : false },

		decreaseFontSize : { visible : false }

		}

		} );

	});

</script>
<script language="javascript" type="text/javascript">

$(document).ready(function(){

var ajax_category_url = 'ajax-faq-dropdown.php';

		//var ajax_category_variation_url = 'ajax-category-variation.php';

		$('.faq_cat_id').live('change',function(){

				

				var cat_parent = $(this).val(); 

				var thisNode = $(this); 

				var data_rel = $(this).attr('data-rel'); 

				$.post(ajax_category_url,{cat_parent:cat_parent,level:0,data_rel:data_rel}, function(data) {

					  if(data != '')

						  $('.first_'+data_rel).remove();

						  thisNode.parent().after(data);

					  $('.faq_cat_parent_id').trigger('change');

				});

				for (var i=Number(data_rel);i<20;i++)

				{

					$('.first_'+i).remove();

				}

				/*$.post(ajax_category_variation_url,{cat_parent:cat_parent,level:0}, function(data) {

						  $('.left-part').html(data);

				});*/

		});

		/*$(".add-new-vari").live("click", function(){

			var txt_obj = $(this).parents('.variation-field').find("input");

			var txt_new_val = txt_obj.val();

			var vari_data_id = txt_obj.attr('data-variation-id');

			var data_id_pk = txt_obj.attr('data-id-pk');

			//if($(".right-part").hasClass('vari-val-'+vari_data_id)){

			var chk_class = $('.right-part .vari-val-'+vari_data_id).length;

			//}

			//alert('.right-part vari-val-'+vari_data_id);

			//$(this).parents('.variation-field').clone().insertBefore($(this).parents('.variation-field'));

			//alert(vari_data_id);

			if(txt_new_val == ""){

				alert("Please Enter Value");

			} else {

				if(chk_class == 0){

					$('.right-part').append('<span class="vari-val-'+vari_data_id+'"><input class="input-short" readonly type="text" value="'+txt_new_val+'" name="variation_data['+vari_data_id+'][]" /><button class="delete-vari">X</button></span>')

				} else {

					$('.right-part .vari-val-'+vari_data_id+':last').after('<span class="vari-val-'+vari_data_id+'"><input class="input-short" readonly type="text" value="'+txt_new_val+'" name="variation_data['+vari_data_id+'][]" /><button class="delete-vari">X</button></span>')

				}

			}

		});

		$(".delete-vari").live("click", function(){

			var par_class = $(this).parent().attr('class');

			var chk_class =$('.right-part '+par_class).length;

			//alert(chk_class);

			var txt_obj = $(this).parents('span').remove();

			

		});*/

});

</script>
</head>

<body>
<section id="container"> 
  
  <?php  include('header.php');?>
   
  <?php include('sidebar.php');?>
  
 
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <section class="panel  border-o">
            <header class="panel-heading btn-primary"> Edit Lister Template</header>
            <div class="panel-body">
              <div class="position-center">			     <p>Please create a Mustache template for your listing descriptions. You can use the following variables:</p>
					 <ul style="padding: 5px 17px;">
						 <li><code>{{title}}</code> -- string title of the product</li>
						 <li><code>{{#product_details}}{{.}}{{/product_details}}</code> -- a list of product details</li>
						 <li><code>{{{product_description}}}</code> -- raw HTML of the product description</li>
						 <li><code>{{#feature_bullets}}{{.}}{{/feature_bullets}}</code> -- a list of product features</li>
						 <li><code>(img src={{main_image}})</code> -- the main image for the product</li>
						 <li><code>{{#images}}(img src={{.}}){{/images}}</code> -- show all product pictures</li>
                     </ul>
				<p>We have a few precreated templates to choose from. We don't provide support for template building, 
				but here's how to do it yourself!</p>
				<p>You can also buy fully PriceYak compatible templates from CrazyLister (use coupon code CLPY100).</p>				 									
                <form  role="form" action="" method="post">
                 
				 <span class="export-b">
                 <input type="submit" class="btn btn-info" value="Precreated Templates" data-toggle="dropdown" aria-expanded="false">
                 <span class="caret" data-toggle="dropdown" aria-expanded="false"></span>
                          <ul class="dropdown-menu">
                            <li><a href="#">Default Template</a></li>
                            <li><a href="#">Alternative Template</a></li>
                            <li><a href="#">Modern Template</a></li>
                          </ul>
                </span>
				
				<span class="export-b">
                 <input type="submit" class="btn btn-info" value="Reset Changes"> 
				 </span> 
				 <input type="submit" class="btn btn-info" value="Save Changes"> 				  <div class="clear"></div>				  
                   
				   
				   
                </form>
              </div>			  <p>&nbsp;</p>			   
            </div>
			
				  
					<div class="col-md-6">
					  <h3>Code Editor</h3>
					  <div class="code-editor-box">
						 <pre id="editor">xxx</pre> 
					  </div>
					</div>
					<div class="col-md-6">
					 <h3>Live Preview</h3>
					 <div class="code-editor-box">
						 <div id="return"></div> 
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
  <script src="js/jquery.min.js"></script>
<script src="js/ace.js"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/twilight");
    editor.session.setMode("ace/mode/html");

    function showHTML() {
        $('#return').html(editor.getValue());
    }
    // or use data: url to handle things like doctype
    function showHTMLInIFrame() {
        $('#return').html("<iframe src=" +
             "data:text/html," + encodeURIComponent(editor.getValue()) +
        "></iframe>");
    }
    editor.on("input", showHTMLInIFrame)
</script>
</section>
</body>
</html>