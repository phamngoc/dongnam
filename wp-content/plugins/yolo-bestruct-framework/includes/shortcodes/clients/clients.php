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

if ( ! class_exists('Yolo_Framework_Shortcode_Clients') ) {
    class Yolo_Framework_Shortcode_Clients {
        function __construct() {
            add_shortcode( 'yolo_clients', array($this, 'yolo_clients_shortcode') );
        }

        function yolo_clients_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'yolo_clients', $atts );
            $clients = $autoplay = $slide_duration = $logo_per_slide = $layout_type = $el_class = $yolo_animation = $css_animation = $duration = $delay =  $rtl = '';
            extract(shortcode_atts(array(
                'clients'        => '',
                'autoplay'       => 'true',
                'slide_duration' => '1000',
                'logo_per_slide' => '5',
                'layout_type'    => 'style_1',
                'el_class'       => '',
                'css_animation'  => '',
                'duration'       => '',
                'style'          => 'slider',
                'columns'        => 'column_2',
                'delay'          => '',
            ), $atts)); 
            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_BestructFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_BestructFramework_Shortcodes::yolo_get_style_animation($duration, $delay);
            if(is_rtl()) $rtl = 'true';
            ob_start();
            wp_enqueue_style('owl-carousel');
            wp_enqueue_script('owl-carousel');
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $template_path = $plugin_path . '/templates/style_1.php';
            
            ?>
            <?php if( $clients != '' ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if($styles_animation):?>style= "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
            <?php else : ?>
                <div class="clients-not-select"><?php echo esc_html__( 'Please select clients!', 'yolo-bestruct' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }
    }

    new Yolo_Framework_Shortcode_Clients();
}
?>