<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    25/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

$yolo_header_layout = yolo_get_header_layout();
global $yolo_bestruct_options;
$prefix = 'yolo_';
$mobile_header_search_box = $yolo_bestruct_options['mobile_header_search_box'];
$search_box_type = $yolo_bestruct_options['search_box_type'];
// SHOW HEADER
$header_show_hide = '';
if (!is_search() && !is_404()) {
	$header_show_hide = get_post_meta(get_the_ID(), $prefix . 'header_show_hide',true); // From metaboxes
}
if (($header_show_hide == '')) {
	$header_show_hide = '1';
}
?>
<?php if (($header_show_hide == '1')): ?>
	<?php yolo_get_template('header/header-mobile-template' ); ?>
	<?php yolo_get_template('header/' . $yolo_header_layout ); ?> <!-- From theme/header.php -->
	<?php if ( isset($search_box_type) || ($mobile_header_search_box == '1') ) : ?>
		<?php yolo_get_template('header/search','popup'); ?>
	<?php endif; ?>
<?php endif; ?>