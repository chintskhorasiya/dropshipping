//left side accordion
	
(function ($) {
    "use strict";
// Load function
$( window ).load(function() {
	// Add Active class on actived URL element
	var current_url = window.location.href;
	$('ul.sidebar-menu li a').each(function(){
		$(this).removeClass('active');
		$('.sidebar-menu li').removeClass('active');
		var url = $(this).attr("href");
		if(url == current_url){
			$(this).parents('li').find('a').addClass('active');
			$(this).parents('li').addClass('list');
			$(this).parents('li').find('.sub').slideDown('slow');
			  var o = ($(this).offset());
			  var diff = 200 - o.top;
			  if (diff > 0)
				  $(".leftside-navigation").scrollTo("-=" + Math.abs(diff), 500);
			  else
				  $(".leftside-navigation").scrollTo("+=" + Math.abs(diff), 500);
		}
	});
});
 
//	End Load Function
$(document).ready(function () {
	 
	//Allowing letters only in a text input
	
	if ($.fn.validate) {
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[a-z]+$/i.test(value);
		}, "Only alphanumeric allowed"); 
		$("#userCreate").validate({
			rules: {
				user_full_name: "required",
				user_name: {
					lettersonly:true, //Only Characters
					required: true,
					minlength: 2
				},
				user_password: {
					required: true,
					minlength: 7
				},
				/*confirm_password: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				},*/
				user_email: {
					required: true,
					email: true
				}
			},
			messages: {
				user_full_name: "Please enter your full name",
				user_name: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 2 characters"
				},
				user_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
			   
				user_email: "Please enter a valid email address",
			}
		});
	}
	$('.btnDel').attr('disabled','disabled');
	$('.btnAdd').click(function() {
		var clonedInput = $(this).attr('rel');
		
		var num     = $('.'+clonedInput).length; // how many "duplicatable" input fields we currently have
		var newNum  = new Number(num + 1);      // the numeric ID of the new input field being added
	
		// create the new element via clone(), and manipulate it's ID using newNum value
		var newElem = $('#'+clonedInput + num).clone().attr('id', clonedInput + newNum);
	
		// manipulate the name/id values of the input inside the new element
		newElem.children(':first').attr('id', 'name' + newNum).attr('name', 'name' + newNum);
	
		// insert the new element after the last "duplicatable" input field
		$('#'+clonedInput + num).after(newElem);
	
		// enable the "remove" button
		$('.del_'+clonedInput).attr('disabled',false);
		// business rule: you can only add 5 names
		//if (newNum == 5)
			//$('#btnAdd').attr('disabled','disabled');
	});
	
	$('.btnDel').on('click', function() {
		var clonedInput = $(this).attr('rel');
		var num = $('.'+clonedInput).length; // how many "duplicatable" input fields we currently have
		$('#'+clonedInput + num).remove();     // remove the last element
	
		// if only one element remains, disable the "remove" button
		if (num-1 == 1)
			$(this).attr('disabled','disabled');
	});
	
	
	$('.cust-del').on('click', function(){
		$(this).parents('.row-main').remove();
		if(($('.row-main').length) ==0){
			$('.clonedInput input[type="text"]').attr('required','required');
		}
	});
});
 
})(jQuery);
$(function() {
	if ($.fn.colorpicker) {
		$('.colorpicker-default').colorpicker({
			format: 'hex'
		});
	}
     if ($.fn.dcAccordion) {
		 
            $('#nav-accordion').dcAccordion({
                eventType: 'click',
                autoClose: true,
                saveState: true,
                disableLink: true,
                speed: 'slow',
                showCount: false,
                autoExpand: true,
                classExpand: 'dcjq-current-parent'
            });
        }
        /*==Slim Scroll ==*/
        if ($.fn.slimScroll) {
            $('.event-list').slimscroll({
                height: '305px',
                wheelStep: 20
            });
            $('.conversation-list').slimscroll({
                height: '360px',
                wheelStep: 35
            });
            $('.to-do-list').slimscroll({
                height: '300px',
                wheelStep: 35
            });
        }
        /*==Nice Scroll ==*/

        if ($.fn.niceScroll) {
            $(".leftside-navigation").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $(".leftside-navigation").getNiceScroll().resize();
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();

            $(".right-stat-bar").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

        }
		$('.sidebar-toggle-box .fa-bars').click(function (e) {

            $(".leftside-navigation").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $('#sidebar').toggleClass('hide-left-bar');
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();
            $('#main-content').toggleClass('merge-left');
            e.stopPropagation();
            if ($('#container').hasClass('open-right-panel')) {
                $('#container').removeClass('open-right-panel')
            }
            if ($('.right-sidebar').hasClass('open-right-bar')) {
                $('.right-sidebar').removeClass('open-right-bar')
            }

            if ($('.header').hasClass('merge-header')) {
                $('.header').removeClass('merge-header')
            }


        });


});


