<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    18/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 */
/*================================================
GET UPLOAD URL, DIRECTOR
================================================== */
if (!function_exists('yolo_upload_dir_name')):
	function yolo_upload_dir_name() {
		return apply_filters( 'yolo_upload_dir_name', 'yolo-custom-css' );
	}
endif;

if (!function_exists('yolo_upload_dir')):
	function yolo_upload_dir() {
		$upload_dir = wp_upload_dir();

		return $upload_dir['basedir'] . '/' . yolo_upload_dir_name();
	}
endif;

if (!function_exists('yolo_upload_url')):
	function yolo_upload_url() {
		$upload_dir = wp_upload_dir();

		return $upload_dir['baseurl'] . '/' . yolo_upload_dir_name();
	}
endif;

if (!function_exists('yolo_create_upload_dir')):
	function yolo_create_upload_dir( $wp_filesystem = null ) {
		if( empty( $wp_filesystem ) ) {
			return false;
		}

		$upload_dir = wp_upload_dir();
		global $wp_filesystem;

		$yolo_upload_dir = $wp_filesystem->find_folder( $upload_dir['basedir'] ) . yolo_upload_dir_name();
		if ( ! $wp_filesystem->is_dir( $yolo_upload_dir ) ) {
			if ( wp_mkdir_p( $yolo_upload_dir ) ) {
				return $yolo_upload_dir;
			}

			return false;
		}

		return $yolo_upload_dir;
	}
endif;
/*================================================
YOLO GET TEMPLATE PART
================================================== */
if (!function_exists('yolo_get_template')) {
	function yolo_get_template( $template, $name = null ) {
		get_template_part( 'templates/' . $template, $name);
	}
}

/*================================================
YOLO GET POST META
================================================== */
if ( !function_exists( 'yolo_get_post_meta' ) ) {
	function yolo_get_post_meta( $id, $key = "", $single = false ) {

		$GLOBALS['yolo_post_meta'] = isset( $GLOBALS['yolo_post_meta'] ) ? $GLOBALS['yolo_post_meta'] : array();
		if ( ! isset( $id ) ) {
			return;
		}
		if ( ! is_array( $id ) ) {
			if ( ! isset( $GLOBALS['yolo_post_meta'][ $id ] ) ) {
				$GLOBALS['yolo_post_meta'][ $id ] = get_post_meta( $id );
			}
			if ( ! empty( $key ) && isset( $GLOBALS['yolo_post_meta'][ $id ][ $key ] ) && ! empty( $GLOBALS['yolo_post_meta'][ $id ][ $key ] ) ) {
				if ( $single ) {
					return maybe_unserialize( $GLOBALS['yolo_post_meta'][ $id ][ $key ][0] );
				} else {
					return array_map( 'maybe_unserialize', $GLOBALS['yolo_post_meta'][ $id ][ $key ] );
				}
			}

			if ( $single ) {
				return '';
			} else {
				return array();
			}

		}

		return get_post_meta( $id, $key, $single );
	}
}

/* ==================================================
YOLO GET USER MENU LIST
================================================== */
if ( !function_exists( 'yolo_get_menu_list' ) ){
	function yolo_get_menu_list() {

		if ( !is_admin() ) {
			return array();
		}

		$user_menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		$menu_list = array();

		foreach ( $user_menus as $menu ) {
			$menu_list[ $menu->term_id ] = $menu->name;
		}

		return $menu_list;
	}
}

/* ==================================================
YOLO GET SIDEBAR LIST
================================================== */
if ( !function_exists( 'yolo_get_sidebar_list' ) ){
	function yolo_get_sidebar_list() {

		if ( !is_admin() ) {
			return array();
		}

		$sidebar_list = array();
		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$sidebar_list[ $sidebar['id'] ] = ucwords( $sidebar['name'] );
		}

		return $sidebar_list;
	}
}

/* ==================================================  
YOLO CHECK IS BLOG PAGE
================================================== */
if ( !function_exists( 'yolo_is_blog_page' ) ){
	function yolo_is_blog_page() {
		global $post;

		//Post type must be 'post'.
		$post_type = get_post_type($post);

		return (
			( is_home() || is_archive() || is_single() )
			&& ($post_type == 'post')
		) ? true : false ;
	}
}

