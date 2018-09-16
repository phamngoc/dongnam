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

if ( ! class_exists('Yolo_Framework_Shortcode_Teammember') ) {
    class Yolo_Framework_Shortcode_Teammember {
        function __construct() {
            add_shortcode('yolo_teammember', array($this, 'yolo_teammember_shortcode' ));
        }

        function yolo_teammember_shortcode($atts) {
            $layout_type = $data_source = $category = $member_ids = $member_per_slide = $order  = $autoplay  = $slide_duration = $el_class = $yolo_animation = $css_animation = $duration = $delay = $styles_animation = $rtl = '';
            extract(shortcode_atts(array(
                'layout_type'      => 'style_1',
                'data_source'      => '',
                'category'         => '',
                'member_ids'       => '',
                'member_per_slide' => '3',
                'order'            => 'DESC',
                'autoplay'         => 'true',
                'slide_duration'   => '1000',
                'el_class'         => '',
                'css_animation'    => '',
                'duration'         => '',
                'style'            => 'slider',
                'delay'            => '',
                'bg_img'           => 'white',
                'columns'          => 'column_2',
            ), $atts));

            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_BestructFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_BestructFramework_Shortcodes::yolo_get_style_animation($duration, $delay);
            if(is_rtl()) $rtl = 'true';
            if($style == 'slider'){
                wp_enqueue_style('owl-carousel');
                wp_enqueue_script('owl-carousel');
            }
            $args = array(
                'orderby'        => 'post__in',
                'post__in'       => explode(",", $member_ids),
                'posts_per_page' => -1, // Unlimited member
                'post_type'      => 'yolo_teammember',
                'post_status'    => 'publish');

            if ($data_source == '') {
                $args = array(
                    'posts_per_page' => -1, // Unlimited member
                    'orderby'        => 'post_date',
                    'order'          => $order,
                    'post_type'      => 'yolo_teammember',
                    'post_status'    => 'publish'
                );
                if(!empty($category)){
                    $args['tax_query'] = array(
                      'relation' => 'AND',
                      array(
                        'taxonomy' => 'team_category',
                        'field'    => 'slug',
                        'terms'    => explode(',', $category),
                      ),
                    );
                }
            }
            ob_start();

            $teammembers = new WP_Query($args);

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            switch ($layout_type) {
                case 'style_1':
                    $template_path = $plugin_path . '/templates/style_1.php';
                    break;
                case 'style_2':
                    $template_path = $plugin_path . '/templates/style_2.php';
                    break;
                case 'style_3':
                    $template_path = $plugin_path . '/templates/style_3.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/style_1.php';
            }
        ?>  
        <?php if( $teammembers->have_posts() ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if($styles_animation):?>style= "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>  
        <?php else : ?>
            <div class="item-not-found"><?php echo esc_html__( 'No item found', 'yolo-bestruct' ) ?></div>
        <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;
        }
    }

    new Yolo_Framework_Shortcode_Teammember();
}