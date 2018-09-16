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
 
if( !function_exists( 'yolo_core_functions' ) ) {
	function yolo_core_functions() {
		// Include Redux core file
        if (!class_exists('ReduxFramework')) {
            require_once get_template_directory() . '/framework/core/redux-framework/ReduxCore/framework.php';
            // Use this to load custom fields for Redux
            require_once get_template_directory() . '/framework/core/option-extensions/loader.php';
        }
        if ( file_exists( get_template_directory().'/framework/includes/options-config.php' ) ) {
		    require_once get_template_directory().'/framework/includes/options-config.php';
		}
        // Include Metabox Core file
        if (!class_exists('RW_Meta_Box')) {
            require_once get_template_directory() . '/framework/core/meta-box/meta-box.php';
        }
		// Include functions to generate css, add action to process options at frontend, ...
		require_once get_template_directory() . '/framework/core/functions/base.php' ;
		require_once get_template_directory() . '/framework/core/functions/head.php' ;
		require_once get_template_directory() . '/framework/core/functions/header.php' ;
		require_once get_template_directory() . '/framework/core/functions/footer.php' ;
		require_once get_template_directory() . '/framework/core/functions/blog.php' ;
		require_once get_template_directory() . '/framework/core/functions/breadcrumb.php' ;
		require_once get_template_directory() . '/framework/core/functions/resize-image.php' ;
		require_once get_template_directory() . '/framework/core/functions/action.php' ; // For ajax search
		require_once get_template_directory() . '/framework/core/functions/filter.php' ; // For less to css
		require_once get_template_directory() . '/framework/core/functions/woocommerce.php' ; // 

		// Include megamenu
		require_once get_template_directory() . '/framework/core/megamenu/megamenu.php' ;

		// Include this file to override Redux core file
		// require_once get_template_directory() . '/framework/core/yolo_reduxframework.php' ;
	}
	
	yolo_core_functions();
}