/* ================================================== 
YOLO ATTRIBUTE VALUE
================================================== */
if ( !function_exists( 'yolo_the_attr_value' ) ){
	function yolo_the_attr_value($attr) {
		foreach ($attr as $key) {
			echo esc_attr($key) . ' ';
		}
	}
}

/*================================================
YOLO MAINTENANCE MODE
================================================== */
if (!function_exists('yolo_maintenance_mode')) {
    function yolo_maintenance_mode() {

        if (current_user_can( 'edit_themes' ) || is_user_logged_in()) {
            return;
        }

        global $yolo_bestruct_options;
        $enable_maintenance = isset($yolo_bestruct_options['enable_maintenance']) ? $yolo_bestruct_options['enable_maintenance'] : 0;
        switch ($enable_maintenance) {
            case 1 :
            	date_default_timezone_set($yolo_bestruct_options['timezone']);
				$current_time = date('Y/m/d H:i:s');
				$online_time  = $yolo_bestruct_options['online_time'];

            	if ($online_time > $current_time) {
            		yolo_get_template('maintenance');
            		exit();
            	}
                break;
            case 2:
                $maintenance_mode_page = $yolo_bestruct_options['maintenance_mode_page'];
                if (empty($maintenance_mode_page)) {
                    date_default_timezone_set($yolo_bestruct_options['timezone']);
					$current_time = date('Y/m/d H:i:s');
					$online_time  = $yolo_bestruct_options['online_time'];

	            	if ($online_time > $current_time) {
	            		yolo_get_template('maintenance');
	            		exit();
	            	}
                } else {
					$maintenance_mode_page_url = get_permalink($maintenance_mode_page);
					$current_page_url          = yolo_current_page_url();
                    if ($maintenance_mode_page_url != $current_page_url) {
                        wp_redirect($maintenance_mode_page_url);
                    }
                }
                break;
        }
    }

    add_action( 'get_header', 'yolo_maintenance_mode' );
}


/*================================================
YOLO CONVERT COLOR HEXA TO RGBA
================================================== */
if (!function_exists('yolo_hex2rgba')) {
	function yolo_hex2rgba($hex, $opacity) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} elseif(strlen($hex) == 6) {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		else {
			$r = 0;
			$g = 0;
			$b = 0;
			$opacity = 0;
		}

		return sprintf('rgba(%s,%s,%s,%s)', $r, $g, $b, $opacity);
	}
}

/*================================================
YOLO LIMIT WORDS
================================================== */
if( ! function_exists('yolo_limit_words') ) {
	function yolo_limit_words($string, $word_limit) {
		$words = preg_split('/\s+/', $string);

    	return implode(" ",array_splice($words,0,$word_limit));
	}
}

/*================================================
YOLO GET CURRENT PAGE URL
================================================== */
if (!function_exists('yolo_endsWith')) {
	function yolo_endsWith($haystack,$needle,$case=true)
	{
		$expectedPosition = strlen($haystack) - strlen($needle);

		if ($case)
			return strrpos($haystack, $needle, 0) === $expectedPosition;

		return strripos($haystack, $needle, 0) === $expectedPosition;
	}
}

/*================================================
YOLO GET SEARCH CATEGORY DROPDOWN
================================================== */
if (!function_exists('yolo_categories_binder')) {
	function yolo_categories_binder($categories, $parent,$class= 'search-category-dropdown', $is_anchor = false, $show_count = false) {
		$index = 0;
		$output = '';
		if (empty($categories) || !array($categories)) {
			return $output;
		}
		foreach ($categories as $key => $term) {
			if (empty($term) || (!isset($term->parent))) {
				continue;
			}
			if (((int)$term->parent !== (int)$parent) || ($parent === null) || ($term->parent === null)) {
				continue;
			}

			if ($index == 0) {
				$output = '<ul>';
				if ($parent == 0) {
					$output = '<ul class="'. esc_attr($class) .'">';
				}
			}

			$output .= '<li>';
			$output .= sprintf('%s%s%s',
				$is_anchor ? '<a href="' .  get_term_link((int)$term->term_id, 'product_cat') . '" title="' . esc_attr($term->name) . '">' : '<span data-id="' . esc_attr($term->term_id) . '">',
				$show_count ? esc_html($term->name.' (' . $term->count . ')') : esc_html($term->name),
				$is_anchor ? '</a>' : '</span>'
				);
			$output .= yolo_categories_binder($categories, $term->term_id,$class, $is_anchor,$show_count);
			$output .= '</li>';
			$index++;
		}

		if (!empty($output)) {
			$output .= '</ul>';
		}

		return $output;
	}
}

