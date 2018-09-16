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

if ( ! class_exists('Yolo_Framework_Shortcode_Testimonial') ) {
    class Yolo_Framework_Shortcode_Testimonial {
        function __construct() {
            add_shortcode('yolo_testimonial', array($this, 'yolo_testimonial_shortcode' ));
        }

        function yolo_testimonial_front_scripts() {
            wp_enqueue_style('owl-carousel');
            wp_enqueue_script('owl-carousel');
        }

        function yolo_testimonial_shortcode($atts) {
            $this->yolo_testimonial_front_scripts();
            $layout_type = $data_source = $category = $testimonial_ids = $order  = $autoplay  = $slide_duration = $el_class = $yolo_animation = $css_animation = $duration = $delay = $styles_animation = $rtl = '';
            extract(shortcode_atts(array(
                'layout_type'     => 'carousel',
                'data_source'     => '',
                'category'        => '',
                'testimonial_ids' => '',
                'order'           => 'DESC',
                'autoplay'        => 'true',
                'slide_duration'  => '1000',
                'el_class'        => '',
                'css_animation'   => '',
                'duration'        => '',
                'delay'           => ''
            ), $atts));

            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_BestructFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_BestructFramework_Shortcodes::yolo_get_style_animation($duration, $delay);
            if(is_rtl()) $rtl = 'true';
            $args = array(
                'orderby'        => 'post__in',
                'post__in'       => explode(",", $testimonial_ids),
                'posts_per_page' => -1, // Unlimited testimonial
                'post_type'      => 'yolo_testimonial',
                'post_status'    => 'publish');

            if ($data_source == '') {
                $args = array(
                    'posts_per_page'       => -1, // Unlimited testimonial
                    'orderby'              => 'post_date',
                    'order'                => $order,
                    'post_type'            => 'yolo_testimonial',
                    'post_status'          => 'publish');
                if(!empty($category)){
                    $args['tax_query'] = array(
                      'relation' => 'AND',
                      array(
                        'taxonomy' => 'testimonial_category',
                        'field'    => 'slug',
                        'terms'    => explode(',', $category),
                      ),
                    );
                }
            }
            ob_start();

            $testimonials = new WP_Query($args);

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            switch ($layout_type) {
                case 'carousel':
                    $template_path = $plugin_path . '/templates/carousel.php';
                    break;
                case 'carousel_2':
                    $template_path = $plugin_path . '/templates/carousel_2.php';
                    break;
                case 'carousel_3':
                    $template_path = $plugin_path . '/templates/carousel_3.php';
                    break;
                case 'carousel_4':
                    $template_path = $plugin_path . '/templates/carousel_4.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/carousel.php';
            }
        ?>  
        <?php if( $testimonials->have_posts() ) : ?>
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

    new Yolo_Framework_Shortcode_Testimonial();
}