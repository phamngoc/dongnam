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

/* Custom Sidebar functions */
add_action( 'sidebar_admin_page', 'yolo_custom_sidebar_form' );
function yolo_custom_sidebar_form() {
?>
	<form action="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>" method="post" id="yolo-form-add-sidebar">
        <input type="text" name="sidebar_name" id="sidebar_name" placeholder="<?php esc_html_e( 'Custom Sidebar Name', 'yolo-bestruct' ); ?>" />
        <button class="button-primary" id="yolo-add-sidebar"><?php esc_html_e( 'Add Sidebar', 'yolo-bestruct' ); ?></button>
    </form>
<?php
}

function yolo_get_custom_sidebars() {
	$option_name = 'yolo_custom_sidebars';
    return get_option($option_name);
}

add_action('wp_ajax_yolo_add_custom_sidebar', 'yolo_add_custom_sidebar');
function yolo_add_custom_sidebar() {
	if( isset($_POST['sidebar_name']) ) {
		$option_name = 'yolo_custom_sidebars';
		if( !get_option($option_name) || get_option($option_name) == '' ) {
			delete_option($option_name);
		}
		
		$sidebar_name = $_POST['sidebar_name'];
		
		if( get_option($option_name) ) {
			$custom_sidebars = yolo_get_custom_sidebars();
			if( !in_array($sidebar_name, $custom_sidebars) ) {
				$custom_sidebars[] = $sidebar_name;
			}
			$result1 = update_option($option_name, $custom_sidebars);
		}
		else{
			$custom_sidebars[] = $sidebar_name;
			$result2 = add_option($option_name, $custom_sidebars);
		}
		
		if( $result1 ) {
			die('Updated');
		}
		elseif( $result2 ) {
			die('Added');
		}
		else {
			die('Error');
		}
	}
	die('');
}

add_action('wp_ajax_yolo_delete_custom_sidebar', 'yolo_delete_custom_sidebar');
function yolo_delete_custom_sidebar() {
	if( isset($_POST['sidebar_name']) ) {
		$option_name = 'yolo_custom_sidebars';
		$del_sidebar = trim($_POST['sidebar_name']);
		$custom_sidebars = yolo_get_custom_sidebars();
		foreach( $custom_sidebars as $key => $value ) {
			if( $value == $del_sidebar ) {
				unset($custom_sidebars[$key]);
				break;
			}
		}
		$custom_sidebars = array_values($custom_sidebars);
		update_option($option_name, $custom_sidebars);
		die('Deleted');
	}
	die('');
}


// Functions to generate CSS file

