<?php

/**
 * Shortcode attributes
 * @var $plans
 * @var $columns
 * @var $text
 * @var $sub_text
 * @var $class
 */

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Yolo_Framework_Shortcode_Capabilities') ) {
    class Yolo_Framework_Shortcode_Capabilities {
        function __construct() {
            add_shortcode('yolo_capabilities', array($this, 'yolo_capabilities_shortcode' ));
        }
		function yolo_capabilities_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'yolo_capabilities', $atts );
			$class = $el_class = $yolo_animation = $css_animation = $duration = $delay = $styles_animation = '';
			extract( shortcode_atts( array(
				'select'    => 'yolo-capabilities',
				'title'     => '',
				'link'      => '',
				'values'    => '',
				'el_class'  => '',
				'font_icon' => '',
				'textbt' 	=> '',
				'css_animation'     => '',
                'duration'          => '',
                'delay'             => '',
                'show_recommend' => '',
                'price' 	=> '',
                'sub_title'	=> '',
			), $atts ) );
			$yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_BestructFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_BestructFramework_Shortcodes::yolo_get_style_animation($duration, $delay);
            $class .= $yolo_animation;
            if(!empty($select)){
            	$class .= ' '.$select;
            }
            if( $select == 'yolo-capabilities'){ 
            	$class .= ' vc_row';
            }
			ob_start();
			if( isset( $image ) && !empty( $image ) ){
	            $bk_array = wp_get_attachment_image_src( $image,'full' );
	            $image = $bk_array[0];
	        }
			$values = (array) vc_param_group_parse_atts( $values );
	?>
		<div <?php if(!empty($styles_animation)):?>style= "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
			<div class="<?php echo esc_attr($class); ?> item <?php if($show_recommend==true) echo 'recommend'; ?>" >
	            <div  class="item-inner">
	              <div class="content-header">
	                <div class="content-header-inner">
	                	<?php if($show_recommend==true) :?>
	                	<div class="recommend_title">recommend</div>
	                	<?php endif; ?>
	                  	<div class="text"><?php echo esc_html($title); ?></div>
	                  	<div class="price"><span><?php echo esc_html($price); ?></span>Month</div>
	                  	<div class="sub_title"><?php echo esc_html($sub_title); ?></div>
	                </div>
	              </div>
	              <div class="content-main">
	                <div class="decs">
	                 <?php if( $values ) : ?>
						<ul>
						<?php foreach ($values as $value) : ?>
							<li>
								<i class="fa <?php if($value['active_content']=='yolo-active') echo('fa-check'); else echo('fa-close'); ?>"></i> <?php echo $value['label']; ?>
							</li>
						<?php endforeach; ?>
						</ul>
					<?php endif; ?>
	                </div>
	              </div>
	              <div class="content-footer"><a href="<?php echo esc_url($link); ?>" class="gr-btn gr-btn-style-1"><?php echo esc_html($textbt); ?></a></div>
	            </div>
	        </div>
	    </div>
		<?php
		return ob_get_clean();
		}
	}
	new Yolo_Framework_Shortcode_Capabilities;
}

?>