var Script = function () {

    //  menu auto scrolling

    /*jQuery('#sidebar .sub-menu > a').click(function () {
        var o = ($(this).offset());
        diff = 80 - o.top;
        if(diff>0)
            $("#sidebar").scrollTo("-="+Math.abs(diff),500);
        else
            $("#sidebar").scrollTo("+="+Math.abs(diff),500);
    });*/

    // toggle bar

    $(function() {
        var wd;
        wd = $(window).width();
        function responsiveView() {
            var newd = $(window).width();
            if(newd==wd){
                return true;
            }else{
                wd = newd;
            }
            var wSize = $(window).width();
            if (wSize <= 768) {
                $('#sidebar').addClass('hide-left-bar');

            }
        else{
                $('#sidebar').removeClass('hide-left-bar');
            }

        }
        $(window).on('load', responsiveView);
        $(window).on('resize', responsiveView);




    });

    
    $('.toggle-right-box .fa-bars').click(function (e) {
        $('#container').toggleClass('open-right-panel');
        $('.right-sidebar').toggleClass('open-right-bar');
        $('.header').toggleClass('merge-header');

        e.stopPropagation();
    });

    $('.header,#main-content,#sidebar').click(function () {
       if( $('#container').hasClass('open-right-panel')){
           $('#container').removeClass('open-right-panel')
       }
        if( $('.right-sidebar').hasClass('open-right-bar')){
            $('.right-sidebar').removeClass('open-right-bar')
        }

        if( $('.header').hasClass('merge-header')){
            $('.header').removeClass('merge-header')
        }


    });


   // custom scroll bar
    


   // widget tools

    jQuery('.panel .tools .fa-chevron-down').click(function () {
        var el = jQuery(this).parents(".panel").children(".panel-body");
        if (jQuery(this).hasClass("fa-chevron-down")) {
            jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200);
        }
    });

    jQuery('.panel .tools .fa-times').click(function () {
        jQuery(this).parents(".panel").parent().remove();
    });

   // tool tips

    $('.tooltips').tooltip();

    // popovers

    $('.popovers').popover();

    // notification pie chart
function pie_chart()
{
        $('.notification-pie-chart').easyPieChart({
            onStep: function(from, to, percent) {
                $(this.el).find('.percent').text(Math.round(percent));
            },
            barColor: "#39b6ac",
            lineWidth: 3,
            size:50,
            trackColor: "#efefef",
            scaleColor:"#cccccc"

        });

 }
function plot()
{
        var datatPie = [30,50];
// DONUT
        $.plot($(".target-sell"), datatPie,
            {
                series: {
                    pie: {
                        innerRadius: 0.6,
                        show: true,
                        label: {
                            show: false

                        },
                        stroke: {
                            width:.01,
                            color: '#fff'

                        }
                    }
                },

                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                    clickable: true
                },

                colors: ["#ff6d60", "#cbcdd9"]
            });
}
function easy_piechart()
{
        $('.pc-epie-chart').easyPieChart({
            onStep: function(from, to, percent) {
                $(this.el).find('.percent').text(Math.round(percent));
            },
            barColor: "#5bc6f0",
            lineWidth: 3,
            size:50,
            trackColor: "#32323a",
            scaleColor:"#cccccc"
		 });

}
function d_pending()
{
        $(".d-pending").sparkline([3,1], {
            type: 'pie',
            width: '40',
            height: '40',
            sliceColors: ['#e1e1e1','#8175c9']
        });
}
// SPARKLINE
    $(function () {
        var sparkLine = function () {
            $(".sparkline").each(function(){
                var $data = $(this).data();
                ($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
                ($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));

                $data.valueSpots = {'0:': $data.spotColor};
                $(this).sparkline( $data.data || "html", $data);


                if($(this).data("compositeData")){
                    $spdata = $(this).data("compositeConfig");
                    $spdata.composite = true;
                    $spdata.minSpotColor = false;
                    $spdata.maxSpotColor = false;
                    $spdata.valueSpots = {'0:': $spdata.spotColor};
                    $(this).sparkline($(this).data("compositeData"), $spdata);
                };
            });
        };

        var sparkResize;
        $(window).resize(function (e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(function () {
                sparkLine(true)
            }, 500);
        });
        sparkLine(false);
    });

    /*==Collapsible==*/
    $(function() {
        $('.widget-head').click(function(e)
        {
            var widgetElem = $(this).children('.widget-collapse').children('i');

            $(this)
                .next('.widget-container')
                .slideToggle('slow');
            if ($(widgetElem).hasClass('ico-minus')) {
                $(widgetElem).removeClass('ico-minus');
                $(widgetElem).addClass('ico-plus');
            }
            else
            {
                $(widgetElem).removeClass('ico-plus');
                $(widgetElem).addClass('ico-minus');
            }
            e.preventDefault();
        });

    });
	$(document).scroll(function () {
			if ($(window).scrollTop() >= $(document).height() - $(window).height() - 100 ) {
				$('#action-div').removeClass('fix-action');
				
			} else {
				$('#action-div').addClass('fix-action');
		}
	});
}();