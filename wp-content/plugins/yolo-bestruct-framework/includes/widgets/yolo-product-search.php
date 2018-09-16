<?php
/**
 *	Yolo Widget: Yolo Product Search
 *
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 201, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class YOLO_WC_Widget_Product_Search extends Yolo_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    	= 'yolo_widget yolo_widget_product_search woocommerce';
		$this->widget_description	= __( 'Display a product sorting list.', 'yolo-bestruct' );
		$this->widget_id          	= 'yolo_woocommerce_widget_product_search';
		$this->widget_name        	= __( 'YOLO Product Search', 'yolo-bestruct' );
		$this->settings           	= array(
			'type'  => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Type', 'yolo-bestruct' ),
                'options' => array(
					'standard'  => esc_html__( 'Standard Search', 'yolo-bestruct' ),
					'ajax' => esc_html__( 'Ajax Search', 'yolo-bestruct' )
                )
            ),
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
		
		$search_box_type   = 'standard';
		$search_box_submit = 'submit';
		$search_box_type              = ( ! empty( $instance['type'] ) ) ? $instance['type'] : '';
		if( $search_box_type == 'ajax' ) {
			$search_box_submit = 'button';
		}
		$output = '';

		$output .= 	'<div class="search-box-wrapper header-customize-item" data-hint-message="'.esc_html_e( "Please type at least 3 characters to search", "yolo-bestruct" ).'">
						<form method="get" action="'.esc_url(site_url()).'" class="search-type-'.esc_attr($search_box_type).' search-box">
							<input type="text" name="s" placeholder="'.esc_html_e( 'Search', 'yolo-bestruct' ).'"/>
							<button type="'.esc_attr($search_box_submit).'"><i class="wicon fa fa-search"></i></button>
						</form>
					</div>';

		echo $before_widget . $output . $after_widget;
	}
	
}
if ( ! function_exists('yolo_register_product_search') ) {
	function yolo_register_product_search() {
		register_widget('YOLO_WC_Widget_Product_Search');
	}

	add_action('widgets_init', 'yolo_register_product_search', 1);
}
