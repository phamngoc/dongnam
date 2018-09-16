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

class YOLO_Widget_VerticalMenu extends YOLO_Widget {
	public function __construct() {
		$this->widget_cssclass    = 'widget-vertical-menu';
		$this->widget_description = esc_html__( "Vertical Menu Widget", 'yolo-bestruct' );
		$this->widget_id          = 'yolo-vertical-menu';
		$this->widget_name        = esc_html__( 'YOLO Vertical Menu', 'yolo-bestruct' );
		
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract($args);
		$title 	= apply_filters('widget_title', $instance['title']);
		$menu 	= $instance['menu'];
		
		if( empty($menu) ){
			return;
		}
		
		if( empty($title) ){
			$menu_obj = wp_get_nav_menu_object($menu);
			if( isset( $menu_obj->name ) ){
				$title = $menu_obj->name;
			}
		}
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		
		wp_nav_menu( 
			array( 
				'container'   => 'nav', 
				'menu_class'  => 'yolo-main-menu nav-collapse navbar-nav vertical-megamenu', 
				'menu'        => $menu,
				'fallback_cb' => 'please_set_menu',
				'walker'      => new Yolo_MegaMenu_Walker()
			) 
		);
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;		
		$instance['title'] 		= strip_tags($new_instance['title']);			
		$instance['menu'] 		= $new_instance['menu'];			
		
		return $instance;
	}

	function form( $instance ) {
			
		$defaults = array(
			'title' => 'Shop By Category',
			'menu'  => ''
		);
	
		$instance = wp_parse_args( (array) $instance, $defaults );	
		
		$menus = array('' => '');
		$nav_terms = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
		if( is_array($nav_terms) ){
			foreach( $nav_terms as $term ){
				$menus[$term->term_id] = $term->name;
			}
		}
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Enter your title', 'yolo-bestruct'); ?> </label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('menu'); ?>"><?php esc_html_e('Menu', 'yolo-bestruct'); ?> </label>
			<select class="widefat" id="<?php echo $this->get_field_id('menu'); ?>" name="<?php echo $this->get_field_name('menu'); ?>">
				<?php foreach( $menus as $id => $name ): ?>
				<option value="<?php echo esc_attr($id) ?>" <?php selected($id, $instance['menu']) ?>><?php echo esc_html($name) ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		
		<?php 
	}

}

if (!function_exists('yolo_register_widget_vertical_menu')) {
	function yolo_register_widget_vertical_menu() {
		register_widget('YOLO_Widget_VerticalMenu');
	}
	add_action('widgets_init', 'yolo_register_widget_vertical_menu', 1);
}