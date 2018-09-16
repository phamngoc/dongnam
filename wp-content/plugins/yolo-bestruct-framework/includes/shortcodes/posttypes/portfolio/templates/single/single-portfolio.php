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

get_header();
global $yolo_bestruct_options;
wp_enqueue_style('prettyPhoto');
wp_enqueue_style('owl-carousel');
wp_enqueue_script('jquery-hoverdir');
wp_enqueue_script('owl-carousel');
wp_enqueue_script('prettyPhoto');

if ( have_posts() ) {
    // Start the Loop.
    while ( have_posts() ) : the_post();
        $post_id    = get_the_ID();
        $categories = get_the_terms($post_id, 'portfolio_category');
        
        $meta_values = get_post_meta( get_the_ID(), 'yolo_portfolio_data_format_gallery', false );
        $imgThumbs   = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $cat         = '';
        $arrCatId    = array();
        if($categories) {
            foreach($categories as $category) {
                $cat .= '<span>'.$category->name.'</span>, ';
                $arrCatId[count($arrCatId)] = $category->term_id;
            }
            $cat = trim($cat, ', ');
        }

        // Get portfolio single tags
        $tags     = get_the_terms($post_id, 'portfolio_tag');
        $tag      = '';
        $arrTagId = array();
        if($tags) {
            foreach($tags as $t) {
                $tag .= '<span>'.$t->name.'</span> ';
                $arrTagId[count($arrTagId)] = $t->term_id;
            }
            $tag = trim($tag, ', ');
        }
        
        $detail_style =  get_post_meta(get_the_ID(), 'portfolio_detail_style', true);
        if (!isset($detail_style) || $detail_style == 'none' || $detail_style == '') {
            $detail_style = $yolo_bestruct_options['portfolio-single-style'];
        }

        include_once(plugin_dir_path( __FILE__ ).'/'.$detail_style.'.php');

    endwhile;
    }
?>

<?php

if(isset($yolo_bestruct_options['show_portfolio_related']) && $yolo_bestruct_options['show_portfolio_related'] == '1' )
    include_once(plugin_dir_path( __FILE__ ).'/related.php');

?>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function(){

            $('a','.portfolio-full .share').each(function(){
                $(this).click(function(){
                    var href = $(this).attr('data-href');
                    var leftPosition, topPosition;
                    var width = 400;
                    var height = 300;
                    var leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
                    var topPosition = (window.screen.height / 2) - ((height / 2) + 50);
                    //Open the window.
                    window.open(href, "", "width=300, height=200,left=" + leftPosition + ",top=" + topPosition);
                })
            })

            $("a[rel^='prettyPhoto']").prettyPhoto({
                    theme: 'light_rounded',
                    slideshow: 5000,
                    deeplinking: false,
                    social_tools: false
                });
            $('.portfolio-item.hover-dir > div.entry-thumbnail').hoverdir();
        })
    })(jQuery);
</script>

<?php get_footer(); ?>