/*================================================
YOLO ADD PROFILE LINK TO MENU
http://bavotasan.com/2011/adding-a-search-bar-to-the-nav-menu-in-wordpress/
================================================== */
global $yolo_bestruct_options;
if(isset($yolo_bestruct_options['menu_add_register_link']) && $yolo_bestruct_options['menu_add_register_link'] != '') {
	function yolo_nav_menu_profile_link($items, $args) {
		global $yolo_bestruct_options;

		if( !is_object($args->menu) ) { // Fix select menu on page settings
			$args->menu = wp_get_nav_menu_object( $args->menu );
		}
		if ( $args->menu->slug == $yolo_bestruct_options['menu_add_register_link'] ) {
		    if (!is_user_logged_in()) {
		    	$items = $items . '<li><a href="#login-box" class="login wpml-btn login-window">' . '<span><i class="fa fa-sign-out">'.esc_html__( 'Login', 'yolo-bestruct' ).'</i></span><span><i class="fa fa-key">'.esc_html__( 'Register', 'yolo-bestruct' ).'</i></span>' . '</a>';
		        return $items;
		    } else {
				$current_user = wp_get_current_user();
				$logout_link  = wp_logout_url( home_url( '/' ) );
				// Get wooCommerce links
				$account_link    = '';
				if (class_exists( 'WooCommerce' ) ) {
					global $woocommerce;
					$myaccount_page_id = wc_get_page_id('myaccount');
					if ( $myaccount_page_id > 0 ) {
						$account_link = get_permalink( $myaccount_page_id );
					}
					else {
						$account_link = wp_login_url( get_permalink() );
					}

					$edit_user_link = $account_link . 'edit-account/';
				}
				else {
					$account_link   = wp_login_url( get_permalink() );
					$edit_user_link = get_edit_user_link($current_user->ID);
				}

				$user_menu 	= '<li class="yolo-menu menu_style_dropdown">';
				$user_menu .= '<a href="' . $account_link . '"><span class="profile-text">' . $current_user->display_name . '</span><span class="profile-avatar">' . get_avatar( $current_user->ID, 26 ) . '</span></a>';
				$user_menu .= '<ul class="sub-menu">';
				$user_menu .= '<li>';
		        $user_menu .= '<a href="' . $account_link . '"><i class="fa fa-dashboard"></i> ' . esc_html__( 'My Account', 'yolo-bestruct' ) . '</a>';
		        $user_menu .= '</li>';
		        $user_menu .= '<li>';
		        $user_menu .= '<a href="' . $edit_user_link . '"><i class="fa fa-edit"></i> ' . esc_html__( 'Edit Profile', 'yolo-bestruct' ) . '</a>';
		        $user_menu .= '</li>';
		        $user_menu .= '<li>';
		        $user_menu .= '<a href="' . $logout_link . '"><i class="fa fa-sign-out"></i> ' . esc_html__( 'Logout', 'yolo-bestruct' ) . '</a>';
		        $user_menu .= '</li>';
		        $user_menu .= '</ul>';
		        $user_menu .= '</li>';
		        $items = $items . $user_menu;

		        return $items; 
		    }
		} else {
			return $items;
		}
	}
	
	add_filter( 'wp_nav_menu_items', 'yolo_nav_menu_profile_link', 10, 2 );
}
/*================================================
GET SIDEBAR MENU CANVAS
http://bavotasan.com/2011/adding-a-search-bar-to-the-nav-menu-in-wordpress/
================================================== */
if (!function_exists('yolo_add_canvas_menu_region')) {
	function yolo_add_canvas_menu_region() {
		?>
		<nav class="yolo-canvas-menu-wrapper dark">
			<a href="#" class="yolo-canvas-menu-close"><i class="fa fa-close"></i></a>
			<div class="yolo-canvas-menu-inner sidebar">
				<?php if (is_active_sidebar('canvas-menu')) { dynamic_sidebar('canvas-menu'); } ?>
			</div>
		</nav>
		<?php
	}
	add_action('yolo_after_page_wrapper','yolo_add_canvas_menu_region');
}