// GET CUSTOM CSS VARIABLE FONT
//--------------------------------------------------
if (!function_exists('yolo_custom_css_variable_font')) {
	function yolo_custom_css_variable_font() {
		global $yolo_bestruct_options;

		$fonts = (object)array();
		
		// Menu Font
		$fonts->menu_font_family = 'Raleway';
		$fonts->menu_font_weight = '700';
		$fonts->menu_font_size   = '14px';
			$fonts->menu_font_family = $yolo_bestruct_options['menu_font']['font-family'];
			$fonts->menu_font_weight = $yolo_bestruct_options['menu_font']['font-weight'];
			$fonts->menu_font_size   = $yolo_bestruct_options['menu_font']['font-size'];

		// General Font
		$fonts->primary_font_family = 'Roboto';
		$fonts->primary_font_weight = '400';
		$fonts->primary_font_size   = '14px';
		if ( isset($yolo_bestruct_options['body_font']) && ! empty($yolo_bestruct_options['body_font']) && !empty($yolo_bestruct_options['body_font']['font-family'])) {
			$fonts->primary_font_family = $yolo_bestruct_options['body_font']['font-family'];
			$fonts->primary_font_weight = $yolo_bestruct_options['body_font']['font-weight'];
			$fonts->primary_font_size   = $yolo_bestruct_options['body_font']['font-size'];
		}
		// Secondary Font
		$fonts->secondary_font_family = 'Raleway';
		$fonts->secondary_font_weight = '400';
		$fonts->secondary_font_size   = '14px';
		if ( isset($yolo_bestruct_options['secondary_font']) && ! empty($yolo_bestruct_options['secondary_font']) && !empty($yolo_bestruct_options['secondary_font']['font-family']) ) {
			$fonts->secondary_font_family = $yolo_bestruct_options['secondary_font']['font-family'];
			$fonts->secondary_font_weight = $yolo_bestruct_options['secondary_font']['font-weight'];
			$fonts->secondary_font_size   = $yolo_bestruct_options['secondary_font']['font-size'];
		}

		// Heading Font
		$fonts->h1_font_family = 'Raleway';
		$fonts->h1_font_weight = '700';
		$fonts->h1_font_size   = '36px';
		if ( isset($yolo_bestruct_options['h1_font']) && ! empty($yolo_bestruct_options['h1_font']) && !empty($yolo_bestruct_options['h1_font']['font-family'])) {
			$fonts->h1_font_family = $yolo_bestruct_options['h1_font']['font-family'];
			$fonts->h1_font_weight = $yolo_bestruct_options['h1_font']['font-weight'];
			$fonts->h1_font_size   = $yolo_bestruct_options['h1_font']['font-size'];
		}
		$fonts->h2_font_family = 'Raleway';
		$fonts->h2_font_weight = '700';
		$fonts->h2_font_size   = '30px';
		if ( isset($yolo_bestruct_options['h2_font']) && ! empty($yolo_bestruct_options['h2_font']) && !empty($yolo_bestruct_options['h2_font']['font-family']) ) {
			$fonts->h2_font_family = $yolo_bestruct_options['h2_font']['font-family'];
			$fonts->h2_font_weight = $yolo_bestruct_options['h2_font']['font-weight'];
			$fonts->h2_font_size   = $yolo_bestruct_options['h2_font']['font-size'];
		}
		$fonts->h3_font_family = 'Raleway';
		$fonts->h3_font_weight = '400';
		$fonts->h3_font_size   = '24px';
		if ( isset($yolo_bestruct_options['h3_font']) && ! empty($yolo_bestruct_options['h3_font']) && !empty($yolo_bestruct_options['h3_font']['font-family']) ) {
			$fonts->h3_font_family = $yolo_bestruct_options['h3_font']['font-family'];
			$fonts->h3_font_weight = $yolo_bestruct_options['h3_font']['font-weight'];
			$fonts->h3_font_size   = $yolo_bestruct_options['h3_font']['font-size'];
		}
		$fonts->h4_font_family = 'Raleway';
		$fonts->h4_font_weight = '400';
		$fonts->h4_font_size   = '18px';
		if ( isset($yolo_bestruct_options['h4_font']) && ! empty($yolo_bestruct_options['h4_font']) && !empty($yolo_bestruct_options['h4_font']['font-family']) ) {
			$fonts->h4_font_family = $yolo_bestruct_options['h4_font']['font-family'];
			$fonts->h4_font_weight = $yolo_bestruct_options['h4_font']['font-weight'];
			$fonts->h4_font_size   = $yolo_bestruct_options['h4_font']['font-size'];
		}
		$fonts->h5_font_family = 'Raleway';
		$fonts->h5_font_weight = '400';
		$fonts->h5_font_size   = '16px';
		if ( isset($yolo_bestruct_options['h5_font']) && ! empty($yolo_bestruct_options['h5_font']) && !empty($yolo_bestruct_options['h5_font']['font-family']) ) {
			$fonts->h5_font_family = $yolo_bestruct_options['h5_font']['font-family'];
			$fonts->h5_font_weight = $yolo_bestruct_options['h5_font']['font-weight'];
			$fonts->h5_font_size   = $yolo_bestruct_options['h5_font']['font-size'];
		}
		$fonts->h6_font_family = 'Raleway';
		$fonts->h6_font_weight = '400';
		$fonts->h6_font_size   = '14px';
		if ( isset($yolo_bestruct_options['h6_font']) && ! empty($yolo_bestruct_options['h6_font']) && !empty($yolo_bestruct_options['h6_font']['font-family']) ) {
			$fonts->h6_font_family = $yolo_bestruct_options['h6_font']['font-family'];
			$fonts->h6_font_weight = $yolo_bestruct_options['h6_font']['font-weight'];
			$fonts->h6_font_size   = $yolo_bestruct_options['h6_font']['font-size'];
		}

		// Page Title Font
		$fonts->page_title_font_family = 'Raleway';
		$fonts->page_title_font_weight = '700';
		$fonts->page_title_font_size   = '36px';
		if ( isset($yolo_bestruct_options['page_title_font']) && ! empty($yolo_bestruct_options['page_title_font']) && !empty($yolo_bestruct_options['page_title_font']['font-family']) ) {
			$fonts->page_title_font_family = $yolo_bestruct_options['page_title_font']['font-family'];
			$fonts->page_title_font_weight = $yolo_bestruct_options['page_title_font']['font-weight'];
			$fonts->page_title_font_size   = $yolo_bestruct_options['page_title_font']['font-size'];
		}
		$fonts->page_sub_title_font_family = 'Raleway';
		$fonts->page_sub_title_font_weight = '400';
		$fonts->page_sub_title_font_size   = '14px';
		if ( isset($yolo_bestruct_options['page_sub_title_font']) && ! empty($yolo_bestruct_options['page_sub_title_font']) && !empty($yolo_bestruct_options['page_sub_title_font']['font-family']) ) {
			$fonts->page_sub_title_font_family = $yolo_bestruct_options['page_sub_title_font']['font-family'];
			$fonts->page_sub_title_font_weight = $yolo_bestruct_options['page_sub_title_font']['font-weight'];
			$fonts->page_sub_title_font_size   = $yolo_bestruct_options['page_sub_title_font']['font-size'];
		}

		return $fonts;
	}
}

