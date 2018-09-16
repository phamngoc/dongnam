<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
 
/*---------------------------------------------------
/* THEME ADD ACTION
/*---------------------------------------------------*/


/* COMMENT FORM BEFORE */
if (!function_exists('yolo_comment_form_before_fields')) {
    function yolo_comment_form_before_fields() {
        ?>
        <div class="comment-fields-wrap">
            <!-- <div class="entry-comments-form-avatar"> -->
                <?php //echo get_avatar(get_current_user_id(), '70'); ?>
            <!-- </div> -->
            <div class="comment-fields-inner clearfix">
                <div class="row">
        <?php
    }
    add_action('comment_form_before_fields','yolo_comment_form_before_fields');
    add_action('comment_form_logged_in_after','yolo_comment_form_before_fields');
}


/* COMMENT BOTTOM FORM */
if (!function_exists('yolo_bottom_comment_form')) {
    function yolo_bottom_comment_form() {
        echo '</div></div></div>';
    }
    add_action('comment_form','yolo_bottom_comment_form');
}


/* CUSTOM HEADER CSS */
if (!function_exists('yolo_custom_header_css')) {
	function yolo_custom_header_css() {
		$page_id = '0';
		$prefix = 'yolo_';
		$page_id = get_the_ID() ;

		$css_variable = yolo_custom_css_variable($page_id);
		if (!class_exists('Less_Parser')) {
			require_once get_template_directory() . '/framework/core/less/Autoloader.php';
			Less_Autoloader::register();
		}
		$parser = new Less_Parser(array( 'compress'=>true ));

		$parser->parse($css_variable, get_template_directory_uri());

		$enable_topbar_color 	 = get_post_meta($page_id,$prefix.'enable_topbar_color',true);

		if($enable_topbar_color == '1'){
			$parser->parseFile( get_template_directory() . '/assets/less/topbar-customize.less', get_template_directory_uri() );
		}

		$enable_logo_position 	 = get_post_meta($page_id,$prefix.'enable_logo_position',true);

		if($enable_logo_position == '1'){
			$parser->parseFile( get_template_directory() . '/assets/less/logo-customize.less', get_template_directory_uri() );
		}

		$css = $parser->getCss();
		if(!empty($css)) {
			$output = $css;
			wp_add_inline_style( 'all-custom-style', $output );
		} else {
			return;
		}
	}
	add_action('wp_enqueue_scripts', 'yolo_custom_header_css');
}