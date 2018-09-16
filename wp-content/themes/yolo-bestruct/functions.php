<?php
/**
 * Theme functions for YOLO Framework.
 * This file include the framework functions, it should remain intact between themes.
 * For theme specified functions, see file functions-<theme name>.php
 *
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

// Load the Options Panel
require get_template_directory()  . '/framework/yolo-framework.php';

/*
 *  Add relevant WooCommerce widget-id's to "sidebars_widgets" option so the custom product filters will work
 *
 *  Note: WooCommerce use "is_active_widget()" to check for active widgets in: "../includes/class-wc-query.php"
 */
function yolo_add_woocommerce_widget_ids( $sidebars_widgets, $old_sidebars_widgets = array() ) {
  $shop_sidebar_id = 'woocommerce_filter';
  $shop_widgets = isset($sidebars_widgets[$shop_sidebar_id]) ? $sidebars_widgets[$shop_sidebar_id] : '';

  if ( is_array( $shop_widgets ) ) {
    foreach ( $shop_widgets as $widget ) {
      $widget_id = _get_widget_id_base( $widget );

      if ( $widget_id === 'yolo_woocommerce_price_filter' ) {
        $sidebars_widgets[$shop_sidebar_id][] = 'woocommerce_price_filter-12345';
      } else if ( $widget_id === 'yolo_woocommerce_color_filter' ) {
        $sidebars_widgets[$shop_sidebar_id][] = 'woocommerce_layered_nav-12345';
      }
    }
  }

  return $sidebars_widgets;
}
add_action( 'pre_update_option_sidebars_widgets', 'yolo_add_woocommerce_widget_ids' );

add_action( 'wp_before_admin_bar_render', 'remove_customize' ); 

function remove_customize()
{
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('customize');
}