// GET CUSTOM CSS VARIABLE LOGO
//--------------------------------------------------
if (!function_exists('yolo_custom_css_variable_logo')) {
	function yolo_custom_css_variable_logo($page_id = 0) {
		global $yolo_bestruct_options;
		$prefix = 'yolo_';

		$logo = (object)array();

		// GET logo_padding
		$yolo_header_layout = '';
		if (!empty($page_id)) {
			$yolo_header_layout = get_post_meta($page_id,$prefix . 'header_layout', true);
		}

		if (($yolo_header_layout === '') || ($yolo_header_layout == '-1')) {
			$yolo_header_layout = $yolo_bestruct_options['header_layout'] ? $yolo_bestruct_options['header_layout'] : 'header-1';
		}
		$logo->logo_padding_top    = '10px';
		$logo->logo_padding_bottom = '10px';
		$logo->logo_padding_right    = '0px';
		$logo->logo_padding_left    = '0px';

		// Change default logo height here
		$logo_matrix = array(
			'header-1' => array(10, 10, 0, 0),
			'header-2' => array(20, 10, 0, 0),
			'header-3' => array(20, 10, 0, 0),
			'header-4' => array(20, 10, 0, 0),
			'header-5' => array(20, 10, 0, 0),
			'header-6' => array(20, 10, 0, 0),
			'header-sidebar' => array(20, 20, 20, 20),
		);

		if (isset($logo_matrix[$yolo_header_layout])) {
			$logo->logo_padding_top    = $logo_matrix[$yolo_header_layout][0] . 'px';
			$logo->logo_padding_bottom = $logo_matrix[$yolo_header_layout][1] . 'px';
			$logo->logo_padding_right  = $logo_matrix[$yolo_header_layout][2] . 'px';
			$logo->logo_padding_left   = $logo_matrix[$yolo_header_layout][3] . 'px';
		}
		// Get logo padding
		if (!empty($page_id)) {
			$logo->logo_padding_top = get_post_meta($page_id,$prefix . 'logo_padding_top', true);

			if (($logo->logo_padding_top === '') || ($logo->logo_padding_top == '-1')) {
				if (isset($yolo_bestruct_options['logo_padding']) && is_array($yolo_bestruct_options['logo_padding'])
					&& isset($yolo_bestruct_options['logo_padding']['padding-top']) && !empty($yolo_bestruct_options['logo_padding']['padding-top'])) {
					$logo->logo_padding_top = $yolo_bestruct_options['logo_padding']['padding-top'];
				}
				else {
					$logo->logo_padding_top = $logo_matrix[$yolo_header_layout][0] . 'px';
				}
			}
			else {
				$logo->logo_padding_top .= 'px';
			}


			$logo->logo_padding_bottom = get_post_meta($page_id,$prefix . 'logo_padding_bottom', true);

			if (($logo->logo_padding_bottom === '') || ($logo->logo_padding_bottom == '-1')) {
				if (isset($yolo_bestruct_options['logo_padding']) && is_array($yolo_bestruct_options['logo_padding'])
					&& isset($yolo_bestruct_options['logo_padding']['padding-bottom']) && !empty($yolo_bestruct_options['logo_padding']['padding-bottom'])) {
					$logo->logo_padding_bottom = $yolo_bestruct_options['logo_padding']['padding-bottom'];
				}
				else {
					$logo->logo_padding_bottom = $logo_matrix[$yolo_header_layout][1] . 'px';
				}
			}
			else {
				$logo->logo_padding_bottom .= 'px';
			}

			$logo->logo_padding_right = get_post_meta($page_id,$prefix . 'logo_padding_right', true);

			if (($logo->logo_padding_right === '') || ($logo->logo_padding_right == '-1')) {
				if (isset($yolo_bestruct_options['logo_padding']) && is_array($yolo_bestruct_options['logo_padding'])
					&& isset($yolo_bestruct_options['logo_padding']['padding-right']) && !empty($yolo_bestruct_options['logo_padding']['padding-right'])) {
					$logo->logo_padding_right = $yolo_bestruct_options['logo_padding']['padding-right'];
				}
				else {
					$logo->logo_padding_right = $logo_matrix[$yolo_header_layout][2] . 'px';
				}
			}
			else {
				$logo->logo_padding_right .= 'px';
			}

			$logo->logo_padding_left = get_post_meta($page_id,$prefix . 'logo_padding_left', true);

			if (($logo->logo_padding_left === '') || ($logo->logo_padding_left == '-1')) {
				if (isset($yolo_bestruct_options['logo_padding']) && is_array($yolo_bestruct_options['logo_padding'])
					&& isset($yolo_bestruct_options['logo_padding']['padding-left']) && !empty($yolo_bestruct_options['logo_padding']['padding-left'])) {
					$logo->logo_padding_left = $yolo_bestruct_options['logo_padding']['padding-left'];
				}
				else {
					$logo->logo_padding_left = $logo_matrix[$yolo_header_layout][3] . 'px';
				}
			}
			else {
				$logo->logo_padding_left .= 'px';
			}

		}
		else {
			if (isset($yolo_bestruct_options['logo_padding']) && is_array($yolo_bestruct_options['logo_padding'])) {
				if (isset($yolo_bestruct_options['logo_padding']['padding-top']) && !empty($yolo_bestruct_options['logo_padding']['padding-top'])) {
					$logo->logo_padding_top = $yolo_bestruct_options['logo_padding']['padding-top'];
				}
				if (isset($yolo_bestruct_options['logo_padding']['padding-bottom']) && !empty($yolo_bestruct_options['logo_padding']['padding-bottom'])) {
					$logo->logo_padding_bottom = $yolo_bestruct_options['logo_padding']['padding-bottom'];
				}
				if (isset($yolo_bestruct_options['logo_padding']['padding-right']) && !empty($yolo_bestruct_options['logo_padding']['padding-right'])) {
					$logo->logo_padding_right = $yolo_bestruct_options['logo_padding']['padding-right'];
				}
				if (isset($yolo_bestruct_options['logo_padding']['padding-left']) && !empty($yolo_bestruct_options['logo_padding']['padding-left'])) {
					$logo->logo_padding_left = $yolo_bestruct_options['logo_padding']['padding-left'];
				}
			}
		}
		return $logo;
	}
}

