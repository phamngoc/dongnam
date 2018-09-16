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

if ( ! class_exists('Yolo_Framework_Shortcode_Banner_Slider') ) {
    class Yolo_Framework_Shortcode_Banner_Slider {
        function __construct() {
            add_shortcode( 'yolo_banner_slider', array($this, 'yolo_banner_slider_shortcode') );
        }

        function yolo_banner_slider_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'yolo_banner_slider', $atts );
            $banner_slider = $autoplay = $slide_duration = $logo_per_slide = $layout_type = $el_class = $yolo_animation = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'banner_slider'        => '',
                'autoplay'             => 'true',
                'slide_duration'       => '1000',
                'layout_type'          => 'style_1',
                'el_class'             => '',
                'css_animation'        => '',
                'duration'             => '',
                'delay'                => '',
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
            <?php if( $banner_slider != '' ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if($styles_animation):?>style= "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
            <?php else : ?>
                <div class="banner_slider-not-select"><?php echo esc_html__( 'Please select banner slider!', 'yolo-bestruct' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }
    }

    new Yolo_Framework_Shortcode_Banner_Slider();
}
?>