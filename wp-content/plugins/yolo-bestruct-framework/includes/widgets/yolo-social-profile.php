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

class Yolo_Social_Profile extends  Yolo_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-social-profile';
        $this->widget_description = esc_html__( "Get social icon from theme option to display.", 'yolo-bestruct' );
        $this->widget_id          = 'yolo-social-profile';
        $this->widget_name        = esc_html__( 'YOLO Social Profile', 'yolo-bestruct' );
        $this->settings           = array(
            'label' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Label','yolo-bestruct' )
            ),
	        'type'  => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Type', 'yolo-bestruct' ),
                'options' => array(
                    'social-icon-no-border' => esc_html__( 'No Border', 'yolo-bestruct' ),
                    'social-icon-bordered'  => esc_html__( 'Bordered', 'yolo-bestruct' )
                )
            ),
            'icons' => array(
				'type'    => 'multi-select',
				'label'   => esc_html__( 'Select social profiles', 'yolo-bestruct' ),
				'std'     => '',
				'options' => array(
					'twitter'    => esc_html__( 'Twitter', 'yolo-bestruct' ),
					'facebook'   => esc_html__( 'Facebook', 'yolo-bestruct' ),
					'dribbble'   => esc_html__( 'Dribbble', 'yolo-bestruct' ),
					'vimeo'      => esc_html__( 'Vimeo', 'yolo-bestruct' ),
					'tumblr'     => esc_html__( 'Tumblr', 'yolo-bestruct' ),
					'skype'      => esc_html__( 'Skype', 'yolo-bestruct' ),
					'linkedin'   => esc_html__( 'LinkedIn', 'yolo-bestruct' ),
					'googleplus' => esc_html__( 'Google+', 'yolo-bestruct' ),
					'flickr'     => esc_html__( 'Flickr', 'yolo-bestruct' ),
					'youtube'    => esc_html__( 'YouTube', 'yolo-bestruct' ),
					'pinterest'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
					'foursquare' => esc_html__( 'Foursquare', 'yolo-bestruct' ),
					'instagram'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
					'github'     => esc_html__( 'GitHub', 'yolo-bestruct' ),
					'xing'       => esc_html__( 'Xing', 'yolo-bestruct' ),
					'behance'    => esc_html__( 'Behance', 'yolo-bestruct' ),
					'deviantart' => esc_html__( 'Deviantart', 'yolo-bestruct' ),
					'soundcloud' => esc_html__( 'SoundCloud', 'yolo-bestruct' ),
					'yelp'       => esc_html__( 'Yelp', 'yolo-bestruct' ),
					'rss'        => esc_html__( 'RSS Feed', 'yolo-bestruct' ),
					'email'      => esc_html__( 'Email address', 'yolo-bestruct' ),
	            )
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
		$label        = empty( $instance['label'] ) ? '' : apply_filters( 'widget_label', $instance['label'] );
		$type         = empty( $instance['type'] ) ? '' : apply_filters( 'widget_type', $instance['type'] );
		$icons        = empty( $instance['icons'] ) ? '' : apply_filters( 'widget_icons', $instance['icons'] );
		$widget_id    = $args['widget_id'];
		$social_icons = yolo_get_social_icon($icons,'social-profile ' . $type );
	    echo wp_kses_post( $before_widget );
	    ?>
	    <?php if (!empty($label)) : ?>
		    <span><?php echo wp_kses_post($label); ?></span>
		<?php endif; ?>
		    <?php echo wp_kses_post( $social_icons ); ?>
	    <?php
	    echo wp_kses_post( $after_widget );
    }
}
if ( ! function_exists('yolo_register_social_profile') ) {
    function yolo_register_social_profile() {
        register_widget('Yolo_Social_Profile');
    }

    add_action('widgets_init', 'yolo_register_social_profile', 1);
}