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

	global $yolo_header_customize_current,$yolo_bestruct_options;
	$prefix = 'yolo_';

	$data_search_type = 'standard';
	if (isset($yolo_bestruct_options['search_box_type']) && ($yolo_bestruct_options['search_box_type'] == 'ajax')) {
		$data_search_type = 'ajax';
	}
	$search_box_type = 'standard';
	$search_box_submit = 'submit';
	if (isset($yolo_bestruct_options['search_box_type'])) {
		$search_box_type = $yolo_bestruct_options['search_box_type'];
	}
	if ($search_box_type == 'ajax') {
		$search_box_submit = 'button';
	}

	$search_button_wrapper_class = array(
		'search-button-wrapper',
		'header-customize-item',
		'style-default'
	);
	wp_enqueue_script('dialogFx');
?>
<div class="<?php echo join(' ', $search_button_wrapper_class) ?>">
	<a class="icon-search-menu" href="#" data-search-type="<?php echo esc_attr($data_search_type) ?>"><i class="wicon fa fa-search"></i></a>
</div>