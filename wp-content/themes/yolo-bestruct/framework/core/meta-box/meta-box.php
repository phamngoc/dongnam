<?php
/**
 * Plugin Name: Meta Box
 * Plugin URI: https://metabox.io
 * Description: Create custom meta boxes and custom fields in WordPress.
 * Version: 4.10.4
 * Author: Anh Tran
 * Author URI: http://www.deluxeblogtips.com
 * License: GPL2+
 * Text Domain: meta-box
 * Domain Path: /languages/
 *
 * @package Meta Box
 */

include get_template_directory() . '/framework/core/meta-box/inc/conditional-logic/class-conditional-logic.php';
new Yolo_MB_Conditional_Logic;

if ( defined( 'ABSPATH' ) && ! defined( 'RWMB_VER' ) ) {
	require_once get_template_directory() . '/framework/core/meta-box/inc/loader.php';
	$loader = new RWMB_Loader;
	$loader->init();
}


