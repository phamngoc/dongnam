<?php
/**
 * Yolo Theme Framework includes
 *
 * The $yolo_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed.
 *
 * Please note that missing files will produce a fatal error.
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
if ( !class_exists( 'Yolo_Install_Plugin' ) ) :
    class Yolo_Install_Plugin {
        /**
         * Variable to hold required / recommended plugins.
         *
         * @var  array
         */
        public static $plugins;
        /**
         * Get purchase code
         *
         * @package     Bestruct/Plugins
         * @author      JAMES <luyentv@vietbrain.com>
         * @version     1.0
         */

        public function __construct(){

            require_once get_template_directory() . '/framework/includes/yolo-dash/tgmpa/class-tgm-plugin-activation.php';

            add_action( 'tgmpa_register', array(&$this,'yolo_register_required_plugins') );
            add_action( 'admin_init', array(&$this,'yolo_updater_plugin_load') );
            add_filter( 'upgrader_pre_download', array(&$this,'yolo_upgrader_pre_download'), 10, 3 );
            add_action( 'vc_after_init', array(&$this,'yolo_enable_vc_auto_theme_update') );

            // Register Ajax action to install / uninstall plugin.
            add_action( 'wp_ajax_yolo_updater_plugin'   , array( &$this, 'updater_plugin'   ) );
            add_action( 'wp_ajax_yolo_install_plugin'   , array( &$this, 'install_plugin'   ) );
            add_action( 'wp_ajax_yolo_deactivate_plugin', array( &$this, 'deactivate_plugin') );
            add_action( 'wp_ajax_yolo_uninstall_plugin' , array( &$this, 'uninstall_plugin' ) );

        }

        public function yolo_get_purchase() {

                $theme_options = get_option( 'yolo-bestruct-license-settings' );

                if( $theme_options && isset( $theme_options['license_key'] ) ) {
                    return $theme_options['license_key'];
                }

                return false;

        }

        /**
         * Check plugin active
         *
         * @package     Bestruct/Plugins
         * @author      JAMES <luyentv@vietbrain.com>
         * @version     1.0
         */        
        public static function yolo_bestruct_is_plugin_active( $slug ) {

            $path = self::yolo_bestruct_get_plugin_path( $slug );

            if( $path && is_plugin_active( $path ) ){
                return $path;
            }

            return false;

        }

        /**
         *
         * Get path plugin
         * @param $slug
         * @return Boolean True/False
         * 
         */        
        public static function yolo_bestruct_get_plugin_path( $slug ) {           

            if ( @is_file( WP_PLUGIN_DIR . '/' . ( $path = "{$slug}/init.php" ) ) ) {
                return $path;
            }

            if ( @is_file( WP_PLUGIN_DIR . '/' . ( $path = "{$slug}/{$slug}.php" ) ) ) {
                return $path;
            }

            if ( @is_file( WP_PLUGIN_DIR . '/' . ( $path = "{$slug}/wp-{$slug}.php" ) ) ) {
                return $path;
            }

            return false;

        }


        /**
         * Check plugin active
         *
         * @package     Bestruct/Plugins
         * @author      JAMES <luyentv@vietbrain.com>
         * @version     1.0
         */

        
        public static function yolo_is_plugin_active( $plugin ) {

            include_once ABSPATH . 'wp-admin/includes/plugin.php';
            return is_plugin_active( $plugin );

        }



        /**
         * Register the required plugins for this theme.
         *
         * In this example, we register two plugins - one included with the TGMPA library
         * and one from the .org repo.
         *
         * The variable passed to tgmpa_register_plugins() should be an array of plugin
         * arrays.
         *
         * This function is hooked into tgmpa_init, which is fired within the
         * TGM_Plugin_Activation class constructor.
         */
        public function yolo_register_required_plugins() {

            if ( !current_user_can( 'install_plugins' ) ) {
                return;
            }
            /*
             * Array of plugin arrays. Required keys are name and slug.
             * If the source is NOT from the .org repo, then source is also required.
             */
            if ( ! isset( self::$plugins ) ) {
                self::$plugins = array(
                    array(
                        'name'               => 'Yolo Bestruct Framework', // The plugin name
                        'slug'               => 'yolo-bestruct-framework', // The plugin slug (typically the folder name)
                        'thumb'              => get_template_directory_uri() . '/assets/images/plugins/yolo-bestruct-framework.jpg',
                        'source'             => esc_url( 'http://update.yolotheme.com/download/yolo-bestruct-framework.zip' ), // The plugin source
                        'required'           => true, // If false, the plugin is only 'recommended' instead of required
                        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                        'version'            => '',
                        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                        'external_url'       => '', // If set, overrides default API URL and points to an external URL
                    ),
                    array(
                        'name'               => 'YL WooCommerce Products Layouts Bestruct', // The plugin name
                        'slug'               => 'yl_products_layouts_bestruct', // The plugin slug (typically the folder name)
                        'thumb'              => get_template_directory_uri() . '/assets/images/plugins/yl_products_layouts.jpg',
                        'source'             => esc_url( 'http://update.yolotheme.com/download/yl_products_layouts_bestruct.zip' ), // The plugin source
                        'required'           => true, // If false, the plugin is only 'recommended' instead of required
                        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                        'version'            => '',
                        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                        'external_url'       => '', // If set, overrides default API URL and points to an external URL
                    ),
                    array(
                        'name'               => 'Revolution Slider', // The plugin name
                        'slug'               => 'revslider', // The plugin slug (typically the folder name)
                        'thumb'              => get_template_directory_uri() . '/assets/images/plugins/revslider.jpg',
                        'source'             => esc_url( 'http://update.yolotheme.com/download/revslider.zip' ), // The plugin source
                        'required'           => true, // If false, the plugin is only 'recommended' instead of required
                        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                        'version'            => '',
                        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                        'external_url'       => '', // If set, overrides default API URL and points to an external URL
                    ),
                    array(
                        'name'               => 'Visual Composer', // The plugin name
                        'slug'               => 'js_composer', // The plugin slug (typically the folder name)
                        'thumb'              => get_template_directory_uri() . '/assets/images/plugins/js_composer.jpg',
                        'source'             => esc_url( 'http://update.yolotheme.com/download/js_composer.zip' ), // The plugin source
                        'required'           => true, // If false, the plugin is only 'recommended' instead of required
                        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                        'version'            => '',
                        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                        'external_url'       => '', // If set, overrides default API URL and points to an external URL
                    ),

                    array(
                        'name'               => 'WooCommerce', // The plugin name
                        'slug'               => 'woocommerce', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                        'thumb'              => get_template_directory_uri() . '/assets/images/plugins/woocommerce.jpg'
                    ),
                    array(
                        'name'               => 'YITH WooCommerce Wishlist', // The plugin name
                        'slug'               => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                        'thumb'              => get_template_directory_uri() . '/assets/images/plugins/yith-woocommerce-wishlist.jpg'
                    ),
                    array(
                        'name'               => 'YITH Woocommerce Compare', // The plugin name
                        'slug'               => 'yith-woocommerce-compare', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                        'thumb'              => get_template_directory_uri() . '/assets/images/plugins/yith-woocommerce-compare.jpg'
                    ),
                    array(
                        'name'               => 'Contact Form 7', // The plugin name
                        'slug'               => 'contact-form-7', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                        'thumb'              => get_template_directory_uri() . '/assets/images/plugins/contact-form-7.jpg'
                    ),       
                    array(
                        'name'               => 'WP Instagram Widget', // The plugin name
                        'slug'               => 'wp-instagram-widget', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                        'thumb'              => get_template_directory_uri() . '/assets/images/plugins/wp-instagram-widget.jpg'
                    ),
                );
            }

            /*
             * Array of configuration settings. Amend each line as needed.
             * If you want the default strings to be available under your own theme domain,
             * leave the strings uncommented.
             * Some of the strings are added into a sprintf, so see the comments at the
             * end of each line for what each argument will be.
             */

            // Change this to your theme text domain, used for internationalising strings
            $config = array(
                'domain'       => 'yolo-bestruct',
                'id'           => 'g_theme_id',                 // Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',                      // Default absolute path to pre-packaged plugins.
                'menu'         => 'install-required-plugins', // Menu slug.
                'parent_slug'  => 'themes.php',            // Parent menu slug.
                'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
                'has_notices'  => true,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => false,                   // Automatically activate plugins after installation or not.
                'message'      => '',                      // Message to output right before the plugins table.
                'strings'      => array(
                    'page_title'                      => esc_html( 'Install Required Plugins', 'yolo-bestruct' ),
                    'menu_title'                      => esc_html( 'Install Plugins', 'yolo-bestruct' ),
                    'installing'                      => esc_html( 'Installing Plugin: %s', 'yolo-bestruct' ), // %s = plugin name.
                    'oops'                            => esc_html( 'Something went wrong with the plugin API.', 'yolo-bestruct' ),
                    'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'yolo-bestruct' ), // %1$s = plugin name(s).
                    'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'yolo-bestruct' ), // %1$s = plugin name(s).
                    'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'yolo-bestruct' ), // %1$s = plugin name(s).
                    'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'yolo-bestruct' ), // %1$s = plugin name(s).
                    'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'yolo-bestruct' ), // %1$s = plugin name(s).
                    'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'yolo-bestruct' ), // %1$s = plugin name(s).
                    'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'yolo-bestruct' ), // %1$s = plugin name(s).
                    'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'yolo-bestruct' ), // %1$s = plugin name(s).
                    'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'yolo-bestruct' ),
                    'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'yolo-bestruct' ),
                    'return'                          => esc_html( 'Return to Required Plugins Installer', 'yolo-bestruct' ),
                    'plugin_activated'                => esc_html( 'Plugin activated successfully.', 'yolo-bestruct' ),
                    'complete'                        => esc_html( 'All plugins installed and activated successfully. %s', 'yolo-bestruct' ), // %s = dashboard link.
                    'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
                )
            );

            tgmpa(self::$plugins, $config );

        }
      
        /**
         * Send request update plugin
         *
         * @package     Bestruct/Plugins
         * @author      JAMES <luyentv@vietbrain.com>
         * @version     1.0
         */
        public function yolo_updater_plugin_load() {

            if ( !current_user_can( 'update_plugins' ) ) {
                return;
            }

            if ( !$this->yolo_get_purchase() ) {
                return;
            }
            
            if ( ! class_exists( 'TGM_Updater' ) ) {
                require_once get_template_directory() . '/framework/includes/yolo-dash/tgmpa/class-tgm-updater.php';
            }

            /**
             * Check version plugin Visual Composer
             */
            if( self::yolo_is_plugin_active( 'js_composer/js_composer.php' ) ) {
                
                $plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'js_composer/js_composer.php');

                $data_plugin_update = array(
                    'plugin_name' => esc_html__( 'WPBakery Visual Composer', 'yolo-bestruct' ),
                    'plugin_slug' => 'js_composer',
                    'plugin_path' => 'js_composer/js_composer.php',
                    'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'yolo-bestruct',
                    'remote_url'  => esc_url( 'http://update.yolotheme.com/plugins/js_composer.json' ),
                    'version'     => $plugin_data['Version'],
                    'key'         => ''
                );

                $tgm_updater = new TGM_Updater( $data_plugin_update );

            }
            /**
             * Check version plugin Yolo Bestruct Framework
             */
            if( self::yolo_is_plugin_active( 'yolo-bestruct-framework/yolo-bestruct-framework.php' ) ) {
                
                $plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'yolo-bestruct-framework/yolo-bestruct-framework.php');
                
                $data_plugin_update = array(
                    'plugin_name' => esc_html__( 'Yolo Sofani Framework', 'yolo-bestruct' ),
                    'plugin_slug' => 'yolo-bestruct-framework',
                    'plugin_path' => 'yolo-bestruct-framework/yolo-bestruct-framework.php',
                    'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'yolo-bestruct-framework',
                    'remote_url'  => esc_url( 'http://update.yolotheme.com/plugins/yolo-bestruct-framework.json' ),
                    'version'     => $plugin_data['Version'],
                    'key'         => ''
                );

                $tgm_updater = new TGM_Updater( $data_plugin_update );

            }
            /**
             * Check version plugin Revolution Slider
             */
            if( self::yolo_is_plugin_active( 'revslider/revslider.php' ) ) {
                
                $plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'revslider/revslider.php');
                $data_plugin_update = array(
                    'plugin_name' => esc_html__( 'Revolution Slider', 'yolo-bestruct' ),
                    'plugin_slug' => 'revslider',
                    'plugin_path' => 'revslider/revslider.php',
                    'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'revslider',
                    'remote_url'  => esc_url( 'http://update.yolotheme.com/plugins/revslider.json' ),
                    'version'     => $plugin_data['Version'],
                    'key'         => ''
                );

                $tgm_updater = new TGM_Updater( $data_plugin_update );

            }
        }

        /**
         * Update Add-On/Plugin
         */
        public static function updater_plugin(){

            // Verify nonce
            if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'yolo-updater-plugin' ) ) {
                wp_send_json_error( 'NONCE_EXPIRED' );
            }

            // Verify request variables.
            if( !isset( $_POST['plugin'] ) || empty( $_POST['plugin'] ) ) {
                wp_send_json_error( esc_html__( 'No plugin specified.', 'yolo-bestruct' ) );
            }

            // Disable error reporting.
            error_reporting( 0 );

            // Initialize TGM Plugin Activation
            self::yolo_register_required_plugins();

            $tgmpa = TGM_Plugin_Activation::get_instance();

            // Emulate request variables to execute bulk install acrion of TGM Plugin Activation.
            $_GET['page'            ] = $_POST['page'            ] = $_REQUEST['page'            ] = $tgmpa->menu;
            $_GET['tgmpa-page'      ] = $_POST['tgmpa-page'      ] = $_REQUEST['tgmpa-page'      ] = $tgmpa->menu;
            $_GET['plugin_status'   ] = $_POST['plugin_status'   ] = $_REQUEST['plugin_status'   ] = 'all';
            $_GET['_wpnonce'        ] = $_POST['_wpnonce'        ] = $_REQUEST['_wpnonce'        ] = wp_create_nonce( 'bulk-plugins' );
            $_GET['_wp_http_referer'] = $_POST['_wp_http_referer'] = $_REQUEST['_wp_http_referer'] = admin_url( "themes.php?page={$tgmpa->menu}" );
            $_GET['action'          ] = $_POST['action'          ] = $_REQUEST['action'          ] = 'tgmpa-bulk-update';
            $_GET['plugin'          ] = $_POST['plugin'          ] = $_REQUEST['plugin'          ] = ( array ) $_POST[ 'plugin' ];

            // Let TGM Plugin Activation install plugins.
            if ( ! class_exists( 'TGMPA_Bulk_Installer' ) ) {
                tgmpa_load_bulk_installer();
            }

            $tgmpa->install_plugins_page();

            // Send response.
            wp_send_json_success();

        }

        /**
         * Install Add-On/Plugin
         */
        public static function install_plugin() {

            // Verify nonce
            if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'yolo-install-plugin' ) ) {
                wp_send_json_error( 'NONCE_EXPIRED' );
            }

            // Verify request variables.
            if( !isset( $_POST['plugin'] ) || empty( $_POST['plugin'] ) ) {
                wp_send_json_error( esc_html__( 'No plugin specified.', 'yolo-bestruct' ) );
            }

            // Disable error reporting.
            error_reporting( 0 );

            // Initialize TGM Plugin Activation
            self::yolo_register_required_plugins();

            $tgmpa = TGM_Plugin_Activation::get_instance();

            // Emulate request variables to execute bulk install acrion of TGM Plugin Activation.
            $_GET['page'            ] = $_POST['page'            ] = $_REQUEST['page'            ] = $tgmpa->menu;
            $_GET['tgmpa-page'      ] = $_POST['tgmpa-page'      ] = $_REQUEST['tgmpa-page'      ] = $tgmpa->menu;
            $_GET['plugin_status'   ] = $_POST['plugin_status'   ] = $_REQUEST['plugin_status'   ] = 'all';
            $_GET['_wpnonce'        ] = $_POST['_wpnonce'        ] = $_REQUEST['_wpnonce'        ] = wp_create_nonce( 'bulk-plugins' );
            $_GET['_wp_http_referer'] = $_POST['_wp_http_referer'] = $_REQUEST['_wp_http_referer'] = admin_url( "themes.php?page={$tgmpa->menu}" );
            $_GET['action'          ] = $_POST['action'          ] = $_REQUEST['action'          ] = 'tgmpa-bulk-install';
            $_GET['plugin'          ] = $_POST['plugin'          ] = $_REQUEST['plugin'          ] = ( array ) $_POST[ 'plugin' ];

            $plugins = array();
            foreach ( ( array ) $_POST[ 'plugin' ] as $plugin ) {

                if( $path = self::yolo_bestruct_get_plugin_path( $plugin ) ) {

                    $result = activate_plugin( $path );

                    if( is_wp_error( $result ) ) {
                        $activation_fails[] = self::$plugins[ $plugin ][ 'name' ];
                    }

                    if( 'js_composer' == $plugin ) {
                        delete_transient( '_vc_page_welcome_redirect' );
                    }

                } else {

                    $plugins[] = $plugin;

                }

            }

            // Increase download timeout.
            function yolo_install_plugin_increase_download_timeout( $timeout ) {
                return HOUR_IN_SECONDS;
            }

            add_filter( 'http_request_timeout', 'yolo_install_plugin_increase_download_timeout' );

            if( count($plugins) > 0) :

                // Let TGM Plugin Activation install plugins.
                if ( ! class_exists( 'TGMPA_Bulk_Installer' ) ) {
                    tgmpa_load_bulk_installer();
                }

                $tgmpa->install_plugins_page();

                // Activate plugin after that install
                foreach ( $plugins as $plugin ) {

                    if ( $path = self::yolo_bestruct_get_plugin_path( $plugin ) ) {

                        $result = activate_plugin( $path );

                        if ( is_wp_error( $result ) ) {
                            $activation_fails[] = self::$plugins[ $plugin ]['name'];
                        }

                        // Disable Visual Composer welcome page redirection.
                        if ( 'js_composer' == $plugin ) {
                            delete_transient( '_vc_page_welcome_redirect' );
                        }

                    } else {

                        $installation_fails[] = self::$plugins[ $plugin ]['name'];

                    }

                }
            endif;

            // Send response.
            if ( isset( $activation_fails ) ) {
                wp_send_json_error(
                    ( count( $activation_fails ) > 1 )
                    ? sprintf( __( 'Failed to activate following plugins: %s', 'yolo-bestruct' ), implode( ', ', $activation_fails ) )
                    : sprintf( __( 'Failed to activate %s plugin', 'yolo-bestruct' ), current( $activation_fails ) )
                );
            }

            elseif ( isset( $installation_fails ) ) {
                wp_send_json_error(
                    ( count( $installation_fails ) > 1 )
                    ? sprintf( __( 'Failed to install following plugins: %s', 'yolo-bestruct' ), implode( ', ', $installation_fails ) )
                    : sprintf( __( 'Failed to install %s plugin. Please enter your Purchase Code first.', 'yolo-bestruct' ), current( $installation_fails ) )
                );
            }
            // Send response.
            wp_send_json_success();

        }

        /**
         * Uninstall Plugin
         */
        public static function deactivate_plugin() {

            // Verify nonce.
            if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'yolo-deactivate-plugin' ) ) {
                wp_send_json_error( esc_html__( 'Nonce verification failed. This might due to your working session has been expired. Please reload the page to renew your working session.', 'yolo-bestruct' ) );
            }

            // Verify request variables.
            if ( ! isset( $_POST[ 'plugin' ] ) || empty( $_POST[ 'plugin' ] ) ) {
                wp_send_json_error( __( 'No plugin specified.', 'yolo-bestruct' ) );
            }

            // Disable error reporting.
            error_reporting( 0 );

            // Deactivate plugin.
            foreach ( ( array ) $_POST['plugin'] as $plugin ) {

                $path = self::yolo_bestruct_get_plugin_path( $plugin );

                if ( $path ) {

                    if ( is_plugin_active( $path ) ) {

                        // Deactivate the plugin first.
                        deactivate_plugins( $path );

                    }

                }

            }

            // Send response.
            wp_send_json_success();

        }

        /**
         * Uninstall Plugin
         */
        public static function uninstall_plugin() {

            // Verify nonce.
            if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'yolo-uninstall-plugin' ) ) {
                wp_send_json_error( esc_html__( 'Nonce verification failed. This might due to your working session has been expired. Please reload the page to renew your working session.', 'yolo-bestruct' ) );
            }

            // Verify request variables.
            if ( ! isset( $_POST[ 'plugin' ] ) || empty( $_POST[ 'plugin' ] ) ) {
                wp_send_json_error( __( 'No plugin specified.', 'yolo-bestruct' ) );
            }

            // Disable error reporting.
            error_reporting( 0 );

            // Uninstall plugin.
            foreach ( ( array ) $_POST['plugin'] as $plugin ) {

                $path = self::yolo_bestruct_get_plugin_path( $plugin );

                if ( $path ) {

                    if ( is_plugin_active( $path ) ) {

                        // Deactivate the plugin first.
                        deactivate_plugins( $path );

                    }

                    // Let WordPress uninstall the plugin.
                    uninstall_plugin( $path );

                    // If the plugin directory still exists, remove it.
                    if ( @is_file( WP_PLUGIN_DIR . '/' . $path ) ) {

                        WP_Filesystem();
                        global $wp_filesystem;
                        $wp_filesystem->rmdir( WP_PLUGIN_DIR . '/' . current( explode( '/', $path ) ), true );

                    }

                }

            }

            // Send response.
            wp_send_json_success();
        }

        // endif;
        /**
         * Send request validate to server
         *
         * @package     Bestruct/Plugins
         * @author      JAMES <luyentv@vietbrain.com>
         * @version     1.0
         */
       
        public function yolo_upgrader_pre_download( $reply, $package, $upgrader ) {

            if( strpos( $package, 'yolotheme.com' ) !== false ) {

                if( ! $this->yolo_get_purchase() ) {
                    return new WP_Error( 
                        'yolo_purchase_empty', 
                        sprintf(
                            wp_kses(
                                __( 'Purchase code verification failed. <a href="%s">Enter Purchase Code</a>', 'yolo-bestruct'), 
                                array( 'a' => array( 'href' => array() ), 'Bestruct' )
                            ),
                            esc_url( admin_url( 'admin.php?page=yolo-options#verify' ) ) 
                        )
                    );
                }

                $data_request = wp_remote_get(
                    add_query_arg(
                        array(
                            'code'           => $this->yolo_get_purchase(), 
                            'site_url'       => get_site_url(), 
                            'package'        => 'yolo-bestruct',
                            'install-plugin' => true
                        ), 
                        'http://update.yolotheme.com'
                    ), 
                    array( 'timeout' => 60 )
                );
                
                if( is_wp_error( $data_request ) ) {
                    return new WP_Error(
                        'yolo_connection_failed', 
                        esc_html__( 'Some troubles with connecting to YoloTheme server.', 'yolo-bestruct' )
                    );
                }
                $rp_data = json_decode( $data_request['body'], true );

                if( !( is_array( $rp_data ) && isset( $rp_data['status'] ) && $rp_data['status'] ) ) {
                    return new WP_Error(
                        'yolo_strater_purchase_error', 
                        sprintf(
                            wp_kses(
                                __( 'Purchase code verification failed. <a href="%s">Enter Purchase Code</a>', 'yolo-bestruct'), 
                                array( 'a' => array( 'href' => array() ) )
                            ), 
                            esc_url( admin_url( 'admin.php?page=yolo-options#verify' ) )
                        )
                    );
                }
            }

            return $reply;

        }

        

    /**
     * Remove notice update visual composer
     *
     * @package     Bestruct/Plugins
     * @author      JAMES <luyentv@vietbrain.com>
     * @version     1.0
     */

        
        public function yolo_enable_vc_auto_theme_update() {

            if( function_exists('vc_updater') ) {
                $vc_updater = vc_updater();
                remove_filter( 'upgrader_pre_download', array( $vc_updater, 'preUpgradeFilter' ), 10 );
                if( function_exists( 'vc_license' ) ) {
                    if( !vc_license()->isActivated() ) {
                        remove_filter( 'pre_set_site_transient_update_plugins', array( $vc_updater->updateManager(), 'check_update' ), 10 );
                    }
                }
                remove_filter( 'admin_notices', array( vc_license(), 'adminNoticeLicenseActivation' ) );
            }

        }
    }
    new Yolo_Install_Plugin;
endif;