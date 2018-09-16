
(function($){
	'use strict';
	var FW = {
		owlCarousel: function(){
			if($('.owl-carousel[data-owl]').length > 0){
				$('.owl-carousel[data-owl]').each(function(){
					var item = $(this).attr('data-owl'),
						autoplay = $(this).attr('data-autoplay'),
						rtl = $(this).attr('data-rtl'),
						duration = $(this).attr('data-duration'),
						loop = $(this).attr('data-loop'),
						margin = $(this).attr('data-margin'),
                		nav = $(this).attr('data-nav'),
                		pagination = $(this).attr('data-pagination');
					var defaults = {
	                    // Most important owl features
	                    items : item ? parseInt(item) : 3,
	                    rtl: rtl ? rtl : false,
	                    autoplay: autoplay ? autoplay : false,
	                    autoplayHoverPause: true,
	                    margin: margin ? parseInt(margin): 0,
	                    nav: nav ? true : false,
	                    loop: loop ? true : false,
	                    slide_duration: duration ? parseInt(duration) : 1000,
	                    dots: pagination ? pagination : false,
	                    navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
	                    slideBy: 1,
	                };
                	var config = {};
                	if(item >= 3){
	                	config = {
	                		responsive: {
		                        0: {
		                            items: 1
		                        },
		                        500: {
		                            items: 2
		                        },
		                        991: {
		                            items: item ? parseInt(item) : 3,
		                        }
		                    }
	                	}
                	}else{
                		config = {
	                        responsive: {
	                            0: {
	                                items: 1
	                            },
	                            500: {
	                                items: item ? parseInt(item) : 1
	                            },
	                            991: {
	                                items: item ? parseInt(item) : 1
	                            }
	                        }
	                    }
                	}
                	var configs = $.extend(defaults, config);
	                // Initialize Slider
	                $(this).owlCarousel(configs);
				});
			}
		},
		testimonial_sync: function(){
			if($('.testimonial-carousel').length > 0){
                $('.testimonial-carousel').each(function(){
                    var testimonial_id = $(this).attr('id'),
                        autoplay = $(this).attr('data-autoplay'),
                        rtl = $(this).attr('data-rtl');
                        var sync1    = $('#sync1','#'+ testimonial_id);
                        var sync2    = $('#sync2','#'+ testimonial_id);
                        var flag     = false;
                        var duration = 500;
                        sync1.owlCarousel({
                                items: 1,
                                margin: 0,
                                autoplay: autoplay ? autoplay : false,
                                nav: false,
                                rtl : rtl ? rtl : false,
                                navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                                dots: true
                            })
                            .on('changed.owl.carousel', function (e) {
                                if (!flag) {
                                    flag = true;
                                    sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
                                    flag = false;
                                }

                                // Add class synced to current slide
                                var current = e.item.index;
                                sync2
                                    .find(".owl-item")
                                    .removeClass("synced")
                                    .eq(current)
                                    .addClass("synced");
                            });

                        sync2.owlCarousel({
                                margin: 0,
                                items: 3,
                                nav: true,
                                rtl : rtl ? rtl : false,
                                navText: ["<i class='fa fa-long-arrow-left'</i>","<i class='fa fa-long-arrow-right'</i>"],
                                center: false,
                                dots: false,
                                responsive: {
                                   0: {
                                       items: 1
                                   },
                                   500: {
                                       items: 3
                                   },
                               },
                                onInitialized : function(){
                                    sync2.find(".owl-item").eq(0).addClass("synced");
                                }
                            })
                            .on('click', '.owl-item', function () {
                                sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
                            })
                            .on('changed.owl.carousel', function (e) {
                                if (!flag) {
                                    flag = true;        
                                    sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
                                    flag = false;
                                }
                            });
                    
                });
            }
	    },
		/*--------------- COUNTER ---------------*/
	    countAppear: function(){
	          if ($(".gr-animated").length > 0){

	            $(".gr-animated").appear();

	            $(document.body).on("appear", ".gr-animated", function () {
	              $(this).addClass("go");
	            });

	            $(document.body).on("disappear", ".gr-animated", function () {
	              $(this).removeClass("go");
	          });
	         }
	    },
	    countProcess: function(){
	        if (!$(".gr-number-counter").length) return;
	        $(".gr-number-counter").appear(); // require jquery-appear
	        $('body').on("appear", ".gr-number-counter", function () {
	          var counter = $(this);
	          if (!counter.hasClass("count-complete")) {
	              counter.countTo({
	                speed: 1500,
	                refreshInterval: 100,
	                onComplete: function () {
	                  counter.addClass("count-complete");
	                }
	              });
	          }
	        });
	        $('body').on("disappear", ".gr-number-counter", function () {
	          $(this).removeClass("count-complete");
	        });
	    },
	    /*------------ COUNT DOWN --------------*/
	    sc_countdown_circle:function(){
	      if($('.circle-style').length > 0){
	        $('.circle-style').each(function(){
	          var circle_id = $(this).attr('id'),
	              diff = $(this).attr('data-time');
	          $('#' + circle_id + ' .countdown-content').redCountdown({
	              end: $.now() + parseInt(diff),
	              labels: true,
	              style: {
	                  element: "",
	                  textResponsive: .5,
	                  daysElement: {
	                      gauge: {
	                          thickness: .03,
	                          bgColor: "rgba(255,255,255,0.05)",
	                          fgColor: "#ffffff"
	                      },
	                      textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#fff;'
	                  },
	                  hoursElement: {
	                      gauge: {
	                          thickness: .03,
	                          bgColor: "rgba(255,255,255,0.05)",
	                          fgColor: "#ffffff"
	                      },
	                      textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#fff;'
	                  },
	                  minutesElement: {
	                      gauge: {
	                          thickness: .03,
	                          bgColor: "rgba(255,255,255,0.05)",
	                          fgColor: "#ffffff"
	                      },
	                      textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#fff;'
	                  },
	                  secondsElement: {
	                      gauge: {
	                          thickness: .03,
	                          bgColor: "rgba(255,255,255,0.05)",
	                          fgColor: "#ffffff"
	                      },
	                      textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#fff;'
	                  }
	                  
	              },
	              onEndCallback: function() { console.log("Time out!"); }
	          });
	        });
	      }
	    },
	    sc_countdown_number: function(){
	      if($('.number-style').length > 0){
	        var days    = sc_countdown.days;
	        var hours   = sc_countdown.hours;
	        var minutes = sc_countdown.minutes;
	        var seconds = sc_countdown.seconds;
	        $('.number-style').each(function(){
	          var number_id = $(this).attr('id'),
	              date_time = $(this).attr('data-time');
	          $('#'+ number_id + ' .countdown-content' ).countdown(date_time, function(event) {
	            $(this).html(
	                event.strftime('<ul class="list-time"><li class="cd-days"><p class="countdown-number">%D</p> <p>' + days + '</p></li> <li class="cd-hours"><p class="countdown-number">%H</p><p>' + hours + '</p></li> <li class="cd-minutes"><p class="countdown-number">%M</p><p>' + minutes + '</p></li> <li  class="cd-seconds"> <p class="countdown-number">%S</p><p>' + seconds + '</p></li></ul>')
	              );
	          });
	        });
	      }
	    },
	    /*Popup callback*/
	    popupInfo: function(){
	      if($('.yolo-teammember').length > 0){
	          $('.teammember-content').click(function(){
	              var $id = $(this).attr('data-option-id');
	              $('.yolo-team-fix').addClass('db');

	              $.ajax({
	                 url: yolo_framework_ajax_url,
	                 type: 'POST',
	                 data: ({
	                      action: 'yolo_team_detail',
	                      id:     $id
	                  }),
	                 success: function(data){
	                      if(data){
	                          $('.yolo-team-fix').addClass('bk-noimage');
	                          $('.yolo-team-wrap').html(data);
	                          $('.yolo-team-wrap').animate({
	                              'top': '50%',
	                              opacity: 1
	                          },350,function(){

	                          });

	                          $('.team-remove').click(function(){

	                              $('.yolo-team-wrap').animate({
	                                  'top': '80%',
	                                  opacity: 0
	                              },350,function(){
	                                  $('.yolo-team-fix').removeClass('bk-noimage');
	                                  $('.yolo-team-fix').removeClass('db');
	                              });

	                          });
	                      }
	                  }
	              });
	          });
	      	}
	    },
	    sc_video: function(){
			if( ! $('.yolo-video-player').length ) //Check empty
				return;
			$('.yolo-video-player').each(function(){
		    	var id = $(this).attr('id');
		    	$('#'+ id +' .video-close').click( function(){
		            $(this).parent().find('iframe').remove();
		            $(this).parent().animate({opacity:0},function(){$(this).hide();});
		        });
		        $('#'+ id +' .play-button').click( function(){
		            var url = $(this).data('video');
		            var height = $(this).data('height'),
		            	yolo_width = $(this).data('width');
		            var embed,id = $(this).data('id');
		            if( url.indexOf('youtube.com') > -1 ){
		                embed = 'http://www.youtube.com/embed/'+id+'?autoplay=1';
		            }else if( url.indexOf('vimeo.com') > -1 ){
		                embed = 'http://player.vimeo.com/video/'+id+'?autoplay=1';
		            }
		            var w = $(window).width();
		            /* iframe default */
		             if ( yolo_width == 'default' ) {
		                $(this).closest('.yolo-video-player')
		                    .find('.iframe-video-player')
		                    .append('<iframe allowfullscreen style="height:'+height+'px;width:100%;position:absolute;top:0;" src="'+embed+'"></iframe')
		                    .css({display:'block', opacity:0})
		                    .animate({opacity:1});
		            } else {
		                var h = parseInt(w*0.5625);
		                var mt = -parseInt((h-height)/2);
		                $(this).closest('.yolo-video-player')
		                    .find('.iframe-video-player')
		                    .append('<iframe style="height:'+h+'px;width:100%;margin-top:'+mt+'px" src="'+embed+'"></iframe>')
		                    .css({display:'block', opacity:0})
		                    .animate({opacity:1});
		            }
		            /* Resize */
		            $(window).resize(function(){
		                var w = $(window).width();
		                /* iframe full width */
		                if ( yolo_width == 'full_width' ) {
		                    var h = parseInt(w*0.5625);
		                    var mt = -parseInt((h-height)/2);
		                    var atttt = "height:"+h+"px;width:100%;margin-top:"+mt+"px;";
		                    $('.iframe-video-player iframe').attr('style', atttt);
		                }
		            });
		        });
		    });
		},
	};
	$(document).ready(function(){
		FW.owlCarousel();
		FW.testimonial_sync();
		FW.countAppear();
		FW.countProcess();
		FW.sc_countdown_circle();
		FW.sc_countdown_number();
		FW.popupInfo();
		FW.sc_video();
	});
})(jQuery);


