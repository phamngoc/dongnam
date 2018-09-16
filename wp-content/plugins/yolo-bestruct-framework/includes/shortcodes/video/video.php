<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $number
 * @var $text
 */
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if ( ! class_exists('Yolo_Framework_Shortcode_Video') ) {
    class Yolo_Framework_Shortcode_Video {
        function __construct() {
            add_shortcode( 'yolo_video', array($this, 'yolo_video_player') );
        }

    function yolo_video_player($atts){
        $atts  = vc_map_get_attributes( 'yolo_video', $atts );
        extract(shortcode_atts(array(
            'yolo_video_link'       =>  '',
            'yolo_title'            => '',
            'style'                 => 'style_1',
            'yolo_height'           =>  '',
            'yolo_width'            =>  'default',
            'yolo_background_video' =>  '',
            'yolo_add_class'        => '',
            'yolo_description'      => '',
            'des_color'             => '',
            'title_color'           => '',
            'icon_color'            => '',

            ),$atts));
        ob_start();

        ?>
        <?php 
        // Get Video id
        $video_id = '';
        if(strpos( $yolo_video_link, 'youtube.com' )){
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $yolo_video_link, $matches);
            $video_id = $matches[1];
        }else{
            preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/", $yolo_video_link, $matches);
            $video_id = $matches[5];
        }
        $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
        $id = uniqid();
            ?>
        <div id="yolo-<?php echo esc_attr($id)?>" style="height: <?php echo esc_attr( $yolo_height ); ?>px; background-image: url('<?php echo esc_url(wp_get_attachment_url( $yolo_background_video ));?>'); background-size: cover;" class="yolo-video-player <?php echo esc_attr( $style ); ?> <?php echo esc_attr( $yolo_add_class ); ?>">
            <?php 
                include_once $plugin_path . '/templates/'.$style.'.php';
            ?>
            <div class="iframe-video-player">
                <p class="video-close">X</p>
            </div>
        </div>
        <?php
        return ob_get_clean();
        }
    }
    new Yolo_Framework_Shortcode_Video();
}
?>