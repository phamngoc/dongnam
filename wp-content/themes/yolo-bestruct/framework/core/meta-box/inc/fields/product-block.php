<?php
/**
 * This class defines new "Footer" field type for Meta Box class
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://yolotheme.com
*/
if ( class_exists( 'RWMB_Field' ) && !class_exists( 'RWMB_Product_Block_Field' ) ) {
	class RWMB_Product_Block_Field extends RWMB_Field {

		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts() {

			wp_enqueue_style( 'rwmb-product-block', RWMB_CSS_URL . 'product-block.css', array(), RWMB_VER );
			wp_enqueue_script( 'rwmb-product-block', RWMB_JS_URL . 'product-block.js', array(), RWMB_VER, true );
		}

		/**
		 * Get field HTML
		 *
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $meta, $field ) {		
			$html = sprintf('<select class="rwmb-product-block" name="%s" id="%s">',
				$field['field_name'],
				$field['id']
				);

			$html .= self::options_html( $field, $meta );
			$html .= '</select>';

			return $html;
		}

		/**
		 * Creates html for options
		 *
		 * @param array $field
		 * @param mixed $meta
		 *
		 * @return array
		 */
		static function options_html( $field, $meta )
		{	
			$field['options'] = self::get_product_block_posts();

			$html = '';
			$html .= '<option value="">'. esc_html__( 'Default', 'yolo-bestruct' ) .'</option>';
			$option = '<option value="%s"%s>%s</option>';

			foreach ( $field['options'] as $value => $label ) {
				$html .= sprintf(
					$option,
					$value,
					selected( in_array( $value, (array) $meta ), true, false ),
					$label
				);
			}

			return $html;
		}

		// Get Product Block to render
		static function get_product_block_posts() {
            $args = array(
                'posts_per_page'   => -1,
                'post_type'        => 'product_block',
                'post_status'      => 'publish',
            );
            $posts_array = get_posts( $args );
            $product_block = array();
            foreach ( $posts_array as $k => $v ) {
                $product_block[$v->ID] = $v->post_title;
            }

            return $product_block;
		}
	}
}