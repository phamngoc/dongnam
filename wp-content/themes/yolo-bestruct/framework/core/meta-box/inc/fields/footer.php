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
if ( class_exists( 'RWMB_Field' ) && !class_exists( 'RWMB_Footer_Field' ) ) {
	class RWMB_Footer_Field extends RWMB_Field {

		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts() {

			wp_enqueue_style( 'rwmb-footer', RWMB_CSS_URL . 'footer.css', array(), RWMB_VER );
			wp_enqueue_script( 'rwmb-footer', RWMB_JS_URL . 'footer.js', array(), RWMB_VER, true );
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
			$html = sprintf('<select class="rwmb-footer" name="%s" id="%s">',
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
			$field['options'] = self::get_footer_posts();

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

		// Get Footer Block to render
		static function get_footer_posts() {
            $args = array(
                'posts_per_page'   => -1,
                'post_type'        => 'yolo_footer',
                'post_status'      => 'publish',
            );
            $posts_array = get_posts( $args );
            foreach ( $posts_array as $k => $v ) {
                $footer[$v->ID] = $v->post_title;
            }

            return $footer;
		}
	}
}