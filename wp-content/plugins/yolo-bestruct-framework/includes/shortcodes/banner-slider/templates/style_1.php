<?php
/**
 *  
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
$banner_slider = (array)vc_param_group_parse_atts( $banner_slider );
$banner_slider_id = uniqid();
?>
<div class="<?php echo $layout_type; ?> banner_slider-shortcode-wrap">
    <div id="banner_slider-list-<?php echo $banner_slider_id; ?>" class="banner_slider-list owl-carousel owl-theme">
        <?php foreach( $banner_slider as $client ) :  ?>
            <div class="slider-item">
            <?php if( isset($client['url'])) : // Show if have url in $client array ?> 
            <a href="<?php echo esc_url($client['url']); ?>">
                <?php endif; ?>
                <?php if(isset($client['img'])) :?>
                        <?php $image_src = wp_get_attachment_url($client['img']); ?>
                        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo $client['title']; ?>">  
                <?php else : echo esc_html__('Please select Image banner!','yolo-bestruct');?> 
                <?php endif; ?>  
                <div class="content-slider">
                    <?php if(isset($client['title'])) :?>
                        <div class="title-slider">
                            <?php echo esc_attr($client['title']); ?>
                        </div>
                     <?php endif; ?> 
                    <?php if(isset($client['sub'])) :?>
                        <div class="description">
                            <?php echo esc_attr($client['sub']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($client['bt_text'])) :?>
                        <div class="button_text">
                            <?php echo esc_attr($client['bt_text']); ?>
                        </div>
                    <?php endif; ?>     
                </div>
            <?php if( isset($client['url']) ) : // Show if have url in $client array ?> 
            </a>
            <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div id="banner_slider-control-<?php echo $banner_slider_id; ?>" class="banner_slider-control">
        <div class="banner_slider-nav nav_prev"><i class="fa fa-chevron-left"></i></div>
        <div class="banner_slider-nav nav_next"><i class="fa fa-chevron-right"></i></div>
    </div>
</div>
<script>
  jQuery(document).ready(function($){
    var owl = $('#banner_slider-list-<?php echo $banner_slider_id; ?>');
    owl.owlCarousel({
        items : 1,
        margin: 80,
        loop: true,
        center: false,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: true,
        freeDrag: false,
        stagePadding: 0,
        merge: false,
        mergeFit: true,
        <?php if(is_rtl()) : ?> rtl : true, <?php endif;?>
        autoWidth: false,
        startPosition: 0,
        URLhashListener: false,
        nav: false,
        navText: ['next','prev'],
        rewind: true,
        navElement: 'div',
        slideBy: 1,
        dots: true,
        dotsEach: false,
        lazyLoad: false,
        lazyContent: false,

        autoplay: <?php echo $autoplay; ?>,
        autoplayTimeout: <?php echo $slide_duration; ?>,
        autoplayHoverPause: true,
        
        smartSpeed: 250,
        fluidSpeed: false,
        autoplaySpeed: false,
        navSpeed: false,
        dotsSpeed: false,
        dragEndSpeed: false,
        responsive: {
            0: {
                items: 1
            },
            500: {
                items: 1
            },
            991: {
                items: 1
            },
            1200: {
                items: 1
            },
            1300: {
                items: 1
            }
        },
        responsiveRefreshRate: 200,
        responsiveBaseElement: window,
        video: false,
        videoHeight: false,
        videoWidth: false,
        animateOut: false,
        animateIn: false,
        fallbackEasing: 'swing',

        info: false,

        nestedItemSelector: false,
        itemElement: 'div',
        stageElement: 'div',

        navContainer: false,
        dotsContainer: false
    });
    // Custom Navigation Events
    $('#banner_slider-control-<?php echo $banner_slider_id; ?>').find(".nav_next").click(function(){
        owl.trigger('next.owl.carousel');
    });
    $('#banner_slider-control-<?php echo $banner_slider_id; ?>').find(".nav_prev").click(function(){
        owl.trigger('prev.owl.carousel');
    });
  });
</script> 