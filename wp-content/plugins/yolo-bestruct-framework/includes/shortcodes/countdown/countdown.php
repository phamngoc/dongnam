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

if ( ! class_exists('Yolo_Framework_Shortcode_Countdown') ) {
    class Yolo_Framework_Shortcode_Countdown {
        function __construct() {
            add_shortcode( 'yolo_countdown', array($this, 'yolo_countdown_shortcode') );
        }
        function yolo_countdown_shortcode($atts) {
            $layout_type =  $datetime = $el_class = $yolo_animation = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'layout_type'   => '',
                'datetime'      => '',
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

            switch ($layout_type) {
                case 'number':
                    $template_path = $plugin_path . '/templates/number.php';
                    break;
                case 'circle':
                    $template_path = $plugin_path . '/templates/circle.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/number.php';
            }

            ?>
            <?php if( $datetime != '' ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if($styles_animation):?>style= "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
            <?php else : ?>
                <div class="datetime-not-select"><?php echo esc_html__( 'Please select datetime!', 'yolo-bestruct' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }
    }

    new Yolo_Framework_Shortcode_Countdown();
}
?>