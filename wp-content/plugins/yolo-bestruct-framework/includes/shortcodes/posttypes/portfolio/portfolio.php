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

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Yolo_Framework_Shortcode_Portfolio') ) {
    class Yolo_Framework_Shortcode_Portfolio {
        function __construct() {
            add_shortcode('yolo_portfolio', array($this, 'yolo_portfolio_shortcode' ));
            add_filter('single_template', array($this, 'get_portfolio_single_template')); // Load custom template: https://codex.wordpress.org/Plugin_API/Filter_Reference/single_template
            // add_action('wp_enqueue_scripts', array($this, 'portfolio_front_scripts'),15); // Fix masonry style
            $this->includes();
        }

        function portfolio_front_scripts() {

            wp_enqueue_style('prettyPhoto');
            wp_enqueue_script('prettyPhoto');
            wp_enqueue_script('isotope');
            wp_enqueue_style('ladda-css');
            wp_enqueue_script('ladda-spin');
            wp_enqueue_script('ladda');
            wp_enqueue_script('jquery-hoverdir');
        }

        private function includes() {
            include_once( 'utils/ajax-action.php' );
            include_once( 'utils/utils.php' );
        }

        function yolo_portfolio_shortcode($atts) {
            $this->portfolio_front_scripts();
            $portfolio_thumbnail = $portfolio_title = $overlay_style = $overlay_effect = $hover_dir = $column = $data_source = $category = $portfolio_ids = $portfolio_tag = $show_filter = $filter_by = $show_pagging = $item = $order = $padding = $image_size
              = $current_page = $data_section_id = $el_class = $yolo_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'portfolio_thumbnail' => 'default',
                'portfolio_title'     => '',
                'column'              => '4',
                'overlay_style'       => 'icon',
                'overlay_effect'       => 'effect_1',
                'hover_dir'           => 'on',
                'data_source'         => '',
                'category'            => '',
                'portfolio_ids'       => '',
                'portfolio_tag'       => '',
                'show_filter'         => '',
                'filter_by'           => 'tag',
                'show_pagging'        => '',
                'item'                => '4',// number of item
                'order'               => 'DESC',
                'padding'             => '',
                'image_size'          => '',
                'el_class'            => '',
                'css_animation'       => '',
                'duration'            => '',
                'delay'               => '',               
                'current_page'        => '1',
                'data_section_id'     => '',
                'filter_style'        => 'style_1',
            ), $atts));
            if ( $item == '' ) {
                $offset        = 0;
                $post_per_page = -1;
            } else {
                $post_per_page = $item;
                $offset        = ($current_page - 1) * $item;
            }
            $overlay_align = 'hover-align-center';

            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_BestructFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_BestructFramework_Shortcodes::yolo_get_style_animation($duration, $delay);

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            switch ($portfolio_thumbnail) {
                case 'squared':
                    $template_path = $plugin_path . '/templates/portfolio-squared.php';
                    break;
                case 'landscape':
                    $template_path = $plugin_path . '/templates/portfolio-landscape.php';
                    break;
                case 'portrait':
                    $template_path = $plugin_path . '/templates/portfolio-portrait.php';
                    break;
                case 'packery':
                    $template_path = $plugin_path . '/templates/portfolio-packery.php';
                    break;
                case 'masonry':
                    $template_path = $plugin_path . '/templates/portfolio-masonry.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/portfolio-default.php';
            }
            ob_start();

            include($template_path);
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }

        function get_portfolio_single_template($single) {
            global $post;
            /* Checks for single template by post type */
            if ($post->post_type == 'yolo_portfolio') {
                $plugin_path   = untrailingslashit( plugin_dir_path(__FILE__) );
                $template_path = $plugin_path . '/templates/single/single-portfolio.php';
                if (file_exists($template_path)) {
                    return $template_path;
                }
            }

            return $single;
        }

    }

    new Yolo_Framework_Shortcode_Portfolio();
}