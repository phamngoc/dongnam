<?php
/**
 *	Yolo Widget: Product Sorting List
 *
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class YOLO_WC_Widget_Product_Sorting extends Yolo_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    	= 'yolo_widget yolo_widget_product_sorting woocommerce';
		$this->widget_description	= esc_html__( 'Show sort by for shop page. This widget use for shop ajax page.', 'yolo-bestruct' );
		$this->widget_id          	= 'yolo_woocommerce_widget_product_sorting';
		$this->widget_name        	= esc_html__( 'YOLO WooCommerce Sort By Ajax ', 'yolo-bestruct' );
		$this->settings           	= array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Sort By', 'yolo-bestruct' ),
				'label'	=> esc_html__( 'Title', 'yolo-bestruct' )
			)
		);
		
		parent::__construct();
	}

	/**
	 * Widget function
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		global $wp_query;
		
		extract( $args );
		
		$title = ( ! empty( $instance['title'] ) ) ? $before_title . $instance['title'] . $after_title : '';

		$output = '';
		if ( 1 != $wp_query->found_posts || woocommerce_products_will_display() ) {
			$output .= '<ul class="yolo-filter-widgets">';
			
			$orderby = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
			$orderby == ( $orderby ===  'title' ) ? 'menu_order' : $orderby; // Fixed: 'title' is default before WooCommerce settings are saved

			$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
				'menu_order'	=> esc_html__( 'Default', 'yolo-bestruct' ),
				'popularity' 	=> esc_html__( 'Popularity', 'yolo-bestruct' ),
				'rating'     	=> esc_html__( 'Average rating', 'yolo-bestruct' ),
				'date'       	=> esc_html__( 'Newness', 'yolo-bestruct' ),
				'price'      	=> esc_html__( 'Price: Low to High', 'yolo-bestruct' ),
				'price-desc'	=> esc_html__( 'Price: High to Low', 'yolo-bestruct' )
			) );
	
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
				unset( $catalog_orderby_options['rating'] );
			}
			
			
			/* Build entire current page URL (including query strings) */
			global $wp;
			$link = home_url( $wp->request ); // Base page URL
					
			// Unset query strings used for Ajax shop filters
			unset( $_GET['shop_load'] );
			unset( $_GET['_'] );
			
			$qs_count = count( $_GET );
			
			// Any query strings to add?
			if ( $qs_count > 0 ) {
				$i = 0;
				$link .= '?';
				
				// Build query string
				foreach ( $_GET as $key => $value ) {
					$i++;
					$link .= $key . '=' . $value;
					if ( $i != $qs_count ) {
						$link .= '&';
					}
				}
			}
			
			
            foreach ( $catalog_orderby_options as $id => $name ) {
				if ( $orderby == $id ) {
					$output .= '<li class="active">' . esc_attr( $name ) . '</li>';
				} else {
					// Add 'orderby' URL query string
					$link = add_query_arg( 'orderby', $id, $link );
					$output .= '<li><a href="' . esc_url( $link ) . '">' . esc_attr( $name ) . '</a></li>';
				}
            }
			       
        	$output .= '</ul>';
		}
		
		echo $before_widget . $title . $output . $after_widget;
	}
	
}
if ( ! function_exists('yolo_register_product_sorting') ) {
	function yolo_register_product_sorting() {
		register_widget('YOLO_WC_Widget_Product_Sorting');
	}

	add_action('widgets_init', 'yolo_register_product_sorting', 1);
}