// GET CUSTOM CSS VARIABLE HEADER
//--------------------------------------------------
if (!function_exists('yolo_custom_css_variable_header')) {
	function yolo_custom_css_variable_header($page_id = 0) {
		global $yolo_bestruct_options;
		$prefix = 'yolo_';

		$header = (object)array();

		$header->header_1_nav_bg_color_color 	= '#4fff';
        $header->header_1_nav_text_color     	= '#333';
        $header->header_1_height		 		= '130px';

        $header->header_2_nav_bg_color_color 	= '#fff';
        $header->header_2_nav_text_color     	= '#333';
        $header->header_2_height		 		= '130px';

        $header->header_3_nav_bg_color_color 	= '#fff';
        $header->header_3_nav_text_color     	= '#333';
        $header->header_3_height		 		= '130px';

        $header->header_4_nav_bg_color_color 	= '#fff';
        $header->header_4_nav_text_color     	= '#333';
        $header->header_4_height		 		= '130px';

        $header->header_5_nav_bg_color_color 	= '#fff';
        $header->header_5_nav_text_color     	= '#333';
        $header->header_5_height		 		= '130px';

        $header->header_6_nav_bg_color_color 	= '#fff';
        $header->header_6_nav_text_color     	= '#333';
        $header->header_6_height		 		= '130px';

        $header->headersidebar_nav_bg_color_color = '#fff';
        $header->headersidebar_nav_text_color     = '#333';
        $header->headersidebar_sidebar_width      = '300px';

        if (isset($yolo_bestruct_options['header_1_nav_bg_color']) && !empty($yolo_bestruct_options['header_1_nav_bg_color'])) {
            $header->header_1_nav_bg_color_color = $yolo_bestruct_options['header_1_nav_bg_color'];
        }
        if (isset($yolo_bestruct_options['header_1_nav_text_color']) && !empty($yolo_bestruct_options['header_1_nav_text_color'])) {
            $header->header_1_nav_text_color = $yolo_bestruct_options['header_1_nav_text_color'];
        }
        if (isset($yolo_bestruct_options['header_1_height']) && !empty($yolo_bestruct_options['header_1_height'])) {
            $header->header_1_height = $yolo_bestruct_options['header_1_height'] . 'px';
        }


        if (isset($yolo_bestruct_options['header_2_nav_bg_color']) && !empty($yolo_bestruct_options['header_2_nav_bg_color'])) {
            $header->header_2_nav_bg_color_color = $yolo_bestruct_options['header_2_nav_bg_color'];
        }
        if (isset($yolo_bestruct_options['header_2_nav_text_color']) && !empty($yolo_bestruct_options['header_2_nav_text_color'])) {
            $header->header_2_nav_text_color = $yolo_bestruct_options['header_2_nav_text_color'];
        }
        if (isset($yolo_bestruct_options['header_2_height']) && !empty($yolo_bestruct_options['header_2_height'])) {
            $header->header_2_height = $yolo_bestruct_options['header_2_height'] . 'px';
        }


        if (isset($yolo_bestruct_options['header_3_nav_bg_color']) && !empty($yolo_bestruct_options['header_3_nav_bg_color'])) {
            $header->header_3_nav_bg_color_color = $yolo_bestruct_options['header_3_nav_bg_color'];
        }
        if (isset($yolo_bestruct_options['header_3_nav_text_color']) && !empty($yolo_bestruct_options['header_3_nav_text_color'])) {
            $header->header_3_nav_text_color = $yolo_bestruct_options['header_3_nav_text_color'];
        }
        if (isset($yolo_bestruct_options['header_3_height']) && !empty($yolo_bestruct_options['header_3_height'])) {
            $header->header_3_height = $yolo_bestruct_options['header_3_height'] . 'px';
        }

        if (isset($yolo_bestruct_options['header_4_nav_bg_color']) && !empty($yolo_bestruct_options['header_4_nav_bg_color'])) {
            $header->header_4_nav_bg_color_color = $yolo_bestruct_options['header_4_nav_bg_color'];
        }
        if (isset($yolo_bestruct_options['header_4_nav_text_color']) && !empty($yolo_bestruct_options['header_4_nav_text_color'])) {
            $header->header_4_nav_text_color = $yolo_bestruct_options['header_4_nav_text_color'];
        }
        if (isset($yolo_bestruct_options['header_4_height']) && !empty($yolo_bestruct_options['header_4_height'])) {
            $header->header_4_height = $yolo_bestruct_options['header_4_height'] . 'px';
        }

        if (isset($yolo_bestruct_options['header_5_nav_bg_color']) && !empty($yolo_bestruct_options['header_5_nav_bg_color'])) {
            $header->header_5_nav_bg_color_color = $yolo_bestruct_options['header_5_nav_bg_color'];
        }
        if (isset($yolo_bestruct_options['header_5_nav_text_color']) && !empty($yolo_bestruct_options['header_5_nav_text_color'])) {
            $header->header_5_nav_text_color = $yolo_bestruct_options['header_5_nav_text_color'];
        }
        if (isset($yolo_bestruct_options['header_5_height']) && !empty($yolo_bestruct_options['header_5_height'])) {
            $header->header_5_height = $yolo_bestruct_options['header_5_height'] . 'px';
        }

        if (isset($yolo_bestruct_options['header_6_nav_bg_color']) && !empty($yolo_bestruct_options['header_6_nav_bg_color'])) {
            $header->header_6_nav_bg_color_color = $yolo_bestruct_options['header_6_nav_bg_color'];
        }
        if (isset($yolo_bestruct_options['header_6_nav_text_color']) && !empty($yolo_bestruct_options['header_6_nav_text_color'])) {
            $header->header_6_nav_text_color = $yolo_bestruct_options['header_6_nav_text_color'];
        }
        if (isset($yolo_bestruct_options['header_6_height']) && !empty($yolo_bestruct_options['header_6_height'])) {
            $header->header_6_height = $yolo_bestruct_options['header_6_height'] . 'px';
        }

        if (isset($yolo_bestruct_options['headersidebar_nav_bg_color']) && !empty($yolo_bestruct_options['headersidebar_nav_bg_color'])) {
            $header->headersidebar_nav_bg_color = $yolo_bestruct_options['headersidebar_nav_bg_color'];
        }
        if (isset($yolo_bestruct_options['headersidebar_nav_text_color']) && !empty($yolo_bestruct_options['headersidebar_nav_text_color'])) {
            $header->headersidebar_nav_text_color = $yolo_bestruct_options['headersidebar_nav_text_color'];
        }
        if (isset($yolo_bestruct_options['headersidebar_sidebar_width']) && !empty($yolo_bestruct_options['headersidebar_sidebar_width'])) {
            $header->headersidebar_sidebar_width = $yolo_bestruct_options['headersidebar_sidebar_width'] . 'px';
        }

		// Set top bar layout
		$header->top_bar_layout_padding = '100';
		if ((!empty($page_id))) {
			$header_nav_layout = get_post_meta($page_id,$prefix . 'top_bar_layout_width', true);
			if (($header_nav_layout == '-1') || ($header_nav_layout === '')) {
				$header->top_bar_layout_padding = isset($yolo_bestruct_options['top_bar_layout_padding']) ? $yolo_bestruct_options['top_bar_layout_padding'] : '100';
			}
			else if ($header_nav_layout == 'topbar-fullwith') {
				$header->top_bar_layout_padding = get_post_meta($page_id,$prefix . 'top_bar_layout_padding', true);
				if ($header->top_bar_layout_padding == '') {
					$header->top_bar_layout_padding = '100';
				}
			}

		}
		else {
			$header->top_bar_layout_padding = isset($yolo_bestruct_options['top_bar_layout_padding']) ? $yolo_bestruct_options['top_bar_layout_padding'] : '100';
			if ($header->top_bar_layout_padding == '') {
				$header->top_bar_layout_padding = '100';
			}
		}

		$header->top_bar_layout_padding .= 'px';

		// Set header nav layout
		
		$header->header_1_nav_layout_padding = (isset($yolo_bestruct_options['header_1_nav_layout_padding']) && $yolo_bestruct_options['header_1_nav_layout_padding'] != '') ? $yolo_bestruct_options['header_1_nav_layout_padding'] : '100';
        $header->header_1_nav_layout_padding .= 'px';

        $header->header_2_nav_layout_padding = (isset($yolo_bestruct_options['header_2_nav_layout_padding']) && $yolo_bestruct_options['header_2_nav_layout_padding'] != '') ? $yolo_bestruct_options['header_2_nav_layout_padding'] : '100';
        $header->header_2_nav_layout_padding .= 'px';

        $header->header_3_nav_layout_padding = (isset($yolo_bestruct_options['header_3_nav_layout_padding']) && $yolo_bestruct_options['header_3_nav_layout_padding'] != '') ? $yolo_bestruct_options['header_3_nav_layout_padding'] : '100';
        $header->header_3_nav_layout_padding .= 'px';

        $header->header_4_nav_layout_padding = (isset($yolo_bestruct_options['header_4_nav_layout_padding']) && $yolo_bestruct_options['header_4_nav_layout_padding'] != '') ? $yolo_bestruct_options['header_4_nav_layout_padding'] : '100';
        $header->header_4_nav_layout_padding .= 'px';

        $header->header_5_nav_layout_padding = (isset($yolo_bestruct_options['header_5_nav_layout_padding']) && $yolo_bestruct_options['header_5_nav_layout_padding'] != '') ? $yolo_bestruct_options['header_5_nav_layout_padding'] : '100';
        $header->header_5_nav_layout_padding .= 'px';

        $header->header_6_nav_layout_padding = (isset($yolo_bestruct_options['header_6_nav_layout_padding']) && $yolo_bestruct_options['header_6_nav_layout_padding'] != '') ? $yolo_bestruct_options['header_6_nav_layout_padding'] : '100';
        $header->header_6_nav_layout_padding .= 'px';

         // Set header navigation distance
        $header->header_1_nav_distance = (isset($yolo_bestruct_options['header_1_nav_distance']) && $yolo_bestruct_options['header_1_nav_distance'] != '') ? $yolo_bestruct_options['header_1_nav_distance'] : '30';
        $header->header_1_nav_distance .= 'px';

        $header->header_2_nav_distance = (isset($yolo_bestruct_options['header_2_nav_distance']) && $yolo_bestruct_options['header_2_nav_distance'] != '') ? $yolo_bestruct_options['header_2_nav_distance'] : '30';
        $header->header_2_nav_distance .= 'px';

        $header->header_3_nav_distance = (isset($yolo_bestruct_options['header_3_nav_distance']) && $yolo_bestruct_options['header_3_nav_distance'] != '') ? $yolo_bestruct_options['header_3_nav_distance'] : '30';
        $header->header_3_nav_distance .= 'px';

        $header->header_4_nav_distance = (isset($yolo_bestruct_options['header_4_nav_distance']) && $yolo_bestruct_options['header_4_nav_distance'] != '') ? $yolo_bestruct_options['header_4_nav_distance'] : '30';
        $header->header_4_nav_distance .= 'px';

        $header->header_5_nav_distance = (isset($yolo_bestruct_options['header_5_nav_distance']) && $yolo_bestruct_options['header_5_nav_distance'] != '') ? $yolo_bestruct_options['header_5_nav_distance'] : '30';
        $header->header_5_nav_distance .= 'px';

        $header->header_6_nav_distance = (isset($yolo_bestruct_options['header_6_nav_distance']) && $yolo_bestruct_options['header_6_nav_distance'] != '') ? $yolo_bestruct_options['header_6_nav_distance'] : '30';
        $header->header_6_nav_distance .= 'px';

		// Sub menu
		$menu_sub_scheme = isset($yolo_bestruct_options['menu_sub_scheme']) ? $yolo_bestruct_options['menu_sub_scheme'] : 'light';
		$header->menu_sub_bg_color = '#fff';
		$header->menu_sub_text_color = '#0f0f0f';
		switch ($menu_sub_scheme) {
			case 'customize':
				if (isset($yolo_bestruct_options['menu_sub_bg_color']) && ! empty($yolo_bestruct_options['menu_sub_bg_color'])) {
					$header->menu_sub_bg_color = $yolo_bestruct_options['menu_sub_bg_color'];
				}
				if (isset($yolo_bestruct_options['menu_sub_text_color']) && ! empty($yolo_bestruct_options['menu_sub_text_color'])) {
					$header->menu_sub_text_color = $yolo_bestruct_options['menu_sub_text_color'];
				}
				break;
			default:
				$header->menu_sub_bg_color = '#fff';
				$header->menu_sub_text_color = '#0f0f0f';
				break;
		}

		return $header;
	}
}

