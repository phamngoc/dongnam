<?php
/**
 *
 *    Plugin Name: Yolo Bestruct Framework
 *    Plugin URI: http://yolotheme.com
 *    Description: The Yolo Bestruct Framework plugin.
 *    Version: 1.1.5
 *    Author: YoloTheme
 *    Author URI: http://yolotheme.com
 *
 *    Text Domain: yolo-bestruct
 *    Domain Path: /languages/
 *
 * @package Yolo Bestruct Framework
 * @category Core Plugin
 * @author YoloTheme
 *
 **/

if (!defined('ABSPATH')) {
	exit; // Exit if access directly
}
/*================================================
YOLO LIMIT WORDS SHORTCODE
================================================== */


if( ! function_exists('yolo_limit_words_pg') ) {
    function yolo_limit_words_pg($string, $word_limit) {
        $words = preg_split('/\s+/', $string);

        return implode(" ",array_splice($words,0,$word_limit));
    }
}
if ( ! class_exists( 'Yolo_BestructFramework' ) ) {
    class Yolo_BestructFramework {
    	protected $loader;

    	protected $prefix;

    	protected $version;

        function __construct() {
        	$this->version = '1.0.0';
        	$this->prefix = 'yolo-yolo-bestruct-framework';
        	$this->define_constants();
            $this->include_files();
            $this->define_hook();
            $this->load_plugin_scripts();
        }

        function define_constants() {
        	if( !defined( 'PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR' ) ) {
        		define( 'PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR', plugin_dir_path(__FILE__) );
        	}
            if( !defined( 'PLUGIN_YOLO_BESTRUCT_FRAMEWORK_URL' ) ) {
                define( 'PLUGIN_YOLO_BESTRUCT_FRAMEWORK_URL', plugin_dir_url( __FILE__ ) );
            }
            if( !defined( 'PLUGIN_YOLO_BESTRUCT_FRAMEWORK_FILE' ) ) {
                define( 'PLUGIN_YOLO_BESTRUCT_FRAMEWORK_FILE', __FILE__ );
            }
        	if( !defined( 'PLUGIN_YOLO_BESTRUCT_FRAMEWORK_NAME' ) ) {
        		define( 'PLUGIN_YOLO_BESTRUCT_FRAMEWORK_NAME', 'yolo-bestruct-framework' );
        	}
        	if( !defined( 'YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY' ) ) {
        		define( 'YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY', esc_html__( 'Bestruct Shortcodes', 'yolo-bestruct' ) );
        	}
        }

        function include_files() {
        	require_once( 'includes/yolo_framework_loader.php' );
        	$this->loader = new Yolo_BestructFramework_Loader();

            if ( !class_exists('WPAlchemy_MetaBox') ) {
                include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/MetaBox.php' );
            }

        	require_once( 'admin/yolo_framework_admin.php' );
            require_once( 'includes/posttypes/posttypes.php' );
            require_once( 'includes/shortcodes/shortcodes.php' );
            require_once( 'includes/widgets/widgets.php' );
            require_once( 'includes/term-meta/index.php' ); // Add term meta to product attributes
            require_once( 'includes/importer/yolo-setup-install.php' );
        }

        public function load_plugin_textdomain() {
            load_plugin_textdomain( 'yolo-bestruct', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'  );
		}
        function load_plugin_scripts() {
            add_action('wp_enqueue_scripts', array($this,'yolo_enqueue_plugin_scripts'));
        }
        function yolo_enqueue_plugin_scripts(){
            wp_enqueue_style( 'yolo-framework-css', plugins_url() . '/yolo-bestruct-framework/assets/css/yolo-shortcode.css', array() );
            // CSS Owl Carousel
            wp_register_style('owl-carousel', plugins_url() . '/yolo-bestruct-framework/assets/plugins/owl-carousel/owl.carousel.css');
            // CSS Slide Pro
            wp_register_style('slide-pro', plugins_url() . '/yolo-bestruct-framework/assets/plugins/slidePro/slider-pro.min.css');
            // CSS Slick
            wp_register_style('slick', plugins_url() . '/yolo-bestruct-framework/assets/plugins/slick/slick.css');
            // CSS prettyPhoto
            wp_register_style('prettyPhoto', plugins_url() . '/yolo-bestruct-framework/assets/plugins/prettyPhoto/css/prettyPhoto.min.css');
            // CSS Ladda
            wp_register_style('ladda-css', plugins_url() . '/yolo-bestruct-framework/assets/plugins/ladda/dist/ladda-themeless.min.css', array(),false);
           /*------------------ Register Library ----------------*/
            // CountDown
            wp_register_script('countdown', plugins_url() . '/yolo-bestruct-framework/assets/plugins/countdown/jquery.countdown.js',array('jquery'), null, true);
            wp_register_script('jquery-knob', plugins_url() . '/yolo-bestruct-framework/assets/plugins/countdown/jquery.knob.min.js',array('jquery'), null, true);
            wp_register_script('jquery-ba-throttle-debounce', plugins_url() . '/yolo-bestruct-framework/assets/plugins/countdown/jquery.ba-throttle-debounce.min.js',array(), null, true);
            wp_register_script('redcountdown', plugins_url() . '/yolo-bestruct-framework/assets/plugins/countdown/jquery.redcountdown.js',array('jquery-knob','jquery-ba-throttle-debounce'), null, true);
            // jQuery Appear
            wp_register_script('jquery-appear', plugins_url() . '/yolo-bestruct-framework/assets/plugins/counter/jquery.appear.js', array('jquery'),null, true);
            // Counter
            wp_register_script('jquery-counto', plugins_url() . '/yolo-bestruct-framework/assets/plugins/counter/jquery.countTo.js', array('jquery'),null, true);
            // Owl Carousel
            wp_register_script('owl-carousel', plugins_url() . '/yolo-bestruct-framework/assets/plugins/owl-carousel/owl.carousel.min.js', array('jquery'),null, true);
            // Isotope
            wp_register_script('isotope', plugins_url() . '/yolo-bestruct-framework/assets/plugins/isotope/isotope.pkgd.min.js', array('jquery'),null, true);
            // Packery
            wp_register_script('packery-mode', plugins_url() . '/yolo-bestruct-framework/assets/plugins/isotope/packery-mode.pkgd.min.js', array(),null, true);
            // Hoverdir
            wp_register_script('jquery-hoverdir', plugins_url() . '/yolo-bestruct-framework/assets/plugins/hoverdir/jquery.hoverdir.js', array('jquery'),null, true);
            // SlidePro
            wp_register_script('slide-pro', plugins_url() . '/yolo-bestruct-framework/assets/plugins/slidePro/jquery.sliderPro.min.js', array('jquery'),null, true);
            // Slick 
            wp_register_script('slick', plugins_url() . '/yolo-bestruct-framework/assets/plugins/slick/slick.min.js', array('jquery'), null, true);
             // PrettyPhoto 
            wp_register_script('prettyPhoto', plugins_url() . '/yolo-bestruct-framework/assets/plugins/prettyPhoto/js/jquery.prettyPhoto.js', array('jquery'), null, true);
            // Ladda
            wp_register_script('ladda-spin', plugins_url() . '/yolo-bestruct-framework/assets/plugins/ladda/dist/spin.min.js', false, true);
            wp_register_script('ladda', plugins_url() . '/yolo-bestruct-framework/assets/plugins/ladda/dist/ladda.min.js', false, true);
            // Main JS
            wp_enqueue_script( 'yolo-framework-js', plugins_url().'/yolo-bestruct-framework/assets/js/yolo-framework.js', array(), null, true );
            $sc_countdown = array(
                'days'           => esc_html__( 'Day', 'yolo-bestruct' ),
                'hours'          => esc_html__( 'Hours', 'yolo-bestruct' ),
                'minutes'        => esc_html__( 'Minutes', 'yolo-bestruct' ),
                'seconds'        => esc_html__( 'Second', 'yolo-bestruct' )
            );
            wp_localize_script('yolo-framework-js', 'sc_countdown', $sc_countdown);
        }
		private function define_hook() {
			/*set locale*/
			$this->loader->add_action( 'plugins_loaded', $this, 'load_plugin_textdomain' );

			/*admin*/
			$plugin_admin = new Yolo_BestructFramework_Admin( $this->get_prefix(), $this->get_version() );

			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		}

		public function get_version() {
			return $this->version;
		}

		public function get_prefix() {
			return $this->prefix;
		}

		public function run() {
			$this->loader->run();
		}

    }

    // Run Yolo_BestructFramework
    if( !function_exists( 'init_yolo_bestruct_framework' ) ) {
    	function init_yolo_bestruct_framework() {
    		$yoloBestructFramework = new Yolo_BestructFramework();
    		$yoloBestructFramework->run();
    	}
    }

    init_yolo_bestruct_framework();
}
