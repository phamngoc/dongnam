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

if ( ! class_exists('Yolo_Framework_Shortcode_Process') ) {
    class Yolo_Framework_Shortcode_Process {
        function __construct() {
            add_shortcode( 'yolo_our_process', array($this, 'yolo_our_process_shortcode') );
        }

        function yolo_our_process_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'yolo_our_process', $atts );
            $our_process = $layout_type = $el_class = $yolo_animation = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'our_process'    => '',
                'layout_type'    => 'style_1',
                'el_class'       => '', 
                'css_animation'  => '',
                'number_step'    => 'step_3',
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
                default:
                    $template_path = $plugin_path . '/templates/style_1.php';
            }

            ?>
            <?php if( $our_process != '' ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if($styles_animation):?>style= "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
            <?php else : ?>
                <div class="our-process-not-select"><?php echo esc_html__( 'Please select Process', 'yolo-bestruct' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }
    }

    new Yolo_Framework_Shortcode_Process();
}
?>