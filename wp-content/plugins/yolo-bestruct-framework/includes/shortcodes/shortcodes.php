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

if (!class_exists('Yolo_BestructFramework_Shortcodes')) {
    class Yolo_BestructFramework_Shortcodes
    {
        private static $instance;

        public static function init() {
            if (!isset(self::$instance)) {
                self::$instance = new Yolo_BestructFramework_Shortcodes;
                add_action('init', array(self::$instance, 'includes'), 0);
                add_action('init', array(self::$instance, 'register_vc_map'), 15); // Need to change piority from 10 to 15 because can cause invalid taxonomy
            }
            return self::$instance;
        }
        public function includes() {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            if (!is_plugin_active('js_composer/js_composer.php')) {
                return;
            }
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/functions.php' ); // Include functions for fields type
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/countdown/countdown.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/blog/blog.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/banner/banner.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/banner-slider/banner-slider.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/clients/clients.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/icon-footer/icon-footer.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/icon-box/icon-box.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/gmaps/gmaps.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/recent-news/recent-news.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/recent-news-footer/recent-news-footer.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/widget/widget.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/counter/counter.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/video/video.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/our-process/our-process.php'); 
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/pricing/yolo-pricing.php'); 
            // Yolo Posttypes Shortcodes
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/posttypes/portfolio/portfolio.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/posttypes/testimonial/testimonial.php' );
            include_once( PLUGIN_YOLO_BESTRUCT_FRAMEWORK_DIR . 'includes/shortcodes/posttypes/teammember/teammember.php' );
        }

        public static function yolo_get_css_animation($css_animation) {
            $output = '';
            if ($css_animation != '') {
                wp_enqueue_script('waypoints');
                $output = ' wpb_animate_when_almost_visible yolo-css-animation ' . $css_animation;
            }
            return $output;
        }
        public static function yolo_get_style_animation($duration, $delay) {
            $styles = array();
            if ($duration != '0' && !empty($duration)) {
                $duration = (float)trim($duration, "\n\ts");
                $styles[] = "-webkit-animation-duration: {$duration}s";
                $styles[] = "-moz-animation-duration: {$duration}s";
                $styles[] = "-ms-animation-duration: {$duration}s";
                $styles[] = "-o-animation-duration: {$duration}s";
                $styles[] = "animation-duration: {$duration}s";
            }
            if ($delay != '0' && !empty($delay)) {
                $delay = (float)trim($delay, "\n\ts");
                $styles[] = "opacity: 0";
                $styles[] = "-webkit-animation-delay: {$delay}s";
                $styles[] = "-moz-animation-delay: {$delay}s";
                $styles[] = "-ms-animation-delay: {$delay}s";
                $styles[] = "-o-animation-delay: {$delay}s";
                $styles[] = "animation-delay: {$delay}s";
            }
            return implode(';', $styles);
        }

        public static function substr($str, $txt_len, $end_txt = '...') {
            if (empty($str)) return '';
            if (strlen($str) <= $txt_len) return $str;

            $i = $txt_len;
            while ($str[$i] != ' ') {
                $i--;
                if ($i == -1) break;
            }
            while ($str[$i] == ' ') {
                $i--;
                if ($i == -1) break;
            }

            return substr($str, 0, $i + 1) . $end_txt;
        }

        /*
        * SHORTCODES MAP TABLE
        * 2. 
        * 3. 
        * 4. 
        * 5. 
        * 6. 
        * 7. YOLO BLOG
        * 8. YOLO PORTFOLIO
        * 9. YOLO TESTIMONIAL
        * 10. YOLO RECENT NEWS
        * 11. YOLO COUNTDOWN
        * 12. YOLO BANNER
        * 13. YOLO CLIENTS
        * 14. YOLO ICON BOX
        * 15. YOLO TEAM MEMBER
        * 16. YOLO GOOGLE MAPS
        * 17. YOLO WIDGET
        * 18. YOLO COUNTER
        * 19. 
        * 20. 
        */
        public function register_vc_map() {
            if (function_exists('vc_map')) {

                // Declare new params for shortcodes
                $add_css_animation = array(
                    'type'       => 'dropdown',
                    'heading'    => esc_html__( 'CSS Animation', 'yolo-bestruct' ),
                    'param_name' => 'css_animation',
                    'value'      => array(
                        esc_html__( 'No', 'yolo-bestruct' )                   => '', 
                        esc_html__( 'Fade In', 'yolo-bestruct' )              => 'wpb_fadeIn', 
                        esc_html__( 'Fade Top to Bottom', 'yolo-bestruct' )   => 'wpb_fadeInDown', 
                        esc_html__( 'Fade Bottom to Top', 'yolo-bestruct' )   => 'wpb_fadeInUp', 
                        esc_html__( 'Fade Left to Right', 'yolo-bestruct' )   => 'wpb_fadeInLeft', 
                        esc_html__( 'Fade Right to Left', 'yolo-bestruct' )   => 'wpb_fadeInRight', 
                        esc_html__( 'Bounce In', 'yolo-bestruct' )            => 'wpb_bounceIn', 
                        esc_html__( 'Bounce Top to Bottom', 'yolo-bestruct' ) => 'wpb_bounceInDown', 
                        esc_html__( 'Bounce Bottom to Top', 'yolo-bestruct' ) => 'wpb_bounceInUp', 
                        esc_html__( 'Bounce Left to Right', 'yolo-bestruct' ) => 'wpb_bounceInLeft', 
                        esc_html__( 'Bounce Right to Left', 'yolo-bestruct' ) => 'wpb_bounceInRight', 
                        esc_html__( 'Zoom In', 'yolo-bestruct' )              => 'wpb_zoomIn', 
                        esc_html__( 'Flip Vertical', 'yolo-bestruct' )        => 'wpb_flipInX', 
                        esc_html__( 'Flip Horizontal', 'yolo-bestruct' )      => 'wpb_flipInY', 
                        esc_html__( 'Bounce', 'yolo-bestruct' )               => 'wpb_bounce', 
                        esc_html__( 'Flash', 'yolo-bestruct' )                => 'wpb_flash', 
                        esc_html__( 'Shake', 'yolo-bestruct' )                => 'wpb_shake', 
                        esc_html__( 'Pulse', 'yolo-bestruct' )                => 'wpb_pulse', 
                        esc_html__( 'Swing', 'yolo-bestruct' )                => 'wpb_swing', 
                        esc_html__( 'Rubber band', 'yolo-bestruct' )          => 'wpb_rubberBand', 
                        esc_html__( 'Wobble', 'yolo-bestruct' )               => 'wpb_wobble', 
                        esc_html__( 'Tada', 'yolo-bestruct' )                 => 'wpb_tada'),
                    'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'yolo-bestruct' ),
                    'group'       => esc_html__( 'Animation Settings', 'yolo-bestruct' )
                );

                $add_duration_animation = array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Animation Duration', 'yolo-bestruct' ),
                    'param_name'  => 'duration',
                    'value'       => '',
                    'description' => esc_html__( 'Duration in seconds. You can use decimal points in the value. Use this field to specify the amount of time the animation plays. <em>The default value depends on the animation, leave blank to use the default.</em>', 'yolo-bestruct' ),
                    'dependency'  => Array(
                        'element' => 'css_animation', 
                        'value'   => array(
                            'wpb_fadeIn', 
                            'wpb_fadeInDown', 
                            'wpb_fadeInUp', 
                            'wpb_fadeInLeft', 
                            'wpb_fadeInRight', 
                            'wpb_bounceIn', 
                            'wpb_bounceInDown', 
                            'wpb_bounceInUp', 
                            'wpb_bounceInLeft', 
                            'wpb_bounceInRight', 
                            'wpb_zoomIn', 
                            'wpb_flipInX', 
                            'wpb_flipInY', 
                            'wpb_bounce', 
                            'wpb_flash', 
                            'wpb_shake', 
                            'wpb_pulse', 
                            'wpb_swing', 
                            'wpb_rubberBand', 
                            'wpb_wobble', 
                            'wpb_tada'
                        )
                    ),
                    'group'      => esc_html__( 'Animation Settings', 'yolo-bestruct' )
                );

                $add_delay_animation = array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Animation Delay', 'yolo-bestruct' ),
                    'param_name'  => 'delay',
                    'value'       => '',
                    'description' => esc_html__( 'Delay in seconds. You can use decimal points in the value. Use this field to delay the animation for a few seconds, this is helpful if you want to chain different effects one after another above the fold.', 'yolo-bestruct' ),
                    'dependency'  => Array(
                        'element' => 'css_animation', 
                        'value' => array(
                            'wpb_fadeIn', 
                            'wpb_fadeInDown', 
                            'wpb_fadeInUp', 
                            'wpb_fadeInLeft', 
                            'wpb_fadeInRight', 
                            'wpb_bounceIn', 
                            'wpb_bounceInDown', 
                            'wpb_bounceInUp', 
                            'wpb_bounceInLeft', 
                            'wpb_bounceInRight', 
                            'wpb_zoomIn', 
                            'wpb_flipInX', 
                            'wpb_flipInY', 
                            'wpb_bounce', 
                            'wpb_flash', 
                            'wpb_shake', 
                            'wpb_pulse', 
                            'wpb_swing', 
                            'wpb_rubberBand', 
                            'wpb_wobble', 
                            'wpb_tada'
                        )
                    ),
                    'group'       => esc_html__( 'Animation Settings', 'yolo-bestruct' )
                );

                $add_el_class = array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Extra class name', 'yolo-bestruct' ),
                    'param_name'  => 'el_class',
                    'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yolo-bestruct' ),
                );

                $custom_colors = array(
                    esc_html__( 'Informational', 'yolo-bestruct' )         => 'info',
                    esc_html__( 'Warning', 'yolo-bestruct' )               => 'warning',
                    esc_html__( 'Success', 'yolo-bestruct' )               => 'success',
                    esc_html__( 'Error', 'yolo-bestruct' )                 => "danger",
                    esc_html__( 'Informational Classic', 'yolo-bestruct' ) => 'alert-info',
                    esc_html__( 'Warning Classic', 'yolo-bestruct' )       => 'alert-warning',
                    esc_html__( 'Success Classic', 'yolo-bestruct' )       => 'alert-success',
                    esc_html__( 'Error Classic', 'yolo-bestruct' )         => "alert-danger",
                );
                // REGISTER VC_MAP SHORTCODES
                /* B. OTHER SHORTCODE */
                /* 7. YOLO BLOG */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Blog', 'yolo-bestruct' ),
                        'base'        => 'yolo_blog',
                        'icon'        => 'fa fa-file-text',
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => esc_html__( 'Display post as list, grid', 'yolo-bestruct' ),
                        'params'      => array(
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Layout Style', 'yolo-bestruct' ),
                                'description'=> esc_html__('Choose layout style from drop down list styles.', 'yolo-bestruct'),
                                'param_name' => 'type',
                                'value'      => array(
                                    esc_html__( 'List (Larger Image)', 'yolo-bestruct' ) => 'large-image',
                                    esc_html__( 'List (Medium Image)', 'yolo-bestruct' ) => 'medium-image',
                                    esc_html__( 'Grid', 'yolo-bestruct' )                => 'grid',
                                    esc_html__( 'Masonry', 'yolo-bestruct' )             => 'masonry'
                                ),
                                'std'              => 'large-image',
                                // 'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                "type"       => "dropdown",
                                "heading"    => esc_html__( "Columns", 'yolo-bestruct' ),
                                "param_name" => "columns",
                                "value"      => array(
                                    esc_html__( '2 columns', 'yolo-bestruct' ) => 2,
                                    esc_html__( '3 columns', 'yolo-bestruct' ) => 3,
                                    esc_html__( '4 columns', 'yolo-bestruct' ) => 4,
                                ),
                                'dependency'  => array(
                                    'element' => 'type',
                                    'value'   => array('grid', 'masonry')
                                ),
                                'std'              => 2,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                "type"       => "checkbox",
                                "heading"    => esc_html__( "Padding", 'yolo-bestruct' ),
                                "param_name" => "yolo_padding",
                                'dependency'  => array(
                                    'element' => 'type',
                                    'value'   => array('grid', 'masonry')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'type'       => 'blog-cat',
                                'heading'    => esc_html__( 'Narrow Category', 'yolo-bestruct' ),
                                'description'=> esc_html__('Select categories to display post on your page.', 'yolo-bestruct'),
                                'param_name' => 'category'
                            ),
                            array(
                                "type"        => "textfield",
                                "heading"     => esc_html__( "Total items", 'yolo-bestruct' ),
                                'description' => esc_html__('Set max limit for items or enter -1 to display all (limited to 1000).', 'yolo-bestruct'),
                                "param_name"  => "max_items",
                                "value"       => -1,
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Display Type', 'yolo-bestruct' ),
                                'param_name' => 'paging_style',
                                'value'      => array(
                                    esc_html__( 'Show all', 'yolo-bestruct' )        => 'all',
                                    esc_html__( 'Default', 'yolo-bestruct' )         => 'default',
                                    esc_html__( 'Load More', 'yolo-bestruct' )       => 'load-more',
                                    esc_html__( 'Infinity Scroll', 'yolo-bestruct' ) => 'infinity-scroll',
                                ),
                                'std'              => 'all',
                                // 'edit_field_class' => 'vc_col-sm-6 vc_column',
                                'dependency'       => array(
                                    'element' => 'max_items',
                                    'value'   => array('-1')
                                ),
                            ),
                            array(
                                "type"        => "textfield",
                                "heading"     => esc_html__( "Items per page", 'yolo-bestruct' ),
                                'description' => esc_html__('Number of items to show per page.', 'yolo-bestruct'),
                                "param_name"  => "posts_per_page",
                                "value"       => get_option('posts_per_page'),
                                'dependency'  => array(
                                    'element' => 'paging_style',
                                    'value'   => array('default', 'load-more', 'infinity-scroll'),
                                ),
                                 'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Navigation Alignment', 'yolo-bestruct' ),
                                'param_name' => 'paging_align',
                                'value'      => array(
                                    esc_html__( 'Left', 'yolo-bestruct' )   => 'left',
                                    esc_html__( 'Center', 'yolo-bestruct' ) => 'center',
                                    esc_html__( 'Right', 'yolo-bestruct' )  => 'right',
                                ),
                                'std'        => 'right',
                                'dependency' => array(
                                    'element' => 'paging_style',
                                    'value'   => array('default'),
                                ),
                            ),
                            array(
                                "type"        => "textfield",
                                "heading"     => esc_html__( "Excerpt length", 'yolo-bestruct' ),
                                "param_name"  => "yolo_excerpt_length",
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'std'              => '20',
                            ),
                            // Data settings  
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__('Order by', 'yolo-bestruct'),
                                'param_name' => 'orderby',
                                'value'      => array(
                                    esc_html__( 'Date', 'yolo-bestruct' )                  => 'date',
                                    esc_html__( 'Order by post ID', 'yolo-bestruct' )      => 'ID',
                                    esc_html__( 'Author', 'yolo-bestruct' )                => 'author',
                                    esc_html__( 'Title', 'yolo-bestruct' )                 => 'title',
                                    esc_html__( 'Last modified date', 'yolo-bestruct' )    => 'modified',
                                    esc_html__( 'Post/page parent ID', 'yolo-bestruct' )   => 'parent',
                                    esc_html__( 'Number of comments', 'yolo-bestruct' )    => 'comment_count',
                                    esc_html__( 'Menu order/Page Order', 'yolo-bestruct' ) => 'menu_order',
                                    esc_html__( 'Meta value', 'yolo-bestruct' )            => 'meta_value',
                                    esc_html__( 'Meta value number', 'yolo-bestruct' )     => 'meta_value_num',
                                    esc_html__( 'Random order', 'yolo-bestruct' )          => 'rand',
                                ),
                                'description'        => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'yolo-bestruct' ),
                                'group'              => esc_html__( 'Data Settings', 'yolo-bestruct' ),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                            ),

                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Sort Order', 'yolo-bestruct' ),
                                'param_name' => 'order',
                                'group'      => esc_html__( 'Data Settings', 'yolo-bestruct' ),
                                'value'      => array(
                                    esc_html__( 'Descending', 'yolo-bestruct' ) => 'DESC',
                                    esc_html__( 'Ascending', 'yolo-bestruct' )  => 'ASC',
                                ),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'description'        => esc_html__( 'Select sorting order.', 'yolo-bestruct' ),
                            ),

                            array(
                                'type'               => 'textfield',
                                'heading'            => esc_html__( 'Meta key', 'yolo-bestruct' ),
                                'param_name'         => 'meta_key',
                                'description'        => esc_html__( 'Input meta key for grid ordering.', 'yolo-bestruct' ),
                                'group'              => esc_html__( 'Data Settings', 'yolo-bestruct' ),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'dependency'         => array(
                                    'element' => 'orderby',
                                    'value'   => array('meta_value', 'meta_value_num'),
                                ),
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                // POSTTYPES SHORTCODE
                /* 8. YOLO PORTFOLIO */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Portfolio', 'yolo-bestruct' ),
                        'base'        => 'yolo_portfolio',
                        'icon'        => 'fa fa-th-large',
                        'description' => esc_html__( 'Display Portfolio projects', 'yolo-bestruct' ),
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__('Thumbnail type','yolo-bestruct'),
                                'param_name'  => 'portfolio_thumbnail',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'Default', 'yolo-bestruct' )                                      => 'default', 
                                    esc_html__( 'Squared', 'yolo-bestruct' )                                      => 'squared', 
                                    esc_html__( 'Landscape', 'yolo-bestruct' )                                    => 'landscape', 
                                    esc_html__( 'Portrait', 'yolo-bestruct' )                                     => 'portrait', 
                                    esc_html__( 'Packery (Thumbnail size set in item setting)', 'yolo-bestruct' ) => 'packery',
                                    esc_html__( 'Masonry', 'yolo-bestruct' )                                      => 'masonry'
                                ),
                                'std'         => 'default'                      
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Portfolio Title', 'yolo-bestruct' ),
                                'param_name'  => 'portfolio_title',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'None', 'yolo-bestruct' )           => '',
                                    esc_html__( 'Show in Top', 'yolo-bestruct' )   => 'top',
                                    esc_html__( 'Show in Bottom', 'yolo-bestruct' ) => 'bottom'
                                ),
                                'std'         => '',
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Overlay Style', 'yolo-bestruct' ),
                                'param_name'  => 'overlay_style',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'Icon', 'yolo-bestruct' )                                         => 'icon',
                                    esc_html__( 'Icon and Title', 'yolo-bestruct' )                               => 'icon-title',
                                    esc_html__( 'Icon, Title and Category', 'yolo-bestruct' )                     => 'icon-title-category',
                                    esc_html__( 'Title and Category', 'yolo-bestruct' )                           => 'title-category',
                                    esc_html__( 'Title, Category and Link button', 'yolo-bestruct' )              => 'title-category-link',
                                ),
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Overlay Effect', 'yolo-bestruct' ),
                                'param_name'  => 'overlay_effect',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'Effect 1', 'yolo-bestruct' )      => 'effect_1',
                                    esc_html__( 'Effect 2', 'yolo-bestruct' )      => 'effect_2',
                                    esc_html__( 'Effect 3', 'yolo-bestruct' )      => 'effect_3',
                                    esc_html__( 'Effect 4', 'yolo-bestruct' )      => 'effect_4',
                                    esc_html__( 'Effect 5', 'yolo-bestruct' )      => 'effect_5',

                                ),
                            ),
                             array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Hover Dir Effect', 'yolo-bestruct' ),
                                'param_name'  => 'hover_dir',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'On', 'yolo-bestruct' )  => 'on',
                                    esc_html__( 'Off', 'yolo-bestruct' ) => 'off',
                                ),
                                'std'          => 'on'
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Columns', 'yolo-bestruct' ),
                                'param_name' => 'column',
                                'value'      => array(
                                    esc_html__( '2 columns', 'yolo-bestruct' ) => '2',
                                    esc_html__( '3 columns', 'yolo-bestruct' ) => '3',
                                    esc_html__( '4 columns', 'yolo-bestruct' ) => '4',
                                    esc_html__( '5 columns', 'yolo-bestruct' ) => '5',
                                    esc_html__( '6 columns', 'yolo-bestruct' ) => '6',
                                ),
                                'std'              => '4',
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Source', 'yolo-bestruct' ),
                                'param_name'  => 'data_source',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'From Category', 'yolo-bestruct' )      => '',
                                    esc_html__( 'From Portfolio IDs', 'yolo-bestruct' ) => 'list_id'
                                ),
                                'std' => ''
                            ),
                            array(
                                'type'        => 'portfolio-cat',
                                'heading'     => esc_html__( 'Portfolio Category', 'yolo-bestruct' ),
                                'param_name'  => 'category',
                                'admin_label' => true,
                                'dependency'  => array(
                                    'element' => 'data_source', 
                                    'value'   => array('')
                                ),
                            ),
                            array(
                                'type'       => 'portfolio-single',
                                'heading'    => esc_html__( 'Select Portfolio', 'yolo-bestruct' ),
                                'param_name' => 'portfolio_ids',
                                'dependency' => array(
                                    'element' => 'data_source', 
                                    'value'   => array('list_id')
                                )
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Show Filter', 'yolo-bestruct' ),
                                'param_name'  => 'show_filter',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'None', 'yolo-bestruct' )           => '',
                                    esc_html__( 'Show in left', 'yolo-bestruct' )   => 'left',
                                    esc_html__( 'Show in center', 'yolo-bestruct' ) => 'center',
                                    esc_html__( 'Show in right', 'yolo-bestruct' )  => 'right'
                                ),
                                'std'           => '',
                            ),
                            array(
                                'type'          => 'dropdown',
                                'heading'       => esc_html__( 'Filter By (Filter at front-end)', 'yolo-bestruct' ),
                                'param_name'    => 'filter_by',
                                'admin_label'   => true,
                                'value'         => array(
                                    esc_html__( 'Tag', 'yolo-bestruct' )      => 'tag',
                                    esc_html__( 'Category', 'yolo-bestruct' ) => 'category'
                                ),
                                'std'           => 'tag',
                                'dependency'    => array(
                                    'element'   => 'show_filter',
                                    'value'     => array('left','center','right')
                                    ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Filter Style', 'yolo-bestruct' ),
                                'param_name'  => 'filter_style',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                                'dependency'    => array(
                                    'element'   => 'show_filter',
                                    'value'     => array('left','center','right')
                                    ),
                                'value'       => array(
                                    esc_html__( 'Style 1', 'yolo-bestruct' )   => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-bestruct' )   => 'style_2',
                                    esc_html__( 'Style 3', 'yolo-bestruct' )   => 'style_3',
                                ),
                                'std'           => 'style_1',

                            ),
                            array(
                                'type'        => 'portfolio-tag',
                                'heading'     => esc_html__( 'Portfolio Tags', 'yolo-bestruct' ),
                                'param_name'  => 'portfolio_tag',
                                'admin_label' => true,
                                'dependency'    => array(
                                    'element'   => 'filter_by',
                                    'value'     => array('tag')
                                    ),
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Show Paging', 'yolo-bestruct' ),
                                'param_name' => 'show_pagging',
                                'value' => array(
                                    esc_html__( 'None', 'yolo-bestruct' )      => '', 
                                    esc_html__( 'Load more', 'yolo-bestruct' ) => '1'
                                ),
                                'std'              => '',
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'       => 'textfield',
                                'heading'    => esc_html__( 'Number of item (or number of item per page if choose show paging)', 'yolo-bestruct' ),
                                'param_name' => 'item',
                                'value'      => '4',
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Order Post Date By', 'yolo-bestruct' ),
                                'param_name' => 'order',
                                'value'      => array(
                                    esc_html__('Descending', 'yolo-bestruct') => 'DESC', 
                                    esc_html__('Ascending', 'yolo-bestruct')  => 'ASC'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Padding', 'yolo-bestruct' ),
                                'param_name' => 'padding',
                                'value'      => array(
                                    esc_html__( 'No padding', 'yolo-bestruct' ) => '', 
                                    esc_html__( '5 px', 'yolo-bestruct' )       => 'col-padding-5', 
                                    esc_html__( '10 px', 'yolo-bestruct' )      => 'col-padding-10', 
                                    esc_html__( '15 px', 'yolo-bestruct' )      => 'col-padding-15',
                                    esc_html__( '20 px', 'yolo-bestruct' )      => 'col-padding-20',
                                ),
                                'std' => '',
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 9. YOLO TESTIMONIAL */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Testimonial', 'yolo-bestruct' ),
                        'base'        => 'yolo_testimonial',
                        'icon'        => 'fa fa-comments',
                        'description' => '',
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Layout Style', 'yolo-bestruct' ),
                                'param_name' => 'layout_type',
                                'value'      => array(
                                    esc_html__( 'Carousel', 'yolo-bestruct' )   => 'carousel',
                                    esc_html__( 'Carousel 2', 'yolo-bestruct' ) => 'carousel_2',
                                    esc_html__( 'Carousel 3', 'yolo-bestruct' ) => 'carousel_3',
                                    esc_html__( 'Carousel 4', 'yolo-bestruct' ) => 'carousel_4',
                                   
                                ),
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Source', 'yolo-bestruct' ),
                                'param_name'  => 'data_source',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'From Category', 'yolo-bestruct' )        => '',
                                    esc_html__( 'From Testimonial IDs', 'yolo-bestruct' ) => 'list_id'
                                )
                            ),
                            array(
                                'type'        => 'testimonial-cat',
                                'heading'     => esc_html__( 'Testimonial Category', 'yolo-bestruct' ),
                                'param_name'  => 'category',
                                'admin_label' => true,
                                'dependency'  => array(
                                    'element' => 'data_source', 
                                    'value'   => array('')
                                ),
                            ),
                            array(
                                'type'       => 'testimonial-single',
                                'heading'    => esc_html__( 'Select Testimonial', 'yolo-bestruct' ),
                                'param_name' => 'testimonial_ids',
                                'dependency' => Array(
                                    'element' => 'data_source', 
                                    'value'   => array('list_id')
                                )
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Order Post Date By', 'yolo-bestruct' ),
                                'param_name' => 'order',
                                'value'      => array(
                                    esc_html__('Descending', 'yolo-bestruct') => 'DESC', 
                                    esc_html__('Ascending', 'yolo-bestruct')  => 'ASC'
                                )
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'AutoPlay', 'yolo-bestruct' ),
                                'param_name' => 'autoplay',
                                'value'      => array(
                                    esc_html__( 'Yes', 'yolo-bestruct') => 'true', 
                                    esc_html__( 'No', 'yolo-bestruct')  => 'false'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                            ),
                            array(
                                "type"             => "textfield",
                                "heading"          => esc_html__( "Slide Duration (ms)", 'yolo-bestruct' ),
                                "param_name"       => "slide_duration",
                                'std'             => '1000',
                                "admin_label"      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 10. YOLO RECENT NEWS */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Recent News', 'yolo-bestruct' ),
                        'base'        => 'yolo_recent_news',
                        'icon'        => 'fa fa-bookmark',
                        'description' => esc_html__( 'Display latest post or selected post', 'yolo-bestruct' ),
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Home V1', 'yolo-bestruct' )   => 'home_1',
                                    esc_html__( 'Home V2', 'yolo-bestruct' )   => 'home_2',
                                    esc_html__( 'Home V3', 'yolo-bestruct' )   => 'home_3',
                                    esc_html__( 'Home V4', 'yolo-bestruct' )   => 'home_4',
                                    esc_html__( 'Home V5', 'yolo-bestruct' )   => 'home_5',
                                    esc_html__( 'Home V6', 'yolo-bestruct' )   => 'home_6',
                                    esc_html__( 'Home V7', 'yolo-bestruct' )   => 'home_7'
                                )
                            ),
                            array(
                                'type'        => 'blog-cat',
                                'heading'     => esc_html__( 'Select Categories', 'yolo-bestruct' ),
                                'param_name'  => 'category',
                                'admin_label' => true
                            ),
                            array(
                                'param_name'  => 'columns', 
                                'heading'     => esc_html__( 'Number of Columns', 'yolo-bestruct' ), 
                                'type'        => 'dropdown', 
                                'admin_label' => true, 
                                'value'       => array(
                                    esc_html__( '2', 'yolo-bestruct' ) => '2',
                                    esc_html__( '3', 'yolo-bestruct' ) => '3', 
                                    esc_html__( '4', 'yolo-bestruct' ) => '4' 
                                ),
                                'dependency' => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_1', 'home_2', 'home_3', 'home_5','home_6','home_7' )
                                )
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'AutoPlay', 'yolo-bestruct' ),
                                'param_name' => 'autoplay',
                                'value'      => array(
                                    esc_html__( 'Yes', 'yolo-bestruct') => 'true', 
                                    esc_html__( 'No', 'yolo-bestruct')  => 'false'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'  => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_1', 'home_2', 'home_3', 'home_5','home_6','home_7' )
                                )
                            ),
                            array(
                                'type'             => 'textfield',
                                'heading'          => esc_html__( 'Slide Duration (ms)', 'yolo-bestruct' ),
                                'param_name'       => 'slide_duration',
                                'std'              => '1000',
                                'admin_label'      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'  => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_1', 'home_2', 'home_3', 'home_5','home_6','home_7' )
                                )
                            ),
                            array( 
                                'param_name'  => 'posts_per_page', 
                                'heading'     => esc_html__( 'Posts per page', 'yolo-bestruct' ), 
                                'type'        => 'textfield', 
                                'admin_label' => true,
                                'dependency'  => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_1', 'home_2', 'home_3', 'home_5','home_6','home_7' )
                                )
                            ),
                            array(
                                'param_name'  => 'excerpt_length',
                                'heading'     => esc_html__( 'Excerpt Length', 'yolo-bestruct' ),
                                'description' => esc_html__( 'Insert number of words to show in excerpt.', 'yolo-bestruct' ),
                                'type'        => 'textfield',
                                'value'       => '',
                                'admin_label' => true,
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 11. YOLO COUNTDOWN */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Countdown', 'yolo-bestruct' ),
                        'base'        => 'yolo_countdown',
                        'icon'        => 'fa fa-clock-o',
                        'description' => esc_html__( 'Display Countdown timer', 'yolo-bestruct' ),
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'param_name'  => 'datetime',
                                'type'        => 'yolo_datetime',
                                'heading'     => esc_html__( 'Select Datetime', 'yolo-bestruct' ),
                                'admin_label' => true,
                                'value'       => ''
                            ),
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Number', 'yolo-bestruct' )   => 'number',
                                    esc_html__( 'Circle', 'yolo-bestruct' )   => 'circle'
                                )
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 12. YOLO BANNER */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Banner', 'yolo-bestruct' ),
                        'base'        => 'yolo_banner',
                        'icon'        => 'fa fa-windows',
                        'description' => esc_html__( 'Display banner', 'yolo-bestruct' ),
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Layout Style', 'yolo-bestruct' ),
                                'param_name' => 'layout_type',
                                'value'      => array(
                                    esc_html__( 'Style 1', 'yolo-bestruct' )        => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-bestruct' )        => 'style_2',
                                    esc_html__( 'Style 3', 'yolo-bestruct' )        => 'style_3',
                                    esc_html__( 'Style 4', 'yolo-bestruct' )        => 'style_4',
                                    esc_html__( 'Style 5', 'yolo-bestruct' )        => 'style_5',
                                ),
                            ),
                            array(
                                'type'        => 'colorpicker',
                                'heading'     => esc_html__( 'Border Color', 'yolo-bestruct' ),
                                'param_name'  => 'border_color',
                                'description' => esc_html__( 'Select custom border color.', 'yolo-bestruct' ),
                                'dependency'  => array(
                                    'element' => 'layout_type',
                                    'value'   => 'style_1',
                                ),
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__( 'Title', 'yolo-bestruct' ),
                                'param_name'  => 'title',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'    => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'style_3')
                                )
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__( 'Button Text', 'yolo-bestruct' ),
                                'param_name'  => 'button_text',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'    => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'style_3' )
                                )
                            ),
                            array(
                                'type'        => 'vc_link',
                                'heading'     => esc_html__( 'Link', 'yolo-bestruct' ),
                                'param_name'  => 'link',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'type'        => 'attach_image',
                                'heading'     => esc_html__( 'Banner\'s Image', 'yolo-bestruct' ),
                                'param_name'  => 'image',
                                'admin_label' => true,
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 13. YOLO CLIENTS */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Clients', 'yolo-bestruct' ),
                        'base'        => 'yolo_clients',
                        'icon'        => 'fa fa-users',
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => esc_html__( 'Display client logos', 'yolo-bestruct' ),
                        'params'      => array(
                            array(
                                'type'        => 'param_group',
                                'heading'     => esc_html__( 'Clients', 'yolo-bestruct' ),
                                'param_name'  => 'clients',
                                'description' => esc_html__( 'Enter values for client - name, image and url.', 'yolo-bestruct' ),
                                'value'       => urlencode( json_encode( array(
                                    array(
                                        'name' => esc_html__( 'Themeforest', 'yolo-bestruct' ),
                                        'logo' => '',
                                        'url'  => '',
                                    ),
                                    array(
                                        'name'  => esc_html__( 'Codecanyon', 'yolo-bestruct' ),
                                        'value' => '',
                                        'url'   => '',
                                    ),
                                    array(
                                        'name'  => esc_html__( 'Photodune', 'yolo-bestruct' ),
                                        'value' => '',
                                        'url'   => '',
                                    ),
                                ) ) ),
                                'params' => array(
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Name', 'yolo-bestruct' ),
                                        'param_name'  => 'name',
                                        'description' => esc_html__( 'Enter name of client.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                    array(
                                        'type'        => 'attach_image',
                                        'heading'     => esc_html__( 'Image', 'yolo-bestruct' ),
                                        'param_name'  => 'logo',
                                        'description' => esc_html__( 'Please select client\' logo.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Url', 'yolo-bestruct' ),
                                        'param_name'  => 'url',
                                        'description' => esc_html__( 'Please insert client\' link.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                ),
                            ),
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Style 1', 'yolo-bestruct' )   => 'style_1',
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'param_name'  => 'style',
                                'heading'     => esc_html__( 'Choose style', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Slider', 'yolo-bestruct' )     => 'slider',
                                    esc_html__( 'Grid', 'yolo-bestruct' )       => 'grid',
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'param_name'  => 'columns',
                                'heading'     => esc_html__( 'Choose columns for Grid', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'dependency'    => array(
                                    'element'   => 'style',
                                    'value'     => array( 'grid')
                                ),
                                'value'       => array(
                                    esc_html__( 'Column 2', 'yolo-bestruct' )   => 'column_2',
                                    esc_html__( 'Column 3', 'yolo-bestruct' )   => 'column_3',
                                    esc_html__( 'Column 4', 'yolo-bestruct' )   => 'column_4',
                                    esc_html__( 'Column 5', 'yolo-bestruct' )   => 'column_5',
                                ),
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'AutoPlay', 'yolo-bestruct' ),
                                'param_name' => 'autoplay',
                                'dependency'    => array(
                                    'element'   => 'style',
                                    'value'     => array( 'slider')
                                ),
                                'value'      => array(
                                    esc_html__( 'Yes', 'yolo-bestruct') => 'true', 
                                    esc_html__( 'No', 'yolo-bestruct')  => 'false'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'type'             => 'textfield',
                                'heading'          => esc_html__( 'Slide Duration (ms)', 'yolo-bestruct' ),
                                'param_name'       => 'slide_duration',
                                'std'              => '1000',
                                'dependency'    => array(
                                    'element'   => 'style',
                                    'value'     => array( 'slider')
                                ),
                                'admin_label'      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array( 
                                'param_name'  => 'logo_per_slide', 
                                'heading'     => esc_html__( 'Logo per slide', 'yolo-bestruct' ), 
                                'type'        => 'textfield',
                                'value'       => '5',
                                'dependency'    => array(
                                    'element'   => 'style',
                                    'value'     => array( 'slider')
                                ),
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        ),
                    )
                );

                /* 14. YOLO ICON BOX */          
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Icon Box', 'yolo-bestruct' ),
                        'base'        => 'yolo_icon_box',
                        'icon'        => 'fa fa-info',
                        'description' => esc_html__( 'Display Icon box from libraries', 'yolo-bestruct' ),
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Layout Style', 'yolo-bestruct' ),
                                'param_name' => 'layout_type',
                                'value'      => array(
                                    esc_html__( 'Style 1', 'yolo-bestruct' ) => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-bestruct' ) => 'style_2',
                                    esc_html__( 'Style 3', 'yolo-bestruct' ) => 'style_3',
                                    esc_html__( 'Style 4', 'yolo-bestruct' ) => 'style_4',
                                    esc_html__( 'Style 5', 'yolo-bestruct' ) => 'style_5',
                                    esc_html__( 'Style 6', 'yolo-bestruct' ) => 'style_6',
                                    esc_html__( 'Style 7', 'yolo-bestruct' ) => 'style_7',
                                    esc_html__( 'Style 8', 'yolo-bestruct' ) => 'style_8',
                                    esc_html__( 'Style 9', 'yolo-bestruct' ) => 'style_9',
                                    esc_html__( 'Style 10', 'yolo-bestruct' ) => 'style_10',
                                    esc_html__( 'Style 11', 'yolo-bestruct' ) => 'style_11',
                                ),
                            ),
                            array(
                                'type'    => 'dropdown',
                                'heading' => esc_html__( 'Icon library', 'yolo-bestruct' ),
                                'value'   => array(
                                    esc_html__( 'Font Awesome', 'yolo-bestruct' )          => 'fontawesome',
                                    esc_html__( 'Open Iconic', 'yolo-bestruct' )           => 'openiconic',
                                    esc_html__( 'Typicons', 'yolo-bestruct' )              => 'typicons',
                                    esc_html__( 'Entypo', 'yolo-bestruct' )                => 'entypo',
                                    esc_html__( 'Linecons', 'yolo-bestruct' )              => 'linecons',
                                    esc_html__( 'Custom Image Icon', 'yolo-bestruct' )     => 'image_icon',
                                ),
                                'admin_label' => true,
                                'param_name'  => 'type',
                                'description' => esc_html__( 'Select icon library.', 'yolo-bestruct' ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-bestruct' ),
                                'param_name' => 'icon_fontawesome',
                                'value'      => 'fa fa-adjust', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false,
                                    // default true, display an "EMPTY" icon?
                                    'iconsPerPage' => 4000,
                                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'fontawesome',
                                ),
                                'description' => esc_html__( 'Select icon from library.', 'yolo-bestruct' ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-bestruct' ),
                                'param_name' => 'icon_openiconic',
                                'value'      => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                    'type'         => 'openiconic',
                                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'openiconic',
                                ),
                                'description' => esc_html__( 'Select icon from library.', 'yolo-bestruct' ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-bestruct' ),
                                'param_name' => 'icon_typicons',
                                'value'      => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                    'type'         => 'typicons',
                                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'typicons',
                                ),
                                'description' => esc_html__( 'Select icon from library.', 'yolo-bestruct' ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-bestruct' ),
                                'param_name' => 'icon_entypo',
                                'value'      => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                    'type'         => 'entypo',
                                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'entypo',
                                ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-bestruct' ),
                                'param_name' => 'icon_linecons',
                                'value'      => 'vc_li vc_li-heart', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                    'type'         => 'linecons',
                                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'linecons',
                                ),
                                'description' => esc_html__( 'Select icon from library.', 'yolo-bestruct' ),
                            ),
                            array(
                                'type'       => 'attach_image',
                                'heading'    => esc_html__( 'Select Image Icon', 'yolo-bestruct' ),
                                'param_name' => 'image',
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'image_icon',
                                ),
                                'description' => esc_html__( 'Select Image Icon.', 'yolo-bestruct' ),
                            ),
                            array(
                                'type'               => 'dropdown',
                                'heading'            => esc_html__( 'Icon color', 'yolo-bestruct' ),
                                'param_name'         => 'color',
                                'value'              => array_merge( getVcShared( 'colors' ), array( esc_html__( 'Custom color', 'yolo-bestruct' ) => 'custom' ) ),
                                'description'        => esc_html__( 'Select icon color.', 'yolo-bestruct' ),
                                'param_holder_class' => 'vc_colored-dropdown',
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => array('linecons','entypo','typicons','openiconic','fontawesome'),
                                ),
                            ),
                            array(
                                'type'        => 'colorpicker',
                                'heading'     => esc_html__( 'Custom color', 'yolo-bestruct' ),
                                'param_name'  => 'custom_color',
                                'description' => esc_html__( 'Select custom icon color.', 'yolo-bestruct' ),
                                'dependency'  => array(
                                    'element' => 'color',
                                    'value'   => 'custom',
                                ),
                            ),
                            array(
                                'type'       => 'attach_image',
                                'heading'    => esc_html__( 'Select Background Image Icon', 'yolo-bestruct' ),
                                'param_name' => 'bg_image',
                                'dependency' => array(
                                    'element' => 'layout_type',
                                    'value'   => array('style_8','style_9'),
                                ),
                                'description' => esc_html__( 'Select Image Icon.', 'yolo-bestruct' ),
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Remove line bottom Icon", 'yolo-bestruct' ),
                                "param_name"  => "line_bottom",
                                'dependency'  => array(
                                    'element' => 'layout_type',
                                    'value'   => 'style_6',
                                ),
                            ),
                            array(
                                'type'        => 'colorpicker',
                                'heading'     => esc_html__( 'Background Icon Box Color', 'yolo-bestruct' ),
                                'param_name'  => 'bg_color',
                                'description' => esc_html__( 'Select custom icon color.', 'yolo-bestruct' ),
                                'dependency'  => array(
                                    'element' => 'layout_type',
                                    'value'   => 'style_2',
                                ),
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__( 'Title', 'yolo-bestruct' ),
                                'param_name'  => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type'        => 'vc_link',
                                'heading'     => esc_html__( 'Link', 'yolo-bestruct' ),
                                'param_name'  => 'link',
                                'admin_label' => true
                            ),
                            array(
                                'type'        => 'textarea',
                                'heading'     => esc_html__( 'Description', 'yolo-bestruct' ),
                                'param_name'  => 'description',
                                'admin_label' => true,
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 15. YOLO TEAM MEMBER */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Team Member', 'yolo-bestruct' ),
                        'base'        => 'yolo_teammember',
                        'icon'        => 'fa fa-users',
                        'description' => esc_html__( 'Display our team member', 'yolo-bestruct' ),
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Source', 'yolo-bestruct' ),
                                'param_name'  => 'data_source',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'From Category', 'yolo-bestruct' )   => '',
                                    esc_html__( 'From Member IDs', 'yolo-bestruct' ) => 'list_id'
                                )
                            ),
                            array(
                                'type'        => 'team-cat',
                                'heading'     => esc_html__( 'Teammember Category', 'yolo-bestruct' ),
                                'param_name'  => 'category',
                                'admin_label' => true,
                                'dependency'  => Array(
                                    'element' => 'data_source', 
                                    'value'   => array('')
                                ),
                            ),
                            array(
                                'type'       => 'team-single',
                                'heading'    => esc_html__( 'Select Teammember', 'yolo-bestruct' ),
                                'param_name' => 'member_ids',
                                'dependency' => Array(
                                    'element' => 'data_source', 
                                    'value'   => array('list_id')
                                )
                            ),
                            array(
                                'type'             => 'dropdown',
                                'heading'          => esc_html__( 'Layout Style', 'yolo-bestruct' ),
                                'param_name'       => 'layout_type',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'value'            => array(
                                    esc_html__( 'Style 1', 'yolo-bestruct' )   => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-bestruct' )   => 'style_2',
                                    esc_html__( 'Style 3', 'yolo-bestruct' )   => 'style_3',
                                ),
                            ),
                            array(
                                'param_name'  => 'style',
                                'heading'     => esc_html__( 'Choose style', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Slider', 'yolo-bestruct' )   => 'slider',
                                    esc_html__( 'Grid', 'yolo-bestruct' )   => 'grid',
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'param_name'  => 'columns',
                                'heading'     => esc_html__( 'Choose columns for Grid', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'dependency'    => array(
                                    'element'   => 'style',
                                    'value'     => array( 'grid')
                                ),
                                'value'       => array(
                                    esc_html__( 'Column 2', 'yolo-bestruct' )   => 'column_2',
                                    esc_html__( 'Column 3', 'yolo-bestruct' )   => 'column_3',
                                    esc_html__( 'Column 4', 'yolo-bestruct' )   => 'column_4',
                                    esc_html__( 'Column 5', 'yolo-bestruct' )   => 'column_5',
                                ),
                            ),
                            array( 
                                'param_name'       => 'member_per_slide', 
                                'heading'          => esc_html__( 'Members per slide', 'yolo-bestruct' ), 
                                'type'             => 'textfield',
                                'value'            => '3',
                                'admin_label'      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'    => array(
                                    'element'   => 'style',
                                    'value'     => array( 'slider')
                                ),
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Order Post Date By', 'yolo-bestruct' ),
                                'param_name' => 'order',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'value'      => array(
                                    esc_html__('Descending', 'yolo-bestruct') => 'DESC', 
                                    esc_html__('Ascending', 'yolo-bestruct')  => 'ASC'
                                )
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Background Images', 'yolo-bestruct' ),
                                'param_name' => 'bg_img',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'value'      => array(
                                    esc_html__('White', 'yolo-bestruct') => 'white', 
                                    esc_html__('Gray', 'yolo-bestruct')  => 'gray'
                                ),
                                'dependency'  => array(
                                    'element' => 'layout_type',
                                    'value'   => 'style_1',
                                ),
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'AutoPlay', 'yolo-bestruct' ),
                                'param_name' => 'autoplay',
                                'value'      => array(
                                    esc_html__( 'Yes', 'yolo-bestruct') => 'true', 
                                    esc_html__( 'No', 'yolo-bestruct')  => 'false'
                                ),
                                'dependency'    => array(
                                    'element'   => 'style',
                                    'value'     => array( 'slider')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                            ),
                            array(
                                "type"             => "textfield",
                                "heading"          => esc_html__( "Slide Duration (ms)", 'yolo-bestruct' ),
                                "param_name"       => "slide_duration",
                                'std'             => '1000',
                                "admin_label"      => true,
                                'dependency'    => array(
                                    'element'   => 'style',
                                    'value'     => array( 'slider')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 16. YOLO GOOGLE MAPS */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Google Maps', 'yolo-bestruct' ),
                        'base'        => 'yolo_gmaps',
                        'icon'        => 'fa fa-map-marker',
                        'description' => esc_html__( 'Display Google Maps with information', 'yolo-bestruct' ),
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                "type"       => "dropdown",
                                "class"      => "",
                                "heading"    => esc_html__("Choose style layout",'yolo-bestruct'),
                                "param_name" => "layout_type",
                                "value"      => array(
                                    esc_html__( 'Show Map', 'yolo-bestruct' )      => 'show_map',
                                    esc_html__( 'Toggle Button', 'yolo-bestruct' ) => 'toggle_button'
                                )
                            ),
                            array(
                                "type"       => "dropdown",
                                "class"      => "",
                                "heading"    => esc_html__("Choose style map",'yolo-bestruct'),
                                "param_name" => "light_map",
                                "value"      => array(
                                    esc_html__( 'Basic', 'yolo-bestruct' )          => 'basic',
                                    esc_html__( 'Light green', 'yolo-bestruct' )    => 'light_green',
                                    esc_html__( 'Shades of Grey', 'yolo-bestruct' ) => 'shades_grey',
                                    esc_html__( 'Ultra Light', 'yolo-bestruct' )    => 'ultra_light',
                                )
                             ),
                            array(
                                "type"        => "textarea",
                                "class"       => "",
                                "heading"     => esc_html__( "Info window title", 'yolo-bestruct' ),
                                "param_name"  => "info_title",
                                "value"       => esc_html__( "My address", 'yolo-bestruct' ),
                                "description" => ""
                            ),
                            array(
                                "type"        => "attach_image",
                                "class"       => "",
                                "heading"     => esc_html__( "Info window image", 'yolo-bestruct' ),
                                "param_name"  => "info_image",
                                "value"       => esc_html__( "My address", 'yolo-bestruct' ),
                                "description" => ""
                            ),
                            array(
                                "type"        => "textfield",
                                "class"       => "",
                                "heading"     => esc_html__( "Map height", 'yolo-bestruct' ),
                                "param_name"  => "height",
                                "value"       => esc_html__( "400px", 'yolo-bestruct' ),
                                "description" => esc_html__( "Example: 500px", 'yolo-bestruct' )
                            ),
                            array(
                                "type"        => "textfield",
                                "class"       => "",
                                "heading"     => esc_html__( "Latitude",'yolo-bestruct' ),
                                "param_name"  => "lat",
                                "value"       => esc_html__( "40.843292",'yolo-bestruct' ),
                                "description" => esc_html__( "Get longtitude from here: https://www.google.com/maps",'yolo-bestruct' )
                            ),
                            array(
                                "type"        => "textfield",
                                "class"       => "",
                                "heading"     => esc_html__( "Longitude", 'yolo-bestruct' ),
                                "param_name"  => "lng",
                                "value"       => esc_html__( "-73.864512", 'yolo-bestruct' ),
                                "description" => esc_html__( "Get longtitude from here: https://www.google.com/maps", 'yolo-bestruct' )
                            ),
                            array(
                                "type"        => "textfield",
                                "class"       => "",
                                "heading"     => esc_html__( "Zoom", 'yolo-bestruct' ),
                                "param_name"  => "zoom",
                                "value"       => esc_html__( "12", 'yolo-bestruct' ),
                                "description" => esc_html__( "Example : 20 for a close view, 5 for a far view",'yolo-bestruct' )
                            ),
                            array(
                                'type'        => 'attach_image',
                                'heading'     => esc_html__( 'Image to replace marker', 'yolo-bestruct' ),
                                'param_name'  => 'image',
                                'value'       => '',
                                'description' => esc_html__( 'Select the image to replace the original map marker (optional).', 'yolo-bestruct' )
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );
               
                /* 17. YOLO WIDGET */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Widget', 'yolo-bestruct' ),
                        'base'        => 'yolo_widget',
                        'class'       => 'yolo_widget',
                        'icon'        => 'fa fa-align-justify',
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => esc_html__( 'Display widgets.', 'yolo-bestruct' ),
                        'params'      => array(
                            array(
                                'type'        => 'widgetised_sidebars',
                                'heading'     => esc_html__( 'Sidebar', 'yolo-bestruct' ),
                                'param_name'  => 'sidebar_id',
                                'description' => esc_html__( 'Select widget area to display.', 'yolo-bestruct' ),
                            ),

                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        ),
                    )
                );
                /* 18. YOLO COUNTER */
                vc_map(
                    array(
                        'name'        => esc_html__('Yolo Counter', 'yolo-bestruct'),
                        'base'        => 'yolo_counter',
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'icon'        => 'fa fa-tachometer',
                        'description' => esc_html__( 'Display Counter Statistical', 'yolo-bestruct' ),
                        'params'      =>  array(
                            array(
                                'param_name'    => 'layout_type',
                                'heading'       => esc_html__( 'Style', 'yolo-bestruct' ),
                                'description'   => 'Select style for display statistical.',
                                'type'          => 'dropdown',
                                'holder'        => 'div',
                                'value'         => array(
                                    esc_html__( 'Style 1', 'yolo-bestruct' ) =>  'style_1',
                                    esc_html__( 'Style 2', 'yolo-bestruct' ) =>  'style_2',
                                    esc_html__( 'Style 3', 'yolo-bestruct' ) =>  'style_3',
                                )
                            ),
                            array(
                                'type'       => 'attach_image',
                                'heading'    => esc_html__( 'Select Image Icon', 'yolo-bestruct' ),
                                'param_name' => 'image',
                                'description' => esc_html__( 'Select Image Icon.', 'yolo-bestruct' ),
                            ),
                            array(
                                'type'          =>  'textfield',
                                'heading'       =>  esc_html__( 'Title', 'yolo-bestruct' ),
                                'description'   =>  'Enter text for counter title',
                                'param_name'    =>  'title',
                                'value'         =>  ''
                            ),
                            array(
                                'type'          =>  'textfield',
                                'heading'       =>  esc_html__( 'Number', 'yolo-bestruct' ),
                                'description'   => 'Enter number of statistical. Example 1466.',
                                'param_name'    =>  'number',
                                'value'         =>  ''
                            ),
                            array(
                                'type'          =>  'textfield',
                                'heading'       =>  esc_html__( 'Sub Text', 'yolo-bestruct' ),
                                'description'   =>  esc_html__('Add text for number counter','yolo-bestruct'),
                                'param_name'    =>  'sub_text',
                                'value'         =>  ''
                            ),

                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );
                
                /* 19. YOLO SOCIAL */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Icon Footer', 'yolo-bestruct' ),
                        'base'        => 'yolo_icon_footer',
                        'icon'        => 'fa fa-globe',
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => esc_html__( 'Display Icon Footer', 'yolo-bestruct' ),
                        'params'      => array(
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Style 1', 'yolo-bestruct' )   => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-bestruct' )   => 'style_2',
                                    esc_html__( 'Style 3', 'yolo-bestruct' )   => 'style_3',
                                    esc_html__( 'Style 4', 'yolo-bestruct' )   => 'style_4',
                                ),
                            ),
                            array(
                                'type'             => 'colorpicker',
                                'heading'          => esc_html__( 'Icon color', 'yolo-bestruct' ),
                                'param_name'       => 'icon_color',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'       => Array(
                                    'element' => 'layout_type', 
                                    'value'   => array('style_1','style_2','style_3',)
                                )
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__( 'Icon size', 'yolo-bestruct' ),
                                'param_name'  => 'font_size',
                                'description' => esc_html__( 'Enter icon size (Example: 18px) of Social', 'yolo-bestruct' ),
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'       => Array(
                                    'element' => 'layout_type', 
                                    'value'   => array('style_1','style_2','style_3')
                                )
                            ),
                            array(
                                'type'             => 'colorpicker',
                                'heading'          => esc_html__( 'Title color', 'yolo-bestruct' ),
                                'param_name'       => 'title_color',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'       => Array(
                                    'element' => 'layout_type', 
                                    'value'   => array('style_2')
                                )
                            ),
                            array(
                                'param_name'  => 'icon_align', 
                                'heading'     => esc_html__( 'Icon Footer Alignment', 'yolo-bestruct' ), 
                                'type'        => 'dropdown', 
                                'admin_label' => true, 
                                'value'       => array(
                                    esc_html__( 'Left', 'yolo-bestruct' ) => 'left',
                                    esc_html__( 'Center', 'yolo-bestruct' ) => 'center', 
                                    esc_html__( 'Right', 'yolo-bestruct' ) => 'right' 
                                ),
                                'dependency' => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'style_4','style_3' )
                                )
                            ),
                            array(
                                'type'        => 'param_group',
                                'heading'     => esc_html__( 'Icon Footer', 'yolo-bestruct' ),
                                'param_name'  => 'icon_footer',
                                'description' => esc_html__( 'Enter values for Icon Footer - name, icon and url.', 'yolo-bestruct' ),
                                'value'       => urlencode( json_encode( array(
                                    array(
                                        'name' => esc_html__( 'Facebook', 'yolo-bestruct' ),
                                        'icon' => 'fa fa-facebook',
                                        'url'  => '#',
                                    ),
                                    array(
                                        'name'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                                        'icon' => 'fa fa-instagram',
                                        'url'   => '#',
                                    ),
                                    array(
                                        'name'  => esc_html__( 'Twitter', 'yolo-bestruct' ),
                                        'icon' => 'fa fa-twitter',
                                        'url'   => '#',
                                    ),
                                ) ) ),
                                'params' => array(
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Name', 'yolo-bestruct' ),
                                        'param_name'  => 'name',
                                        'description' => esc_html__( 'Enter name or title of Icon', 'yolo-bestruct' ),
                                        'admin_label' => true,

                                    ),
                                    array(
                                        'type'        => 'iconpicker',
                                        'heading'     => esc_html__( 'Icon', 'yolo-bestruct' ),
                                        'param_name'  => 'icon',
                                        'description' => esc_html__( 'Please select Footer\' Icon.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                        'value'      => 'fa ',

                                    ),
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Url', 'yolo-bestruct' ),
                                        'param_name'  => 'url',
                                        'description' => esc_html__( 'Please insert Icon\' link.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                ),
                            ),
                            
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        ),
                    )
                );
                
                /* 20. YOLO RECENT NEW FOOTER */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Recent News Footer', 'yolo-bestruct' ),
                        'base'        => 'yolo_recent_news_footer',
                        'icon'        => 'fa fa-bookmark',
                        'description' => esc_html__( 'Display latest post or selected post', 'yolo-bestruct' ),
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Footer V1', 'yolo-bestruct' )   => 'home_1',
                                    esc_html__( 'Footer V2', 'yolo-bestruct' )   => 'home_2',
                                )
                            ),
                             array(
                                'param_name'  => 'text_color',
                                'heading'     => esc_html__( 'Choose color for the text ', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'White', 'yolo-bestruct' )   => 'white',
                                    esc_html__( 'Dark', 'yolo-bestruct' )   => 'dark',
                                )
                            ),
                            array(
                                'type'        => 'blog-cat',
                                'heading'     => esc_html__( 'Select Categories', 'yolo-bestruct' ),
                                'param_name'  => 'category',
                                'admin_label' => true
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Show Author", 'yolo-bestruct' ),
                                "param_name"  => "hide_author",
                                'edit_field_class' => 'vc_col-sm-3 vc_column vc_column-with-padding',
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Show Date", 'yolo-bestruct' ),
                                "param_name"  => "hide_date",
                                'edit_field_class' => 'vc_col-sm-3 vc_column vc_column-with-padding',
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Show Comment", 'yolo-bestruct' ),
                                "param_name"  => "hide_comment",
                                'edit_field_class' => 'vc_col-sm-3 vc_column vc_column-with-padding',
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Show Excerpt", 'yolo-bestruct' ),
                                "param_name"  => "hide_excerpt",
                                'std'         => false,
                                'edit_field_class' => 'vc_col-sm-3 vc_column vc_column-with-padding',
                            ),
                            array( 
                                'param_name'  => 'posts_per_page', 
                                'heading'     => esc_html__( 'Posts per page', 'yolo-bestruct' ), 
                                'type'        => 'textfield', 
                                'admin_label' => true,
                                'dependency'  => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_1', 'home_2', )
                                )
                            ),
                            array(
                                'param_name'  => 'excerpt_length',
                                'heading'     => esc_html__( 'Excerpt Length', 'yolo-bestruct' ),
                                'description' => esc_html__( 'Insert number of words to show in excerpt.', 'yolo-bestruct' ),
                                'type'        => 'textfield',
                                'value'       => '',
                                'admin_label' => true,
                                'dependency'  => array(
                                    'element'   => 'hide_excerpt',
                                    'value'     => array('true'),
                                )
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );
                
                /* 21. YOLO VIDEO*/
                vc_map(array(
                    'name' => __('Yolo Video Player', 'yolo-bestruct'),
                    'base' => 'yolo_video',
                    'icon' => 'fa fa-play',
                    'category' => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => __('Display Video Player with Content', 'yolo-bestruct'),
                    'params' => array(
                        array(
                            'param_name'  => 'style',
                            'heading'     => __( 'Style', 'yolo-bestruct' ),
                            'description' => 'Select video content display style',
                            'type'        => 'dropdown',
                            'holder'      => 'div',
                            'value'       => array( 
                                __( 'Style 1', 'yolo-bestruct' )  => 'style_1',
                                __( 'Style 2', 'yolo-bestruct' )  => 'style_2',
                                __( 'Style 3', 'yolo-bestruct' )  => 'style_3',
                                )
                        ),
                        array(
                            'param_name'    => 'yolo_title',
                            'heading'       => __('Heading', 'yolo-bestruct'),
                            'type'          => 'textfield',
                            'description'   => __('Enter text for heading line.', 'yolo-bestruct'),
                            'holder'        => 'div',
                            'value'         => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                         array(
                            'param_name'    =>  'title_color',
                            'heading'       =>  __('Heading Color', 'yolo-bestruct'),
                            'description'   =>  'Select color heading.',
                            'type'          =>  'colorpicker',
                            'holder'        =>  'div',
                            'value'       => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'    => 'yolo_description',
                            'heading'       => __('Subheading', 'yolo-bestruct'),
                            'type'          => 'textfield',
                            'description'   => __('Enter text for subheading line.', 'yolo-bestruct'),
                            'holder'        => 'div',
                            'value'         => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'    =>  'des_color',
                            'heading'       =>  __('Subheading Color', 'yolo-bestruct'),
                            'description'   =>  'Select color subheading',
                            'type'          =>  'colorpicker',
                            'holder'        =>  'div',
                            'value'       => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'    =>  'icon_color',
                            'heading'       =>  __('Icon Color', 'yolo-bestruct'),
                            'description'   =>  'Select color video icon',
                            'type'          =>  'colorpicker',
                            'holder'        =>  'div',
                            'value'       => ''
                        ),
                        array(
                            'param_name'    => 'yolo_video_link',
                            'heading'       => __('Video URL', 'yolo-bestruct'),
                            'type'          => 'textfield',
                            'description'   => __('Enter Video or Youtube link. Example https://vimeo.com/15801179 or https://www.youtube.com/watch?v=n3MMERy4nWY', 'yolo-bestruct'),
                            'holder'        => 'div',
                            'value'         => ''
                        ),
                        array(
                            'param_name'    => 'yolo_height',
                            'heading'       => __('Height', 'yolo-bestruct'),
                            'type'          => 'textfield',
                            'description'   => __('Enter video height(px). Example: 700', 'yolo-bestruct'),
                            'holder'        => 'div',
                            'value'         => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'    => 'yolo_width',
                            'heading'       => __('Width', 'yolo-bestruct'),
                            'type'          => 'dropdown',
                            'description'   => 'Display video fullscreen or fit-screen',
                            'value'         => array(
                                __('Default', 'yolo-bestruct')     => 'default',
                                __('Full width', 'yolo-bestruct')  => 'full_width', 
                            ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'    => 'yolo_background_video',
                            'heading'       => __('Background image', 'yolo-bestruct'),
                            'type'          => 'attach_image',
                            'holder'        => 'div',
                            'description'   => 'Select image from media library.',
                            'value'         => '',
                        ),
                        array(
                            'param_name'    => 'yolo_add_class',
                            'heading'       => __('Extra class name', 'yolo-bestruct'),
                            'type'          => 'textfield',
                            'holder'        => 'div',
                            'description'   => 'Style particular content element differently - add a class name and refer to it in custom CSS.',
                            'value'         => '',
                        ),
                    )
                ));

                /* 21. YOLO VIDEO*/
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Banner Slider', 'yolo-bestruct' ),
                        'base'        => 'yolo_banner_slider',
                        'icon'        => 'fa fa-sliders',
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => esc_html__( 'Display Banner Slider', 'yolo-bestruct' ),
                        'params'      => array(
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Style 1', 'yolo-bestruct' )   => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-bestruct' )   => 'style_2',
                                ),
                            ),
                            array(
                                'type'        => 'param_group',
                                'heading'     => esc_html__( 'Banner Slider', 'yolo-bestruct' ),
                                'param_name'  => 'banner_slider',
                                'description' => esc_html__( 'Enter values for Banner Slider - name, image and url.', 'yolo-bestruct' ),
                                'value'       => urlencode( json_encode( array(
                                    array(
                                        'title'     => esc_html__( 'Title', 'yolo-bestruct' ),
                                        'sub'       => esc_html__( 'Description', 'yolo-bestruct' ),
                                        'bt_text'   => esc_html__( 'Button Text', 'yolo-bestruct' ),
                                        'img'       => '',
                                        'url'       => '',
                                    ),
                                    array(
                                        'title'     => esc_html__( 'Title', 'yolo-bestruct' ),
                                        'sub'       => esc_html__( 'Sub-Title', 'yolo-bestruct' ),
                                        'bt_text'   => esc_html__( 'Button Text', 'yolo-bestruct' ),
                                        'img'       => '',
                                        'url'       => '',
                                    ),
                                    array(
                                        'title'     => esc_html__( 'Title', 'yolo-bestruct' ),
                                        'sub'       => esc_html__( 'Sub-Title', 'yolo-bestruct' ),
                                        'bt_text'   => esc_html__( 'Button Text', 'yolo-bestruct' ),
                                        'img'       => '',
                                        'url'       => '',
                                    ),
                                ) ) ),
                                'params' => array(
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Title', 'yolo-bestruct' ),
                                        'param_name'  => 'title',
                                        'description' => esc_html__( 'Enter title of slider.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                    array(
                                        'type'        => 'textarea',
                                        'heading'     => esc_html__( 'Sub-Title', 'yolo-bestruct' ),
                                        'param_name'  => 'sub',
                                        'description' => esc_html__( 'Enter sub-title of slider.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                     array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Button Text', 'yolo-bestruct' ),
                                        'param_name'  => 'bt_text',
                                        'description' => esc_html__( 'Enter sub-title of slider.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                    array(
                                        'type'        => 'attach_image',
                                        'heading'     => esc_html__( 'Image', 'yolo-bestruct' ),
                                        'param_name'  => 'img',
                                        'description' => esc_html__( 'Please select slider\' image.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Url', 'yolo-bestruct' ),
                                        'param_name'  => 'url',
                                        'description' => esc_html__( 'Please insert slider\' link.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                ),
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'AutoPlay', 'yolo-bestruct' ),
                                'param_name' => 'autoplay',
                                'value'      => array(
                                    esc_html__( 'Yes', 'yolo-bestruct') => 'true', 
                                    esc_html__( 'No', 'yolo-bestruct')  => 'false'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'type'             => 'textfield',
                                'heading'          => esc_html__( 'Slider Duration (ms)', 'yolo-bestruct' ),
                                'param_name'       => 'slide_duration',
                                'std'              => '1000',
                                'admin_label'      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        ),
                    )
                );
                /* 22. YOLO OUR PROCESS */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Our Process', 'yolo-bestruct' ),
                        'base'        => 'yolo_our_process',
                        'icon'        => 'fa fa-th-list',
                        'category'    => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => esc_html__( 'Display Social Icon', 'yolo-bestruct' ),
                        'params'      => array(
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Style 1', 'yolo-bestruct' )   => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-bestruct' )   => 'style_2',
                                    esc_html__( 'Style 3', 'yolo-bestruct' )   => 'style_3',
                                    esc_html__( 'Style 4', 'yolo-bestruct' )   => 'style_4',
                                ),
                            ),
                            array(
                                'param_name'  => 'number_step',
                                'heading'     => esc_html__( 'Seclect number step', 'yolo-bestruct' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( '3 Step', 'yolo-bestruct' )   => 'step_3',
                                    esc_html__( '4 Step', 'yolo-bestruct' )   => 'step_4',
                                    esc_html__( '5 Step', 'yolo-bestruct' )   => 'step_5',
                                ),
                            ),
                            array(
                                'type'        => 'param_group',
                                'heading'     => esc_html__( 'Our process', 'yolo-bestruct' ),
                                'param_name'  => 'our_process',
                                'description' => esc_html__( 'Enter values for Our Process - name, icon and url.', 'yolo-bestruct' ),
                                'value'       => urlencode( json_encode( array(
                                    array(
                                        'name' => esc_html__( 'Step 1', 'yolo-bestruct' ),
                                        'icon' => 'fa fa-lightbulb-o',
                                        'url'  => '#',
                                    ),
                                    array(
                                        'name'  => esc_html__( 'Step 2', 'yolo-bestruct' ),
                                        'icon' => 'fa fa-diamond',
                                        'url'   => '#',
                                    ),
                                    array(
                                        'name'  => esc_html__( 'Step 3', 'yolo-bestruct' ),
                                        'icon' => 'fa fa-building',
                                        'url'   => '#',
                                    ),
                                ) ) ),
                                'params' => array(
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Name', 'yolo-bestruct' ),
                                        'param_name'  => 'name',
                                        'description' => esc_html__( 'Enter name or title of Icon', 'yolo-bestruct' ),
                                        'admin_label' => true,

                                    ),
                                    array(
                                        'type'        => 'iconpicker',
                                        'heading'     => esc_html__( 'Icon', 'yolo-bestruct' ),
                                        'param_name'  => 'icon',
                                        'description' => esc_html__( 'Please select Footer\' Icon.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                        'value'      => 'fa ',

                                    ),
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Url', 'yolo-bestruct' ),
                                        'param_name'  => 'url',
                                        'description' => esc_html__( 'Please insert Icon\' link.', 'yolo-bestruct' ),
                                        'admin_label' => true,
                                    ),
                                ),
                            ),
                            
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        ),
                    )
                );
                /* 23. YOLO CAPABILITIES */  
                vc_map( array(
                    'name' => esc_html__( 'Yolo Pricing', 'yolo-bestruct' ),
                    'base' => 'yolo_pricing',
                    'icon' => 'fa fa-server',
                    'category' => YOLO_BESTRUCT_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description'   => esc_html__( 'Display pricing', 'yolo-bestruct' ),
                    'params' => array(
                        array(
                            'param_name'    => 'select',
                            'heading'       => esc_html__( 'Style', 'yolo-bestruct' ),
                            'description'   => '',
                            'type'          => 'dropdown',
                            'holder'        => 'div',
                            'value'         => array(
                                esc_html__( 'Style 1', 'yolo-bestruct' )     =>  'yolo-pricing',
                                )
                            ),
                        array(
                            "type"       => "checkbox",
                            "heading"    => esc_html__( "Show Recommend", 'bestruct' ),
                            "param_name" => "show_recommend",
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Title', 'yolo-bestruct' ),
                            'param_name' => 'title',
                            'description' => esc_html__( 'Enter text used as title of plan (or pricing).', 'yolo-bestruct' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Price', 'yolo-bestruct' ),
                            'param_name' => 'price',
                            'description' => esc_html__( 'Enter values for pricing  - price', 'yolo-bestruct' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Sub Title', 'yolo-bestruct' ),
                            'param_name' => 'sub_title',
                            'description' => esc_html__( 'Enter sub title text used as title of plan (or pricing).', 'yolo-bestruct' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'param_group',
                            'heading' => esc_html__( 'Values', 'yolo-bestruct' ),
                            'param_name' => 'values',
                            'description' => esc_html__( 'Enter values for pricing  - price, title and etc...', 'yolo-bestruct' ),
                            'value' => urlencode( json_encode( array(
                                array(
                                    'label' => esc_html__( 'Integrated campaigns', 'yolo-bestruct' ),
                                    'active_content'  => esc_html__( 'Active Content', 'yolo-bestruct' ),
                                ),
                                array(
                                    'label' => esc_html__( 'Service design', 'yolo-bestruct' ),
                                    'active_content'  => esc_html__( 'Active Content', 'yolo-bestruct' ),
                                ),
                                array(
                                    'label' => esc_html__( 'In-store digital', 'yolo-bestruct' ),
                                    'active_content'  => esc_html__( 'Active Content', 'yolo-bestruct' ),
                                ),
                            ) ) ),
                            'params' => array(
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__( 'Label', 'yolo-bestruct' ),
                                    'param_name' => 'label',
                                    'description' => esc_html__( 'Enter text used as value of Label.', 'yolo-bestruct' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'type'        => 'dropdown',
                                    'heading'     => esc_html__( 'Choose Active / Disable Content', 'yolo-bestruct' ),
                                    'param_name'  => 'active_content',
                                    'description' => esc_html__( 'Please select', 'yolo-bestruct' ),
                                    'admin_label' => true,
                                    'value'         => array(
                                        esc_html__( 'Active', 'yolo-bestruct' )      =>  'yolo-active',
                                        esc_html__( 'Disable', 'yolo-bestruct' )     =>  'yolo-disable',
                                    )
                                ),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Button', 'yolo-bestruct' ),
                            'param_name' => 'textbt',
                            'description' => esc_html__( 'Text on the button.', 'yolo-bestruct' ),
                            'dependency'    => array(
                                'element'   => 'select',
                                'value'     => array( 'yolo-pricing','yolo-pricing2','yolo-pricing4','yolo-pricing5','yolo-pricing6' )
                                ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Button link', 'yolo-bestruct' ),
                            'param_name' => 'link',
                            'description' => esc_html__( 'Enter URL if you want this button to have a link.', 'yolo-bestruct' ),
                            'dependency'    => array(
                                'element'   => 'select',
                                'value'     => array( 'yolo-pricing','yolo-pricing2','yolo-pricing4','yolo-pricing5','yolo-pricing6' )
                                ),
                            'admin_label' => true,
                        ),
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation,
                        $add_el_class
                    )
                ) );
            }
        }
    }

    if ( ! function_exists('init_yolo_framework_shortcodes') ) {
        function init_yolo_framework_shortcodes() {
            return Yolo_BestructFramework_Shortcodes::init();
        }

        init_yolo_framework_shortcodes();
    }
}