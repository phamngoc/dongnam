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

/*================================================
LOAD CSS
================================================== */
if (!function_exists('yolo_enqueue_styles')) {
    function yolo_enqueue_styles()
    {
        global $yolo_bestruct_options;
        $min_suffix   = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        /* Bootstrap */
        $url_bootstrap = get_template_directory_uri() . '/assets/plugins/bootstrap/css/bootstrap.min.css';
        wp_enqueue_style('bootstrap', $url_bootstrap, array(), null);

        /* Font-awesome */
        $url_font_awesome = get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome.min.css';
        wp_enqueue_style('font-awesome', $url_font_awesome, array(), null);
        /* pe-icon-7-stroke */
        wp_enqueue_style('pe-icon-7-stroke', get_template_directory_uri() . '/assets/plugins/pe-icon-7-stroke/css/styles' . $min_suffix . '.css', array(), null);
        /* owl-carousel */
        wp_register_style('owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel' . $min_suffix . '.css', array(), null);
        wp_register_style('owl-carousel-theme', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.theme' . $min_suffix . '.css', array(), null);
        wp_register_style('owl-transitions', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.transitions' . $min_suffix . '.css', array(), null);
        /* prettyPhoto */
        wp_register_style('prettyPhoto', get_template_directory_uri() . '/assets/plugins/prettyPhoto/css/prettyPhoto' . $min_suffix . '.css', array(), null);
        /* Magnific Popup */
        if (isset($yolo_bestruct_options['show_popup']) && ($yolo_bestruct_options['show_popup'] != false)) {
            wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/plugins/magnificPopup/css/magnific-popup' . $min_suffix . '.css', array(), null);
        }
        /* Custom Scrollbar */
        wp_register_style('custom-scrollbar', get_template_directory_uri() . '/assets/plugins/customscroll/jquery.mCustomScrollbar.min.css', array(), null);

        /* Theme CSS */
        wp_enqueue_style('yolo-framework-style', get_template_directory_uri() . '/assets/css/yolo.css', array(), null);
        /* Custom Style*/
        // wp_enqueue_style('all-custom-style', get_template_directory_uri() . '/assets/css/custom-style.css', array(), null);
        // Custom style will be build in upload/yolo-custom-css
        if( is_file( yolo_upload_dir() . '/custom-style.css' ) ) {
            wp_enqueue_style( 'all-custom-style', yolo_upload_url() . '/custom-style.css', array(), NULL );
        }

        /* VC Customize */
        wp_enqueue_style('yolo-framework-vc-customize', get_template_directory_uri() . '/assets/vc-extend/css/vc-customize' . $min_suffix . '.css', array(), null);
    }
    add_action('wp_enqueue_scripts', 'yolo_enqueue_styles');
}

/*================================================
LOAD JS
================================================== */
if (!function_exists('yolo_enqueue_script')) {
    function yolo_enqueue_script()
    {
        global $yolo_bestruct_options;
        $min_suffix      = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        $min_suffix_path = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : 'min/';
        /* Comments */
        if (is_single()){
            wp_enqueue_script('comment-reply');
        }
        /* Plugins as sticky, onepage, carousel,... */
        // wp_enqueue_script('yolo_framework_plugins', get_template_directory_uri() . '/assets/js/' . $min_suffix_path . 'yolo-plugin' . $min_suffix . '.js', array(), null, true);
        // Mega menu
        wp_register_script('megamenu-js', get_template_directory_uri() . '/framework/core/megamenu/assets/js/megamenu' . $min_suffix . '.js', array(), null, true);
        wp_enqueue_script('megamenu-js');
        /* Shop filters */
        wp_register_script('yolo_shop_filters', get_template_directory_uri() . '/assets/js/' . $min_suffix_path . 'yolo-shop-filters' . $min_suffix . '.js', array(), null, true);
        /* Custom add-to-cart-variation */
        wp_enqueue_script('wc-add-to-cart-variation'); // Use this to fix add-to-cart-variation at home page
        wp_enqueue_script('yolo_add_to_cart_variation', get_template_directory_uri() . '/assets/js/' . $min_suffix_path . 'yolo-add-to-cart-variation' . $min_suffix . '.js', array(), null, true);

        wp_enqueue_script('yolo_framework_app', get_template_directory_uri() . '/assets/js/' . $min_suffix_path . 'yolo-main' . $min_suffix . '.js', array(), null, true);
        wp_register_script('jquery-cookie', get_template_directory_uri() . '/assets/plugins/jquery-cookie/jquery.cookie.min.js', array(), null, true);
        /* Load Bootstrap */
        $url_bootstrap = get_template_directory_uri() . '/assets/plugins/bootstrap/js/bootstrap.min.js';
        wp_enqueue_script('bootstrap', $url_bootstrap, array('jquery'), null, true);
        /*Isotope*/
        wp_register_script('isotope', get_template_directory_uri() . '/assets/plugins/isotope/isotope.pkgd.min.js', array('jquery'), null, true);

        // Import Library
        wp_register_script('sticky-header', get_template_directory_uri() . '/assets/plugins/stickyHeader/sticky-custom.js', array('jquery'), null, true);
        
        wp_register_script('jquery-magnific-popup', get_template_directory_uri() . '/assets/plugins/magnificPopup/js/jquery.magnific-popup.min.js', array('jquery'), null, true);
        
        wp_register_script('modernizr', get_template_directory_uri() . '/assets/plugins/modernizr/modernizr.min.js', array('jquery'), null, true);
        
        wp_register_script('classie', get_template_directory_uri() . '/assets/plugins/dialog-effects/js/classie.js', array(), null, true);

        wp_register_script('dialogFx', get_template_directory_uri() . '/assets/plugins/dialog-effects/js/dialogFx.js', array('modernizr','classie'), null, true);
        
        wp_register_script('owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel.min.js', array('jquery'), null, true);
        wp_enqueue_script('imagesloaded', get_template_directory_uri() . '/assets/plugins/imagesloaded/imagesloaded.pkgd.min.js', array('jquery'), null, true);
        wp_register_script('jquery-infinitescroll', get_template_directory_uri() . '/assets/plugins/infinitescroll/jquery.infinitescroll.min.js', array('jquery'), null, true);
        wp_register_script('stellar', get_template_directory_uri() . '/assets/plugins/stellar/stellar.min.js', array('jquery'), null, true);
        
        wp_register_script('jquery-waypoints', get_template_directory_uri() . '/assets/plugins/waypoints/jquery.waypoints.min.js', array('jquery'), null, true);
        wp_enqueue_script('matchmedia', get_template_directory_uri() . '/assets/plugins/matchmedia/matchmedia.js', array('jquery'), null, true);
        
        /* Custom Scrollbar */
        wp_register_script('custom-scrollbar', get_template_directory_uri() . '/assets/plugins/customscroll/jquery.mCustomScrollbar.min.js', array('jquery'), null,true);
        wp_register_script('prettyPhoto', get_template_directory_uri() . '/assets/plugins/prettyPhoto/js/jquery.prettyPhoto.js', array('jquery'), null, true);
        // wp_register_script('sticky-kit', get_template_directory_uri() . '/assets/plugins/sticky-kit/sticky-kit.js', array('jquery'), null, true);

        /* Localize the script with new data */
        $translation_array = array(
            'product_compare'        => esc_html__('Compare', 'yolo-bestruct'),
            'product_wishList'       => esc_html__('WishList', 'yolo-bestruct'),
            'product_wishList_added' => esc_html__('Browse WishList', 'yolo-bestruct'),
            'product_quickview'      => esc_html__('Quick View', 'yolo-bestruct'),
            'product_addtocart'      => esc_html__('Add To Cart', 'yolo-bestruct'),
            'enter_keyword'          => esc_html__('Please enter keyword to search', 'yolo-bestruct'),
        );
        wp_localize_script('yolo_framework_app', 'yolo_framework_constant', $translation_array);
        wp_localize_script('yolo_framework_app', 'yolo_framework_ajax_url', get_site_url() . '/wp-admin/admin-ajax.php?activate-multi=true');
        wp_localize_script('yolo_framework_app', 'yolo_framework_theme_url', get_template_directory_uri());
        wp_localize_script('yolo_framework_app', 'yolo_framework_site_url', site_url());

    }
    add_action('wp_enqueue_scripts', 'yolo_enqueue_script');
}
/* VC FOOTER STYLE
===================================================== */
if(!function_exists('yolo_footer_styles')) {
    function yolo_footer_styles() {

        global $yolo_bestruct_options,$yolo_footer_id;

        $prefix = 'yolo_';
        $post_id   = get_the_ID();
        if( $yolo_footer_id == '' && isset($yolo_bestruct_options['footer'])) {
            $yolo_footer_id = $yolo_bestruct_options['footer'];
        }
        if ( $yolo_footer_id && $post_id != $yolo_footer_id ) {
           $shortcodes_custom_css = get_post_meta( $yolo_footer_id, '_wpb_shortcodes_custom_css', true );
           if ( ! empty( $shortcodes_custom_css ) ) {
                $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
                    wp_add_inline_style( 'all-custom-style', $shortcodes_custom_css );
           }
        }
        
    }
    add_action( 'wp_enqueue_scripts', 'yolo_footer_styles' );
}
/* CUSTOM CSS OUTPUT
================================================== */
if (!function_exists('yolo_enqueue_custom_css')) {
    function yolo_enqueue_custom_css()
    {
        global $yolo_bestruct_options;
        $custom_css   = $yolo_bestruct_options['custom_css'];
        if (!empty($custom_css)) {
            $custom_css = wp_strip_all_tags($custom_css);
            wp_add_inline_style('all-custom-style', $custom_css);
        }
    }
    add_action('wp_enqueue_scripts', 'yolo_enqueue_custom_css');
}
/* CUSTOM JS OUTPUT
================================================== */
if (!function_exists('yolo_enqueue_custom_script')) {
    function yolo_enqueue_custom_script()
    {
        global $yolo_bestruct_options;
        $custom_js    = $yolo_bestruct_options['custom_js'];
        if (!empty($custom_js)) {
            echo sprintf('<script type="text/javascript">%s</script>', $custom_js);
        }
    }
    add_action('wp_footer', 'yolo_enqueue_custom_script');
}
