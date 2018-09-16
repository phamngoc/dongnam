<?php
/**
 *
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 */
global $yolo_bestruct_options;
$prefix       = 'yolo_';
$post_id      = get_the_ID();
global $yolo_footer_id;
if ($yolo_footer_id == '' && isset($yolo_bestruct_options['footer'])) {
    $yolo_footer_id = $yolo_bestruct_options['footer'];
}
$content_post = get_post($yolo_footer_id);
$content      = $content_post->post_content;

$content      = str_replace(']]>', ']]&gt;', $content);
echo do_shortcode($content);
