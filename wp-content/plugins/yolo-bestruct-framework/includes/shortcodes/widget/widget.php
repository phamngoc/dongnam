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

if ( ! class_exists('Yolo_Framework_Shortcode_Widget') ) {
    class Yolo_Framework_Shortcode_Widget {
        function __construct() {
            add_shortcode( 'yolo_widget', array($this, 'yolo_widget_shortcode') );
        }
        function yolo_widget_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'yolo_widget', $atts );
            $sidebar_id = $el_class = $yolo_animation = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'sidebar_id'    => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));
	           
            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_BestructFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_BestructFramework_Shortcodes::yolo_get_style_animation($duration, $delay);

            ob_start();
            
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            $template_path = $plugin_path . '/templates/widget.php';

            ?>
            <?php if( $sidebar_id != '' ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if($styles_animation):?>style= "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
            <?php else : ?>
                <div class="widget-not-select"><?php echo esc_html__( 'Please select Widget!', 'yolo-bestruct' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }
    }

    new Yolo_Framework_Shortcode_Widget();
}
?>