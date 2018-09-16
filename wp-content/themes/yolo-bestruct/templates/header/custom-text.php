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

global $yolo_header_customize_current;
global $yolo_bestruct_options;
$yolo_header_layout    = yolo_get_header_layout();
$prefix = 'yolo_';
$header_customize_text = '';
switch ($yolo_header_customize_current) {
	case 'nav':
		if ('header-1' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_1_customize_nav_text'];
        }
        if ('header-2' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_2_customize_nav_text'];
        }
        if ('header-3' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_3_customize_nav_text'];
        }
        if ('header-4' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_4_customize_nav_text'];
        }
        if ('header-5' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_5_customize_nav_text'];
        }
        if ('header-6' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_6_customize_nav_text'];
        }
        if ('header-sidebar' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['headersidebar_customize_nav_text'];
        }

		break;
	case 'left':
		if ('header-2' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_2_customize_left_text'];
        }
		break;
	case 'right':
        if ('header-1' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_1_customize_right_text'];
        }
        if ('header-2' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_2_customize_right_text'];
        }
        if ('header-3' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_3_customize_right_text'];
        }
        if ('header-4' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_4_customize_right_text'];
        }
        if ('header-5' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['header_5_customize_right_text'];
        }
        if ('header-sidebar' == $yolo_header_layout) {
            $header_customize_text = $yolo_bestruct_options['headersidebar_customize_right_text'];
        }
        break;
}
?>
<?php if (!empty($header_customize_text)) : ?>
	<div class="custom-text-wrapper header-customize-item">
		<?php echo wp_kses_post($header_customize_text); ?>
	</div>
<?php endif;?>