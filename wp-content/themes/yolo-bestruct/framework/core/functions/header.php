<?php
/**
 *
 * @package    YOLO Framework
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 */

/* 1. Yolo Site Loading */
if (!function_exists('yolo_site_loading')) {
	function yolo_site_loading() {
        yolo_get_template('site-loading');
	}
	add_action( 'yolo_before_page_wrapper', 'yolo_site_loading', 5);
}

/* 2. Yolo Popup Window */
if (!function_exists('yolo_popup_window')) {
	function yolo_popup_window() {
        yolo_get_template('popup-window');
	}
	add_action( 'yolo_before_page_wrapper', 'yolo_popup_window', 10);
}

/* 3. Yolo Page Heading */
if (!function_exists('yolo_page_heading')) {
	function yolo_page_heading() {
		yolo_get_template('page-heading');
	}
	add_action('yolo_before_page','yolo_page_heading', 5);
}

/* 4. Yolo Archire Heading */
if (!function_exists('yolo_archive_heading')) {
	function yolo_archive_heading() {
		yolo_get_template('archive-heading');
	}
	add_action('yolo_before_archive','yolo_archive_heading', 5);
}

/* 5. Yolo Archire Product Heading */
if (!function_exists('yolo_archive_product_heading')) {
    function yolo_archive_product_heading() {
        yolo_get_template('archive-product-heading');
    }
    add_action('yolo_before_archive_product','yolo_archive_product_heading', 5);
}

/* 6. Yolo Topbar */
if (!function_exists('yolo_page_top_bar')) {
	function yolo_page_top_bar() {
		yolo_get_template('top-bar-template');
	}
	add_action('yolo_before_page_wrapper_content','yolo_page_top_bar', 10);
}

/* 7. Yolo Header */
if (!function_exists('yolo_page_header')) {
	function yolo_page_header() {
		yolo_get_template('header-template');
	}
	add_action('yolo_before_page_wrapper_content','yolo_page_header',15);
}
/* 8. Yolo Body Class */
if (!function_exists('yolo_body_class')) {
	function yolo_body_class( $classes ) {
		// global $yolo_header_layout;
		
		global $yolo_bestruct_options;
		$prefix = 'yolo_';

		// Site Preloader Class
		if ($yolo_bestruct_options['home_preloader'] != 'none' && !empty($yolo_bestruct_options['home_preloader'])) {
			$classes[] = 'yolo-site-preload';
		}
		// Popup class
		if ( $yolo_bestruct_options['show_popup'] != false ) {
			$classes[] = 'open-popup';
		}
		// Layout class
		$layout_style = get_post_meta(get_the_ID(),$prefix.'layout_style',true);
		if(!isset($layout_style) || $layout_style == '-1' || $layout_style == '') {
			$layout_style = $yolo_bestruct_options['layout_style'];
		}

        if ($layout_style != 'wide') {
            $classes[] =  $layout_style;
        }
        // Page extra class
        $page_class_extra =  get_post_meta(get_the_ID(),$prefix.'page_class_extra',true);
		if (!empty($page_class_extra)) {
			$classes[] = $page_class_extra;
		}
		
		$yolo_header_layout = yolo_get_header_layout();

		$classes[] = $yolo_header_layout;
		// Header layout float
		if ( 'header-1' == $yolo_header_layout ) {
			$header_layout_float = 	( isset($yolo_bestruct_options['header_1_nav_layout_float']) && $yolo_bestruct_options['header_1_nav_layout_float'] != '' ) ? $yolo_bestruct_options['header_1_nav_layout_float'] : false;
		}
		if ( 'header-2' == $yolo_header_layout ) {
			$header_layout_float = 	( isset($yolo_bestruct_options['header_2_nav_layout_float']) && $yolo_bestruct_options['header_2_nav_layout_float'] != '' ) ? $yolo_bestruct_options['header_2_nav_layout_float'] : false;
		}
		if ( 'header-3' == $yolo_header_layout ) {
			$header_layout_float = 	( isset($yolo_bestruct_options['header_3_nav_layout_float']) && $yolo_bestruct_options['header_3_nav_layout_float'] != '' ) ? $yolo_bestruct_options['header_3_nav_layout_float'] : false;
		}
		if ( 'header-4' == $yolo_header_layout ) {
			$header_layout_float = 	( isset($yolo_bestruct_options['header_4_nav_layout_float']) && $yolo_bestruct_options['header_4_nav_layout_float'] != '' ) ? $yolo_bestruct_options['header_4_nav_layout_float'] : false;
		}
		if ( 'header-5' == $yolo_header_layout ) {
			$header_layout_float = 	( isset($yolo_bestruct_options['header_5_nav_layout_float']) && $yolo_bestruct_options['header_5_nav_layout_float'] != '' ) ? $yolo_bestruct_options['header_5_nav_layout_float'] : false;
		}
		if ( 'header-6' == $yolo_header_layout ) {
			$header_layout_float = 	( isset($yolo_bestruct_options['header_6_nav_layout_float']) && $yolo_bestruct_options['header_6_nav_layout_float'] != '' ) ? $yolo_bestruct_options['header_6_nav_layout_float'] : false;
		}
		if (isset($header_layout_float) && $header_layout_float == '1') {
			$classes[] = 'header-float';
		}

		return $classes;
	}

	add_filter( 'body_class', 'yolo_body_class' );
}
/* 9. Yolo Header Layout */
if (!function_exists('yolo_get_header_layout')) {
	function yolo_get_header_layout() {
		global $yolo_bestruct_options;
		$prefix = 'yolo_';

		$page_enable_header_set_page = get_post_meta(get_the_ID(),$prefix . 'header_set_page',true); // Added by GDragon
		if('1' == $page_enable_header_set_page){
			$yolo_header_layout           = get_post_meta(get_the_ID(),$prefix . 'header_layout',true);
			if ('' === $yolo_header_layout) {
				$yolo_header_layout = isset($yolo_bestruct_options['header_layout']) ? $yolo_bestruct_options['header_layout'] : 'header-6';
			}
		}else{
			$yolo_header_layout = isset($yolo_bestruct_options['header_layout']) && !empty($yolo_bestruct_options['header_layout']) ? $yolo_bestruct_options['header_layout'] : 'header-6';
		}

		return $yolo_header_layout;
	}
}