<?php

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux_Framework_options_config' ) ) {

    class Redux_Framework_options_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if ( ! class_exists( 'ReduxFramework' ) ) {
                return;
            }

            $this->initSettings();
        }

        public function initSettings() {
            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }

        /**
         * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments( $args ) {
            $args['dev_mode'] = false;

            return $args;
        }

        /**
         * Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            $page_title_bg_url             = get_template_directory_uri() . '/assets/images/bg-page-title.jpg';
            $page_404_bg_url               = get_template_directory_uri() . '/assets/images/404-bg.jpg';

            // General Setting
            $this->sections[] = array(
                'title'  => esc_html__( 'General Setting', 'yolo-bestruct' ),
                'desc'      => esc_html__('Welcome to Bestruct theme options panel! Have fun customize the theme!', 'yolo-bestruct'),
                'icon'   => 'el el-wrench',
                'fields' => array(
                    array(
                        'id'       => 'home_preloader',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Page Preloader', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Select Page Preloader. Leave empty if you don\'t want to use.', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'square-1'   => 'Square 01',
                            'square-2'   => 'Square 02',
                            'square-3'   => 'Square 03',
                            'square-4'   => 'Square 04',
                            'square-5'   => 'Square 05',
                            'square-6'   => 'Square 06',
                            'square-7'   => 'Square 07',
                            'square-8'   => 'Square 08',
                            'square-9'   => 'Square 09',
                            'round-1'    => 'Round 01',
                            'round-2'    => 'Round 02',
                            'round-3'    => 'Round 03',
                            'round-4'    => 'Round 04',
                            'round-5'    => 'Round 05',
                            'round-6'    => 'Round 06',
                            'round-7'    => 'Round 07',
                            'round-8'    => 'Round 08',
                            'round-9'    => 'Round 09',
                        ),
                        'default' => ''
                    ),


                    array(
                        'id'       => 'home_preloader_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Preloader background color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set Preloader background color.', 'yolo-bestruct' ),
                        'default'  => '#000',
                        'required' => array('home_preloader', 'not_empty_and', array('none')),
                    ),

                    array(
                        'id'       => 'home_preloader_spinner_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Preloader spinner color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Pick a preloader spinner color for the Top Bar', 'yolo-bestruct' ),
                        'default'  => '#e8e8e8',
                        'required' => array( 'home_preloader', 'not_empty_and', array('none') ),
                    ),

                    array(
                        'id'       => 'back_to_top',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Back To Top', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Back to top button', 'yolo-bestruct' ),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'layout_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Layout Style', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Select the layout style', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'boxed' => array('title' => 'Boxed', 'img' => get_template_directory_uri().'/assets/images/theme-options/layout-boxed.png'),
                            'wide'  => array('title' => 'Wide', 'img' => get_template_directory_uri().'/assets/images/theme-options/layout-wide.png'),
                            'float' => array('title' => 'Float', 'img' => get_template_directory_uri().'/assets/images/theme-options/layout-float.png')
                        ),
                        'default'  => 'wide'
                    ),

                    array(
                        'id'       => 'layout_site_width',
                        'type'     => 'slider',
                        'title'    => esc_html__( 'Site Width (%)', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set the site width of body', 'yolo-bestruct' ),
                        'default'  => '90',
                        "min"      => 60,
                        "step"     => 1,
                        "max"      => 100,
                        'required' => array('layout_style','=','boxed'),
                    ),
                    array(
                        'id'       => 'layout_site_max_width',
                        'type'     => 'slider',
                        'title'    => esc_html__( 'Site Max Width (px)', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set the site max width of body', 'yolo-bestruct' ),
                        'default'  => '1200',
                        "min"      => 980,
                        "step"     => 10,
                        "max"      => 1600,
                        'required' => array('layout_style','=','boxed'),
                    ),

                    array(
                        'id'       => 'body_background_mode',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Body Background Mode', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Chose Background Mode', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'background' => 'Background',
                            'pattern'    => 'Pattern'
                        ),
                        'default'  => 'background',
                        'required' => array('layout_style','=','boxed'),
                    ),

                    array(
                        'id'       => 'body_background',
                        'type'     => 'background',
                        'output'   => array( 'body' ),
                        'title'    => esc_html__( 'Body Background', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Body background (Apply for Boxed layout style).', 'yolo-bestruct' ),
                        'default'  => array(
                            'background-color'      => '',
                            'background-repeat'     => 'no-repeat',
                            'background-position'   => 'center center',
                            'background-attachment' => 'fixed',
                            'background-size'       => 'cover'
                        ),
                        'required'  => array(
                            array('body_background_mode', '=', array('background'))
                        ),
                    ),
                    array(
                        'id'       => 'body_background_pattern',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Background Pattern', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Body background pattern(Apply for Boxed layout style)', 'yolo-bestruct' ),
                        'desc'     => '',
                        'height'   => '40px',
                        'options'  => array(
                            'pattern-1.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-1.png'),
                            'pattern-2.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-2.png'),
                            'pattern-3.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-3.png'),
                            'pattern-4.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-4.png'),
                            'pattern-5.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-5.png'),
                            'pattern-6.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-6.png'),
                            'pattern-7.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-7.png'),
                            'pattern-8.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-8.png'),
                            'pattern-9.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-9.png'),
                            'pattern-10.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-10.png'),
                        ),
                        'default'  => 'pattern-1.png',
                        'required' => array(
                            array('body_background_mode', '=', array('pattern'))
                        ) ,
                    ),
                    array(
                        'id'       => 'google_api_key',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Google API Key', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set google API Key for Map', 'yolo-bestruct' ),
                        'desc'     => '',
                    ),
                )
            );
    
            // Coming soon
            $this->sections[] = array(
                'title'      => esc_html__( 'Coming Soon', 'yolo-bestruct' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-time',
                'fields'     => array(
                    array(
                        'id'       => 'enable_maintenance',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Coming Soon / Maintenance Mode', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable your site coming soon / maintenance mode.', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            '2' => 'On (Custom Page)',
                            '1' => 'On (Standard)',
                            '0' => 'Off',
                        ),
                        'default'  => '0'
                    ),
                    array(
                        'id'       => 'maintenance_mode_page',
                        'type'     => 'select',
                        'data'     => 'pages',
                        'required' => array('enable_maintenance', '=', '2'),
                        'title'    => esc_html__('Custom Maintenance Mode Page', 'yolo-bestruct'),
                        'subtitle' => esc_html__('If you would like to show a custom page instead of the standard Maintenance page, select the page that is your maintenace page, .', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'args'     => array()
                    ),
                    array(
                        'id'          => 'maintenance_title',
                        'type'        => 'text',
                        'placeholder' => 'Coming Soon',
                        'required'    => array('enable_maintenance', '=', '1'),
                        'title'       => esc_html__('Maintenance title', 'yolo-bestruct'),
                        'subtitle'    => esc_html__('Insert coming soon title.', 'yolo-bestruct'),
                        'default'     => 'Coming Soon',
                    ),
                    array(
                        'id'       => 'maintenance_background',
                        'type'     => 'media',
                        'url'      => true,
                        'required' => array('enable_maintenance', '=', '1'),
                        'title'    => esc_html__('Maintenance Background', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select maintenance background image.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'args'     => array()
                    ),
                    array(
                        'id'          => 'online_time',
                        'type'        => 'datetime',
                        'placeholder' => 'Y/m/d H:i:s',
                        'required'    => array('enable_maintenance', '=', '1'),
                        'title'       => esc_html__( 'Online time', 'yolo-bestruct' ),
                        'subtitle'    => esc_html__( 'Your page will automatic end maintenance mode after this time.', 'yolo-bestruct' ),
                    ),
                    array(
                        'id'          => 'timezone',
                        'type'        => 'text',
                        'placeholder' => 'Asia/Ho_Chi_Minh',
                        'required'    => array('enable_maintenance', '=', '1'),
                        'title'       => esc_html__('Timezone', 'yolo-bestruct'),
                        'subtitle'    => esc_html__('You can change timezone from here. More details: http://php.net/manual/en/timezones.php', 'yolo-bestruct'),
                        'default'     => 'Asia/Ho_Chi_Minh',
                    ),
                    array(
                        'id'       => 'maintenance_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'required' => array('enable_maintenance', '=', '1'),
                        'width'    => '100%',
                        'title'    => esc_html__('Maintenance social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for maintenance page.', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => ''
                    ),
                )
            );
            // 404 Page error
            $this->sections[] = array(
                'title'      => esc_html__( '404 Setting', 'yolo-bestruct' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-remove-circle',
                'fields'     => array(
                    array(
                        'id'        => 'page_title_404',
                        'type'      => 'text',
                        'title'     => esc_html__('Page Title 404', 'yolo-bestruct'),
                        'default'   => esc_html__('Sorry, this page does not exist!', 'yolo-bestruct'),
                    ),
                    array(
                        'id'        => 'sub_page_title_404',
                        'type'      => 'text',
                        'title'     => esc_html__( 'SubPage Title 404', 'yolo-bestruct' ),
                        'default'   => esc_html__( 'The link might be corrupted, or the page may have been removed.', 'yolo-bestruct' ),
                    ),
                    array(
                        'id'       => 'page_404_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Background 404 page', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Upload your background image here.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url'  => $page_404_bg_url
                        )
                    ),
                    array(
                        'id'        => 'title_404',
                        'type'      => 'text',
                        'title'     => esc_html__('Title 404', 'yolo-bestruct'),
                        'default'   => esc_html__('404', 'yolo-bestruct'),
                    ),
                    array(
                        'id'        => 'go_back_404',
                        'type'      => 'text',
                        'title'     => esc_html__('Go back label', 'yolo-bestruct'),
                        'default'   => esc_html__('Home page', 'yolo-bestruct'),
                    ),
                    array(
                        'id'        => 'go_back_url_404',
                        'type'      => 'text',
                        'title'     => esc_html__('Go back link', 'yolo-bestruct'),
                        'default'   => '',
                    )
                )
            );            
            // Logo
            $this->sections[] = array(
                'title'  => esc_html__( 'Logo & Favicon', 'yolo-bestruct' ),
                'desc'   => '',
                'icon'   => 'el el-picture',
                'fields' => array(
                    array(
						'id'       => 'logo',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__('Logo', 'yolo-bestruct'),
						'subtitle' => esc_html__('Upload your logo here.', 'yolo-bestruct'),
						'desc'     => '',
						'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/logo.png'
                        )
                    ),

                    array(
                        'id'       => 'logo_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Retina Logo', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Upload your retina logo here.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/logo_retina.png'
                        )
                    ),
	                array(
						'id'             => 'logo_padding',
						'type'           => 'spacing',
						'mode'           => 'padding',
						'units'          => 'px',
						'units_extended' => 'false',
						'title'          => esc_html__('Logo Padding', 'yolo-bestruct'),
						'subtitle'       => esc_html__('This must be numeric (no px). Leave blank for default.', 'yolo-bestruct'),
						'desc'           => esc_html__('If you would like to override the default logo padding, then you can do so here.', 'yolo-bestruct'),
						'default'        => array(
							'padding-top'    => '0px',
							'padding-bottom' => '0px',
                            'padding-left'   => '',
                            'padding-right'  => '',
							'units'          => 'px',
		                )
	                ),
	                array(
                            'id'       => 'sticky_logo',
                            'type'     => 'media',
                            'url'      => true,
                            'title'    => esc_html__('Sticky Logo', 'yolo-bestruct'),
                            'subtitle' => esc_html__('Upload a sticky version of your logo here', 'yolo-bestruct'),
                            'desc'     => '',
                            'default'  => array(
                            'url'      => get_template_directory_uri() . '/assets/images/logo.png'
                        )
                    ),

                    array(
							'id'       => 'sticky_retina_logo',
							'type'     => 'media',
							'url'      => true,
							'title'    => esc_html__('Sticky Retina Logo', 'yolo-bestruct'),
							'subtitle' => esc_html__('Upload a sticky version of your retina logo here', 'yolo-bestruct'),
							'desc'     => '',
							'default'  => array(
							'url'      => get_template_directory_uri() . '/assets/images/logo_retina.png'
		                )
	                ),

                    array(
						'id'       => 'custom_favicon',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__('Custom favicon', 'yolo-bestruct'),
						'subtitle' => esc_html__('Upload a 16px x 16px Png/Gif/ico image that will represent your website favicon', 'yolo-bestruct'),
						'desc'     => ''
                    ),
                )
            );

            // Header
            $this->sections[] = array(
                'title'  => esc_html__( 'Header', 'yolo-bestruct' ),
                'desc'   => '',
                'icon'   => 'el el-credit-card',
                'fields' => array(

                    array(
                        'id'       => 'header_layout',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Header Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select a header layout option from the examples.', 'yolo-bestruct'),
                        'desc'     => '',
                        'class'    => 'header_layout',
                        'options'  => array(
                            'header-1'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_1.jpg'),
                            'header-2'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_2.jpg'),
                            'header-3'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_3.jpg'),
                            'header-4'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_4.jpg'),
                            'header-5'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_5.jpg'),
                            'header-6'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_6.jpg'),
                            'header-sidebar' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_sidebar.jpg'),
                        ),
                        'default' => 'header-5'
                    ),

                    array(
                        'id'     => 'section-header-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Navigation', 'yolo-bestruct'),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'menu_animation',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sub Menu Animation', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Select animation for mega menu', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'fadeIn'            => 'fadeIn',
                            'fadeInUp'          => 'fadeInUp',
                            'bounceIn'          => 'bounceIn',
                            'flipInX'           => 'flipInX',
                            'bounceInRight'     => 'bounceInRight',
                            'fadeInRight'       => 'fadeInRight',
                        ),
                        'default' => 'fadeInUp'
                    ),
                    array(
                        'id'       => 'menu_sub_scheme',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Sub menu scheme', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set sub menu scheme', 'yolo-bestruct' ),
                        'default'  => 'default',
                        'options'  => array(
                            'default'   => esc_html__('Default','yolo-bestruct'),
                            'customize' => esc_html__('Customize','yolo-bestruct')
                        )
                    ),

                    array(
                        'id'       => 'menu_sub_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Sub Menu Background Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sub Menu Background Color.', 'yolo-bestruct'),
                        'default'  => '#ddd',
                        'required'  => array('menu_sub_scheme', '=', 'customize'),
                    ),

                    array(
                        'id'       => 'menu_sub_text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Sub Menu Text Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sub Menu Text Color.', 'yolo-bestruct'),
                        'default'  => '#0f0f0f',
                        'required'  => array('menu_sub_scheme', '=', 'customize'),
                    ),
                    // Header Sticky
                    array(
                        'id'     => 'section-header-sticky',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Sticky', 'yolo-bestruct'),
                        'indent' => true,
                    ), 
                    array(
                        'id'       => 'header_sticky',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show/Hide Header Sticky', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Show Hide header Sticky.', 'yolo-bestruct' ),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'header_sticky_effect',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Header Sticky Effect', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Choose header sticky effect.', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'slideDown,slideUp'         => esc_html__('Slide Up Down','yolo-bestruct'),
                            'bounceInDown,bounceOutUp'  => esc_html__('Bource','yolo-bestruct'),
                            'flipInX,flipOutX'          => esc_html__('Flip','yolo-bestruct'),
                            'swingInX,swingOutX'        => esc_html__('Swing','yolo-bestruct')
                        ),
                        'default'  => 'slideDown,slideUp',
                        'required'  => array('header_sticky','=','1')
                    ),

                    array(
                        'id'       => 'header_sticky_scheme',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Header sticky scheme', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Choose header sticky scheme', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'inherit' => esc_html__('Inherit','yolo-bestruct'),
                            'gray'    => esc_html__('Gray','yolo-bestruct'),
                            'light'   => esc_html__('Light','yolo-bestruct'),
                            'dark'    => esc_html__('Dark','yolo-bestruct')
                        ),
                        'default'  => 'dark'
                    ),              
                )
            );
            



            // Var Option
            // @ Social network
                $option_social = array(
                    'twitter'    => esc_html__('Twitter', 'yolo-bestruct'),
                    'facebook'   => esc_html__('Facebook', 'yolo-bestruct'),
                    'dribbble'   => esc_html__('Dribbble', 'yolo-bestruct'),
                    'vimeo'      => esc_html__('Vimeo', 'yolo-bestruct'),
                    'tumblr'     => esc_html__('Tumblr', 'yolo-bestruct'),
                    'skype'      => esc_html__('Skype', 'yolo-bestruct'),
                    'linkedin'   => esc_html__('LinkedIn', 'yolo-bestruct'),
                    'googleplus' => esc_html__('Google+', 'yolo-bestruct'),
                    'flickr'     => esc_html__('Flickr', 'yolo-bestruct'),
                    'youtube'    => esc_html__('YouTube', 'yolo-bestruct'),
                    'pinterest'  => esc_html__('Pinterest', 'yolo-bestruct'),
                    'foursquare' => esc_html__('Foursquare', 'yolo-bestruct'),
                    'instagram'  => esc_html__('Instagram', 'yolo-bestruct'),
                    'github'     => esc_html__('GitHub', 'yolo-bestruct'),
                    'xing'       => esc_html__('Xing', 'yolo-bestruct'),
                    'behance'    => esc_html__('Behance', 'yolo-bestruct'),
                    'deviantart' => esc_html__('Deviantart', 'yolo-bestruct'),
                    'soundcloud' => esc_html__('SoundCloud', 'yolo-bestruct'),
                    'yelp'       => esc_html__('Yelp', 'yolo-bestruct'),
                    'rss'        => esc_html__('RSS Feed', 'yolo-bestruct'),
                    'email'      => esc_html__('Email address', 'yolo-bestruct'),
                );
            // Header 1
            $this->sections[] = array(
                'title'      => esc_html__('Header 1 Options', 'yolo-bestruct'),
                'desc'       => '',
                'subsection' => true,
                'fields'     => array(
                    array( 
                        'id'       => 'header_1_image',
                        'type'     => 'raw',
                        'class'    => 'header_demo_image',
                        'content'  =>  '<img src='.get_template_directory_uri().'/assets/images/theme-options/header_1.jpg />',
                    ),
                    array(
                        'id'      => 'header_1_height',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header Height (px)', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set a height for the header. Empty value to default.', 'yolo-bestruct'),
                        'default' => 130,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 300,
                    ),
                    array(
                        'id'       => 'header_1_nav_layout_float',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Float', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Header Float.', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'      => 'header_1_nav_layout',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header navigation layout', 'yolo-bestruct'),
                        'options' => array(
                            'container'    => esc_html__('Container','yolo-bestruct'),
                            'nav-fullwith' => esc_html__('Full width','yolo-bestruct'),
                        ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'header_1_nav_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__('Header navigation padding left/right (px)', 'yolo-bestruct'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 200,
                        'required' => array('header_1_nav_layout','=','nav-fullwith'),
                    ),
                    array(
                        'id'     => 'section-header-1-navigation',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_1_nav_distance',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header navigation distance', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set distance between navigation items. Empty value to default', 'yolo-bestruct'),
                        'default' => 20,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 50,
                    ),
                    array(
                        'id'       => 'header_1_nav_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Header navigation background color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set header navigation background color', 'yolo-bestruct' ),
                        'default'  => '#171717'
                    ),
                    array(
                        'id'       => 'header_1_nav_text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Header navigation text color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set header navigation text color', 'yolo-bestruct'),
                        'default'  => '#ffffff'
                    ),
                    // Header Custom Right
                    array(
                        'id'     => 'section-header-1-customize-right',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Right', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_1_customize_right',
                        'type'    => 'sorter',
                        'title'   => 'Header customize right',
                        'desc'    => 'Organize how you want the layout to appear on the header right',
                        'options' => array(
                            'enabled'  => array(
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'custom-text'    => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                                'shopping-cart'  => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'wishlist'       => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'search-button'  => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'search-box'     => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'canvas-menu'    => esc_html__( 'Canvas Menu','yolo-bestruct' )
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_1_customize_right_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_1_customize_right_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '<i class="fa fa-phone"></i> + 46 234-623-213',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                    // Header Custom Nav
                    array(
                        'id'     => 'section-header-1-customize-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_1_customize_nav',
                        'type'    => 'sorter',
                        'title'   => 'Header customize navigation',
                        'desc'    => 'Organize how you want the layout to appear on the header navigation',
                        'options' => array(
                            'enabled'  => array(
                            ),
                            'disabled' => array(
                                'social-profile'       => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'custom-text'          => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_1_customize_nav_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_1_customize_nav_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),


                )
            );
            // Header 2
            $this->sections[] = array(
                'title'      => esc_html__('Header 2 Options', 'yolo-bestruct'),
                'desc'       => '',
                'subsection' => true,
                'fields'     => array(
                    array( 
                        'id'       => 'header_2_image',
                        'type'     => 'raw',
                        'class'    => 'header_demo_image',
                        'content'  =>  '<img src='.get_template_directory_uri().'/assets/images/theme-options/header_2.jpg />',
                    ),
                    array(
                        'id'      => 'header_2_height',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header Height (px)', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set a height for the header. Empty value to default.', 'yolo-bestruct'),
                        'default' => 120,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 300,
                    ),
                    array(
                        'id'       => 'header_2_nav_layout_float',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Float', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Header Float.', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'      => 'header_2_nav_layout',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header navigation layout', 'yolo-bestruct'),
                        'options' => array(
                            'container'    => esc_html__('Container','yolo-bestruct'),
                            'nav-fullwith' => esc_html__('Full width','yolo-bestruct'),
                        ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'header_2_nav_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__('Header navigation padding left/right (px)', 'yolo-bestruct'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 200,
                        'required' => array('header_2_nav_layout','=','nav-fullwith'),
                    ),
                    array(
                        'id'     => 'section-header-2-navigation',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_2_nav_distance',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header navigation distance', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set distance between navigation items. Empty value to default', 'yolo-bestruct'),
                        'default' => 20,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 50,
                    ),
                    array(
                        'id'       => 'header_2_nav_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Header navigation background color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set header navigation background color', 'yolo-bestruct' ),
                        'default'  => '#fafafa'
                    ),
                    array(
                        'id'       => 'header_2_nav_text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Header navigation text color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set header navigation text color', 'yolo-bestruct'),
                        'default'  => '#424242'
                    ),

                    // Header Custom Left
                    array(
                        'id'     => 'section-header-2-customize-left',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Left', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_2_customize_left',
                        'type'    => 'sorter',
                        'title'   => 'Header customize left',
                        'desc'    => 'Organize how you want the layout to appear on the header left',
                        'options' => array(
                            'enabled'  => array(
                                'social-profile'       => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'custom-text'          => esc_html__( 'Custom Text','yolo-bestruct' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_2_customize_left_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_2_customize_left_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                    // Header Custom Right
                    array(
                        'id'     => 'section-header-2-customize-right',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Right', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_2_customize_right',
                        'type'    => 'sorter',
                        'title'   => 'Header customize right',
                        'desc'    => 'Organize how you want the layout to appear on the header right',
                        'options' => array(
                            'enabled'  => array(
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'search-box'     => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'canvas-menu'    => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'custom-text'    => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_2_customize_right_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_2_customize_right_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                    // Header Custom Nav
                    array(
                        'id'     => 'section-header-2-customize-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_2_customize_nav',
                        'type'    => 'sorter',
                        'title'   => 'Header customize navigation',
                        'desc'    => 'Organize how you want the layout to appear on the header navigation',
                        'options' => array(
                            'enabled'  => array(
                            ),
                            'disabled' => array(
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'custom-text'          => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_2_customize_nav_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_2_customize_nav_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),


                )
            );
            // Header 3
            $this->sections[] = array(
                'title'      => esc_html__('Header 3 Options', 'yolo-bestruct'),
                'desc'       => '',
                'subsection' => true,
                'fields'     => array(
                    array( 
                        'id'       => 'header_3_image',
                        'type'     => 'raw',
                        'class'    => 'header_demo_image',
                        'content'  =>  '<img src='.get_template_directory_uri().'/assets/images/theme-options/header_3.jpg />',
                    ),
                    array(
                        'id'      => 'header_3_height',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header Height (px)', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set a height for the header. Empty value to default.', 'yolo-bestruct'),
                        'default' => 120,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 300,
                    ),
                    array(
                        'id'       => 'header_3_nav_layout_float',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Float', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Header Float.', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'      => 'header_3_nav_layout',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header navigation layout', 'yolo-bestruct'),
                        'options' => array(
                            'container'    => esc_html__('Container','yolo-bestruct'),
                            'nav-fullwith' => esc_html__('Full width','yolo-bestruct'),
                        ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'header_3_nav_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__('Header navigation padding left/right (px)', 'yolo-bestruct'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 200,
                        'required' => array('header_3_nav_layout','=','nav-fullwith'),
                    ),
                    array(
                        'id'     => 'section-header-3-navigation',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_3_nav_distance',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header navigation distance', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set distance between navigation items. Empty value to default', 'yolo-bestruct'),
                        'default' => 20,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 50,
                    ),
                    array(
                        'id'       => 'header_3_nav_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Header navigation background color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set header navigation background color', 'yolo-bestruct' ),
                        'default'  => '#ffffff'
                    ),
                    array(
                        'id'       => 'header_3_nav_text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Header navigation text color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set header navigation text color', 'yolo-bestruct'),
                        'default'  => '#424242'
                    ),

                    // Header Custom Nav
                    array(
                        'id'     => 'section-header-3-customize-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_3_customize_nav',
                        'type'    => 'sorter',
                        'title'   => 'Header customize navigation',
                        'desc'    => 'Organize how you want the layout to appear on the header navigation',
                        'options' => array(
                            'enabled'  => array(
                            ),
                            'disabled' => array(
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'custom-text'          => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_3_customize_nav_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_3_customize_nav_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                    // Header Custom Right
                    array(
                        'id'     => 'section-header-3-customize-right',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Right', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_3_customize_right',
                        'type'    => 'sorter',
                        'title'   => 'Header customize right',
                        'desc'    => 'Organize how you want the layout to appear on the header right',
                        'options' => array(
                            'enabled'  => array(
                                'custom-text'    => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'search-box'     => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'canvas-menu'    => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_3_customize_right_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_3_customize_right_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '<i class="fa fa-phone"></i> + 46 234-623-213',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),

                    // Header Custom Left
                    array(
                        'id'     => 'section-header-3-customize-left',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Left', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_3_customize_left',
                        'type'    => 'sorter',
                        'title'   => 'Header customize left',
                        'desc'    => 'Organize how you want the layout to appear on the header left',
                        'options' => array(
                            'enabled'  => array(
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'social-profile'       => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'custom-text'          => esc_html__( 'Custom Text','yolo-bestruct' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_3_customize_left_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_3_customize_left_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),

                )
            );
            // Header 4
            $this->sections[] = array(
                'title'      => esc_html__('Header 4 Options', 'yolo-bestruct'),
                'desc'       => '',
                'subsection' => true,
                'fields'     => array(
                    array( 
                        'id'       => 'header_4_image',
                        'type'     => 'raw',
                        'class'    => 'header_demo_image',
                        'content'  =>  '<img src='.get_template_directory_uri().'/assets/images/theme-options/header_4.jpg />',
                    ),
                    array(
                        'id'      => 'header_4_height',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header Height (px)', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set a height for the header. Empty value to default.', 'yolo-bestruct'),
                        'default' => 130,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 300,
                    ),
                    array(
                        'id'       => 'header_4_nav_layout_float',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Float', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Header Float.', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'      => 'header_4_nav_layout',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header navigation layout', 'yolo-bestruct'),
                        'options' => array(
                            'container'    => esc_html__('Container','yolo-bestruct'),
                            'nav-fullwith' => esc_html__('Full width','yolo-bestruct'),
                        ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'header_4_nav_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__('Header navigation padding left/right (px)', 'yolo-bestruct'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 200,
                        'required' => array('header_4_nav_layout','=','nav-fullwith'),
                    ),
                    array(
                        'id'     => 'section-header-4-navigation',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_4_nav_distance',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header navigation distance', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set distance between navigation items. Empty value to default', 'yolo-bestruct'),
                        'default' => 20,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 50,
                    ),
                    array(
                        'id'       => 'header_4_nav_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Header navigation background color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set header navigation background color', 'yolo-bestruct' ),
                        'default'  => '#333333'
                    ),
                    array(
                        'id'       => 'header_4_nav_text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Header navigation text color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set header navigation text color', 'yolo-bestruct'),
                        'default'  => '#f2f2f2'
                    ),
                    // Header Custom Right
                    array(
                        'id'     => 'section-header-4-customize-right',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Right', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_4_customize_right',
                        'type'    => 'sorter',
                        'title'   => 'Header customize right',
                        'desc'    => 'Organize how you want the layout to appear on the header right',
                        'options' => array(
                            'enabled'  => array(
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'search-box'     => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'canvas-menu'    => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                                'custom-text'    => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_4_customize_right_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_4_customize_right_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                    // Header Custom Nav
                    array(
                        'id'     => 'section-header-4-customize-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_4_customize_nav',
                        'type'    => 'sorter',
                        'title'   => 'Header customize navigation',
                        'desc'    => 'Organize how you want the layout to appear on the header navigation',
                        'options' => array(
                            'enabled'  => array(
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'custom-text'          => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_4_customize_nav_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_4_customize_nav_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                )
            );
            // Header 5
            $this->sections[] = array(
                'title'      => esc_html__('Header 5 Options', 'yolo-bestruct'),
                'desc'       => '',
                'subsection' => true,
                'fields'     => array(
                    array( 
                        'id'       => 'header_5_image',
                        'type'     => 'raw',
                        'class'    => 'header_demo_image',
                        'content'  =>  '<img src='.get_template_directory_uri().'/assets/images/theme-options/header_5.jpg />',
                    ),
                    array(
                        'id'      => 'header_5_height',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header Height (px)', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set a height for the header. Empty value to default.', 'yolo-bestruct'),
                        'default' => 120,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 300,
                    ),
                    array(
                        'id'       => 'header_5_nav_layout_float',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Float', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Header Float.', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'      => 'header_5_nav_layout',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header navigation layout', 'yolo-bestruct'),
                        'options' => array(
                            'container'    => esc_html__('Container','yolo-bestruct'),
                            'nav-fullwith' => esc_html__('Full width','yolo-bestruct'),
                        ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'header_5_nav_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__('Header navigation padding left/right (px)', 'yolo-bestruct'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 200,
                        'required' => array('header_5_nav_layout','=','nav-fullwith'),
                    ),
                    array(
                        'id'     => 'section-header-5-navigation',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_5_nav_distance',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header navigation distance', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set distance between navigation items. Empty value to default', 'yolo-bestruct'),
                        'default' => 20,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 50,
                    ),
                    array(
                        'id'       => 'header_5_nav_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Header navigation background color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set header navigation background color', 'yolo-bestruct' ),
                        'default'  => '#111'
                    ),
                    array(
                        'id'       => 'header_5_nav_text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Header navigation text color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set header navigation text color', 'yolo-bestruct'),
                        'default'  => '#fff'
                    ),
                    // Header Custom Right
                    array(
                        'id'     => 'section-header-5-customize-right',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Right', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_5_customize_right',
                        'type'    => 'sorter',
                        'title'   => 'Header customize right',
                        'desc'    => 'Organize how you want the layout to appear on the header right',
                        'options' => array(
                            'enabled'  => array(
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'search-box'     => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'canvas-menu'    => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                                'custom-text'    => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_5_customize_right_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_5_customize_right_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '<ul class="contact-info"><li><div class="icon"><i class="fa fa-map-marker"></i></div> <div class="content-step"><div class="text">30 Mario street,<br> California, USA. </div></div></li><li><div class="icon"><i class="fa fa-phone"></i></div> <div class="content-step"><div class="title">Phone us</div><div class="text">(+12) 123 456 789</div></div></li><li><div class="icon"><i class="fa fa-envelope"></i></div> <div class="content-step"><div class="title">E-mail us</div><div class="text">YoloTheme@gmail.com</div></div></li><li><a class="btn-book" href="#">Book a Service</a></li></ul>',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                    // Header Custom Nav
                    array(
                        'id'     => 'section-header-5-customize-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_5_customize_nav',
                        'type'    => 'sorter',
                        'title'   => 'Header customize navigation',
                        'desc'    => 'Organize how you want the layout to appear on the header navigation',
                        'options' => array(
                            'enabled'  => array(
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'custom-text'          => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_5_customize_nav_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_5_customize_nav_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),

                )
            );
            // Header 6
            $this->sections[] = array(
                'title'      => esc_html__('Header 6 Options', 'yolo-bestruct'),
                'desc'       => '',
                'subsection' => true,
                'fields'     => array(
                    array( 
                        'id'       => 'header_6_image',
                        'type'     => 'raw',
                        'class'    => 'header_demo_image',
                        'content'  =>  '<img src='.get_template_directory_uri().'/assets/images/theme-options/header_6.jpg />',
                    ),
                    array(
                        'id'      => 'header_6_height',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header Height (px)', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set a height for the header. Empty value to default.', 'yolo-bestruct'),
                        'default' => 120,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 300,
                    ),
                    array(
                        'id'       => 'header_6_nav_layout_float',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Float', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Header Float.', 'yolo-bestruct' ),
                        'default'  => true
                    ),
                    array(
                        'id'      => 'header_6_nav_layout',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header navigation layout', 'yolo-bestruct'),
                        'options' => array(
                            'container'    => esc_html__('Container','yolo-bestruct'),
                            'nav-fullwith' => esc_html__('Full width','yolo-bestruct'),
                        ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'header_6_nav_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__('Header navigation padding left/right (px)', 'yolo-bestruct'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 200,
                        'required' => array('header_6_nav_layout','=','nav-fullwith'),
                    ),
                    array(
                        'id'     => 'section-header-6-navigation',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_6_nav_distance',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header navigation distance', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set distance between navigation items. Empty value to default', 'yolo-bestruct'),
                        'default' => 15,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 50,
                    ),
                    array(
                        'id'       => 'header_6_nav_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Header navigation background color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set header navigation background color', 'yolo-bestruct' ),
                        'default'  => '#3333333'
                    ),
                    array(
                        'id'       => 'header_6_nav_text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Header navigation text color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set header navigation text color', 'yolo-bestruct'),
                        'default'  => '#ffffff'
                    ),
                    // Header Custom Nav
                    array(
                        'id'     => 'section-header-6-customize-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'header_6_customize_nav',
                        'type'    => 'sorter',
                        'title'   => 'Header customize navigation',
                        'desc'    => 'Organize how you want the layout to appear on the header navigation',
                        'options' => array(
                            'enabled'  => array(
                                'search-button'        => esc_html__( 'Search Button', 'yolo-bestruct' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-bestruct' ),
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                            ),
                            'disabled' => array(
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-bestruct' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-bestruct' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-bestruct' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-bestruct' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-bestruct' ),
                                'custom-text'          => esc_html__( 'Custom Text', 'yolo-bestruct' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_6_customize_nav_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','twitter','googleplus','linkedin')
                    ),
                    array(
                        'id'       => 'header_6_customize_nav_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),

                )
            );
            // Header Sidebar Options
            $this->sections[] = array(
                'title'      => esc_html__('Header Sidebar', 'yolo-bestruct'),
                'desc'       => '',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'      => 'headersidebar_sidebar_width',
                        'type'    => 'slider',
                        'title'   => esc_html__('Header Sidebar Width (px)', 'yolo-bestruct'),
                        'desc'    => esc_html__('You can set a width for this header sidebar', 'yolo-bestruct'),
                        'default' => 300,
                        'min'     => 250,
                        'step'    => 1,
                        'max'     => 450,
                    ),

                    array(
                        'id'     => 'section-header-siderbar-navigation',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),

                    array(
                        'id'       => 'headersidebar_nav_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Navigation background color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set header navigation background color', 'yolo-bestruct'),
                        'default'  => '#ffffff'
                    ),

                    array(
                        'id'       => 'headersidebar_nav_text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Navigation text color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set header navigation text color', 'yolo-bestruct'),
                        'default'  => '#424242',
                    ),

                    array(
                        'id'     => 'section-header-sidebar-customize-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Navigation', 'yolo-bestruct'),
                        'indent' => true,
                    ),

                    array(
                        'id'      => 'headersidebar_customize_nav',
                        'type'    => 'sorter',
                        'title'   => 'Header customize navigation',
                        'desc'    => 'Organize how you want the layout to appear on the header navigation',
                        'options' => array(
                            'enabled'  => array(
                            ),
                            'disabled' => array(
                                'social-profile'       => esc_html__('Social Profile', 'yolo-bestruct'),
                                'shopping-cart'        => esc_html__('Shopping Cart', 'yolo-bestruct'),
                                'shopping-cart-price'  => esc_html__('Shopping Cart With Price', 'yolo-bestruct'),
                                'wishlist'             => esc_html__('Wishlist', 'yolo-bestruct'),
                                'search-button'        => esc_html__('Search Button', 'yolo-bestruct'),
                                'search-box'           => esc_html__('Search Box', 'yolo-bestruct'),
                                'custom-text'          => esc_html__('Custom Text', 'yolo-bestruct'),
                            ),
                        ),
                    ),
                    array(
                        'id'       => 'headersidebar_customize_nav_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social for social profile.', 'yolo-bestruct'),
                        'options'  => $option_social,
                        'desc'     => '',
                        'default'  => array('facebook', 'twitter', 'googleplus', 'linkedin'),
                    ),
                    array(
                        'id'       => 'headersidebar_customize_nav_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'chrome',
                        'title'    => esc_html__('Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add content for custom text.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines' => 5, 'maxLines' => 60),
                    ),
                    array(
                        'id'     => 'section-header-sidebar-customize-right',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize After Logo', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'headersidebar_customize_right',
                        'type'    => 'sorter',
                        'title'   => 'Header customize bottom',
                        'desc'    => 'Organize how you want the layout to appear on the header right',
                        'options' => array(
                            'enabled'  => array(
                                
                            ),
                                'disabled' => array(
                                'shopping-cart' => esc_html__('Shopping Cart', 'yolo-bestruct'),
                                'shopping-cart-price'  => esc_html__('Shopping Cart With Price', 'yolo-bestruct'),
                                'wishlist'             => esc_html__('Wishlist', 'yolo-bestruct'),
                                'search-button'        => esc_html__('Search Button', 'yolo-bestruct'),
                                'search-box'           => esc_html__('Search Box', 'yolo-bestruct'),
                                'social-profile'       => esc_html__('Social Profile', 'yolo-bestruct'),
                                'custom-text'          => esc_html__('Custom Text', 'yolo-bestruct'),
                            ),
                        ),
                    ),
                    array(
                        'id'       => 'headersidebar_customize_right_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social for social profile.', 'yolo-bestruct'),
                        'options'  => $option_social,
                        'desc'     => '',
                        'default'  => array('facebook', 'twitter', 'googleplus', 'linkedin'),
                    ),
                    array(
                        'id'       => 'headersidebar_customize_right_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'chrome',
                        'title'    => esc_html__('Text Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add content for custom text.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines' => 5, 'maxLines' => 60),
                    ),
                ),
            );
            // Header Icon Action
            $this->sections[] = array(
                'title'      => esc_html__('Header Icon Actions', 'yolo-bestruct'),
                'desc'       => '',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'     => 'section-search-icon',
                        'type'   => 'section',
                        'title'  => esc_html__('Search Icon', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'search_box_type',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Search Box Type', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select search box type.', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'standard' => esc_html__('Standard','yolo-bestruct'),
                            'ajax'     => esc_html__('Ajax Search','yolo-bestruct')
                        ),
                        'default'  => 'standard'
                    ),
                    array(
                        'id'       => 'search_box_post_type',
                        'type'     => 'checkbox',
                        'title'    => esc_html__('Post type for Ajax Search', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select post type for ajax search', 'yolo-bestruct'),
                        'options'  => array(
                            'post'      => 'Post',
                            'page'      => 'Page',
                            'product'   => 'Product',
                            'service'   => 'Our Services',
                        ),
                        'default'  => array(
                            'post'      => '1',
                            'page'      => '0',
                            'product'   => '1',
                            'service'   => '1',
                        ),
                        'required' => array('search_box_type','=','ajax'),
                    ),
                    array(
                        'id'        => 'search_box_result_amount',
                        'type'      => 'text',
                        'title'     => esc_html__('Amount Of Search Result', 'yolo-bestruct'),
                        'subtitle'  => esc_html__('This must be numeric (no px) or empty (default: 8).', 'yolo-bestruct'),
                        'desc'      => esc_html__('Set mount of Search Result', 'yolo-bestruct'),
                        'validate'  => 'numeric',
                        'default'   => '8',
                        'required' => array('search_box_type','=','ajax'),
                    ),
                    array(
                        'id'     => 'section-shop-icon',
                        'type'   => 'section',
                        'title'  => esc_html__('Woo Icon', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'header_shopping_cart_button',
                        'type'     => 'checkbox',
                        'title'    => esc_html__('Shopping Cart Button', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select header shopping cart button', 'yolo-bestruct'),
                        'options'  => array(
                            'view-cart' => 'View Cart',
                            'checkout'  => 'Checkout',
                        ),
                        'default'  => array(
                            'view-cart' => '1',
                            'checkout'  => '1',
                        ),
                    ),
                )
            );
            // Top Bar
            $this->sections[] = array(
                'title'      => esc_html__( 'Top Bar', 'yolo-bestruct' ),
                'desc'       => '',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'top_bar',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show/Hide Top Bar', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Show Hide Top Bar.', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'      => 'top_bar_layout_width',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Top bar layout width', 'yolo-bestruct'),
                        'options' => array(
                            'container'    => esc_html__('Container','yolo-bestruct'),
                            'topbar-fullwith' => esc_html__('Full width','yolo-bestruct'),
                        ),
                        'default'  => 'container',
                        'required' => array('top_bar','=','1'),
                    ),
                    array(
                        'id'       => 'top_bar_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__('Top bar padding left/right (px)', 'yolo-bestruct'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 200,
                        'required' => array('top_bar_layout_width','=','topbar-fullwith'),
                    ),
                    array(
                        'id'       => 'top_bar_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Top Bar background color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set Top Bar background color.', 'yolo-bestruct' ),
                        'default'  => '#fff'
                    ),
                    array(
                        'id'       => 'top_bar_text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Top Bar text color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Pick a text color for the Top Bar', 'yolo-bestruct'),
                        'default'  => '#0f0f0f',
                    ),
                    array(
                        'id'       => 'top_bar_layout',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Top bar Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select the top bar column layout.', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'top-bar-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-1.jpg'),
                            'top-bar-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-2.jpg'),
                            'top-bar-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-3.jpg'),
                            'top-bar-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-4.jpg'),
                        ),
                        'default'  => 'top-bar-1',
                        'required' => array('top_bar','=','1'),
                    ),
                    array(
                        'id'       => 'top_bar_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Top Left Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default top left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'top_bar_left',
                        'required' => array('top_bar_layout', '=', array('top-bar-1','top-bar-2','top-bar-3')),
                    ),
                    array(
                        'id'       => 'top_bar_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Top Right Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default top right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'top_bar_right',
                        'required' => array('top_bar_layout', '=', array('top-bar-1','top-bar-2','top-bar-3')),
                    ),
                    array(
                        'id'       => 'top_bar_center_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Top Center Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default top center sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'top_bar_left',
                        'required' => array('top_bar_layout','=','top-bar-4'),
                    ),  
                )
            );

            // Mobile Header
            $this->sections[] = array(
				'title'      => esc_html__( 'Mobile Header', 'yolo-bestruct' ),
				'desc'       => '',
				'subsection' => true,
				'fields'     => array(
	                array(
						'id'       => 'mobile_header_layout',
						'type'     => 'image_select',
						'title'    => esc_html__('Header Layout', 'yolo-bestruct'),
						'subtitle' => esc_html__('Select header mobile layout', 'yolo-bestruct'),
						'desc'     => '',
						'options'  => array(
			                'header-mobile-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header-mobile-1.png'),
			                'header-mobile-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header-mobile-2.png'),
                            'header-mobile-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header-mobile-3.png'),
			                'header-mobile-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header-mobile-4.png'),
		                ),
		                'default' => 'header-mobile-1'
	                ),

	                array(
						'id'       => 'mobile_header_menu_drop',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Menu Drop Type', 'yolo-bestruct' ),
						'subtitle' => esc_html__( 'Set menu drop type for mobile header', 'yolo-bestruct' ),
						'desc'     => '',
						'options'  => array(
							'dropdown' => esc_html__('Dropdown Menu','yolo-bestruct'),
							'fly'      => esc_html__('Fly Menu','yolo-bestruct')
		                ),
		                'default'  => 'fly'
	                ),

	                array(
						'id'       => 'mobile_header_logo',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__('Mobile Logo', 'yolo-bestruct'),
						'subtitle' => esc_html__('Upload your logo here.', 'yolo-bestruct'),
						'desc'     => '',
						'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/logo.png'
                        )
                    ),
	                array(
						'id'      => 'logo_mobile_padding',
						'type'    => 'slider',
						'title'   => esc_html__('Logo Top/Bottom Padding', 'yolo-bestruct'),
						'desc'    => esc_html__('If you would like to override the default logo top/bottom padding, then you can do so here', 'yolo-bestruct'),
						'default' => 30,
                        'min'     => 0,
                        'step'    => 1,
                        'max'     => 50,
	                ),

                    array(
                        'id'       => 'mobile_header_top_bar',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Top Bar', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Top bar.', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'mobile_header_stick',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Stick Mobile Header', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Stick Mobile Header.', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'mobile_header_search_box',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Search Box', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Search Box.', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'mobile_header_shopping_cart',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Shopping Cart', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Shopping Cart', 'yolo-bestruct' ),
                        'default'  => true
                    ),
                )
            );
            
            // Pages Setting
            $this->sections[] = array(
                'title'  => esc_html__( 'Pages Setting', 'yolo-bestruct' ),
                'desc'   => '',
                'icon'   => 'el el-th',
                'fields' => array(
                    array(
                        'id'       => 'page_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Page Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'yolo-bestruct' ),
                            'container'       => esc_html__( 'Container', 'yolo-bestruct' ),
                            'container-fluid' => esc_html__( 'Container Fluid', 'yolo-bestruct' )
                        ),
                        'default'  => 'container'
                    ),
                    // Add to fix page background color
                    array(
                        'id'       => 'page_background_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__( 'Page Background Color', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Select page background color.', 'yolo-bestruct' ),
                        'default'  => '#FFFFFF',
                    ),
                    array(
                        'id'       => 'page_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Sidebar', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sidebar Style', 'yolo-bestruct'),
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png'),
                            'both'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-both.png'),
                        ),
                        'default' => 'none'
                    ),

                    array(
                        'id'       => 'page_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Sidebar Width', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('small' => 'Small (1/4)', 'large' => 'Large (1/3)'),
                        'default'  => 'small',
                        'required' => array('page_sidebar', '=', array('left','both','right')),
                    ),

                    array(
                        'id'       => 'page_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Left Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('page_sidebar', '=', array('left','both')),
                    ),
                    array(
                        'id'       => 'page_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Right Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('page_sidebar', '=', array('right','both')),
                    ),
                    array(
                        'id'       => 'page_comment',
                        'type'     => 'switch',
                        'title'    => esc_html__('Page Comment', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable page comment', 'yolo-bestruct'),
                        'default'  => true
                    ),
                    // Page title
                    array(
                        'id'     => 'section-page-title',
                        'type'   => 'section',
                        'title'  => esc_html__('Page Title', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'show_page_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Page Title', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Show/Hide Page Title', 'yolo-bestruct'),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'page_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Page Title Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Page Title Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                            'container-fluid' => 'Container Fluid'
                        ),
                        'default'  => 'full',
                        'required' => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'             => 'page_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Page Title Margin', 'yolo-bestruct'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave blank for default value.', 'yolo-bestruct'),
                        'desc'           => esc_html__('If you would like to override the default page title top/bottom margin, please set it here.', 'yolo-bestruct'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.page-title-margin'),
                        'default'        => array(
                            'margin-top'     => '0px',
                            'margin-bottom'  => '70px',
                            'units'          => 'px',
                        ),
                        'required'  => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'page_title_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Page Title Style', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select page title style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'page-title-style-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-1.png'),
                            'page-title-style-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-2.png'),
                            'page-title-style-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-3.png'),
                            'page-title-style-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-4.png'),
                            'page-title-style-5' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-5.png'),
                        ),
                        'default' => 'page-title-style-1'
                    ),

                    array(
                        'id'       => 'page_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Page Title Parallax', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Page Title Parallax', 'yolo-bestruct' ),
                        'default'  => false,
                        'required' => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'        => 'page_title_height',
                        'type'      => 'slider',
                        'units'     => 'px',
                        'width'     =>  false,
                        'title'     => esc_html__('Page Title Height', 'yolo-bestruct'),
                        'desc'      => esc_html__('You can set a height for the page title here', 'yolo-bestruct'),
                        'output'   => array('.page-title-height'),
                        'min'      => 10,
                        'step'     => 1,
                        'max'      => 500,
                        'default'  => 300,
                        'required' => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'page_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Page Title Background', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Upload page title background.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => $page_title_bg_url
                        ),
                        'required'  => array('show_page_title', '=', array('1')),
                    ),
                    
                    array(
                        'id'     => 'section-page-title-background-color',
                        'type'   => 'section',
                        'title'  => esc_html__('Page Title Scheme', 'yolo-bestruct'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'page_title_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Page Title Text Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Pick a color for page title.', 'yolo-bestruct'),
                        'default'  => '#fff'
                    ),
                    array(
                        'id'       => 'page_sub_title_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Page Sub Title Text Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Pick a color for page sub title.', 'yolo-bestruct'),
                        'default'  => '#333333'
                    ),
                    array(
                        'id'       => 'page_title_bg_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Page Title Background Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Pick a background color for page title.', 'yolo-bestruct'),
                        'default'  => '#FFFFFF'
                    ),
                    array(
                        'id'       => 'page_title_overlay_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Page Title Background Overlay Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Pick a background overlay color for page title.', 'yolo-bestruct'),
                        'default'  => '#fff'
                    ),

                    array(
                        'id'     => 'section-page-title-breadcrumbs',
                        'type'   => 'section',
                        'title'  => esc_html__('Breadcrumbs', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'breadcrumbs_in_page_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Pages', 'yolo-bestruct'),
                        'default'  => true
                    ),
                )
            );
            // Blog
            $this->sections[] = array(
                'title'      => esc_html__( 'Blog', 'yolo-bestruct' ),
                'desc'       => '',
                'icon'       => 'el el-pencil',
                'fields'     => array(
                    array(
                        'id'     => 'section-archive-layout',
                        'type'   => 'section',
                        'title'  => esc_html__('Blog Layout', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'archive_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Layout', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Select Archive Layout', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'yolo-bestruct' ),
                            'container'       => esc_html__( 'Container', 'yolo-bestruct' ),
                            'container-fluid' => esc_html__( 'Container Fluid', 'yolo-bestruct'),
                            ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'archive_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Sidebar', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sidebar Style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'none'     => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-none.png'),
                            'left'     => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-left.png'),
                            'right'    => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-right.png'),
                            'both'     => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-both.png'),
                        ),
                        'default'  => 'right'
                    ),

                    array(
                        'id'       => 'archive_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Sidebar Width', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Set Sidebar width', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'small' => esc_html__( 'Small (1/4)', 'yolo-bestruct' ),
                            'large' => esc_html__( 'Large (1/3)', 'yolo-bestruct' ),
                        ),
                        'default'  => 'small',
                        'required' => array('archive_sidebar', '=', array('left','both','right')),
                    ),

                    array(
                        'id'       => 'archive_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Left Sidebar', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Choose the default left sidebar', 'yolo-bestruct' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('archive_sidebar', '=', array('left','both')),
                    ),
                    array(
                        'id'       => 'archive_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Right Sidebar', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Choose the default right sidebar', 'yolo-bestruct' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('archive_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'archive_paging_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Paging Style', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Select archive paging style', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'         => esc_html__( 'Default', 'yolo-bestruct' ),
                            'load-more'       => esc_html__( 'Load More', 'yolo-bestruct' ),
                            'infinity-scroll' => esc_html__( 'Infinity Scroll', 'yolo-bestruct' )
                        ),
                        'default'  => 'default'
                    ),

                    array(
                        'id'       => 'archive_paging_align',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Paging Align', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Select archive paging align', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'left'   => esc_html__( 'Left','yolo-bestruct' ),
                            'center' => esc_html__( 'Center','yolo-bestruct' ),
                            'right'  => esc_html__( 'Right','yolo-bestruct' )
                        ),
                        'default' => 'right'
                    ),

                    array(
                        'id'       => 'archive_display_type',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Type', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select archive display type', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'large-image'  => esc_html__('Large Image','yolo-bestruct'),
                            'medium-image' => esc_html__('Medium Image','yolo-bestruct'),
                            'grid'         => esc_html__('Grid','yolo-bestruct'),
                            'masonry'      => esc_html__('Masonry','yolo-bestruct'),
                        ),
                        'default'  => 'medium-image'
                    ),

                    array(
                        'id'       => 'archive_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Columns', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Choose the number of columns to display on archive pages.','yolo-bestruct'),
                        'options'  => array(
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                        ),
                        'desc'     => '',
                        'default'  => '2',
                        'required' => array('archive_display_type','=',array('grid','masonry')),
                    ),
                    array(
                        'id'     => 'section-archive-title',
                        'type'   => 'section',
                        'title'  => esc_html__('Blog Archive Title', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'inherit_archive_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Inherit Page Title ', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Inherit Page Title Setting', 'yolo-bestruct'),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'show_archive_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Archive Title', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Archive Title', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('inherit_archive_title','=',array('0')),
                    ),

                    array(
                        'id'       => 'archive_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Title Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Archive Title Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'full',
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'             => 'archive_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Archive Title Margin', 'yolo-bestruct'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave blank for default.', 'yolo-bestruct'),
                        'desc'           => esc_html__('If you would like to override the default archive title top/bottom margin, then you can do so here.', 'yolo-bestruct'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.archive-title-margin'),
                        'default'        => array(
                            'margin-top'     => '0px',
                            'margin-bottom'  => '65px',
                            'units'          => 'px',
                        ),
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_title_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Archive Page Title Style', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select archive page title style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'page-title-style-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-1.png'),
                            'page-title-style-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-2.png'),
                            'page-title-style-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-3.png'),
                            'page-title-style-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-4.png'),
                            'page-title-style-5' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-5.png'),
                        ),
                        'default' => 'page-title-style-1',
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Archive Title Parallax', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Archive Title Parallax', 'yolo-bestruct' ),
                        'default'  => false,
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_title_height',
                        'type'     => 'slider',
                        'title'    => esc_html__('Archive Title Height', 'yolo-bestruct'),
                        'desc'     => esc_html__('You can set a height for the archive title here', 'yolo-bestruct'),
                        'min'      => 10,
                        'step'     => 1,
                        'max'      => 500,
                        'default'  => 250,
                        'output'   => array('.archive-title-height'),
                        'required' => array('show_archive_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'archive_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Archive Title Background', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Upload archive title background.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => $page_title_bg_url
                        ),
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_archive_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Archive', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('inherit_archive_title','=',array('0')),
                    ),

                )

            );
            // Single Blog
            $this->sections[] = array(
                'title'      => esc_html__( 'Single Blog', 'yolo-bestruct' ),
                'desc'       => '',
                'icon'       => 'el el-file',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'single_blog_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Single Blog Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'single_blog_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Sidebar', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sidebar Style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png'),
                            'both'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-both.png'),
                        ),
                        'default'  => 'right'
                    ),

                    array(
                        'id'       => 'single_blog_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Sidebar Width', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('small' => 'Small (1/4)', 'large' => 'Large (1/3)'),
                        'default'  => 'small',
                        'required' => array('single_blog_sidebar', '=', array('left','both','right')),
                    ),


                    array(
                        'id'       => 'single_blog_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Left Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('single_blog_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'single_blog_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Right Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('single_blog_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'show_post_navigation',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Post Navigation', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Post Navigation', 'yolo-bestruct'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'show_author_info',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Author Info', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Author Info', 'yolo-bestruct'),
                        'default'  => true
                    ),
                    
                    array(
                        'id'       => 'related_post',
                        'type'     => 'switch',
                        'title'    => esc_html__('Related Post', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Related Post', 'yolo-bestruct'),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'related_title',
                        'type'     => 'text',
                        'title'    => esc_html__('Related Heading', 'yolo-bestruct'),
                        'default'  => esc_html__('Related Post','yolo-bestruct'),
                        'required'  => array('related_post', '=', array('1')),
                    ),
                    array(
                        'id'       => 'related_layout',
                        'type'     => 'select',
                        'title'    => esc_html__('Related Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select related layout.', 'yolo-bestruct'),
                        'options'  => array(
                            'grid' => esc_html__('Grid','yolo-bestruct'),
                            'slider'=>esc_html__('Slider','yolo-bestruct')
                            ),
                        'default'   => 'slider',
                        'required'  => array('related_post', '=', array('1')),
                    ),
                    array(
                        'id'       => 'related_margin',
                        'type'     => 'text',
                        'title'    => esc_html__('Item Margin', 'yolo-bestruct'),
                        'subtitle' => esc_html__('eg: 15.', 'yolo-bestruct'),
                        'default'  => '15',
                        'required'  => array('related_layout', '=', array('slider')),
                    ),
                    array(
                        'id'       => 'related_count',
                        'type'     => 'text',
                        'title'    => esc_html__('Related Total Record', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Total Record Of Related Post.', 'yolo-bestruct'),
                        'default'  => '3',
                        'required'  => array('related_post', '=', array('1')),
                    ),
                    array(
                        'id'       => 'related_post_col',
                        'type'     => 'select',
                        'title'    => esc_html__('Related Column', 'yolo-bestruct'),
                        'subtitle' => '',
                        'options'  => array(
                            '2'=>esc_html__('2','yolo-bestruct'),
                            '3'=>esc_html__('3','yolo-bestruct'),
                            ),
                        'default'  => '2',
                        'required'  => array('related_post', '=', array('1')),
                    ),
                    array(
                        'id'     => 'section-single-blog-title',
                        'type'   => 'section',
                        'title'  => esc_html__('Single Blog Title', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'inherit_single_blog_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Inherit Page Title ', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Inherit Page Title Setting', 'yolo-bestruct'),
                        'default'  => false
                    ),

                    array(
                        'id'       => 'show_single_blog_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Single Blog Title', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Single Blog Title', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('inherit_single_blog_title', '=', array('0')),
                    ),

                    array(
                        'id'       => 'single_blog_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Single Blog Title Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Single Blog Title Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                            'container-fluid' => 'Container Fluid'
                        ),
                        'default'  => 'full',
                        'required' => array('show_single_blog_title', '=', array('1')),
                    ),
                    array(
                        'id'       => 'custom_single_blog_title',
                        'type'     => 'text',
                        'title'    => esc_html__('Custom Single Blog Title', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enter a custom page title if you would like. ', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => esc_html__('Blog Details','yolo-bestruct'),
                        'required' => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'             => 'single_blog_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Single Blog Title Margin', 'yolo-bestruct'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'yolo-bestruct'),
                        'desc'           => esc_html__('If you would like to override the default single blog title top/bottom margin, then you can do so here.', 'yolo-bestruct'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.single-blog-title-margin'),
                        'default'        => array(
                            'margin-top'     => '0px',
                            'margin-bottom'  => '0px',
                            'units'          => 'px',
                        ),
                        'required'       => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_blog_title_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Single Blog Title Style', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select single blog title style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'page-title-style-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-1.png'),
                            'page-title-style-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-2.png'),
                            'page-title-style-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-3.png'),
                            'page-title-style-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-4.png'),
                            'page-title-style-5' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-5.png'),
                        ),
                        'default' => 'page-title-style-1',
                        'required' => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_blog_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Blog Title Parallax', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Single Blog Title Parallax', 'yolo-bestruct' ),
                        'default'  => false,
                        'required' => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_blog_title_height',
                        'type'     => 'slider',
                        'title'    => esc_html__('Single Blog Title Height', 'yolo-bestruct'),
                        'desc'     => esc_html__('You can set a height for the single blog title here', 'yolo-bestruct'),
                        'required' => array('show_single_blog_title', '=', array('1')),
                        'min'      => 10,
                        'step'     => 1,
                        'max'      => 500,
                        'default'  => 400,
                        'output'   => array('.single-blog-title-height'),
                    ),

                    array(
                        'id'       => 'single_blog_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Single Blog Title Background', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Upload single blog title background.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => $page_title_bg_url
                        ),
                        'required'  => array('show_single_blog_title', '=', array('1'))
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_single_blog_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Single Blog', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('inherit_single_blog_title', '=', array('0')),
                    ),

                )
            );
            // Search Page Setting
            $this->sections[] = array(
                'title'  => esc_html__( 'Search Page', 'yolo-bestruct' ),
                'desc'   => '',
                'icon'   => 'el el-search',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'search_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Search Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'search_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Sidebar', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sidebar Style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-right.png'),
                            'both'  => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-both.png'),
                        ),
                        'default' => 'right'
                    ),

                    array(
                        'id'       => 'search_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Sidebar Width', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('small' => 'Small (1/4)', 'large' => 'Large (1/3)'),
                        'default'  => 'small',
                        'required' => array('search_sidebar', '=', array('left','both','right')),
                    ),

                    array(
                        'id'       => 'search_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Left Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('search_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'search_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Right Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('search_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'search_paging_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Paging Style', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select search paging style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('default' => 'Default', 'load-more' => 'Load More', 'infinity-scroll' => 'Infinity Scroll'),
                        'default'  => 'default'
                    ),
                    array(
                        'id'       => 'search_paging_align',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Paging Align', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select search paging align', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'left'   => esc_html__('Left','yolo-bestruct'),
                            'center' => esc_html__('Center','yolo-bestruct'),
                            'right'  => esc_html__('Right','yolo-bestruct')
                        ),
                        'default' => 'right'
                    ),
                )
            );

            // Woocommerce
            $this->sections[] = array(
                'title'  => esc_html__( 'Woocommerce', 'yolo-bestruct' ),
                'desc'   => '',
                'icon'   => 'el el-shopping-cart-sign',
                'fields' => array(
                    array(
                        'id'       => 'product_show_rating',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Rating', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Show/Hide Rating product', 'yolo-bestruct' ),
                        'default'  => true
                    ),


                    array(
                        'id'       => 'product_sale_flash_mode',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Sale Badge Mode', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Chose Sale Badge Mode', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array(
                            'text'    => 'Text',
                            'percent' => 'Percent'
                        ),
                        'default'  => 'percent'
                    ),

                    array(
                        'id'       => 'product_show_result_count',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Result Count', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Show/Hide Result Count In Archive Product', 'yolo-bestruct' ),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_2')),
                    ),
                    array(
                        'id'       => 'product_show_catalog_ordering',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Catalog Ordering', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Show/Hide Catalog Ordering', 'yolo-bestruct' ),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_2')),
                    ),
                    array(
                        'id'       => 'product_button_tooltip',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Button Tooltip', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Button Tooltip', 'yolo-bestruct' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'product_quick_view',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Quick View Button', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Quick View', 'yolo-bestruct' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'product_add_to_cart',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Add To Cart Button', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Add To Cart Button', 'yolo-bestruct' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'product_add_wishlist',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Add To Wishlist Button', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Add To Wishlist Button', 'yolo-bestruct' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'product_add_to_compare',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Add To Compare Button', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable/Disable Add To Compare Button', 'yolo-bestruct' ),
                        'default'  => true
                    ),

                )
            );

            // Archive Product
            $this->sections[] = array(
                'title'  => esc_html__( 'Archive Product', 'yolo-bestruct' ),
                'desc'   => '',
                'icon'   => 'el el-book',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'     => 'section-archive-product-layout',
                        'type'   => 'section',
                        'title'  => esc_html__('Archive Product Layout', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'show_page_shop_content',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Show Page Shop Content', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Shop Page Content', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('0' => 'Off','before' => 'Show Before Archive','after' => 'Show After Archive'),
                        'default'  => '0'
                    ),
                    array(
                        'id'       => 'archive_product_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Product Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Archive Product Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'product_per_page',
                        'type'     => 'text',
                        'title'    => esc_html__('Products Per Page', 'yolo-bestruct'),
                        'desc'     => esc_html__('This must be numeric or empty (default 12).', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Products Per Page in archive product', 'yolo-bestruct'),
                        'validate' => 'numeric',
                        'default'  => '12',
                    ),
                    array(
                        'id'       => 'product_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Product Display Columns', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Choose the number of columns to display on shop/category pages.','yolo-bestruct'),
                        'options'  => array(
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                            '5'     => '5'
                        ),
                        'desc'    => '',
                        'default' => '4',
                        'select2' => array('allowClear' =>  false) ,
                    ),


                    array(
                        'id'     => 'section-archive-product-layout-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Layout Options', 'yolo-bestruct'),
                        'indent' => true
                    ),
                    
                    array(
                        'id'       => 'archive_product_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Ajax Page/ Default Page', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Ajax Filter/Woo default', 'yolo-bestruct'),
                        'options'  => array(
                            'style_1'       => 'Ajax Filter',
                            'style_2'       => 'Default'
                        ),
                        'default'  => 'style_2'
                    ),
                    array(
                        'id'       => 'archive_product_display',
                        'type'     => 'select',
                        'title'    => esc_html__('Select Product Style', 'yolo-bestruct'),
                        'subtitle' => '',
                        'options'  => array(
                            'fitRows'       => esc_html__('FitRows', 'yolo-bestruct'),
                            'masonry'       => esc_html__('Masonry', 'yolo-bestruct')
                        ),
                        'default'  => 'fitRows',
                    ),
                    array(
                        'id'       => 'show_categories',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Categories', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Show/Hide categories', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_1')),
                    ),
                    array(
                        'id'       => 'show_filters',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Filters', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Show/Hide filters', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_1')),
                    ),
                    array(
                        'id'       => 'show_search',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Search', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Show/Hide search', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_1')),
                    ),
                    array(
                        'id'       => 'yolo_ajax_filter',
                        'type'     => 'switch',
                        'title'    => esc_html__('Ajax filter', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Use Ajax to filter shop content (Ajax allows new content without reloading the whole page).', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_1')),
                    ),
                    array(
                        'id'       => 'archive_product_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Archive Product Sidebar', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Archive Product Sidebar', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png')
                        ),
                        'default'  => 'right',
                        'required' => array('archive_product_style', '=', array('style_2'))
                    ),
                    array(
                        'id'       => 'archive_product_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Sidebar Width', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'small' => 'Small (1/4)',
                            'large' => 'Large (1/3)'
                        ),
                        'default'  => 'small',
                        'required' => array('archive_product_sidebar', '=', array('left','both','right')),
                    ),
                    array(
                        'id'       => 'archive_product_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Product Left Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default Archive Product left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'woocommerce',
                        'required' => array('archive_product_sidebar', '=', array('left','both')),
                    ),
                    array(
                        'id'       => 'archive_product_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Product Right Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default Archive Product right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'woocommerce',
                        'required' => array('archive_product_sidebar', '=', array('right','both')),
                    ),
                    array(
                        'id'     => 'section-archive-product-layout-end',
                        'type'   => 'section',
                        'indent' => false
                    ),
                    // PRODUCT PAGE TITLE
                    array(
                        'id'     => 'section-archive-product-title',
                        'type'   => 'section',
                        'title'  => esc_html__('Archive Product Title', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'inherit_archive_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Inherit Page Title ', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Inherit Page Title Setting', 'yolo-bestruct'),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'show_archive_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Archive Title', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Archive Product Title', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('inherit_archive_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'archive_product_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Product Title Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Archive Product Title Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                            'container-fluid' => 'Container Fluid'
                        ),
                        'default'  => 'full',
                        'required' => array('show_archive_product_title', '=', array('1')),
                    ),

                    array(
                        'id'             => 'archive_product_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Archive Product Title Margin', 'yolo-bestruct'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'yolo-bestruct'),
                        'desc'           => esc_html__('If you would like to override the default archive product title top/bottom margin, then you can do so here.', 'yolo-bestruct'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.archive-product-title-margin'),
                        'default'        => array(
                            'margin-top'     => '',
                            'margin-bottom'  => '65px',
                            'units'          => 'px',
                        ),
                        'required'  => array('show_archive_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'archive_product_title_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Archive Product Page Title Style', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select archive product page title style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'page-title-style-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-1.png'),
                            'page-title-style-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-2.png'),
                            'page-title-style-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-3.png'),
                            'page-title-style-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-4.png'),
                            'page-title-style-5' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-5.png'),
                        ),
                        'default' => 'page-title-style-1',
                        'required'  => array('show_archive_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'archive_product_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Archive Product Title Parallax', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Archive Product Title Parallax', 'yolo-bestruct' ),
                        'default'  => false,
                        'required' => array('show_archive_product_title', '=', array('1')),
                    ),


                    array(
                        'id'       => 'archive_product_title_height',
                        'type'     => 'slider',
                        'title'    => esc_html__('Archive Product Title Height', 'yolo-bestruct'),
                        'desc'     => esc_html__('You can set a height for the archive product title here', 'yolo-bestruct'),
                        'required' => array('show_archive_product_title', '=', array('1')),
                        'min'      => 10,
                        'step'     => 1,
                        'max'      => 500,
                        'default'  => 300,
                        'output'   => array('.archive-product-title-height'),
                    ),

                    array(
                        'id'       => 'archive_product_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Archive Product Title Background', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Upload archive product title background.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => $page_title_bg_url
                        ),
                        'required'  => array('show_archive_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_archive_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs in Archive Product', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs in Archive Product', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('inherit_archive_product_title', '=', array('1')),
                    ),

                )
            );

            // Single Product
            $this->sections[] = array(
                'title'      => esc_html__( 'Single Product', 'yolo-bestruct' ),
                'desc'       => '',
                'icon'       => 'el el-laptop',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'single_product_show_image_thumb',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Image Thumb', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Show/Hide Image Thumb product', 'yolo-bestruct' ),
                        'default'  => true
                    ),

                    array(
                        'id'     => 'section-single-product-layout-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Layout Options', 'yolo-bestruct'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'single_product_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Single Product Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Single Product Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                            'container-fluid' => 'Container Fluid'
                        ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'single_product_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Single Product Sidebar', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Single Product Sidebar', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png'),
                        ),
                        'default' => 'none'
                    ),
                    array(
                        'id'       => 'single_product_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Single Product Sidebar Width', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('small' => 'Small (1/4)', 'large' => 'Large (1/3)'),
                        'default'  => 'small',
                        'required' => array('single_product_sidebar', '=', array('left','both','right')),
                    ),
                    array(
                        'id'       => 'single_product_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Single Product Left Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default Single Product left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'woocommerce',
                        'required' => array('single_product_sidebar', '=', array('left','both')),
                    ),
                    array(
                        'id'       => 'single_product_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Single Product Right Sidebar', 'yolo-bestruct'),
                        'subtitle' => "Choose the default Single Product right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'woocommerce',
                        'required' => array('single_product_sidebar', '=', array('right','both')),
                    ),


                    array(
                        'id'     => 'section-single-product-layout-end',
                        'type'   => 'section',
                        'indent' => false
                    ),
                   
                    array(
                        'id'     => 'section-single-product-related-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Product Related Options', 'yolo-bestruct'),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'related_product_count',
                        'type'     => 'text',
                        'title'    => esc_html__('Related Product Total Record', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Total Record Of Related Product.', 'yolo-bestruct'),
                        'validate' => 'number',
                        'default'  => '6',
                    ),

                    array(
                        'id'       => 'related_product_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Related Product Display Columns', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Choose the number of columns to display on related product.','yolo-bestruct'),
                        'options'  => array(
                            '3'     => '3',
                            '4'     => '4',
                        ),
                        'desc'    => '',
                        'default' => '4'
                    ),

                    array(
                        'id'      => 'related_product_condition',
                        'type'    => 'checkbox',
                        'title'   => esc_html__('Related Product Condition', 'yolo-bestruct'),
                        'options' => array(
                            'category' => esc_html__('Same Category','yolo-bestruct'),
                            'tag'      => esc_html__('Same Tag','yolo-bestruct'),
                        ),
                        'default' => array(
                            'category' => '1',
                            'tag'      => '1',
                        ),
                    ),

                    array(
                        'id'     => 'section-single-product-related-end',
                        'type'   => 'section',
                        'indent' => false
                    ),
                    array(
                        'id'     => 'section-single-product-title',
                        'type'   => 'section',
                        'title'  => esc_html__('Single Product Title', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    // Single product page title
                    array(
                        'id'       => 'inherit_single_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Inherit Page Title ', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Inherit Page Title Setting', 'yolo-bestruct'),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'show_single_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Single Title', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Single Product Title', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('inherit_single_product_title', '=', array('0')),
                    ),
                    array(
                        'id'       => 'custom_single_product_title',
                        'type'     => 'text',
                        'title'    => esc_html__('Custom Single Product Title', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enter a custom page title if you would like. ', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => esc_html__('Product Details','yolo-bestruct'),
                        'required' => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_product_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Single Product Title Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Single Product Title Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'full',
                        'required' => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'             => 'single_product_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Single Product Title Margin', 'yolo-bestruct'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'yolo-bestruct'),
                        'desc'           => esc_html__('If you would like to override the default single product title top/bottom margin, then you can do so here.', 'yolo-bestruct'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.single-product-title-margin'),
                        'default'            => array(
                            'margin-top'     => '',
                            'margin-bottom'  => '70px',
                            'units'          => 'px',
                        ),
                        'required'  => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_product_title_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Single Product Page Title Style', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select single product page title style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'page-title-style-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-1.png'),
                            'page-title-style-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-2.png'),
                            'page-title-style-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-3.png'),
                            'page-title-style-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-4.png'),
                            'page-title-style-5' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-5.png'),
                        ),
                        'default' => 'page-title-style-1',
                        'required'  => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_product_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Product Title Parallax', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Single Product Title Parallax', 'yolo-bestruct' ),
                        'default'  => false,
                        'required' => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_product_title_height',
                        'type'     => 'slider',
                        'title'    => esc_html__('Single Product Title Height', 'yolo-bestruct'),
                        'subtitle' => esc_html__('This must be numeric (no px) or empty.', 'yolo-bestruct'),
                        'desc'     => esc_html__('You can set a height for the single product title here', 'yolo-bestruct'),
                        'required' => array('show_single_product_title', '=', array('1')),
                        'min'      => 10,
                        'step'     => 1,
                        'max'      => 500,
                        'default'  => 300,
                        'output'   => array('.single-product-title-height'),
                    ),

                    array(
                        'id'       => 'single_product_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Single Product Title Background', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Upload single product title background.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => $page_title_bg_url
                        ),
                        'required'  => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_single_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs in Single Product', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs in Single Product', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('inherit_single_product_title', '=', array('0')),
                    ),

                )
            );
            
            // Portfolio Settings
            $this->sections[] = array(
                'title'      => esc_html__( 'Portfolio Settings', 'yolo-bestruct' ),
                'desc'       => '',
                'icon'       => 'el el-th-large',
                'subsection' => false,
                'fields'     => array(
                    array(
                        'id'       => 'portfolio_disable_link_detail',
                        'type'     => 'switch',
                        'title'    => esc_html__('Disable link to detail', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable link to detail in Portfolio', 'yolo-bestruct'),
                        'default'  => false
                    ),

                    array(
                        'id'     => 'section-portfolio-single-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Portfolio Single Settings', 'yolo-bestruct'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'portfolio-single-style',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Single Portfolio Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Single Portfolio Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'detail-01' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-detail-01.png'),
                            'detail-02' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-detail-02.png'),
                            'detail-03' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-detail-03.png'),
                            'detail-04' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-detail-04.png'),
                            'detail-05' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-detail-05.png'),
                            'detail-06' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-detail-06.png'),
                            'detail-07' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-detail-07.png'),
                        ),
                        'default' => 'detail-02'
                    ),
                    array(
                        'id'       => 'portfolio_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Portfolio social profiles', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select social profile for portfolio single.', 'yolo-bestruct'),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
                            'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
                            'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
                            'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                            'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
                            'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
                            'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
                            'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                            'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
                            'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                            'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
                            'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
                            'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
                            'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
                            'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
                            'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
                            'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
                            'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
                        ),
                        'desc'    => '',
                        'default' => array('facebook','googleplus','twitter','linkedin')
                    ),

                    array(
                        'id' => 'section-portfolio-related',
                        'type' => 'section',
                        'title' => esc_html__('Portfolio Related', 'yolo-bestruct'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_portfolio_related',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Show/Hide Related', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Show or hide related in single portfolio', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array( '1' => 'Show', '0' => 'Hide' ),
                        'default'  => '1',

                    ),
                    array(
                        'id'      => 'portfolio_related_style',
                        'type'    => 'select',
                        'multi'   => false,
                        'title'   => esc_html__('Select portfolio related style', 'yolo-bestruct'),
                        'options' => array(
                            'default'   => esc_html__('Default', 'yolo-bestruct'),
                            'squared'   => esc_html__('Squared', 'yolo-bestruct'),
                            'landscape' => esc_html__('Landscape', 'yolo-bestruct'),
                            'portrait'  => esc_html__('Portrait', 'yolo-bestruct')
                        ),
                        'desc'     => '',
                        'default'  => 'landscape',
                        'required' => array('show_portfolio_related', '=', array('1'))
                    ),
                    array(
                        'id'       => 'portfolio-related-column',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Portfolio Related Column', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Portfolio Related Column.', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            '2' => array('title' => 'Two Column', 'img' => get_template_directory_uri().'/assets/images/theme-options/columns-2.jpg'),
                            '3' => array('title' => 'Three Column', 'img' => get_template_directory_uri().'/assets/images/theme-options/columns-3.jpg'),
                            '4' => array('title' => 'Four Column', 'img' => get_template_directory_uri().'/assets/images/theme-options/columns-4.jpg'),
                        ),
                        'default'  => '3',
                        'required' => array('show_portfolio_related', '=', array('1'))
                    ),
                    array(
                        'id'       => 'portfolio-related-overlay',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Portfolio Related Orverlay Style', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Portfolio Related Orverlay Style.  Only apply for Portfolio related style is grid', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'icon'                => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-overlay-01.png'),
                            'icon-title'          => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-overlay-02.png'),
                            'icon-title-category' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-overlay-03.png'),
                            'title-category'      => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-overlay-04.png'),
                            'title-category-link' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/portfolio-overlay-05.png'),
                        ),
                        'default'  => 'icon-title-category',
                        'required' => array('show_portfolio_related', '=', array('1'))
                    ),
                    array(
                        'id'      => 'portfolio_related_effect',
                        'type'    => 'select',
                        'multi'   => false,
                        'title'   => esc_html__('Select portfolio related hover effect', 'yolo-bestruct'),
                        'options' => array(
                            'effect_1'   => esc_html__('Effect 1', 'yolo-bestruct'),
                            'effect_2'   => esc_html__('Effect 2', 'yolo-bestruct'),
                            'effect_3'   => esc_html__('Effect 3', 'yolo-bestruct'),
                            'effect_4'   => esc_html__('Effect 4', 'yolo-bestruct'),
                            'effect_5'   => esc_html__('Effect 5', 'yolo-bestruct'),
                        ),
                        'desc'     => '',
                        'default'  => 'effect_1',
                        'required' => array('show_portfolio_related', '=', array('1'))
                    ),
                    // Single Portfolio page title
                    array(
                        'id'     => 'section-single-portfolio-title',
                        'type'   => 'section',
                        'title'  => esc_html__('Single Portfolio Title', 'yolo-bestruct'),
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'inherit_single_portfolio_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Inherit Page Title ', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Inherit Page Title Setting', 'yolo-bestruct'),
                        'default'  => true
                    ), 
                    array(
                        'id'       => 'show_portfolio_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Portfolio Title', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Portfolio Title', 'yolo-bestruct'),
                        'default'  => true,
                        'required' => array('inherit_single_portfolio_title', '=', array('0')),
                    ),

                    array(
                        'id'       => 'portfolio_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Portfolio Title Layout', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select Portfolio Title Layout', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'container',
                        'required' => array('show_portfolio_title', '=', array('1')),
                    ),

                    array(
                        'id'             => 'portfolio_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Portfolio Title Margin', 'yolo-bestruct'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'yolo-bestruct'),
                        'desc'           => esc_html__('If you would like to override the default portfolio title top/bottom margin, then you can do so here.', 'yolo-bestruct'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.portfolio-title-margin'),
                        'default'            => array(
                            'margin-top'     => '',
                            'margin-bottom'  => '',
                            'units'          => 'px',
                        ),
                        'required'  => array('show_portfolio_title', '=', array('1')),
                    ),
                   
                    array(
                        'id'       => 'portfolio_title_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Portfolio Page Title Style', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Select portfolio page title style', 'yolo-bestruct'),
                        'desc'     => '',
                        'options'  => array(
                            'page-title-style-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-1.png'),
                            'page-title-style-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-2.png'),
                            'page-title-style-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-3.png'),
                            'page-title-style-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-4.png'),
                            'page-title-style-5' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/page-title-style-5.png'),
                        ),
                        'default' => 'page-title-style-1',
                        'required'  => array('show_portfolio_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'portfolio_title_parallax',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Portfolio Title Parallax', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Enable Portfolio Title Parallax', 'yolo-bestruct' ),
                        'desc'     => '',
                        'options'  => array( '1' => 'Enable', '0' => 'Disable' ),
                        'default'  => '0',
                        'required' => array('show_portfolio_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'portfolio_title_height',
                        'type'     => 'slider',
                        'title'    => esc_html__('Portfolio Title Height', 'yolo-bestruct'),
                        'subtitle' => esc_html__('This must be numeric (no px) or empty.', 'yolo-bestruct'),
                        'desc'     => esc_html__('You can set a height for the Portfolio title here', 'yolo-bestruct'),
                        'min'      => 10,
                        'step'     => 1,
                        'max'      => 500,
                        'default'  => 300,
                        'required'  => array('show_portfolio_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'portfolio_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Portfolio Title Background', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Upload portfolio title background.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => $page_title_bg_url
                        ),
                        'required'  => array('show_portfolio_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_portfolio_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs in Portfolio', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs in Portfolio', 'yolo-bestruct'),
                        'default'  => false,
                        'required' => array('inherit_single_portfolio_title', '=', array('0')),
                    ),
                    
                )
            );
            // Footer
            $this->sections[] = array(
                'title'  => esc_html__( 'Footer', 'yolo-bestruct' ),
                'desc'   => '',
                'icon'   => 'el el-website',
                'fields' => array(
	                array(
                        'id'       => 'footer',
                        'type'     => 'footer',
                        'title'    => esc_html__('Select Footer Block', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Footer Block', 'yolo-bestruct'),
                    ),

                )
            );

            // Styling Options
            $this->sections[] = array(
                'title'  => esc_html__( 'Styling Options', 'yolo-bestruct' ),
                'desc'   => esc_html__( 'If you change value in this section, you must "Save & Generate CSS"', 'yolo-bestruct' ),
                'icon'   => 'el el-magic',
                'fields' => array(
                    array(
                        'id'       => 'primary_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Primary Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Primary Color', 'yolo-bestruct'),
                        'default'  => '#fdb801',
                    ),

                    array(
                        'id'       => 'secondary_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Secondary Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Secondary Color', 'yolo-bestruct'),
                        'default'  => '#0195fd',
                    ),


                    array(
                        'id'       => 'text_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Text Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Text Color.', 'yolo-bestruct'),
                        'default'  => '#606060',
                    ),

                    array(
                        'id'       => 'heading_color',
                        'type'     => 'color_alpha',
                        'title'    => esc_html__('Heading Color', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Set Heading Color.', 'yolo-bestruct'),
                        'default'  => '#0f0f0f',
                    ),
                    
                )
            );

            // Typography
            $this->sections[] = array(
				'icon'   => 'el el-font',
				'title'  => esc_html__('Typograhpy', 'yolo-bestruct'),
				'desc'   => esc_html__( 'If you change value in this section, you must "Save & Generate CSS"', 'yolo-bestruct' ),
				'fields' => array(

                    array(
						'id'             => 'body_font',
						'type'           => 'typography',
						'title'          => esc_html__('Body Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the body font properties.', 'yolo-bestruct'),
						'google'         => true,
						'line-height'    => false,
						'color'          => false,
						'letter-spacing' => false,
						'text-align'     => false,
						'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
						'output'         => array('body'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array('body'), // An array of CSS selectors to apply this font style to dynamically
						'units'          => 'px', // Defaults to px
						'default'        => array(
							'color'       => '#606060',
							'font-size'   => '15px',
							'font-family' => 'Roboto',
							'font-weight' => '400',
							'google'      => true,
                        ),
                    ),

					array(
						'id'          => 'secondary_font',
						'type'        => 'typography',
						'title'       => esc_html__('Secondary Font', 'yolo-bestruct'),
						'subtitle'    => esc_html__('Specify the Secondary font properties.', 'yolo-bestruct'),
						'google'      => true,
						'line-height' => false,
						'all_styles'  => true, // Enable all Google Font style/weight variations to be added to the page
						'color'       => false,
						'text-align'  => false,
						'font-style'  => false,
						'subsets'     => true,
						'font-size'   => true,
						'font-weight' => true,
						'output'      => array(''), // An array of CSS selectors to apply this font style to dynamically
						'compiler'    => array(''), // An array of CSS selectors to apply this font style to dynamically
						'units'       => 'px', // Defaults to px
						'default'     => array(
							'font-family' => 'Raleway',
							'font-size'   => '14px',
							'font-weight' => '400',
							'google'      => true,
                    	),
                    ),

                    array(
                        'id' => 'section-heading-font',
                        'type' => 'section',
                        'title' => esc_html__('Heading Font', 'yolo-bestruct'),
                        'indent' => true
                    ),


                    array(
						'id'             =>'h1_font',
						'type'           => 'typography',
						'title'          => esc_html__('H1 Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the H1 font properties.', 'yolo-bestruct'),
						'google'         => true,
						'letter-spacing' => false,
						'color'          => false,
						'line-height' 	 => false,
						'text-align'     => false,
						'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
						'output'         => array('h1'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array('h1'), // An array of CSS selectors to apply this font style to dynamically
						'units'          =>'px', // Defaults to px
						'default'        => array(
							'color'       => '#0f0f0f',
							'font-size'   => '36px',
							'font-family' => 'Raleway',
							'font-weight' => '700',
                        ),
                    ),
                    array(
						'id'             =>'h2_font',
						'type'           => 'typography',
						'title'          => esc_html__('H2 Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the H2 font properties.', 'yolo-bestruct'),
						'google'         => true,
						'letter-spacing' => false,
						'color'          => false,
						'line-height' 	 => false,
						'text-align'     => false,
						'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
						'output'         => array('h2'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array('h2'), // An array of CSS selectors to apply this font style to dynamically
						'units'          =>'px', // Defaults to px
						'default'        => array(
							'color'       => '#0f0f0f',
							'font-size'   => '30px',
							'font-family' => 'Raleway',
							'font-weight' => '700',
                        ),
                    ),
                    array(
						'id'             =>'h3_font',
						'type'           => 'typography',
						'title'          => esc_html__('H3 Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the H3 font properties.', 'yolo-bestruct'),
						'google'         => true,
						'color'          => false,
						'line-height' 	 => false,
						'letter-spacing' => false,
						'text-align'     => false,
						'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
						'output'         => array('h3'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array('h3'), // An array of CSS selectors to apply this font style to dynamically
						'units'          =>'px', // Defaults to px
						'default'        => array(
							'color'       => '#0f0f0f',
							'font-size'   => '24px',
							'font-family' => 'Raleway',
							'font-weight' => '700',
                        ),
                    ),
                    array(
						'id'             =>'h4_font',
						'type'           => 'typography',
						'title'          => esc_html__('H4 Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the H4 font properties.', 'yolo-bestruct'),
						'google'         => true,
						'color'          => false,
						'line-height' 	 => false,
						'letter-spacing' => false,
						'text-align'     => false,
						'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
						'output'         => array('h4'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array('h4'), // An array of CSS selectors to apply this font style to dynamically
						'units'          =>'px', // Defaults to px
						'default'        => array(
							'color'       => '#0f0f0f',
							'font-size'   => '20px',
							'font-family' => 'Raleway',
							'font-weight' => '400',
                        ),
                    ),
                    array(
						'id'             =>'h5_font',
						'type'           => 'typography',
						'title'          => esc_html__('H5 Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the H5 font properties.', 'yolo-bestruct'),
						'google'         => true,
						'line-height' 	 => false,
						'color'          => false,
						'letter-spacing' => false,
						'text-align'     => false,
						'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
						'output'         => array('h5'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array('h5'), // An array of CSS selectors to apply this font style to dynamically
						'units'          =>'px', // Defaults to px
						'default'        => array(
							'color'       => '#0f0f0f',
							'font-size'   => '18px',
							'font-family' => 'Raleway',
							'font-weight' => '400',
                        ),
                    ),
                    array(
						'id'             =>'h6_font',
						'type'           => 'typography',
						'title'          => esc_html__('H6 Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the H6 font properties.', 'yolo-bestruct'),
						'google'         => true,
						'color'          => false,
						'line-height' 	 => false,
						'letter-spacing' => false,
						'text-align'     => false,
						'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
						'output'         => array('h6'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array('h6'), // An array of CSS selectors to apply this font style to dynamically
						'units'          =>'px', // Defaults to px
						'default'        => array(
							'color'       => '#0f0f0f',
							'font-size'   => '14px',
							'font-family' => 'Raleway',
							'font-weight' => '400',
                        ),
                    ),

                    array(
                        'id' => 'section-menu-font',
                        'type' => 'section',
                        'title' => esc_html__('Menu Font', 'yolo-bestruct'),
                        'indent' => true
                    ),

                    array(
						'id'             => 'menu_font',
						'type'           => 'typography',
						'title'          => esc_html__('Menu Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the Menu font properties.', 'yolo-bestruct'),
						'google'         => true,
						'all_styles'     => false, // Enable all Google Font style/weight variations to be added to the page
						'color'          => false,
						'line-height' 	 => false,
						'text-align'     => false,
						'font-style'     => false,
						'subsets'        => true,
						'text-transform' => false,
						'output'         => array(''), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array(''), // An array of CSS selectors to apply this font style to dynamically
						'units'          => 'px', // Defaults to px
						'default'        => array(
							'font-family'    => 'Raleway',
							'font-size'      => '14px',
							'font-weight'    => '700',
							'text-transform' => 'none',
                        ),
                    ),

                    array(
                        'id' => 'section-page-title-font',
                        'type' => 'section',
                        'title' => esc_html__('Page Title Font', 'yolo-bestruct'),
                        'indent' => true
                    ), 

                    array(
						'id'             => 'page_title_font',
						'type'           => 'typography',
						'title'          => esc_html__('Page Title Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the page title font properties.', 'yolo-bestruct'),
						'google'         => true,
						'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
						'line-height'    => false,
						'color'          => false,
						'text-align'     => false,
						'font-style'     => true,
						'subsets'        => false,
						'font-size'      => true,
						'font-weight'    => true,
						'text-transform' => true,
						'output'         => array('.page-title-inner h1'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array(), // An array of CSS selectors to apply this font style to dynamically
						'units'          => 'px', // Defaults to px
						'default'        => array(
							'font-family'    => 'Raleway',
							'font-size'      => '36px',
							'font-weight'    => '700',
							'text-transform' => 'none',
                        ),
                    ),

                    array(
						'id'             => 'page_sub_title_font',
						'type'           => 'typography',
						'title'          => esc_html__('Page Sub Title Font', 'yolo-bestruct'),
						'subtitle'       => esc_html__('Specify the page sub title font properties.', 'yolo-bestruct'),
						'google'         => true,
						'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
						'line-height'    => false,
                        'color'          => false,
						'font-style'     => true,
						'text-align'     => false,
						'subsets'        => false,
						'font-size'      => true,
						'font-weight'    => true,
						'text-transform' => true,
						'output'         => array('.page-title-inner .page-sub-title'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'       => array(), // An array of CSS selectors to apply this font style to dynamically
						'units'          => 'px', // Defaults to px
						'default'        => array(
							'font-family'    => 'Raleway',
							'font-size'      => '14px',
							'font-weight'    => '400',
							'text-transform' => 'none',
							//'color'          => '#333333'
                        ),
                    ),


                ),
            );
            
            // Social Profiles
            $this->sections[] = array(
                'title'  => esc_html__( 'Social Profiles', 'yolo-bestruct' ),
                'desc'   => '',
                'icon'   => 'el el-globe',
                'fields' => array(

                    array(
						'id'       => 'facebook_url',
						'type'     => 'text',
						'title'    => esc_html__('Facebook URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Facebook URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'twitter_url',
						'type'     => 'text',
						'title'    => esc_html__('Twitter URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Twitter URL.",
						'desc'     => '',
						'default'  => ''
                    ),

                    array(
						'id'       => 'dribbble_url',
						'type'     => 'text',
						'title'    => esc_html__('Dribbble URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Dribbble URL.",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'vimeo_url',
						'type'     => 'text',
						'title'    => esc_html__('Vimeo URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Vimeo URL.",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'tumblr_url',
						'type'     => 'text',
						'title'    => esc_html__('Tumblr URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Tumblr URL.",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'skype_username',
						'type'     => 'text',
						'title'    => esc_html__('Skype ID', 'yolo-bestruct'),
						'subtitle' => "Please enter your skype ID.",
						'default'  => ''
                    ),
                    array(
						'id'       => 'linkedin_url',
						'type'     => 'text',
						'title'    => esc_html__('LinkedIn URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Linkedin URL.",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'googleplus_url',
						'type'     => 'text',
						'title'    => esc_html__('Google+ URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Google+ URL.",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'flickr_url',
						'type'     => 'text',
						'title'    => esc_html__('Flickr URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Flickr URL.",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'youtube_url',
						'type'     => 'text',
						'title'    => esc_html__('YouTube URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Youtube URL.",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'pinterest_url',
						'type'     => 'text',
						'title'    => esc_html__('Pinterest URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Pinterest URL.",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'foursquare_url',
						'type'     => 'text',
						'title'    => esc_html__('Foursquare URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Foursqaure URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'instagram_url',
						'type'     => 'text',
						'title'    => esc_html__('Instagram URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Instagram URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'github_url',
						'type'     => 'text',
						'title'    => esc_html__('GitHub URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your GitHub URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'xing_url',
						'type'     => 'text',
						'title'    => esc_html__('Xing URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Xing URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'behance_url',
						'type'     => 'text',
						'title'    => esc_html__('Behance URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Behance URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'deviantart_url',
						'type'     => 'text',
						'title'    => esc_html__('Deviantart URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Deviantart URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'soundcloud_url',
						'type'     => 'text',
						'title'    => esc_html__('SoundCloud URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your SoundCloud URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'yelp_url',
						'type'     => 'text',
						'title'    => esc_html__('Yelp URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your Yelp URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'rss_url',
						'type'     => 'text',
						'title'    => esc_html__('RSS Feed URL', 'yolo-bestruct'),
						'subtitle' => "Please enter in your RSS Feed URL",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'       => 'email_address',
						'type'     => 'text',
						'title'    => esc_html__('Email address', 'yolo-bestruct'),
						'subtitle' => "Please enter in your email address",
						'desc'     => '',
						'default'  => ''
                    ),
                    array(
						'id'   =>'social-profile-divide-0',
						'type' => 'divide'
                    ),
                    array(
                        'title'    => esc_html__('Social Share', 'yolo-bestruct'),
                        'id'       => 'social_sharing',
                        'type'     => 'checkbox',
                        'subtitle' => esc_html__('Show the social sharing in blog posts', 'yolo-bestruct'),

                        //Must provide key => value pairs for multi checkbox options
                        'options'  => array(
                            'facebook'  => 'Facebook',
                            'twitter'   => 'Twitter',
                            'google'    => 'Google',
                            'linkedin'  => 'Linkedin',
                            'tumblr'    => 'Tumblr',
                            'pinterest' => 'Pinterest'
                        ),

                        //See how default has changed? you also don't need to specify opts that are 0.
                        'default' => array(
                            'facebook'  => '1',
                            'twitter'   => '1',
                            'google'    => '1',
                            'linkedin'  => '1',
                            'tumblr'    => '1',
                            'pinterest' => '1'
                        )
                    ),
                    
                )
            );

            // Popup Configs
            $this->sections[] = array(
                'title'  => esc_html__( 'Promo Popup', 'yolo-bestruct' ),
                'desc'   => '',
                'icon'   => 'el el-photo',
                'fields' => array(
                    array(
                        'id'       => 'show_popup',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Popup', 'yolo-bestruct' ),
                        'subtitle' => esc_html__( 'Show/Hide Popup when user go to your site', 'yolo-bestruct' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'popup_width',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Popup Width', 'yolo-bestruct' ),
                        'subtitle' => "Please set with of popup (number only in px)",
                        'validate'  => 'numeric',
                        'desc'     => '',
                        'default'  => '770',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_height',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Popup Height', 'yolo-bestruct' ),
                        'subtitle' => "Please set height of popup (number only in px)",
                        'validate'  => 'numeric',
                        'desc'     => '',
                        'default'  => '500',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_effect',
                        'type'     => 'select',
                        'title'    => esc_html__('Popup Effect', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Choose popup effect.','yolo-bestruct'),
                        'options'  => array(
                            'mfp-zoom-in'         => esc_html__( 'ZoomIn', 'yolo-bestruct' ),
                            'mfp-newspaper'       => esc_html__( 'Newspaper', 'yolo-bestruct' ),
                            'mfp-move-horizontal' => esc_html__( 'Move Horizontal', 'yolo-bestruct' ),
                            'mfp-move-from-top'   => esc_html__( 'Move From Top', 'yolo-bestruct' ),
                            'mfp-3d-unfold'       => esc_html__( '3D Unfold', 'yolo-bestruct' ),
                            'mfp-zoom-out'        => esc_html__( 'ZoomOut', 'yolo-bestruct' ),
                            'hinge'               => esc_html__( 'Hinge', 'yolo-bestruct' )
                        ),
                        'desc'     => '',
                        'default'  => 'mfp-zoom-in',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_delay',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Popup Delay', 'yolo-bestruct' ),
                        'subtitle' => "Please set delay of popup (caculate by miliseconds)",
                        'validate'  => 'numeric',
                        'desc'     => '',
                        'default'  => '4000',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_content',
                        'type'     => 'editor',
                        'title'    => esc_html__( 'Popup Content', 'yolo-bestruct' ),
                        'subtitle' => "Please set content of popup",
                        'desc'     => '',
                        'default'  => '',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_background',
                        'type'     => 'media',
                        'title'    => esc_html__( 'Popup Background', 'yolo-bestruct' ),
                        'url'      => true,
                        'subtitle' => "",
                        'desc'     => '',
                        'default'  => array(
                            'url'  =>  get_template_directory_uri() . '/assets/images/popup.jpg'
                        ),
                        'required' => array('show_popup','=',array('1')),
                    ),

                )
            );

			// Custom CSS & Script
            $this->sections[] = array(
                'title'  => esc_html__( 'Custom CSS & Script', 'yolo-bestruct' ),
                'desc'   => esc_html__( 'If you change Custom CSS, you must "Save & Generate CSS"', 'yolo-bestruct' ),
                'icon'   => 'el el-edit',
                'fields' => array(
                    array(
						'id'       => 'custom_css',
						'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'monokai',
						'title'    => esc_html__('Custom CSS', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add some CSS to your theme by adding it to this textarea. Please do not include any style tags.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 10, 'maxLines' => 60)
                    ),
                    array(
                        'id'       => 'custom_js',
                        'type'     => 'ace_editor',
                        'mode'     => 'javascript',
                        'theme'    => 'chrome',
                        'title'    => esc_html__('Custom JS', 'yolo-bestruct'),
                        'subtitle' => esc_html__('Add some custom JavaScript to your theme by adding it to this textarea. Please do not include any script tags.', 'yolo-bestruct'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 10, 'maxLines' => 60)
                    ),

                )
            );
        }

        public function setHelpTabs() {
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'           => 'yolo_bestruct_options',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'       => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'    => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'          => 'submenu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'     => true,
                // Show the sections below the admin menu item or not
                'menu_title'         => esc_html__( 'Theme Options', 'yolo-bestruct' ),
                'page_title'         => esc_html__( 'Theme Options', 'yolo-bestruct' ),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'     => '',
                // Must be defined to add google fonts to the typography module

                'async_typography'   => false,
                // Use a asynchronous font on the front end or font string
                'admin_bar'          => true,
                // Show the panel pages on the admin bar
                'global_variable'    => '',
                // Set a different name for your global variable other than the opt_name
                'dev_mode'           => false,
                // Show the time the page took to load, etc
                'forced_dev_mode_off' => true,
                // To forcefully disable the dev mode
                'templates_path'     => get_template_directory().'/framework/core/templates/panel',
                // Path to the templates file for various Redux elements
                'customizer'         => true,
                // Enable basic customizer support

                // OPTIONAL -> Give you extra features
                'page_priority'      => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'        => 'yolo-options',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_theme_page#Parameters
                'page_permissions'   => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon'          => '',
                // Specify a custom URL to an icon
                'last_tab'           => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon'          => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug'          => '_options',
                // Page slug used to denote the panel
                'save_defaults'      => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show'       => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark'       => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'     => 60 * MINUTE_IN_SECONDS,
                'output'             => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'         => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'           => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'        => false,
                // REMOVE

                // HINTS
                'hints'              => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'   => 'light',
                        'shadow'  => true,
                        'rounded' => false,
                        'style'   => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'mouseover',
                        ),
                        'hide' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'click mouseleave',
                        ),
                    ),
                )
            );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el el-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el el-facebook'
            );
            $args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el el-twitter'
            );
            $args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el el-linkedin'
            );

        }

    }

    global $reduxConfig;
    $reduxConfig = new Redux_Framework_options_config();
}