/**
 *  
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
/*
* Portfolio
* 
 */
var PortfolioAjaxAction = {};
(function($) {
"use strict";
	PortfolioAjaxAction = {
	    htmlTag:{
	        load_more:'.load-more',
	        portfolio_container: '#portfolio-'
	    },
	    vars:{
	        ajax_url: '',
	    },

	    processFilter:function(elm, isLoadmore) {
	        var $this              = jQuery(elm);
	        var l                  = Ladda.create(elm);
	        l.start();
	        var $overlay_style     = $this.attr('data-overlay-style');
	        var $overlay_effect    = $this.attr('data-overlay-effect');
	        var $section_id        = $this.attr('data-section-id');
	        var $data_source       = $this.attr('data-source');
	        var $data_portfolioIds = $this.attr('data-portfolio-ids');
	        var $data_show_paging  = $this.attr('data-show-paging');
	        var $current_page      = $this.attr('data-current-page');
	        var $category          = $this.attr('data-category');
	        var $offset            = 0;
	        var $post_per_page     = $this.attr('data-post-per-page');
	        var $column            = $this.attr('data-column');
	        var $padding           = '';
	        var $order             = $this.attr('data-order');
	        var $thumbnail         = $this.attr('data-thumbnail');
	        var $tag               = $this.attr('data-tag');
	        var $filter_by         = $this.attr('data-filter-by');
	        var $hover_dir         = $this.attr('data-hover-dir');
	        var $portfolio_title   = $this.attr('data-portfolio-title');

	        // if( $filter_by == 'category' ) {
	        //     $category = jQuery('a.active', jQuery(elm).parent().parent()).attr('data-category');
	        // }
	        // console.log($category);
	        jQuery.ajax({
	            url: PortfolioAjaxAction.vars.ajax_url,
	            data: ({
	                action : 'yoloframework_portfolio_load_more', 
	                postsPerPage: $post_per_page, 
	                current_page: $current_page,
	                thumbnail: $thumbnail,
	                tag: $tag,
	                hover_dir: $hover_dir,
	                portfolio_title: $portfolio_title,
	                category : $category,
	                columns: $column, 
	                colPadding: $padding, 
	                offset: 0, 
	                order: $order,
	                data_source  : $data_source, 
	                portfolioIds: $data_portfolioIds, 
	                data_show_paging: $data_show_paging,
	                overlay_style: $overlay_style,
	                overlay_effect: $overlay_effect,  
	                data_section_id: $section_id,
	            }),
	            success: function(data) {
	                l.stop();
	                // console.log(data);
	                if($data_show_paging=='1') {
	                    jQuery('#load-more-' + $section_id).empty();
	                    if(jQuery('.paging',data).length>0){
	                        var $loadButton = jQuery('.paging a.load-more',data); // Fixed loadmore get a tags don't need
	                        $loadButton.attr('data-section-id',$section_id);
	                        // console.log($loadButton);
	                        jQuery('#load-more-' + $section_id).append($loadButton);
	                        PortfolioAjaxAction.registerLoadmore();
	                    }
	                }
	                var $container = jQuery('#portfolio-container-' + $section_id);

	                var $item = jQuery('.portfolio-item',data);


	                if(isLoadmore == null || !isLoadmore) {
	                    $container.isotope();
	                    jQuery('.portfolio-item',$container).each(function(){
	                        $container.isotope( 'remove', jQuery(this) );
	                    })
	                    $container.fadeOut();
	                    $item.css('transition','all 0.3s');
	                    $item.css('-webkit-transition','all 0.3s');
	                    $item.css('-moz-transition','all 0.3s');
	                    $item.css('-ms-transition','all 0.3s');
	                    $item.css('-o-transition','all 0.3s');
	                    $item.css('opacity',0);
	                }else{
	                    $item.fadeOut();
	                }

	                $container.append( $item ).isotope( 'appended', $item);
	                var $containerIsotope = jQuery('div[data-section-id="' + $section_id + '"]');
	                $containerIsotope.imagesLoaded( function() {
	                    if( $hover_dir == 'on' ) {
	                        jQuery('.portfolio-item > div').hoverdir('destroy');
	                        jQuery('.portfolio-item > div').hoverdir('rebuild');
	                    }
	                    $container.isotope({ 
	                    // filter: '*' // @TODO: auto filter to all, change filter to current category by comment this line
	                    }); 
	                });

	                PortfolioAjaxAction.registerPrettyPhoto();
	                // Refix padding packery
	                PortfolioAjaxAction.fixPackeryPadding();

	                if( $hover_dir == 'on' ) {
	                    jQuery('.portfolio-item > div.entry-thumbnail').hoverdir();
	                }

	                $item.fadeIn();

	                PortfolioAjaxAction.registerLoadmore($section_id);
	            },
	            error:function(){
	                // Do something
	            }
	        });
	    },

	    registerLoadmore:function(sectionId) {
	        jQuery('a','#load-more-' + sectionId).off(); // Remove click event
	        jQuery('a','#load-more-' + sectionId).click(function() {
	            PortfolioAjaxAction.processFilter(this, true);
	        });
	    },

	    fixPackeryPadding:function() {
	        if( (typeof padding_width !== 'undefined') && (padding_width != false) && (jQuery(window).width() > 767) ) { // Use padding
	            var portfolio_wrapper_width = jQuery('.portfolio-wrapper').width();
	            var padding_total = column * padding_width * 2; // Column from portfolio-packery.php file

	            var portfolio_item_height = (portfolio_wrapper_width - padding_total) / column;
	            // Small squared

	            // Landscape
	            jQuery('.portfolio-item.landscape').each(function() {
	                jQuery(this).css({"height": portfolio_item_height});
	                jQuery('img',this).css({"height": portfolio_item_height});
	            });
	            // Portrait
	            jQuery('.portfolio-item.portrait').each(function() {
	                jQuery(this).css({"height": (portfolio_item_height+padding_width) * 2 });
	                jQuery('img',this).css({"height": (portfolio_item_height+padding_width) * 2 });
	            });
	            // Big Squared
	            jQuery('.portfolio-item.big_squared').each(function() {
	                jQuery(this).css({"height": (portfolio_item_height+padding_width) * 2 });
	                jQuery('img',this).css({"height": (portfolio_item_height+padding_width) * 2 });
	            });
	        }
	    },

	    registerPrettyPhoto:function() {
	        jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
	            hook: 'data-rel',
	            theme: 'light_rounded',
	            slideshow: 5000,
	            deeplinking: false,
	            social_tools: false
	        });
	    },

	    wrapperContentResize:function() {
	        jQuery('#wrapper-content').bind('resize', function(){
	            var $container = jQuery('.portfolio-wrapper');
	            $container.isotope({
	                itemSelector: '.portfolio-item'
	            }).isotope('layout');
	        });
	    },

	    init:function(ajax_url, dataSectionId) {
	        PortfolioAjaxAction.vars.ajax_url = ajax_url;
	        PortfolioAjaxAction.registerLoadmore(dataSectionId);
	        PortfolioAjaxAction.fixPackeryPadding();
	        PortfolioAjaxAction.registerPrettyPhoto();
	        PortfolioAjaxAction.wrapperContentResize();
	    }
	}
})(jQuery);