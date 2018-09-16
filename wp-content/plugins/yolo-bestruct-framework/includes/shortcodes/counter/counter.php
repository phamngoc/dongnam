<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    21/4/2016
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Yolo_Framework_Shortcode_Counter') ) {
    class Yolo_Framework_Shortcode_Counter {
        function __construct() {
            add_shortcode('yolo_counter', array($this, 'yolo_counter_shortcode' ));
        }

        function yolo_counter_front_scripts() {
            wp_enqueue_script( 'jquery-appear' );
            wp_enqueue_script( 'jquery-counto' );
        }

        function yolo_counter_shortcode($atts) {
            $this->yolo_counter_front_scripts();
            $layout_type = $title = $number = $el_class = $yolo_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'   => 'style_1',
                'title'         => '',
                'number'        => '',
                'sub_text'      => '',
                'el_class'      => '',
                'css_animation' => '',
                'image'         => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));

            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_BestructFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_BestructFramework_Shortcodes::yolo_get_style_animation($duration, $delay);

            ob_start();

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
        <?php if( $number != '' ) : ?>
            <div class="counter-wrap-<?php echo $layout_type . esc_attr($yolo_animation); ?>" <?php if($styles_animation):?>style= "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
        <?php else : ?>
            <div class="item-not-found"><?php echo esc_html__( 'Please insert counter number', 'yolo-bestruct' ) ?></div>
        <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;
        }
    }

    new Yolo_Framework_Shortcode_Counter();
}