// GET CUSTOM CSS VARIABLE
//--------------------------------------------------
if (!function_exists('yolo_custom_css_variable')) {
	function yolo_custom_css_variable($page_id = 0) {
		global $yolo_bestruct_options;
		if (isset($_REQUEST['current_page_id'])) {
			$page_id = $_REQUEST['current_page_id'];
		}
		$prefix = 'yolo_';

		// Set default color for page
		$top_bar_bg_color   	  = '#fff';
		$top_bar_text_color 	  = '#0f0f0f';
		$primary_color      	  = '#fdb801';
		// Set body width
		$layout_site_width = $yolo_bestruct_options['layout_site_width']."%";
		$layout_site_max_width = $yolo_bestruct_options['layout_site_max_width']."px";
		// Set Page title style
        $page_title_color         = '#fff';
        $page_sub_title_color     = '#fff';
        $page_title_margin_top    = '30px';
        $page_title_margin_bottom = '30px';
        $page_title_bg_color      = '#424242';
        $page_title_height        = '250px';
        $page_title_overlay_color = 'rgba(255,255,255,0.3)';

		// Top bar color
		$enable_topbar_color 	  = get_post_meta($page_id,$prefix.'enable_topbar_color',true);
		if ('1' == $enable_topbar_color) {
            $top_bar_bg_color = get_post_meta($page_id, $prefix . 'top_bar_bg_color', true);
            if ($top_bar_bg_color == '') {
                if (isset($yolo_bestruct_options['top_bar_bg_color']) && !empty($yolo_bestruct_options['top_bar_bg_color'])) {
                    $top_bar_bg_color = $yolo_bestruct_options['top_bar_bg_color'];
                }
            }
            $top_bar_text_color = get_post_meta($page_id, $prefix . 'top_bar_text_color', true);
            if ($top_bar_text_color == '') {
                if (isset($yolo_bestruct_options['top_bar_text_color']) && !empty($yolo_bestruct_options['top_bar_text_color'])) {
                    $top_bar_text_color = $yolo_bestruct_options['top_bar_text_color'];
                }
            }
        } else {
            if (isset($yolo_bestruct_options['top_bar_bg_color']) && !empty($yolo_bestruct_options['top_bar_bg_color'])) {
                $top_bar_bg_color = $yolo_bestruct_options['top_bar_bg_color'];
            }
            if (isset($yolo_bestruct_options['top_bar_text_color']) && !empty($yolo_bestruct_options['top_bar_text_color'])) {
                $top_bar_text_color = $yolo_bestruct_options['top_bar_text_color'];
            }
        }
        // Styling Option

		if (isset($yolo_bestruct_options['primary_color']) && ! empty($yolo_bestruct_options['primary_color'])) {
			$primary_color = $yolo_bestruct_options['primary_color'];
		}

		$secondary_color = '#0195fd';
		if (isset($yolo_bestruct_options['secondary_color']) && ! empty($yolo_bestruct_options['secondary_color'])) {
			$secondary_color = $yolo_bestruct_options['secondary_color'];
		}

		$text_color = '#606060';
		if (isset($yolo_bestruct_options['text_color']) && ! empty($yolo_bestruct_options['text_color'])) {
			$text_color = $yolo_bestruct_options['text_color'];
		}

		$heading_color = '#0f0f0f';
		if (isset($yolo_bestruct_options['heading_color']) && ! empty($yolo_bestruct_options['heading_color'])) {
			$heading_color = $yolo_bestruct_options['heading_color'];
		}

		// Page Title
		//-------------------

		$page_title_margin_top = get_post_meta(get_the_ID(), $prefix . 'page_title_margin_top', true);
        if (!isset($page_title_margin_top) || empty($page_title_margin_top)) {
            if (isset($yolo_bestruct_options['page_title_margin'])) {
                $page_title_margin_top = $yolo_bestruct_options['page_title_margin']['margin-top'];
            }

        } else {
            $page_title_margin_top = $page_title_margin_top . 'px';
        }

        $page_title_margin_bottom = get_post_meta(get_the_ID(), $prefix . 'page_title_margin_bottom', true);
        if (!isset($page_title_margin_bottom) || empty($page_title_margin_bottom)) {
            if (isset($yolo_bestruct_options['page_title_margin']['margin-bottom']) && !empty($yolo_bestruct_options['page_title_margin']['margin-bottom'])) {
                $page_title_margin_bottom = $yolo_bestruct_options['page_title_margin']['margin-bottom'];
            }

        } else {
            $page_title_margin_bottom = $page_title_margin_bottom . 'px';
        }

        $page_title_height = get_post_meta(get_the_ID(), $prefix . 'page_title_height', true);
        if (!isset($page_title_height) || empty($page_title_height)) {
            if (isset($yolo_bestruct_options['page_title_height']) && !empty($yolo_bestruct_options['page_title_height'])) {
                $page_title_height = $yolo_bestruct_options['page_title_height'] . 'px';
            }

        } else {
            $page_title_height = $page_title_height . 'px';
        }

        if (isset($yolo_bestruct_options['page_title_bg_color']) && !empty($yolo_bestruct_options['page_title_bg_color'])) {
            $page_title_bg_color = $yolo_bestruct_options['page_title_bg_color'];
        }
        if (isset($yolo_bestruct_options['page_title_color']) && !empty($yolo_bestruct_options['page_title_color'])) {
            $page_title_color = $yolo_bestruct_options['page_title_color'];
        }

        if (isset($yolo_bestruct_options['page_sub_title_color']) && !empty($yolo_bestruct_options['page_sub_title_color'])) {
            $page_sub_title_color = $yolo_bestruct_options['page_sub_title_color'];
        }

        if (isset($yolo_bestruct_options['page_title_overlay_color']) && !empty($yolo_bestruct_options['page_title_overlay_color'])) {
            $page_title_overlay_color = $yolo_bestruct_options['page_title_overlay_color'];
        }

		// Mobile menu
		$logo_mobile_padding     = '15px';
		$logo_mobile_matrix = array(
			'header-mobile-1' => array(15),
			'header-mobile-2' => array(25),
			'header-mobile-3' => array(15),
			'header-mobile-4' => array(15),
			'header-mobile-5' => array(15),
		);

		// GET logo_padding
		$mobile_header_layout = isset($yolo_bestruct_options['mobile_header_layout']) ? $yolo_bestruct_options['mobile_header_layout'] : 'header-mobile-2';

		if (isset($logo_mobile_matrix[$mobile_header_layout])) {
			$logo_mobile_padding    = $logo_mobile_matrix[$mobile_header_layout][0] . 'px';
		}
		if (isset($yolo_bestruct_options['logo_mobile_padding']) && ! empty($yolo_bestruct_options['logo_mobile_padding'])) {
			$logo_mobile_padding = $yolo_bestruct_options['logo_mobile_padding']. 'px';
		}
		$fonts  = yolo_custom_css_variable_font();
		$logo   = yolo_custom_css_variable_logo($page_id);
		$header = yolo_custom_css_variable_header($page_id);
		ob_start();
		echo "@layout_site_width:			$layout_site_width;", PHP_EOL;
		echo "@layout_site_max_width:		$layout_site_max_width;", PHP_EOL;
		// Styling Option
		echo "@primary_color:				$primary_color;", PHP_EOL;
		echo "@secondary_color:				$secondary_color;", PHP_EOL;
		echo "@text_color:					$text_color;", PHP_EOL;
		echo "@heading_color:				$heading_color;", PHP_EOL;

		// Top bar
		echo "@top_bar_layout_padding:		$header->top_bar_layout_padding;", PHP_EOL;
		echo "@top_bar_bg_color:			$top_bar_bg_color;", PHP_EOL;
		echo "@top_bar_text_color:			$top_bar_text_color;", PHP_EOL;

		// Menu font
		echo "@menu_font:				'$fonts->menu_font_family';", PHP_EOL;
		echo "@menu_font_weight:		$fonts->menu_font_weight;", PHP_EOL;
		echo "@menu_font_size:			$fonts->menu_font_size;", PHP_EOL;
		
		// Second font
		echo "@secondary_font:			'$fonts->secondary_font_family';", PHP_EOL;
		echo "@secondary_font_weight:	$fonts->secondary_font_weight;", PHP_EOL;
		echo "@secondary_font_size:		$fonts->secondary_font_size;", PHP_EOL;
		
		// Primary font
		echo "@primary_font:			'$fonts->primary_font_family';", PHP_EOL;
		echo "@primary_font_weight:		$fonts->primary_font_weight;", PHP_EOL;
		echo "@primary_font_size:		$fonts->primary_font_size;", PHP_EOL;

		// Page title
		echo "@page_title_color: 			$page_title_color;", PHP_EOL;
        echo "@page_sub_title_color: 		$page_sub_title_color;", PHP_EOL;
        echo "@page_title_bg_color:			$page_title_bg_color;", PHP_EOL;
        echo "@page_title_overlay_color:	$page_title_overlay_color;", PHP_EOL;
        echo "@page_title_margin_top: 		$page_title_margin_top;", PHP_EOL;
        echo "@page_title_margin_bottom: 	$page_title_margin_bottom;", PHP_EOL;
        echo "@page_title_height: 			$page_title_height;", PHP_EOL;

        // Logo
		echo "@logo_padding_top:		$logo->logo_padding_top;", PHP_EOL;
		echo "@logo_padding_bottom:		$logo->logo_padding_bottom;", PHP_EOL;
		echo "@logo_padding_right:		$logo->logo_padding_right;", PHP_EOL;
		echo "@logo_padding_left:		$logo->logo_padding_left;", PHP_EOL;
		echo "@logo_mobile_padding:		$logo_mobile_padding;", PHP_EOL;

		// Header
		echo "@header_1_nav_layout_padding:	$header->header_1_nav_layout_padding;", PHP_EOL;
        echo "@header_2_nav_layout_padding:	$header->header_2_nav_layout_padding;", PHP_EOL;
        echo "@header_3_nav_layout_padding:	$header->header_3_nav_layout_padding;", PHP_EOL;
        echo "@header_4_nav_layout_padding:	$header->header_4_nav_layout_padding;", PHP_EOL;
        echo "@header_5_nav_layout_padding:	$header->header_5_nav_layout_padding;", PHP_EOL;
        echo "@header_6_nav_layout_padding:	$header->header_6_nav_layout_padding;", PHP_EOL;
        echo "@header_1_nav_distance:		$header->header_1_nav_distance;", PHP_EOL;
        echo "@header_2_nav_distance:		$header->header_2_nav_distance;", PHP_EOL;
        echo "@header_3_nav_distance:		$header->header_3_nav_distance;", PHP_EOL;
        echo "@header_4_nav_distance:		$header->header_4_nav_distance;", PHP_EOL;
        echo "@header_5_nav_distance:		$header->header_5_nav_distance;", PHP_EOL;
        echo "@header_6_nav_distance:		$header->header_6_nav_distance;", PHP_EOL;

		echo "@menu_sub_bg_color:			$header->menu_sub_bg_color;", PHP_EOL;
		echo "@menu_sub_text_color:			$header->menu_sub_text_color;", PHP_EOL;

		echo "@header_1_nav_bg_color: 		$header->header_1_nav_bg_color_color;", PHP_EOL;
        echo "@header_1_nav_text_color: 	$header->header_1_nav_text_color;", PHP_EOL;
        echo "@header_1_height: 			$header->header_1_height;", PHP_EOL;

        echo "@header_2_nav_bg_color: 		$header->header_2_nav_bg_color_color;", PHP_EOL;
        echo "@header_2_nav_text_color: 	$header->header_2_nav_text_color;", PHP_EOL;
        echo "@header_2_height: 			$header->header_2_height;", PHP_EOL;

        echo "@header_3_nav_bg_color: 		$header->header_3_nav_bg_color_color;", PHP_EOL;
        echo "@header_3_nav_text_color: 	$header->header_3_nav_text_color;", PHP_EOL;
        echo "@header_3_height: 			$header->header_3_height;", PHP_EOL;

        echo "@header_4_nav_bg_color: 		$header->header_4_nav_bg_color_color;", PHP_EOL;
        echo "@header_4_nav_text_color: 	$header->header_4_nav_text_color;", PHP_EOL;
        echo "@header_4_height: 			$header->header_4_height;", PHP_EOL;

        echo "@header_5_nav_bg_color: 		$header->header_5_nav_bg_color_color;", PHP_EOL;
        echo "@header_5_nav_text_color: 	$header->header_5_nav_text_color;", PHP_EOL;
        echo "@header_5_height: 			$header->header_5_height;", PHP_EOL;

        echo "@header_6_nav_bg_color: 		$header->header_6_nav_bg_color_color;", PHP_EOL;
        echo "@header_6_nav_text_color: 	$header->header_6_nav_text_color;", PHP_EOL;
        echo "@header_6_height: 			$header->header_6_height;", PHP_EOL;

        echo "@headersidebar_nav_bg_color: 	$header->headersidebar_nav_bg_color;", PHP_EOL;
        echo "@headersidebar_nav_text_color:$header->headersidebar_nav_text_color;", PHP_EOL;
        echo "@headersidebar_sidebar_width: $header->headersidebar_sidebar_width;", PHP_EOL;

		echo '@theme_url:"'. get_template_directory_uri() . '";', PHP_EOL;

		// echo sprintf('%s', $header->header_background_css), PHP_EOL;

		return ob_get_clean();
	}
}

