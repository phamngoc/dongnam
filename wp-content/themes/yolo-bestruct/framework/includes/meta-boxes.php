<?php
/**
 *
 *	Meta Box Functions
 *	------------------------------------------------
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 * @see 		
*/
global $meta_boxes;

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 * https://metabox.io/docs/registering-meta-boxes/
 * https://metabox.io/docs/filters/
 * https://metabox.io/docs/meta-box-conditional-logic/#section-the-example
 * @return void
 */

function yolo_register_meta_boxes() {
	global $meta_boxes;
	$prefix = 'yolo_';
	/* PAGE MENU */
	$menu_list = array();
	if ( function_exists( 'yolo_get_menu_list' ) ) {
		$menu_list = yolo_get_menu_list();
	}
	/* PAGE SIDEBARS */
	$sidebar_list = array();
	if ( function_exists( 'yolo_get_sidebar_list' ) ) {
		$sidebar_list = yolo_get_sidebar_list();
	}

	// POST FORMAT: Image
	//--------------------------------------------------
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Image', 'yolo-bestruct' ),
		'id'         => $prefix .'meta_box_post_format_image',
		'post_types' => array('post'),
		'fields'     => array(
			array(
				'name'             => esc_html__('Image', 'yolo-bestruct'),
				'id'               => $prefix . 'post_format_image',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'desc'             => esc_html__( 'Select a image for post','yolo-bestruct' )
			),
		),
	);

	// POST FORMAT: Gallery
	//--------------------------------------------------
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Gallery', 'yolo-bestruct' ),
		'id'         => $prefix . 'meta_box_post_format_gallery',
		'post_types' => array('post'),
		'fields'     => array(
			array(
				'name' => esc_html__( 'Images', 'yolo-bestruct' ),
				'id'   => $prefix . 'post_format_gallery',
				'type' => 'image_advanced',
				'desc' => esc_html__( 'Select images gallery for post','yolo-bestruct' )
			),
		),
	);

	// POST FORMAT: Video
	//--------------------------------------------------
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Video', 'yolo-bestruct' ),
		'id'         => $prefix . 'meta_box_post_format_video',
		'post_types' => array('post'),
		'fields'     => array(
			array(
				'name' => esc_html__( 'Video URL or Embeded Code', 'yolo-bestruct' ),
				'id'   => $prefix . 'post_format_video',
				'type' => 'textarea',
			),
		),
	);

	// POST FORMAT: Audio
	//--------------------------------------------------
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Audio', 'yolo-bestruct' ),
		'id'         => $prefix . 'meta_box_post_format_audio',
		'post_types' => array('post'),
		'fields'     => array(
			array(
				'name' => esc_html__( 'Audio URL or Embeded Code', 'yolo-bestruct' ),
				'id'   => $prefix . 'post_format_audio',
				'type' => 'textarea',
			),
		),
	);

	// POST FORMAT: QUOTE
	//--------------------------------------------------
    $meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Quote', 'yolo-bestruct' ),
		'id'         => $prefix . 'meta_box_post_format_quote',
		'post_types' => array('post'),
		'fields'     => array(
            array(
                'name' => esc_html__( 'Quote', 'yolo-bestruct' ),
                'id'   => $prefix . 'post_format_quote',
                'type' => 'textarea',
            ),
            array(
                'name' => esc_html__( 'Author', 'yolo-bestruct' ),
                'id'   => $prefix . 'post_format_quote_author',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Author Url', 'yolo-bestruct' ),
                'id'   => $prefix . 'post_format_quote_author_url',
                'type' => 'url',
            ),
        ),
    );
    // POST FORMAT: LINK
	//--------------------------------------------------
    $meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Link', 'yolo-bestruct' ),
		'id'         => $prefix . 'meta_box_post_format_link',
		'post_types' => array('post'),
		'fields'     => array(
            array(
                'name' => esc_html__( 'Url', 'yolo-bestruct' ),
                'id'   => $prefix . 'post_format_link_url',
                'type' => 'url',
            ),
            array(
                'name' => esc_html__( 'Text', 'yolo-bestruct' ),
                'id'   => $prefix . 'post_format_link_text',
                'type' => 'text',
            ),
        ),
    );

	// PAGE LAYOUT
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_layout_meta_box',
		'title'      => esc_html__( 'Page Layout', 'yolo-bestruct' ),
		'post_types' => array('page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Layout Style', 'yolo-bestruct' ),
				'id'      => $prefix . 'layout_style',
				'type'    => 'button_set',
				'options' => array(
					'-1'    => esc_html__( 'Default','yolo-bestruct' ),
					'boxed' => esc_html__( 'Boxed','yolo-bestruct' ),
					'wide'  => esc_html__( 'Wide','yolo-bestruct' ),
					'float' => esc_html__( 'Float','yolo-bestruct' )
				),
				'std'      => '-1',
				'multiple' => false,
			),
			array(
				'name'    => esc_html__( 'Page Layout', 'yolo-bestruct' ),
				'id'      => $prefix . 'page_layout',
				'type'    => 'button_set',
				'options' => array(
					'-1'              => esc_html__( 'Default','yolo-bestruct' ),
					'full'            => esc_html__( 'Full Width','yolo-bestruct' ),
					'container'       => esc_html__( 'Container','yolo-bestruct' ),
					'container-fluid' => esc_html__( 'Container Fluid','yolo-bestruct' ),
				),
				'std'      => '-1',
				'multiple' => false,
			),
			// Add to fix page background color
			array(
				'name'           => esc_html__( 'Page background color', 'yolo-bestruct' ),
				'id'             => $prefix . 'page_background_color',
				'desc'           => esc_html__( "Optionally set background color for the page.", 'yolo-bestruct' ),
				'type'           => 'color',
				'std'            => '',
			),
			array(
				'name'       => esc_html__( 'Page Sidebar', 'yolo-bestruct' ),
				'id'         => $prefix . 'page_sidebar',
				'type'       => 'image_set',
				'allowClear' => true,
				'options'    => array(
					'none'	  => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png',
					'left'	  => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png',
					'right'	  => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png',
					'both'	  => get_template_directory_uri().'/assets/images/theme-options/sidebar-both.png'
				),
				'std'      => '',
				'multiple' => false,

			),

			array(
				'name'        => esc_html__( 'Left Sidebar', 'yolo-bestruct' ),
				'id'          => $prefix . 'page_left_sidebar',
				'type'        => 'select',
				'options'     => $sidebar_list,
				'placeholder' => esc_html__( 'Select Sidebar','yolo-bestruct' ),
				'std'         => '',
				'visible'      => array( $prefix . 'page_sidebar', 'in', array('','left','both') )
			),

			array(
				'name'        => esc_html__( 'Right Sidebar', 'yolo-bestruct' ),
				'id'          => $prefix . 'page_right_sidebar',
				'type'        => 'select',
				'options'     => $sidebar_list,
				'placeholder' => esc_html__( 'Select Sidebar','yolo-bestruct' ),
				'std'         => '',
				'visible'      => array( $prefix . 'page_sidebar', 'in', array('','right','both') )
			),

			array(
				'name'    => esc_html__( 'Sidebar Width', 'yolo-bestruct' ),
				'id'      => $prefix . 'sidebar_width',
				'type'    => 'button_set',
				'options' => array(
					'-1'    => esc_html__( 'Default','yolo-bestruct' ),
					'small' => esc_html__( 'Small (1/4)','yolo-bestruct' ),
					'large' => esc_html__( 'Large (1/3)','yolo-bestruct' )
				),
				'std'            => '-1',
				'multiple'       => false,
				'hidden' => array( $prefix . 'page_sidebar', '=', 'none' )
			),

			array(
				'name' 	=> esc_html__( 'Page Class Extra', 'yolo-bestruct' ),
				'id' 	=> $prefix . 'page_class_extra',
				'type' 	=> 'text',
				'std' 	=> ''
			),
		)
	);
	// PAGE TOP BAR
	$meta_boxes[] = array(
		'id'         => $prefix . 'site_top_meta_box',
		'title'      => esc_html__( 'Page Top Bar', 'yolo-bestruct' ),
		'post_types' => array('page'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Show/Hide Top Bar', 'yolo-bestruct' ),
				'id'      => $prefix . 'top_bar',
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1' => esc_html__( 'Default','yolo-bestruct' ),
					'1'  => esc_html__( 'Show','yolo-bestruct' ),
					'0'  => esc_html__( 'Hide','yolo-bestruct' )
				),
			),
			array(
				'id'      => $prefix . 'top_bar_layout_width',
				'name'    => esc_html__( 'Top bar layout width', 'yolo-bestruct' ),
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1'           => esc_html__( 'Default', 'yolo-bestruct' ),
					'container'    => esc_html__( 'Container', 'yolo-bestruct' ),
					'topbar-fullwith' => esc_html__( 'Full width', 'yolo-bestruct' ),
				),
				'visible' => array( $prefix . 'top_bar', '!=', '0' )
			),
			array(
				'id'         => $prefix .'top_bar_layout_padding',
				'name'       => esc_html__( 'Top bar padding left/right (px)', 'yolo-bestruct' ),
				'clone'      => false,
				'type'       => 'slider',
				'prefix'     => '',
				'js_options' => array(
					'min'  => 0,
					'max'  => 200,
					'step' => 1,
				),
				'std'            => '100',
				'visible' => array( $prefix . 'top_bar_layout_width', '=', 'topbar-fullwith' )
			),
			array(
				'name'       => esc_html__( 'Top Bar Layout', 'yolo-bestruct' ),
				'id'         => $prefix . 'top_bar_layout',
				'type'       => 'image_set',
				'allowClear' => true,
				'width'      => '80px',
				'std'        => '',
				'options'    => array(
					'top-bar-1' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-1.jpg',
					'top-bar-2' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-2.jpg',
					'top-bar-3' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-3.jpg',
					'top-bar-4' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-4.jpg'
				),
				'visible' => array( $prefix . 'top_bar', '!=', '0' )
			),

			array(
				'name'           => esc_html__( 'Top Left Sidebar', 'yolo-bestruct' ),
				'id'             => $prefix . 'top_left_sidebar',
				'type'           => 'select',
				'options'        => $sidebar_list,
				'std'            => '',
				'placeholder'    => esc_html__( 'Select Sidebar', 'yolo-bestruct' ),
				'multiple'       => false,
				'visible' => array( $prefix . 'top_bar_layout', 'in', array('top-bar-1','top-bar-2','top-bar-3') )
			),

			array(
				'name'           => esc_html__( 'Top Right Sidebar', 'yolo-bestruct' ),
				'id'             => $prefix . 'top_right_sidebar',
				'type'           => 'select',
				'options'        => $sidebar_list,
				'std'            => '',
				'placeholder'    => esc_html__( 'Select Sidebar','yolo-bestruct' ),
				'visible' => array( $prefix . 'top_bar_layout', 'in', array('top-bar-1','top-bar-2','top-bar-3') )
			),

			array(
				'name'           => esc_html__( 'Top Center Sidebar', 'yolo-bestruct' ),
				'id'             => $prefix . 'top_center_sidebar',
				'type'           => 'select',
				'options'        => $sidebar_list,
				'std'            => '',
				'placeholder'    => esc_html__( 'Select Sidebar','yolo-bestruct' ),
				'visible' => array( $prefix . 'top_bar_layout', '=', 'top-bar-4' )
			),

			array (
				'name' 	=> esc_html__('Top Bar Scheme', 'yolo-bestruct'),
				'id' 	=> $prefix . 'top-bar-scheme-section',
				'type' 	=> 'section',
			),
			array(
				'name' => esc_html__( 'Customize Top Bar Color?', 'yolo-bestruct' ),
				'id'   => $prefix . 'enable_topbar_color',
				'type' => 'checkbox_advanced',
				'std'  => 0,
				'visible' => array( $prefix . 'top_bar', '!=', '0' )
			),
			array(
				'name'   => esc_html__( 'Top bar text color', 'yolo-bestruct' ),
				'id'     => $prefix . 'top_bar_text_color',
				'desc'   => esc_html__( "Set top bar text color.", 'yolo-bestruct' ),
				'type'   => 'color',
				'std'    => '',
				'hidden' => array( $prefix . 'enable_topbar_color', '!=', '1' )
			),
			array(
				'name'   => esc_html__( 'Top bar background color', 'yolo-bestruct' ),
				'id'     => $prefix . 'top_bar_bg_color',
				'desc'   => esc_html__( "Set top bar background color.", 'yolo-bestruct' ),
				'type'   => 'color',
				'std'    => '',
				'hidden' => array( $prefix . 'enable_topbar_color', '!=', '1' )
			),
			array(
				'name'       => esc_html__( 'Top bar background color opacity', 'yolo-bestruct' ),
				'id'         => $prefix .'top_bar_bg_color_opacity',
				'desc'       => esc_html__( 'Set the opacity level of the top bar background color', 'yolo-bestruct' ),
				'clone'      => false,
				'type'       => 'slider',
				'prefix'     => '',
				'std'        => '',
				'js_options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'hidden' => array( $prefix . 'enable_topbar_color', '!=', '1' )
			),
		)
	);

	// PAGE HEADER
	//--------------------------------------------------
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_header_meta_box',
		'title'      => esc_html__( 'Page Header', 'yolo-bestruct' ),
		'post_types' => array('page'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name' => esc_html__( 'Header On/Off?', 'yolo-bestruct' ),
				'id'   => $prefix . 'header_show_hide',
				'type' => 'checkbox_advanced',
				'desc' => esc_html__( "Switch header ON or OFF?", 'yolo-bestruct' ),
				'std'  => '1',
			),

			// Header Customize On/Off?
			array(
				'name' => esc_html__( 'Header Customize On/Off?', 'yolo-bestruct' ),
				'id'   => $prefix . 'header_set_page',
				'type' => 'checkbox_advanced',
				'desc' => esc_html__( "Switch header customize ON or OFF?", 'yolo-bestruct' ),
				'std'  => '0',
			),
			// Start Header Customize childs
			array(
				'name'       => esc_html__( 'Header Layout', 'yolo-bestruct' ),
				'id'         => $prefix . 'header_layout',
				'type'       => 'image_set',
				'allowClear' => true,
				'std'        => '',
				'options'    => array(
					'header-1'       => get_template_directory_uri().'/assets/images/theme-options/header_1.jpg',
					'header-2'       => get_template_directory_uri().'/assets/images/theme-options/header_2.jpg',
					'header-3'       => get_template_directory_uri().'/assets/images/theme-options/header_3.jpg',
					'header-4'       => get_template_directory_uri().'/assets/images/theme-options/header_4.jpg',
					'header-5'       => get_template_directory_uri().'/assets/images/theme-options/header_5.jpg',
					'header-6'       => get_template_directory_uri().'/assets/images/theme-options/header_6.jpg',
					'header-sidebar' => get_template_directory_uri().'/assets/images/theme-options/header_sidebar.jpg',
				),
				'hidden' => array( $prefix . 'header_set_page', '!=', '1' )
			),
		)
	);

	// LOGO
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_logo_meta_box',
		'title'      => esc_html__( 'Logo', 'yolo-bestruct' ),
		'post_types' => array('page'),
		'tab'        => true,
		'fields'     => array(
			array(
				'id'               => $prefix.  'custom_logo',
				'name'             => esc_html__( 'Custom Logo', 'yolo-bestruct' ),
				'desc'             => esc_html__( 'Upload custom logo in header.', 'yolo-bestruct' ),
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
			array(
				'id'               => $prefix . 'sticky_logo',
				'name'             => esc_html__( 'Sticky Logo', 'yolo-bestruct' ),
				'desc'             => esc_html__( 'Upload sticky logo in header (empty to default)', 'yolo-bestruct' ),
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
			array(
				'name' => esc_html__( 'Customize Logo Position', 'yolo-bestruct' ),
				'id'   => $prefix . 'enable_logo_position',
				'type' => 'checkbox_advanced',
				'std'  => 0
			),
			array(
				'id'    => $prefix.  'logo_padding_top',
				'name'  => esc_html__( 'Logo padding top', 'yolo-bestruct' ),
				'desc'  => esc_html__( 'Logo padding top. Insert number only (empty to set default value). Eg: 30', 'yolo-bestruct' ),
				'type'  => 'text',
				'sdt'   => '',
				'visible' => array( $prefix . 'enable_logo_position', '!=', '0' )
			),

			array(
				'id'    => $prefix.  'logo_padding_bottom',
				'name'  => esc_html__( 'Logo padding bottom', 'yolo-bestruct' ),
				'desc'  => esc_html__( 'Logo padding bottom. Insert number only (empty to set default value). Eg: 30', 'yolo-bestruct' ),
				'type'  => 'text',
				'sdt'   => '',
				'visible' => array( $prefix . 'enable_logo_position', '!=', '0' )
			),
			array(
				'id'    => $prefix.  'logo_padding_right',
				'name'  => esc_html__( 'Logo padding right', 'yolo-bestruct' ),
				'desc'  => esc_html__( 'Logo padding right. Insert number only (empty to set default value). Eg: 30', 'yolo-bestruct' ),
				'type'  => 'text',
				'sdt'   => '',
				'visible' => array( $prefix . 'enable_logo_position', '!=', '0' )
			),
			array(
				'id'    => $prefix.  'logo_padding_left',
				'name'  => esc_html__( 'Logo padding left', 'yolo-bestruct' ),
				'desc'  => esc_html__( 'Logo padding left. Insert number only (empty to set default value). Eg: 30', 'yolo-bestruct' ),
				'type'  => 'text',
				'sdt'   => '',
				'visible' => array( $prefix . 'enable_logo_position', '!=', '0' )
			),
		)
	);

	// MENU
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_menu_meta_box',
		'title'      => esc_html__( 'Menu', 'yolo-bestruct' ),
		'post_types' => array('page'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name'        => esc_html__( 'Page menu', 'yolo-bestruct' ),
				'id'          => $prefix . 'page_menu',
				'type'        => 'select',
				'options'     => $menu_list,
				'placeholder' => esc_html__( 'Select Menu','yolo-bestruct' ),
				'std'         => '',
				'multiple'    => false,
				'desc'        => esc_html__( 'Optionally you can choose to override the menu that is used on the page', 'yolo-bestruct' ),
			),

			array(
				'name'        => esc_html__( 'Page menu mobile', 'yolo-bestruct' ),
				'id'          => $prefix . 'page_menu_mobile',
				'type'        => 'select',
				'options'     => $menu_list,
				'placeholder' => esc_html__( 'Select Menu', 'yolo-bestruct' ),
				'std'         => '',
				'multiple'    => false,
				'desc'        => esc_html__( 'Optionally you can choose to override the menu mobile that is used on the page', 'yolo-bestruct' ),
			),

		)
	);

	// PAGE TITLE
	//--------------------------------------------------
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_title_meta_box',
		'title'      => esc_html__( 'Page Title', 'yolo-bestruct' ),
		'post_types' => array('post', 'page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Show/Hide Page Title?', 'yolo-bestruct' ),
				'id'      => $prefix . 'show_page_title',
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1' => esc_html__( 'Default', 'yolo-bestruct' ),
					'1'  => esc_html__( 'Show', 'yolo-bestruct' ),
					'0'  => esc_html__( 'Hide', 'yolo-bestruct' ),
				)

			),
			array(
				'name'           => esc_html__( 'Custom Page Subtitle', 'yolo-bestruct' ),
				'id'             => $prefix . 'page_subtitle_custom',
				'desc'           => esc_html__( "Enter a custom page title if you'd like.", 'yolo-bestruct' ),
				'type'           => 'text',
				'std'            => '',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),
			array(
				'name' 	=> esc_html__('Page Title Scheme', 'yolo-bestruct'),
				'id' 	=> $prefix . 'page-title-scheme-section',
				'type' 	=> 'section',
				'hidden' => array( $prefix . 'show_page_title', '!=', '1' )
			),
			array(
				'name'           => esc_html__( 'Custom Background Image?', 'yolo-bestruct' ),
				'id'             => $prefix . 'enable_custom_page_title_bg_image',
				'type'           => 'checkbox_advanced',
				'std'            => 0,
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),			

			// BACKGROUND IMAGE
			array(
				'id'               => $prefix.  'page_title_bg_image',
				'name'             => esc_html__( 'Background Image', 'yolo-bestruct' ),
				'desc'             => esc_html__( 'Background Image for page title.', 'yolo-bestruct' ),
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'hidden' => array($prefix . 'enable_custom_page_title_bg_image','!=','1'),
			),
			array(
				'name' 	=> esc_html__('Page Title Style', 'yolo-bestruct'),
				'id' 	=> $prefix . 'page-title-style-section',
				'type' 	=> 'section',
				'hidden' => array( $prefix . 'show_page_title', '!=', '1' )
			),
			array(
				'name'    => esc_html__( 'Page Title Parallax', 'yolo-bestruct' ),
				'id'      => $prefix . 'page_title_parallax',
				'desc'    => esc_html__( "Enable Page Title Parallax", 'yolo-bestruct' ),
				'type'    => 'button_set',
				'options' => array(
					'-1' => esc_html__( 'Default', 'yolo-bestruct' ),
					'1'  => esc_html__( 'Enable','yolo-bestruct' ),
					'0'  => esc_html__( 'Disable','yolo-bestruct' ),
				),
				'std'            => '-1',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),
			

			// PAGE TITLE Height
			array(
				'name'           => esc_html__( 'Page Title Height', 'yolo-bestruct' ),
				'id'             => $prefix . 'page_title_height',
				'desc'           => esc_html__( "Enter a page title height value. Eg: 400px.", 'yolo-bestruct' ),
				'type'           => 'textfield',
				'std'            => '',
				'hidden' => array( $prefix . 'show_page_title', '=', '1' )
			),
			array(
				'name'  => esc_html__( 'Margin Top', 'yolo-bestruct' ),
				'id'    => $prefix . 'page_title_margin_top',
				'type'  => 'number',
				'desc'           => esc_html__( "Enter a margin top value (not include unit).", 'yolo-bestruct' ),
				'std'	=> '',
				'hidden' => array( $prefix . 'show_page_title', '=', '1' )
			),
            array(
                'name'  => esc_html__( 'Margin Bottom', 'yolo-bestruct' ),
                'id'    => $prefix . 'page_title_margin_bottom',
                'type'  => 'number',
                'desc'           => esc_html__( "Enter a margin bottom value (not include unit).", 'yolo-bestruct' ),
                'std'	=> '',
                'hidden' => array( $prefix . 'show_page_title', '=', '1' )
            ),
            // Breadcrumbs in Page Title
			array(
				'name'    => esc_html__( 'Breadcrumbs', 'yolo-bestruct' ),
				'id'      => $prefix . 'breadcrumbs_in_page_title',
				'desc'    => esc_html__( "Show/Hide Breadcrumbs", 'yolo-bestruct' ),
				'type'    => 'button_set',
				'options' => array(
					'-1' => esc_html__( 'Default','yolo-bestruct' ),
					'1'  => esc_html__( 'Show','yolo-bestruct' ),
					'0'  => esc_html__( 'Hide','yolo-bestruct' ),
				),
				'std' => '-1',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),
		)
	);

	// PAGE FOOTER
	//--------------------------------------------------
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_footer_meta_box',
		'title'      => esc_html__( 'Page Footer', 'yolo-bestruct' ),
		'post_types' => array('page'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name' => esc_html__( 'Select Footer', 'yolo-bestruct' ),
				'id'   => $prefix . 'footer',
				'type' => 'footer',
				'desc' => esc_html__( 'Select footer to override footer selected in Theme Options', 'yolo-bestruct' ),
			),
		)
	);
	
	return $meta_boxes;
}
// Hook to 'rwmb_meta_boxes' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
// add_action('admin_init', 'yolo_register_meta_boxes');
add_filter( 'rwmb_meta_boxes', 'yolo_register_meta_boxes' ); // From version 4.8.0