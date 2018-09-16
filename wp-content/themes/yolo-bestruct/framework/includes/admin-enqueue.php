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

if (!function_exists('yolo_admin_enqueue_scripts')) {

	function yolo_admin_enqueue_scripts() {
		// Enqueue Script
		wp_register_script( 'admin-app-js', get_template_directory_uri() . '/admin/assets/js/yolo_admin.js',array(), '1.0.0', true );
		wp_enqueue_script( 'admin-yolo-color-picker-init.js', get_template_directory_uri() . '/admin/assets/js/yolo-color-picker-init.js',array('jquery', 'wp-color-picker'), '1.0.0', true );

		/* yolo_sections.js: install demo */
		 wp_enqueue_script( 'admin-install-sections', get_template_directory_uri() . '/admin/assets/js/yolo_sections.js',array(), '1.0.0', true );
		/* datetimepicker */
		wp_register_script('datetimepicker', get_template_directory_uri() . '/admin/assets/js/datetimepicker/jquery.datetimepicker.js', array(), false, true);
		if ( class_exists( 'RW_Meta_Box' ) ) { // Check metabox plugin load before load js for tab
			global $meta_boxes;
			$meta_box_id = '';
			foreach ($meta_boxes as $box) {
				if (!isset($box['tab'])) {
					continue;
				}
				if (!empty($meta_box_id)) {
					$meta_box_id .= ',';
				}
				$meta_box_id .= '#' . $box['id'];
			}
			wp_localize_script( 'admin-app-js' , 'meta_box_ids' , $meta_box_id);
		}
		wp_enqueue_script('admin-app-js');

		// Enqueue CSS
		wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/admin/assets/css/admin_style.css', false, '1.0.0' );

		/* datetimepicker */
		wp_register_style('datetimepicker', get_template_directory_uri() . '/admin/assets/js/datetimepicker/jquery.datetimepicker.css', array());
		/* Font-Awesome */
		wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome.min.css', array());
		wp_enqueue_style( 'admin-install-sections', get_template_directory_uri() . '/admin/assets/css/yolo_sections.css', false, '1.0.0' );
		wp_enqueue_style('yolo_framework_font_awesome_animation', get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome-animation.min.css', array());

		wp_localize_script( 'admin-app-js', 'yolo_admin', array(
			'ajaxurl'                    => admin_url( 'admin-ajax.php' ),
			'updater_plugin_url'         => admin_url( 'admin-ajax.php?action=yolo_updater_plugin' ),
			'updater_plugin_nonce'       => wp_create_nonce( 'yolo-updater-plugin' ),
			'install_plugin_url'         => admin_url( 'admin-ajax.php?action=yolo_install_plugin' ),
			'install_plugin_nonce'       => wp_create_nonce( 'yolo-install-plugin' ),
			'deactivate_plugin_url'      => admin_url( 'admin-ajax.php?action=yolo_deactivate_plugin' ),
			'deactivate_plugin_nonce'    => wp_create_nonce( 'yolo-deactivate-plugin' ),
			'uninstall_plugin_url'       => admin_url( 'admin-ajax.php?action=yolo_uninstall_plugin' ),
			'uninstall_plugin_nonce'     => wp_create_nonce( 'yolo-uninstall-plugin' ),
			'install'                    => esc_html__( 'Install', 'yolo-bestruct' ),
			'installed'                  => esc_html__( 'Completed!', 'yolo-bestruct' ),
			'activate'                   => esc_html__( 'Activate', 'yolo-bestruct' ),
			'deactivate'                 => esc_html__( 'Deactivate', 'yolo-bestruct' ),
			'deactivated'                => esc_html__( 'Deactivated!', 'yolo-bestruct' ),
			'uninstall'                  => esc_html__( 'Uninstall', 'yolo-bestruct' ),
			'uninstalled'                => esc_html__( 'Uninstalled!', 'yolo-bestruct' ),
			'updating'                   => esc_html__( 'Updating...', 'yolo-bestruct' ),
			'updated'                    => esc_html__( 'Updated!', 'yolo-bestruct' ),
			'install_all_plugin'         => esc_html__( 'Install All Plugins', 'yolo-bestruct' ),
			'all_success'                => esc_html__( 'You installed successfull!', 'yolo-bestruct' ),
			'confirm_updater_plugin'     => esc_html__( 'Update %PLUGIN% plugin?', 'yolo-bestruct' ),
			'confirm_install_plugin'     => esc_html__( 'Install %PLUGIN% plugin?', 'yolo-bestruct' ),
			'confirm_install_all_plugin' => esc_html__( 'Install all plugin?', 'yolo-bestruct' ),
			'confirm_deactivate_plugin'  => esc_html__( 'Deactivate %PLUGIN% plugin?', 'yolo-bestruct' ),
			'confirm_uninstall_plugin'   => esc_html__( 'Uninstall %PLUGIN% plugin?', 'yolo-bestruct' ),
			'unknown_error'              => esc_html__( 'An unknown error was occurred. Please try again later.', 'yolo-bestruct' ),
			'install_plugin_failed'      => esc_html__( 'Failed to install the plugin %s. This might due to corrupted internet connection.', 'yolo-bestruct' ),
		) );
	}
	add_action( 'admin_enqueue_scripts', 'yolo_admin_enqueue_scripts' );
}

/*================================================
GET CURRENT PAGE URL @TODO: need move to other file. It support for load sidebar script
================================================== */
if (!function_exists('yolo_current_page_url')) {
    function yolo_current_page_url() {
		$pageURL = 'http';
        if ( isset( $_SERVER["HTTPS"] ) ) {
            if ( $_SERVER["HTTPS"] == "on" ) {
                $pageURL .= "s";
            }
        }
        $pageURL .= "://";
        if ( $_SERVER["SERVER_PORT"] != "80" ) {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }

        return $pageURL;
    }
}

// Sidebar script to add custom sidebar
if( !function_exists( 'yolo_sidebar_script' ) ) {
	$current_page = yolo_current_page_url();
	$page_parts   = pathinfo($current_page);
	$basename     = $page_parts['basename'];
	if( $basename == 'widgets.php') {
		function yolo_sidebar_script() {
			wp_enqueue_script( 'yolo_sidebar', get_template_directory_uri() . '/admin/assets/js/yolo_sidebar.js',array(), '1.0.0', true );
		}

		add_action( 'admin_enqueue_scripts', 'yolo_sidebar_script' );
	}
	
}