// GET CUSTOM CSS
//--------------------------------------------------
if (!function_exists('yolo_custom_css')) {
	function yolo_custom_css() {
		global $yolo_bestruct_options;
		$custom_css           = '';
		$background_image_css = '';

		$body_background_mode = $yolo_bestruct_options['body_background_mode'];
		
		if ($body_background_mode == 'background') {
			$background_image_url = isset($yolo_bestruct_options['body_background']['background-image']) ? $yolo_bestruct_options['body_background']['background-image'] : '';
			$background_color     = isset($yolo_bestruct_options['body_background']['background-color']) ? $yolo_bestruct_options['body_background']['background-color'] : '';

			if (!empty($background_color)) {
				$background_image_css .= 'background-color:' . $background_color . ';';
			}

			if (!empty($background_image_url)) {
				$background_repeat     = isset($yolo_bestruct_options['body_background']['background-repeat']) ? $yolo_bestruct_options['body_background']['background-repeat'] : '';
				$background_position   = isset($yolo_bestruct_options['body_background']['background-position']) ? $yolo_bestruct_options['body_background']['background-position'] : '';
				$background_size       = isset($yolo_bestruct_options['body_background']['background-size']) ? $yolo_bestruct_options['body_background']['background-size'] : '';
				$background_attachment = isset($yolo_bestruct_options['body_background']['background-attachment']) ? $yolo_bestruct_options['body_background']['background-attachment'] : '';
				
				$background_image_css  .= 'background-image: url("'. $background_image_url .'");';


				if (!empty($background_repeat)) {
					$background_image_css .= 'background-repeat: '. $background_repeat .';';
				}

				if (!empty($background_position)) {
					$background_image_css .= 'background-position: '. $background_position .';';
				}

				if (!empty($background_size)) {
					$background_image_css .= 'background-size: '. $background_size .';';
				}

				if (!empty($background_attachment)) {
					$background_image_css .= 'background-attachment: '. $background_attachment .';';
				}
			}

		}

		if ($body_background_mode == 'pattern') {
			$background_image_url =  get_template_directory_uri() . '/assets/images/theme-options/' . $yolo_bestruct_options['body_background_pattern'];
			$background_image_css .= 'background-image: url("'. $background_image_url .'");';
			$background_image_css .= 'background-repeat: repeat;';
			$background_image_css .= 'background-position: center center;';
			$background_image_css .= 'background-size: auto;';
			$background_image_css .= 'background-attachment: scroll;';
		}

		if (!empty($background_image_css)) {
			$custom_css.= 'body{'.$background_image_css.'}';
		}
		// if (isset($yolo_bestruct_options['custom_css'])) {
		// 	$custom_css .=  $yolo_bestruct_options['custom_css'];
		// }

		$custom_css = str_replace( "\r\n", '', $custom_css );
		$custom_css = str_replace( "\n", '', $custom_css );
		$custom_css = str_replace( "\t", '', $custom_css );

		return $custom_css;
	}
}


