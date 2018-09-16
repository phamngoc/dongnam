<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

global $yolo_bestruct_options;
if( $yolo_bestruct_options['show_popup'] != false ) :
	$popup_width      = ( isset($yolo_bestruct_options['popup_width']) ) ? $yolo_bestruct_options['popup_width'] : 700;
	$popup_height     = ( isset($yolo_bestruct_options['popup_height']) ) ? $yolo_bestruct_options['popup_height'] : 350;
	$popup_effect     = ( isset($yolo_bestruct_options['popup_effect']) ) ? $yolo_bestruct_options['popup_effect'] : 'mfp-zoom-in';
	$popup_delay      = ( isset($yolo_bestruct_options['popup_delay']) ) ? $yolo_bestruct_options['popup_delay'] : '2000';
	$popup_background = ( isset($yolo_bestruct_options['popup_background']['url']) ) ? $yolo_bestruct_options['popup_background']['url'] : '';
	wp_enqueue_script('jquery-magnific-popup');
	wp_enqueue_script('jquery-cookie');
	?>
	<!-- Display popup window -->
	<!-- Change popup effect change mfp-zoon-in -->

	<div class="yolo_popup_link hide"><a class="yolo-popup open-click" href="#yolo-popup" data-effect="<?php echo esc_attr($popup_effect); ?>" data-delay="<?php echo esc_attr($popup_delay); ?>"><?php esc_html_e( 'Newsletter', 'yolo-bestruct' ); ?></a></div>
	<div id="yolo-popup" data-effect="mfp-zoom-in" style="width: <?php echo esc_attr($popup_width).'px' ?>; height: <?php echo esc_attr($popup_height).'px' ?>; background-color: #fff; background-image: url('<?php echo esc_url($popup_background); ?>');" 
	class="white-popup-block mfp-hide mfp-with-anim"> 
	    <?php echo (isset($yolo_bestruct_options['popup_content'])) ? do_shortcode($yolo_bestruct_options['popup_content']) : ''; ?>
	    <p class="checkbox-label">
	        <input type="checkbox" value="do-not-show" name="showagain" id="showagain" class="showagain" />
	        <label for="showagain"><?php esc_html_e( "Don't show this popup again", 'yolo-bestruct' ); ?></label>
	    </p>
	</div>
<?php endif; ?>