/* ajax */
if( !function_exists( 'yolo_ajax_get_sections' ) ) :
	function yolo_ajax_get_sections(){
		
				/* Get data of 1 item in templater */
		if ( isset( $_REQUEST['install'] ) && $_REQUEST['install'] != ''){		
			$id =$_REQUEST['install'];
            $output = '';
           
            if ( empty( $id ) ) {
                return $output;
            }

            $my_query = new WP_Query( array( 'post_type' => 'yolo_templater', 'p' => (int)$id ) );
            while ( $my_query->have_posts() ) {
                $my_query->the_post();
                if( get_the_ID() === (int)$id ) {
                    ob_start();
                    visual_composer()->addFrontCss();
                    $content = get_the_content();
                   
                    echo ($content);
                    $output .= ob_get_clean();
                }
            }
            wp_reset_postdata();
            echo trim( ($output) );
            exit();

            	/* End get data of 1 item in templater */
        }else{


				/* Get list category of templater */
			$categories_templater = get_terms( 'templater_category', 'orderby=count&hide_empty=0' );
			$yolo_data['yolo_sections'] = '<option value="starter-all">'.__( "All", "yolo-bestruct" ).'</option>';
			$yolo_data['term_id'] = '';
			foreach ( $categories_templater as $item ) {
				if($item->count > 0){
					$yolo_data['yolo_sections'] .='	<option value="starter-'.$item->term_id.'">'.$item->name.'</option>';
				}
			}

			$custom_terms = get_terms('templater_category');
	        $yolo_data['yolo_contents'] = '';
	        foreach ( $custom_terms as $template ) {
			    $args = array('post_type' => 'yolo_templater',
			        'tax_query' => array(
			            array(
			                'taxonomy' => 'templater_category',
			                'field' => 'slug',
			                'terms' => $template->slug,
			            ),
			        ),
			     );

			    $loop = new WP_Query($args);
			    if($loop->have_posts()) {
				    
			    		$yolo_data['yolo_contents'] .= '<div class="sc-layout starter-'.$template->term_id.'">';
				        while($loop->have_posts()) : $loop->the_post();
				            $yolo_data['yolo_contents'] .= '<div class="ltitem ">';
				            $yolo_data['yolo_contents'] .= '<div class="item-thumbn">';
				            if(wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')){
					            $image_pr= wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					            $yolo_data['yolo_contents'] .=      '<img src="'.$image_pr['0'].'" />';
					        }
					        $yolo_data['yolo_contents'] .= '</div>';
				            $yolo_data['yolo_contents'] .=      '<div class="item-desc"><span>' . get_the_title() . '</span><br/>';
				            $yolo_data['yolo_contents'] .=          '<button class="btn btn-info installSection" rel="'.get_the_ID().'"><i class="fa fa-cloud-download"></i>Install
										</button>';
				            $yolo_data['yolo_contents'] .=      '</div>';
				            $yolo_data['yolo_contents'] .= '</div>';

				        endwhile;
				         $yolo_data['yolo_contents'] .= '</div>';
				    }
				    wp_reset_postdata();
	        }
	       
		       	/* End get list item in templater	*/
        }

		$data= (json_encode( $yolo_data ));
		echo ($data);
		exit;
	}

endif;

add_action( 'wp_ajax_yolo_ajax_get_sections', 'yolo_ajax_get_sections' );
add_action( 'wp_ajax_nopriv_yolo_ajax_get_sections', 'yolo_ajax_get_sections' );
